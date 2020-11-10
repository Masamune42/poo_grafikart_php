<?php

namespace App\Table;

use App\App;

class Table
{
    // private $id;

    // private $titre;

    // private $contenu;
    protected static $table;

    private static function getTable()
    {
        if (static::$table === null) {
            $class_name = explode('\\', get_called_class());
            static::$table = strtolower(end($class_name)) . 's';
        }
        return static::$table;
    }

    public static function find($id)
    {
        return static::query(
            "SELECT *
            FROM " . static::$table . "
            WHERE id = ?",
            [$id],
            true
        );
    }

    public static function query($statement, $attributes = null, $one = false)
    {
        if ($attributes) {
            return App::getDb()->prepare($statement, $attributes, get_called_class(), $one);
        } else {
            return App::getDb()->query($statement, get_called_class(), $one);
        }
    }

    public static function all()
    {
        return App::getDb()->query(
            "SELECT *
            FROM " . static::$table,
            get_called_class()
        );
    }

    /**
     * Fonction magique : si on appelle une variable qui n'existe pas, on utilise cette variable selon nos besoins. ATTENTION : ne pas en abuser (voir ne pas l'utiliser)
     *
     * @param string $key clé de la valeur souhaitée
     * @return void
     */
    public function __get($key)
    {
        // On récupère la clé pour l'utiliser et appeler une fonction
        $method = 'get' . ucfirst($key);
        // On déclare une nouvelle propriété qui appellera la méthode voulue la prochaine fois qu'on utilisera cette propriété (= utilisation de la méthode magique une seule fois)
        $this->$key = $this->$method();
        return $this->$key;
    }
}
