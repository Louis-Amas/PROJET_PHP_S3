<?php

    class Sentence {
        private $id;
        private $lang;
        private $sentence;

      public function __construct($result) {
            $this->id   = $result->SENTENCE_ID;
            $this->lang = $result->LANG;
            $this->sentence = $result->SENTENCE;
        }

        public function getSentence() {
          return $this->sentence;
        }
        public function getLang() {
          return $this->lang;
        }
        public function setSentence($sentence) {
          $this->sentence = $sentence;
        }
        public function setLang($lang) {
          return $this->lang = $lang;
        }
        public static function findById($id) {
            $pdo = MyPdo::getConnection();
            $sql = 'SELECT *  FROM SENTENCE WHERE SENTENCE_ID = :id';
            $stmt = $pdo->prepare($sql); // Préparation d'une requête.
            $stmt->bindValue('id', $id, PDO::PARAM_INT); // Lie les paramètres de manière sécurisée.
            try
            {
                $stmt->execute(); // Exécution de la requête.
                if ($stmt->rowCount() == 0) {
                    return null;
                }
                $stmt->setFetchMode(PDO::FETCH_OBJ);

                while ($result = $stmt->fetch())
                {
                    return new Sentence($result);
                }
            }
            catch (PDOException $e)
            {
                // Affichage de l'erreur et rappel de la requête.
                echo 'Erreur : ', $e->getMessage(), PHP_EOL;
                echo 'Requête : ', $sql, PHP_EOL;
                exit();
            }
        }

        public static function findAll() {
            $pdo = MyPdo::getConnection();
            $sql = 'SELECT *  FROM SENTENCE';
            $stmt = $pdo->prepare($sql); // Préparation d'une requête.
            try
            {
                $stmt->execute(); // Exécution de la requête.
                if ($stmt->rowCount() == 0) {
                    return null;
                }
                $stmt->setFetchMode(PDO::FETCH_OBJ);
                $list = [];
                while ($result = $stmt->fetch())
                {
                    $list[] = new Sentence($result);
                }
                return $list;
            }
            catch (PDOException $e)
            {
                // Affichage de l'erreur et rappel de la requête.
                echo 'Erreur : ', $e->getMessage(), PHP_EOL;
                echo 'Requête : ', $sql, PHP_EOL;
                exit();
            }
        }

        public static function insert($sentence) {
            $pdo = MyPdo::getConnection();
            $sql = 'INSERT INTO SENTENCE(SENTENCE, LANG)
            VALUES(:sentence, :lang)';
            $stmt = $pdo->prepare($sql);

            $parameters = array(':sentence' => $sentence->sentence, ':lang' => $sentence->lang );

            try {
                $stmt->execute($parameters);
                return true;

            } catch (PDOException $e) {
                //A supprimer en développement
                //return false;
                // Affichage de l'erreur et rappel de la requête.
                echo 'Erreur : ', $e->getMessage(), PHP_EOL;
                echo 'Requête : ', $sql, PHP_EOL;
                exit();
            }
        }
    }

?>
