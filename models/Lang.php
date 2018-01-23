<?php

    class Lang {
        private $name;
        private $lang;
        
        public function __construct($result) {
            $this->lang   = $result->LANG;
            $this->name   = $result->NAME;
        }
        
        public static function findByAcro($acro) {
            $pdo = MyPdo::getConnection();
            $sql = 'SELECT *  FROM LANG WHERE LANG = :lang';
            $stmt = $pdo->prepare($sql); // Préparation d'une requête.
            $stmt->bindValue('lang', $acro, PDO::PARAM_STR); // Lie les paramètres de manière sécurisée.
            try
            {
                $stmt->execute(); // Exécution de la requête.
                if ($stmt->rowCount() == 0) {
                    return null;
                }
                $stmt->setFetchMode(PDO::FETCH_OBJ);

                while ($result = $stmt->fetch())
                {
                    return new Lang($result);
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
            $sql = 'SELECT *  FROM LANG';
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
                    $list[] = new Lang($result);
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

        public static function insert($lang) {
            $pdo = MyPdo::getConnection();
            $sql = 'INSERT INTO LANG(LANG, NAME) 
            VALUES(:acro, :name)';
            $stmt = $pdo->prepare($sql); 
            
            $parameters = array(':acro' => $lang->lang, ':acro' => $sentence->name );

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