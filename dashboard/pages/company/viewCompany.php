<button class="btn btn-primary mb-4" id="createCompanyButton" style="height: 55px;">Add Company</button>
    <div class="container">
        <h3>Company List</h3>
        <table id="categoryTable" class="table table-bordered table-striped">

        </table>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "../config/company/companyConfig.php",
                type: "GET",
                data: {
                    action: "comData"
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Loading...',
                        text: 'Please wait while we fetch the data.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    // console.log(response)
                    if (response.status === 'success') {
                        Swal.close();
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
                                    data: "company_name",
                                    title: "Company Name"
                                },
                                {
                                    data: "country",
                                    title: "Country"
                                },
                                {
                                    data: "email",
                                    title: "Email"
                                },
                                {
                                    data: "phone",
                                    title: "Phone"
                                },
                                {
                                    data: null,
                                    title: "Edit",
                                    render: function(data, type, row, meta) {
                                        return '<button class="btn btn-warning btn-sm edit-btn" data-id="' + meta.row + '">Edit</button>';
                                    }
                                },
                                {
                                    data: null,
                                    title: "Delete",
                                    render: function(data, type, row, meta) {
                                        return '<button class="btn btn-danger btn-sm delete-btn" data-id="' + meta.row + '">Delete</button>';
                                    }
                                }
                            ],
                            "pageLength": 10,
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                [10, 25, 50, "All"]
                            ],
                            "destroy": true, // Add this option if you want to reinitialize the table with new data
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