<?php

class NewIntro extends MusicChanger implements iMaker {
  
    public function create() {
        $measures = array();
        for ($i=0; $i<4; $i++) {
            $notes = array();
            for ($j=0; $j<4; $j++) {
                $notes[] = new Note([60], "NORMAL", $j*4, 4);
            }
            
            //$chords = array();
            //$chords[] = new Chord(0, "MAJOR", 16);
            
            $chords = array();
            $chords[] = new Chord(0, "MAJOR", 16);
            
            $measures[] = new Measure($notes, $chords);
        }
        
        $part = Part::setMeasures($measures);
        $part->instrument = 1;
        
        return $part;
    }
    
    public function isComplete() {
        
    }
    
    public function makeChange() {
        
    }
  
    
}

?>