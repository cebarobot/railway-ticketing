<?php 
namespace foundation;

class BaseModel {
    function __construct($data = array()) {
        $this->set($data);
    }

    public function set($data) {
        foreach ($data as $key => $value) $this->{$key} = $value;
    }
}