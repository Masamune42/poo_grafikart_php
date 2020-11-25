<?php

/**
 * Exemplete de fusion de 2 traits dans un seul
 */
trait Hybridable
{
    // On peut utiliser des traits dans d'autres
    use Rechargeable, Dieselable {
        Rechargeable::rouler as rouler_electric;
        Dieselable::rouler as rouler_diesel;
    }

    public function rouler($km)
    {
        $this->rouler_electric($km);
        $this->rouler_diesel($km);
    }
}
