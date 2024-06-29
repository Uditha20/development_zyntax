<button type="button" id="loadData" class="btn btn-primary">Lorad Company List </button>

<table class="table mt-3" id="dataTable">
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Email</th>
            <th>country</th>
            <th>phoneNo</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be inserted here -->
    </tbody>
</table>
<script>
    $(document).ready(function () {
        $('#loadData').on('click', function () {
            $.ajax({
                type: 'GET',
                url: '../config/company/createFormConfig.php',
                data: {
                    action: 'Catdata'
                },
                dataType: 'json',
                success: function (response) {
                    Swal.close();
                    if (response.status === 'success' && Array.isArray(response.data)) {
                        var tbody = $('#dataTable tbody');
                        tbody.empty(); // Clear existing table rows

                        // Insert data into table
                        response.data.forEach(function (user) {
                            if (user.isActive) {
                                var row = '<tr>' +
                                    '<td>' + user.company_name + '</td>' +
                                    '<td>' + user.email + '</td>' +
                                    '<td>' + user.country + '</td>' +
                                    '<td>' + user.phone + '</td>' +
                                    '<td>' +
                                    '<button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' + user.id + '">Delete</button>' + '&nbsp' +
                                    '<button type="button" class="btn btn-warning btn-sm update-btn" data-id="' + user.id + '" data-company-name="' + user.company_name + '" data-email="' + user.email + '" data-country="' + user.country + '" data-phone="' + user.phone + '">Update</button>' +
                                    '</td>' +
                                    '</tr>';
                                tbody.append(row);
                            }
                        });
                    } else {
                        console.error('Invalid response format or data:', response);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    Swal.close();
                    console.error('Error in AJAX call:', textStatus, errorThrown);
                }
            });
        });

        // Update button click
        $(document).on('click', '.update-btn', function () {
            var id = $(this).data('id');
            var companyName = $(this).data('company-name');
            var email = $(this).data('email');
            var country = $(this).data('country');
            var phone = $(this).data('phone');
            $('#update-id').val(id);
            $('#update-name').val(companyName);
            $('#update-email').val(email);
            $('#update-country').val(country);
            $('#update-phone').val(phone);
            $('#update-modal').show();
        });

        // Save update
        $('#save-update').click(function () {
            var id = $('#update-id').val();
            var companyName = $('#update-name').val();
            var email = $('#update-email').val();
            var country = $('#update-country').val();
            var phone = $('#update-phone').val();
            $.ajax({
                url: '../config/company/createFormConfig.php',
                type: 'POST',
                data: { id: id, company_name: companyName, email: email, country: country, phone: phone },
                success: function (response) {
                    $('#update-modal').hide();
                    $('#loadData').click(); // Reload data
                }
            });
        });

        // Delete button click
        $(document).on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure you want to delete this record?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: '../config/company/createFormConfig.php',
                            type: 'POST',
                            data: { id: id },
                            success: function (response) {
                                $('#loadData').click(); // Reload data
                            }
                        });
                    },
                    cancel: function () {
                    }
                }
            });
        });
    });
</script>