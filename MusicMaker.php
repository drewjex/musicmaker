<?php

require('midi/midi.class.php');
require('MusicAnalyzer.php');
require('MusicParser.php'); 
require('Database.php');

foreach (glob("model/*.php") as $filename)
{
    include_once $filename;
}

foreach (glob("makers/*.php") as $filename)
{
    include_once $filename;
}

$save_dir = 'save/';

class MusicMaker {
    
    public $song;
    public $template;
    public $music_analyzer;
    public $music_player;
    public $music_parser;
    
    public function __construct($title=null, $author=null, $template=null) {
        
        if ($template != null) {
            $this->template = $template;
            $this->song = new Song($title, $author, $this->template->structure);
        }
        $this->music_player = new Midi();
        $this->music_analyzer = new MusicAnalyzer();
    }
    
    public function makeSong() {
        
        foreach ($this->template->part_templates as $part_template) {
            $maker_instance = new $part_template->part_type();
            $this->song->parts[] = $maker_instance->create();
            echo "The part created from template ".$part_template->part_type." is ".MusicAnalyzer::getCombinedScore($this->song->parts[count($this->song->parts)-1])."<br>";
        }
        
    }
    
    public function makePartFromTemplate($part_template) {
        $maker_instance = new $part_template->part_type();
        return $maker_instance->create();
    }
    
    public function generateMidiFile() {
             
        $this->music_player->open(480); //timebase=480, quarter note=120
	    $this->music_player->setBpm(100);
        
        foreach ($this->song->structure as $track) {
            $first = true;
            $track_number = $this->music_player->newTrack() - 1;
            $timer = 0;
            $measure_number = 0;
            $min = 75;
            $max = 95;
            $step = 5;
            foreach ($track as $part_index) {
                if ($part_index < 0) {
                    $part = Part::emptyPart();
                    for ($i=0; $i<abs($part_index); $i++) {
                        $part->measures[] = new Measure();
                    }
                } else {
                    $part = $this->song->parts[$part_index];
                }
                
                if ($first) { //so if you suddenly change parts, it won't change the instrument unless you create a new track 55. That's probably how it should work.
                    $channel = $track_number+1;
                    $instrument = ($part->instrument == null || $part->instrument == 0) ? 1 : $part->instrument;
                    if ($part->is_drum) {
                        $channel = 10;
                        $this->music_player->addMsg($track_number, "0 PrCh ch=10 p=$instrument"); //ch=1
                    } else {
                        $this->music_player->addMsg($track_number, "0 PrCh ch=$channel p=$instrument"); //ch=1
                    }
                    $first = false;
                }
                
                $time_increment = 1920/$part->time_increment;
                foreach ($part->measures as $measure) {
                    if ($measure->notes != null) {
                        foreach ($measure->notes as $note) {
                            //$velocity = 100;
                            $velocity = rand($min, $max);
                            $min += $step;
                            $max += $step;
                            if ($max > 95 || $max < 65) {
                                $step *= -1;
                            } 
                            $timer = (1920 * $measure_number) + ($note->time*$time_increment);
                            foreach ($note->note as $same_note) {
                                $pitch = abs($same_note);
                                if ($same_note == -1) {
                                    $this->music_player->addMsg($track_number, "$timer On ch=$channel n=$pitch v=0");
                                } else {
                                    $this->music_player->addMsg($track_number, "$timer On ch=$channel n=$pitch v=$velocity");
                                }  
                            }
                            $length = $note->length*$time_increment;
                            $end_note = $length+$timer;
                            foreach ($note->note as $same_note) {
                                $pitch = abs($same_note);
                                if ($same_note == -1) {
                                    $this->music_player->addMsg($track_number, "$timer On ch=$channel n=$pitch v=0");
                                } else {
                                    $this->music_player->addMsg($track_number, "$timer On ch=$channel n=$pitch v=$velocity");
                                }    
                            }
                            $timer = $end_note;
                        }
                    }
                    $measure_number++;
                }
            }
            
            $this->music_player->addMsg($track_number, "$timer Meta TrkEnd");
        }
        
        $this->music_player->deleteTrack($this->music_player->getTrackCount()-1);
        
        //srand((double)microtime()*1000000);
        //$rand = rand();
        $file = $this->song->title.'.mid';
        $loop = 1;
        $plug = 'wm';
        
        echo $this->music_player->getTxtMod();
        
        //$this->music_player->saveMidFile('save/'.$file);
    }
    
    public function playSong() {
        $file = $this->song->title.'.mid';
        $this->music_player->playFile('save/'.$file);
    }
    
    public function getMidiText() {
        echo $this->music_player->getTxtMod();
    }
    
    public function loadMidiSong($title) {
        $this->music_player->importMid('save/'.$title.'.mid');
    }
    
    public function saveMidiSong() {
        $file = $this->song->title.'.mid';
        $this->music_player->saveMidFile('save/'.$file);
    }
    
    public function saveSongToDatabase() {
        $db = new Database();
        $json = json_encode($this->song);
        $stmt = $db->prepare("INSERT INTO songs(title, author, data)
            VALUES(:title, :author, :data)");
        $stmt->execute(array(
            "title" => $this->song->title,
            "author" => $this->song->author,
            "data" => $json
        ));
    }
    
    public function loadSongFromDatabase($title, $author) {
        $db = new Database();
        $sql = "SELECT * FROM songs WHERE title='$title' AND author='$author'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        $this->song = json_decode($row['data']);
    }
    
    public function convertMidiToMM($file) {
        $this->music_player->importMid($file);
        $str = $this->music_player->getTxtMod();
        $midi_array = explode("<br>", $str);
        $this->music_parser = new MusicParser($midi_array);
        $this->song = $this->music_parser->parse();
    }
}