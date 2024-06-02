<body>
    <div class="container">
        <h3>Interview state</h3>
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
            <div class="row">

                <div class="col-md-1 mb-3" style="margin-top: 33px;">
                    <button type="button" class="btn btn-success" id="submitButton">Pass</button>
                </div>
                <div class="col-md-1 mb-3" style="margin-top: 33px;">
                    <button type="button" class="btn btn-danger" id="failButton">Fail</button>
                </div>
            </div>

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
                    url: "../config/status/assignConfig.php",
                    type: "GET",
                    data: {
                        action: "selectData"
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
                                        data: null,
                                        title: "Select",
                                        render: function(data, type, row, meta) {
                                            return '<input type="checkbox" class="select-checkbox" data-id="' + row.assign_to_job_id + '">';
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
                                        data: "interview_time",
                                        title: "Interview Time"
                                    }, {
                                        data: "interview_date",
                                        title: "Interview Date"
                                    },
                                    // {
                                    //     data: null,
                                    //     title: "Edit",
                                    //     render: function(data, type, row, meta) {
                                    //         return '<button class="btn btn-warning btn-sm edit-btn" data-id="' + row.assign_to_job_id + '">Edit</button>';
                                    //     }
                                    // },
                                    {
                                        data: null,
                                        title: "Delete",
                                        render: function(data, type, row, meta) {
                                            return '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.assign_to_job_id + '">Delete</button>';
                                        }
                                    }
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
            $('#submitButton').click(function() {

                const selectedIds = [];

                $('.select-checkbox:checked').each(function() {
                    selectedIds.push($(this).data('id'));
                });

                if (selectedIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Selection',
                        text: 'Please select at least one item.',
                    });
                    return;
                }
                const dataToSend = {
                    action: 'selectData',
                    assign_to_job_ids: selectedIds,
                };
                $.ajax({
                    url: "../config/status/dateTimeAssignConfig.php",
                    type: "POST",
                    data: JSON.stringify(dataToSend),
                    contentType: "application/json",
                    success: function(response) {
                        // console.log(response);
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data has been Update successfully.',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Call assignData function
                                    assignData();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to submit data.',
                        });
                    }
                });
            });
            $('#failButton').click(function() {

                const selectedIds = [];

                $('.select-checkbox:checked').each(function() {
                    selectedIds.push($(this).data('id'));
                });

                if (selectedIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Selection',
                        text: 'Please select at least one item.',
                    });
                    return;
                }
                const dataToSend = {
                    action: 'failselectData',
                    assign_to_job_ids: selectedIds,
                };
                $.ajax({
                    url: "../config/status/dateTimeAssignConfig.php",
                    type: "POST",
                    data: JSON.stringify(dataToSend),
                    contentType: "application/json",
                    success: function(response) {
                         // console.log(response);
                         if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data has been Update successfully.',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Call assignData function
                                    assignData();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to submit data.',
                        });
                    }
                });
            });
        });
    </script>