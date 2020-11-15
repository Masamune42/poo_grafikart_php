<?php

use Core\Database\QueryBuilder;

class Query
{
    /**
     * Méthode magique (PHP 5.3+) qui permet de rediriger vers QueryBuilder
     *
     * @param string $method Nom de la méthode à appeler
     * @param array $arguments Arguments à passer à la méthode
     * @return void
     */
    public static function __callStatic($method, $arguments)
    {
        $query = new QueryBuilder();
        // Méthode qui permet d'appeler la fonction d'une méthode avec des arguments
        // Ex : méthode select de QueryBuilder avec les arguments
        return call_user_func_array([$query, $method], $arguments);
    }
}
