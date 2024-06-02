<?php

function getAssignedCandidates($conn)
{
    // Initialize an empty array to hold the results
    $result = array();

    // Prepare the SQL statement to join tables and fetch the required data
    $sql = "
        SELECT 
            c.first_name, 
            c.last_name, 
            c.employee_id,
            aj.id

        FROM 
            assign_to_job aj
        JOIN 
            candidate c ON aj.candidate_id = c.id
        WHERE 
            aj.assign_state >= 4
        AND 
        aj.isActive=1
    ";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Execute the statement
        $stmt->execute();

        // Declare variables to hold the results
        $first_name = null;
        $last_name = null;
        $employee_id = null;
        $id = null;

        // Bind the result variables
        $stmt->bind_result($first_name, $last_name, $employee_id, $id);

        // Fetch all results into an array
        while ($stmt->fetch()) {
            $result[] = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'employee_id' => $employee_id,
                'id' => $id
            );
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle statement preparation error
        $result['error'] = "Failed to prepare the SQL statement.";
    }

    
    return $result;
}
function updatePayment($conn, $id, $payment)
{
    $sql = "UPDATE assign_to_job SET payment = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("di", $payment, $id);
        if ($stmt->execute()) {

            if ($stmt->affected_rows > 0) {
                // Close the statement
                $stmt->close();
                return 1;
            }
        }
        $stmt->close();
    }
    return 0;
}



function getPaymentDetails($conn, $id) {
    // Initialize an empty result array
    $result = array();

    // Prepare the SQL statement
    $sql = "SELECT payment, payed_amount, due_amount FROM assign_to_job WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind the ID parameter
        $stmt->bind_param("i", $id);
        
        // Execute the statement
        $stmt->execute();
        
        // Declare variables to hold the results
        $payment = null;
        $payed_amount = null;
        $due_amount = null;
        
        // Bind the result variables
        $stmt->bind_result($payment, $payed_amount, $due_amount);
        
        // Fetch the result
        if ($stmt->fetch()) {
            $result = array(
                'payment' => $payment,
                'payed_amount' => $payed_amount,
                'due_amount' => $due_amount
            );
        } else {
            $result['error'] = "No data found for the given ID.";
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Handle statement preparation error
        $result['error'] = "Failed to prepare the SQL statement.";
    }

    // Return the result array
    return $result;
}

function updatePaymentDetails($conn, $id, $additional_payed_amount) {
    // Initialize variables to hold the existing payment details
   
    $current_payed_amount = 0;

    // Step 1: Retrieve the current payed_amount
    $select_sql = "SELECT payed_Amount FROM assign_to_job WHERE id = ?";
    $select_stmt = $conn->prepare($select_sql);
    
    if ($select_stmt) {
        $select_stmt->bind_param("i", $id);
        $select_stmt->execute();
        $select_stmt->bind_result( $current_payed_amount);
        $select_stmt->fetch();
        $select_stmt->close();
    } else {
        return 0; // Failed to prepare the select statement
    }

    // Step 2: Calculate the new total payed_amount
    $new_payed_amount = $current_payed_amount + $additional_payed_amount;

    // Step 3: Update the record with the new payed_amount
    $update_sql = "UPDATE assign_to_job SET payed_Amount = ?, last_pay_time = NOW() WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);

    if ($update_stmt) {
        $update_stmt->bind_param("di", $new_payed_amount, $id);
        $result = $update_stmt->execute();
        $update_stmt->close();
        
        if ($result) {
            return 1; // Update was successful
        }
    }
    
    return 0; // Update failed
}