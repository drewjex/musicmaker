<?php

include_once "iMaker.php";
include_once "MusicChanger.php";

class BasicBass extends MusicChanger implements iMaker {
    
    public function create() { //Doi Pha Hom Pok National Park.
        $measures = array();
        for ($i=0; $i<8; $i++) {
            $notes = array();
            $notes[] = new Note([48], "NORMAL", 16);
            
            //$chords = array();
            //$chords[] = new Chord(0, "MAJOR", 16);
            
            $chords = array();
            $chords[] = new Chord(0, "MAJOR", 16);
            
            $measures[] = new Measure($notes, $chords);
        }
        
        $part = Part::setMeasures($measures);
        $part->instrument = 33; //14
        
        return $part;
    }
    
    public function isComplete() {
        
    }
    
    public function makeChange() {
        
    }
    
}

?>