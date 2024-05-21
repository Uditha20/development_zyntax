<body>
    <div class="container">
        <h3>Category List</h3>
        <table id="categoryTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here via DataTables -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "../config/category/categoryViewConfig.php",
                type: "GET",
                data: {
                    action: "catData"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#categoryTable').DataTable({
                            data: response.data,
                            columns: [
                                { data: "id" },
                                { data: "categoryName" },
                                { data: "isActive", render: function(data, type, row) {
                                    return data == 1 ? 'Active' : 'Inactive';
                                }}
                            ],
                            "pageLength": 10,
                            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
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