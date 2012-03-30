<?php
require_once('PHPUnit/Autoload.php');
require_once(dirname(__FILE__).'/../LRUCache/LRUCache.php');

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

    public function testPut() {
        $numEntries = 1000;
        $lru = new LRUCache($numEntries);

        $key1 = 'mykey1';
        $value1 = 'myvaluefromkey1';

        $lru->put($key1, $value1);
        $this->assertEquals($lru->get($key1), $value1);
    }

    public function testMassivePut() {
        $numEntries = 90000;
        $lru = new LRUCache($numEntries);

        while($numEntries > 0) {
            $lru->put($numEntries - 899999, 'some value...');
            $numEntries--;
        }
    }

    public function testPutWhenFull() {
        $lru = new LRUCache(3);

        $key1 = 'key1';
        $value1 = 'value1forkey1';
        $key2 = 'key2';
        $value2 = 'value2forkey2';
        $key3 = 'key3';
        $value3 = 'value3forkey3';
        $key4 = 'key4';
        $value4 = 'value4forkey4';

        // fill the cache
        $lru->put($key1, $value1);
        $lru->put($key2, $value2);
        $lru->put($key3, $value3);

        // access some elements more often
        $lru->get($key2);
        $lru->get($key2);
        $lru->get($key3);

        // put a new entry to force cache to discard the oldest
        $lru->put($key4, $value4);

        $this->assertNull($lru->get($key1));
    }
}
