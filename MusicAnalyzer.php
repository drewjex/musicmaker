<?php
class MusicAnalyzer {
    
    public function __construct() {}
    
    public static function getCombinedScore($part) {
        $score = 0;
		$increment_length = 1;
		while ($increment_length <= $part->time_increment) { //!=
			$part_sections_rhythm = array();
            $part_sections_notes = array();
			$measure_number = 0;
			$initial_note = null;
			foreach ($part->measures as $measure) {
				foreach ($measure->notes as $note) {
					$pointer = ($measure_number*$part->time_increment) + $note->time;
					$list_number = floor($pointer / $increment_length);
					$position_number = $pointer % $increment_length;
					
					if (count($part_sections_notes[$list_number]) == 0) {
						$part_sections_notes[$list_number][$position_number] = 0;
						$initial_note = $note->note[0];
					} else {
						$current_note_diff = abs($note->note[0] - $initial_note);
						$part_sections_notes[$list_number][$position_number] = $current_note_diff;
					}	
					
					$part_sections_rhythm[$list_number][$position_number] = 1;
				}
				$measure_number++;
			}
            /*echo "<pre>"; 
            print_r($part_sections_rhythm); 
            echo "</pre>";*/
			while (!empty($part_sections_rhythm)) {
				$current_section_rhythm = array_shift($part_sections_rhythm); //$part_sections_rhythm[0];
				$current_section_notes = array_shift($part_sections_notes); //$part_sections_notes[0];
                foreach ($part_sections_rhythm as $key => $value) { // => $value
					if (($value === $current_section_rhythm) && in_array(1, $current_section_rhythm)) {
						$score += pow($increment_length, 2); //so it rewards bigger matches of patterns
						if ($part_sections_notes[$key] === $current_section_notes) {
							$score += pow($increment_length, 2);
						}
                        unset($part_sections_rhythm[$key]);
                        unset($part_sections_notes[$key]);
					} 
				}
			}
			
			//echo "Score after time increment of ".$increment_length." is: ".$score.".";
			$increment_length *= 2;
		}
		return $score;
    }
	
	public static function getScoreMeasures($measures, $time_increment=16) {
        $score = 0;
		$increment_length = 1;
		while ($increment_length <= $time_increment) { //!=
			$part_sections_rhythm = array();
            $part_sections_notes = array();
			$measure_number = 0;
			$initial_note = null;
			foreach ($measures as $measure) {
				foreach ($measure->notes as $note) {
					$pointer = ($measure_number*$part->time_increment) + $note->time;
					$list_number = floor($pointer / $increment_length);
					$position_number = $pointer % $increment_length;
					
					if (count($part_sections_notes[$list_number]) == 0) {
						$part_sections_notes[$list_number][$position_number] = 0;
						$initial_note = $note->note[0];
					} else {
						$current_note_diff = abs($note->note[0] - $initial_note);
						$part_sections_notes[$list_number][$position_number] = $current_note_diff;
					}	
					
					$part_sections_rhythm[$list_number][$position_number] = 1;
				}
				$measure_number++;
			}
            /*echo "<pre>"; 
            print_r($part_sections_rhythm); 
            echo "</pre>";*/
			while (!empty($part_sections_rhythm)) {
				$current_section_rhythm = array_shift($part_sections_rhythm); //$part_sections_rhythm[0];
				$current_section_notes = array_shift($part_sections_notes); //$part_sections_notes[0];
                foreach ($part_sections_rhythm as $key => $value) { // => $value
					if (($value === $current_section_rhythm) && in_array(1, $current_section_rhythm)) {
						$score += pow($increment_length, 2); //so it rewards bigger matches of patterns
						if ($part_sections_notes[$key] === $current_section_notes) {
							$score += pow($increment_length, 2);
						}
                        unset($part_sections_rhythm[$key]);
                        unset($part_sections_notes[$key]);
					} 
				}
			}
			
			//echo "Score after time increment of ".$increment_length." is: ".$score.".";
			$increment_length *= 2;
		}
		return $score;
    }
	
	public static function cmp($a, $b) {
		if ($a->time == $b->time) {
			return 0;
		}
		return ($a->time < $b->time) ? -1 : 1;
	}
	
	/*
	 * 1. Get this function complete, then do patterns, and then try and generate a similar to song to midi files. If time, also look at different midi files to see how they are parsed and research mp3 to midi converters.
	 */ 
	
	public static function getSimilarity($measure1, $measure2) { 
		$score = 0;
		
		$copy = clone $measure1; //NOT TRULY A DEEP CLONE - CAUSING ISSUES
		
		/*foreach ($copy->notes as $note) {
			echo $note->time;
			echo "<br>";
		}
		echo "______________<br>";
		foreach ($measure2->notes as $note) {
			echo $note->time;
			echo "<br>";
		}
		
		echo "---------------------------------------------------------<br><br>";*/
				
		foreach ($copy->notes as $key => $note1) {
			$count = 0;
			foreach ($measure2->notes as $note2) {
				if ($note1->time == $note2->time) {
					if ($note1->note !== $note2->note) {
						$note1->note = $note2->note;
						$score++;
					}
					if ($note1->length !== $note2->length) {
						$note1->length = $note2->length;
						$score++;
					}		
					break;
				} else if ($note2->time > $note1->time || $count == count($measure2->notes)-1) {
					//doesn't exist
					//delete it
					unset($copy->notes[$key]);
					$score++;
				} 
				$count++;
			}
		}
		
		/*foreach ($copy->notes as $note) {
			echo $note->time;
			echo "<br>";
		}
		echo "______________<br>";
		foreach ($measure2->notes as $note) {
			echo $note->time;
			echo "<br>";
		}
		
		echo "---------------------------------------------------------<br><br>";*/
			
		if (count($copy->notes) != count($measure2->notes)) {
			foreach ($measure2->notes as $note2) {
				$found = false;
				foreach ($copy->notes as $note1) {
					if ($note1->time == $note2->time) {
						$found = true;
						break;
					}
				}
				if (!$found) {
					$copy->notes[] = clone $note2;
					$score++;
				}
			}
		}
		
		//usort($copy->notes, array("MusicAnalyzer", "cmp"));
		
		/*foreach ($copy->notes as $note) {
			echo $note->time;
			foreach ($note->note as $n) {
				echo $n."<br>";
			}
			echo "<br>";
		}
		echo "______________<br>";
		foreach ($measure2->notes as $note) {
			echo $note->time;
			foreach ($note->note as $n) {
				echo $n."<br>";
			}
			echo "<br>";
		}
		
		var_dump($copy->notes);
		echo "<br>------------------<br>";
		var_dump($measure2->notes);*/
		
		return $score;
	}

	public static function getSimilarityNoOctave($measure1, $measure2) { 
		$score = 0;
		
		$copy = clone $measure1; //NOT TRULY A DEEP CLONE - CAUSING ISSUES
		
		/*foreach ($copy->notes as $note) {
			echo $note->time;
			echo "<br>";
		}
		echo "______________<br>";
		foreach ($measure2->notes as $note) {
			echo $note->time;
			echo "<br>";
		}
		
		echo "---------------------------------------------------------<br><br>";*/
				
		foreach ($copy->notes as $key => $note1) {
			$count = 0;
			foreach ($measure2->notes as $note2) {
				if ($note1->time == $note2->time) {
					if (($note1->note % 12) !== ($note2->note % 12)) {
						$note1->note = $note2->note;
						$score++;
					}
					if ($note1->length !== $note2->length) {
						$note1->length = $note2->length;
						$score++;
					}		
					break;
				} else if ($note2->time > $note1->time || $count == count($measure2->notes)-1) {
					//doesn't exist
					//delete it
					unset($copy->notes[$key]);
					$score++;
				} 
				$count++;
			}
		}
		
		/*foreach ($copy->notes as $note) {
			echo $note->time;
			echo "<br>";
		}
		echo "______________<br>";
		foreach ($measure2->notes as $note) {
			echo $note->time;
			echo "<br>";
		}
		
		echo "---------------------------------------------------------<br><br>";*/
			
		if (count($copy->notes) != count($measure2->notes)) {
			foreach ($measure2->notes as $note2) {
				$found = false;
				foreach ($copy->notes as $note1) {
					if ($note1->time == $note2->time) {
						$found = true;
						break;
					}
				}
				if (!$found) {
					$copy->notes[] = clone $note2;
					$score++;
				}
			}
		}
		
		//usort($copy->notes, array("MusicAnalyzer", "cmp"));
		
		/*foreach ($copy->notes as $note) {
			echo $note->time;
			foreach ($note->note as $n) {
				echo $n."<br>";
			}
			echo "<br>";
		}
		echo "______________<br>";
		foreach ($measure2->notes as $note) {
			echo $note->time;
			foreach ($note->note as $n) {
				echo $n."<br>";
			}
			echo "<br>";
		}
		
		var_dump($copy->notes);
		echo "<br>------------------<br>";
		var_dump($measure2->notes);*/
		
		return $score;
	}

	public static function getChordValues($notes) {
		if (count($notes) < 2 && count($notes[0]->note) < 2)
			return null;

		//bass note is the most important
		$root = self::getRootNote($notes);

		$values = array();
		foreach ($notes as $note) {
			//get everything in same octave - just do lowest for convenience
			foreach ($note->note as $note_values) {
				$values[] = $note_values % 12; //% 12; //this also ensures that it's always in order!
			}
		}
		
		//in order from smallest to biggest
		sort($values);

		//before killing duplicates, we want to find the most common notes and keep only those (max = 4, min = 2)
		$count = array_count_values($values);
		asort($count);
		//var_dump($count);
		//$maxs = array_keys($count, max($count));
		//echo $maxs[0];

		//see how big $count is. If 2, 3, or 4 return

		if (count($count) > 1 && count($count) < 5)
			return array_unique($values);


		
		//kills duplicates...do we really want this?
		$values = array_unique($values);

		//reset array
		$values = array_values($values);

		return $values; //(multiply by 12 to get good octave)
	}

	public static function getChordValuesOctave($notes) {
		if (count($notes) < 2 && count($notes[0]->note) < 2)
			return null;

		//bass note is the most important
		$root = self::getRootNote($notes);

		$values = array();
		foreach ($notes as $note) {
			//get everything in same octave - just do lowest for convenience
			foreach ($note->note as $note_values) {
				$values[] = $note_values % 12; //% 12; //this also ensures that it's always in order!
			}
		}
		
		//in order from smallest to biggest
		sort($values);

		//before killing duplicates, we want to find the most common notes and keep only those (max = 4, min = 2)
		$count = array_count_values($values);
		asort($count);
		//var_dump($count);
		//$maxs = array_keys($count, max($count));
		//echo $maxs[0];

		//see how big $count is. If 2, 3, or 4 return

		if (count($count) > 1 && count($count) < 5) {
			$values = array_unique($values);
			$new_values = array();
			foreach ($values as $v) {
				$new_values[] = $v+60;
			}
			return $new_values;
		}


		
		//kills duplicates...do we really want this?
		$values = array_unique($values);

		//reset array
		$values = array_values($values);

		$new_values = array();
			foreach ($values as $v) {
				$new_values[] = $v+60;
			}

		return $new_values; //(multiply by 12 to get good octave)
	}
	
	public static function getChordName($notes) {
		//make sure there are at least 2 notes
		if (count($notes) < 2)
			return false;
		//bass note is the most important
		$values = array();
		foreach ($notes as $note) {
			//get everything in same octave - just do lowest for convenience
			foreach ($note->note as $note_values) {
				$values[] = $note_values % 12; //% 12; //this also ensures that it's always in order!
			}
		}
		
		//in order from smallest to biggest
		sort($values);
		
		//kills duplicates...do we really want this?
		$values = array_unique($values);

		//reset array
		$values = array_values($values);

		if (count($values) == 2) {
		
		} else if (count($values) == 3) { //take 3 most common notes!! Need to implement!
		
			$intervals = array();
			
			$intervals[] = $values[1] - $values[0];
			$intervals[] = $values[2] - $values[1];

			/*switch ($intervals[0]) {
				case 3:
					if ($intervals[1] == 4) {
						return self::getNoteFromMidi($values[0])." MINOR";
					} else if ($intervals[1] == 3) {
						return self::getNoteFromMidi($values[0])." DIMINISHED";
					}  
				break;
				case 4:
					if ($intervals[1] == 3) {
						return self::getNoteFromMidi($values[0])." MAJOR";
					} else if ($intervals[1] == 4) {
						return self::getNoteFromMidi($values[0])." AUGMENTED";
					}
				break;
			}*/
			
			switch ($intervals[0]) {
				case 3:
					if ($intervals[1] == 3) {
						return self::getNoteFromMidi($values[0])." DIMINISHED";
					} else if ($intervals[1] == 4) {
						return self::getNoteFromMidi($values[0])." MINOR";
					} else if ($intervals[1] == 5) {
						return self::getNoteFromMidi($values[2])." MAJOR";
					} else if ($intervals[1] == 6) {
						return self::getNoteFromMidi($values[2])." DIMINISHED";
					}
				break;
				case 4:
					if ($intervals[1] == 3) {
						return self::getNoteFromMidi($values[0])." MAJOR";
					} else if ($intervals[1] == 4) {
						return self::getNoteFromMidi($values[0])." AUGMENTED";
					} else if ($intervals[1] == 5) {
						return self::getNoteFromMidi($values[2])." MINOR";
					} 
				break;
				case 5:
					if ($intervals[1] == 3) {
						return self::getNoteFromMidi($values[1])." MINOR";
					} else if ($intervals[1] == 4) {
						return self::getNoteFromMidi($values[1])." MAJOR";
					} 
				break;
				case 6:
					return self::getNoteFromMidi($values[1])." DIMINISHED";
				break;
			}
			
		} else if (count($values) == 4) { //take 4 most common notes
			
		}
		
		return $values;
	}

	public static function getNoteFromMidi($midi) {
		$octave = ($midi / 12) - 1;
		$note = substr("C C#D D#E F F#G G#A A#B ",($midi % 12) * 2, 2);
		return $note;
	}
	
	//this will get all notes being played (regardless of when the note was started) at specified time
	//goes back current measure only.
	public static function getAllNotesAtTime($song, $section_number, $measure_number, $time) {
		$overlapping_notes = array();
		foreach ($song->structure as $track) {
			$part_number = $track[$section_number];
			$measure = $song->parts[$part_number]->measures[$measure_number];
			foreach ($measure->notes as $note) {
				//get all overlapping notes in measure
				if ($note->time <= $time && $note->time+$note->length > $time) {
					//it overlaps
					$overlapping_notes[] = clone $note;
					/*foreach ($note->note as $note_value) {
						$overlapping_notes[] = $note_value;
					}*/
				}
			}
		}
		
		return $overlapping_notes;
	}

	//i want to be able to convert this to a song and play it.
	//the problem here is that at the interval, only one note may be playing, but it could be part of a larger chord progression...
	//so do we take the previous chord progression into account..?
	//i'll have to start at beginning of song and just look at each chord at every moment and change when it changes!
	public static function getChordProgression($song, $increment=16) {
		//foreach 
		$chords = array();

		$section_number = 0;
		$measure_number = 0;
		$time = 0;

		while ($section_number < count($song->structure[0])) {
			while ($measure_number <= count($song->parts[$song->structure[0][$section_number]]->measures) - 1) {
				$notes = self::getAllNotesAtTime($song, $section_number, $measure_number, $time);	
				/*echo "<br><br>";
				var_dump($notes);
				echo "<br><br>";*/
				$chords[] = self::getChordValues($notes);
				$measure_number++;
			}
			$section_number++;
		}

		return $chords;

		/*foreach ($song->structure as $track) {
			foreach ($track as $part_index) {
				//$chords
			}
		}*/
	}

	public static function getChordProgressionPlusRoot($song, $increment=16) {
		//foreach 
		$object = new stdClass();
		$roots = array();
		$chords = array();

		$section_number = 0;
		$measure_number = 0;
		$time = 0;

		while ($section_number < count($song->structure[0])) {
			while ($measure_number <= count($song->parts[$song->structure[0][$section_number]]->measures) - 1) {
				$notes = self::getAllNotesAtTime($song, $section_number, $measure_number, $time);	
				/*echo "<br><br>";
				var_dump($notes);
				echo "<br><br>";*/
				$chords[] = self::getChordValues($notes);
				$roots[] = self::getRootNote($notes);
				$measure_number++;
			}
			$section_number++;
		}

		$object->chords = $chords;
		$object->roots = $roots;

		return $object;

		/*foreach ($song->structure as $track) {
			foreach ($track as $part_index) {
				//$chords
			}
		}*/
	}

	public static function getRootNote($notes) { //maybe should only return if there is only one note (has to be at least 2)
		$lowest = null;
		if (count($notes) < 2 && count($notes[0]->note) < 2)
			return -1;
		//if (count($notes[0]->note) < 2)
		//	return -1;
		foreach ($notes as $note) {
			foreach ($note->note as $note_values) {
				if ($note_values < $lowest || $lowest == null)
					$lowest = $note_values;
			}
		}

		return $lowest;
	}

	public static function getChordProg($song, $increment=1) {
		$root = array();

		$section_number = 0;
		$measure_number = 0;
		$time = 0;
		$current_note = null;

		while ($section_number < count($song->structure[0])) {
			while ($measure_number < count($song->parts[$song->structure[0][$section_number]]->measures)) {
				while ($time < 16) {
					$notes = self::getAllNotesAtTime($song, $section_number, $measure_number, $time);	
					/*echo "<br><br>";
					var_dump($notes);
					echo "<br><br>";*/
					$root[] = self::getRootNote($notes);
					$time++;
				}
				$measure_number++;
				$time = 0;
			}
			$section_number++;
		}

		return $root;

	}

	public static function getChordProgPlusRoot($song, $increment=1) {
		$object = new stdClass();
		$chords = array();
		$roots = array();

		$section_number = 0;
		$measure_number = 0;
		$time = 0;
		$current_note = null;

		while ($section_number < count($song->structure[0])) {
			while ($measure_number < count($song->parts[$song->structure[0][$section_number]]->measures)) {
				while ($time < 16) {
					$notes = self::getAllNotesAtTime($song, $section_number, $measure_number, $time);	
					/*echo "<br><br>";
					var_dump($notes);
					echo "<br><br>";*/
					$chords[] = self::getChordValuesOctave($notes);
					$roots[] = self::getRootNote($notes);
					$time++;
				}
				$measure_number++;
				$time = 0;
			}
			$section_number++;
		}

		$object->roots = $roots;
		$object->chords = $chords;

		return $object;

	}

	public static function getChordProgTwo($song, $increment=1) {
		$roots = array();

		$section_number = 0;
		$measure_number = 0;
		$time = 0;
		$current_note = null;

		while ($section_number < count($song->structure[0])) {
			while ($measure_number < count($song->parts[$song->structure[0][$section_number]]->measures)) {
				while ($time < 16) {
					$notes = self::getAllNotesAtTime($song, $section_number, $measure_number, $time);	
					/*echo "<br><br>";
					var_dump($notes);
					echo "<br><br>";*/
					$root = self::getRootNote($notes);
					if ($root != $current_note) {
						$current_note = $root;
						$roots[] = $current_note;
					} else {
						//$roots[] = 
					}
					//$root[] = self::getRootNote($notes);
					$time++;
				}
				$measure_number++;
				$time = 0;
			}
			$section_number++;
		}

		return $root;

	}
	
	public static function getChords($song) {
		//structure[track][time_period_in_track]
		$chords = array();
		
		$track_number = 0;
		$measure_number = 0;
		$time = 0;
		
		$notes = array();
		foreach ($this->song->structure as $track) {
			$track_number = $this->music_player->newTrack() - 1;
			foreach ($track as $part_index) {
				if ($part_index < 0) {
                    $part = Part::emptyPart();
                    for ($i=0; $i<abs($part_index); $i++) {
                        $part->measures[] = new Measure();
                    }
                } else {
                    $part = $this->song->parts[$part_index];
                }
			}	
		}
		
		return $chords;
	}
	
	//we need to keep track of these patterns across all parts! (think Celebration)
	//should i have a note-analyzer that looks at notes and decides the appropriate chord for that section?
	public static function getPatterns($part, $pattern_length=16) { //should includes notes, chords, repetition patterns, common rhythms and note-lengths, and song structure.
		$object = new stdClass();
		$patterns = array();
		$structure = array();
		if ($part->time_increment == $pattern_length) {
			$measures = $part->measures;
			while (!empty($measures)) {
				$next = self::array_shift_assoc_kv($measures);
				reset($next);
				$current_key = key($next);
				$current_measure = $next[$current_key];
				$pattern = new Pattern();
				$pattern->length = $pattern_length;
				$pattern->chords = $current_measure->chords; //here, use getChordValues()
				$pattern->num_notes = count($current_measure->notes);
				foreach ($current_measure->notes as $note) {
					$pattern->note_sack[] = $note->note[0];
				}
				$patterns[] = $pattern;
				$pattern_id = count($patterns)-1;
				$structure[$current_key] = $pattern_id; 
				foreach ($measures as $key => $value) {
					/*var_dump($current_measure);
					echo "<br><br>";
					echo "<br>HI".$key." ".$current_key." ".$pattern_id." ".self::getSimilarity($current_measure, $value)."<br>";
					echo "<br><br>";
					var_dump($current_measure);
					echo "<br><br>";*/
					if (self::getSimilarity($current_measure, $value) < 4) { //also need to look across octaves, right? - haven't done that yet
						//echo "<br>HELLO".$key." ".$current_key." ".$pattern_id." ".self::getSimilarity($current_measure, $value)."<br>";
						$structure[$key] = $pattern_id;
						unset($measures[$key]);
					}
				}
			}
		}
		
		$object->patterns = $patterns;
		$object->structure = $structure;
		
		ksort($object->structure);
		
		return $object;
	}

	//we need to keep track of these patterns across all parts! (think Celebration)
	//should i have a note-analyzer that looks at notes and decides the appropriate chord for that section?
	public static function getPatternsTwo($part, $pattern_length=16) { //should includes notes, chords, repetition patterns, common rhythms and note-lengths, and song structure.
		$object = new stdClass();
		$patterns = array();
		$structure = array();
		if ($part->time_increment == $pattern_length) {
			$measures = $part->measures;
			while (!empty($measures)) {
				$next = self::array_shift_assoc_kv($measures);
				reset($next);
				$current_key = key($next);
				$current_measure = $next[$current_key];
				$pattern = new Pattern();
				$pattern->length = $pattern_length;
				$pattern->chords = $current_measure->chords; //here, use getChordValues()
				$pattern->num_notes = count($current_measure->notes);
				foreach ($current_measure->notes as $note) {
					$pattern->note_sack[] = $note->note[0];
				}
				$patterns[] = $pattern;
				$pattern_id = count($patterns)-1;
				$structure[$current_key] = $pattern_id; 
				foreach ($measures as $key => $value) {
					/*var_dump($current_measure);
					echo "<br><br>";
					echo "<br>HI".$key." ".$current_key." ".$pattern_id." ".self::getSimilarity($current_measure, $value)."<br>";
					echo "<br><br>";
					var_dump($current_measure);
					echo "<br><br>";*/
					if (self::getSimilarityNoOctave($current_measure, $value) < 4) { //also need to look across octaves, right? - haven't done that yet
						//echo "<br>HELLO".$key." ".$current_key." ".$pattern_id." ".self::getSimilarity($current_measure, $value)."<br>";
						$structure[$key] = $pattern_id;
						unset($measures[$key]);
					}
				}
			}
		}
		
		$object->patterns = $patterns;
		$object->structure = $structure;
		
		ksort($object->structure);
		
		return $object;
	}
	
	// returns value
	public static function array_shift_assoc( &$arr ){
		$val = reset( $arr );
		unset( $arr[ key( $arr ) ] );
		return $val; 
	}

	// returns [ key, value ]
	public static function array_shift_assoc_kv( &$arr ){
		$val = reset( $arr );
		$key = key( $arr );
		$ret = array( $key => $val );
		unset( $arr[ $key ] );
		return $ret; 
	}
    
}
?>