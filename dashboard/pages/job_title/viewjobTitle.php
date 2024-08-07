<button class="btn btn-primary mb-4" id="createTitleButton" style="height: 55px;">Add Title</button>

<div class="container">
    <h3>Job Title List</h3>
    <table id="jobtitles" class="table table-bordered table-striped">

    </table>
</div>

<script>
    $(document).ready(function() {
        function jobtitlesview() {

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
                        $('#jobtitles').DataTable({
                            data: response.data,
                            columns: [{
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
                                        return '<button class="btn btn-warning btn-sm edit-btntitle" data-id="' + row.job_title_id + '">Edit</button>';
                                    }
                                },
                                {
                                    data: null,
                                    title: "Delete",
                                    render: function(data, type, row, meta) {
                                        return '<button class="btn btn-danger btn-sm delete-btn" data-id="' + row.job_title_id + '">Delete</button>';
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
        jobtitlesview()
        $('#jobtitles').on('click', '.delete-btn', function() {
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
                        url: '../config/job_title/job_titleConfig.php',
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
                                    jobtitlesview();
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