<?php
// Page d'un article

use App\Table\Article;

/** @var Article */
$post = $db->prepare('SELECT * FROM articles WHERE id= ?', [$_GET['id']], 'App\Table\Article', 1);
?>

<h2><?= $post->titre; ?></h2>

<p><?= $post->contenu; ?></p>