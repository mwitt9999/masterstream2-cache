<?php

namespace Salestreamsoft\Cache\Application;

use Predis;

/**
 * Class PredisCacheService
 * @package Salestreamsoft\Cache\Application
 */
class PredisCacheService implements CacheServiceInterface
{
    /**
     * @var Predis\Client
     */
    private $client;

    /**
     * PredisCacheService constructor.
     */
    public function __construct(){
        $redisHost = getenv('REDIS_HOST');
        $redisPort = getenv('REDIS_PORT');

        $predisConfig = [
            'scheme' => 'tcp',
            'host'   => $redisHost,
            'port'   => $redisPort,
        ];

        $this->client = new Predis\Client($predisConfig);
    }

    /**
     * @param $key
     * @return value from cache for $key
     * else return false if $key does not exist
     */

    public function getKey($key){
        if(!self::checkKeyExists($key))
            return false;

        return $this->client->get($key);
    }

    /**
     * @param $key
     * @param $value
     * @return 'OK' if set correctly else returns NULL
     */

    public function setKey($key, $value){
        return $this->client->set($key, $value);
    }

    /**
     * @param $key
     * @return returns 1 or 0
     */

    public function checkKeyExists($key){
        return $this->client->exists($key);
    }

    /**
     * @param $key
     * @param $timestamp
     * @return bool|int
     */
    public function setKeyExpireAt($key, $timestamp){
        if(!self::checkKeyExists($key))
            return false;

        return $this->client->expireat($key, $timestamp);
    }

    /**
     * @param $key
     * @param $seconds
     * @return bool|int
     */
    public function setKeyExpire($key, $seconds){
        if(!self::checkKeyExists($key))
            return false;

        return $this->client->expire($key, $seconds);
    }

    /**
     * @param $key
     * @return bool|int
     */
    public function persistKey($key){
        if(!self::checkKeyExists($key))
            return false;

        return $this->client->persist($key);
    }

    /**
     * @param $key
     * @return bool|int
     */
    public function checkKeyRemainingExpiration($key){
        if(!self::checkKeyExists($key))
            return false;

        return $this->client->ttl($key);
    }

}