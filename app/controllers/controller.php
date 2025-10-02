<?php

require_once(__DIR__ . '/../models/library.php');

//Абстрактен клас за контролерите, който всеки контролер наследява
abstract class Controller {
    protected Library $library;

    //Всеки контролер има индекс метод, затова декларирам абстрактен метод в базовия клас
    abstract public function index();

    public function __construct() {
        $this->library = new Library();
    }
}