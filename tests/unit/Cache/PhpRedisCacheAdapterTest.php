<?php
/**
 * @author @jayS-de <jens.schulze@commercetools.de>
 * @created: 22.01.15, 10:46
 */

namespace Commercetools\Core\Cache;

class PhpRedisCacheAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DoctrineCacheAdapter
     */
    protected $adapter;

    public function setUp()
    {
        if (!extension_loaded('redis')) {
            $this->markTestSkipped(
                'The redis extension is not available.'
            );
        }
        $cache = new \Redis();
        try {
            if (!$cache->connect('localhost')) {
                throw new \RuntimeException('cannot connect to local redis server');
            }
        } catch (\Exception $e) {
            $this->markTestSkipped('cannot connect to local redis server');
        }
        $this->adapter = new PhpRedisCacheAdapter($cache);
        $this->adapter->store('test', ['key' => 'value']);
    }

    public function testHas()
    {
        $this->assertTrue($this->adapter->has('test'));
    }

    public function testHasNot()
    {
        $this->assertFalse($this->adapter->has('test1'));
    }

    public function testFetch()
    {
        $this->assertArrayHasKey('key', $this->adapter->fetch('test'));
    }

    public function testFetchFail()
    {
        $this->assertFalse($this->adapter->fetch('test1'));
    }

    public function testStore()
    {
        $this->assertTrue($this->adapter->store('test2', ['key2' => 'value2']));
    }

    public function testStoreWithLifetime()
    {
        $this->assertTrue($this->adapter->store('test2', ['key2' => 'value2'], 1));
    }

    public function testRemove()
    {
        $this->assertTrue($this->adapter->remove('test'));
    }

    public function testRemoveFail()
    {
        $this->assertFalse($this->adapter->remove('test1'));
    }
}
