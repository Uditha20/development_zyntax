<body>
    <div class="container">
        <h3>Visa Process</h3>
        <div class="row">
            <!-- <div class="col-md-3 mb-4">
                <label for="dateInput" class="form-label">Select Date</label>
                <input type="date" class="form-control" id="dateInput" name="dateInput">
            </div>
            <div class="col-md-3 mb-4">
                <label for="timeInput" class="form-label">Select Time</label>
                <input type="time" class="form-control" id="timeInput" name="timeInput">
            </div>
         -->
            <!-- <div class="col-md-3 mb-3" style="margin-top: 33px;">
                <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
            </div> -->

        </div>
        <table id="categoryTable" class="table table-bordered table-striped">

        </table>
    </div>

    <script>
        $(document).ready(function() {
            function assignData() {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Please wait while we fetch the data.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: "../config/visa/visaConfig.php",
                    type: "GET",
                    data: {
                        action: "newvisaProcess"
                    },
                    success: function(response) {
                        // console.log(response);
                        Swal.close();
                        if (response.status === 'success') {
                            $('#categoryTable').DataTable({
                                data: response.data,
                                columns: [{
                                        data: null,
                                        title: "No",
                                        render: function(data, type, row, meta) {
                                            return meta.row + 1;
                                        }
                                    },
                                   

                                    {
                                        data: "employee_id",
                                        title: "Cadidate_Code"
                                    },
                                    {
                                        data: "first_name",
                                        title: "First Name"
                                    },
                                    {
                                        data: "last_name",
                                        title: "Last Name"
                                    },

                                    {
                                        data: "company_name",
                                        title: "Company Name"
                                    },
                                    {
                                        data: "job_title_name",
                                        title: "Job Title Name"
                                    },

                                    {
                                        data: null,
                                        title: "Action",
                                        render: function(data, type, row, meta) {
                                            return '<button class="btn btn-success btn-sm migrate-btn" data-id="' + row.assign_to_job_id + '">Migrate</button>';
                                        }
                                    }, {
                                        data: null,
                                        title: "Action",
                                        render: function(data, type, row, meta) {
                                            return '<button class="btn btn-danger btn-sm reject-btn" data-id="' + row.assign_to_job_id + '">Reject</button>';
                                        }
                                    },

                                ],
                                "pageLength": 10,
                                "lengthMenu": [
                                    [10, 25, 50, -1],
                                    [10, 25, 50, "All"]
                                ],
                                "destroy": true // Add this option if you want to reinitialize the table with new data
                            });
                        } else {
                            console.error('Error fetching data:', response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching data:', textStatus, errorThrown);
                    }
                });
            }
            assignData();

            $(document).on('click', '.migrate-btn', function() {
                const assignToJobId = $(this).data('id');
                const dataToSend = {
                    action: 'migrate',
                    assign_to_job_id: assignToJobId
                };

                $.ajax({
                    url: "../config/status/dateTimeAssignConfig.php",
                    type: "POST",
                    data: JSON.stringify(dataToSend),
                    contentType: "application/json",
                    success: function(response) {
                        if (response.status === 'success') {
                            if (response.message === 'Payment complete.') {
                                // Show confirmation dialog
                                Swal.fire({
                                    title: 'Payment complete',
                                    text: "Are you sure you want to proceed with migration?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, proceed'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Perform the necessary action when payment is complete
                                        $.ajax({
                                            url: "../config/status/dateTimeAssignConfig.php", // URL for migration action
                                            type: "POST",
                                            data: JSON.stringify({
                                                assign_to_job_id: assignToJobId,
                                                action: 'migratecandidate',
                                            }),
                                            contentType: "application/json",
                                            success: function(migrateResponse) {
                                                if (migrateResponse.status === 'success') {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Success',
                                                        text: 'Migration is successful.'
                                                    });
                                                    assignData();
                                                } else {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error',
                                                        text: 'Migration failed: '
                                                    });
                                                }
                                                // console.log(migrateResponse);
                                            },
                                            error: function(xhr, status, error) {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: 'AJAX error during migration: ' + error
                                                });
                                            }
                                        });
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Payment Status',
                                    text: response.message
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while fetching the payment status.'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to migrate the record.',
                        });
                    }
                });
            });


      

        // reject the candudate 
        $(document).on('click', '.reject-btn', function() {
            const assignToJobId = $(this).data('id');
            const dataToSend = {
                action: 'reject',
                assign_to_job_id: assignToJobId
            };

            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to reject this candidate?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, send the AJAX request
                    $.ajax({
                        url: "../config/status/dateTimeAssignConfig.php",
                        type: "POST",
                        data: JSON.stringify(dataToSend),
                        contentType: "application/json",
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Rejected!',
                                    text: response.message,
                                });
                                
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                            }
                            assignData();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to reject the assignment.',
                            });
                        }
                    });
                }
            });

        })
    });
    </script>