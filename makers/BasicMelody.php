<?php

include_once "iMaker.php";
include_once "MusicChanger.php";

class BasicMelody extends MusicChanger implements iMaker {
    
    public $counter = 0;
    
    public function create() {
        $measures = array();
        $offset = 0;
        for ($i=0; $i<4; $i++) {
            $notes = array();
            for ($j=0; $j<4; $j++) {
                $notes[] = new Note([72+$offset], "NORMAL", 4);
            }
            
            $chords = array();
            $chords[] = new Chord(0, "MAJOR", 16); //+$offset
            
            $measures[] = new Measure($notes, $chords);
            if ($i == 0) {
                $offset -= 3;
            } else if ($i == 1) {
                $offset -= 4;
            } else if ($i == 2) {
                $offset += 2;
            }
        }
        
        $this->part = Part::setMeasures($measures);
        $this->part->instrument = 1;
        
        for ($i=0; $i<1; $i++) {
            $this->part = $this->changeNoteRandom($this->part);
        }

        while (!$this->isComplete()) {
            $new_change = $this->makeChange();
            if (MusicAnalyzer::getCombinedScore($new_change) > MusicAnalyzer::getCombinedScore($this->part)) {
                $this->part = $new_change; //clone
            }
            $this->counter++;
        }
        
        return $this->part;
    }
    
    public function makeChange() {
        return $this->addNoteRandom($this->part);
    }
    
    public function isComplete() {
        return ($this->counter > 100);
    }
    
}

?>