<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;

class instr_NOT extends AbstractInstruction
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
                $this->bool = $string === 'false';
            }
        }
        else if ($this->args[1]->argType === "bool")
        {
            $string = $this->args[1]->argValue;
            if (!preg_match('/^(true|false)$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->bool = $string === 'false';
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
            $frame->addToFrame($this->VarValue, "bool", (string)$this->bool, "GF", false);
        }
        else if ($this->VarFrame === "LF")
        {
            $frame->addToFrame($this->VarValue, "bool", (string)$this->bool, "LF", false);
        }
        else if ($this->VarFrame === "TF")
        {
            $frame->addToFrame($this->VarValue, "bool", (string)$this->bool, "TF", false);
        }
    }
}