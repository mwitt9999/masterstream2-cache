<?php

namespace Salestreamsoft\Cache\Application;

interface CacheServiceInterface
{
    public function getKey();

    public function setKey();

    public function checkKeyExists();
}