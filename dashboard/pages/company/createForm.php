<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .invalid-feedback {
            display: none;
        }

        .l1 {
            font-weight: bold;
        }
    </style>
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
    <?php require_once '../../headers/header.php'; ?>
    <div>
        <form action="" id="myForm">
            <div class="row g-3">
                <div class="col-md-5 mb-3">
                    <div class="l1"><label>Name :</label></div>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ex: ZYNTAXY">
                    <div class="invalid-feedback">
                        Please enter a valid name (only capital letters and spaces).
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="l1"><label>Country :</label></div>
                    <input type="text" class="form-control" id="country" name="country" placeholder="Ex: SRI LANKA"
                        required>
                    <div class="invalid-feedback">
                        Please enter a valid country name (only capital letters and spaces).
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-5 mb-3">
                    <div class="l1"><label>Phone :</label></div>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Ex: 07737xxxx">
                    <div class="invalid-feedback">
                        Please enter a valid phone number (10 digits).
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="l1"><label>Email :</label></div>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Ex: Example@gmail.com">
                    <div class="invalid-feedback">
                        Please enter a valid email address.
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Company</button>
        </form>
    </div>
    <script>
        function validateInput(inputElement, feedbackElement, pattern) {
            const value = inputElement.value;
            if (pattern.test(value)) {
                inputElement.classList.remove('is-invalid');
                inputElement.classList.add('is-valid');
                feedbackElement.style.display = 'none';
            } else {
                inputElement.classList.remove('is-valid');
                inputElement.classList.add('is-invalid');
                feedbackElement.style.display = 'block';
            }
        }

        $(document).ready(function () {
            $('#name').on('input', function () {
                validateInput(this, this.nextElementSibling, /^[A-Z\s]+$/);
            });
            $('#country').on('input', function () {
                validateInput(this, this.nextElementSibling, /^[A-Z\s]+$/);
            });
            $('#phone').on('input', function () {
                validateInput(this, this.nextElementSibling, /^\+?\d{10,12}$/);
            });
            $('#email').on('input', function () {
                validateInput(this, this.nextElementSibling, /^[^\s@]+@[^\s@]+\.[^\s@]+$/);
            });
            $("#myForm").submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                console.log('Form Data:');
                formData.forEach((value, key) => {
                    console.log(key + ": " + value);
                });
            });
            $("#myForm").submit(function (e) {
                e.preventDefault(); // Prevent default form submission

                // Validate form inputs before submission
                const nameValid = /^[A-Z\s]+$/.test($('#name').val());
                const countryValid = /^[A-Z\s]+$/.test($('#country').val());
                const phoneValid = /^\+?\d{10,12}$/.test($('#phone').val());
                const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($('#email').val());

                if (!nameValid || !countryValid || !phoneValid || !emailValid) {
                    // Show an error message if any field is invalid
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please check your input fields.',
                    });
                    return;
                }

                // If all fields are valid, proceed with AJAX submission
                $.ajax({
                    url: 'your_php_script.php',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Handle successful submission response
                        Swal.fire({
                            icon: 'success',
                            title: 'Form Submitted',
                            text: 'Your form has been submitted successfully!',
                        });
                    },
                    error: function (xhr, status, error) {
                        // Handle submission error
                        Swal.fire({
                            icon: 'error',
                            title: 'Submission Error',
                            text: 'An error occurred while submitting the form. Please try again later.',
                        });
                    },
                });
            });
        });
    </script>
</body>

</html>