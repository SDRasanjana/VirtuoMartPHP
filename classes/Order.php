<?php
class Order {
    private $id;
    private $customerId;
    private $orderDate;
    private $totalAmount;
    private $status;

    public function __construct($customerId, $totalAmount) {
        $this->customerId = $customerId;
        $this->orderDate = date('Y-m-d H:i:s');
        $this->totalAmount = $totalAmount;
        $this->status = 'Pending';
    }

    
    public function getId() {
         return $this->id; 
        }
    public function setId($id) {
         $this->id = $id; 
        }
    public function getCustomerId() {
         return $this->customerId;
         }
    public function getOrderDate() {
         return $this->orderDate; 
        }
    public function getTotalAmount() {
         return $this->totalAmount;
         }
    public function getStatus() {
         return $this->status; 
        }
    public function setStatus($status) {
         $this->status = $status;
         }
}