<?php
class Authentication {
    private $db;
    private $admin;
    private $customer;

    public function __construct(Database $db, Admin $admin, RegisteredCustomer $customer) {
        $this->db = $db;
        $this->admin = $admin;
        $this->customer = $customer;
    }

    public function authenticate($username, $password) {
        if ($this->admin->authenticate($username, $password)) {
            $this->setAdminSession($this->admin);
            return 'admin';
        }

        if ($this->customer->authenticate($username, $password)) {
            $this->setCustomerSession($this->customer);
            return 'customer';
        }

        return false;
    }

    private function setAdminSession($admin) {
        $_SESSION['user_id'] = $admin->getId();
        $_SESSION['username'] = $admin->getUsername();
        $_SESSION['email'] = $admin->getEmail();
        $_SESSION['is_admin'] = true;
    }

    private function setCustomerSession($customer) {
        $_SESSION['user_id'] = $customer->getId();
        $_SESSION['username'] = $customer->getUsername();
        $_SESSION['is_admin'] = false;
    }
}