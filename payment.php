<?php
session_start();
require_once 'CartManager.php';

$cartManager = new CartManager();
$cartTotal = $cartManager->getCartTotal();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // submit the payment details
    $cardNumber = $_POST['card_number'];
    $cardHolder = $_POST['card_holder'];
    $expiryMonth = $_POST['expiry_month'];
    $expiryYear = $_POST['expiry_year'];
    $cvv = $_POST['cvv'];
    $shippingAddress = $_POST['shipping_address'];

    // Store payment and shipping details in session
    $_SESSION['payment_details'] = [
        'card_number' => $cardNumber,
        'card_holder' => $cardHolder,
        'expiry_month' => $expiryMonth,
        'expiry_year' => $expiryYear,
        'cvv' => $cvv
    ];
    $_SESSION['shipping_address'] = $shippingAddress;

    // go back to checkout.php
    header('Location: checkout.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .order-container {
            max-width: 800px;
            margin: 2rem auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-control, .form-select {
            border-radius: 5px;
        }
        .card-icons img {
            height: 25px;
            margin-right: 10px;
        }
        .btn-confirm {
            background-color: #e63946;
            border: none;
        }
        .btn-confirm:hover {
            background-color: #d62828;
        }
        .product-image {
            max-width: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="order-container p-4">
            <h3 class="mb-4">Payment Details</h3>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Card number</label>
                    <input type="text" class="form-control" name="card_number" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cardholder name</label>
                    <input type="text" class="form-control" name="card_holder" required>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label class="form-label">Expiry Month</label>
                        <select class="form-select" name="expiry_month" required>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Expiry Year</label>
                        <select class="form-select" name="expiry_year" required>
                            <?php for ($i = date('Y'); $i <= date('Y') + 10; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label">CVV</label>
                        <input type="text" class="form-control" name="cvv" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Shipping Address</label>
                    <textarea class="form-control" name="shipping_address" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total Amount</label>
                    <input type="text" class="form-control" value="$<?php echo number_format($cartTotal, 2); ?>" readonly>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">Proceed to Checkout</button>
            </form>
        </div>
    </div>
</body>
</html>