    <button class="btn btn-primary mb-4" id="createCandidateButton" style="height: 55px;">Register Candidate</button>
    <div class="table-container ">
        <h3>Candidate List</h3>
        <table id="candidateTable" class="display" style="width: 100%;">

        </table>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "../config/candidate/viewConfig.php",
                type: "GET",
                data: {
                    action: "candiView"
                },
                success: function(response) {
                    if (response.status === 'success') {
                // Initialize DataTable
                $('#candidateTable').DataTable({
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
                            title: "Mobile"
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