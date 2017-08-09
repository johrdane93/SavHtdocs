<?php

require_once './Vehicule.php';

class Moto extends Vehicule
{
    protected static $avalableFuels=[
        'essence'
    ];
    public function getNbWheels()
    {
        return 2;
    }
}

