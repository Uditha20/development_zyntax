<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        label {
            font-weight: bold;
        }

        .invalid-feedback {
            display: none;
        }
    </style>

</head>

<body>
    <?php
    require_once '../../headers/header.php'
        ?>
    <div>
        <form action="" id="myForm">
            <div class="row g-3">
                <div class="col-md-5 mb-3">
                    <div><label>Name :</label></div>
                    <input type="text" class="form-control capitalize" id="name" placeholder="Name">
                    <div class="invalid-feedback">
                        Please enter a valid name (only letters and spaces).
                    </div>
                </div>

                <div class="col-md-5 mb-3">
                    <div><label>Country : </label></div>

                    <input type="text" class="form-control capitalize" id="country" placeholder="Country" required>
                    <div class="invalid-feedback">
                        Please enter a valid country name (only letters and spaces).
                    </div>
                </div>
            </div>
    </div>
    <div class="row g-3">
        <div class="col-md-5 mb-3">
            <div><label>Phone :</label></div>
            <input type="tel" class="form-control" id="phone" placeholder="Phone" required>
            <div class="invalid-feedback">
                Please enter a valid phone number (10 digits).
            </div>
        </div>

        <div class="col-md-5 mb-3">
            <div><label>Email :</label></div>

            <input type="email" class="form-control" id="email" placeholder="Email" required>
            <div class="invalid-feedback">
                Please enter a valid email address.
            </div>

        </div>
    </div>
    <button class="btn btn-primary"> Create Compny</button>
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


        document.getElementById('name').addEventListener('input', function () {
            validateInput(this, this.nextElementSibling, /^[A-Za-z\s]+$/);
        });

        document.getElementById('country').addEventListener('input', function () {
            validateInput(this, this.nextElementSibling, /^[A-Za-z\s]+$/);
        });

        document.getElementById('phone').addEventListener('input', function () {
            validateInput(this, this.nextElementSibling, /^\+?\d{10,12}$/);
        });

        document.getElementById('email').addEventListener('input', function () {
            validateInput(this, this.nextElementSibling, /^[^\s@]+@[^\s@]+\.[^\s@]+$/);
        });
    </script>

</html>