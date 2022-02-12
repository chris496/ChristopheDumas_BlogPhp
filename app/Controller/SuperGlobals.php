<?php
namespace App\blog\Controller;


class SuperGlobals
{
    private $_GET;

    public function __construct()
    {
        $this->_GET = filter_input_array(INPUT_GET);
    }

    public function getGET($key = null)
    {
        if(null !== $key)
        {
            return $this->_GET[$key] ?? null;
        }
        return $this->_GET;
    }
}