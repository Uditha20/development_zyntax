<?php
function fetchActiveJobOrders($conn) {
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
            company.isActive = 1
        AND 
            job_title.isActive = 1
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