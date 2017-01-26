<?php

include_once "iMaker.php";
include_once "MusicChanger.php";

class MakeFromPattern extends MusicChanger implements iMaker {
    
    public $patterns;
    public $structure;
    
    public function create() {
        
        $measures = array();
        $pattern_id = 0;
        foreach ($this->patterns as $pattern) {
            if ($pattern->length == 16) {
                $measure = new Measure([new Note([-1], "NORMAL", 16)], $pattern->chords);
                for ($i=0; $i<$pattern->num_notes; $i++) {
                    $measure = $this->addNoteFromSackInMeasure($measure, $pattern->note_sack, 16);
                }
                //$measures[] = $measure;
                foreach($this->structure as $key => $value) {
                    if ($value == $pattern_id) {
                        $measures[$key] = $measure;
                    }
                }
            }
            $pattern_id++;
        }
        
        $part = Part::setMeasures($measures);
        $part->instrument = 1;
        
        return $part;
    }
    
    public function makeChange() {
        
    }
    
    public function isComplete() {
        
    }
    
}

?>