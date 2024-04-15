<?php

namespace IPP\Student;

interface InstructionInterface
{
    public function execute();
}

class Instruction implements InstructionInterface
{
    function __construct()
    {
        

    }

    // function __construct(string $opcode, \DOMElement $instruction)
    // {
    //     // switch ($opcode) {
    //     //     case 'DEFVAR':
    //     //             return new DefVarInstruction($instruction);
    //     //     case 'READ':
    //     //         return new ReadInstruction($instruction);
    //     //     case 'WRITE':
    //     //         return new WriteInstruction($instruction);
    //     //     // Add cases for other opcodes as needed
    //     //     default:
    //     //         throw new \InvalidArgumentException("Unknown opcode: $opcode");
    //     // }
    // }

    public function execute()
    {

    }
}