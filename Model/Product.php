<?php

namespace CliApp\Model;

use CliApp\Classes\MagicObjects;

/**
 * [Description Product]
 */
class Product extends MagicObjects {

    /**
     * @param Array $productAttributes
     */
    public function __construct(Array $productAttributes)
    {
        //Example just for this app, it should be strictly defined anyway
        foreach ($productAttributes as $key=>$value)
        {
            $this->$key = $value;
        }
    }



}