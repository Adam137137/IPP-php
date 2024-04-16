<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;
use IPP\Core\StreamWriter;

class instr_WRITE extends AbstractInstruction
{
    private string $VarFrame;
    private string $VarValue;
    private string $type;
    private string $string;

    public function execute() :void
    {
        $frame = Frame::getInstance();
        $streamWriter = new StreamWriter(STDOUT);

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
                list($this->type, $this->string) = $value;
            }
        }
        else if ($this->args[0]->argType === "int")
        {
            echo "int\n";
            $this->type = "int";
            $this->string = $this->args[0]->argValue;
        }
        else if ($this->args[0]->argType === "string")
        {
            echo "string\n";
            $this->type = "string";
            $this->string = $this->args[0]->argValue;
        }
        else if ($this->args[0]->argType === "bool")
        {
            echo "bool\n";
            $this->type = "bool";
            $this->string = $this->args[0]->argValue;
        }


        if ($this->type === "string")
        {
            $streamWriter->writeString($this->string);
        }
        else if ($this->type === "int")
        {
            $streamWriter->writeInt((int)$this->string);
        }
        else if ($this->type === "bool")
        {
            $streamWriter->writeBool((bool)$this->string);
        }
    }
}