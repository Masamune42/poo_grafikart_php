<?php

trait Rechargeable
{
    public $energy = 100;

    public function recharger()
    {
        $this->energy = 100;
    }

    public function rouler($km)
    {
        // Par défaut la fonction écrase la fonction parente si elle existe
        // On appelle donc la fonction de la classe parente comme ceci
        // parent::rouler($km);
        $this->energy -= $km;
    }
}
