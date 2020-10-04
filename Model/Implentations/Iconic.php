<?php

namespace CliApp\Model\Implentations;

use CliApp\Classes\Processor;
use CliApp\Model\Curl;
use CliApp\Model\Product;

/**
 * [Description Iconic]
 * Actual implementation of the decorator
 */
class Iconic extends Curl implements Processor {

    protected $iconic_api;

    protected $pagination = 1000;

    protected $page = 1;

    public function __construct()
    {
        $this->iconic_api = "https://eve.theiconic.com.au";

        parent::__construct($this->iconic_api);
    }
    
    /**
     * @return object
     */
    public function processApi() : object {
        
        $params = [
            'gender' => 'female',
            'page' => $this->page,
            'page_size' => $this->pagination,
            'sort' => 'popularity',
        ];
        
        $result = $this->callApi('/catalog/products',$params, "GET");

        if ($result)
        {
            $result = json_decode($result);
        }

        //little bit of processing here
        if (count($result->_embedded->product)){
            $collected_products = [];
            foreach($result->_embedded->product as $product) 
            {                
                //cast it cause it only takes array for now
                $product_data = (array) $product;

                $current_product = new Product($product_data);
                $decorated_product = $this->decorateResults($current_product);

                if ($decorated_product->video_link != "No video Link")
                {
                    //pre-pend to first if there is a video (sorting requirement)
                    array_unshift($collected_products, $decorated_product);                
                } else {
                    $collected_products[] = $decorated_product;                
                }
            }
        }        

        //rebuild and replace the product part of the output
        $result->_embedded->product = $collected_products;
        //end processing

        return $result;
    }

    
    /**
     * @param Product $product
     * 
     * @return Product
     */
    public function decorateResults(Product $product) : Product
    {
        if ($product->video_count > 0)
        {
            $product->setvideo_link(
                $this->iconic_api . "/products/".$product->sku."/videos"
            );
        } else {            
            $product->setvideo_link("No video Link");
        }

        return $product;
    }
    

    /**
     * @param mixed $int
     * 
     * @return [type]
     */
    public function setPagination($int)
    {
        return $this->pagination = $int;
    }

    /**
     * @param mixed $int
     * 
     * @return [type]
     */
    public function setPage($int)
    {
        return $this->page = $int;
    }
}