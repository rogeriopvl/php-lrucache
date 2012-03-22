<?php
require_once('PHPUnit/Autoload.php');
require_once(dirname(__FILE__).'/../LRUCache.php');

class LRUCacheTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->lru = new LRUCache(1000);
    }

    public function testStartsEmpty() {
        $this->assertNull($this->lru->get(1));
    }

    public function testPut() {}

    public function testGet() {
        $key = 'key1';
        $data = 'content for key1';
        $this->lru->put($key, $data);
        $this->assertEquals($this->lru->get($key), $data);
    }

    public function testMultipleGet() {
        $key = 'key1';
        $data = 'content for key1';
        $key2 = 'key2';
        $data2 = 'content for key2';

        $this->lru->put($key, $data);
        $this->lru->put($key2, $data2);

        $this->assertEquals($this->lru->get($key), $data);
        $this->assertEquals($this->lru->get($key2), $data2);
        
    }

}
