<?php
class Util{
  public static function redirect_to($url){
    header('Location: ' . $url);
  }
  public static function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
      $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
  }

  public static function back(){
    ?>
    <script>
      window.history.back();
    </script>
    <?php
  }

  public static function can_acces($rights){
    if (empty($_SESSION['USER']) && $rights != null) {
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
  public static function must_be_user($id){
    if ($_SESSION['USER']['rights'] != 'ADM' && $_SESSION['USER']['id'] != $id){
      new Alert('danger','You cannot acces to this page');
      Util::redirect_to('index.php');
    }
  }
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
