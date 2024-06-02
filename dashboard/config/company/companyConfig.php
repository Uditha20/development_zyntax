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
                $approval_Id = htmlspecialchars($_POST['Approval']);
                $address = htmlspecialchars($_POST['address']);
                // $companyName = strtoupper($companyName);
                $result = insertCompany($companyName, $country, $phone, $email, $approval_Id, $address, $conn);

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
        case 'getCompanyDetails':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $result = fetchCompanydetailsForEdit($conn, $id);
                echo json_encode([
                    "status" => "success",
                    "data" => $result
                ]);
                break;
            } else {
                echo json_encode(["status" => "error", "message" => "id not selected"]);
            }
            break;
        case 'updateCompany':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Retrieve and sanitize input data
                $id = intval($_POST['id']);
                $company_name = ucwords(strtolower(htmlspecialchars($_POST['companyname'])));
                $country = ucwords(strtolower(htmlspecialchars($_POST['country'])));
                $email = htmlspecialchars($_POST['email']);
                $phone = htmlspecialchars($_POST['phone']);
                $approval_Id = htmlspecialchars($_POST['Approval']);
                $address = ucwords(strtolower(htmlspecialchars($_POST['address'])));
                $result = updateCompanyDetails($conn, $id, $company_name, $country, $email, $phone, $approval_Id, $address);
                echo json_encode(['status' => 'success', 'message' => 'update successfull']);
                break;
            }
        case 'delete':
            if(isset($_POST['id'])){
                $id=$_POST['id'];
                $result = deactivateCompany($conn, $id);
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
} else {
    // Output an error message if the request method is not POST
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
