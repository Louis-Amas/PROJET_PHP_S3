<?php
require 'models/User.php';
require_once 'utilClasses/Email.php';
class UserController {
  public static $path = '/?controller=user&action=';
  public function index() {
    Util::must_connected($this::$path.'loginPage');
    $tab = User::findAllActivated();
    $path = $this::$path . 'show&id=';
    require 'views/user/index.php';
  }
  public function loginPage() {
    $path = $this::$path . 'login';
    require 'views/user/loginPage.php';
  }
  public function forgotPassword(){
    $path = $this::$path . 'forgot';
    require 'views/user/forgotPassword.php';
  }
  public function forgot()
  {
    $email = filter_input(INPUT_POST,'EMAIL');
    Email::send_reset_email($email);
    new Alert('success','An email as just been sent to '.$email);
    Util::redirect_to('/');
  }
  public function unlogin() {
    unset($_SESSION['USER']);
    Util::redirect_to('/');
  }
  public function login() {
    global $lang;
    $username = filter_input(INPUT_POST, 'USERNAME');
    $password = filter_input(INPUT_POST, 'PASSWORD');
    $user = User::findByUsername($username);
    if ($_POST['submit']=="forgot"){
      Util::redirect_to($this::$path . 'forgotPassword');
      exit;
    }
    if ($user == null) {
      new Alert('danger',$lang['ERROR_WRONG_USERNAME']);
      Util::redirect_to($this::$path . 'loginPage');
    }
    else {
      if (!$user->isActivated()){
        new Alert('danger', 'This account is not activated please check out your emails');
        Util::redirect_to('/');
      }
      elseif ($user->verifyPassword($password)) {
        $_SESSION['USER']['id'] = $user->getId();
        $_SESSION['USER']['username'] = $user->getUsername();
        $_SESSION['USER']['rights'] = $user->getType();
        new Alert('success', $lang['WELCOME'] . ' ' . $user->getUsername());
        Util::redirect_to('/');
      }
      else {
        new Alert('danger', $lang['ERROR_WRONG_PASSWORD']);
        Util::redirect_to($this::$path . 'loginPage');
      }
    }
  }
  public function create() {
    $path = $this::$path . 'createAction';
    require 'views/user/create.php';
  }
  public function show() {
    $id = filter_input(INPUT_GET, 'id');
    Util::must_be_user($id);
    $user = User::findById($id);
    if ($user == null)
    Util::redirect_to('/');

    $path = $this::$path . 'edit&id=' . $id;
    require 'views/user/show.php';
  }
  public function reset() {
    $email = filter_input(INPUT_GET, 'email');
    $salt = filter_input(INPUT_GET,'salt');
    if(is_null($email) || is_null($salt)){
      new Alert('danger', 'An error occured please contact an administrator');
      Util::redirect_to('/');
      exit;
    }
    $user = User::findByEmail($email);
    if($user->getSalt() != $salt){
      new Alert('danger', 'Verification error please contact an administrator');
      Util::redirect_to('/');
      exit;
    }
    $id = $user->getId();
    $path = $this::$path . 'reseting&id=' . $id;
    if ($user == null)
    self::index();
    require 'views/user/reset.php';
  }
  public function edit() {
    $id = filter_input(INPUT_GET, 'id');
    Util::must_be_user($id);
    $user = User::findById($id);
    $path = $this::$path . 'update&id=' . $id;
    if ($user == null)
    self::index();
    require 'views/user/edit.php';
  }
  public function activateaccount(){
    $email = filter_input(INPUT_GET,'email');
    $salt = filter_input(INPUT_GET,'salt');
    $user = User::findByEmail($email);
    if ($user && $user->getSalt() == $salt){
      $user->activate();
      new Alert('success','Your account have been activated !');
      Util::redirect_to('/');
    } else{
      new Alert('danger', 'An error occured please contact an administrator');
      Util::redirect_to('/');
    }
  }

  public function createAction() {
    global $lang;
    $password =filter_input(INPUT_POST, 'PASSWORD');
    $confPassword = filter_input(INPUT_POST, 'confirmPassword');
    $choosenname = filter_input(INPUT_POST, 'USERNAME');
    $email = filter_input(INPUT_POST, 'EMAIL');
    $user = new User($_POST, 1);
    $captcha = filter_input(INPUT_POST,'g-recaptcha-response');
    $captchaValidation = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LeTWUAUAAAAAMCWwcOelu8Wc3kxrnnBmUR1B3p9&response='.$captcha);
    $responseKeys=json_decode($captchaValidation,true);
    if ($password != $confPassword) {
      new Alert('danger', $lang['PASS_DOESNT_MATCH']);
      Util::redirect_to($this::$path . 'create');
    }
    elseif (strlen($choosenname) > 32) {
      new Alert('danger',$lang['BAD_INSCRIPTION'].': Username too long');
      Util::redirect_to(self::$path.'create');
    }
    elseif (array_search(null,$_POST)) {
      new Alert('danger', $lang['BAD_INSCRIPTION'] . ': Please fill all the fields');
      Util::redirect_to($this::$path . 'create');
    }
    else if (User::insert($user)) {
      new Alert('success', $lang['HAPPY_INSCRIPTION'].'EMAIL :'.$email);
      Email::send_confirmation_email($email,'');
      #send_confirmation_email($email,User::findByEmail($email)->getSalt());
      Util::redirect_to('/');
    }
    else {
      new Alert('danger', $lang['BAD_INSCRIPTION'].': User already exist');
      Util::redirect_to($this::$path . 'create' );
    }
  }

  public function reseting(){
    self::update(true);
  }
  public function update($reseting=false) {
    global $lang;
    $id = filter_input(INPUT_GET, 'id');
    $user = User::findById($id);
    if ($user == null) {
      new Alert('danger', $lang['USER_NOT_EXIST']);
      Util::redirect_to($this::$path . 'index');
    }
    else {
      $newPassword = filter_input(INPUT_POST,'PASSWORD');
      $newPasswordConfirm = filter_input(INPUT_POST, 'confirmPassword');
      $oldPassword = filter_input(INPUT_POST, 'OLDPASSWORD');
      $username = filter_input(INPUT_POST, 'USERNAME');
      $mode = 0;
      if (!is_null($username))
        $user->setUsername($username);
      if ($reseting || $user->verifyPassword($oldPassword)){
        if (!empty($newPassword) && $newPassword == $newPasswordConfirm){
            $user->setPassword($newPassword);
            $mode = 1;
        }
        elseif (!empty($newPassword) && $newPassword != $newPasswordConfirm){
          new Alert('danger', $lang['PASS_DOESNT_MATCH'] . ' !');
          Util::redirect_to($_SERVER['HTTP_REFERER']);
          return;
        }
        User::update($user, $mode);
        new Alert('success', $lang['SUCCESSFULL_UPDATE']);
        Util::redirect_to($this::$path . 'show&id='. $id);
      }
      elseif (empty($oldPassword)){
        new Alert('warning','You need to fill \'Old password\' in order to edit your account' );
        Util::redirect_to($this::$path . 'edit&id='. $id);
      }
      else {
        new Alert('danger', $lang['ERROR_WRONG_PASSWORD']);
        Util::redirect_to($this::$path . 'edit&id='. $id);
      }
    }
  }
  public function destroy() {
  }
}
