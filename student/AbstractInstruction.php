<?php

namespace IPP\Student;

class AbstractInstruction
{
    private int $order;
    protected array $args;

    function __construct(int $order, array $args)
    {
        $this->order = $order;
        $this->args = $args;
    }

    public function getOrder() :int
    {
        return $this->order;
    }

    public function getArgs() :array
    {
        return $this->args;
    }
    
    function print() :void
    {
        echo "Order: {$this->order}\n";
    }
    function printArgs() :void
    {
        foreach ($this->args as $arg)
        {
            $arg->print();
        }
    }

}