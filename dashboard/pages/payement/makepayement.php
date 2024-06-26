<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>
<form id="makepayemnt" class="mx-4" data-id="<?php echo htmlspecialchars($id); ?>">
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="l1"><label>First Name</label></div>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Last Name</label></div>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Receipt ID</label></div>
            <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Payment</label></div>
            <input type="text" class="form-control" id="Payement" name="Payement" placeholder="" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Total Paid</label></div>
            <input type="text" class="form-control" id="Payed" name="Payed" placeholder="" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <div class="l1"><label>Due Amount</label></div>
            <input type="text" class="form-control" id="due" name="due" placeholder="" readonly>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="l1"><label>Add Payment</label></div>
            <input type="number" class="form-control" id="Pay_amount" name="Pay_amount" placeholder="" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Make payment</button>
</form>


<script>
    $(document).ready(function() {
        // // Initialize select2 for candidate dropdown
        // $('#Candidate').select2({
        //     placeholder: 'Select a candidate',
        //     allowClear: true
        // });

        // // Show loading alert
        // Swal.fire({
        //     title: 'Loading',
        //     allowOutsideClick: false,
        //     showConfirmButton: false,
        //     didOpen: () => {
        //         Swal.showLoading();
        //     }
        // });
        var id = $('#makepayemnt').data('id');

        // Fetch candidates and populate the select2 dropdown
        if (id) {

            $.ajax({
                type: 'GET',
                url: '../config/payment/payementConfig.php',
                data: {
                    action: 'getDetails',
                    id: id
                },

                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success' && response.data) {
                        // Populate the input fields with the received data
                        $('#Payement').val(parseFloat(response.data.payment).toFixed(2));
                        $('#Payed').val(parseFloat(response.data.payed_amount).toFixed(2));
                        var dueAmount = response.data.payment - response.data.payed_amount;
                        $('#due').val(parseFloat(dueAmount).toFixed(2));
                        $('#first_name').val(response.data.first_name);
                        $('#last_name').val(response.data.last_name);
                        $('#employee_id').val(response.data.employee_id);
                    } else {
                        Swal.fire('Error', 'Failed to retrieve payment details.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close(); // Close loading alert
                    Swal.fire('Error', 'AJAX error: ' + error, 'error');
                }
            });
        }


        // Handle form submission for making payment
        $("#makepayemnt").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
                formData.append('action', 'makepayement');
                formData.append('id', id)

            $.ajax({
                url: '../config/payment/payementConfig.php', // Replace with the path to your PHP config file
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Clear the form fields
                                $('#makepayemnt')[0].reset();
                                $('#Candidate').val(null).trigger('change');
                            }
                        });
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                    console.log(response); // Log the response for debugging
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'AJAX error: ' + error, 'error');
                }
            });
        });
    });
</script>