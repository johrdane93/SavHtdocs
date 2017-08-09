<?php

namespace Animal\continen\Africa;

class Gazelle
{
    public function watchElephant()
    {
        /*
         * = new Animal\continent\Africa\Elephant()
         * car on est dans le namespace Animal\continent\Africa
         * pas besoin de use dans ce cas
         */
        
        $elephant = new Elephant();
        
        echo $elephant->getEarsSize();
    }
}

