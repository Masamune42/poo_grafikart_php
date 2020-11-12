<?php

namespace App;

use App\Database\MysqlDatabase;

class App
{
    public $title = "Mon super site";

    private static $_instance;

    private $db_instance;

    /**
     * Singleton : crée ou récupère l'instance
     *
     * @return self Instance de la classe
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public static function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        header('Location:index.php?p=404');
    }

    /**
     * Factory : permet d'appeler la Table dont le nom est passé en paramètre
     *
     * @param string $name Nom de la classe
     * @return Table une table qui extends de Table
     */
    public function getTable($name)
    {
        $class_name = '\\App\\Table\\' . ucfirst($name) . 'Table';
        return new $class_name($this->getDb());
    }

    /**
     * Effectue une connexion à la base de données et la garde en instance de classe
     *
     * @return MysqlDatabase Instance de la base de donnée
     */
    public function getDb()
    {
        $config = Config::getInstance();
        if(is_null($this->db_instance)) {
            $this->db_instance = new MysqlDatabase($config->get('db_name'), $config->get('db_user'), $config->get('db_pass'), $config->get('db_host'));
        }
        return $this->db_instance;
    }
}
