<div class="row">
    <div class="col-sm-8">
        <!-- Liste des articles -->
        <ul>
            <?php foreach (App::getInstance()->getTable('Post')->last() as $post) : ?>
                <h2><a href="<?= $post->url ?>"><?= $post->titre ?></a></h2>
                <p><em><?= $post->categorie; ?></em></p>
                <p><?= $post->extrait; ?></p>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-sm-4">
        <?php foreach (App::getInstance()->getTable('Category')->all() as $categorie) : ?>
            <li><a href="<?= $categorie->url; ?>"><?= $categorie->titre; ?></a></li>
        <?php endforeach; ?>
    </div>
</div>