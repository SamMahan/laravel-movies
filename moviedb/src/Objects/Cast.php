<?php

namespace Samuelm\Moviedb\Objects;

/**
 * This is where I create an object type to represent api JSON I get back
 * @property int $adult 
 * @property string $name
 * @property string $character
 */
class Cast {
    public $name;
    public $character;

    public function __construct($obj) {
        $this->setValue('name', 'name', $obj);
        $this->setValue('character', 'character', $obj);
    }

    public function __set($key, $value) {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
    }

    public function setValue($key, $newKey, $obj) {
        if (property_exists($obj, $key)) $this->__set($newKey, $obj->$key);
    }
}