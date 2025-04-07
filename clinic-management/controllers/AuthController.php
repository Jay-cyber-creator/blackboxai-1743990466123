<?php
class AuthController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = $this->userModel->login($email, $password);
            
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_role'] = $user->role;
                
                // Redirect based on role
                header('Location: /' . $user->role . '/dashboard');
                exit();
            } else {
                $error = "Invalid email or password";
                require_once 'views/auth/login.php';
            }
        } else {
            require_once 'views/auth/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => $_POST['role'] ?? 'patient'
            ];
            
            if ($this->userModel->register($data)) {
                // Registration successful - redirect to login
                header('Location: /auth/login');
                exit();
            } else {
                $error = "Registration failed";
                require_once 'views/auth/register.php';
            }
        } else {
            require_once 'views/auth/register.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /');
        exit();
    }
}