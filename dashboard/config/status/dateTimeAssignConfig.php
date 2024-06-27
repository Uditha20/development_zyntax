<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/status/assignFunction.php';

header('Content-Type: application/json');

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Log the incoming request for debugging
error_log("Received data: " . print_r($data, true));

$response = ['status' => 'error', 'message' => 'Invalid request'];

if (isset($data['action']) && $data['action'] === 'saveData') {
    if (isset($data['rows']) && !empty($data['rows'])) {
        $rows = $data['rows']; // This is already decoded as array

        if (is_array($rows)) {
            $stmt = $conn->prepare("
                UPDATE assign_to_job
                SET interview_date = ?, interview_time = ?, interview = ?, interviewed = ?, `select` = ?, visa_process = ?
                WHERE id = ?
            ");

            foreach ($rows as $row) {
                $id = $row['id'];
                $interview = $row['Interview'];
                $interviewed = $row['Interviewed'];
                $selectState = $row['SelectState'];
                $visaProcess = $row['VisaProcess'];
                $time = $row['Time'] ?: null;
                $date = $row['Date'] ?: null;

                $stmt->bind_param("sssiiii", $date, $time, $interview, $interviewed, $selectState, $visaProcess, $id);

                if (!$stmt->execute()) {
                    die('Execute failed: ' . htmlspecialchars($stmt->error));
                }
            }

            $stmt->close();

            $response = ['status' => 'success', 'message' => 'Data updated successfully'];
        } else {
            $response['message'] = 'Invalid row data format';
        }
    } else {
        $response['message'] = 'No rows data provided';
    }
}

echo json_encode($response);
// } else {
//     if (isset($data['action']) && $data['action'] === 'interviewData') {

//         $assignToJobIds = $data['assign_to_job_ids'];
//         $result = updateinterview($conn, $assignToJobIds);
//         if ($result == 1) {
//             echo json_encode([
//                 'status' => 'success',
//                 'message' => 'Update successfully'
//             ]);
//         }
//     } else {
//         if (isset($data['action']) && $data['action'] === 'selectData') {

//             $assignToJobIds = $data['assign_to_job_ids'];
//             $result = updateselect($conn, $assignToJobIds);
//             if ($result == 1) {
//                 echo json_encode([
//                     'status' => 'success',
//                     'message' => 'Update successfully'
//                 ]);
//             } else {
//                 echo json_encode([
//                     'status' => 'error',
//                     'message' => 'Failed to update'
//                 ]);
//             }
//         } else {
//             if (isset($data['action']) && $data['action'] === 'migrate') {


//                 $id = $data['assign_to_job_id'];
//                 $paymentStatus = checkPaymentStatus($conn, $id);
//                 echo json_encode([
//                     'status' => 'success',
//                     'message' =>  $paymentStatus
//                 ]);


//                 // $result = updateselect($conn, $assignToJobIds);
//                 // if ($result == 1) {
//                 //     echo json_encode([
//                 //         'status' => 'success',
//                 //         'message' => 'Update successfully'
//                 //     ]);
//                 // } else {
//                 //     echo json_encode([
//                 //         'status' => 'error',
//                 //         'message' => 'Failed to update'
//                 //     ]);
//                 // }
//             } else {
//                 if (isset($data['action']) && $data['action'] === 'finalselect') {

//                     $assignToJobIds = $data['assign_to_job_ids'];
//                     $result = updatefinalselect($conn, $assignToJobIds);
//                     if ($result == 1) {
//                         echo json_encode([
//                             'status' => 'success',
//                             'message' => 'Update successfully'
//                         ]);
//                     } else {
//                         echo json_encode([
//                             'status' => 'error',
//                             'message' => 'Failed to update'
//                         ]);
//                     }
//                 } else {
//                     if (isset($data['action']) && $data['action'] === 'migratecandidate') {

//                         $assign_to_job_id = $data['assign_to_job_id'];
//                         $result = updateAssignState($conn, $assign_to_job_id);
//                         // $result = updatefinalselect($conn, $assignToJobIds);
//                         if ($result == 1) {
//                             echo json_encode([
//                                 'status' => 'success',
//                                 'message' => 'Update successfully'
//                             ]);
//                         } else {
//                             echo json_encode([
//                                 'status' => 'error',
//                                 'message' => 'Failed to update'
//                             ]);
//                         }
//                     } else {
//                         if (isset($data['action']) && $data['action'] === 'reject') {

//                             $assign_to_job_id = $data['assign_to_job_id'];
//                             $result = updaterejected($conn, $assign_to_job_id);
//                             // $result = updatefinalselect($conn, $assignToJobIds);
//                             if ($result == 1) {
//                                 echo json_encode([
//                                     'status' => 'success',
//                                     'message' => 'reject successfully'
//                                 ]);
//                             } else {
//                                 echo json_encode([
//                                     'status' => 'error',
//                                     'message' => 'Failed to update'
//                                 ]);
//                             }
//                         } else {
//                             if (isset($data['action']) && $data['action'] === 'failselectData') {

//                                 $assignToJobIds = $data['assign_to_job_ids'];
//                                 $result = updatefail($conn, $assignToJobIds);
//                                 // $result = updatefinalselect($conn, $assignToJobIds);
//                                 if ($result == 1) {
//                                     echo json_encode([
//                                         'status' => 'success',
//                                         'message' => 'update successfully'
//                                     ]);
//                                 } else {
//                                     echo json_encode([
//                                         'status' => 'error',
//                                         'message' => 'Failed to update'
//                                     ]);
//                                 }
//                             }
//                         }
//                     }
//                 }
//             }
//         }
//     }
// }
