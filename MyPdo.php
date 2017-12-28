
<?php

    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
        {
            $str = '';
            $max = mb_strlen($keyspace, '8bit') - 1;
            for ($i = 0; $i < $length; ++$i) {
                $str .= $keyspace[random_int(0, $max)];
            }
            return $str;
        }
    class MyPdo {

        public static function getConnection() {
            try
            {
                 // Connexion à la base de données.
                $dsn = 'mysql:host=localhost;dbname=db_projet_php';
                $pdo = new PDO($dsn, 'louisamas', '123');
                // Codage de caractères.
                $pdo->exec('SET CHARACTER SET utf8');
                // Gestion des erreurs sous forme d'exceptions.
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            }
            catch(PDOException $e)
            {
                die('Erreur : ' . $e->getMessage());      
            }       
        }
    }

?>