<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;

class instr_AND extends AbstractInstruction
{
    private string $VarFrame;
    private string $VarValue;
    private bool $bool;

    private string $VarFrame1;
    private string $VarValue1;
    private string $VarFrame2;
    private string $VarValue2;

    public function execute()
    {
        $frame = Frame::getInstance();
        
        // symb1
        if ($this->args[1]->argType === "var")
        {
            $parts = explode("@", $this->args[1]->argValue);
            if (count($parts) !== 2) {
                exit (ReturnCode::SEMANTIC_ERROR);
            }
            $this->VarFrame1 = $parts[0];
            $this->VarValue1 = $parts[1];

            if($this->VarFrame1 == "GF")
            {
                $value = $frame->getFromFrame($this->VarValue1, "GF");
            }
            else if($this->VarFrame1 == "LF")
            {
                $value = $frame->getFromFrame($this->VarValue1, "LF");
            }
            else if($this->VarFrame1 == "TF")
            {
                $value = $frame->getFromFrame($this->VarValue1, "TF");
            }
            
            if ($value !== null) {
                list($type, $string) = $value;
                if (!preg_match('/^(true|false)$/', $string) || $type !== "bool") {
                    exit(ReturnCode::OPERAND_TYPE_ERROR);
                }
                $this->bool = $string === 'true';
            }
        }
        else if ($this->args[1]->argType === "bool")
        {
            $string = $this->args[1]->argValue;
            if (!preg_match('/^(true|false)$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->bool = $string === 'true';
        }
        else{
            exit (ReturnCode::OPERAND_TYPE_ERROR);
        }

        // symb2:
        if ($this->args[2]->argType === "var")
        {
            $parts = explode("@", $this->args[2]->argValue);
            if (count($parts) !== 2) {
                exit (ReturnCode::SEMANTIC_ERROR);
            }
            $this->VarFrame2 = $parts[0];
            $this->VarValue2 = $parts[1];

            if($this->VarFrame2 == "GF")
            {
                $value = $frame->getFromFrame($this->VarValue2, "GF");
            }
            else if($this->VarFrame2 == "LF")
            {
                $value = $frame->getFromFrame($this->VarValue2, "LF");
            }
            else if($this->VarFrame2 == "TF")
            {
                $value = $frame->getFromFrame($this->VarValue2, "TF");
            }
            
            if ($value !== null) {
                list($type, $string) = $value;
                if (!preg_match('/^(true|false)$/', $string) || $type !== "bool") {
                    exit (ReturnCode::OPERAND_TYPE_ERROR);
                }
                $this->bool = $string === 'true' && $this->bool;
            }
        }
        else if ($this->args[2]->argType === "bool")
        {
            $string = $this->args[2]->argValue;
            if (!preg_match('/^(true|false)$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->bool = $string === 'true' && $this->bool;
        }
        else{
            exit (ReturnCode::OPERAND_TYPE_ERROR);
        }


        // part move to <var>
        $parts = explode("@", $this->args[0]->argValue);
        if (count($parts) !== 2) {
            exit (ReturnCode::SEMANTIC_ERROR);
        }
        $this->VarFrame = $parts[0];
        $this->VarValue = $parts[1];

        $boolAsString = $this->bool ? "true" : "false";
        if ($this->VarFrame === "GF")
        {
            $frame->addToFrame($this->VarValue, "bool", $boolAsString, "GF", false);
        }
        else if ($this->VarFrame === "LF")
        {
            $frame->addToFrame($this->VarValue, "bool", $boolAsString, "LF", false);
        }
        else if ($this->VarFrame === "TF")
        {
            $frame->addToFrame($this->VarValue, "bool", $boolAsString, "TF", false);
        }
    }
}