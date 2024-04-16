<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;

class Frame
{
    private static ?Frame $instance = null;
    /**
     * @var array<string, string>
     */
    private array $frameGF = [];

    /**
     * @var array<string, string>
     */
    private array $frameLF = [];

    /**
     * @var array<string, string>
     */
    private array $frameTF = [];
    
    public static function getInstance(): Frame
    {
        if (self::$instance === null) {
            self::$instance = new Frame();
        }
        return self::$instance;
    }

    public function addToFrame(string $name, string $type, string $value, string $frame, bool $creation) :void
    {
        if ($frame === "GF"){
            if(isset($this->frameGF[$name]) && ($creation === true))
            {
                exit(ReturnCode::SEMANTIC_ERROR);
            }
            $this->frameGF[$name] = [$type, $value];
        }
        else if ($frame === "LF"){
            if(isset($this->frameLF[$name]) && ($creation === true))
            {
                exit(ReturnCode::SEMANTIC_ERROR);
            }
            $this->frameLF[$name] = [$type, $value];
        }
        else if ($frame === "TF"){
            if(isset($this->frameTF[$name]) && ($creation === true))
            {
                exit(ReturnCode::SEMANTIC_ERROR);
            }
            $this->frameTF[$name] = [$type, $value];
        }
    }

    
    public function getFromFrame(string $name, string $frame)
    { 
        if ($frame === "GF")
        {
            if(!isset($this->frameGF[$name]))
            {
                echo "value is not set\n";
                exit(ReturnCode::SEMANTIC_ERROR);   
            }
            return $this->frameGF[$name];
        }
        else if ($frame === "LF")
        {
            if(!isset($this->frameLF[$name]))
            {
                echo "value is not set\n";
                exit(ReturnCode::SEMANTIC_ERROR);   
            }
            return $this->frameLF[$name];
        }
        else if ($frame === "TF")
        {
            if(!isset($this->frameTF[$name]))
            {
                echo "value is not set\n";
                exit(ReturnCode::SEMANTIC_ERROR);   
            }
            return $this->frameTF[$name];
        }
    }
}