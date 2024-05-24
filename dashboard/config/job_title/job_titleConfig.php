<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/job_title/jobTitleFunction.php';
header('Content-Type: application/json');


$method = $_SERVER['REQUEST_METHOD'];
$action = '';
if ($method == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
} elseif ($method == 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
}
switch ($action) {


    case 'Catdata':
        // Handle employee data action
        $DetailCategory = getJobTitles($conn);
        echo json_encode(["status" => "success", "data" => $DetailCategory]);
        break;
    
    case 'Create':
        if (isset($_POST['categoryId']) && isset($_POST['fieldName'])) {
            $cat_Id = $_POST['categoryId'];
            $fieldName = $_POST['fieldName'];
            $result = insertJobTitle($fieldName, $cat_Id, $conn);
            if ($result == 1) {
                echo json_encode((["status" => "success"]));
            } else {
                echo json_encode((["status" => "err", "message" => "something went Wrong"]));
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Not data recived.'
            );
        }

        break;
    
        


    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        break;
}
