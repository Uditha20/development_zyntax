<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/company/companyFunction.php';
require_once "../../functions/payement/payementFunction.php";

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
    case 'getcomdata':
        $candidate = getAssignedCandidates($conn);
        echo json_encode([
            "status" => "success",
            "candidate" => $candidate
        ]);
        break;
    case 'payement':
        if (isset($_POST['Candidate']) && isset($_POST['payement'])) {

            $id = $_POST['Candidate'];
            $payment = $_POST['payement'];
            $result = updatePayment($conn, $id, $payment);
            echo json_encode([
                "status" =>  'success',
                "message" => 'payement update success'
            ]);
        }
        break;
    case 'getDetails':
        if (isset($_POST['assig_id'])) {
            $id = $_POST['assig_id'];
            $result = getPaymentDetails($conn, $id);
            echo json_encode([
                "status" => "success",
                "data" => $result
            ]);
        }
        break;
    case 'makepayement':
        if (isset($_POST['Candidate']) && isset($_POST['Pay_amount'])) {

            $id = $_POST['Candidate'];
            $additional_payed_amount = $_POST['Pay_amount'];
            $result = updatePaymentDetails($conn, $id, $additional_payed_amount);
            echo json_encode([
                "status" =>  'success',
                "message" => 'payement update success'
            ]);
        }
        break;


    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        break;
}
