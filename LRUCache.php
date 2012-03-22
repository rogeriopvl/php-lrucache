<?php

/**
 * Class that implements the concept of an LRU Cache
 * using an associative array as a naive hashmap, and a doubly linked list
 * to control the access and insertion order.
 *
 * @author Rogério Vicente
 * @license MIT (see the LICENSE file for details)
 */
class LRUCache {

    // object Node representing the head of the list
    private $head;

    // object Node representing the tail of the list
    private $tail;

    // int the max number of elements the cache supports
    private $capacity;

    // Array representing a naive hashmap (TODO needs to pass the key through a hash function)
    private $hashmap;

    /**
     * @param int $capacity the max number of elements the cache allows
     */
    public function __construct($capacity) {
        $this->capacity = $capacity;
        $this->hashmap = array();
        $this->head = new Node(null);
        $this->tail = new Node(null);

        $this->head->setNext($this->tail);
        $this->tail->setPrevious($this->head);
    }

    /**
     * Get an element with the given key
     * @param string $key the key of the element to be retrieved
     * @return mixed the content of the element to be retrieved
     */
    public function get($key) {

        if (!isset($this->hashmap[$key])) { return null; }

        $node = $this->hashmap[$key];
        if (count($this->hashmap) == 1) { return $node->getData(); }

        // refresh the access
        $this->detach($node);
        $this->attach($this->head, $node);

        return $node->getData();
    }

    /**
     * Inserts a new element into the cache 
     * @param string $key the key of the new element
     * @param string $data the content of the new element
     * @return boolean true on success, false if cache has zero capacity
     */
    public function put($key, $data) {
        if ($this->capacity <= 0) { return false; }
        if (isset($this->hashmap[$key]) && !empty($this->hashmap[$key])) {
            $node = $this->hashmap[$key];
            // update data
            $this->detach($node);
            $this->attach($this->head, $node);
            $node->setData($data);
        }
        else {
            $node = new Node($data);
            $this->hashmap[$key] = $node;
            $this->attach($this->head, $node);

            // check if cache is full
            if (count($this->hashmap) > $this->capacity) {
                // we're full, remove the tail
                $this->detach($this->tail->getPrevious());
                unset($this->hashmap[$key]);
            }
        }
        return true;
    }

    /**
     * Adds a node to the head of the list
     * @param Node $head the node object that represents the head of the list
     * @param Node $node the node to move to the head of the list
     */
    private function attach($head, $node) {
        $node->setPrevious($head);
        $node->setNext($head->getNext());
        $node->getNext()->setPrevious($node);
        $node->getPrevious()->setNext($node);
    }

    /**
     * Removes a node from the list
     * @param Node $node the node to remove from the list
     */
    private function detach($node) {
        $node->getPrevious()->setNext($node->getNext());
        $node->getNext()->setPrevious($node->getPrevious());
    }

}

/**
 * Class that represents a node in a doubly linked list
 */
class Node {

    // the content of the node
    private $data;

    // the next node
    private $next;

    // the previous node
    private $previous;

    /**
     * @param string $data the content of the node
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * Sets a new value for the node data
     * @param string the new content of the node
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * Sets a node as the next node
     * @param Node $next the next node
     */
    public function setNext($next) {
        $this->next = $next;
    }

    /**
     * Sets a node as the previous node
     * @param Node $previous the previous node
     */
    public function setPrevious($previous) {
        $this->previous = $previous;
    }

    /**
     * Returns the node data
     * @return string the content of the node
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Returns the next node
     * @return Node the next node of the node
     */
    public function getNext() {
        return $this->next;
    }

    /**
     * Returns the previous node
     * @return Node the previous node of the node
     */
    public function getPrevious() {
        return $this->previous;
    }

}
