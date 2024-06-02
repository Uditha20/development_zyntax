<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>

<form id="editCompanyForm" data-id="<?php echo htmlspecialchars($id); ?>">

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
            <div class="l1"><label>Email :</label></div>
            <input type="email" class="form-control" id="email" name="email" placeholder=" Ex " required>
        </div>
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Mobile Number</label></div>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Ex : " required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Job Approval ID</label></div>
            <input type="text" class="form-control" id="Approval" name="Approval" placeholder="" required>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Company Address</label></div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="address" id="address" name="address" style="height: 80px"></textarea>
                <label for="floatingTextarea2">address</label>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Edit Deails</button>
</form>
<script>
    $(document).ready(function() {
        var id = $('#editCompanyForm').data('id');
        // console.log('ID from data attribute:', id);

        if (id) {
            $.ajax({
                url: '../config/company/companyConfig.php',
                type: 'GET',
                data: {
                    id: id,
                    action: 'getCompanyDetails'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        var company = response.data[0]; // Access the first element of the array
                        $('#companyname').val(company.company_name);
                        $('#country').val(company.country);
                        $('#email').val(company.email);
                        $('#phone').val(company.phone);
                        $('#Approval').val(company.approval_Id);
                        $('#address').val(company.address);
                    } else {
                        Swal.fire('Error', 'Failed to fetch company details.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Failed to fetch company details.', 'error');
                }
            });
        }

        $('#editCompanyForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('action', 'updateCompany');
            formData.append('id', id);
            $.ajax({
                url: '../config/company/companyConfig.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        title: 'Success!',
                        text: 'Company updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('.main-container').load('../pages/company/viewCompany.php');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Failed to update company.', 'error');
                }
            });
        });
    });
</script>