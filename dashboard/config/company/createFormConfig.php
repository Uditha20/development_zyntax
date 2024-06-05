<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/company/createFormFuntion.php';
header('Content-Type: application/json');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = $_POST['email'];
    $company_name = $_POST['company_name'];
    $country= $_POST['country'];
    $phone = $_POST['phone'];
    

    echo "<script> alret($name); </script> ";

    $stmt = $db->prepare('INSERT INTO company (email, company_name, country, email) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $email, $company_name, $country, $phone);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database insertion failed']);
    }

    $stmt->close();
    $db->close();
    
} else {
    // Send filure response if not a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $companyName = $_POST['name'];
//     $country = $_POST['country'];
//     $phone = $_POST['phone'];
//     $email = $_POST['email'];
//     $approval_Id = 'some_approval_id'; // You can modify this as per your logic
//     $address = 'some_address'; // You can modify this as per your logic

//     // Call the function to insert data into the database
//     $result = insertCompany($companyName, $country, $phone, $email, $approval_Id, $address, $conn);

//     if ($result == 1) {
//         echo json_encode(['status' => 'success']);
//     } else {
//         echo json_encode(['status' => 'error']);
//     }
// }
// 
?>