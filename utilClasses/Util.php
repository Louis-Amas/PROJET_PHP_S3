<?php
class Util{
  /*
   *   Redirige vers la page passé en parametre
   *
   */
  public static function redirect_to($url){
    header('Location: ' . $url);
  }
  /*
   *   renvoie un string aléatoire
   *
   */
  public static function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
      $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
  }
  /*
   *   ramène à la page précédente
   *
   */
  public static function back(){
    ?>
    <script>
      window.history.back();
    </script>
    <?php
  }
  /*
   *   return true si l'utilisateur actuel peut accéder à la page en fonction de ses droits
   *
   */
  public static function can_acces($rights){
    if (empty($_SESSION) && $rights != null) {
      return false;
    }
    if ($rights != $_SESSION['USER']['rights']){
      if ($rights == 'PRE' && $_SESSION['USER']['rights'] == 'NOR'){
        return false;
      }
      elseif ($rights == 'TRA' && $_SESSION['USER']['rights'] =='NOR' || $_SESSION['USER']['rights'] =='PRE'){
        return false;
      }
      elseif ($rights == 'ADM') {
        return false;
      }
    }
    return true;
  }
  /*
   *   Empeche l'accès à une page pour un utilisateur n'ayant pas les droits suffisant
   *
   */
  public static function must_be_user($id){
    if ($_SESSION['USER']['rights'] != 'ADM' && $_SESSION['USER']['id'] != $id){
      new Alert('danger','You cannot acces to this page');
      Util::redirect_to('index.php');
    }
  }
  /*
   *   Empeche l'accès à une page pour une personne qui n'est pas connecté
   *
   */
  public static function must_connected($path = 'index.php', $rights = 'NOR'){
    if (empty($_SESSION)){
      new Alert('danger','You must be connected in order to access this page');
      self::redirect_to($path);
    }
    elseif (!self::can_acces($rights)){
      new Alert('danger','You don\'t have enough rights to acces this page');
      self::redirect_to($path);
    }
  }
  /*
   *   charge la langue sélectionné
   *
   */
  public static function load_lang($langCode) {
    // Lire le fichier json
   $allInternal = Sentence::findAllInternal();
   $listSentencesByID = array();
   foreach ($allInternal as $key => $value) {
     if($value->getLang()=='basic' || $value->getLang()==$langCode){
       $listSentencesByID[$value->getId()][$value->getLang()] = $value->getSentence();
     }
   }

   $lang =array();
   foreach ($listSentencesByID as $key => $value) {
     $internal = $value['basic'];
     $translated = $value[$langCode];
     $lang[$internal] = $translated;
   }
    return $lang;
  }
}
