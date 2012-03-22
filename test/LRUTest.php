<?php
require_once('PHPUnit/Autoload.php');
require_once(dirname(__FILE__).'/../LRU.php');

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

}
