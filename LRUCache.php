<?php

class LRUCache {

    private $head;
    private $tail;
    private $capacity;
    private $hashmap;

    public function __construct($capacity) {
        $this->capacity = $capacity;
        $this->hashmap = array();
        $this->head = new Node(null);
        $this->tail = new Node(null);

        $this->head->setNext($this->tail);
        $this->tail->setPrevious($this->head);
    }

    public function get($key) {

        if (!isset($this->hashmap[$key])) { return null; }

        $node = $this->hashmap[$key];
        if (count($this->hashmap) == 1) { return $node->getData(); }

        // refresh the access
        $this->detach($node);
        $this->attach($this->head, $node);
    }

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
    }

    private function attach($head, $node) {
        $node->setPrevious($head);
        $node->setNext($head->getNext());
        $node->getNext()->setPrevious($node);
        $node->getPrevious()->setNext($node);
    }

    private function detach($node) {
        $node->getPrevious()->setNext($node->getNext());
        $node->getNext()->setPrevious($node->getPrevious());
    }

}

class Node {

    private $data;
    private $next;
    private $previous;

    public function __construct($data) {
        $this->data = $data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setNext($next) {
        $this->next = $next;
    }

    public function setPrevious($previous) {
        $this->previous = $previous;
    }

    public function getData() {
        return $this->data;
    }

    public function getNext() {
        return $this->next;
    }

    public function getPrevious() {
        return $this->previous;
    }

}
