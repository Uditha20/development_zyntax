<body>
    <div class="container">
        <h3>Visa Received state</h3>
        <div class="row">
            <!-- <div class="col-md-3 mb-4">
                <label for="dateInput" class="form-label">Select Date</label>
                <input type="date" class="form-control" id="dateInput" name="dateInput">
            </div>
            <div class="col-md-3 mb-4">
                <label for="timeInput" class="form-label">Select Time</label>
                <input type="time" class="form-control" id="timeInput" name="timeInput">
            </div>
         -->


        </div>
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
                        action: "visareject"
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
                                        data: "company_name",
                                        title: "Company Name"
                                    },
                                    {
                                        data: "mobile",
                                        title: "Phone No"
                                    },
                                    {
                                        data: "job_title_name",
                                        title: "Job Title Name"
                                    },                                
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

        });
    </script>