<?php

namespace App\Table;

use Core\Database\QueryBuilder;

class DemoTable extends QueryBuilder
{
    public function index()
    {
        $query = new QueryBuilder();
        echo $query
            ->select('id', 'titre', 'contenu')
            ->where('Post.category_id = 1')
            ->where('Post.date > NOW()')
            ->from('articles', 'Post')
            ->getQuery();
    }
}
