<?php

abstract class Vehicule
{
    protected $fuel;
    protected $maxSpeed;
    
    protected static $availableFuel = [
        'essence',
        'diesel'
    ];
    public function __construct(
      $maxSpeed,
      $fuel = 'essence'
       )
    {
        $this->setFuel($fuel);
        $this->setMaxSpeed($maxSpeed);
    }
    
    public function getFuel()
    {
        return $this->fuel;
    }
    
    public function getMaxSpeed()
    {
        return $this->maxSpeed;
    }
    
    public function setFuel($fuel)
    {
        if (!in_array($fuel, static::$availableFuels))
        {
            $msg = "$fuel n'est pas un carburant accepté: "
                .  implode (',', static::$availableFuels)
                .  'sont les valeurs possibles';
          
            trigger_error($msg,E_USER_ERROR);
                           
        }
        $this->fuel=$fuel;
        return $this;
    }
    
    
    
            
}

