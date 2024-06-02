<?php
require_once '../../../db/dbconfig.php';
require_once "../../functions/job_order/vacanciesFunction.php";

// require_once '../../functions/job_title/jobTitleFunction.php';
header('Content-Type: application/json');


$method = $_SERVER['REQUEST_METHOD'];
$action = '';
if ($method == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
} elseif ($method == 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
}

switch ($action) {
    case 'vacancydata':
        $result = fetchActiveJobOrders($conn);
        echo json_encode(["status" => "success", "data" => $result]);
        break;
    
    case 'delete':
        if(isset($_POST['id'])){
            $id=$_POST['id'];
            $result = deactivateJoOrder($conn, $id);
            if($result===1){
                echo json_encode([
                    "status" => "success",
                    "message" => "Delete success..!"
                ]);
            }
        }else {
            echo json_encode(["status" => "error", "message" => "ID not provided"]);
        }
        break;
    default:
        // Output an error message for unknown actions
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        break;
}
