<?php

class Zoe extends Voiture
{
    // On utilise le trait (paramètres + fonctions)
    // On peut appeler une fonction et redéfinir son nom dans la classe actuelle pour l'utiliser
    use Rechargeable, Dieselable {
        // Cas 1 : la fonction existe dans la classe courante + dans un trait
        // Rechargeable::rouler as rouler_electric;
        // Cas 2 : la fonction existe dans 2 traits
        // Rechargeable::rouler insteadof Dieselable;
        // Cas 3 : dans la classe courante + dans 2 traits
        Rechargeable::rouler as rouler_electric;
        // On peut redéfinir la portée en l'indiquant après le "as"
        Dieselable::rouler as rouler_diesel;
    }
    // use Dieselable;

    private $name = 'Zoe';

    public function rouler($km)
    {
        $this->rouler_electric($km);
        $this->rouler_diesel($km);
        // $this->km += $km * 2;
    }
}
