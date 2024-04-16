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
    
    public function getFromGF(string $name)
    {
        if(isset($this->frameGF[$name]))
        {
            return $this->frameGF[$name];
        }
        else
        {
            echo "value is not set\n";
            exit(ReturnCode::SEMANTIC_ERROR);   
        }
    }
    public function getFromLF(string $name)
    {
        if(isset($this->frameLF[$name]))
        {
            return $this->frameLF[$name];
        }
        else
        {
            echo "value is not set\n";
            exit(ReturnCode::SEMANTIC_ERROR);   
        }
    }
    public function getFromTF(string $name)
    {
        if(isset($this->frameTF[$name]))
        {
            return $this->frameTF[$name];
        }
        else
        {
            echo "value is not set\n";
            exit(ReturnCode::SEMANTIC_ERROR);   
        }
    }

}