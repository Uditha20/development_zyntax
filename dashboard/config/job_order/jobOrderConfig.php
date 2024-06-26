<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/company/companyFunction.php';
require_once "../../functions/job_order/jobOrderFunction.php";

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
    case 'getdata':
        // Handle getdata action
        $company = fetchCompany($conn);
        $job_title = fetchActive_job_titles($conn);
        echo json_encode([
            "status" => "success",
            "company" => $company,
            "job_title" => $job_title
        ]);
        break;
    case 'jobOrder':
        if (isset($_POST['companySelect']) && isset($_POST['categorySelect']) && isset($_POST['vacanciescount']) && isset($_POST['payment'])) {
            $companySelect = htmlspecialchars($_POST['companySelect']);
            $categorySelect = htmlspecialchars($_POST['categorySelect']);
            $vacanciesCount = htmlspecialchars($_POST['vacanciescount']);
            $payment = htmlspecialchars($_POST['payment']);
            $Currency = htmlspecialchars($_POST['Currency']);
            $bureau = htmlspecialchars($_POST['bureau']);
            $req = htmlspecialchars($_POST['req']);
            $medicale = htmlspecialchars($_POST['medicale']);
            $visafee = htmlspecialchars($_POST['visafee']);


            // Process the data, e.g., save to database
            // Placeholder processing
            // $result = saveToDatabase($companySelect, $categorySelect, $email, $phone);
            $result = insertJobOrder($conn, $companySelect, $categorySelect, $vacanciesCount, $payment, $Currency, $bureau, $req, $medicale, $visafee);
            if ($result == 1) {
                echo json_encode(['status' => 'success', 'message' => 'Job order registered successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to register job order']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Missing required data']);
        }
        break;

    case 'getcomdata':
        $company = fetchCompany($conn);
        $candidate = fetchCandidate($conn);
        echo json_encode([
            "status" => "success",
            "company" => $company,
            "candidate" => $candidate
        ]);
        break;
    case 'getJobDetails':
        if (isset($_POST['companyId'])) {
            $companyId = intval($_POST['companyId']);
            $result = fetchJobOrdersByCompanyId($conn, $companyId);
            echo json_encode(["status" => "success", "jobDetails" => $result]);
        }
        break;
    case 'jobassign':
        if (isset($_POST['joborder']) && isset($_POST['Candidate'])) {
            $joborderId = intval($_POST['joborder']);
            $candidateId = intval($_POST['Candidate']);
            $result = insertJobAssign($conn, $joborderId, $candidateId);
            if ($result == 1) {
                echo json_encode(['status' => 'success', 'message' => 'Job order registered successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to register job order']);
            }
        }
        break;
    case 'editData':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $result = getJobOrderDetails($conn, $id);
            echo json_encode(["status" => "success", "jobDetails" => $result]);
        }
        break;
    case 'updatejob':

        // All variables are set and not empty
        $id = intval($_POST['id']);
        $companySelect = htmlspecialchars($_POST['companySelect']);
        $categorySelect = htmlspecialchars($_POST['categorySelect']);
        $vacanciesCount = htmlspecialchars($_POST['vacanciescount']);
        $payment = htmlspecialchars($_POST['payment']);
        $Currency = htmlspecialchars($_POST['Currency']);
        $bureau = htmlspecialchars($_POST['bureau']);
        $req = htmlspecialchars($_POST['req']);
        $medicale = htmlspecialchars($_POST['medicale']);
        $visafee = htmlspecialchars($_POST['visafee']);
        $result= updateJobOrder($conn, $id, $companySelect, $categorySelect, $vacanciesCount, $payment, $Currency, $bureau, $req, $medicale, $visafee);
       if($result===1){

           echo json_encode(["status" => "success", "message" => "successful update ...!"]);
       }else{
        echo json_encode(["status" => "fail", "message" => "fail to update"]);

       }
        

        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        break;
}
