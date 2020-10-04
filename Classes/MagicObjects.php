<?php
namespace CliApp\Classes;

/**
 * [Description MagicObjects]
 */
abstract class MagicObjects {
    public function __call($methodName, $args) {
        $variable = substr($methodName, 3); 
        switch (substr($methodName, 0, 3))
        {
            case 'get':
                return $this->$variable;
            break;
            case 'set':                
                //error suppression and is_array check
                if (!property_exists($this, $variable) || !is_array($this->$variable))
                {
                    $this->$variable = $args[0];
                }                
            break;
        }
    }
}