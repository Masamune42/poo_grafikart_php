<?php

namespace App\Table;

use App\App;
use App\Database\MysqlDatabase;

class Table
{
    protected $table;

    /** @var MysqlDatabase */
    protected $db;

    /**
     * Constructeur par défaut
     *
     * @param \App\Database\Database $db Base de données
     */
    public function __construct(\App\Database\Database $db)
    {
        $this->db = $db;
        if (is_null($this->table)) {
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);
            $this->table = strtolower(str_replace('Table', '', $class_name));
        }
    }

    /**
     * Récupère tous les articles
     *
     * @return PostsTable[] Tableau d'articles
     */
    public function all()
    {
        return $this->db->query('SELECT * FROM articles');
    }
}
