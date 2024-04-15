<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;

class DEFVAR extends AbstractInstruction
{
    private string $VarFrame;
    private string $VarValue;

    public function execute() :void
    {
        if($this->args[0]->argType === "var")
        {
            $parts = explode("@", $this->args[0]->argValue);
            if (count($parts) !== 2) {
                exit (ReturnCode::SEMANTIC_ERROR);
            }
            $this->VarFrame = $parts[0];
            $this->VarValue = $parts[1];
        }

        $frame = Frame::getInstance();

        if ($this->VarFrame === "GF")
        {
            $frame->addToGF($this->VarValue, "NULL", "NULL");
        }
        else if ($this->VarFrame === "LF")
        {
            $frame->addToLF($this->VarValue, "NULL", "NULL");
        }
        if ($this->VarFrame === "TF")
        {
            $frame->addToTF($this->VarValue, "NULL", "NULL");
        }
    }

}