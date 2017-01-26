<?php

include_once "iMaker.php";
include_once "MusicChanger.php";

class BasicSuggestion extends MusicChanger implements iMaker {
    
    public $counter = 0;
    
    public function create() {
        $measures = array();
        $offset = 0;
        for ($i=0; $i<1; $i++) {
            $notes = array();
            $notes[] = new Note([60], "NORMAL", 16);
            
            $chords = array();
            $chords[] = new Chord(0+$offset, "MAJOR", 16);
            
            $measures[] = new Measure($notes, $chords);
        }
        
        $this->part = Part::setMeasures($measures);
        
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
        return ($this->counter > 10);
    }
    
}

?>