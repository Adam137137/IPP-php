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

    public function addToGF(string $name, string $type, string $value, bool $creation) :void
    {
        if(!isset($this->frameGF[$name]) || ($creation === false))
        {
            $this->frameGF[$name] = [$type, $value];
        }
        else
        {
            exit(ReturnCode::SEMANTIC_ERROR);   
        }
    }

    public function addToLF(string $name, string $type, string $value, bool $creation) :void
    {
        if(!isset($this->frameLF[$name]) || ($creation === false))
        {
            $this->frameLF[$name] = [$type, $value];
        }
        else
        {
            exit(ReturnCode::SEMANTIC_ERROR);
        }
    }
    public function addToTF(string $name, string $type, string $value, bool $creation) :void
    {
        if(!isset($this->frameTF[$name]) || ($creation === false))
        {
            $this->frameTF[$name] = [$type, $value];
        }
        else
        {
            exit(ReturnCode::SEMANTIC_ERROR);
        }
    }
    
}