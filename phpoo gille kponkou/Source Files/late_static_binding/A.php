<?php

class A
{
    public static function qui()
    {

        /*
         * retourne la class
         * dans laquelle on se trouve
         */
        echo __CLASS__ ;
    }
    public static function testSelf()
    {
      /*
       * appelé depuis B c'est tous de même la methode qui() de A qui sera
       *  utilisée
       */
      self::qui();

    }
    public static function testStatic()
    {

        /*
         * appelé depuis B c'est la methode qui() de B qui sera utilisé
         *
         */
        static::qui();
    }
}
