<?php

namespace App\blog\Controller;

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
        $this->_GET = (isset($_GET)) ? $_GET : null;
        $this->_POST = (isset($_POST)) ? $_POST : null;
        $this->_FILES = (isset($_FILES)) ? $_FILES : null;
        $this->_SESSION = (isset($_SESSION)) ? $_SESSION : null;
        $this->_ENV = (isset($_ENV)) ? $_ENV : null;
        $this->_SERVER = (isset($_SERVER)) ? $_SERVER : null;
    }

    public function getGET($key = null): ?array
    {
        if (null !== $key) {
            return (isset($this->_GET["$key"])) ? $this->_GET["$key"] : null;
        }
        return $this->_GET;
    }

    public function getPOST($key = null)
    {
        if (null !== $key) {
            return (isset($this->_POST["$key"])) ? $this->_POST["$key"] : null;
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
