<form id="comanyForm">

    <div class="row">
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Company Name :</label></div>
            <input type="text" class="form-control capitalize" id="companyname" name="companyname" placeholder=" Ex :nimal" required>
            <div class="invalid-feedback">
                Please enter a valid name (only letters and spaces).
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Country</label></div>
            <input type="text" class="form-control capitalize" id="country" name="country" placeholder="Ex : SriLanaka" required>
        </div>

    </div>


    <div class="row">
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Email</label></div>
            <input type="email" class="form-control" id="Email" name="email" placeholder="Ex:sample@gmail.com " required>
        </div>
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Mobile Number</label></div>
            <input type="Number" class="form-control" id="Mobile" name="phone" placeholder="Ex: 071xxxxxxx " required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Job Approval ID</label></div>
            <input type="text" class="form-control" id="Approval" name="Approval" placeholder="Ex:Jo/200/400/2024" required>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Company Address</label></div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="address" id="Approval" name="address" style="height: 80px"></textarea>
                <label for="floatingTextarea2">address</label>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>
<script>
    $(document).ready(function() {
        $("#comanyForm").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('action', 'company');
          
            $.ajax({
                url: '../config/company/companyConfig.php', // Replace with the path to your PHP config file
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Handle success
                    if(response.status === 'success'){
 // Show SweetAlert success message
                    Swal.fire({
                        title: 'Success!',
                        text: 'Form submitted successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Clear the form fields
                            $('#comanyForm')[0].reset();
                        }
                    });
                    }
                    else{
                        Swal.fire('Error', 'Failed to save data: ' + response.message, 'error');
                    }

                   
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                    alert('An error occurred while submitting the form');
                }
            });
        })

    });
</script>