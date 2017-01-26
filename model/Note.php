<?php

class Note {
    
    public $time;
    public $note = array();
    public $effect;
    public $length;
    
    public function __construct($note, $effect, $time, $length) {
        $this->note = $note;
        $this->effect = $effect;
        $this->time = $time;
        $this->length = $length;
    }
}