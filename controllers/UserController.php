<?php
    require 'models/User.php';
    require_once 'util.php';

    class UserController {

        public static $path = '/?controller=user&action=';

        public function index() {
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
          send_reset_email($email);
          add_alert('success','An email as just been sent to '.$email);
          redirect_to('/');
        }

        public function unlogin() {
            unset($_SESSION['USER']);
            redirect_to('/');
        }
        public function login() {
            global $lang;

            $username = filter_input(INPUT_POST, 'USERNAME');
            $password = filter_input(INPUT_POST, 'PASSWORD');
            $user = User::findByUsername($username);
            if ($_POST['submit']=="forgot"){
              redirect_to($this::$path . 'forgotPassword');
              exit;
            }
            if ($user == null) {
                add_alert('danger',$lang['ERROR_WRONG_USERNAME']);
                redirect_to($this::$path . 'loginPage');
            }
            else {
                if (!$user->isActivated()){
                  add_alert('danger', 'This account is not activated please check out your emails');
                  redirect_to('/');
                }
                elseif ($user->verifyPassword($password)) {
                    $_SESSION['USER']['id'] = $user->getId();
                    $_SESSION['USER']['username'] = $user->getUsername();
                    add_alert('success', $lang['WELCOME'] . ' ' . $user->getUsername());
                    redirect_to('/');
                }
                else {
                    add_alert('danger', $lang['ERROR_WRONG_PASSWORD']);
                    redirect_to($this::$path . 'loginPage');
                }
            }
        }

        public function new() {
            $path = $this::$path . 'create';
            require 'views/user/new.php';
        }

        public function show() {
            $id = filter_input(INPUT_GET, 'id');
            $user = User::findById($id);
            if ($user == null)
                redirect_to('/');
            require 'views/user/show.php';
        }


        public function reset() {
          $email = filter_input(INPUT_GET, 'email');
          $salt = filter_input(INPUT_GET,'salt');
          if(is_null($email) || is_null($salt)){
            add_alert('danger', 'An error occured please contact an administrator');
            redirect_to('/');
            exit;
          }
          $user = User::findByEmail($email);
          if($user->getSalt() != $salt){
            add_alert('danger', 'Verification error please contact an administrator');
            redirect_to('/');
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
              add_alert('success','Your account have been activated !');
              redirect_to('/');
            } else{
              add_alert('danger', 'An error occured please contact an administrator');
              redirect_to('/');
            }

        }

        public function create() {
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
                add_alert('danger', $lang['PASS_DOESNT_MATCH']);
                redirect_to($this::$path . 'new');
            }
            elseif (strlen($choosenname) > 32) {
              add_alert('danger',$lang['BAD_INSCRIPTION'].': Username too long');
              redirect_to(self::$path.'new');
            }
            elseif (array_search(null,$_POST)) {
              add_alert('danger', $lang['BAD_INSCRIPTION'] . ': Please fill all the fields');
              redirect_to($this::$path . 'new');
            }
            else if (User::insert($user)) {
                add_alert('success', $lang['HAPPY_INSCRIPTION'].'EMAIL :'.$email);
                send_confirmation_email($email,User::findByEmail($email)->getSalt());
                redirect_to('/');
            }
            else {
                add_alert('danger', $lang['BAD_INSCRIPTION']);
                redirect_to($this::$path . 'new' );

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
                add_alert('danger', $lang['USER_NOT_EXIST']);
                redirect_to($this::$path . 'index');
            }
            else {
                $oldPassword = filter_input(INPUT_POST, 'OLDPASSWORD');
                if ( $reseting || $user->verifyPassword($oldPassword)) {

                    $newPassword = filter_input(INPUT_POST, 'PASSWORD');
                    if ($newPassword == null) {
                        redirect_to($this::$path . 'edit&id='. $id);
                    }
                    else {
                        $newPasswordConfirm = filter_input(INPUT_POST, 'confirmPassword');
                        if ($newPassword == $newPasswordConfirm) {
                            $user->setPassword($newPassword);
                            User::update($user, 1);
                            add_alert('success', $lang['SUCCESSFULL_UPDATE']);
                            redirect_to($this::$path . 'show&id='. $id);
                        }
                        else {
                            add_alert('danger', $lang['PASS_DOESNT_MATCH'] . ' !');
                            redirect_to($this::$path . 'edit&id='. $id);
                        }
                    }
                }
                else {
                    add_alert('danger', $lang['ERROR_WRONG_PASSWORD']);
                    redirect_to($this::$path . 'edit&id='. $id);
                }

            }
        }

        public function destroy() {

        }
    }
