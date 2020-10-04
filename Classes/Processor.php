<?php

namespace CliApp\Classes;

use CliApp\Model\Product;

/**
 * [Description Processor]
 */
interface Processor 
{

    /**
     * @return object
     */
    public function processApi() : object;

    /**
     * @param Product $object
     * 
     * @return Product
     */
    public function decorateResults(Product $object) : Product;
}
