<?php
require_once('PHPUnit/Autoload.php');
require_once(dirname(__FILE__).'/../LRU.php');

class LRUTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
    }

    public function startsEmpty() {
        $lru = new LRU(1000);
        $this->assertNull($lru->get(1));
    }

    public function testGet() {}

    public function testPut() {}

}
