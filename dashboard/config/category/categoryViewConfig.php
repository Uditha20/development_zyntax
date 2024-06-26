<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/category/viewFunction.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$action = '';
if ($method == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
} elseif ($method == 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
}

switch ($action) {
    case 'catData':
        $categories = fetchCategories($conn);
        echo json_encode([
            "status" => "success",
            "data" => $categories
        ]);
        break;
    case 'delete':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $result = deactivateCategory($conn, $id);
            if ($result === 1) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Delete success..!"
                ]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "ID not provided"]);
        }
        break;

    case 'getCategoryDetails':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $result = getCategoryNameById($conn, $id);
            echo json_encode(["status"=>"success","data"=>$result]);
        } else {
            echo json_encode(["status" => "error", "message" => "ID not provided"]);
        }
        break;
    case 'updatecategory':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $categoryName=$_POST['category'];
            $result =updateCategory($conn, $id, $categoryName);
            if ($result === 1) {
                echo json_encode([
                    "status" => "success",
                    "message" => "update success..!"
                ]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "ID not provided"]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        break;
}
