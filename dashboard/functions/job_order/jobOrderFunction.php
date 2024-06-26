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


function insertJobOrder($conn, $companySelect, $categorySelect, $vacanciesCount, $payment,$Currency,$bureau,$req,$medicale,$visafee) {
    $stmt = $conn->prepare("INSERT INTO job_order (company_id,job_title_id, vacances_amount,payment_for_job,curency,bureaufee,reqfee,medicalfee,visafee) VALUES (?, ?, ?, ?,?, ?, ?, ?,?)");
    $stmt->bind_param("iiiisdddd",$companySelect, $categorySelect, $vacanciesCount, $payment,$Currency,$bureau,$req,$medicale,$visafee);
    
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


function getJobOrderDetails($conn, $id) {
    // Prepare the SQL statement with placeholders
    $sql = "SELECT id, company_id, job_title_id, vacances_amount, payment_for_job, bureaufee, reqfee, medicalfee, visafee, curency
            FROM job_order 
            WHERE id = ? AND isActive = 1";
    
    // Initialize the prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter to the placeholder
        $stmt->bind_param("i", $id);

        // Execute the statement
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();
            
            // Check if any row was returned
            if ($result->num_rows > 0) {
                // Fetch the row as an associative array
                $row = $result->fetch_assoc();
                // Close the statement
                $stmt->close();
                // Return the row data
                return $row;
            } else {
                // Close the statement
                $stmt->close();
                return null; // No job order found with the given ID
            }
        } else {
            return null; // Execute failed
        }
    } else {
        return null; // Prepare failed
    }
}

function updateJobOrder($conn, $id, $companySelect, $categorySelect, $vacanciesCount, $payment, $Currency, $bureau, $req, $medicale, $visafee)
{
    // Base query
    $query = "UPDATE job_order SET 
                vacances_amount = ?, 
                payment_for_job = ?, 
                bureaufee = ?, 
                reqfee = ?, 
                medicalfee = ?, 
                visafee = ?, 
                curency = ?";
                
    // Parameters array
    $params = [];
    $paramTypes = 'idddddd';

    // Conditionally add company_id to query
    if (!empty($companySelect)) {
        $query .= ", company_id = ?";
        $params[] = $companySelect;
        $paramTypes .= 'i';
    }

    // Conditionally add job_title_id to query
    if (!empty($categorySelect)) {
        $query .= ", job_title_id = ?";
        $params[] = $categorySelect;
        $paramTypes .= 'i';
    }

    // Append the WHERE clause
    $query .= " WHERE id = ?";
    $params[] = $id;
    $paramTypes .= 'i';

    // Prepare the statement
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        return 0; // Prepare failed
    }

    // Bind parameters
    $stmt->bind_param($paramTypes, $vacanciesCount, $payment, $bureau, $req, $medicale, $visafee, $Currency, ...$params);

    // Execute the statement
    if ($stmt->execute()) {
        // Update successful
        return 1;
    } else {
        // Update failed
        return 0;
    }
}