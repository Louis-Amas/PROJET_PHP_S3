<?php
    require 'models/Sentence.php';
    require 'models/Lang.php';
    
    class SentenceController {
        public static $path = '/?controller=sentence&action=';

        public function index() {
            $list = Sentence::findAll();
        }
    }

?>