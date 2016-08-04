<?php

namespace Salestreamsoft\Cache\Application;

use Predis\Client;

class PredisCacheService implements CacheServiceInterface
{
    private $client;

    public function __construct(){
        $this->client = new Predis\Client();
    }

    public function getKey(){

    }

    public function setKey(){

    }

    public function checkKeyExists(){

    }
}