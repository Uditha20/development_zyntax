<button class="btn btn-primary mb-4" id="createJobButton" style="height: 55px;">Add Job Order</button>
    <div class="container">
        <h3>Job Order List</h3>
        <table id="jobDetailsTable" class="table table-bordered table-striped">

        </table>
    </div>

    <script>
        $(document).ready(function() {
            function jobOrder(){

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
                                        data: "job_count",
                                        title: "Assign_Amount"
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
                                            return '<button class="btn btn-warning btn-sm edit-btn" data-id="' + row.job_order_id + '">Edit</button>';
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Delete",
                                        render: function(data, type, row, meta) {
                                            return '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.job_order_id + '">Delete</button>';
                                        }
                                    }
                                ],
                                createdRow: function(row, data, dataIndex) {
                                    // Apply custom styles to the specific columns
                                    $('td', row).eq(5).css('background-color', 'lightcoral');
                                    $('td', row).eq(4).css('background-color', 'lightgreen');
                                   
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
            jobOrder()
            $('#jobDetailsTable').on('click', '.delete-btn', function() {
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
                        url: '../config/job_order/viewVacancyConfig.php',
                        data: {
                            action: 'delete',
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
                                jobOrder();
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