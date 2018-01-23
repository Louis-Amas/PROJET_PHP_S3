<?php

    class Transaltor {


        private $lang;
        private $langS;

        public function __construct($lang, $langS) {
            $this->lang = $lang;
            $this->langS = $langS;
        }

        public function getTraduction($sentence) {
            return self::getTradByLang($sentence, $this->langS, $this->lang);
        }
        public static function getTradByLang($sentence, $langS, $lang) {
            $pdo = MyPdo::getConnection();
            $sql = 'select s.*
                    from SENTENCE s
                    left join TRANSLATE t on (t.TRANSLATED_ID = s.SENTENCE_ID or t.ORIGIN_ID = s.SENTENCE_ID)
                    left join SENTENCE st on (st.SENTENCE_ID = t.ORIGIN_ID or t.TRANSLATED_ID = s.SENTENCE_ID)
                    where st.SENTENCE = :sentence and st.LANG= :langS and s.LANG = :lang
                    and (tor.TRANSLATED_ID is not null)';
            $stmt = $pdo->prepare($sql); // Préparation d'une requête
            $params =  array(':sentence' => $sentence, ':langS' => $langS, ':lang' => $lang);
            $stmt->execute($params); // Exécution de la requête.
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            return $stmt->fetch();
        }
    }