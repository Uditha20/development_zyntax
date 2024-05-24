<?php
function fetchCandidateDetails($conn) {
    $sql = "
        SELECT 
            id, 
            first_name, 
            last_name, 
            dob, 
            gender, 
            passport_no, 
            pass_expire_date, 
            mobile, 
            email, 
            address, 
            city, 
            employee_id
        FROM 
            candidate
        WHERE 
            isActive = 1
    ";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $candidates = [];
    while ($row = $result->fetch_assoc()) {
        $candidates[] = $row;
    }

    $stmt->close();
    return $candidates;
}
?>