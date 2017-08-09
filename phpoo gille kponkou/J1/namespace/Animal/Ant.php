<?php

namespace Animal;

class Ant
{
    public function WatchAfricanElephant()
    {
     
        $elephant = new Continent\Africa\Elephant();
        echo $elephant->getEarsSize();
        
    }
}

