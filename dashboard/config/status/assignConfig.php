<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/status/assignFunction.php';
require_once '../../functions/status/deleteFunction.php';


header('Content-Type: application/json');


$method = $_SERVER['REQUEST_METHOD'];
$action = '';
if ($method == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
} elseif ($method == 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
}
switch ($action) {
    case 'assignData':
        $result = getAssignToJobDetails($conn);
        echo json_encode(["status" => "success", "data" => $result]);
        break;
    case 'interviewData':
        $result = getinterview($conn);
        echo json_encode(["status" => "success", "data" => $result]);
        break;
    case 'selectData':
        $result = selectstate($conn);
        echo json_encode(["status" => "success", "data" => $result]);
        break;

    case 'visaReceivedData':
        $result = visaRecivedstate($conn);
        echo json_encode(["status" => "success", "data" => $result]);
        break;
    case 'visareject':
        $result = visaReject($conn);
        echo json_encode(["status" => "success", "data" => $result]);
        break;
    
    case 'assigdelete':
        if(isset($_POST['id'])){
            $id=$_POST['id'];
            $result = deactivateAssign($conn, $id);
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
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        break;
}
