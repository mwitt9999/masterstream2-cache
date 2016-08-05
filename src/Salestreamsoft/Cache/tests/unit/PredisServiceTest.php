<?php

use Predis;
use Salestreamsoft\Cache\Application\PredisCacheService as CacheService;

class PredisServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;


    private $predis;

    public function __construct(){
        $redisHost = getenv('REDIS_HOST');
        $redisPort = getenv('REDIS_PORT');

        $predisConfig = [
            'scheme' => 'tcp',
            'host'   => $redisHost,
            'port'   => $redisPort,
        ];

        $this->predis = new Predis\Client($predisConfig);
    }

    protected function _before()
    {
        $this->predis->flushall();
    }

    protected function _after()
    {
        $this->predis->flushall();
    }

    // tests
    public function testMe()
    {
        $cacheService = new CacheService();
        var_dump('here');exit;

        $result = $cacheService->checkKeyExists(NULL);
        $this->assertEquals($result, 0);

        $result = $cacheService->getKey('test_key');
        $this->assertFalse($result);

        $result = $cacheService->setKey('test_key', 'test_value');
        $this->assertEquals($result, 'OK');

        $result = $cacheService->getKey('test_key');
        $this->assertEquals($result, 'test_value');


    }
}