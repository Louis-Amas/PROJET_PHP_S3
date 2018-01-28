<?php

    class PageController {
    	//redirection vers la page home
        public function home() {
            require 'views/page/home.php';
        }
        //redirection vers la page des mentions legales
        public function legal(){
          require 'views/page/legalMention.php';
        }


    }
?>
