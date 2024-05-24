<body>
    <div class="container">
        <h3>Job Title List</h3>
        <table id="jobDetailsTable" class="table table-bordered table-striped">

        </table>
    </div>

    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait while we fetch the data.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: "../config/job_order/viewVacancyConfig.php",
                type: "GET",
                data: {
                    action: "vacancydata"
                },
                success: function(response) {
                    Swal.close(); 
                    if (response.status === 'success') {
                        // Initialize DataTable
                        $('#jobDetailsTable').DataTable({
                            data: response.data,
                            columns: [{
                                    data: null,
                                    title: "No",
                                    render: function(data, type, row, meta) {
                                        return meta.row + 1;
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
                                    data: "categoryName",
                                    title: "Category Name"
                                },
                                {
                                    data: "vacances_amount",
                                    title: "Vacances Amount"
                                },
                                {
                                    data: "payment_for_job",
                                    title: "Payment for Job"
                                },
                                {
                                    data: "company_Email",
                                    title: "Company Email"
                                },
                                {
                                    data: "country",
                                    title: "Country"
                                },
                                {
                                    data: "phone",
                                    title: "Phone"
                                },
                                {
                                    data: null,
                                    title: "Edit",
                                    render: function(data, type, row, meta) {
                                        return '<button class="btn btn-warning btn-sm edit-btn" data-id="' + row.id + '">Edit</button>';
                                    }
                                },
                                {
                                    data: null,
                                    title: "Delete",
                                    render: function(data, type, row, meta) {
                                        return '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.id + '">Delete</button>';
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
        });
    </script>