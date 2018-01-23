<?php

    class ToTranslate {
        private $id;
        private $sentence_id;
        private $lang;
        private $state;
        private $author;
        
        public function __construct($result) {
            $this->id          = $result->TOTRANSLATE_ID;
            $this->sentence_id = $result->SENTENCE_ID;
            $this->lang        = $result->LANG;
            $this->state       = $result->STATE;
            $this->author      = $result->AUTHOR; 
        }
        
        public static function findByUserId($userId) {
            $pdo = MyPdo::getConnection();
            $sql = 'SELECT *  FROM TOTRANSLATE WHERE AUTHOR = :id';
            $stmt = $pdo->prepare($sql); // Préparation d'une requête.
            $stmt->bindValue('id', $userId, PDO::PARAM_INT); // Lie les paramètres de manière sécurisée.
            try
            {
                $stmt->execute(); // Exécution de la requête.
                if ($stmt->rowCount() == 0) {
                    return null;
                }
                $stmt->setFetchMode(PDO::FETCH_OBJ);

                while ($result = $stmt->fetch())
                {
                    return new ToTranslate($result);
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
            $sql = 'SELECT *  FROM TOTRANSLATE';
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
                    $list[] = new ToTranslate($result);
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

        public static function insert($sentence_id, $author, $lang) {
            $pdo = MyPdo::getConnection();
            $sql = 'INSERT INTO TOTRANSLATE(SENTENCE_ID, LANG, STATE, AUTHOR) 
            VALUES(:sentence_id, :lang, ATT, :author )';
            $stmt = $pdo->prepare($sql);
            $parameters =  array(':sentence_id' => $sentence_id, ':author' => $author, ':lang' => $lang );
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