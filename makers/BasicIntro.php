<?php

include_once "iMaker.php";
include_once "MusicChanger.php";

class BasicIntro extends MusicChanger implements iMaker {
    
    public function create() {
        $measures = array();
        $offset = 0;
        for ($i=0; $i<4; $i++) {
            $notes = array();
            for ($j=0; $j<4; $j++) {
                $notes[] = new Note([60+$offset], "NORMAL", 4*$j, 4);
            }
            
            //$chords = array();
            //$chords[] = new Chord(0, "MAJOR", 16);
            
            $chords = array();
            $chords[] = new Chord(0+$offset, "MAJOR", 16);
            
            $measures[] = new Measure($notes, $chords);
            
            if ($i == 0) {
                $offset -= 3;
            } else if ($i == 1) {
                $offset -= 4;
            } else if ($i == 2) {
                $offset += 2;
            }
            
            for ($j=0; $j<20; $j++) {
                $sack = [60, 62, 64, 67, 71];
                $measures[$i] = $this->addNoteFromSackInMeasure($measures[$i], $sack); //not quite there yet...
            }
        }
        
        $part = Part::setMeasures($measures);
        $part->instrument = 1;
        
        /*for ($i=0; $i<20; $i++) {
            $part = $this->addNoteRandom($part); //not quite there yet...
        }*/
        
        return $part;
    }
    
    public function isComplete() {
        
    }
    
    public function makeChange() {
        
    }
    
}

?>