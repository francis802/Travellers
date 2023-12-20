function displayImage(input) {
    var preview = document.getElementById('image-preview');
    var label = document.getElementById('file-label');
    var container = document.getElementById('preview-container');
    var closeButton = document.getElementById('close-button');

    var file = input.files[0];

    if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            closeButton.style.display = 'block';
            label.innerText = 'Change Photo';
            container.style.height = 'auto';
        };
        reader.readAsDataURL(file);
    } else {
        // No file selected
        preview.style.display = 'none';
        closeButton.style.display = 'none';
        label.innerText = 'Select Photo';
        container.style.height = '0';
    }
}

function removeImage() {
    var preview = document.getElementById('image-preview');
    var closeButton = document.getElementById('close-button');
    var label = document.getElementById('file-label');
    var container = document.getElementById('preview-container');
    var input = document.getElementById('image');

    preview.style.display = 'none';
    closeButton.style.display = 'none';
    label.innerText = 'Select Photo';
    container.style.height = '0';
    input.value = ''; // Clear the file input
}