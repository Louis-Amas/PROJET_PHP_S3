<?php

    class ToTranslate {
        
        private $id;
        private $sentence;
        private $langd;
        private $langs;
        private $status;
        private $author;
        
        public function __construct($result) {
            $this->id          = $result->TOTRANSLATE_ID;
            $this->sentence    = $result->TOTRANSLATE;
            $this->langd       = $result->LANGD;
            $this->langs       = $result->LANGS;
            $this->status      = $result->STATUS;
            $this->author      = $result->AUTHOR_ID; 
        }
        
        public static function findByLangDLangSAndSentence($sentence, $langs, $langd) {
            $pdo = MyPdo::getConnection();
            $sql = 'SELECT *  FROM TOTRANSLATE WHERE LANGD = :langd AND LANGS = :langs 
            AND TOTRANSLATE = :sentence';
            $stmt = $pdo->prepare($sql); // Préparation d'une requête.
            $parameters = array(':langd' => $langd, ':langs' => $langs, ':sentence' => $sentence);
            try
            {
                $stmt->execute($parameters); // Exécution de la requête.
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

        public static function insert($sentence, $author, $langs, $langd) {
            $pdo = MyPdo::getConnection();
            $sql = 'INSERT INTO TOTRANSLATE(TOTRANSLATE, LANGS, LANGD, STATUS, AUTHOR_ID) 
            VALUES(:totranslate, :langs, :langd, "WAITING", :author )';
            $stmt = $pdo->prepare($sql);
            $parameters =  array(':totranslate' => $sentence, ':author' => $author, ':langs' => $langs, ':langd'
            => $langd );
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