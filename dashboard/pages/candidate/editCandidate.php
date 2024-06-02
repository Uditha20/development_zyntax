<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>
<form id="candidateEditForm" enctype="multipart/form-data" data-id="<?php echo htmlspecialchars($id); ?>">
    <div class="col-md-5 mb-3">
        <div class="l1"><label>Candidate ID</label></div>
        <input type="text" class="form-control" id="candidateid" name="candidateid" placeholder=" Ex :nimal" readonly>
    </div>
    <div class="row">
        <div class="col-md-5 mb-3">
            <div class="l1"><label>First Name :</label></div>
            <input type="text" class="form-control capitalize" id="firstname" name="firstname" placeholder=" Ex :nimal" required>
            <div class="invalid-feedback">
                Please enter a valid name (only letters and spaces).
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Last Name</label></div>
            <input type="text" class="form-control capitalize" id="lastname" name="lastname" placeholder="Ex : kumara" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Date of Birth</label></div>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>
        <div class="col-md-5 d-flex mt-4">
            <div class="form-check mx-2">
                <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required>
                <label class="form-check-label" for="male">
                    <b>Male</b>
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="female" value="Female" required>
                <label class="form-check-label" for="female">
                    <b>Female</b>
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Passport No :</label></div>
            <input type="text" class="form-control" id="PassportNo" name="PassportNo" placeholder=" Ex: N-1234 " required>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Passport Expire Date</label></div>
            <input type="date" class="form-control " id="PassportExpire" name="PassportExpire" required>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Name in Full Passport :</label></div>
            <input type="text" class="form-control capitalize" id="NamePassport" name="NamePassport" placeholder=" Ex: A.G Nimal Kumara " required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Email :</label></div>
            <input type="email" class="form-control" id="Email" name="Email" placeholder=" Ex:sample@gmail.com " required>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>WhatsApp Number</label></div>
            <input type="text" class="form-control" id="Mobile" name="Mobile" placeholder="Ex: 071xxxxxxx " required>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Land Phone Number</label></div>
            <input type="text" class="form-control" id="land" name="land" placeholder="Ex :011xxxxxxx ">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Address</label></div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="address" id="address" name="address" style="height: 80px" required></textarea>
                <label for="floatingTextarea2">address</label>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>District</label></div>
            <input type="text" class="form-control" id="city" name="city" placeholder="Ex: Colombo " required>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Candidate ID</label></div>
            <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="Ex: 0011" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="l1"><label>CV</label></div>
            <input type="file" class="form-control" id="cv" name="cv">
            <div class="invalid-feedback" id="cvError">
                Please upload a valid PDF file less than 5MB.
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Passport</label></div>
            <input type="file" class="form-control" id="passport" name="passport">
            <div class="invalid-feedback" id="passportError">
                Please upload a valid PDF file less than 5MB.
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Profile Picture</label></div>
            <input type="file" class="form-control" id="profile" name="profile">
            <div class="invalid-feedback" id="profileError">
                Please upload a valid image (PNG, JPG, JPEG) file less than 5MB.
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary col-md-3">Register</button>
</form>
<script>
    $(document).ready(function() {

        function validateFile(input, maxSizeMB, allowedTypes) {
            const file = input.files[0];
            if (file) {
                const fileSizeMB = file.size / (1024 * 1024);
                const fileType = file.type;

                if (fileSizeMB > maxSizeMB) {
                    return `File size should be less than ${maxSizeMB} MB.`;
                }

                if (!allowedTypes.includes(fileType)) {
                    return `Invalid file type. Allowed types are: ${allowedTypes.join(', ')}.`;
                }
            }
            return '';
        }

        var id = $('#candidateEditForm').data('id');
        console.log('ID from data attribute:', id);

        if (id) {
            $.ajax({
                url: '../config/candidate/viewConfig.php',
                type: 'GET',
                data: {
                    id: id,
                    action: 'getdetails'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.data) {
                        var candidate = response.data;

                        $('#candidateid').val(candidate.id);
                        $('#firstname').val(candidate.first_name);
                        $('#lastname').val(candidate.last_name);
                        $('#dob').val(candidate.dob);
                        $('input[name="gender"][value="' + candidate.gender + '"]').prop('checked', true);
                        $('#PassportNo').val(candidate.passport_no);
                        $('#PassportExpire').val(candidate.pass_expire_date);
                        $('#Mobile').val(candidate.mobile);
                        $('#Email').val(candidate.email);
                        $('#address').val(candidate.address);
                        $('#city').val(candidate.city);
                        $('#employee_id').val(candidate.employee_id);
                        $('#NamePassport').val(candidate.name_in_pass_full);
                        $('#land').val(candidate.landphone);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Failed to fetch company details.', 'error');
                }
            });
        }

      
        $('#candidateEditForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('action', 'updateCompany');
            formData.append('id', id);
            $.ajax({
                url: '../config/candidate/editconfig.php',
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
                            $('.main-container').load('../pages/candidate/viewCandidate.php');
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