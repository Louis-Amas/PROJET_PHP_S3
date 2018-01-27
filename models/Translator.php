<?php
class Translator {

  public function __construct($sentence) {
  }

  public function getTraduction($sentence) {
    return self::getTradByLang($sentence, $this->langS, $this->lang);
  }
  public static function getTradByLang($sentence, $lang) {
    $pdo = MyPdo::getConnection();
    $sql = 'select *
    from SENTENCE s
    where s.SENTENCE_ID IN (select se.SENTENCE_ID
    from SENTENCE se
    where se.SENTENCE = :sentence) and s.LANG = :lang';
    $stmt = $pdo->prepare($sql); // Préparation d'une requête
    $params =  array(':sentence' => $sentence->getSentence(),  ':lang' => $lang);
    $stmt->execute($params); // Exécution de la requête.
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    while ($result = $stmt->fetch())
    {
      return new Sentence($result);
    }
  }

  public function addNewTrad($sentence, $translation) {
    $pdo = MyPdo::getConnection();
    $sql = 'insert into SENTENCE(LANG, SENTENCE)
    select l.LANG, :sentence
    from LANG l
    where l.LANG = :langS';
    $stmt = $pdo->prepare($sql); // Préparation d'une requête
    $stmt->bindValue('langS', $sentence->getLang(), PDO::PARAM_STR);
    $stmt->bindValue('sentence', $sentence->getSentence(), PDO::PARAM_STR);
    $params =  array(':langS' => $sentence->getLang(), ':sentence' => $sentence->getSentence());
    try {
      $stmt->execute($parameters);
      Translator::addNewTradFromExistingSentence($sentence, $translation);
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

  public function addNewTradFromExistingSentence($sentence, $translation) {
    $pdo = MyPdo::getConnection();
    $sql = 'insert into SENTENCE(SENTENCE_ID, LANG, SENTENCE)
    select s.SENTENCE_ID, :langT, :translation
    from SENTENCE s
    where s.SENTENCE = :sentence';
    $stmt = $pdo->prepare($sql); // Préparation d'une requête
    $stmt->bindValue('langT', $translation->getLang(), PDO::PARAM_STR);
    $stmt->bindValue('sentence', $sentence->getSentence(), PDO::PARAM_STR);
    $stmt->bindValue('translation', $translation->getSentence(), PDO::PARAM_STR);
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
}
