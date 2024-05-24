<body>
    <div class="container">
        <h3>Job Title List</h3>
        <table id="categoryTable" class="table table-bordered table-striped">

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
                url: "../config/job_title/job_titleConfig.php",
                type: "GET",
                data: {
                    action: "Catdata"
                },
                success: function(response) {
                    Swal.close();
                    // console.log(response)
                    if (response.status === 'success') {
                // Initialize DataTable
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
                            data: "categoryName",
                            title: "Category Name"
                        },
                        {
                            data: "job_title_name",
                            title: "Job Title Name"
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