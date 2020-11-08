<?php

require '../app/Autoloader.php';

use App\Database;
// On déclare la time zone utilisée
date_default_timezone_set('Europe/Paris');
// On s'enregistre à l'autoloader
App\Autoloader::register();

// Si "p" est en paramètre, alors on récupère sa valeur dans $p, sinon égal à 'home'
if (isset($_GET['p'])) {
    $p = $_GET['p'];
} else {
    $p = 'home';
}

// Connexion à la BDD blog
$db = new Database('blog');

// On met en buffer la page demandée
ob_start();
if ($p === 'home') {
    require '../pages/home.php';
} elseif ($p === 'article') {
    require '../pages/single.php';
}
$content = ob_get_clean();
// On appelle la page de layout
require '../pages/templates/default.php';
