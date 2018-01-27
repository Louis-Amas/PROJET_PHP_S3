<?php
    require 'models/Sentence.php';
    require 'models/Lang.php';

    class SentenceController {
        public static $path = '/?controller=sentence&action=';

        public function index() {
            $path= $this::$path . 'newSentence';
            $listLangs = Lang::findAll();
            $allSentences = Sentence::findAll();
            $listSentencesByID = array();
            foreach ($allSentences as $key => $value) {
              $listSentencesByID[$value->getId()][$value->getLang()] = $value;
            }
            require 'views/sentence/viewall.php';
        }

        public function newSentence(){
          $lang = filter_input(INPUT_POST,"LANG");
          $sentenceToAdd = filter_input(INPUT_POST,"SENTENCE");
          // Insertion new 

          Util::redirect_to('/?controller=sentence');
        }

    }

?>
