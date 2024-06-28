<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link rel="stylesheet" href="pdstyles.css">
</head>
<body>
    <div class="container">
        <div class="product">
            <div class="product-images">
                <img src="img/products/f1.jpg" alt="Product Image">
                <div class="thumbnail-images">
                    <img src="img/products/f1.jpg" alt="Thumbnail 1">
                    <img src="img/products/f2.jpg" alt="Thumbnail 2">
                    <img src="img/products/f3.jpg" alt="Thumbnail 3">
                    <img src="img/products/f4.jpg" alt="Thumbnail 4">
                </div>
            </div>
            <div class="product-details">
                <h1>T-Shirt Republic - Raven Black Men's Premium Long Sleeve T Shirt</h1>
                <div class="price">
                    <span class="new-price">Rs. 1,350</span>
                    <span class="old-price">Rs. 1,650</span>
                    <span class="discount">-18%</span>
                </div>
                <p class="promotion">Min. Spend Rs. 439 Capped at Rs. 200</p>
                <p class="installment">Installment Offers available up to 3 months</p>
                <p class="color">Color Family: <span>Black</span></p>
                <div class="sizes">
                    <label for="size">Size:</label>
                    <select id="size" name="size">
                        <option value="s">S</option>
                        <option value="m">M</option>
                        <option value="l">L</option>
                        <option value="xl">XL</option>
                        <option value="xxl">XXL</option>
                    </select>
                </div>
                <div class="quantity">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" value="1">
                </div>
                <button class="buy-now">Buy Now</button>
                <button class="add-to-cart">Add to Cart</button>
                <div class="ratings">
                    <span>4.8</span> Top Rated
                    <div class="stars">
                        <span>⭐⭐⭐⭐⭐</span>
                        <span>(1074 ratings)</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="delivery">
            <h2>Delivery</h2>
            <p>Western, Colombo 1-15, Colombo 01 - Fort</p>
            <p>Standard Delivery: Rs. 250</p>
            <p>Cash on Delivery Available</p>
        </div>
        <div class="service">
            <h2>Service</h2>
            <p>100% Authentic from Trusted Brand</p>
            <p>14 days free & easy return</p>
            <p>Warranty not available</p>
        </div>
    </div>
    <script>
        // JavaScript for image thumbnail click events
const thumbnails = document.querySelectorAll('.thumbnail-images img');
const mainImage = document.querySelector('.product-images img');

thumbnails.forEach(thumbnail => {
    thumbnail.addEventListener('click', () => {
        mainImage.src = thumbnail.src;
    });
});

    </script>
</body>
</html>
