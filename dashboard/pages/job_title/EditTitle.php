<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>

<div class="row d-flex justify-content-center mt-5">

    <form id="editTitle" data-id="<?php echo htmlspecialchars($id); ?>">
        <div class="d-flex align-items-center" style="flex-direction: column;">
            <div class="mb-3 col-md-4">
                <label for="categorySelect" class="form-label">Category</label>
                <select class="form-control border border-dark" name="categorySelect" id="categorySelect" aria-describedby="categoryHelp">
                    <option value="">Select a category</option>
                </select>
            </div>
            <div class="mb-3 col-md-4">
                <label for="fieldNameInput" class="form-label">Field Name</label>
                <input type="text"  name="fieldNameInput"   class="form-control border border-dark capitalize" id="fieldNameInput" aria-describedby="fieldNameHelp" placeholder="Ex: Software Engineering">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>


    <script>
        $(document).ready(function() {
             // Initialize Select2
      $('#categorySelect').select2({
        placeholder: 'Select a category',
        allowClear: true
      });

      // Show loading alert
      Swal.fire({
        title: 'Loading',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // AJAX call to fetch category data
      $.ajax({
        type: 'GET',
        url: '../config/job_title/job_titleConfig.php',
        data: {
          action: 'activCatdata'
        },
        dataType: 'json',
        success: function(response) {
          Swal.close();
          if (response.status === 'success' && Array.isArray(response.data)) {
            var categorySelect = $('#categorySelect');
            categorySelect.empty();
            response.data.forEach(function(category) {
              var option = new Option(category.categoryName, category.id, false, false);
              categorySelect.append(option);
            });
            categorySelect.trigger('change');
          } else {
            console.error('Invalid response format or data:', response);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.close();
          console.error('Error in AJAX call:', textStatus, errorThrown);
        }
      });
            var id = $('#editTitle').data('id');
            // console.log('ID from data attribute:', id);

            if (id) {
                $.ajax({
                    url: '../config/job_title/job_titleConfig.php',
                    type: 'GET',
                    data: {
                        id: id,
                        action: 'getTItleDetails'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Assuming response.data contains the job title details
                            let jobTitleName = response.data.job_title_name;
                            // Set the value of the input field
                            $('#fieldNameInput').val(jobTitleName);
                        } else {
                            Swal.fire('Error', 'Failed to fetch job title details.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Failed to fetch job title details.', 'error');
                    }
                });
            }

            $('#editTitle').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('action', 'updatetitle');
                formData.append('id', id);
                $.ajax({
                    url: '../config/job_title/job_titleConfig.php',
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
                                $('.main-container').load('../pages/job_title/viewjobTitle.php');
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