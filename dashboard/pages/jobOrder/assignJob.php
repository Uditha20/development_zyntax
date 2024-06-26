<form id="jobOrder">
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="l1"><label>Company Name :</label></div>
            <div class="mb-3 col-md-6">
                <select class="form-control border border-dark col-md-6" id="companySelect" name="companySelect" aria-describedby="categoryHelp" required>
                    <option value="">Select a Company Name</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="mb-3 col-md-6">
                <div>
                    <!-- <div>Total vacances count: <span id="vacancesCount"></span></div> -->
                </div>
                <div class="l1"><label>Job Order:</label></div>
                <select class="form-control border border-dark col-md-6" id="joborder" name="joborder" aria-describedby="categoryHelp" required>
                    <option value="">Select a Job Title</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-3">

            <div class="mb-3 col-md-6">
                <div class="l1"><label>Candidate:</label></div>
                <select class="form-control border border-dark col-md-6" id="Candidate" name="Candidate" aria-describedby="categoryHelp" required>
                    <option value="">Select a Job Title</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>


<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#companySelect').select2({
            placeholder: 'Select a company',
            allowClear: true
        });

        $('#Candidate').select2({
            placeholder: 'Select a candidate',
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
                action: 'getcomdata'
            },
            dataType: 'json',
            success: function(response) {
                Swal.close(); // Close loading alert

                if (response.status === 'success') {
                    var companySelect = $('#companySelect');
                    companySelect.empty().append('<option value="">Select a Company Name</option>');
                    $.each(response.company, function(index, company) {
                        companySelect.append('<option value="' + company.id + '">' + company.company_name + '</option>');
                    });

                    // Populate Candidate select
                    var candidateSelect = $('#Candidate');
                    candidateSelect.empty().append('<option value="">Select a Candidate</option>');
                    $.each(response.candidate, function(index, candidate) {
                        candidateSelect.append('<option value="' + candidate.id + '">' + candidate.first_name + ' ' + candidate.last_name + ' (' + candidate.employee_id + ')</option>');
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

        $('#companySelect').on('change', function() {
            var selectedCompanyId = $(this).val();
            if (selectedCompanyId) {
                $.ajax({
                    type: 'POST',
                    url: '../config/job_order/jobOrderConfig.php',
                    data: {
                        action: 'getJobDetails',
                        companyId: selectedCompanyId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Populate joborder select
                            var jobOrderSelect = $('#joborder');
                            jobOrderSelect.empty().append('<option value="">Select a Job Order</option>');
                            $.each(response.jobDetails, function(index, job) {
                                jobOrderSelect.append('<option value="' + job.id + '">' + job.job_title_name + ' - ' + job.categoryName + '</option>');
                            });
                            jobOrderSelect.trigger('change'); // Update Select2
                        } else {
                            Swal.fire('Error', 'Failed to load job details', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'AJAX error: ' + error, 'error');
                    }
                });
            }
        })
     
        $("#jobOrder").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('action', 'jobassign');

                $.ajax({
                    url: '../config/job_order/jobOrderConfig.php', // Replace with the path to your PHP config file
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                        title: 'Success!',
                        text: 'Form submitted successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Clear the form fields
                            $('#jobOrder')[0].reset();
                        }
                    });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'AJAX error: ' + error, 'error');
                    }
                });
            });
    });
</script>