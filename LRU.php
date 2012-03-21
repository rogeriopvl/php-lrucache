<?php

class LRU {

    private $head;
    private $tail;
    private $capacity;
    private $hashmap;

    public function __construct($capacity) {
        $this->capacity = $capacity;
        $this->hashmap = array();
        $this->head = null;
        $this->tail = null;

        $this->head.setNext($this->tail);
        $this->tail.setPrevious($this->head);
    }

    public function get($key) {
        $node = $this->hashmap[$key];

        if ($node === null) { return null; }
        if (count($this->hashmap) == 1) { return $node->getData(); }

        // refresh the access
        $this->detach($node);
        $this->attach($this->head, $node);
    }

    public function put($key, $data) {}

    private function attach($head, $node) {
        $node->setPrevious($head);
        $node->setNext($head->getNext());
        $node->getNext()->setPrevious(node);
        $node->getPrevious()->setNext(node);
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
