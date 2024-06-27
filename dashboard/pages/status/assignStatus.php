<body>
    <div class="container">
        <h3>Assigned Candidate</h3>
        <div class="row">
            <div class="col-md-3 mb-4">
                <label for="dateInput" class="form-label">Select Date</label>
                <input type="date" class="form-control" id="dateInput" name="dateInput">
            </div>
            <div class="col-md-3 mb-4">
                <label for="timeInput" class="form-label">Select Time</label>
                <input type="time" class="form-control" id="timeInput" name="timeInput">
            </div>

            <div class="col-md-3" style="margin-top: 33px;">
                <button type="button" class="btn btn-primary" id="submitButton">Submit</button>
            </div>

        </div>
        <input type="hidden" id="selectedRowsData" />
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
                        action: "assignData"
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
                                        data: null,
                                        title: "Interview State",
                                        render: function(data, type, row, meta) {
                                            return `
                                        <select class="form-control interview-state" data-id="${row.assign_to_job_id}">
                                            <option value="0" ${row.interview == 0 ? 'selected' : ''}>No</option>
                                            <option value="1" ${row.interview == 1 ? 'selected' : ''}>Yes</option>
                                        </select>
                                    `;
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Interviewed State",
                                        render: function(data, type, row, meta) {
                                            return `
                                        <select class="form-control interviewed-state" data-id="${row.assign_to_job_id}">
                                            <option value="0" ${row.interviewed == 0 ? 'selected' : ''}>No</option>
                                            <option value="1" ${row.interviewed == 1 ? 'selected' : ''}>Pass</option>
                                            <option value="2" ${row.interviewed == 2 ? 'selected' : ''}>Fail</option>
                                        </select>
                                    `;
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Select State",
                                        render: function(data, type, row, meta) {
                                            return `
                                        <select class="form-control select-state" data-id="${row.assign_to_job_id}">
                                            <option value="0" ${row.select == 0 ? 'selected' : ''}>No</option>
                                            <option value="1" ${row.select == 1 ? 'selected' : ''}>Yes</option>
                                        </select>
                                    `;
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Visa Process State",
                                        render: function(data, type, row, meta) {
                                            return `
                                        <select class="form-control visa-process-state" data-id="${row.assign_to_job_id}">
                                            <option value="0" ${row.visa_process == 0 ? 'selected' : ''}>No</option>
                                            <option value="1" ${row.visa_process == 1 ? 'selected' : ''}>Yes</option>
                                        </select>
                                    `;
                                        }
                                    },
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
            $('#categoryTable').on('change', '.select-checkbox, .form-control', function() {
                updateSelectedRows();
            });

            function updateSelectedRows() {
                let selectedRows = [];
                let dateValue = $('#dateInput').val();
                let timeValue = $('#timeInput').val();
                $('#categoryTable tbody tr').each(function() {
                    let row = $(this);
                    let checkbox = row.find('.select-checkbox');
                    if (checkbox.is(':checked')) {
                        let rowData = {
                            id: checkbox.data('id'),
                            Interview: row.find('.interview-state').val(),
                            Interviewed: row.find('.interviewed-state').val(),
                            SelectState: row.find('.select-state').val(),
                            VisaProcess: row.find('.visa-process-state').val(),
                            Date: dateValue,
                            Time: timeValue
                        };
                        selectedRows.push(rowData);
                    }
                });
                // Log the selected rows for debugging
                console.log('Selected Rows Data:', selectedRows);
                // Update a hidden input field or a global variable with the selected rows data
                $('#selectedRowsData').val(JSON.stringify(selectedRows));
            }

            function updateSelectColors() {
                $('select').each(function() {
                    var value = $(this).val();
                    $(this).removeClass('red green orange');
                    if (value == '0') {
                        $(this).addClass('red');
                    } else if (value == '1') {
                        $(this).addClass('green');
                    } else if (value == '2') {
                        $(this).addClass('orange');
                    }
                });
            }

            $('#submitButton').on('click', function() {
                let selectedRowsData = $('#selectedRowsData').val();

                // Ensure the data is correctly set
                if (!selectedRowsData || selectedRowsData === '[]') {
                    console.error('No rows selected');
                    alert('No rows selected. Please select at least one row before submitting.');
                    return;
                }

                // Log the data being sent for debugging
                console.log('Submitting Data:', selectedRowsData);

                // Send the selectedRowsData to the backend
                $.ajax({
                    url: '../config/status/dateTimeAssignConfig.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        action: 'saveData',
                        rows: selectedRowsData
                    }),
                    success: function(response) {
                        console.log('Data submitted successfully:', response);
                        // Handle success response
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
                                        data: null,
                                        title: "Interview State",
                                        render: function(data, type, row, meta) {
                                            return '<select class="form-control interview-state" data-id="' + row.assign_to_job_id + '"><option value="0" selected>No</option><option value="1">Yes</option></select>';
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Interviewed State",
                                        render: function(data, type, row, meta) {
                                            return '<select class="form-control interviewed-state" data-id="' + row.assign_to_job_id + '"><option value="0" selected>No</option><option value="1">Pass</option><option value="2">Fail</option></select>';
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Select State",
                                        render: function(data, type, row, meta) {
                                            return '<select class="form-control select-state" data-id="' + row.assign_to_job_id + '"><option value="0" selected>No</option><option value="1">Yes</option></select>';
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Visa Process State",
                                        render: function(data, type, row, meta) {
                                            return '<select class="form-control visa-process-state" data-id="' + row.assign_to_job_id + '"><option value="0" selected>No</option><option value="1">Yes</option></select>';
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Delete",
                                        render: function(data, type, row, meta) {
                                            return '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.assign_to_job_id + '">Delete</button>';
                                        }
                                    }
                                ],
                                pageLength: 10,
                                lengthMenu: [
                                    [10, 25, 50, -1],
                                    [10, 25, 50, "All"]
                                ],
                                destroy: true // Add this option if you want to reinitialize the table with new data
                            });
                        } else {
                            console.error('Error fetching data:', response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error submitting data:', textStatus, errorThrown);
                        // Handle error response
                    }
                });
            });


            $('#categoryTable').on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // AJAX call to delete the item
                        $.ajax({
                            type: 'POST',
                            url: '../config/status/assignConfig.php',
                            data: {
                                action: 'assigdelete',
                                id: id
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'The record has been deleted.',
                                        icon: 'success'
                                    }).then(() => {
                                        // Call companyDetails function to reload the data
                                        assignData();
                                    });
                                } else {
                                    Swal.fire('Error!', 'Failed to delete the record.', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Error!', 'AJAX error: ' + error, 'error');
                            }
                        });
                    }
                });
            })
        });
    </script>