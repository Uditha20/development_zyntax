<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>
<div class="row d-flex justify-content-center mt-5">
    <form id="CategoryCreationForm" data-id="<?php echo htmlspecialchars($id); ?>">
        <div class="d-flex align-items-center" style="flex-direction: column;">
            <div class="mb-3 col-md-4">
                <label for="exampleInputEmail1" class="form-label">Category Name</label>
                <input type="text" class="form-control border border-dark capitalize" name="category" id="category" aria-describedby="emailHelp" placeholder="Ex : ICT field">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        var id = $('#CategoryCreationForm').data('id');
        // console.log('ID from data attribute:', id);

        if (id) {
            $.ajax({
                url: '../config/category/categoryViewConfig.php',
                type: 'GET',
                data: {
                    id: id,
                    action: 'getCategoryDetails'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        
                        $('#category').val(response.data);
                    } else {
                        Swal.fire('Error', 'Failed to fetch category details.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Failed to fetch company details.', 'error');
                }
            });
        }

        $('#CategoryCreationForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('action', 'updatecategory');
            formData.append('id', id);
            $.ajax({
                url: '../config/category/categoryViewConfig.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        title: 'Success!',
                        text: 'Company updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('.main-container').load('../pages/category/categoryView.php');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Failed to update company.', 'error');
                }
            });
        });
    });
</script>