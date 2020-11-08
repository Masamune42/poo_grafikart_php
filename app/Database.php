<?php

namespace App;

use App\Table\Article;
use PDO;

class Database
{
    private $db_name;

    private $db_user;

    private $db_pass;

    private $db_host;

    private $pdo;

    public function __construct($db_name, $db_user = 'root', $db_pass = '', $db_host = 'localhost')
    {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    /**
     * Retourne un objet PDO : connexion à la BDD, en utilisant les propriétés de l'instance
     *
     * @return PDO
     */
    public function getPDO(): PDO
    {
        if ($this->pdo === null) {
            $pdo = new PDO("mysql:dbname={$this->db_name};host={$this->db_host};charset=utf8", $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $pdo;
    }

    /**
     * Appelle une requête SQL et renvoie ses résultats
     *
     * @param string $statement Requête SQL
     * @param string $class_name Nom de la classe utilisée
     * @return array()
     */
    public function query($statement, $class_name)
    {
        $res = $this->getPDO()->query($statement);
        $data = $res->fetchAll(PDO::FETCH_CLASS, $class_name);
        return $data;
    }

    public function prepare($statement, $attributes, $class_name, $one = false)
    {
        $req = $this->getPDO()->prepare($statement);
        $req->execute($attributes);
        $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }
        return $data;
    }
}
