
<?php

    class MyPdo {

        public static function getConnection() {
            try {// Connexion à la base de données.
                $dsn = 'mysql:host=localhost;dbname=db_projet_php';
                $pdo = new PDO($dsn, 'louisamas', '123');
                // Codage de caractères.
                $pdo->exec('SET CHARACTER SET utf8');
                // Gestion des erreurs sous forme d'exceptions.
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch(PDOException $e)
            {
                die('Erreur : ' . $e->getMessage());      
            }       
        }
    }

