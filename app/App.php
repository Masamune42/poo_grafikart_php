<?php

namespace App;

class App
{
    public $title = "Mon super site";

    private static $_instance;

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
}
