<?php

namespace CliApp\Classes;

interface Http 
{

    public function getApi() : string;

    public function callApi($route, $parameters, $method) : string;

    public function buildPostData($params);
    
    public function buildGetData($params);

}
