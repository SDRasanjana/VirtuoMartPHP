<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $product = $_POST['product'];
    $message = $_POST['message'];
    
    // Handle the image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageSize = $image['size'];
        $imageError = $image['error'];
        $imageType = $image['type'];

        $imageExt = explode('.', $imageName);
        $imageActualExt = strtolower(end($imageExt));

        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($imageActualExt, $allowed)) {
            if ($imageError === 0) {
                if ($imageSize < 5000000) { // 5MB
                    $imageNameNew = uniqid('', true) . "." . $imageActualExt;
                    $imageDestination = 'uploads/' . $imageNameNew;
                    move_uploaded_file($imageTmpName, $imageDestination);
                } else {
                    echo "Your file is too big!";
                }
            } else {
                echo "There was an error uploading your file!";
            }
        } else {
            echo "You cannot upload files of this type!";
        }
    }

    // Store form data
    $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'product' => $product,
        'message' => $message,
        'image_path' => $imageDestination ?? null
    ];

    // You can save $data to a database or process it as needed
    echo "Form submitted successfully!";
} else {
    echo "Invalid request method.";
}
?>

