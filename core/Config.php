<?php

namespace Core;

class Config
{
    private $settings = [];
    private static $_instance;

    /**
     * Singleton : crée ou récupère l'instance
     *
     * @return self Instance de la classe
     */
    public static function getInstance($file)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Config($file);
        }
        return self::$_instance;
    }

    public function __construct($file)
    {
        $this->settings = require($file);
    }

    /**
     * Récupère la clé de la configuration voulue
     *
     * @param string $key Nom de la clé
     * @return void
     */
    public function get($key)
    {
        if (!isset($this->settings[$key])) {
            return null;
        }
        return $this->settings[$key];
    }
}
