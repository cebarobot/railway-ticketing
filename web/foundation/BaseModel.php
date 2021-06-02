<?php 
namespace foundation;

class BaseModel {
    function __construct($data) {
        $this->set($data);
    }

    public function set($data) {
        foreach ($data as $key => $value) $this->{$key} = $value;
    }
}