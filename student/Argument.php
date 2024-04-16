<?php

namespace IPP\Student;

class Argument
{
    public string $argType;
    public int $argNumber;
    public string $argValue;


    function __construct(string $argType, int $argNumber, string $argValue)
    {
        $this->argType = $argType;
        $this->argNumber = $argNumber;
        $this->argValue = $argValue;
    }

    function getArgNumber() :int
    {
        return $this->argNumber;
    }

    // function getVarFrame() {
    //     return $this->VarFrame;
    // }

    // function getVarValue() {
    //     return $this->VarValue;
    // }

    // function setVarFrame() {
    //     return $this->VarFrame;
    // }

    // function setVarValue()
    // {
    //     return $this->VarValue;
    // }

    function print() :void
    {
        echo "    Arg num: {$this->argNumber} Type: {$this->argType}, Value: {$this->argValue}\n";
    }

}
