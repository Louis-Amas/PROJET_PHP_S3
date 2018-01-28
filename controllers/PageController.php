<?php

    class PageController {

        public function home() {
            $allLangs = Lang::findAll();
            $langselected = filter_input(INPUT_POST,'LANGSELECT');
            if(!empty($langselected)){
              $_SESSION['LANG'] = $langselected;
              Util::redirect_to('/');
            }
            require 'views/page/home.php';
        }
        public function legal(){
          require 'views/page/legalMention.php';
        }


    }
?>
