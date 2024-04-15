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
        $namespace_prefix = 'IPP\Student\\';

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
                        echo "{$argValue}\n";
                        $args[] = new Argument($argType, $argNumber, $argValue);
                    }
                    else{
                        echo "tu1";
                        return ReturnCode::INVALID_SOURCE_STRUCTURE;
                    }
                }
                // else{
                //     echo "{$node->nodeType}";
                //     return ReturnCode::INVALID_XML_ERROR;
                // }
            }
            usort($args, function($a, $b) {
                return $a->getArgNumber() - $b->getArgNumber();
            });

            foreach ($args as $arg)
            {
                $arg->print();
            }
            
            $className = $namespace_prefix . $opcode;
            $instructionObject = new $className($order);
            $instruction_Array[] = $instructionObject;
        }


        return ReturnCode::OK;
        throw new NotImplementedException;
    }
}
