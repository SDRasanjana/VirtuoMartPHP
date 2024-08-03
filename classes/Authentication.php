<?php
class Authentication {
    private $db;
    private $admin;
    private $customer;
    private $deliveryMember;
    private $owner;

    public function __construct(Database $db, Admin $admin, RegisteredCustomer $customer, DeliveryMember $deliveryMember, Owner $owner) {
        $this->db = $db;
        $this->admin = $admin;
        $this->customer = $customer;
        $this->deliveryMember = $deliveryMember;
        $this->owner = $owner;
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
        if ($this->deliveryMember->authenticate($username, $password)) {
            $this->setDeliveryMemberSession($this->deliveryMember);
            return 'delivery_member';
        }

        if ($this->owner->authenticate($username, $password)) {
            $this->setOwnerSession($this->owner);
            return 'owner';
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
    private function setDeliveryMemberSession($deliveryMember) {
        $_SESSION['user_id'] = $deliveryMember->getId();
        $_SESSION['username'] = $deliveryMember->getUsername();
        $_SESSION['is_admin'] = false;
    }

    private function setOwnerSession($owner) {
        $_SESSION['user_id'] = $owner->getId();
        $_SESSION['username'] = $owner->getUsername();
        $_SESSION['is_admin'] = false;
    }
}