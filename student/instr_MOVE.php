<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;

class instr_MOVE extends AbstractInstruction
{
    private string $VarFrame;
    private string $VarValue;
    private string $type;
    private string $string;

    private string $VarFrame1;
    private string $VarValue1;

    public function execute() :void
    {
        $frame = Frame::getInstance();

        // part get from
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
                list($this->type, $this->string) = $value;
            }
        }
        else if ($this->args[1]->argType === "int")
        {
            $string = $this->args[1]->argValue;
            if (!preg_match('/^-?\d+$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->type = "int";
            $this->string = $string;
        }
        else if ($this->args[1]->argType === "string")
        {
            $this->type = "string";
            $this->string = $this->args[1]->argValue;
        }
        else if ($this->args[1]->argType === "bool")
        {
            $this->type = "bool";
            $this->string = $this->args[1]->argValue;
        }
        else if ($this->args[1]->argType === "nil")
        {
            $string = $this->args[1]->argValue;
            if (!preg_match('/^nil$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->type = "nil";
            $this->string = $string;
        }
        else{
            exit (ReturnCode::OPERAND_TYPE_ERROR);
        }

        // part move to
        $parts = explode("@", $this->args[0]->argValue);
        if (count($parts) !== 2) {
            exit (ReturnCode::SEMANTIC_ERROR);
        }
        $this->VarFrame = $parts[0];
        $this->VarValue = $parts[1];

        if ($this->VarFrame === "GF")
        {
            $frame->addToFrame($this->VarValue, $this->type, $this->string, "GF",false);
        }
        else if ($this->VarFrame === "LF")
        {
            $frame->addToFrame($this->VarValue, $this->type, $this->string, "LF",false);
        }
        else if ($this->VarFrame === "TF")
        {
            $frame->addToFrame($this->VarValue, $this->type, $this->string, "TF",false);
        }
        else{
            exit (ReturnCode::SEMANTIC_ERROR);
        }
    }
}