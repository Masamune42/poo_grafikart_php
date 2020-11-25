<?php
// Autolaoder
spl_autoload_register(function ($class) {
    include 'class/' . $class . '.php';
});


$zoe = new Zoe();
$zoe->energy = 20;
var_dump($zoe);
$zoe->recharger();
var_dump($zoe);
// echo $zoe->polluer();
$zoe->rouler(20);
var_dump($zoe);