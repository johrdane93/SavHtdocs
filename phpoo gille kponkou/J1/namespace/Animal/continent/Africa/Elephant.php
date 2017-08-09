<?php

namespace Animal\continent\Africa;

use Animal\Element as AbstractElephant;

// pour ne pas avoir à préfixer une classe sans namespace
// d'un \ à l'intérieur d'un namespace, on peut utiliser un use

use Tourist;

class Elephant extends AbstractElephant
{
    public function getEarsSize()
    {
        return 'big';
    }
    
    public function beSeen()
    {
        $tourist = new Tourist();
        $tourist->watchElephant('africa');
    }
}




