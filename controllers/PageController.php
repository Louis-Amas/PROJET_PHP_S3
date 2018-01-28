<?php

    class PageController {
    	//redirection vers la page home
        public function home() {
            $allLangs = Lang::findAll();
            $langselected = filter_input(INPUT_POST,'LANGSELECT');
            if(!empty($langselected)){
              $_SESSION['LANG'] = $langselected;
              Util::redirect_to('/');
            }
            require 'views/page/home.php';
        }
        //redirection vers la page des mentions legales
        public function legal(){
          require 'views/page/legalMention.php';
        }


    }
?>
