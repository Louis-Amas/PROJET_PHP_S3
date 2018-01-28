<?php
class Email {
  private $destination;
  private $subject;
  private $message;
  public function __construct($destination,$message='',$subject=''){
    $this->destination = $destination;
    $this->message = $message;
    $this->subject=$subject;
  }
  /*
   *   Envoie d'un mail
   *
   */
  public function send(){
    return mail($this->destination,$this->subject,$this->message);
  }
  /*
   *   Envoie de l'email de confiramtion d'inscription
   *
   */
  public static function send_confirmation_email($email) {
    $user = User::findByEmail($email);
    $message = 'Hello, Thanks for your registration please click here to activate your account: '.
    'https://projetsem3php.alwaysdata.net/?controller=user&action=activateaccount&email='.$email.'&salt='.$user->getSalt();
    $message = wordwrap($message,70,"\r\n");
    $MyEmail = new Email($email,$message,'Registration confirmation email');
      if (!$MyEmail->send()){
        new Alert('danger', 'Error: '.$email . ' ' . $salt);
        Util::redirect_to('/');
      }
  }
  /*
   *   Envoie de l'email de reset de mot de passe
   *
   */
  public static function send_reset_email($email){
    $user = User::findByEmail($email);
    if (!is_null($user)){
      $message = 'Hello, Follow this link to reset your password (ignore it if the action is not from you) '.
      'https://projetsem3php.alwaysdata.net/?controller=user&action=reset&email='.$email.'&salt='.$user->getSalt();
      $message = wordwrap($message,70,"\r\n");
      $MyEmail = new Email($email,$message,'Resetting your password');
        if (!$MyEmail->send()){
          new Alert('danger', 'Error: '.$email);
          Util::redirect_to('/');
        }
    }
  }
}
