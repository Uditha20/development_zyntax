

<div class="row d-flex justify-content-center mt-5">
    <form id="CategoryCreationForm">
        <div class="d-flex align-items-center" style="flex-direction: column;">
            <div class="mb-3 col-md-4">
                <label for="exampleInputEmail1" class="form-label">Category Name</label>
                <input type="text" class="form-control border border-dark capitalize" name="category" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ex : ICT field">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $("#CategoryCreationForm").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "../config/category/categoryConfig.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if (data.status === "success") {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('CategoryCreationForm').reset();
                                // Any additional actions after closing the alert
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to submit form. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error("AJAX error: ", status, error);
                }
            });
        });
    });
</script>