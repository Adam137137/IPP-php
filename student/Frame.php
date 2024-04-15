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
    
    // function __construct()
    // {
        
    // }
    public static function getInstance(): Frame
    {
        if (self::$instance === null) {
            self::$instance = new Frame();
        }
        return self::$instance;
    }

    public function addToGF(string $name, string $type, string $value) :void
    {
        if(!isset($this->frameGF[$name]))
        {
            $this->frameGF[$name] = [$type, $value];
        }
        else
        {
            exit(ReturnCode::SEMANTIC_ERROR);
        }
    }

    public function addToLF(string $name, string $type, string $value) :void
    {
        if(!isset($this->frameLF[$name]))
        {
            $this->frameLF[$name] = [$type, $value];
        }
        else
        {
            exit(ReturnCode::SEMANTIC_ERROR);
        }
    }
    public function addToTF(string $name, string $type, string $value) :void
    {
        if(!isset($this->frameTF[$name]))
        {
            $this->frameTF[$name] = [$type, $value];
        }
        else
        {
            exit(ReturnCode::SEMANTIC_ERROR);
        }
    }
    
}