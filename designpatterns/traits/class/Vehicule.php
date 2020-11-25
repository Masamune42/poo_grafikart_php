<?php

class Vehicule
{
    protected $roue = 4;
    protected $km = 0;

    public function rouler($km)
    {
        $this->km += $km;
    }
}
