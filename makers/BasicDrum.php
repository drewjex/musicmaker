<?php

include_once "iMaker.php";
include_once "MusicChanger.php";

class BasicDrum extends MusicChanger implements iMaker {
    
    public $measures = 8;
    
    public function create() {
        $measures = array();
        $offset = 0;
        for ($i=0; $i<$this->measures; $i++) {
            $notes = array();
            for ($j=0; $j<2; $j++) {
                $notes[] = new Note([-1], "NORMAL", 4);
                $notes[] = new Note([60], "NORMAL", 4);
                /*$notes[] = new Note([60], "NORMAL", 1);
                $notes[] = new Note([60], "NORMAL", 1);
                $notes[] = new Note([60], "NORMAL", 1);
                $notes[] = new Note([60], "NORMAL", 1);
                $notes[] = new Note([60], "NORMAL", 1);
                $notes[] = new Note([60], "NORMAL", 1);
                $notes[] = new Note([60], "NORMAL", 1);
                $notes[] = new Note([60], "NORMAL", 1);*/
            }
                       
            $measures[] = new Measure($notes, $chords);
            
        }
        
        $part = Part::setMeasures($measures);
        $part->instrument = 127; //10 //99
       // $part->is_drum = true; //39

        return $part;
    }
    
    public function isComplete() {
        
    }
    
    public function makeChange() {
        
    }
    
}

?>