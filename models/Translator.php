<?php

    class Transaltor {


        private $lang;

        public function __construct($lang) {
            $this->lang = $lang;
        }

        public function getTraduction($sentence) {
            return self::getTradByLang($sentence, $this->lang);
        }
        public static function getTradByLang($sentence, $lang) {
            $pdo = MyPdo::getConnection();
            $sql = 'SELECT SENTENCE FROM TRADUCTION as trad , SENTENCE as Sen 
            WHERE trad.ORIGIN = :sentence AND LANG = :lang';
            $stmt = $pdo->prepare($sql); // Préparation d'une requête
            $params =  array(':sentence' => $sentence, ':lang' => $lang);
            $stmt->execute($params); // Exécution de la requête.
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            return $stmt->fetch();
        }
    }
