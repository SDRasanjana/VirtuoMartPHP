<?php
session_start();
require_once 'CartManager.php';

$cartManager = new CartManager();
$cartTotal = $cartManager->getCartTotal();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // submit the payment details
    $cardNumber = $_POST['card_number'];
    $cardHolder = $_POST['card_holder'];
    $expiryMonth = $_POST['expiry_month'];
    $expiryYear = $_POST['expiry_year'];
    $cvv = $_POST['cvv'];
    $shippingAddress = $_POST['shipping_address'];

    // Validate card number
    if (!preg_match('/^[0-9]{16}$/', $cardNumber)) {
        $errors[] = "Invalid card number. It should be 16 digits.";
    }

    // Validate card holder name
    if (empty($cardHolder)) {
        $errors[] = "Cardholder name is required.";
    }

    // Validate expiry date
    $currentYear = date('Y');
    $currentMonth = date('m');
    if ($expiryYear < $currentYear || ($expiryYear == $currentYear && $expiryMonth < $currentMonth)) {
        $errors[] = "The card has expired.";
    }

    // Validate CVV
    if (!preg_match('/^[0-9]{3,4}$/', $cvv)) {
        $errors[] = "Invalid CVV. It should be 3 or 4 digits.";
    }

    // Validate shipping address
    if (empty($shippingAddress)) {
        $errors[] = "Shipping address is required.";
    }

    // Store payment and shipping details in session
    if (empty($errors)) {
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    

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
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="order-container p-4">
            <h3 class="mb-4">Payment Details</h3>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" id="paymentForm">
                <div class="mb-3">
                    <label class="form-label">Card number</label>
                    <input type="text" class="form-control" name="card_number" id="card_number" required>
                    <div class="error-message" id="card_number_error"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cardholder name</label>
                    <input type="text" class="form-control" name="card_holder" id="card_holder" required>
                    <div class="error-message" id="card_holder_error"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label class="form-label">Expiry Month</label>
                        <select class="form-select" name="expiry_month" id="expiry_month" required>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Expiry Year</label>
                        <select class="form-select" name="expiry_year" id="expiry_year" required>
                            <?php for ($i = date('Y'); $i <= date('Y') + 10; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label">CVV</label>
                        <input type="text" class="form-control" name="cvv" id="cvv" required>
                        <div class="error-message" id="cvv_error"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Shipping Address</label>
                    <textarea class="form-control" name="shipping_address" id="shipping_address" rows="3" required></textarea>
                    <div class="error-message" id="shipping_address_error"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total Amount</label>
                    <input type="text" class="form-control" value="$<?php echo number_format($cartTotal, 2); ?>" readonly>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">Proceed to Checkout</button>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        let isValid = true;
        const cardNumber = document.getElementById('card_number');
        const cardHolder = document.getElementById('card_holder');
        const expiryMonth = document.getElementById('expiry_month');
        const expiryYear = document.getElementById('expiry_year');
        const cvv = document.getElementById('cvv');
        const shippingAddress = document.getElementById('shipping_address');

        // Reset error messages
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

        // Validate card number
        if (!/^[0-9]{16}$/.test(cardNumber.value)) {
            document.getElementById('card_number_error').textContent = 'Invalid card number. It should be 16 digits.';
            isValid = false;
        }

        // Validate card holder name
        if (cardHolder.value.trim() === '') {
            document.getElementById('card_holder_error').textContent = 'Cardholder name is required.';
            isValid = false;
        }

        // Validate expiry date
        const currentDate = new Date();
        const expiryDate = new Date(expiryYear.value, expiryMonth.value - 1);
        if (expiryDate <= currentDate) {
            document.getElementById('expiry_month').nextElementSibling.textContent = 'The card has expired.';
            isValid = false;
        }

        // Validate CVV
        if (!/^[0-9]{3,4}$/.test(cvv.value)) {
            document.getElementById('cvv_error').textContent = 'Invalid CVV. It should be 3 or 4 digits.';
            isValid = false;
        }

        // Validate shipping address
        if (shippingAddress.value.trim() === '') {
            document.getElementById('shipping_address_error').textContent = 'Shipping address is required.';
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault(); // Prevent form submission if there are errors
        }
    });
    </script>
</body>
</html>