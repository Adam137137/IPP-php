<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;

class instr_MUL extends AbstractInstruction
{
    private string $VarFrame;
    private string $VarValue;
    private int $int;

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
                if (!preg_match('/^-?\d+$/', $string) || $type !== "int") {
                    exit (ReturnCode::OPERAND_TYPE_ERROR);
                }
                $this->int = (int) $string;
            }
        }
        else if ($this->args[1]->argType === "int")
        {
            $string = $this->args[1]->argValue;
            if (!preg_match('/^-?\d+$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->int = (int) $string;
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
                if (! preg_match('/^-?\d+$/', $string) || $type !== "int") {
                    exit (ReturnCode::OPERAND_TYPE_ERROR);
                }
                $this->int *= (int) $string;
            }
        }
        else if ($this->args[2]->argType === "int")
        {
            $string = $this->args[2]->argValue;
            if (!preg_match('/^-?\d+$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->int *= (int) $string;
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

        if ($this->VarFrame === "GF")
        {
            $frame->addToFrame($this->VarValue, "int", (string)$this->int, "GF", false);
        }
        else if ($this->VarFrame === "LF")
        {
            $frame->addToFrame($this->VarValue, "int", (string)$this->int, "LF", false);
        }
        else if ($this->VarFrame === "TF")
        {
            $frame->addToFrame($this->VarValue, "int", (string)$this->int, "TF", false);
        }
    }
}