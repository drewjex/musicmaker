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
            
            $music_maker = new MusicMaker("Repeating", "Drew Jex");
            //$music_maker->convertMidiToMM("save/Free.mid");
            //$music_maker->convertMidiToMM("save/Elephant Walk.mid");
            //$music_maker->convertMidiToMM("save/A Passing Storm.mid");
            $music_maker->convertMidiToMM("save/Highway 101.mid");
            $music_maker->generateMidiFile();
            $music_maker->saveMidiSong();
            $music_maker->playSong();
            
            //$music_maker = new MusicMaker("Drew Jex", "Mock Highway 101");
            //$music_maker->song = new Song("Mock Highway 101", "Drew Jex", $structure); //this changes file name
            //$music_maker->song->parts = $parts;
            //$music_maker->generateMidiFile();
            //$music_maker->saveMidiSong();
            //$music_maker->playSong();

            /*var_dump(MusicAnalyzer::getAllNotesAtTime($music_maker->song, 0, 1, 1));
            var_dump(MusicAnalyzer::getAllNotesAtTime($music_maker->song, 0, 2, 5));
            var_dump(MusicAnalyzer::getAllNotesAtTime($music_maker->song, 0, 3, 5));
            var_dump(MusicAnalyzer::getAllNotesAtTime($music_maker->song, 0, 4, 5));
            var_dump(MusicAnalyzer::getAllNotesAtTime($music_maker->song, 0, 5, 5));
            var_dump(MusicAnalyzer::getAllNotesAtTime($music_maker->song, 0, 6, 5));*/

            echo "<br><br>";

            echo "<pre>";
            print_r($music_maker->song);
            echo "</pre>";

            $chords = MusicAnalyzer::getChordProgression($music_maker->song);

        ?>
    </body>
</html>