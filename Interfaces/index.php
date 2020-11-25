<?php

require "vendor/autoload.php";

$session = new Grafikart\Session();
$cookie = new Grafikart\Cookie();
$flash = new Grafikart\Flash($session);
// $flash = new Grafikart\Flash($cookie);
// var_dump(count($session));
// $session->set('animal', 'chat');
// var_dump($session->get('animal'));
// var_dump($session->offsetGet('animal'));
// exit;
// ALERT CODE BIDON !!
// Code à l'arrache pour rendre une vue ^^
if (isset($_GET['p'])) {
    $page = $_GET['p'];
}  else {
    $page = 'index';
}
$pages = ['flash', 'index'];
if(!in_array($page, $pages)){
    die('Put the coconut down NOW !');
}
ob_start();
require "views/{$page}.php";
$content = ob_get_clean();
require 'views/layout.php';
