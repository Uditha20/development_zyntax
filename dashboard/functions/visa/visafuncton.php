<?php
function visaProcess($conn)
{
    $sql = "
    SELECT 
    assign_to_job.id AS assign_to_job_id,
    assign_to_job.candidate_id,
    assign_to_job.assign_state,
    company.company_name,
    job_title.job_title_name,
    candidate.first_name,
    candidate.last_name,
    candidate.employee_id,
    assign_to_job.payment,
    assign_to_job.payed_Amount


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
AND 
assign_to_job.assign_state =4";

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

function newvisaProcess($conn)
{
    $sql = "
    SELECT 
    assign_to_job.id AS assign_to_job_id,
    assign_to_job.candidate_id,
    assign_to_job.assign_state,
    company.company_name,
    job_title.job_title_name,
    candidate.first_name,
    candidate.last_name,
    candidate.employee_id,
    assign_to_job.payment,
    assign_to_job.payed_Amount


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
AND 
assign_to_job.assign_state=5";

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


function detailsvisaProcess($conn)
{
    $sql = "
    SELECT 
    assign_to_job.id AS assign_to_job_id,
    assign_to_job.candidate_id,
    assign_to_job.assign_state,
    company.company_name,
    job_title.job_title_name,
    candidate.first_name,
    candidate.last_name,
    candidate.employee_id,
    assign_to_job.payment,
    assign_to_job.payed_Amount,
    assign_to_job.last_pay_time


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
AND 
assign_to_job.assign_state >=4
AND 
assign_to_job.ispayActive=1";

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

function deactivatepay($conn, $id) {
    // Prepare the SQL statement with a placeholder
    $stmt = $conn->prepare("UPDATE assign_to_job SET ispayActive = 0 WHERE id = ?");
    
    // Check if the preparation was successful
    if ($stmt === false) {
        return 0;
    }
    
    // Bind the parameters (i for integer)
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    if ($stmt->execute()) {
        $stmt->close();
        return 1;
    } else {
        $stmt->close();
        return 0;
    }
}