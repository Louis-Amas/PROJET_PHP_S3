
<?php

    class MyPdo {

        public static function getConnection() {
            try {// Connexion à la base de données.
                $dsn = 'mysql:host=mysql-projetsem3php.alwaysdata.net;dbname=projetsem3php_database';
                $pdo = new PDO($dsn, '150610', 'root');
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
