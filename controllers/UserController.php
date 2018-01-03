<?php
    require 'models/User.php';
    require_once 'util.php';

    class UserController {

        public static $path = '/?controller=user&action=';

        public function index() {
            $tab = User::findAll();
            $path = $this::$path . 'show&id=';
            require 'views/user/index.php';
        }

        public function loginPage() {
            $path = $this::$path . 'login';
            require 'views/user/loginPage.php';
        }

        public function login() {
            $username = filter_input(INPUT_POST, 'USERNAME');
            $password = filter_input(INPUT_POST, 'PASSWORD');
            $user = User::findByUsername($username);
            var_dump($user);
            if ($user == null) {
                add_alert('danger','Wrong username');
                redirect_to($this::$path . 'loginPage');
            }
            else {
                var_dump($user);    
                if ($user->verifyPassword($password)) {
                    $_SESSION['USER_ID'] = $user->getId();
                    add_alert('success', 'Welcome');
                    redirect_to('/');
                }
                else {
                    add_alert('danger', 'Wrong password');
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
                self::index();
            require 'views/user/show.php';
        }


        public function edit() {
            $id = filter_input(INPUT_GET, 'id');
            $user = User::findById($id);
            if ($user == null) 
                self::index();
            require 'views/user/edit.php';
        }

        public function create() {
            global $lang;
            $password =filter_input(INPUT_POST, 'PASSWORD');
            $confPassword = filter_input(INPUT_POST, 'confirmPassword');
            var_dump($_POST);
            $user = new User($_POST, 1);
            if ($password != $confPassword) {
                add_alert('danger', $lang['PASSDOESNTMATCH']);
                redirect_to($this::$path . 'new');
            }
            else if (User::insert($user)) {
                add_alert('success', $lang['HAPPYINSCRIPTION']);
                redirect_to('/');
            }
            else {
                add_alert('danger', $lang['BADINSCRIPTION']);
                redirect_to($this::$path . 'new' ); 
                
            }
        }

        public function update() {

        }
        
        public function destroy() {

        }
    }
?>