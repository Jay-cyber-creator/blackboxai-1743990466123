<?php
class User {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function register($data) {
        $this->db->query('INSERT INTO users (email, password, role) VALUES (:email, :password, :role)');
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':role', $data['role'] ?? 'patient');
        
        return $this->db->execute();
    }

    public function login($email, $password) {
        $user = $this->findByEmail($email);
        if($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
}