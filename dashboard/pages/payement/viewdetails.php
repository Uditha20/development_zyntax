<body>
    <div class="container">
        <h3>Payement Details</h3>
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
                        action: "detailsvisaProcess"
                    },
                    success: function(response) {
                        // console.log(response);
                        Swal.close();
                        if (response.status === 'success') {
                            $('#categoryTable').DataTable({
                                data: response.data,
                                columns: [
                        {
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
        });
    </script>