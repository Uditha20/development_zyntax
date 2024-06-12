<button type="button" id="loadData" class="btn btn-primary">Lorad Company List </button>

<table class="table mt-3" id="dataTable">
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Email</th>
            <th>country</th>
            <th>phoneNo</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be inserted here -->
    </tbody>
</table>
<script>
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
                        var row = '<tr>' +
                            '<td>' + user.company_name + '</td>' +
                            '<td>' + user.email + '</td>' +
                            '<td>' + user.country + '</td>' +
                            '<td>' + user.phone + '</td>' +
                            '</tr>';
                        tbody.append(row);
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
</script>