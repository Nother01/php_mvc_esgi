<?php

require_once __DIR__ . '/../Models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['success'] = 'Connexion réussie';
                header('Location: /tasks');
                exit;
            } else {
                $_SESSION['error'] = 'email ou mot de passe incorrect';
            }
        }

        include __DIR__ . '/../Views/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->userModel->register($name, $email, $password)) {
                $_SESSION['success'] = 'inscription réussie';
                header('Location: /login');
                exit;
            } else {
                $_SESSION['error'] = 'erreur lors de l\'inscription';
            }
        }

        include __DIR__ . '/../Views/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}