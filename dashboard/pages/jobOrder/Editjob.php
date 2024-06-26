<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>

<form id="jobOrder" data-id="<?php echo htmlspecialchars($id); ?>">
    <div class="container">
        <div class="row">
            <!-- Company Name Column -->
            <div class="col-md-4 mb-3">
                <label for="companySelect" class="li">Company Name</label>
                <select class="form-control border border-dark" id="companySelect" name="companySelect" aria-describedby="categoryHelp">
                    <option value="">Select a Company Name</option>
                </select>
            </div>

            <!-- Job Approval ID Column -->
            <div class="col-md-4 mb-3">
                <label for="payment" class="li">Job Approval ID</label>
                <input type="text" class="form-control border border-dark" id="approval" name="approval" placeholder="" >
            </div>

            <!-- Job Title Column -->
            <div class="col-md-4 mb-3">
                <label for="categorySelect" class="form-label li">Job Title</label>
                <select class="form-control border border-dark" id="categorySelect" name="categorySelect" aria-describedby="categoryHelp">
                    <option value="">Select a Job Title</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class=""><label>Payment For Job</label></div>
            <input type="Number" class="form-control" id="payment" name="payment" placeholder="Ex: 100000.00">
        </div>
        <div class="col-md-4 mb-3">
            <div class=""><label>Currency</label></div>
            <input type="text" class="form-control Currency" id="Currency" name="Currency" placeholder="Ex: Rs">
        </div>
        <div class="col-md-4 mb-3">
            <div class=""><label>Vacancies Count</label></div>
            <input type="Number" class="form-control" id="vacanciescount" name="vacanciescount" placeholder="Ex: 10">
        </div>

    </div>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class=""><label>Bureau Fee</label></div>
            <input type="text" class="form-control" id="bureau" name="bureau">
        </div>
        <div class="col-md-3 mb-3">
            <div class=""><label>Requirement Charge</label></div>
            <input type="text" class="form-control Currency" id="req" name="req">
        </div>
        <div class="col-md-3 mb-3">
            <div class=""><label>Medical Charges</label></div>
            <input type="text" class="form-control" id="medicale" name="medicale">
        </div>
        <div class="col-md-3 mb-3">
            <div class=""><label>Visa Fee</label></div>
            <input type="text" class="form-control" id="visafee" name="visafee" placeholder="">
        </div>

    </div>
    <button type="submit" class="btn btn-primary">Edit</button>
</form>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#companySelect').select2({
            placeholder: 'Select a company',
            allowClear: true
        });
        $('#categorySelect').select2({
            placeholder: 'Select a job title',
            allowClear: true
        });

        Swal.fire({
            title: 'Loading',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            type: 'POST',
            url: '../config/job_order/jobOrderConfig.php',
            data: {
                action: 'getdata'
            },
            dataType: 'json',
            success: function(response) {
                Swal.close(); // Close loading alert

                if (response.status === 'success') {
                    // Populate companySelect
                    var companySelect = $('#companySelect');

                    companySelect.empty().append('<option value="">Select a Company Name</option>');
                    $.each(response.company, function(index, company) {
                        companySelect.append('<option value="' + company.id + '" data-approval-id="' + company.approval_Id + '">' + company.company_name + '</option>');
                    });

                    // Populate categorySelect
                    var categorySelect = $('#categorySelect');
                    categorySelect.empty().append('<option value="">Select a Job Title</option>');
                    $.each(response.job_title, function(index, job) {
                        categorySelect.append('<option value="' + job.job_id + '">' + job.job_title_name + '-' + job.categoryName + '</option>');
                    });

                    // Add event listener for companySelect
                    companySelect.on('change', function() {
                        var selectedOption = $(this).find('option:selected');
                        var approvalId = selectedOption.data('approval-id');
                        $('#approval').val(approvalId || '');
                    });
                } else {
                    Swal.fire('Error', 'Failed to load data', 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.close(); // Close loading alert
                Swal.fire('Error', 'AJAX error: ' + error, 'error');
            }
        });

        var id = $('#jobOrder').data('id');
        // console.log('ID from data attribute:', id);

        if (id) {
            $.ajax({
                url: '../config/job_order/jobOrderConfig.php',
                type: 'GET',
                data: {
                    id: id,
                    action: 'editData'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        var jobDetails = response.jobDetails;                    
                       
                      
                        $('#payment').val(jobDetails.payment_for_job);
                        $('#Currency').val(jobDetails.curency);
                        $('#vacanciescount').val(jobDetails.vacances_amount);
                        $('#bureau').val(jobDetails.bureaufee);
                        $('#req').val(jobDetails.reqfee);
                        $('#medicale').val(jobDetails.medicalfee);
                        $('#visafee').val(jobDetails.visafee);
                    } else {
                        Swal.fire('Error', 'Failed to load job order details', 'error');
                    }


                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Failed to fetch company details.', 'error');
                }
            });
        }

        $('#jobOrder').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('action', 'updatejob');
            formData.append('id', id);
            $.ajax({
                url: '../config/job_order/jobOrderConfig.php',
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
                            $('.main-container').load('../pages/jobOrder/viewVacancies.php');
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