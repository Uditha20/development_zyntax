<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/visa/visafuncton.php';

header('Content-Type: application/json');


$method = $_SERVER['REQUEST_METHOD'];
$action = '';
if ($method == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
} elseif ($method == 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
}
switch ($action) {
    case 'visaProcess':
        $result = visaProcess($conn);
        echo json_encode(["status" => "success", "data" => $result]);
        break;
    
    case 'newvisaProcess':
        $result =  newvisaProcess($conn);
        echo json_encode(["status" => "success", "data" => $result]);
        break;
   
    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        break;
}