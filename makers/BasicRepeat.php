<?php

include_once "iMaker.php";
include_once "MusicChanger.php";

class BasicRepeat extends MusicChanger implements iMaker {
    
    public $sack = array();
    
    public function create() {
        $measures = array();
        $note = new Note([60], "NORMAL", 16);
        $chord = new Chord(0, "MAJOR", 16);
        $notes = array();
        $notes[] = clone $note;
        
        $chords = array();
        $chords[] = clone $chord;
        
        $notes_two = array();
        $notes_two[] = clone $note;
        
        $chords_two = array();
        $chords_two[] = clone $chord;
        
        $measure_one = new Measure($notes, $chords);
        $measure_two = new Measure($notes_two, $chords_two);
        
        /*for ($j=0; $j<10; $j++) {
            $measure_one = $this->addNoteRandomInMeasure($measure_one, 16);
            $measure_two = $this->addNoteRandomInMeasure($measure_two, 16);
        }*/
        
        //$sack = [60, 62, 64, 59, 57, 67];
        $this->sack = [60, 62, 64, 67, 69, 72];
        for ($j=0; $j<6; $j++) {
            $measure_one = $this->addNoteFromSackInMeasure($measure_one, $this->sack, 16);
            $measure_two = $this->addNoteFromSackInMeasure($measure_two, $this->sack, 16);
        }
        
        for ($i=0; $i<4; $i++) {            
            $measures[] = $measure_one;
            $measures[] = $measure_two;
        }
        
        $part = Part::setMeasures($measures);
        $part->instrument = 1;
        
        /*for ($i=0; $i<20; $i++) {
            $part = $this->addNoteRandom($part);
        }*/
        
        return $part;
    }
    
    public function makeChange() {
        return $this->addNoteRandom($this->part);
    }
    
    public function isComplete() {
        return ($this->counter > 100);
    }
    
}

?>