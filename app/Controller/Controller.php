<?php
namespace App\blog\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller{
    private $loader;
    protected $twig;

    public function __construct(){
        $this->loader = new FilesystemLoader(dirname(__DIR__).'\View\Templates');

        $this->twig = new Environment($this->loader);
    }
}