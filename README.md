# PHP LRU Cache implementation

## Intro

### WTF is a LRU Cache?

LRU stands for Least Recently Used. It's a type of cache that usually has a fixed capacity and discards the oldest entries. This is specially useful if you have the need to control the cache memory usage.

If you want more details about LRU Cache, you can read [this article][0] that explains it pretty well. Also if you want more interesting info, you can read [this great paper on LRU algorithms][1].

### Implementation

This code is in it's early stages. I need to write more tests to find out the possible naive code parts in order to achieve some performance, if any is possible with PHP :P

This implementation is similar to a [LinkedHashMap][2]. Right now I'm just messing around with the code and decided to keep it simple, using a simple associative array as a naive hashmap. 

## Usage

Usage is pretty simple:

    require_once('LRUCache/LRUCache.php');
    
    $cache = new LRUCache(1000);
    
    $cache->put('mykey', 'arrow to the knee');
    
    echo $cache->get('mykey');

You can use the tests to try things like load testing etc.


[0]: http://java-planet.blogspot.pt/2005/08/how-to-set-up-simple-lru-cache-using.html
[1]: http://www.vldb.org/conf/1994/P439.PDF
[2]: http://docs.oracle.com/javase/7/docs/api/java/util/LinkedHashMap.html
