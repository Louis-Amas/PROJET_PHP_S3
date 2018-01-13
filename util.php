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

function send_confirmation_email($email,$salt) {
  $message = 'Hello, Thanks for your re gistration please click here to activate your account: '.
  'http://projetsem3php.alwaysdata.net/?controller=user&action=activateaccount&email='.$email.'&salt='.$salt;


    $message = wordwrap($message,70,"\r\n");
      if (!mail($email,'Registration confirmation email',$message)){
        add_alert('danger', 'Error: '.$email . ' ' . $salt);
        redirect_to('/');
      }

}

function send_reset_email($email) {

  $user = User::findByEmail($email);
  if (!is_null($user)){
    $message = 'Hello, Follow this link to reset your password (ignore it if the action is not from you) '.
    'http://projetsem3php.alwaysdata.net/?controller=user&action=reset&email='.$email.'&salt='.$user->getSalt();
    $message = wordwrap($message,70,"\r\n");
      if (!mail($email,'Resetting password',$message)){
        add_alert('danger', 'Error: '.$email);
        redirect_to('/');
      }
  }
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
