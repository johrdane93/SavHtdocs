<?php

namespace Animal\continent\Asia;
use Animal\Elephant as AbstractElephant;

class Elephant extends AbstractElephant
{
    public function getEarsSize()
    {
        return 'small';
    }
    
    public function beseen()
    {
        
        $tourist = new \Tourist();
        $tourist->watchElephant('asia');
    }
}


