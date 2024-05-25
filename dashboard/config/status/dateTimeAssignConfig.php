<?php 
require_once '../../../db/dbconfig.php';
require_once '../../functions/status/assignFunction.php';

header('Content-Type: application/json');


// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);


if (isset($data['action']) && $data['action'] === 'saveData') {
    // Extract the variables from the JSON data
    $assignToJobIds = $data['assign_to_job_ids'];
    $selectedDate = $data['date'];
    $selectedTime = $data['time'];

    // Call the function to update the records
    $result = updateAssignToJob($conn, $assignToJobIds, $selectedDate, $selectedTime);

    // Send response based on the result
    if ($result == 1) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Update successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update'
        ]);
    }
} else {
    if (isset($data['action']) && $data['action'] === 'interviewData') {

        $assignToJobIds = $data['assign_to_job_ids'];
        $result = updateinterview($conn, $assignToJobIds);
        if ($result == 1) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Update successfully'
            ]);
        } 
        
    } else {
        if (isset($data['action']) && $data['action'] === 'selectData') {

            $assignToJobIds = $data['assign_to_job_ids'];
            $result = updateselect($conn, $assignToJobIds);
            if ($result == 1) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Update successfully'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update'
                ]);
            }
        }else{
            if (isset($data['action']) && $data['action'] === 'migrate') {
        

                $id= $data['assign_to_job_id'];
                $paymentStatus = checkPaymentStatus($conn, $id);
                     echo json_encode([
                        'status' => 'success',
                        'message' =>  $paymentStatus
                    ]);
                
        
                // $result = updateselect($conn, $assignToJobIds);
                // if ($result == 1) {
                //     echo json_encode([
                //         'status' => 'success',
                //         'message' => 'Update successfully'
                //     ]);
                // } else {
                //     echo json_encode([
                //         'status' => 'error',
                //         'message' => 'Failed to update'
                //     ]);
                // }
            }else{
                if (isset($data['action']) && $data['action'] === 'finalselect') {

                    $assignToJobIds = $data['assign_to_job_ids'];
                    $result = updatefinalselect($conn, $assignToJobIds);
                    if ($result == 1) {
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Update successfully'
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Failed to update'
                        ]);
                    }
                }  
            }
        }
    } 
}