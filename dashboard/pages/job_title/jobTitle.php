<div class="row d-flex justify-content-center mt-5">

  <form id="dataForm">
    <div class="d-flex align-items-center" style="flex-direction: column;">
      <div class="mb-3 col-md-4">
        <label for="categorySelect" class="form-label">Category</label>
        <select class="form-control border border-dark" id="categorySelect" aria-describedby="categoryHelp">
          <option value="">Select a category</option>
        </select>
      </div>
      <div class="mb-3 col-md-4">
        <label for="fieldNameInput" class="form-label">Field Name</label>
        <input type="text" class="form-control border border-dark capitalize" id="fieldNameInput" aria-describedby="fieldNameHelp" placeholder="Ex: Software Engineering">
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

      // Handle form submission
      $('#dataForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Get selected category ID and field name value
        var categoryId = $('#categorySelect').val();
        var fieldName = $('#fieldNameInput').val();

        // Show loading alert
        Swal.fire({
          title: 'Saving',
          allowOutsideClick: false,
          showConfirmButton: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        // Send data using AJAX
        $.ajax({
          type: 'POST',
          url: '../config/job_title/job_titleConfig.php',
          data: {
            action: 'Create',
            categoryId: categoryId,
            fieldName: fieldName
          },
          dataType: 'json',
          success: function(response) {
            Swal.close();
            if (response.status === 'success') {
              Swal.fire({
                title: 'Success!',
                text: "insert successfull",
                confirmButtonText: 'OK'
              }).then((result) => {
                if (result.isConfirmed) {
                  document.getElementById('dataForm').reset();
                  // Any additional actions after closing the alert
                }
              });
            } else {
              Swal.fire('Error', 'Failed to save data: ' + response.message, 'error');
            }
            console.log(response);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.close();
            Swal.fire('Error', 'Error in AJAX call: ' + textStatus, 'error');
          }
        });
      });
    });
  </script>