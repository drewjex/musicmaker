<?php

include_once "iMaker.php";
include_once "MusicChanger.php";

class RepetetiveMelody extends MusicChanger implements iMaker {
    
    public function create() {
        $measures = array();
        $notes = array();
        $offset = 0;
        for ($j=0; $j<4; $j++) {
            $notes[] = new Note([60], "NORMAL", 4*$j, 4);
        }
        $chords = array();
        $chords[] = new Chord(0, "MAJOR", 16);
        
        $measure = new Measure($notes, $chords);
        for ($i=0; $i<3; $i++) {
            $measure = $this->addNoteFromSackInMeasure($measure, [60]);
        }
        for ($i=0; $i<4; $i++) {
            $measure = clone $measure;
                        
            $chords = array();
            $chords[] = new Chord(0+$offset, "MAJOR", 16);
            
            $measure->chords = $chords;
            for ($j=0; $j<count($measure->notes); $j++) {
                foreach ($measure->notes[$j]->note as $key => $value) {
                    $measure->notes[$j]->note[$key] = 60 + $offset;
                }
            }
            
            if ($i == 0) {
                $offset -= 3;
            } else if ($i == 1) {
                $offset -= 4;
            } else if ($i == 2) {
                $offset += 2;
            }
            
            $measures[] = $measure;
        }
        //$measures[] = new Measure($notes, $chords);
        
        /*while (count($measures) < 4) {
            $prev_measures = clone $measures;
            $prev_score = MusicAnalyzer::getScoreMeasures($measures);
            $measures = $this->makeChange($measures);
            $new_score = MusicAnalyzer::getScoreMeasures($measures);
        }*/
        
        /*for ($i=0; $i<4; $i++) {
            $notes = array();
            for ($j=0; $j<4; $j++) {
                $notes[] = new Note([60], "NORMAL", 4*$j, 4);
            }
            
            $chords = array();
            $chords[] = new Chord(0, "MAJOR", 16);
            
            $measures[] = new Measure($notes, $chords);
            
            for ($j=0; $j<20; $j++) {
                $sack = [60, 62, 64, 67, 71];
                $measures[$i] = $this->addNoteFromSackInMeasure($measures[$i], $sack); //not quite there yet...
            }
        }*/
        
        $part = Part::setMeasures($measures);
        $part->instrument = 1;
        
        /*for ($i=0; $i<20; $i++) {
            $part = $this->addNoteRandom($part); //not quite there yet...
        }*/
        
        return $part;
    }
    
    public function makeRandomChange($measures) {
        $random = 0; //rand(0, 3);
        $measure_number = rand(0, count($measures)-1);
        switch ($random) {
            case 0:
                $measures[$measure_number] = $this->addNoteFromSackInMeasure($measures[$measure_number], [60]);
            break;
            case 1:
                //$measures[$measure_number] = $this->changeNoteRandomInMeasure($measures[$measure_number]);
            break;
        }
        
        return $measures;
    }
    
    public function isComplete() {
        
    }
    
    public function makeChange() {
        
    }
    
}

?>