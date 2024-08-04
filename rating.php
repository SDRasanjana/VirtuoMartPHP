<?php
require_once './DbConnector.php';
$dbconnector = new DbConnector();
$conn = $dbconnector->getConnection();

// data handle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST["rating"];
    $title = $_POST["reviewTitle"];
    $text = $_POST["reviewText"];

    $sql = "INSERT INTO customer_reviews (rating, title, review_text) VALUES (:rating, :title, :text)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':text', $text, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $response = ["success" => true];
    } else {
        $response = ["success" => false, "error" => $stmt->errorInfo()[2]];
    }

    echo json_encode($response);
    exit();
}

// display saved reviews
$sql = "SELECT * FROM customer_reviews ORDER BY created_at DESC";
$stmt = $conn->query($sql);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Review and Rating</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .star-rating {
            font-size: 0;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            padding: 5px;
            font-size: 24px;
            color: #ddd;
            float: right;
            transition: color 0.2s;
        }
        .star-rating label:before {
            content: '\f005';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }
        .star-rating input:checked ~ label {
            color: #ffc107;
        }
        .star-rating:not(:checked) label:hover,
        .star-rating:not(:checked) label:hover ~ label {
            color: #ffd700;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Product Review</h2>
        <div class="card">
            <div class="card-body">
                <form id="reviewForm">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Your Rating</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" />
                            <label for="star5" title="5 stars"></label>
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4" title="4 stars"></label>
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3" title="3 stars"></label>
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2" title="2 stars"></label>
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1" title="1 star"></label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="reviewTitle" class="form-label">Review Title</label>
                        <input type="text" class="form-control" id="reviewTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="reviewText" class="form-label">Your Review</label>
                        <textarea class="form-control" id="reviewText" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
        </div>

        <div class="mt-5">
            <h3>Customer Reviews</h3>
            <div id="reviewsContainer">
                <?php foreach ($reviews as $review): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($review['title']); ?></h5>
                            <p class="card-text"><?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($review['review_text']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const rating = document.querySelector('input[name="rating"]:checked').value;
            const title = document.getElementById('reviewTitle').value;
            const text = document.getElementById('reviewText').value;

            fetch('rating.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `rating=${rating}&reviewTitle=${encodeURIComponent(title)}&reviewText=${encodeURIComponent(text)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    addReview(rating, title, text);
                    this.reset();
                } else {
                    alert('Error saving review. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving review. Please try again.');
            });
        });

        function addReview(rating, title, text) {
            const reviewsContainer = document.getElementById('reviewsContainer');
            const reviewElement = document.createElement('div');
            reviewElement.className = 'card mb-3';
            reviewElement.innerHTML = `
                <div class="card-body">
                    <h5 class="card-title">${title}</h5>
                    <p class="card-text">${'★'.repeat(rating)}${'☆'.repeat(5-rating)}</p>
                    <p class="card-text">${text}</p>
                </div>
            `;
            reviewsContainer.insertBefore(reviewElement, reviewsContainer.firstChild);
        }
    </script>
</body>
</html>