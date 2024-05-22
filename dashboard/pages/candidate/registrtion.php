<?php
require_once '../../headers/header.php'
?>
<form id="candidateForm" enctype="multipart/form-data">
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
        <div class="col-md-5 d-flex">
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
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Passport No :</label></div>
            <input type="text" class="form-control" id="PassportNo" name="PassportNo" placeholder=" Ex " required>
        </div>
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Passport Expire Date</label></div>
            <input type="date" class="form-control " id="PassportExpire" name="PassportExpire" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Name in Full Passport :</label></div>
            <input type="text" class="form-control capitalize" id="NamePassport" name="NamePassport" placeholder=" Ex " required>
        </div>
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Mobile Number</label></div>
            <input type="text" class="form-control" id="Mobile" name="Mobile" placeholder="Ex : " required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Email :</label></div>
            <input type="email" class="form-control" id="Email" name="Email" placeholder=" Ex " required>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Address</label></div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="address" id="address" name="address" style="height: 80px" required></textarea>
                <label for="floatingTextarea2">address</label>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>City</label></div>
            <input type="text" class="form-control" id="city" name="city" placeholder="Ex : " required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mb-3">
            <div class="l1"><label>CV</label></div>
            <input type="file" class="form-control" id="cv" name="cv" required>
            <div class="invalid-feedback" id="cvError">
                Please upload a valid PDF file less than 3MB.
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <div class="l1"><label>Passport</label></div>
            <input type="file" class="form-control" id="passport" name="passport" required>
            <div class="invalid-feedback" id="passportError">
                Please upload a valid PDF file less than 3MB.
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>
<script>
    $(document).ready(function() {
        function fetchCandidateId() {
        $.ajax({
            url: '../config/candidate/candidateIdGenarate.php',
            type: 'GET',
            success: function(response) {
                // Set the fetched candidate ID in the input field
                $('#candidateid').val(response.candidate_id);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching candidate ID:', textStatus, errorThrown);
            }
        });
    }
    fetchCandidateId();
        $('#candidateForm').on('submit', function(e) {
            e.preventDefault();
            // Validate files
            let isValid = true;
            const maxSize = 3 * 1024 * 1024; // 3MB in bytes
            const cv = $('#cv')[0].files[0];
            const passport = $('#passport')[0].files[0];
            const validFileType = 'application/pdf';

            // Reset error messages
            $('#cvError').hide();
            $('#passportError').hide();

            if (cv) {
                if (cv.type !== validFileType || cv.size > maxSize) {
                    $('#cvError').show();
                    isValid = false;
                }
            }

            if (passport) {
                if (passport.type !== validFileType || passport.size > maxSize) {
                    $('#passportError').show();
                    isValid = false;
                }
            }

            if (!isValid) {
                return;
            }
            var formData = new FormData(this);

            $.ajax({
                url: '../config/candidate/candidateConfig.php', // Replace with the path to your PHP config file
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Handle success
                    console.log(response);

                    // Show SweetAlert success message
                    Swal.fire({
                        title: 'Success!',
                        text: 'Form submitted successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Clear the form fields
                            $('#candidateForm')[0].reset();
                            fetchCandidateId();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                    alert('An error occurred while submitting the form');
                }
            });
        });
    });
</script>