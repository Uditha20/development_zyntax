<body>
    <div  class="table-container">
        <h3>Payment Details</h3>
        <table id="categoryTable" class="table table-bordered table-striped display" style="width: 100%;">

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
                        action: "detailsvisaProcess"
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
                                        data: "payment",
                                        title: "Payment",
                                        render: function(data, type, row) {
                                            return parseFloat(data).toFixed(2); // Format to 2 decimal places
                                        }
                                    },
                                    {
                                        data: "payed_Amount",
                                        title: "Total Paid",
                                        render: function(data, type, row) {
                                            return parseFloat(data).toFixed(2); // Format to 2 decimal places
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Due Amount",
                                        render: function(data, type, row) {
                                            var dueAmount = parseFloat(row.payment) - parseFloat(row.payed_Amount);
                                            return dueAmount.toFixed(2); // Calculate and format to 2 decimal places
                                        }
                                    },
                                    {
                                        data: "last_pay_time",
                                        title: "Last Pay Date and Time",
                                        render: function(data, type, row) {
                                            return data ? new Date(data).toLocaleString() : ''; // Format date and time
                                        }
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
                                        title: "Make Payment",
                                        render: function(data, type, row) {
                                            return '<button class="btn btn-success makepayment" data-id="' + row.assign_to_job_id + '">Make payment</button>';
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Edit",
                                        render: function(data, type, row) {
                                            return '<button class="btn btn-warning editpay" data-id="' + row.assign_to_job_id + '">Edit</button>';
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Delete",
                                        render: function(data, type, row) {
                                            return '<button class="btn btn-danger delete-btn" data-id="' + row.assign_to_job_id + '">Delete</button>';
                                        }
                                    }
                                ],
                                createdRow: function(row, data, dataIndex) {
                                    // Apply custom styles to the specific columns
                                    $('td', row).eq(4).css('background-color', 'lightblue');
                                    $('td', row).eq(5).css('background-color', 'lightgreen');
                                    $('td', row).eq(6).css('background-color', 'lightcoral');
                                },
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
                        url: '../config/visa/visaConfig.php',
                        data: {
                            action: 'deletepay',
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