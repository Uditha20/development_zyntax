<?php

// waiting =1
// interview=2
// interviewlist =3 pass
// interview fsail=0
// select statw=4 
// visa process =5
// visar apporve=6
// visa reject =7

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
AND 
assign_to_job.assign_state=1";

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

// Ensure this path is correct

function updateAssignToJob($conn, $assignToJobIds, $date, $time)
{
    // Prepare the SQL statement
    $sql = "UPDATE assign_to_job SET assign_state = 2, interview_date = ?, interview_time = ? WHERE id = ?";

    // Initialize the statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Loop through each ID and execute the update
    foreach ($assignToJobIds as $id) {
        $stmt->bind_param('ssi', $date, $time, $id);
        if (!$stmt->execute()) {
            $stmt->close();
            $conn->close();
            return 0;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return 1;
}


function getinterview($conn)
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
    assign_to_job.interview_date,
    assign_to_job.interview_time

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
assign_to_job.assign_state=2";

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



function updateinterview($conn, $assignToJobIds)
{
    // Prepare the SQL statement
    $sql = "UPDATE assign_to_job SET assign_state = 3 WHERE id = ?";

    // Initialize the statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Loop through each ID and execute the update
    foreach ($assignToJobIds as $id) {
        $stmt->bind_param('i',$id);
        if (!$stmt->execute()) {
            $stmt->close();
            $conn->close();
            return 0;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return 1;
}

function selectstate($conn)
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
    assign_to_job.interview_date,
    assign_to_job.interview_time

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
assign_to_job.assign_state=3";

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


function updateselect($conn, $assignToJobIds)
{
    // Prepare the SQL statement
    $sql = "UPDATE assign_to_job SET assign_state = 4 WHERE id = ?";

    // Initialize the statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Loop through each ID and execute the update
    foreach ($assignToJobIds as $id) {
        $stmt->bind_param('i',$id);
        if (!$stmt->execute()) {
            $stmt->close();
            $conn->close();
            return 0;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return 1;
}

function updatefinalselect($conn, $assignToJobIds)
{
    // Prepare the SQL statement
    $sql = "UPDATE assign_to_job SET assign_state =5 WHERE id = ?";

    // Initialize the statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Loop through each ID and execute the update
    foreach ($assignToJobIds as $id) {
        $stmt->bind_param('i',$id);
        if (!$stmt->execute()) {
            $stmt->close();
            $conn->close();
            return 0;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return 1;
}
function checkPaymentStatus($conn, $id) {
    // Initialize the result message
    $message = "";

    // Prepare the SQL statement
    $sql = "SELECT payment, payed_Amount FROM assign_to_job WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind the ID parameter
        $stmt->bind_param("i", $id);
        
        // Execute the statement
        $stmt->execute();
        
        // Declare variables to hold the results
        $payement = null;
        $payed_amount = null;
        
        // Bind the result variables
        $stmt->bind_result($payement, $payed_amount);
        
        // Fetch the result
        if ($stmt->fetch()) {
            if ($payement == 0 && $payed_amount == 0) {
                $message = "Payment still not allocated.";
            } elseif ($payement == $payed_amount) {
                $message = "Payment complete.";
            } else {
                $message = "Payment not complete.";
            }
        } else {
            $message = "No data found for the given ID.";
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Handle statement preparation error
        $message = "Failed to prepare the SQL statement.";
    }

    return $message;
}


function updateAssignState($conn, $assign_to_job_id) {
    $sql = "UPDATE assign_to_job SET assign_state = 6 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
      
        $stmt->bind_param("i", $assign_to_job_id);
        if ($stmt->execute()) {
           
            $stmt->close();
            return true; 
        } else {
            
            $stmt->close();
            return false;
        }
    } else {
       
        return false; 
    }
}

function visaRecivedstate($conn)
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
    candidate.mobile,
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
AND 
assign_to_job.assign_state=6";

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
function updaterejected($conn, $assign_to_job_id){
    $sql = "UPDATE assign_to_job SET assign_state = -1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
      
        $stmt->bind_param("i", $assign_to_job_id);
        if ($stmt->execute()) {
           
            $stmt->close();
            return true; 
        } else {
            
            $stmt->close();
            return false;
        }
    } else {
       
        return false; 
    }
}


function visaReject($conn)
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
    candidate.mobile,
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
AND 
assign_to_job.assign_state=-1";

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

function updatefail($conn, $assignToJobIds)
{
    // Prepare the SQL statement
    $sql = "UPDATE assign_to_job SET assign_state =0 WHERE id = ?";

    // Initialize the statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Loop through each ID and execute the update
    foreach ($assignToJobIds as $id) {
        $stmt->bind_param('i',$id);
        if (!$stmt->execute()) {
            $stmt->close();
            $conn->close();
            return 0;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return 1;
}