<?php
function fetchActiveJobOrders($conn)
{
    $sql = "
    SELECT 
    job_order.id AS job_order_id, 
    job_order.company_id, 
    job_order.job_title_id, 
    job_order.vacances_amount, 
    job_order.payment_for_job,
    job_title.job_title_name, 
    category.categoryName,
    company.email AS company_Email, 
    company.company_name, 
    company.country, 
    company.phone,
    COALESCE(assign_count.job_count, 0) AS job_count
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
LEFT JOIN (
    SELECT 
        job_order_id, 
        COUNT(*) AS job_count
    FROM 
        assign_to_job
    WHERE 
        isActive = 1
    GROUP BY 
        job_order_id
) AS assign_count 
ON 
    job_order.id = assign_count.job_order_id
WHERE 
    job_order.isActive = 1;
    ";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $jobOrders = [];
    while ($row = $result->fetch_assoc()) {
        $jobOrders[] = $row;
    }

    $stmt->close();
    return $jobOrders;
}


function deactivateJoOrder($conn, $id)
{
    // Prepare the SQL statement with a placeholder
    $stmt = $conn->prepare("UPDATE job_order SET isActive = 0 WHERE id = ?");

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
