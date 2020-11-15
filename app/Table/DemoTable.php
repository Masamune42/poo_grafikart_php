<?php

namespace App\Table;

class DemoTable
{
    public function index()
    {
        require ROOT . '/Query.php';
        echo \Query::select('id', 'titre', 'contenu')
            ->where('Post.category_id = 1')
            ->where('Post.date > NOW()')
            ->from('articles', 'Post')
            ->getQuery();
    }
}