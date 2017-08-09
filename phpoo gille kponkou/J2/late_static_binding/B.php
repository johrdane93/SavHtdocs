<?php

require_once './A.php';

class B extends A
{
    public static function qui()
    {
        echo __CLASS__;
    }
}