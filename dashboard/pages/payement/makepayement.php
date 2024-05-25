<form id="makepayemnt" class="mx-4">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 mb-3">
            <div class="mb-3 col-md-6">
                <div class="l1"><label>Candidate:</label></div>
                <select class="form-control border border-dark col-md-6" id="Candidate" name="Candidate" aria-describedby="categoryHelp">
                    <option value="">Select a candidate</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Payment</label></div>
            <input type="text" class="form-control" id="Payement" name="Payement" placeholder="" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Total Payed</label></div>
            <input type="text" class="form-control" id="Payed" name="Payed" placeholder="" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Due Amount</label></div>
            <input type="text" class="form-control" id="due" name="due" placeholder="" readonly>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="col-md-6 mb-3">
            <div class="l1"><label>Add Payment</label></div>
            <input type="text" class="form-control" id="Pay_amount" name="Pay_amount" placeholder="Ex" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Make payment</button>
</form>


<script>
    $(document).ready(function() {
        // Initialize select2 for candidate dropdown
        $('#Candidate').select2({
            placeholder: 'Select a candidate',
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

        // Fetch candidates and populate the select2 dropdown
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

        // Fetch payment details when a candidate is selected
        $('#Candidate').on('change', function() {
            var selectedAssignId = $(this).val();
            if (selectedAssignId) {
                $.ajax({
                    type: 'POST',
                    url: '../config/payment/payementConfig.php',
                    data: {
                        action: 'getDetails',
                        assig_id: selectedAssignId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success' && response.data) {
                            // Populate the input fields with the received data
                            $('#Payement').val(parseFloat(response.data.payment).toFixed(2));
                            $('#Payed').val(parseFloat(response.data.payed_amount).toFixed(2));
                            var dueAmount = response.data.payment - response.data.payed_amount;
                            $('#due').val(parseFloat(dueAmount).toFixed(2));
                        } else {
                            Swal.fire('Error', 'Failed to retrieve payment details.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'AJAX error: ' + error, 'error');
                    }
                });
            }
        });

        // Handle form submission for making payment
        $("#makepayemnt").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('action', 'makepayement');

            $.ajax({
                url: '../config/payment/payementConfig.php', // Replace with the path to your PHP config file
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    // if (response.status === 'success') {
                    //     Swal.fire({
                    //         title: 'Success!',
                    //         text: response.message,
                    //         icon: 'success',
                    //         confirmButtonText: 'OK'
                    //     }).then((result) => {
                    //         if (result.isConfirmed) {
                    //             // Clear the form fields
                    //             $('#makepayemnt')[0].reset();
                    //             $('#Candidate').val(null).trigger('change');
                    //         }
                    //     });
                    // } else {
                    //     Swal.fire('Error', response.message, 'error');
                    // }
                    console.log(response); // Log the response for debugging
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'AJAX error: ' + error, 'error');
                }
            });
        });
    });
</script>