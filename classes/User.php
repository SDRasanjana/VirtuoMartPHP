<?php
abstract class User {
    protected $db;
    protected $id;
    protected $username;
    protected $email;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    abstract public function authenticate($username, $password);

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }
}