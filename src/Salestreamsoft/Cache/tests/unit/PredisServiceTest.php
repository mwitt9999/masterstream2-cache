<?php

use Salestreamsoft\Cache\Application\PredisCacheService as CacheService;

/**
 * Class PredisServiceTest
 */
class PredisServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;


    /**
     * @var Predis\Client
     */
    private $predis;
    /**
     * @var
     */
    private $cacheService;

    /**
     * PredisServiceTest constructor.
     */
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

    /**
     *
     */
    protected function _before()
    {
        $this->predis->flushall();
        $this->cacheService = new CacheService();
    }

    /**
     *
     */
    protected function _after()
    {
        $this->predis->flushall();
    }

    /**
     *
     */
    public function testCheckKeyExistsWithUnsetKeyAssertFalse()
    {
        $result = $this->cacheService->checkKeyExists(NULL);
        $this->assertEquals($result, 0);
    }

    /**
     *
     */
    public function testCheckKeyExistsWithSetKeyAssertTrue()
    {
        $result = $this->cacheService->setKey('test_key', 'test_value');
        $this->assertEquals($result, 'OK');

        $result = $this->cacheService->checkKeyExists('test_key');
        $this->assertEquals($result, 1);
    }

    /**
     *
     */
    public function testSetKeyAssertOk(){
        $result = $this->cacheService->setKey('test_key', 'test_value');
        $this->assertEquals($result, 'OK');
    }

    /**
     *
     */
    public function testGetKeyWithUnsetKeyAssertFalse()
    {
        $result = $this->cacheService->getKey('test_key');
        $this->assertFalse($result);
    }

    /**
     *
     */
    public function testGetKeyWithSetKeyAssertSetKeysValue()
    {
        $this->cacheService->setKey('test_key', 'test_value');

        $result = $this->cacheService->getKey('test_key');
        $this->assertEquals($result, 'test_value');
    }
}
