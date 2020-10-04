<?php

namespace CliApp\Model;

use CliApp\Classes\Http;
use CliApp\Classes\Processor;
use Exception;

class Curl implements Http {

    protected string $_api;

    protected $_curl;

    public function __construct($api)
    {
        $this->_api = $api;
        $this->_curl = curl_init();
    }


    public function getApi() : string {

        return $this->_api;
    }

    public function callApi($route, $query_parameters, $method) : string{

        
        $url = $this->_api . $route;

        curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, TRUE);        

        switch (strtolower($method))  {
            case "post":         
                if (!empty($query_parameters)) {
                    curl_setopt($this->_curl, CURLOPT_URL, $url);
                    curl_setopt($this->_curl, CURLOPT_POSTFIELDS, $this->buildPostData($query_parameters));                    
                }
            break;

            case "get": default:
                $url = $url . "?" . $this->buildGetData($query_parameters);
                curl_setopt($this->_curl, CURLOPT_URL, $url);
            break;
        }

        try {
            $response = curl_exec($this->_curl);
            if ($response === false) {
                throw new Exception(curl_error($this->_curl), curl_errno($this->_curl));
            }
        } catch (Exception $e) {
            echo $e->getCode(), $e->getMessage();
        }

        curl_close($this->_curl);

        return $response;
    }    

    public function buildPostData($params)
    {
        return http_build_query($params);
    }

    public function buildGetData($params)
    {
        return http_build_query($params);
    }
}