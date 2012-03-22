<?php
require_once('PHPUnit/Autoload.php');
require_once(dirname(__FILE__).'/../LRUCache.php');

class LRUCacheTest extends PHPUnit_Framework_TestCase {

    public function testStartsEmpty() {
        $lru = new LRUCache(1000);
        $this->assertNull($lru->get(1));
    }

    public function testGet() {
        $lru = new LRUCache(1000);
        $key = 'key1';
        $data = 'content for key1';
        $lru->put($key, $data);
        $this->assertEquals($lru->get($key), $data);
    }

    public function testMultipleGet() {
        $lru = new LRUCache(1000);
        $key = 'key1';
        $data = 'content for key1';
        $key2 = 'key2';
        $data2 = 'content for key2';

        $lru->put($key, $data);
        $lru->put($key2, $data2);

        $this->assertEquals($lru->get($key), $data);
        $this->assertEquals($lru->get($key2), $data2);
        
    }

    public function testPut() {}
}
