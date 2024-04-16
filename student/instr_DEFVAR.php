<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;

class instr_DEFVAR extends AbstractInstruction
{
    private string $VarFrame;
    private string $VarValue;

    public function execute() :void
    {
        $frame = Frame::getInstance();

        $parts = explode("@", $this->args[0]->argValue);
        if (count($parts) !== 2) {
            exit (ReturnCode::SEMANTIC_ERROR);
        }
        $this->VarFrame = $parts[0];
        $this->VarValue = $parts[1];

        if ($this->VarFrame === "GF")
        {
            $frame->addToFrame($this->VarValue, "NULL", "NULL", "GF", true);
        }
        else if ($this->VarFrame === "LF")
        {
            $frame->addToFrame($this->VarValue, "NULL", "NULL", "LF", true);
        }
        if ($this->VarFrame === "TF")
        {
            $frame->addToFrame($this->VarValue, "NULL", "NULL", "TF", true);
        }
    }
}