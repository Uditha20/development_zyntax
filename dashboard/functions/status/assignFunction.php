<?php
function getAssignToJobDetails($conn)
{
    $sql = "
    SELECT 
    assign_to_job.id AS assign_to_job_id,
    assign_to_job.job_order_id,
    assign_to_job.candidate_id,
    assign_to_job.assign_state,
    job_order.company_id,
    job_order.job_title_id,
    job_order.vacances_amount,
    company.company_name,
    job_title.job_title_name,
    job_title.category_id,
    candidate.first_name,
    candidate.last_name,
    candidate.employee_id
FROM 
    assign_to_job
INNER JOIN 
    job_order ON assign_to_job.job_order_id = job_order.id
INNER JOIN 
    company ON job_order.company_id = company.id
INNER JOIN 
    job_title ON job_order.job_title_id = job_title.id
INNER JOIN 
	candidate ON assign_to_job.candidate_id =candidate.id
WHERE 
	assign_to_job.isActive=1
    ";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $stmt->close();
        return $data;
    } else {
        die("Prepare failed: " . $conn->error);
    }
}
