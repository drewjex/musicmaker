<html>
    <head>
        <script src='http://www.midijs.net/lib/midi.js'></script>
    </head>
    <body>
        <?php

            require_once('MusicMaker.php');
            require_once('model/SongTemplate.php');
            require_once('model/PartTemplate.php');

            /*$title = "Test Song 1";
            $author = "Drew Jex";
            $parts = array();
            $parts[0] = new PartTemplate("BasicIntro");
            $parts[1] = new PartTemplate("BasicMelody");

            $structure = array();
            $structure[0][0] = 0;
            $structure[0][1] = 0;
            $structure[0][2] = 0;
            $structure[1][0] = -4; 
            $structure[1][1] = 1; 
            $structure[1][2] = 1;

            $template = new SongTemplate($title, $author, $parts, $structure);
            $music_maker = new MusicMaker("Test Song", "Drew Jex", $template);
            //$music_maker->makeSuggestion();
            $music_maker->makeSong();
            $music_maker->playSong();*/
            
            /*for ($i=0; $i<50; $i++) {
                $music_maker = new MusicMaker("Test Song", "Drew Jex", $template);
                $music_maker->makeSong();
            }*/
            
            /*$best_score = 0;
            $worst_score = 99999;
            $best_music_maker = null;
            $worst_music_maker = null;
            for ($i=0; $i<100; $i++) {
                $music_maker = new MusicMaker("Repeat", "Drew Jex");
                $new_score = $music_maker->developRepeat();
                if ($new_score > $best_score) {
                    $best_music_maker = $music_maker;
                    $best_score = $new_score;
                    //echo $best_score."<br>";
                } if ($new_score < $worst_score) {
                    $worst_music_maker = $music_maker;
                    $worst_score = $new_score;
                    //echo $worst_score."<br>";
                }
            }
            
            $best_music_maker->generateMidiFile();
            $best_music_maker->saveSongToDatabase();
            $best_music_maker->playSong();*/
            //$worst_music_maker->playSong();
            
            /*$music_maker = new MusicMaker();
            $music_maker->loadSongFromDatabase("Repeat12", "Drew Jex");
            $music_maker->generateMidiFile();
            $music_maker->playSong(); */
            
            
            
            /*$music_maker = new MusicMaker("From Pattern", "Drew Jex");
            $parts[0] = new PartTemplate("BasicRepeat");
            $parts[1] = new PartTemplate("MakeFromPattern");
            
            $part = $music_maker->makePartFromTemplate($parts[0]);
            $object = MusicAnalyzer::getPatterns($part);
            
            echo var_dump($object->structure);
            
            $maker_instance = new $parts[1]->part_type();
            $maker_instance->patterns = $object->patterns;
            $maker_instance->structure = $object->structure;
            $part_two = $maker_instance->create();
            
            $structure = array();
            $structure[0][0] = 0;
            $structure[0][1] = 1;
            
            $music_maker->song = new Song("From Pattern", "Drew Jex", $structure);
            $music_maker->song->parts = [$part, $part_two];
            $music_maker->generateMidiFile();
            $music_maker->saveSongToDatabase();
            $music_maker->playSong();*/
            
            $music_maker = new MusicMaker("Repeat", "Drew Jex");
            //$music_maker->convertMidiToMM("save/Free.mid");
            //$music_maker->convertMidiToMM("save/Elephant Walk.mid");
            //$music_maker->convertMidiToMM("save/A Passing Storm.mid");
            $music_maker->convertMidiToMM("save/Highway 101_2.mid");
            //$music_maker->convertMidiToMM("save/My_First_Score.mid");
            //$music_maker->convertMidiToMM("save/Celebration.mid");
            //$music_maker->convertMidiToMM("save/Ttest.mid");
            
            /*$title = "Test Song 2";
            $author = "Drew Jex";
            $parts = array();
            $parts[0] = new PartTemplate("BasicIntro");
            //$parts[1] = new PartTemplate("NewMelody");

            $structure = array();
            $structure[0][0] = 0;
            $structure[0][1] = 0;
            $structure[0][2] = 0;
            //$structure[1][0] = -4; 
            //$structure[1][1] = 1; 
            //$structure[1][2] = 1;

            $template = new SongTemplate($title, $author, $parts, $structure);
            $music_maker = new MusicMaker("Test Song 20", "Drew Jex", $template);
            //$music_maker->makeSuggestion();
            $music_maker->makeSong();
            $music_maker->generateMidiFile();
            $music_maker->saveMidiSong();
            $music_maker->playSong();*/
            
            /*echo "Number of Measures: ".count($music_maker->song->parts[0]->measures)."<br><br>"; //1, 40
            echo "Measures 2 and 41 Similarity: ".MusicAnalyzer::getSimilarity($music_maker->song->parts[0]->measures[0], $music_maker->song->parts[0]->measures[1])."<br><br>";
            $object = MusicAnalyzer::getPatterns($music_maker->song->parts[0]);
            var_dump($object->structure);
            echo "<pre>";
            var_dump($object->patterns);
            echo "</pre>";*/
            
            //echo "Number of Measures: ".count($music_maker->song->parts[0]->measures)."<br><br>"; //1, 40
            //echo "Measures 2 and 41 Similarity: ".MusicAnalyzer::getSimilarity($music_maker->song->parts[0]->measures[1], $music_maker->song->parts[0]->measures[40])."<br><br>";
            //echo "Measures 40 and 70 Similarity: ".MusicAnalyzer::getSimilarity($music_maker->song->parts[0]->measures[39], $music_maker->song->parts[0]->measures[69])."<br><br>";
            //var_dump($music_maker->song->parts[0]->measures[1]);
            //echo "<br><br><br>";
            //var_dump($music_maker->song->parts[0]->measures[40]);
            $object = MusicAnalyzer::getPatterns($music_maker->song->parts[0]);
            $object2 = MusicAnalyzer::getPatterns($music_maker->song->parts[1]);
            //var_dump($object->structure);
            //echo "<pre>";
            //var_dump($object->patterns);
            //echo "</pre>";
            
            $music_changer = new MusicChanger();
            $parts = array();
            foreach ($object->patterns as $pattern) {
                $part = new Part();
                $measures = array();
                $notes = array();
                $chords = array();
                $chords[] = new Chord(0, "MAJOR", 16);
                $measure = new Measure($notes, $chords);
                for ($i=0; $i<$pattern->num_notes; $i++) {
                    $measure = $music_changer->addNoteFromSackInMeasure($measure, $pattern->note_sack);
                }
                
                $measures[] = $measure;
                $part = Part::setMeasures($measures);
                $part->instrument = 1;
                
                /*for ($i=0; $i<20; $i++) {
                    $part = $this->addNoteRandom($part); //not quite there yet...
                }*/
                
                $parts[] = $part;
            }
            
            $part = new Part();
            $measures = array();
            $offset = 0;
            for ($i=0; $i<70; $i++) {
                $notes = array();
                $chords = array();
                $chords[] = new Chord(0, "MAJOR", 16);
                for ($j=0; $j<4; $j++) {
                    $notes[] = new Note([60], "NORMAL", 4*$j, 4);
                }
                        
                $measures[] = new Measure($notes, $chords);
                
            }
            
            $part = Part::setMeasures($measures);
            $part->instrument = 117; //10 //99

            $parts[] = $part;
            $id1 = count($parts)-1;
            $parts[] = $music_maker->song->parts[1];
            $id2 = count($parts)-1;
            
            foreach ($object2->patterns as $pattern) {
                $part = new Part();
                $measures = array();
                $notes = array();
                $chords = array();
                $chords[] = new Chord(0, "MAJOR", 16);
                $measure = new Measure($notes, $chords);
                for ($i=0; $i<$pattern->num_notes; $i++) {
                    $measure = $music_changer->addNoteFromSackInMeasure($measure, $pattern->note_sack);
                }
                
                $measures[] = $measure;
                $part = Part::setMeasures($measures);
                $part->instrument = 1;
                
                /*for ($i=0; $i<20; $i++) {
                    $part = $this->addNoteRandom($part); //not quite there yet...
                }*/
                
                $parts[] = $part;
            }
            
            foreach ($object2->structure as $key => $value) {
                $object2->structure[$key] = $value+$id2+1;
            }
            
            //var_dump($parts);
            
            //var_dump($parts);
            
            $structure = array();
            $structure[0] = $object->structure;
            $structure[1][0] = $id1;
            //$structure[2][0] = $id2;
            $structure[3] = $object2->structure;
            
            $music_maker2 = new MusicMaker("Drew Jex", "Mock Highway 101");
            $music_maker2->song = new Song("Mock Highway 101", "Drew Jex", $structure); //this changes file name
            $music_maker2->song->parts = $parts;
            $music_maker2->generateMidiFile();
            $music_maker2->saveMidiSong();
            $music_maker2->playSong();
            
            /*$measure1 = new Measure();
            $measure1->notes[] = new Note([62], "Normal", 0, 3);
            $measure1->notes[] = new Note([62], "Normal", 2, 3);
            $measure1->notes[] = new Note([62], "Normal", 3, 3);
            $measure1->notes[] = new Note([62], "Normal", 15, 3);
            $measure2 = new Measure();
            $measure2->notes[] = new Note([64], "Normal", 0, 3);
            $measure2->notes[] = new Note([65], "Normal", 2, 3);
            $measure2->notes[] = new Note([66], "Normal", 6, 3);
            $measure2->notes[] = new Note([67], "Normal", 10, 3);
            $measure2->notes[] = new Note([68], "Normal", 15, 3);
            
            echo "<br> Score: ".MusicAnalyzer::getSimilarity($measure1, $measure2)."<br>Note Values: ";*/
            //var_dump(MusicAnalyzer::getChord($measure2->notes));
            
            //var_dump($measure1->notes);

        ?>
    </body>
</html>