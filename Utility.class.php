<?php

class Utility {

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
