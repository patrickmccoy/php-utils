<?php

class Utility {
    
    /**
     * List of all known HTTP response codes - used to
     * translate numeric codes to messages.
     *
     * @var array
     */
    protected static $messages = array(
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',

        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',

        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',  // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        // 306 is deprecated but reserved
        307 => 'Temporary Redirect',

        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',

        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded'
    );

    /**
     * List of all acceptable HTTP response codes - used to
     * check the passed error code is handled by the class
     *
     * @var array
     */
    public static $codes = array(
        // 100
          100
        , 101

        // 200
        , 200
        , 201
        , 202
        , 203
        , 204
        , 205
        , 206

        // 300
        , 300
        , 301
        , 302
        , 303
        , 304
        , 305
        , 307

        // 400
        , 400
        , 401
        , 402
        , 403
        , 404
        , 405
        , 406
        , 410

        // 500
        , 500
        , 501
        , 502
        , 503
        , 509
    );

    /**
     * Validate an Email Address
     *
     * @param $email
     * @return mixed - $email if valid, FALSE if not
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Validate an IP Address and make sure that it is not in any private or reserved ranges
     *
     * @param $ip
     * @return mixed - $ip if valid, FALSE if not
     */
    public static function validateIP($ip) {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }

    /**
     * Validate an CIDR Range and make sure that it is not in any private or reserved ranges
     *
     * @param $cidr
     * @return boolean
     */
    public static function validateCIDR($cidr) {
        // check that we are actually dealing with a CIDR here
        if (!self::isCIDR($cidr)) {
            return false;
        }

        // Get the base and the bits from the CIDR
        list($base, $bits) = explode('/', $cidr);

        list($low, $high) = self::getCidrRange($cidr, true);

        // CIDR base must start at the low end of the range
        if (ip2long($base) != $low) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Break a CIDR into its high and low ranges
     *
     * @param $cidr string the cidr to get the low and high ranges for
     * @param $int bool return the results as integers (true) or strings (false)
     * @return array an array of ($low, $high)
     */
    public static function getCidrRange($cidr, $int = true) {
         // Get the base and the bits from the CIDR
        list($base, $bits) = explode('/', $cidr);

        // Now split it up into it's classes
        list($a, $b, $c, $d) = explode('.', $base);

        // Now do some bit shifting/switching to convert to ints
        $i    = ($a << 24) + ($b << 16) + ($c << 8) + $d;
        $mask = ($bits == 0) ? 0 : (~0 << (32 - $bits));

        // Here's our lowest int
        $low = $i & $mask;
        // Here's our highest int
        $high = $i | (~$mask & 0xFFFFFFFF);

        if ($int) {
            return array($low, $high);
        } else {
            return array(long2ip($low), long2ip($high));
        }

    }

    /**
     * Redirect the user's browser to another page
     *
     * @param $uri
     */
    public static function redirect($uri) {
        header('Location: ' . $uri);
        exit();
    }
    /**
     * utility version of this function from the util function include
     *
     * escapes html to make it safe for displaying.
     *
     * @param string $string
     * @param int $quote_style
     * @param string $charset
     * @return type
     */
    public static function escapeHtml($string, $quote_style = ENT_COMPAT, $charset = 'UTF-8') {

        $decoded_string = htmlentities($string, $quote_style, $charset, false);
        if (!$decoded_string) {
            //wasn't able to do decoding, probably due to an invalid multi-byte character
            //detect character encoding
            $encoding_list = array('UTF-8', 'ISO-8859-1');
            $encoding = mb_detect_encoding($string, $encoding_list);

            // try converting again using that encoding
            if (in_array($encoding, $encoding_list) && mb_check_encoding($string, $encoding)) {
                $decoded_string = htmlentities($string, $quote_style, $encoding, false);
            }

            if (!$decoded_string) {
                return $string;
            }
        }
        return $decoded_string;
    }

    // return boolean
    // check to see if string is a CIDR range
    public static function isCIDR($cidr) {

        $cidr_regex = '/^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5]))\/([1-9]|[1-2]\d|3[0-2])$/';
        $matches = array();
        if (preg_match($cidr_regex, $cidr, $matches)) {
            if ($matches[1] && $matches[6]) {
               return (bool) self::validateIP($matches[1]);
            }
        }

        return false;
    }

    /**
     * Send an HTTP Status Code Header
     *
     * @param $code - the http code you want to send
     * @return bool - if the status code was sent
     */
    public static function HTTPStatus($code = 200) {
        if (in_array($code, self::$codes)) {
            header($_SERVER['SERVER_PROTOCOL'] .' '. $code .' '. self::$messages[$code], true, $code);
            return true;
        }

        return false;
    }

    /**
     * Generate a random string of characters
     *
     * @param $length - the number of random characters to return
     * @return string - the random string of characters
     */
    public static function RandomString($length = 16) {
        $string = '';
        //create confirmation id, 16 chars long
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $len = strlen($chars) - 1;
        $salt = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $chars[mt_rand(0, $len)];
        }
        return $string;
    }

    /**
     * humanFilesize method
     *
     * Turn a byte filesize into a human readable fileszie
     *
     * @param int bytes the bytes we are formatting
     * @param int decimals the number of decimals we want to return
     * @return string
     */
    public static function humanFilesize($bytes, $decimals = 2) {  
        $sz = 'BKMGTP';  
        $factor = floor((strlen($bytes) - 1) / 3);  
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];  
    }
}
