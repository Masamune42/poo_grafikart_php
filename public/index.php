<?php

define('ROOT', dirname(__DIR__));
var_dump(ROOT);
require ROOT . '/app/App.php';

App::load();

// On déclare la time zone utilisée
date_default_timezone_set('Europe/Paris');

$app = App::getInstance();
// Si "p" est en paramètre, alors on récupère sa valeur dans $p, sinon égal à 'home'
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'home';
}

// On met en buffer la page demandée
ob_start();
if ($page === 'home') {
    require ROOT . '/pages/articles/home.php';
} elseif ($page === 'article') {
    require ROOT . '/pages/articles/single.php';
} elseif ($page === 'categorie') {
    require ROOT . '/pages/articles/categorie.php';
}
$content = ob_get_clean();
// On appelle la page de layout
require '../pages/templates/default.php';
