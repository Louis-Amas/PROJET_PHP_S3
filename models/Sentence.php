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
        public function getID()
        {
          return $this->id;
        }
        public function setSentence($sentence) {
          $this->sentence = $sentence;
        }
        public function setLang($lang) {
          $this->lang = $lang;
        }

        public function setID($id){
          $this->id = $id;
        }

        public function findTranslation($destination){
          $pdo = MyPdo::getConnection();
          $sql = 'SELECT *  FROM SENTENCE WHERE SENTENCE_ID = :id AND LANG= :lang';
          $stmt = $pdo->prepare($sql); // Préparation d'une requête.
          $stmt->bindValue('id', $this->id, PDO::PARAM_INT); // Lie les paramètres de manière sécurisée.
          $stmt->bindValue('lang', $destination, PDO::PARAM_STR);
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

        public static function findBySentenceAndLang($string,$lang){
          $pdo = MyPdo::getConnection();
          $sql = 'SELECT *  FROM SENTENCE WHERE LANG= :lang AND SENTENCE= :sentence';
          $stmt = $pdo->prepare($sql); // Préparation d'une requête.
          $stmt->bindValue('lang', $lang, PDO::PARAM_STR); // Lie les paramètres de manière sécurisée.
          $stmt->bindValue('sentence', $string, PDO::PARAM_STR);
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

        public static function findByLang($lang){
          $pdo = MyPdo::getConnection();
          $sql = 'SELECT *  FROM SENTENCE WHERE LANG= :lang';
          $stmt = $pdo->prepare($sql); // Préparation d'une requête.
          $stmt->bindValue('lang', $lang, PDO::PARAM_STR); // Lie les paramètres de manière sécurisée.
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

  		public static function insertNew($sentence) {
    		$pdo = MyPdo::getConnection();
    		$sql = 'INSERT INTO SENTENCE(LANG, SENTENCE)
    		SELECT l.LANG, :sentence
    		FROM LANG l
    		WHERE l.LANG = :langS';
    		$stmt = $pdo->prepare($sql); // Préparation d'une requête
    		$stmt->bindValue('langS', $sentence->getLang(), PDO::PARAM_STR);
    		$stmt->bindValue('sentence', $sentence->getSentence(), PDO::PARAM_STR);
    		$params =  array(':langS' => $sentence->getLang(), ':sentence' => $sentence->getSentence());
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

      public static function insertOrUpdateAccordingID($sentence){
        if (is_null($sentence->getID()) || empty($sentence->getID())){
          return false;
        }
        $pdo = MyPdo::getConnection();
        $sql = 'INSERT INTO SENTENCE(SENTENCE_ID, LANG, SENTENCE)
                VALUES (:id,:lang,:sentence)
                ON DUPLICATE KEY UPDATE SENTENCE=":SENTENCE"';

        $stmt = $pdo->prepare($sql); // Préparation d'une requête
    		$stmt->bindValue('sentence', $sentence->getSentence(), PDO::PARAM_STR);
    		$stmt->bindValue('id', $sentence->getID(), PDO::PARAM_INT);
    		$stmt->bindValue('lang', $sentence->getLang(), PDO::PARAM_STR);
        $params =  array(':sentence' => $sentence->getSentence(),':id' => $sentence->getID(), ':lang' => $sentence->getLang());
        try {
    			$stmt->execute($params);
    			return true;

    		} catch (PDOException $e) {
    			echo 'Erreur : ', $e->getMessage(), PHP_EOL;
    			echo 'Requête : ', $sql, PHP_EOL;
    			exit();
    		}
      }

  		public static function insertAlreadyExist($sentence, $translation) {
    		$pdo = MyPdo::getConnection();
   			$sql = 'INSERT INTO SENTENCE(SENTENCE_ID, LANG, SENTENCE)
		    SELECT s.SENTENCE_ID, :langT, :translation
		    FROM SENTENCE s
    		WHERE s.SENTENCE = :sentence';
    		$stmt = $pdo->prepare($sql); // Préparation d'une requête
    		$stmt->bindValue('sentence', $sentence->getSentence(), PDO::PARAM_STR);
    		$stmt->bindValue('translation', $translation->getSentence(), PDO::PARAM_STR);
    		$stmt->bindValue('langT', $translation->getLang(), PDO::PARAM_STR);
    		$params =  array(':langT' => $translation->getLang(),':sentence' => $sentence->getSentence(), ':translation' => $translation->getSentence());
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

  		public static function getAllLangFromBasicToLang() {
  			$pdo = MyPdo::getConnection();
   			$sql = 'SELECT *
		    FROM SENTENCE s
    		WHERE s.SENTENCE_ID IN (SELECT s.SENTENCE_ID
    								FROM SENTENCE s
    								WHERE s.LANG = "basic")';
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
                foreach ($list as $sentence) {
  					$Map[$sentence->getLang()]= $sentence->getSentence();
  				}
  				return $Map;
            }
            catch (PDOException $e)
            {
                // Affichage de l'erreur et rappel de la requête.
                echo 'Erreur : ', $e->getMessage(), PHP_EOL;
                echo 'Requête : ', $sql, PHP_EOL;
                exit();
            }
  		}

  	    public function __toString(){
        	return $this->sentence;
        }
      }
?>
