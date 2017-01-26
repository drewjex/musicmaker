<html>
    <head>
        <script src='http://www.midijs.net/lib/midi.js'></script>
    </head>
    <body>
        <?php

            require_once('MusicMaker.php');

            $measure1 = new Measure();
            $measure1->notes[] = new Note(array(62), "Normal", 0, 3);
            $measure1->notes[] = new Note([62], "Normal", 2, 3);
            $measure1->notes[] = new Note([62], "Normal", 3, 3);
            $measure1->notes[] = new Note([62], "Normal", 15, 3);
            $measure2 = new Measure();
            $measure2->notes[] = new Note([64], "Normal", 0, 3);
            $measure2->notes[] = new Note([65], "Normal", 2, 3);
            $measure2->notes[] = new Note([66], "Normal", 6, 3);
            $measure2->notes[] = new Note([67], "Normal", 10, 3);
            $measure2->notes[] = new Note([68], "Normal", 15, 3);

            $measure3 = new Measure();
            //$measure3->notes[] = new Note([60], "Normal", 0, 3);
            $measure3->notes[] = new Note([64], "Normal", 2, 3);
            $measure3->notes[] = new Note([67], "Normal", 6, 3);
            $measure3->notes[] = new Note([67], "Normal", 6, 3);
            $measure3->notes[] = new Note([72], "Normal", 6, 3);

            $measure4 = new Measure();
            $measure4->notes[] = new Note([60], "Normal", 0, 3);
            $measure4->notes[] = new Note([63], "Normal", 2, 3);
            $measure4->notes[] = new Note([67], "Normal", 6, 3);
            $measure4->notes[] = new Note([67], "Normal", 6, 3);
            $measure4->notes[] = new Note([72], "Normal", 6, 3);

            $measure5 = new Measure();
            $measure5->notes[] = new Note([60], "Normal", 0, 3);
            $measure5->notes[] = new Note([63], "Normal", 2, 3);
            //$measure5->notes[] = new Note([66], "Normal", 6, 3);
            $measure5->notes[] = new Note([66], "Normal", 6, 3);
            //$measure5->notes[] = new Note([72], "Normal", 6, 3);

            $measure6 = new Measure();
            //$measure6->notes[] = new Note([60], "Normal", 0, 3);
            $measure6->notes[] = new Note([64], "Normal", 2, 3);
            $measure6->notes[] = new Note([68], "Normal", 6, 3);
            $measure6->notes[] = new Note([68], "Normal", 6, 3);
            $measure6->notes[] = new Note([72], "Normal", 6, 3);
            
            echo "<br> Score: ".MusicAnalyzer::getSimilarity($measure1, $measure2)."<br>Note Values: ";
            //echo "<br>";
            //var_dump(MusicAnalyzer::getChord($measure2->notes));
            echo "<br>";
            echo "<br>";
            echo MusicAnalyzer::getChordName($measure3->notes);
            echo "<br>";
            echo MusicAnalyzer::getChordName($measure4->notes);
            echo "<br>";
            echo MusicAnalyzer::getChordName($measure5->notes);
            echo "<br>";
            echo MusicAnalyzer::getChordName($measure6->notes);
            echo "<br>";
            var_dump(MusicAnalyzer::getChordValues($measure6->notes));
            //var_dump($measure1->notes);
            //echo "<br>";
            //echo "<br>";
            //getAllNotesAtTime

        ?>
    </body>
</html>