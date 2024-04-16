<?php

namespace IPP\Student;

use IPP\Core\AbstractInterpreter;
use IPP\Core\Exception\NotImplementedException;
use IPP\Core\ReturnCode;


class Interpreter extends AbstractInterpreter
{
    public function execute(): int
    {
        // TODO: Start your code here
        // Check \IPP\Core\AbstractInterpreter for predefined I/O objects:
        $dom = $this->source->getDOMDocument();
        //$val = $this->input->readString();
        //$this->stdout->writeString("stdout");
        //$this->stderr->writeString("stderr");

        $instructions = $dom->getElementsByTagName('instruction');
        $instruction_Array=[];
        $namespace_prefix = 'IPP\Student\\instr_';

        foreach ($instructions as $instruction) {
            $order = $instruction->getAttribute('order');
            $opcode = $instruction->getAttribute('opcode');
            
            // Get arguments
            $args = [];
            foreach ($instruction->childNodes as $node) {
                if ($node->nodeType === XML_ELEMENT_NODE) {
                    $argName = $node->nodeName;
                    $argType = $node->getAttribute('type');
                    $argValue = $node->nodeValue;

                    if (preg_match('/^arg(\d+)$/', $argName, $matches)) {
                        $argNumber = $matches[1];
                        $args[] = new Argument($argType, (int) $argNumber, $argValue);
                    }
                    else{
                        return ReturnCode::INVALID_SOURCE_STRUCTURE;
                    }
                }
                else{
                    // return ReturnCode::INVALID_XML_ERROR;
                }
            }
            usort($args, function($a, $b) {
                return $a->getArgNumber() - $b->getArgNumber();
            });


            
            $className = $namespace_prefix . $opcode;
            $instructionObject = new $className($order, $args);
            $instruction_Array[] = $instructionObject;
        }

        $orderComparison = function($a, $b) {
            // Extract the order attribute from each instruction
            $orderA = $a->getOrder();
            $orderB = $b->getOrder();
        
            // Compare the order values
            if ($orderA == $orderB) {
                return 0;
            }
            return ($orderA < $orderB) ? -1 : 1;
        };

        usort($instruction_Array, $orderComparison);

        foreach($instruction_Array as $instruction){
            $instruction->print();
            $instruction->printArgs();
            $instruction->execute();
        }


        return ReturnCode::OK;
    }
    
}
