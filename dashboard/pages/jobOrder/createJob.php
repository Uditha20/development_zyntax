<form id="jobOrder">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="l1"><label>Company Name :</label></div>
                <div class="mb-3 col-md-6">
                    <select class="form-control border border-dark col-md-6" id="companySelect" name="companySelect" aria-describedby="categoryHelp">
                        <option value="">Select a Company Name</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="mb-3 col-md-6">
                    <div class="l1"><label>Job Title:</label></div>
                    <select class="form-control border border-dark col-md-6" id="categorySelect" name="categorySelect" aria-describedby="categoryHelp">
                        <option value="">Select a Job Title</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 mb-3">
                <div class="l1"><label>Vacancies Count:</label></div>
                <input type="text" class="form-control" id="vacanciescount" name="vacanciescount" placeholder="Ex" required>
            </div>
            <div class="col-md-5 mb-3">
                <div class="l1"><label>Payment For Job</label></div>
                <input type="text" class="form-control" id="payment" name="payment" placeholder="Ex" required>
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
                            companySelect.append('<option value="' + company.id + '">' + company.company_name + '</option>');
                        });

                        // Populate categorySelect
                        var categorySelect = $('#categorySelect');
                        categorySelect.empty().append('<option value="">Select a Job Title</option>');
                        $.each(response.job_title, function(index, job) {
                            categorySelect.append('<option value="' + job.job_id + '">' + job.job_title_name + '-' + job.categoryName + '</option>');
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

            $("#jobOrder").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('action', 'jobOrder');

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