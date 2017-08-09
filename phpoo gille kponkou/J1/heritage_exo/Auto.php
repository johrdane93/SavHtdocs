<?php

require_once './Vehicule.php';
class Auto extends Vehicule
{
    public function getNbWheels()
    {
        return 4;
    }
}

