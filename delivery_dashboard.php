<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .dashboard-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            margin-bottom: 30px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .update-btn {
            width: 100%;
        }
        .stats-container {
            margin-top: 30px;
        }
        .stat-box {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            height: 100%;
        }
        .stat-box h5 {
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        .stat-box p {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-container">
            <h1>Delivery Dashboard</h1>
            <form>
                <div class="form-group">
                    <label for="orderID">Order ID</label>
                    <input type="text" class="form-control" id="orderID">
                </div>
                <div class="form-group">
                    <label for="ProductID">Product ID</label>
                    <input type="text" class="form-control" id="ProductID">
                </div>
                <div class="form-group">
                    <label for="deliveryMemberID">Delivery Member ID</label>
                    <input type="text" class="form-control" id="deliveryMemberID">
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <select class="form-control" id="state">
                        <option selected>Choose...</option>
                        
                    </select>
                </div>
                <button type="submit" class="btn btn-info update-btn">Update</button>
            </form>
            
            <div class="row stats-container">
                <div class="col-md-4 mb-3">
                    <div class="stat-box">
                        <h5>No. of products processing</h5>
                        <p>0</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-box">
                        <h5>No. of products shipped</h5>
                        <p>0</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-box">
                        <h5>No. of products delivered</h5>
                        <p>1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>