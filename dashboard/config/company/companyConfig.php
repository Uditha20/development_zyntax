<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/company/companyFunction.php';

header('Content-Type: application/json');
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || 'GET') {

    $action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];


    switch ($action) {
        case 'company':

            if (isset($_POST['companyname']) && isset($_POST['country']) && isset($_POST['phone']) && isset($_POST['email'])) {

                $companyName = strtoupper(htmlspecialchars($_POST['companyname']));
                $country = strtoupper(htmlspecialchars($_POST['country']));
                $phone = htmlspecialchars($_POST['phone']);
                $email = htmlspecialchars($_POST['email']);
                // $companyName = strtoupper($companyName);
                $result = insertCompany($companyName, $country, $phone, $email, $conn);

                if ($result == 1) {
                    echo json_encode((["status" => "success"]));
                }
            } else {
                echo json_encode((["status" => "err", "message" => "something went Wrong"]));
            }
            break;

        case 'comData':
            $company = fetchCompany($conn);
            echo json_encode([
                "status" => "success",
                "data" => $company
            ]);
            break;

        default:
            // Output an error message for unknown actions
            echo json_encode(["status" => "error", "message" => "Invalid action"]);
            break;
    }
} else {
    // Output an error message if the request method is not POST
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
