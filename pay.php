<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="order-container p-4">
            <h3 class="mb-4">Order Confirmation</h3>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h4>Product Details</h4>
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="img/products/f1.jpg" class="img-fluid rounded-start product-image" alt="Baseball Cap">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">New Unisex Baseball Cap</h5>
                                    <p class="card-text">Spring And Autumn Outdoor Recreational Sports Fishing Embroidery</p>
                                    <p class="card-text"><small class="text-muted">Adjustable, black</small></p>
                                    <p class="card-text"><strong>US $2.59</strong></p>
                                    <div class="input-group input-group-sm" style="max-width: 100px;">
                                        <button class="btn btn-outline-secondary" type="button">-</button>
                                        <input type="text" class="form-control text-center" value="1">
                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Shipping</h5>
                            <p class="card-text">US $0.99</p>
                            <p class="card-text"><small class="text-muted">Estimated delivery between Aug 04 - 09</small></p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h4>Payment Details</h4>
                    <p class="text-success mb-4"><i class="bi bi-shield-check"></i> Your payment information is safe with us</p>
                    
                    <form>
                        <div class="mb-3">
                        <label class="form-label">Select payment method</label>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="cashOnDelivery">
                            <label class="form-check-label" for="cashOnDelivery">Cash On Delivery Payment</label>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="OnlinePayment">
                            <label class="form-check-label" for="onlinePayment">Card Payment</label>
                        </div>
                            <label class="form-label">Add a new card</label>
                            <div class="card-icons">
                                <img src="img/pay/visa.png" alt="Visa">
                                <img src="img/pay/mastercard.png" alt="Mastercard">
                                <img src="img/pay/jcb.jpeg" alt="JCB">
                                <img src="img/pay/amex.png" alt="American Express">
                            </div>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Card number">
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <select class="form-select">
                                    <option selected>MM</option>
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                                <option>04</option>
                                <option>05</option>
                                <option>06</option>
                                <option>07</option>
                                <option>08</option>
                                <option>09</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <select class="form-select">
                                    <option selected>YY</option>
                                     <option>26</option>
                                     <option>27</option>
                                    <option>28</option>
                                    <option>29</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" placeholder="CVV">
                            </div>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Cardholder name">
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Amount Rs.">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="saveCard">
                            <label class="form-check-label" for="saveCard">Save card details</label>
                        </div>
                        <p class="text-muted mb-4"><small><i class="bi bi-info-circle"></i> Your order will be processed in LKR</small></p>

                        <button type="submit" class="btn btn-confirm btn-lg w-100 text-white">Confirm & pay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>