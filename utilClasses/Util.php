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
  public static function load_lang($url) {
      // Lire le fichier json
      $json = file_get_contents($url);

      // Transformer json en Array php
      $json_data = json_decode($json, true);
      $array = $json_data['lang'];
      $lang;
      foreach ($array as $value) {
          foreach ($value as $key => $val) {
              $lang[$key] = $val;
          }
      }
      return $lang;
  }
}
