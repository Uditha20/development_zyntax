<div class="container">
    <div class="row ">
        <div class="col-xl-4 col-lg-4">
            <div class="card l-bg-cherry">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Active Candidates</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0" id="activeCandidatesCount">

                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Assigned Candidates</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0" id="totalAssignedCount">

                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4">
            <div class="card l-bg-green-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Migrants Candidate</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0" id="assignedCandidatesCount">

                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        
        $.ajax({
            url: '../config/dashboard/dashConfig.php',
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    const data = response.data;
                    $('#activeCandidatesCount').text(data.candidate_count);
                    $('#assignedCandidatesCount').text(data.total_assign_count);
                    $('#totalAssignedCount').text(data.active_assign_count);
                } else {
                    console.error('Error fetching data:', response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching candidate ID:', textStatus, errorThrown);
            }
        });
    })
</script>