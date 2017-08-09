<?php

class A
{
    public static function qui()
    {
        /**
         * retourne la classe
         * //dans laquelle on se trouve
         */
        echo __CLASS__;
    }
    
    public static function testSelf()
    {
        /*
         * appelé depuis B, c'est tout de même
         * la méthode qui() de A qui sera utilisée
         */
        self::qui();
    }
    
    public static function testStatic()
    {
        // appelé depuis B, C'est la méthode qui()
        // de B qui sera utilisée
        static::qui();
    }
}

