<?php

function load_lang($url) {
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
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
        {
            $str = '';
            $max = mb_strlen($keyspace, '8bit') - 1;
            for ($i = 0; $i < $length; ++$i) {
                $str .= $keyspace[random_int(0, $max)];
            }
            return $str;
}
function add_alert($type, $message) {
    if (!isset($_SESSION['alerts'][$type]) || !is_array($_SESSION['alerts'][$type]) ) {
            $_SESSION['alerts'][$type] = [];
        } 
    $_SESSION['alerts'][$type] = $message;
}
function show_alerts() {
        if ($_SESSION['alerts']) {
          foreach ($_SESSION['alerts'] as $key => $value) {
                echo '<div class="alert alert-'. $key . '" role="alert">' . $value . '</div>';
        }
        unset($_SESSION['alerts']);
      }
}

function redirect_to($url) {
        header('Location: ' . $url);
}

?>