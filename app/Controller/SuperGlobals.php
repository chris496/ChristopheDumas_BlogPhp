<?php
namespace App\blog\Controller;


class SuperGlobals
{
    private $_GET;
    private $_POST;

    public function __construct()
    {
        $this->_GET = filter_input_array(INPUT_GET) ?? null;
        $this->_POST = filter_input_array(INPUT_POST) ?? null;
    }

    public function getGET($key = null)
    {
        if(null !== $key)
        {
            return $this->_GET[$key] ?? null;
        }
        return $this->_GET;
    }

    public function getPOST($key = null)
    {
        if(null !== $key)
        {
            return $this->_POST[$key] ?? null;
        }
        return $this->_POST;
    }
}