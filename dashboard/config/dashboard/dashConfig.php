<?php
require_once '../../../db/dbconfig.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST' || 'GET') {

    $result = getCounts($conn);

    echo json_encode(["status" => "success", "data" => $result]);
}

function getCounts($conn)
{
    // Array to store results
    $counts = [
        "candidate_count" => 0,
        "active_assign_count" => 0,
        "total_assign_count" => 0
    ];

    // Query to get the count of active candidates
    $sql_candidate = "SELECT COUNT(*) AS candidate_count FROM candidate WHERE isActive = 1";
    $result_candidate = $conn->query($sql_candidate);
    if ($result_candidate) {
        $row_candidate = $result_candidate->fetch_assoc();
        $counts['candidate_count'] = $row_candidate['candidate_count'];
    }

    // Query to get the count of active assignments (assign_state = 1) and isActive = 1
    $sql_active_assign = "SELECT COUNT(*) AS active_assign_count FROM assign_to_job WHERE assign_state = 1 AND isActive = 1";
    $result_active_assign = $conn->query($sql_active_assign);
    if ($result_active_assign) {
        $row_active_assign = $result_active_assign->fetch_assoc();
        $counts['active_assign_count'] = $row_active_assign['active_assign_count'];
    }

    // Query to get the total count of assignments where isActive = 1
    $sql_total_assign = "SELECT COUNT(*) AS total_assign_count FROM assign_to_job WHERE isActive = 1";
    $result_total_assign = $conn->query($sql_total_assign);
    if ($result_total_assign) {
        $row_total_assign = $result_total_assign->fetch_assoc();
        $counts['total_assign_count'] = $row_total_assign['total_assign_count'];
    }

    return $counts;
}
