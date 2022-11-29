<?php

namespace App;

class Customer {
    private $name;
    private $age;

    public function setName($name) {
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function getAge() {
        return $this->age;
    }

    public function nameWithAge() {
        return "name: {$this->getName()} / age: {$this->getAge()}";
    }

}