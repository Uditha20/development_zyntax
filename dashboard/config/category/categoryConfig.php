<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/category/categoryFunctions.php';
header('Content-Type: application/json');

$response = array();

// Check if the category name is received
if (isset($_POST['category'])) {
    $categoryName = strtoupper($_POST['category']);
    // echo json_encode((["status" => "success","id"=>$categoryName]));
    // Process the data (e.g., save to the database)
    // For now, just return the received data
    // $response = array(
    //     'status' => 'success',
    //     'message' => 'Category received: ' . $categoryName
    // );
    $result = insertCategory($categoryName, $conn);
    if ($result) {
        $response = array(
            'status' => 'success',
            'message' => 'Category insert success'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Category name not received.'
    );
}

// Echo the JSON response
echo json_encode($response);
