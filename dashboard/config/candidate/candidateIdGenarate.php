<?php
require_once '../../../db/dbconfig.php';


function generateEmployeeId($conn) {
   
    $sql = "SELECT employee_id FROM candidate ORDER BY employee_id DESC LIMIT 1";
    $result = $conn->query($sql);

   
    if ($result && $result->num_rows > 0) {
        // Fetch the last employee_id
        $row = $result->fetch_assoc();
        $lastEmployeeId = $row['employee_id'];
        $newEmployeeId = str_pad((int)$lastEmployeeId + 1, 4, '0', STR_PAD_LEFT);
    } else {
      
        $newEmployeeId = '0001';
    }

    return $newEmployeeId;
}

// Generate new employee ID
$newEmployeeId = generateEmployeeId($conn);


header('Content-Type: application/json');
echo json_encode(['candidate_id' => $newEmployeeId]);


$conn->close();