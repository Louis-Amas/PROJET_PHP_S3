<?php
class User {
  private $id;
  private $email;
  private $username;
  private $password;
  private $salt;
  private $type;

  public function getType(){
    return $this->type;
  }
  public function isActivated(){
    return is_null($type);
  }

  public function setUsername($username) {
    $this->username = $username;
  }
  public function setPassword($password) {
    $this->password = $password;
  }
  public function setEmail($email) {
    $this->email = $email;
  }
  public function getEmail() {
    return $this->email;
  }

  public function __construct($result, $option = 0) {
    if ($option == 0) {
      $this->id          = $result->USER_ID;
      $this->email       = $result->EMAIL;
      $this->username    = $result->USERNAME;
      $this->password    = $result->PASSWORD;
      $this->salt        = $result->SALT;
      $this->date_der_co = $result->DATE_DER_CO;
      $this->type        = $result->TYPE;
    } else {
      $this->email       = $result['EMAIL'];
      $this->username    = $result['USERNAME'];
      $this->password    = $result['PASSWORD'];
    }
  }
  public function getSalt() {
    return $this->salt;
  }
  public function verifyPassword($password) {
    if ($this->password == hash('sha256', $password . $this->salt ))
    return true;
    return false;
  }

  public function getUsername() {
    return $this->username;
  }
  public function getId() {
    return $this->id;
  }

  public function show() {
    return $this->id . ' ' . $this->username;
  }

  public static function findAllActivated(){
    $pdo = MyPdo::getConnection();
    $sql = 'SELECT *  FROM USER WHERE TYPE IS NOT NULL';
    $stmt = $pdo->prepare($sql); // Préparation d'une requête
    try {
      $stmt->execute(); // Exécution de la requête.

      if ($stmt->rowCount() == 0) {
        return null;
      }
      $stmt->setFetchMode(PDO::FETCH_OBJ);

      while ($result = $stmt->fetch())
      {
        $all[] = new User($result);
      }

    } catch (PDOException $e) {
      // Affichage de l'erreur et rappel de la requête.
      echo 'Erreur : ', $e->getMessage(), PHP_EOL;
      echo 'Requête : ', $sql, PHP_EOL;
      exit();
    }
    return $all;
  }

  public static function findAll() {
    $pdo = MyPdo::getConnection();
    $sql = 'SELECT *  FROM USER';
    $stmt = $pdo->prepare($sql); // Préparation d'une requête
    try {
      $stmt->execute(); // Exécution de la requête.

      if ($stmt->rowCount() == 0) {
        return null;
      }
      $stmt->setFetchMode(PDO::FETCH_OBJ);

      while ($result = $stmt->fetch())
      {
        $all[] = new User($result);

      }

    } catch (PDOException $e) {

      // Affichage de l'erreur et rappel de la requête.
      echo 'Erreur : ', $e->getMessage(), PHP_EOL;
      echo 'Requête : ', $sql, PHP_EOL;
      exit();
    }
    return $all;
  }

  public static function findById($id) {
    $pdo = MyPdo::getConnection();
    $sql = 'SELECT *  FROM USER WHERE USER_ID = :id';
    $stmt = $pdo->prepare($sql); // Préparation d'une requête.
    $id = $id;
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
        return new User($result);
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

  public static function findByUsername($username) {
    $pdo = MyPdo::getConnection();
    $sql = 'SELECT *  FROM USER WHERE USERNAME = :username';
    $stmt = $pdo->prepare($sql); // Préparation d'une requête.
    $stmt->bindValue('username', $username, PDO::PARAM_STR); // Lie les paramètres de manière sécurisée.
    try
    {
      $stmt->execute(); // Exécution de la requête.

      if ($stmt->rowCount() == 0) {
        return null;
      }
      $stmt->setFetchMode(PDO::FETCH_OBJ);

      while ($result = $stmt->fetch())
      {
        return new User($result);
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

  public static function findByEmail($email) {
    $pdo = MyPdo::getConnection();
    $sql = 'SELECT *  FROM USER WHERE EMAIL = :email';
    $stmt = $pdo->prepare($sql); // Préparation d'une requête.
    $stmt->bindValue('email', $email, PDO::PARAM_STR); // Lie les paramètres de manière sécurisée.
    try
    {
      $stmt->execute(); // Exécution de la requête.

      if ($stmt->rowCount() == 0) {
        return null;
      }
      $stmt->setFetchMode(PDO::FETCH_OBJ);

      while ($result = $stmt->fetch())
      {
        return new User($result);
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

  public function activate() {
    $pdo = MyPdo::getConnection();
    $query = 'UPDATE USER SET TYPE = "NOR" WHERE USER_ID = :id';
    $stmt = $pdo->prepare($query);
    $parameters = array(':id' => $this->id);
    try {
      $stmt->execute($parameters);
      return true;
    } catch (PDOException $e) {
      new Alert('Erreur : ', $e->getMessage(), PHP_EOL);
      new Alert('Requête : ', $sql, PHP_EOL);
      Util::redirect_to('/');
    }
  }

  public static function insert($user) {

    if (self::findByUsername($user->username) != null)
    return false;
    if (self::findByEmail($user->email) != null)
    return false;

    $salt = Util::random_str(10);
    $password = hash('sha256', $user->password . $salt);
    $pdo = MyPdo::getConnection();
    $sql = 'INSERT INTO USER(USERNAME, PASSWORD, SALT, DATE_DER_CO, EMAIL)
    VALUES(:username, :password, :salt, now(), :email)';
    $stmt = $pdo->prepare($sql); // Préparation d'une requête.
    $id = $id;
    /*$stmt->bindValue('username', $user->username, PDO::PARAM_STR);
    $stmt->bindValue('salt', $salt, PDO::PARAM_STR);
    $stmt->bindValue('password', $password, PDO::PARAM_STR);
    $stmt->bindValue('email', $user->email, PDO::PARAM_STR);*/
    $parameters = array(':username' => $user->username, ':salt' => $salt, ':password' => $password,
    ':email' => $user->email);

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

  public static function update($user, $mode = 0) {
    var_dump($user->password);
    $sql =   'UPDATE USER
              SET USERNAME = :username, EMAIL = :email
              WHERE USER_ID = :id';
    $parameters = array(':username' => $user->username,
    ':email' => $user->email, ':id' => $user->id );

    if ($mode == 1){
      $user->password = hash('sha256', $user->password . $user->getSalt());
      $sql = 'UPDATE USER
              SET USERNAME = :username, EMAIL = :email, PASSWORD = :password
              WHERE USER_ID = :id';
      $parameters = array(':username' => $user->username, ':password' => $user->password,
      ':email' => $user->email, ':id' => $user->id );
    }
    $pdo = MyPdo::getConnection();

    var_dump($user);

    $stmt = $pdo->prepare($sql); // Préparation d'une requête.


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
