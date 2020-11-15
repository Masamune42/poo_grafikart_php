<?php

define('ROOT', dirname(__DIR__));
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
    require ROOT . '/pages/posts/home.php';
} elseif ($page === 'posts.show') {
    require ROOT . '/pages/posts/show.php';
} elseif ($page === 'posts.category') {
    require ROOT . '/pages/posts/category.php';
}
$content = ob_get_clean();
// On appelle la page de layout
require '../pages/templates/default.php';

// Test du QueryBuilder
// $app->getTable('Demo')->index();