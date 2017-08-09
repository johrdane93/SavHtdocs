<?php

use Animal\Continent\Africa\Elephant;

class Tourist
{
    public function watchElephant($continent)
    {
        /*
         * $continent doit valoir 'asia' ou 'africa'
         * on instancie l'éléphant  qui correspond au continent
         * et on affiche la taille de ses oreilles
         */
        
        if ('asia' == $continent)
        {
            $elephant = new AsianElephant();
            
        }elseif ('africa' == $continent) {
            $elephant = new Elephant();
        } else {
            $msg = "Continent $continent is not allowed ";
        }
        
        echo 'It has ' . $elephant->getEarsSize() . 'ears';
    }
    
    
}
