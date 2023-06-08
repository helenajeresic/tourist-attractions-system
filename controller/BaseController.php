<?php

abstract class BaseController {
    protected $registry;
    function __construct($registry) {
        $this->registry = $registry;
    }

    abstract function index();
}
?>