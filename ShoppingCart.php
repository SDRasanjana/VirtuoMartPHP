<?php
require_once 'product_be.php';

class ShoppingCart {
    private $items = [];

    public function addItem(Product $product, $quantity = 1) {
        $id = $product->getId();
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] += $quantity;
        } else {
            $this->items[$id] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
    }

    public function removeItem($productId) {
        unset($this->items[$productId]);
    }

    public function updateQuantity($productId, $quantity) {
        if (isset($this->items[$productId])) {
            $this->items[$productId]['quantity'] = $quantity;
        }
    }

    public function getItems() {
        return $this->items;
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }

    public function clearCart() {
        $this->items = [];
    }

    public function getItemCount() {
        return count($this->items);
    }
}