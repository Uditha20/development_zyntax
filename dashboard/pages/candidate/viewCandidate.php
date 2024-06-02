    <button class="btn btn-primary mb-4" id="createCandidateButton" style="height: 55px;">Register Candidate</button>
    <div class="table-container">
        <h3>Candidate List</h3>
        <table id="candidateTable" class="table table-bordered table-striped display" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Passport No</th>
                    <th>Passport Expiry Date</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Candidate_ID</th>
                    <th>CV</th>
                    <th>Passport</th>
                    <th>Profile Picture</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            function candidatedetails(){

                $.ajax({
                    url: "../config/candidate/viewConfig.php",
                    type: "GET",
                    data: {
                        action: "candiView"
                    },
                    dataType: "json",
                    success: function(response) {
                        // console.log(response); // Debugging line
                        if (response.status === 'success') {
                            $('#candidateTable').DataTable({
                                data: response.data,
                                columns: [{
                                        data: null,
                                        title: "No",
                                        render: function(data, type, row, meta) {
                                            return meta.row + 1;
                                        }
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
                                        data: "dob",
                                        title: "Date of Birth"
                                    },
                                    {
                                        data: "gender",
                                        title: "Gender"
                                    },
                                    {
                                        data: "passport_no",
                                        title: "Passport No"
                                    },
                                    {
                                        data: "pass_expire_date",
                                        title: "Passport Expiry Date"
                                    },
                                    {
                                        data: "mobile",
                                        title: "WhatsApp"
                                    },
                                    {
                                        data: "email",
                                        title: "Email"
                                    },
                                    {
                                        data: "city",
                                        title: "City"
                                    },
                                    {
                                        data: "employee_id",
                                        title: "Candidate_ID"
                                    },
                                    {
                                        data: "cv",
                                        title: "CV View",
                                        render: function(data, type, row, meta) {
                                            if (data) {
                                                return '<button class="btn btn-info btn-sm" onclick="window.open(\'http://localhost/candidate/dashboard/config/candidate/' + data + '\', \'_blank\')">CV</button>';
                                            }
                                            return '';
                                        }
                                    },
                                    {
                                        data: "passport",
                                        title: "Passport View",
                                        render: function(data, type, row, meta) {
                                            if (data) {
                                                return '<button class="btn btn-info btn-sm" onclick="window.open(\'http://localhost/candidate/dashboard/config/candidate/' + data + '\', \'_blank\')">Passport</button>';
                                            }
                                            return '';
                                        }
                                    },
                                    {
                                        data: "profile",
                                        title: "Profile Picture",
                                        render: function(data, type, row, meta) {
                                            if (data) {
                                                return '<button class="btn btn-info btn-sm" onclick="window.open(\'http://localhost/candidate/dashboard/config/candidate/' + data + '\', \'_blank\')">Profile</button>';
                                            }
                                            return '';
                                        }
                                    },
                                    {
                                        data: null,
                                        title: "Edit",
                                        render: function(data, type, row, meta) {
                                            return '<button class="btn btn-warning btn-sm editcandidate-btn" data-id="' + row.id + '">Edit</button>';
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
                                "destroy": true
                            });
                        } else {
                            Swal.fire('Error', 'Failed to fetch candidate data.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        Swal.fire('Error', 'Failed to fetch candidate data.', 'error');
                    }
                })
            }
            candidatedetails()
            $('#candidateTable').on('click', '.delete-btn', function() {
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
                        url: "../config/candidate/viewConfig.php",
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
                                candidatedetails()
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