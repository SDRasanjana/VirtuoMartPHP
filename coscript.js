document.getElementById('productForm').addEventListener('submit', function(event) {
    const imageInput = document.getElementById('image');
    if (imageInput.files.length === 0) {
        alert('Please upload an image.');
        event.preventDefault();
    }
});

