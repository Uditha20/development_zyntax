<form id="payement">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-6 mb-3">

            <div class="mb-3 col-md-6">
                <div class="l1"><label>Candidate:</label></div>
                <select class="form-control border border-dark col-md-6" id="Candidate" name="Candidate" aria-describedby="categoryHelp">
                    <option value="">Select a Job Title</option>
                </select>
            </div>
            <div class="mb-3 col-md-4">
                <label for="payement" class="form-label">Payement</label>
                <input type="text" class="form-control border border-dark capitalize" id="payement" name="payement" aria-describedby="fieldNameHelp" placeholder="Ex: 10000.00">
            </div>
            <button type="submit" class="btn btn-primary ">Add payement</button>
        </div>
    </div>
</form>


<script>
    $(document).ready(function() {

        $('#Candidate').select2({
            placeholder: 'Select a candidate',
            allowClear: true
        });

        Swal.fire({
            title: 'Loading',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            type: 'POST',
            url: '../config/payment/payementConfig.php',
            data: {
                action: 'getcomdata'
            },
            dataType: 'json',
            success: function(response) {
                Swal.close();
                if (response.status === 'success' && Array.isArray(response.candidate)) {
                    var candidates = response.candidate;
                    var select2Data = candidates.map(function(candidate) {
                        return {
                            id: candidate.id,
                            text: candidate.first_name + ' ' + candidate.last_name + ' (' + candidate.employee_id + ')'
                        };
                    });

                    $('#Candidate').select2({
                        data: select2Data,
                        placeholder: 'Select a candidate',
                        allowClear: true
                    });
                } else {
                    Swal.fire('Error', 'No candidates found or invalid response format.', 'error');
                }
            },
            error: function(xhr, status, error) {
                Swal.close(); // Close loading alert
                Swal.fire('Error', 'AJAX error: ' + error, 'error');
            }
        });


        $("#payement").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('action', 'payement');

            $.ajax({
                url: '../config/payment/payementConfig.php', // Replace with the path to your PHP config file
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response)
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Clear the form fields
                                $('#payement')[0].reset();
                            }
                        });
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'AJAX error: ' + error, 'error');
                }
            });
        });
    });
</script>