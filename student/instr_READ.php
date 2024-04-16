<?php

namespace IPP\Student;

use IPP\Core\FileInputReader;
use IPP\Core\ReturnCode;

class instr_READ extends AbstractInstruction
{
    private string $type;
    private string $value;

    private string $VarFrame;
    private string $VarValue;

    private ?string $string;

    public function execute() :void
    {
        $frame = Frame::getInstance();

        $parts = explode("@", $this->args[0]->argValue);
        if (count($parts) !== 2) {
            exit (ReturnCode::SEMANTIC_ERROR);
        }
        $this->VarFrame = $parts[0];
        $this->VarValue = $parts[1];

        $this->value = $this->args[1]->argValue;
        $fileInputReader = new FileInputReader("file");

        if ($this->value === "int")
        {
            $this->type = "int";
            $this->string = (string) $fileInputReader->readInt();
        }
        else if ($this->value === "string")
        {
            $this->type = "string";
            $this->string = $fileInputReader->readString();
        }
        else if ($this->value === "bool")
        {
            $this->type = "bool";
            $this->string = (string) $fileInputReader->readBool();
        }
        else
        {
            $this->type = "nil";
            $this->string = "nil";
        }

        if ($this->VarFrame === "GF")
        {
            $frame->addToFrame($this->VarValue, $this->type, $this->string, "GF", false);
        }
        else if ($this->VarFrame === "LF")
        {
            $frame->addToFrame($this->VarValue, $this->type, $this->string, "LF", false);
        }
        if ($this->VarFrame === "TF")
        {
            $frame->addToFrame($this->VarValue, $this->type, $this->string, "TF", false);
        }
        

    }
}