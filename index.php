<?php
//  ba0346b763
require_once './headers/header.php'
?>

<body class="">


    <div class="outer d-flex justify-content-center align-items-center ">

        <div>
            <div class="login-img  ">
                <img src="./img/logo.png" class="pic " />
            </div>
            <div>
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">User Name</label>
                        <input type="text" class="form-control input-field fill-color" id="username" name="username" aria-describedby="emailHelp">

                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control fill-color input-field" id="password" name="password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center ">

                        <button type="submit" class="btn btn-primary login-btn">Login</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <?php
    //  ba0346b763
    // Dev@zyntax
    require_once './headers/footer.php'
    ?>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            var passwordInput = document.getElementById("password");
            var toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            }
        });
    </script>

    <script>
        // Handle form submission
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            const formData = {
                username: $('#username').val(),
                password: $('#password').val()
            };

            $.ajax({
                type: 'POST',
                url: './Login/loginConfig.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                      
                        window.location.href = './dashboard/main/index.php'; 
                    } else {
                       
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error
                    console.error('AJAX error: ' + status + ' - ' + error);
                }
            });
        });
    </script>
</body>