<?php
/* Include PostRequest class */
require_once('../src/post_request.php');

/* Constants for defining test type */
define('VALID_TEST', true);
define('INVALID_TEST', false);

echo '<pre>';

/* 
 * VALID TEST-1
 * Create PostRequest object without any argument.
 * It should be valid since our constructor allow it
 */
try {
    $postRequest = new PostRequest();
    testMessage(1, VALID_TEST);
} catch(Exception $e) {
    testMessage(1, VALID_TEST, $e);
}

/* 
 * INVALID TEST-2
 * Call setData method with an invalid argument.
 * It should be thrown an exception since setData() method only accept
 * an array.
 */
try {
    $postRequest->setData('invalid');
    testMessage(2, INVALID_TEST);
} catch(Exception $e) {
    testMessage(2, INVALID_TEST, $e);
}

/*
 * INVALID TEST-3 
 * Call setData method with a zero length array as its argument.
 * It should be thrown an exception since setData() method only accept
 * a non zero length array.
 */
try {
    $postRequest->setData(array());
    testMessage(3, INVALID_TEST);
} catch(Exception $e) {
    testMessage(3, INVALID_TEST, $e);
}

/*
 * INVALID TEST-4 
 * Call setData method with a non-associative array as its argument.
 * It should be thrown an exception since setData() method only accept
 * an associative array.
 */
try {
    $postRequest->setData(array(1, 2, 3));
    testMessage(4, INVALID_TEST);
} catch(Exception $e) {
    testMessage(4, INVALID_TEST, $e);
}

/*
 * VALID TEST-5 
 * Call setData method with a valid associative array as its argument
 */
try {
    $postRequest->setData(array('username' => 'foobar'));
    testMessage(5, VALID_TEST);
} catch(Exception $e) {
    testMessage(5, VALID_TEST, $e);
}

/*
 * INVALID TEST-6
 * Call send() method without any data has been setup
 */
try {
    $postRequest = new PostRequest();
    $postRequest->send('server.php');
    testMessage(6, INVALID_TEST);
} catch(Exception $e) {
    testMessage(6, INVALID_TEST, $e);
}

/*
 * INVALID TEST-7
 * Call send() method with an invalid URL
 */
try {
    $postRequest = new PostRequest(array('name' => 'John Doe'));
    $postRequest->send('invalid');
    testMessage(7, INVALID_TEST);
} catch(Exception $e) {
    testMessage(7, INVALID_TEST, $e);
}

/*
 * INVALID TEST-8
 * Call send() method with valid URL but without protocolo defined
 */
try {
    $postRequest = new PostRequest(array('name' => 'John Doe'));
    $postRequest->send('risan.com');
    testMessage(8, INVALID_TEST);
} catch(Exception $e) {
    testMessage(8, INVALID_TEST, $e);
}

/*
 * INVALID TEST-9
 * Call send() method to unavailable endpoint
 */
try {
    $postRequest = new PostRequest(array('name' => 'John Doe'));
    $postRequest->send('http://nowhsdsdere.com');
    testMessage(9, INVALID_TEST);
} catch(Exception $e) {
    testMessage(9, INVALID_TEST, $e);
}

/*
 * VALID TEST-10
 * Call send() method to valid endpoint
 */
try {
    $postRequest = new PostRequest(array('name' => 'John Doe', 'message' => 'Hello world!'));
    $res = $postRequest->send('http://risanbagja.com/php-post-request/test/server.php');
    testMessage(10, VALID_TEST);
    print_r($res);
} catch(Exception $e) {
    testMessage(10, VALID_TEST, $e);
}

/** 
 * A handy function to display test result message
 *
 * @param int   $testNumber Current test number
 * @param bool  $testType   The type of the test. true for validity test, and 
 *                          false for invalidity test
 * @param mixed $e          Error object when test is failed
 *
 * @return void Simply echoing test result message
 */
function testMessage($testNumber, $testType, $e = null) {

    switch ($testType) {
        /* Validity test, test should not thrown an exception */
        case true:
            if (is_null($e)) $result = 'PASSED';
            else $result = 'NOT PASSED';
            break;
        /* Invalidity test, test should thrown an exception */
        case false:
            if (!is_null($e)) $result = 'PASSED';
            else $result = 'NOT PASSED';
            break;
    }

    /* Get error message contained by exception object */
    $errMsg = '';
    if (!is_null($e)) $errMsg = $e->getMessage();

    /* Ecoing test result */
    echo "TEST #{$testNumber} is {$result}. {$errMsg} \n";
}
