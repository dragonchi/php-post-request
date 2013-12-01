<?php
/**
 * PostRequest is a simple class to send HTTP POST request
 *
 * Rather than using a quite complicated PHP CURL extention, this class shows
 * how to combine file_get_contents() and stream_context_create() functions
 * to send HTTP POST request.
 *
 * @author Risan Bagja Pradana <risanbagja@yahoo.com>
 */
class PostRequest
{
    const E_DATA_NOT_ARRAY_ID = 1;
    const E_DATA_NOT_ARRAY_MSG = "'data' argument should be an array.";

    const E_DATA_ZERO_LENGTH_ARRAY_ID = 2;
    const E_DATA_ZERO_LENGTH_ARRAY_MSG = "'data' argument should at least contains one item.";

    /**
     * Array which contain data to be sent in POST request
     *
     * @var array
     * @access private
     */
    private $data;

    /**
     * Class constructor
     * 
     * @param mixed
     *
     * @return object An object of PostRequest class
     *
     * @access public
     */
    public function __construct($data = null)
    {
        /*
         * If the argument being passed is not null, assume that this is an 
         * array that contains the data to be sent in POST request
         */
        if (!is_null($data)) $this->setData($data);
    }

    /**
     * Set the data which would be sent along with POST request
     *
     * @param array $data An array which contain data to be sent along in POST
     *                    request. Note that the array should be associative 
     *                    array.
     *
     * @return void Simply set private $data class attribute
     *
     * @access public 
     */
    public function setData($data)
    {
        /* If data being passed is not an array, it will thrown an exception */
        if (!is_array($data)) {
            throw new Exception(self::E_DATA_NOT_ARRAY_MSG, 
                self::E_DATA_NOT_ARRAY_ID);
        }

        /* If data being passed is has no items, it will thrown an exception */
        if (count($data) <= 0) {
            throw new Exception(self::E_DATA_ZERO_LENGTH_ARRAY_MSG, 
                self::E_DATA_ZERO_LENGTH_ARRAY_ID);
        }

        $this->data = $data;
    }
}