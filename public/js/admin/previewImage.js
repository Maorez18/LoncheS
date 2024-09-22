function previewImage(event) {
        var input = event.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.style.backgroundImage = 'url(' + e.target.result + ')';
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            var imagePreview = document.getElementById('imagePreview');
            var defaultImage = "{{asset('assets/img/examplePicture.webp')}}";
            imagePreview.style.backgroundImage = 'url('+defaultImage+')';
            imagePreview.style.display = 'block';
        }
    }