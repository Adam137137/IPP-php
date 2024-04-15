<?php

namespace IPP\Student;

class Argument
{
    private string $argType;
    private int $argNumber;
    private string $argValue;

    function __construct(string $argType, int $argNumber, string $argValue)
    {
        $this->argType = $argType;
        $this->argNumber = $argNumber;
        $this->argValue = $argValue;
    }

    function getArgNumber() {
        return $this->argNumber;
    }
    
    function print(){
        echo "Number {$this->argNumber} Type: {$this->argType}, Value: {$this->argValue}\n";
    }

}
