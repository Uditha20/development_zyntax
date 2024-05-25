<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/status/assignFunction.php';

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
        $result=getinterview($conn);
        echo json_encode(["status" => "success", "data" => $result]);
        break;
    case 'selectData':
        $result=selectstate($conn);
        echo json_encode(["status" => "success", "data" => $result]);
        break;

   
    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        break;
}