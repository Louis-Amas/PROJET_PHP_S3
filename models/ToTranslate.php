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

        public function __toString(){
        	return $this->sentence . ' in ' .  $this->langs . ' to ' . $this->langd;
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
            $sql = 'SELECT *  FROM TOTRANSLATE WHERE AUTHOR_ID = :id';
            $stmt = $pdo->prepare($sql); // Préparation d'une requête.
            $stmt->bindValue('id', $userId, PDO::PARAM_INT); // Lie les paramètres de manière sécurisée.
            try
            {
                $stmt->execute(); // Exécution de la requête.
                if ($stmt->rowCount() == 0) {
                    return null;
                }
                $stmt->setFetchMode(PDO::FETCH_OBJ);
                $return = array();
                while ($result = $stmt->fetch())
                {
                    $return[] = new ToTranslate($result);
                }
                return $return;
            }
            catch (PDOException $e)
            {
                // Affichage de l'erreur et rappel de la requête.
                echo 'Erreur : ', $e->getMessage(), PHP_EOL;
                echo 'Requête : ', $sql, PHP_EOL;
                exit();
            }
        }

        public static function findById($Id) {
            $pdo = MyPdo::getConnection();
            $sql = 'SELECT *  FROM TOTRANSLATE WHERE TOTRANSLATE_ID = :id';
            $stmt = $pdo->prepare($sql); // Préparation d'une requête.
            $stmt->bindValue('id', $Id, PDO::PARAM_INT); // Lie les paramètres de manière sécurisée.
            try
            {
                $stmt->execute(); // Exécution de la requête.
                if ($stmt->rowCount() == 0) {
                    return null;
                }
                $stmt->setFetchMode(PDO::FETCH_OBJ);
                $return = array();
                while ($result = $stmt->fetch())
                {
                    $return = new ToTranslate($result);
                }
                return $return;
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

        public function updateStatus($new){
          $pdo = MyPdo::getConnection();
          $sql = 'UPDATE TOTRANSLATE SET STATUS = :new WHERE TOTRANSLATE_ID = :id';
          $stmt = $pdo->prepare($sql);
          $parameters =  array(':id' => $this->id, ':new' => $new );
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

    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Sentence
     *
     * @return mixed
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * Set the value of Sentence
     *
     * @param mixed sentence
     *
     * @return self
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;

        return $this;
    }

    /**
     * Get the value of Langd
     *
     * @return mixed
     */
    public function getLangd()
    {
        return $this->langd;
    }

    /**
     * Set the value of Langd
     *
     * @param mixed langd
     *
     * @return self
     */
    public function setLangd($langd)
    {
        $this->langd = $langd;

        return $this;
    }

    /**
     * Get the value of Langs
     *
     * @return mixed
     */
    public function getLangs()
    {
        return $this->langs;
    }

    /**
     * Set the value of Langs
     *
     * @param mixed langs
     *
     * @return self
     */
    public function setLangs($langs)
    {
        $this->langs = $langs;

        return $this;
    }

    /**
     * Get the value of Status
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of Status
     *
     * @param mixed status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of Author
     *
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of Author
     *
     * @param mixed author
     *
     * @return self
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

}

?>
