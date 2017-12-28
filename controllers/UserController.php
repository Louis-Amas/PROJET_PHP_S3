<?php
    require 'models/User.php';
    require_once 'Controller.php';
    class UserController extends Controller {

        public function index() {
            $tab = User::findAll();
            $path = '?controller=user&action=show&id=';
            require 'views/user/index.php';
        }

        public function new() {
            $path = '?controller=user&action=create';
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
            $user = new User($_POST, 1);
            if (User::insert($user))
                echo 'yes';
            else
                self::signin();
        }

        public function update() {

        }
        
        public function destroy() {

        }
    }
?>