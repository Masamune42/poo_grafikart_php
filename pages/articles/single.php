<?php
// Page d'un article

use App\App;
use App\Table\Article;

/** @var Article */
$post = Article::find($_GET['id']);
if($post === false) {
    App::notFound();
}
App::setTitle($post->titre);
?>

<h1><?= $post->titre; ?></h1>

<p><em><?= $post->categorie ?></em></p>

<p><?= $post->contenu; ?></p>