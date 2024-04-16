<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;

class instr_EXIT extends AbstractInstruction
{
    private string $VarFrame;
    private string $VarValue;
    private string $type;
    private int $int;


    public function execute() :void
    {
        $frame = Frame::getInstance();

        // part get from
        if ($this->args[0]->argType === "var")
        {
            $parts = explode("@", $this->args[0]->argValue);
            if (count($parts) !== 2) {
                exit (ReturnCode::SEMANTIC_ERROR);
            }
            $this->VarFrame = $parts[0];
            $this->VarValue = $parts[1];

            if($this->VarFrame == "GF")
            {
                $value = $frame->getFromFrame($this->VarValue, "GF");
            }
            else if($this->VarFrame == "LF")
            {
                $value = $frame->getFromFrame($this->VarValue, "LF");
            }
            else if($this->VarFrame == "TF")
            {
                $value = $frame->getFromFrame($this->VarValue, "TF");
            }
            
            if ($value !== null) {
                list($this->type, $string) = $value;
                if (!($this->type === "int" && preg_match('/^-?\d+$/', $string)))
                {
                    exit(ReturnCode::OPERAND_TYPE_ERROR);
                }
                $this->int = $string;
            }
        }
        else if ($this->args[0]->argType === "int")
        {
            $string = $this->args[0]->argValue;
            if (!preg_match('/^-?\d+$/', $string)) {
                exit (ReturnCode::OPERAND_TYPE_ERROR);
            }
            $this->type = "int";
            $this->int = $string;
        }
        else{
            exit (ReturnCode::OPERAND_TYPE_ERROR);
        }

        if ($this->int < 0 || $this->int > 9)
        {
            exit (ReturnCode::OPERAND_VALUE_ERROR);
        }

        exit($this->int);
    }
}