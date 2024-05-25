<?php
function fetchCandidate($conn) {
    $sql = "SELECT id,first_name, last_name, employee_id FROM candidate WHERE isActive = 1";
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}


function fetchActive_job_titles($conn) {
    $stmt = $conn->prepare("SELECT 
        job_title.id AS job_id, 
        job_title.job_title_name, 
        category.id AS category_id, 
        category.categoryName
    FROM 
        job_title
    JOIN 
        category ON job_title.category_id = category.id
    WHERE 
        job_title.isActive = ?;");
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $isActive = 1;
    $stmt->bind_param("i", $isActive);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $job_titles = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $job_titles[] = $row;
            }
        }
        $stmt->close();
        return $job_titles;
    } else {
        echo "Error: " . $stmt->error;
        $stmt->close();
        return [];
    }
}


function insertJobOrder($conn, $company_id,$job_title_id, $vacances_amount,$payment) {
    $stmt = $conn->prepare("INSERT INTO job_order (company_id,job_title_id, vacances_amount,payment_for_job) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiii", $company_id,$job_title_id, $vacances_amount,$payment);
    
    if ($stmt->execute()) {
        return 1;
    } else {
        return 0;
    }
}
function fetchJobOrdersByCompanyId($conn, $companyId) {
    $sql = "
        SELECT 
            job_order.id, 
            job_order.company_id, 
            job_order.job_title_id, 
            job_order.vacances_amount, 
            job_order.payment_for_job,
            job_title.job_title_name, 
            category.categoryName,
            company.email AS company_Email, 
            company.company_name, 
            company.country, 
            company.phone 
        FROM 
            job_order 
        INNER JOIN 
            job_title 
        ON 
            job_order.job_title_id = job_title.id 
        INNER JOIN 
            category 
        ON 
            job_title.category_id = category.id 
        INNER JOIN 
            company 
        ON 
            job_order.company_id = company.id 
        WHERE 
            job_order.isActive = 1
        AND 
            job_order.company_id = ?
        AND
            company.isActive = 1
        AND 
            job_title.isActive = 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $companyId);  // "i" denotes that $companyId is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    $jobOrders = [];
    while ($row = $result->fetch_assoc()) {
        $jobOrders[] = $row;
    }

    $stmt->close();
    return $jobOrders;
}


function insertJobAssign($conn, $job_order_id,$candidate_id) {
    $stmt = $conn->prepare("INSERT INTO assign_to_job (job_order_id,candidate_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $job_order_id,$candidate_id);
    
    if ($stmt->execute()) {
        return 1;
    } else {
        return 0;
    }
}