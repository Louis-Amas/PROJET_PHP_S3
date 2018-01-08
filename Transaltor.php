<?php

    class Translator {

        private $lang;

        public function __construct($url) {
            // Lire le fichier json
            $json = file_get_contents($url);

            // Transformer json en Array php
            $json_data = json_decode($json, true);
            $array = $json_data['lang'];
            $lang;
            foreach ($array as $value) {
                foreach ($value as $key => $val) {
                    $lang[$key] = $val;
                }
            }
            $this->lang = $lang;
        }


        public function getTranslation($word) {
            return $lang[$word];
        }
    }