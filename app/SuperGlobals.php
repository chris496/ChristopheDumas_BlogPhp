<?php

namespace App\blog;

class SuperGlobals
{
    private $_GET;
    private $_POST;
    private $_FILES;
    private $_SESSION;
    private $_ENV;
    private $_SERVER;

    public function __construct()
    {
        $this->_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $this->_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $this->_FILES = (isset($_FILES)) ? $_FILES : null;
        $this->_SESSION = (isset($_SESSION)) ? $_SESSION : null;
        $this->_ENV = filter_var_array($_ENV, FILTER_SANITIZE_SPECIAL_CHARS);
        $this->_SERVER = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
    }

    public function getGET($key = null): ?array
    {
        if (null !== $key) {    
            return $this->_GET["$key"] ?? null;
        }
        return $this->_GET;
    }

    public function getPOST($key = null)
    {
        if (null !== $key) {
            return $this->_POST["$key"] ?? null;
        }
        return $this->_POST;
    }

    public function getFILES($key = null)
    {
        if (null !== $key) {
            return (isset($this->_FILES["$key"])) ? $this->_FILES["$key"] : null;
        }
        return $this->_FILES;
    }

    public function getSESSION($key = null)
    {
        if (null !== $key) {
            return (isset($this->_SESSION["$key"])) ? $this->_SESSION["$key"] : null;
        }
        return $this->_SESSION;
    }

    public function setSESSION($session)
    {
        return $_SESSION = $session;
    }

    public function getENV($key = null): ?array
    {
        if (null !== $key) {
            return (isset($this->_ENV["$key"])) ? $this->_ENV["$key"] : null;
        }
        return $this->_ENV;
    }

    public function getSERVER($key = null): ?array
    {
        if (null !== $key) {
            return (isset($this->_SERVER["$key"])) ? $this->_SERVER["$key"] : null;
        }
        return $this->_SERVER;
    }
}
