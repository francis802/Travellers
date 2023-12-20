function displayImage(input) {
    var preview = document.getElementById('image-preview');
    var label = document.getElementById('file-label');
    var closeButton = document.getElementById('close-button');

    var file = input.files[0];

    if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            closeButton.style.display = 'block';
            label.innerText = 'Change Photo';
        };
        reader.readAsDataURL(file);
    } else {
        // No file selected
        let image = location.protocol + '//' + location.host + '/image-placeholder.jpg';
        preview.src = image;
        closeButton.style.display = 'none';
        label.innerText = 'Select Photo';
    }
}

function removeImage() {
    var preview = document.getElementById('image-preview');
    var closeButton = document.getElementById('close-button');
    var label = document.getElementById('file-label');
    var container = document.getElementById('preview-container');
    var input = document.getElementById('image');

    let image = location.protocol + '//' + location.host + '/image-placeholder.jpg';
    preview.src = image;
    closeButton.style.display = 'none';
    label.innerText = 'Select Photo';
    input.value = ''; // Clear the file input
}
