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
        public function unlogin() {
            unset($_SESSION['USER']);
            redirect_to('/');
        }
        public function login() {
            global $lang;
            $username = filter_input(INPUT_POST, 'USERNAME');
            $password = filter_input(INPUT_POST, 'PASSWORD');
            $user = User::findByUsername($username);
            if ($user == null) {
                add_alert('danger',$lang['ERROR_WRONG_USERNAME']);
                redirect_to($this::$path . 'loginPage');
            }
            else {
                if ($user->verifyPassword($password)) {
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

        public function create() {
            $path = $this::$path . 'createAction';
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

            $path = $this::$path . 'update&id=' . $id;
            if ($user == null)
               self::index();
            require 'views/user/edit.php';
        }

        public function createAction() {
            global $lang;
            $password =filter_input(INPUT_POST, 'PASSWORD');
            $confPassword = filter_input(INPUT_POST, 'confirmPassword');
            $user = new User($_POST, 1);
            if ($password != $confPassword) {
                add_alert('danger', $lang['PASS_DOESNT_MATCH']);
                redirect_to($this::$path . 'new');
            }
            else if (User::insert($user)) {
                add_alert('success', $lang['HAPPY_INSCRIPTION']);
                redirect_to('/');
            }
            else {
                add_alert('danger', $lang['BAD_INSCRIPTION']);
                redirect_to($this::$path . 'new' );

            }
        }

        public function update() {
            global $lang;
            $id = filter_input(INPUT_GET, 'id');
            $user = User::findById($id);
            if ($user == null) {
                add_alert('danger', $lang['USER_NOT_EXIST']);
                redirect_to($this::$path . 'index');
            }
            else {
                $oldPassword = filter_input(INPUT_POST, 'OLDPASSWORD');
                if ( $user->verifyPassword($oldPassword)) {

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
