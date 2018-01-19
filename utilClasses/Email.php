<?php
class Email {
  private $destination;
  private $subject;
  private $message;
  public function __construct($destination,$message,$subject=''){
    $this->destination = $destination;
    $this->message = $message;
    $this->subject=$subject;
  }
  public function send(){
    return mail($this->destination,$this->subject,$this->message);
  }

  public static function send_confirmation_email($email) {
    $user = User::findByEmail($email);
    $message = 'Hello, Thanks for your re gistration please click here to activate your account: '.
    'http://projetsem3php.alwaysdata.net/?controller=user&action=activateaccount&email='.$email.'&salt='.$user->getSalt();
    $message = wordwrap($message,70,"\r\n");
    $MyEmail = new Email($email,$message,'Registration confirmation email');
      if ($MyEmail->send()){
        add_alert('danger', 'Error: '.$email . ' ' . $salt);
        redirect_to('/');
      }
  }
  public static function send_reset_email($email){
    $user = User::findByEmail($email);
    if (!is_null($user)){
      $message = 'Hello, Follow this link to reset your password (ignore it if the action is not from you) '.
      'http://projetsem3php.alwaysdata.net/?controller=user&action=reset&email='.$email.'&salt='.$user->getSalt();
      $message = wordwrap($message,70,"\r\n");
      $MyEmail = new Email($email,$message,'Resetting your password');
        if ($MyEmail->send()){
          add_alert('danger', 'Error: '.$email);
          redirect_to('/');
        }
    }
  }
}
