<?php

/**
 * Test class for Common_Utility.
 */
class utilityTest extends PHPUnit_Framework_TestCase {

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
    }

    /**
     * Test the IP validation.
     */
    public function test_validate_ip() {
        $fixtures = array(
            // Valid IP
              array('ip'=>'12.13.14.15', 'result'=>'12.13.14.15')

            // Invalid IP
            , array('ip'=>'256.256.256.256', 'result'=>FALSE)

            // Invalid IP
            , array('ip'=>'256.0.0.0', 'result'=>FALSE)

            // Invalid IP
            , array('ip'=>'255.256.0.0', 'result'=>FALSE)

            // Invalid IP
            , array('ip'=>'255.255.256.0', 'result'=>FALSE)

            // Invalid IP
            , array('ip'=>'255.24.245.256', 'result'=>FALSE)

            // Invalid IP
            , array('ip'=>'2563.0325.1340.01324', 'result'=>FALSE)

            // Invalid IP
            , array('ip'=>'25a.0.0.0', 'result'=>FALSE)

            // Private Range
            , array('ip'=>'10.0.0.0', 'result'=>FALSE)

            // Private Range
            , array('ip'=>'10.255.255.255', 'result'=>FALSE)

            // Private Range
            , array('ip'=>'192.168.0.0', 'result'=>FALSE)

            // Private Range
            , array('ip'=>'192.168.255.255', 'result'=>FALSE)

            // Private Range
            , array('ip'=>'172.16.0.0', 'result'=>FALSE)

            // Private Range
            , array('ip'=>'172.31.255.255', 'result'=>FALSE)

            // Reserved Range
            , array('ip'=>'0.0.0.0', 'result'=>FALSE)

            // Reserved Range
            , array('ip'=>'0.255.255.255', 'result'=>FALSE)

            // Reserved Range
            , array('ip'=>'169.254.0.0', 'result'=>FALSE)

            // Reserved Range
            , array('ip'=>'169.254.255.255', 'result'=>FALSE)

            // Reserved Range
            , array('ip'=>'192.0.2.0', 'result'=>FALSE)

            // Reserved Range
            , array('ip'=>'192.0.2.255', 'result'=>FALSE)

            // Reserved Range
            , array('ip'=>'224.0.0.0', 'result'=>FALSE)

            // Reserved Range
            , array('ip'=>'224.255.255.255', 'result'=>FALSE)

            // Invalid IP
            , array('ip'=>'255.255.255.0', 'result'=>FALSE)
        );

        foreach ($fixtures as $fixture) {
            $this->assertEquals($fixture['result'], Utility::validateIP($fixture['ip']));
        }
    }

    /**
     * Test the IP validation.
     */
    public function test_validate_email() {
        $fixtures = array(
            // Valid Email
              array('email'=>'niceandsimple@example.com', 'result'=>'niceandsimple@example.com')

            // Valid Email
            , array('email'=>'a.little.unusual@example.com', 'result'=>'a.little.unusual@example.com')

            // Valid Email
            , array('email'=>'a.little.more.unusual@dept.example.com', 'result'=>'a.little.more.unusual@dept.example.com')

            // Valid Email
            , array('email'=>'much."more\ unusual"@example.com', 'result'=>'much."more\ unusual"@example.com')

            // Valid Email
            , array('email'=>'very.unusual."@".unusual.com@example.com', 'result'=>'very.unusual."@".unusual.com@example.com')

            // Valid Email
            , array('email'=>'very."(),:;<>[]".VERY."very@\\ very".unusual@strange.example.com', 'result'=>'very."(),:;<>[]".VERY."very@\\ very".unusual@strange.example.com')

            // Invalid Email
            , array('email'=>'Abc.example.com', 'result'=>FALSE)

            // Invalid Email
            , array('email'=>'Abc.@example.com', 'result'=>FALSE)

            // Invalid Email
            , array('email'=>'Abc..123@example.com', 'result'=>FALSE)

            // Invalid Email
            , array('email'=>'A@b@c@example.com', 'result'=>FALSE)

            // Invalid Email
            , array('email'=>'a"b(c)d,e:f;g<h>i[j\k]l@example.com', 'result'=>FALSE)

            // Invalid Email
            , array('email'=>'just"not"right@example.com', 'result'=>FALSE)

            // Invalid Email
            , array('email'=>'this is"not\allowed@example.com', 'result'=>FALSE)

            // Invalid Email
            , array('email'=>'this\ still\"not\\allowed@example.com', 'result'=>FALSE)
        );

        foreach ($fixtures as $fixture) {
            $this->assertEquals($fixture['result'], Utility::validateEmail($fixture['email']));
        }
    }

    /**
     * Test the validateCIDR method
     */
    public function test_validateCIDR() {
        $fixtures = array(
            array('CIDR' => '', 'result' => FALSE)
            , array('CIDR' => '8.0.0.0/8', 'result' => TRUE)
            , array('CIDR' => '8.8.0.0/8', 'result' => FALSE)
            , array('CIDR' => '8.8.0.0/16', 'result' => TRUE)
            , array('CIDR' => '8.8.2.0/16', 'result' => FALSE)
            , array('CIDR' => '8.8.8.0/24', 'result' => TRUE)
            , array('CIDR' => '8.8.8.0/25', 'result' => TRUE)
            , array('CIDR' => '8.8.8.128/25', 'result' => TRUE)
            , array('CIDR' => '8.8.8.255/25', 'result' => FALSE)
            , array('CIDR' => '8.8.8.0/26', 'result' => TRUE)
            , array('CIDR' => '8.8.8.64/26', 'result' => TRUE)
            , array('CIDR' => '8.8.8.128/26', 'result' => TRUE)
            , array('CIDR' => '8.8.8.255/26', 'result' => FALSE)
            , array('CIDR' => '8.8.8.0/27', 'result' => TRUE)
            , array('CIDR' => '8.8.8.32/27', 'result' => TRUE)
            , array('CIDR' => '8.8.8.64/27', 'result' => TRUE)
            , array('CIDR' => '8.8.8.33/27', 'result' => FALSE)
            , array('CIDR' => '8.8.8.0/28', 'result' => TRUE)
            , array('CIDR' => '8.8.8.16/28', 'result' => TRUE)
            , array('CIDR' => '8.8.8.32/28', 'result' => TRUE)
            , array('CIDR' => '8.8.8.222/28', 'result' => FALSE)
            , array('CIDR' => '8.8.8.208/28', 'result' => TRUE)
            , array('CIDR' => '8.8.8.0/29', 'result' => TRUE)
            , array('CIDR' => '8.8.8.8/29', 'result' => TRUE)
            , array('CIDR' => '8.8.8.16/29', 'result' => TRUE)
            , array('CIDR' => '8.8.8.17/29', 'result' => FALSE)
            , array('CIDR' => '8.8.8.15/29', 'result' => FALSE)
            , array('CIDR' => '8.8.8.0/30', 'result' => TRUE)
            , array('CIDR' => '8.8.8.4/30', 'result' => TRUE)
            , array('CIDR' => '8.8.8.5/30', 'result' => FALSE)
            , array('CIDR' => '8.8.8.7/30', 'result' => FALSE)
            , array('CIDR' => '8.8.8.8/30', 'result' => TRUE)
            , array('CIDR' => '8.8.8.0/31', 'result' => TRUE)
            , array('CIDR' => '8.8.8.2/31', 'result' => TRUE)
            , array('CIDR' => '8.8.8.1/31', 'result' => FALSE)
            , array('CIDR' => '8.8.8.0/32', 'result' => TRUE)
            , array('CIDR' => '8.8.8.1/32', 'result' => TRUE)
            , array('CIDR' => '8.8.8.34/32', 'result' => TRUE)
            , array('CIDR' => '8.8.8.234/32', 'result' => TRUE)
            , array('CIDR' => '8.8.8.255/32', 'result' => TRUE)
            , array('CIDR' => '209.44.107.222/28', 'result' => FALSE)
            , array('CIDR' => '209.44.107.208/28', 'result' => TRUE)
            , array('CIDR' => '209.44.107.224/28', 'result' => TRUE)
        );

        foreach ($fixtures as $fixture) {
            $this->assertEquals($fixture['result'], Utility::validateCIDR($fixture['CIDR']));
        }
    }

    /**
     * Test the getCidrRange method
     */
    public function test_getCidrRange() {
        $fixtures = array(
              array('CIDR' => '8.8.8.8/32', 'result_low' =>'8.8.8.8', 'result_high' =>'8.8.8.8')
            , array('CIDR' => '8.8.8.0/31', 'result_low' =>'8.8.8.0', 'result_high' =>'8.8.8.1')
            , array('CIDR' => '8.8.8.0/30', 'result_low' =>'8.8.8.0', 'result_high' =>'8.8.8.3')
            , array('CIDR' => '8.8.8.0/29', 'result_low' =>'8.8.8.0', 'result_high' =>'8.8.8.7')
            , array('CIDR' => '8.8.8.0/28', 'result_low' =>'8.8.8.0', 'result_high' =>'8.8.8.15')
            , array('CIDR' => '8.8.8.0/27', 'result_low' =>'8.8.8.0', 'result_high' =>'8.8.8.31')
            , array('CIDR' => '8.8.8.0/26', 'result_low' =>'8.8.8.0', 'result_high' =>'8.8.8.63')
            , array('CIDR' => '8.8.8.0/25', 'result_low' =>'8.8.8.0', 'result_high' =>'8.8.8.127')
            , array('CIDR' => '8.8.8.0/24', 'result_low' =>'8.8.8.0', 'result_high' =>'8.8.8.255')
            , array('CIDR' => '8.8.0.0/16', 'result_low' =>'8.8.0.0', 'result_high' =>'8.8.255.255')
            , array('CIDR' => '8.0.0.0/8', 'result_low' =>'8.0.0.0', 'result_high' =>'8.255.255.255')
            , array('CIDR' => '209.44.107.222/28', 'result_low' =>'209.44.107.208', 'result_high' =>'209.44.107.223')
        );

        // test the int results
        foreach ($fixtures as $fixture) {
            list($low, $high) = Utility::getCidrRange($fixture['CIDR'], true);
            $this->assertEquals(ip2long($fixture['result_low']), $low);
            $this->assertEquals(ip2long($fixture['result_high']), $high);
        }

        // test the string results
        foreach ($fixtures as $fixture) {
            list($low, $high) = Utility::getCidrRange($fixture['CIDR'], false);
            $this->assertEquals($fixture['result_low'], $low);
            $this->assertEquals($fixture['result_high'], $high);
        }
    }

    /**
     * Test the isCIDR method
     */
    public function test_isCIDR() {
        $fixtures = array(
              array('CIDR' => '', 'result' => FALSE)
            , array('CIDR' => '1.2.3.4/32', 'result' => TRUE)
            , array('CIDR' => '1.2.3.4/24', 'result' => TRUE)
            , array('CIDR' => '1.2.3.4/16', 'result' => TRUE)
            , array('CIDR' => '1.2.3.4/8', 'result' => TRUE)
            , array('CIDR' => '1.2.3.4/4', 'result' => TRUE)
            , array('CIDR' => '1.2.3./32', 'result' => FALSE)
            , array('CIDR' => '1.2.3/32', 'result' => FALSE)
            , array('CIDR' => '1.2.3/24', 'result' => FALSE)
            , array('CIDR' => '1.2.3/16', 'result' => FALSE)
            , array('CIDR' => '1.2.3/8', 'result' => FALSE)
            , array('CIDR' => '1.2.3/4', 'result' => FALSE)
            , array('CIDR' => '1.2.3.4/33', 'result' => FALSE)
            , array('CIDR' => '1.2.3.4/45', 'result' => FALSE)
            , array('CIDR' => '127.0.0.1/32', 'result' => FALSE)

        );

        foreach ($fixtures as $fixture) {
            $this->assertEquals($fixture['result'], Utility::isCIDR($fixture['CIDR']));
        }
    }

    /**
     * Test the random string generation
     */
    public function test_RandomString() {
        // test various lengths and assert that the function returns the correct length
        $this->assertEquals(16, strlen(Utility::RandomString()));
        $this->assertEquals(10, strlen(Utility::RandomString(10)));
        $this->assertEquals(32, strlen(Utility::RandomString(32)));
        $this->assertEquals(64, strlen(Utility::RandomString(64)));
        $this->assertEquals(128, strlen(Utility::RandomString(128)));
        $this->assertEquals(256, strlen(Utility::RandomString(256)));
        $this->assertEquals(512, strlen(Utility::RandomString(512)));
        $this->assertEquals(1024, strlen(Utility::RandomString(1024)));

        // now test the actual return values are what we expect
        mt_srand(50);
        $this->assertEquals('fIO5PlY9m0', Utility::RandomString(10));

        mt_srand(100);
        $this->assertEquals('cpRZjd009zHLUxLc', Utility::RandomString());

        mt_srand(125);
        $this->assertEquals('e86xWKICI8NBeXZ9j5fHUxIu3h4CJqgK', Utility::RandomString(32));

        mt_srand(150);
        $this->assertEquals('FDtZ2iQoSidoDp4XE2w5HTn44DvBXhOtAaYpsxcodpc3iukf3T1zqOedxWXZVdeK', Utility::RandomString(64));

        mt_srand(200);
        $this->assertEquals('CfwJkujjOyA3Wb4tcoB71mAUESSlJH2LwNur3d6nL8gL2Pj6bjTga7nyYWGUCHvmqKUwBSM48jR5o4QfyxZepodt0dKrBkSgOtxmGp938rMSWafvx9TX8QWOdSXGSrHJ', Utility::RandomString(128));

    }
    
    /**
     * Test the Human Filesize method
     */
    public function test_humanFilesize() {
        $fixtures = array(
              array('bytes' => 1, 'decimals' => 0, 'result' => '1B')
            , array('bytes' => 10, 'decimals' => 0, 'result' => '10B')
            , array('bytes' => 100, 'decimals' => 0, 'result' => '100B')
            , array('bytes' => 1024, 'decimals' => 0, 'result' => '1K')
            , array('bytes' => 1024*2, 'decimals' => 0, 'result' => '2K')
            , array('bytes' => pow(1024,2), 'decimals' => 0, 'result' => '1M')
            , array('bytes' => pow(1024,3), 'decimals' => 0, 'result' => '1G')
            , array('bytes' => pow(1024,4), 'decimals' => 0, 'result' => '1T')
          //, array('bytes' => pow(1024,5), 'decimals' => 0, 'result' => '1P')
            , array('bytes' => 1, 'decimals' => 1, 'result' => '1.0B')
            , array('bytes' => 10, 'decimals' => 1, 'result' => '10.0B')
            , array('bytes' => 100, 'decimals' => 1, 'result' => '100.0B')
            , array('bytes' => 1024, 'decimals' => 1, 'result' => '1.0K')
            , array('bytes' => 1024*2, 'decimals' => 1, 'result' => '2.0K')
            , array('bytes' => pow(1024,2), 'decimals' => 1, 'result' => '1.0M')
            , array('bytes' => pow(1024,3), 'decimals' => 1, 'result' => '1.0G')
            , array('bytes' => pow(1024,4), 'decimals' => 1, 'result' => '1.0T')
          //, array('bytes' => pow(1024,5), 'decimals' => 1, 'result' => '1.0P')
            , array('bytes' => 1, 'decimals' => 2, 'result' => '1.00B')
            , array('bytes' => 10, 'decimals' => 2, 'result' => '10.00B')
            , array('bytes' => 100, 'decimals' => 2, 'result' => '100.00B')
            , array('bytes' => 1024, 'decimals' => 2, 'result' => '1.00K')
            , array('bytes' => 1024*2, 'decimals' => 2, 'result' => '2.00K')
            , array('bytes' => pow(1024,2), 'decimals' => 2, 'result' => '1.00M')
            , array('bytes' => pow(1024,3), 'decimals' => 2, 'result' => '1.00G')
            , array('bytes' => pow(1024,4), 'decimals' => 2, 'result' => '1.00T')
          //, array('bytes' => pow(1024,5), 'decimals' => 2, 'result' => '1.00P')
        );
        
        foreach ($fixtures as $fixture) {
            $this->assertEquals($fixture['result'], Utility::humanFilesize($fixture['bytes'], $fixture['decimals']));
        }
    }
}
