<?php

trait Dieselable
{
    public function polluer()
    {
        echo 'VROUM VROUM je pollue';
    }
    
    public function rouler($km)
    {
        $this->polluer();
    }
}
