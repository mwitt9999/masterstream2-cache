<?php

namespace Salestreamsoft\Cache\Application;

/**
 * Interface CacheServiceInterface
 * @package Salestreamsoft\Cache\Application
 */

interface CacheServiceInterface
{
    /**
     * @param $key
     * @return value from cache for $key
     * else return false if $key does not exist
     */
    public function getKey($key);

    /**
     * @param $key
     * @param $value
     * @return 'OK' if set correctly else returns NULL
     */
    public function setKey($key, $value);

    /**
     * @param $key
     * @param $timestamp
     * @return mixed
     */
    public function setKeyExpireAt($key, $timestamp);

    /**
     * @param $key
     * @param $seconds
     * @return mixed
     */
    public function setKeyExpire($key, $seconds);

    /**
     * @param $key
     * @return returns 1 or 0
     */
    public function checkKeyExists($key);


    /**
     * @param $key
     * @return mixed
     */
    public function checkKeyRemainingExpiration($key);

    /**
     * @param $key
     * @return mixed
     */
    public function persistKey($key);

}