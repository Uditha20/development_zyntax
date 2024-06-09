<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/job_title/jobTitleFunction.php';
header('Content-Type: application/json');


// $method = $_SERVER['REQUEST_METHOD'];
// $action = '';
// if ($method == 'POST') {
//     $action = isset($_POST['action']) ? $_POST['action'] : '';
// } elseif ($method == 'GET') {
//     $action = isset($_GET['action']) ? $_GET['action'] : '';


// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request - Insert data
    $email = $_POST['email'];
    $company_name = $_POST['name'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];

    $result = insertCompany($email, $company_name, $country, $phone, $conn);
    if ($result == 1) {
        echo json_encode(['status' => 'success', 'message' => 'Database insertion successed!']);

    } else {
        echo json_encode(['status' => 'fail', 'message' => 'Database insertion failed']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET request - Fetch data
    $DetailCategory = fetchActiveCategories1($conn);
    echo json_encode(['email' => $email, 'company_name' => $company_name, 'country' => $country, 'phone' => $phone]);
    // echo json_encode(["status" => "success", "data" => $DetailCategory]);

    echo json_encode($DetailCategory);
} else {
    // Send failure response if not a POST or GET request
    echo json_encode(['status' => 'fail', 'message' => 'Invalid request method']);
}

$conn->close();
