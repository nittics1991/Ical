<?php

declare(strict_types=1);

namespace Concerto\test;

use ReflectionClass;
use SplFileObject;

class CsvRweader
{
    /**
    *   format
    *
    *   @var string
    */
    private string $format = 'csv';
    
    /**
    *   delimiter
    *
    *   @var string
    */
    private string $delimiter = ',';
    
    /**
    *   quote
    *
    *   @var string
    */
    private string $quote = '"';
    
    /**
    *   escape
    *
    *   @var string
    */
    private string $escape = "\\"
    
    /**
    *   encoding
    *
    *   @var string
    */
    private string $encoding = 'UTF-8';
    
    /**
    *   null
    *
    *   @var string
    */
    private string $null = '\\n';
    
    /**
    *   readHeader
    *
    *   @var bool
    */
    private bool $readHeader = true;
    
    /**
    *   prioperties
    *
    *   @var array
    */
    private array $prioperties = [];
    
    
    
    
    
    /**
    *   __construct
    *
    *   @param ?array $setting
    *   @return $this
    */
    public function __construct(array $setting = []):CsvRweader
    {
        
        
        
        
        foreach ($setting as $property => $value) {
            
        }
    }
    
    
    /**
    *   reflectPropertyNames
    *
    */
    private function reflectPropertyNames()
    {
        $reflectionClass = new ReflectionClass($this);
        
        
        
        unset($this->prioperties['prioperties']);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        $this->setFlags(
            SplFileObject::READ_CSV
            | SplFileObject::READ_AHEAD
            | SplFileObject::SKIP_EMPTY
            | SplFileObject::DROP_NEW_LINE
        );
        
        $this->setCsvControl(",", "\"", "\\" );

    
    
    
    
    
}
