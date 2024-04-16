<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;

class instr_EQ extends AbstractInstruction
{
    private string $VarFrame;
    private string $VarValue;
    private string $type1;
    private string $string1;
    private string $type2;
    private string $string2;
    private string $returnString;

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
                list($this->type1, $this->string1) = $value;
                if (!(
                    ($this->type1 === "bool" && preg_match('/^(true|false)$/', $this->string1)) ||
                    ($this->type1 === "string") ||
                    ($this->type1 === "int" && preg_match('/^-?\d+$/', $this->string1)) ||
                    ($this->type1 === "nil" && preg_match('/^nil$/', $this->string1))
                )) {
                    exit(ReturnCode::OPERAND_TYPE_ERROR);
                }
            }
        }
        else if ($this->args[1]->argType === "bool")
        {
            $string = $this->args[1]->argValue;
            if (!preg_match('/^(true|false)$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->type1 = "bool";
            $this->string1 = $string;
        }
        else if ($this->args[1]->argType === "string")
        {
            $this->type1 = "string";
            $this->string1 = $this->args[1]->argValue;
        }
        else if ($this->args[1]->argType === "int")
        {
            $string = $this->args[1]->argValue;
            if (!preg_match('/^-?\d+$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->type1 = "int";
            $this->string1 = $string;
        }
        else if ($this->args[1]->argType === "nil")
        {
            $string = $this->args[1]->argValue;
            if (!preg_match('/^nil$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->type1 = "nil";
            $this->string1 = $string;
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
                list($this->type2, $this->string2) = $value;

                if (!(
                    ($this->type1 === "bool" && preg_match('/^(true|false)$/', $this->string2)) ||
                    ($this->type1 === "string") ||
                    ($this->type1 === "int" && preg_match('/^-?\d+$/', $this->string2)) ||
                    ($this->type1 === "nil" && preg_match('/^nil$/', $this->string2))
                )) {
                    exit(ReturnCode::OPERAND_TYPE_ERROR);
                }
            }
        }
        else if ($this->args[2]->argType === "bool")
        {
            $string = $this->args[2]->argValue;
            if (!preg_match('/^(true|false)$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->type2 = "bool";
            $this->string2 = $string;
        }
        else if ($this->args[2]->argType === "string")
        {
            $this->type2 = "string";
            $this->string2 = $this->args[2]->argValue;
        }
        else if ($this->args[2]->argType === "int")
        {
            $string = $this->args[2]->argValue;
            if (!preg_match('/^-?\d+$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->type2 = "int";
            $this->string2 = $string;
        }
        else if ($this->args[2]->argType === "nil")
        {
            $string = $this->args[2]->argValue;
            if (!preg_match('/^nil$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->type2 = "nil";
            $this->string2 = $string;
        }
        else{
            exit (ReturnCode::OPERAND_TYPE_ERROR);
        }


        // actual equation
        if ($this->type1 === $this->type2 )
        {
            if($this->string1 === $this->string2)
            {
                $this->returnString = "true";
            }
            else
            {
                $this->returnString = "false";
            }
        }
        else
        {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
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
            $frame->addToFrame($this->VarValue, "bool", $this->returnString, "GF", false);
        }
        else if ($this->VarFrame === "LF")
        {
            $frame->addToFrame($this->VarValue, "bool", $this->returnString, "LF", false);
        }
        else if ($this->VarFrame === "TF")
        {
            $frame->addToFrame($this->VarValue, "bool", $this->returnString, "TF", false);
        }
    }
}