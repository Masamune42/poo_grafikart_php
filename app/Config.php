<?php

namespace App;

class Config
{
    private $settings = [];
    private static $_instance;

    /**
     * Singleton : crée ou récupère l'instance
     *
     * @return self Instance de la classe
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $this->settings = require __DIR__ . '/config/config.php';
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
