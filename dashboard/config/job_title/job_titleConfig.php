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
    case 'activCatdata':
        // Handle employee data action
        $DetailCategory = fetchActiveCategories($conn);
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

    case 'delete':
        if(isset($_POST['id'])){
            $id=$_POST['id'];
            $result = deactivateJobtitle($conn, $id);
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
    case 'getTItleDetails':
        if(isset($_GET['id'])){
            $jobTitleId=$_GET['id'];
            $result=fetchJobTitleDetailsById($conn, $jobTitleId);
            echo json_encode(["status" => "success", "data" => $result]);
            break;

        }

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        break;
}