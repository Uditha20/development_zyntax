<button type="button" id="loadData" class="btn btn-primary">Load Company List</button>
<div id="loading" style="display: none;">Loading...</div>

<table class="table mt-3" id="dataTable">
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Email</th>
            <th>Country</th>
            <th>Phone No</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be inserted here -->
    </tbody>
</table>

<div id="pagination" style="display: flex; justify-content: center; margin-top: 20px;">
    <button id="prevPage" disabled>Previous</button>
    <span id="pageInfo"></span>
    <button id="nextPage" disabled>Next</button>
</div>

<!-- Update Modal -->
<div id="update-modal">
    <input type="hidden" id="update-id">
    <label for="update-name">Company Name:</label>
    <input type="text" id="update-name">
    <label for="update-email">Email:</label>
    <input type="email" id="update-email">
    <label for="update-country">Country:</label>
    <input type="text" id="update-country">
    <label for="update-phone">Phone:</label>
    <input type="text" id="update-phone">
    <button id="save-update">Save</button>
</div>


<script>
    let currentPage = 1;
    const limit = 10;

    function loadData(page) {
        $('#loading').show();
        $.ajax({
            type: 'GET',
            url: '../config/company/createFormConfig.php',
            data: {
                action: 'fetch',
                page: page,
                limit: limit
            },
            dataType: 'json',
            success: function (response) {
                Swal.close();
                $('#loading').hide();
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

                    updatePagination(response.currentPage, response.totalPages);
                } else {
                    console.error('Invalid response format or data:', response);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loading').hide();
                Swal.close();
                console.error('Error in AJAX call:', textStatus, errorThrown);
            }
        });
    }

    function updatePagination(currentPage, totalPages) {
        $('#pageInfo').text(`Page ${currentPage} of ${totalPages}`);
        $('#prevPage').prop('disabled', currentPage <= 1);
        $('#nextPage').prop('disabled', currentPage >= totalPages);
    }

    $('#loadData').on('click', function () {
        currentPage = 1;
        loadData(currentPage);
    });

    $('#prevPage').on('click', function () {
        if (currentPage > 1) {
            currentPage--;
            loadData(currentPage);
        }
    });

    $('#nextPage').on('click', function () {
        currentPage++;
        loadData(currentPage);
    });

    $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure you want to delete this company?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        type: 'POST',
                        url: '../config/company/createFormConfig.php',
                        data: {
                            action: 'delete',
                            id: id
                        },
                        success: function (response) {
                            loadData(currentPage);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.error('Error in AJAX call:', textStatus, errorThrown);
                        }
                    });
                },
                cancel: function () {
                    // Do nothing
                }
            }
        });
    });

    $(document).on('click', '.update-btn', function () {
        const id = $(this).data('id');
        const companyName = $(this).data('company-name');
        const email = $(this).data('email');
        const country = $(this).data('country');
        const phone = $(this).data('phone');

        $('#update-id').val(id);
        $('#update-name').val(companyName);
        $('#update-email').val(email);
        $('#update-country').val(country);
        $('#update-phone').val(phone);

        $('#update-modal').show();
    });

    $('#save-update').on('click', function () {
        const id = $('#update-id').val();
        const companyName = $('#update-name').val();
        const email = $('#update-email').val();
        const country = $('#update-country').val();
        const phone = $('#update-phone').val();

        $.ajax({
            type: 'POST',
            url: '../config/company/createFormConfig.php',
            data: {
                action: 'update',
                id: id,
                name: companyName,
                email: email,
                country: country,
                phone: phone
            },
            success: function (response) {
                $('#update-modal').hide();
                loadData(currentPage);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error in AJAX call:', textStatus, errorThrown);
            }
        });
    });

</script>