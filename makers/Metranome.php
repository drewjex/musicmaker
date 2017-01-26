<?php

include_once "iMaker.php";
include_once "MusicChanger.php";

class Metranome extends MusicChanger implements iMaker {
    
    public $measures = 4;
    
    public function create() {
        $measures = array();
        $offset = 0;
        for ($i=0; $i<$this->measures; $i++) {
            $notes = array();
            for ($j=0; $j<4; $j++) {
                $notes[] = new Note([60], "NORMAL", 4*$j, 4);
            }
                       
            $measures[] = new Measure($notes, $chords);
            
        }
        
        $part = Part::setMeasures($measures);
        $part->instrument = 117; //10 //99

        return $part;
    }
    
    public function isComplete() {
        
    }
    
    public function makeChange() {
        
    }
    
}

?>