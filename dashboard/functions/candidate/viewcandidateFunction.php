<?php
function fetchCandidateDetails($conn) {
    $sql = "
        SELECT 
            id, 
            first_name, 
            last_name, 
            dob, 
            gender, 
            passport_no, 
            pass_expire_date, 
            mobile, 
            email, 
            address, 
            city, 
            employee_id,
            passport,
            profile,
            cv
        FROM 
            candidate
        WHERE 
            isActive = 1
    ";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $candidates = [];
    while ($row = $result->fetch_assoc()) {
        $candidates[] = $row;
    }

    $stmt->close();
    return $candidates;
}
function getCandidateDetails($id, $conn) {
    // Define variables as null
    $res_id = null;
    $first_name = null;
    $last_name = null;
    $dob = null;
    $gender = null;
    $passport_no = null;
    $pass_expire_date = null;
    $mobile = null;
    $email = null;
    $address = null;
    $city = null;
    $employee_id = null;
    $name_in_pass_full = null;
    $landphone = null;

    // Prepare the SQL statement with placeholders
    $sql = "SELECT id, first_name, last_name, dob, gender, passport_no, pass_expire_date, 
                   mobile, email, address, city, employee_id, name_in_pass_full,landphone 
            FROM candidate 
            WHERE id = ?";

    // Initialize prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the id parameter to the statement
        $stmt->bind_param("i", $id);

        // Execute the statement
        $stmt->execute();

        // Bind result variables
        $stmt->bind_result($res_id, $first_name, $last_name, $dob, $gender, $passport_no, $pass_expire_date, 
                           $mobile, $email, $address, $city, $employee_id, $name_in_pass_full, 
                         $landphone);

        // Fetch the result
        if ($stmt->fetch()) {
            // Store the result in an associative array
            $candidate = array(
                "id" => $res_id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "dob" => $dob,
                "gender" => $gender,
                "passport_no" => $passport_no,
                "pass_expire_date" => $pass_expire_date,
                "mobile" => $mobile,
                "email" => $email,
                "address" => $address,
                "city" => $city,
                "employee_id" => $employee_id,
                "name_in_pass_full" => $name_in_pass_full,
                "landphone" => $landphone
            );
        } else {
            $candidate = null;
        }

        // Close the statement
        $stmt->close();
    } else {
        $candidate = null;
    }

    // Return the result
    return $candidate;
}


function deactivateCandidate($conn, $id) {
    // Prepare the SQL statement with a placeholder
    $stmt = $conn->prepare("UPDATE candidate SET isActive = 0 WHERE id = ?");
    
    // Check if the preparation was successful
    if ($stmt === false) {
        return 0;
    }
    
    // Bind the parameters (i for integer)
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    if ($stmt->execute()) {
        $stmt->close();
        return 1;
    } else {
        $stmt->close();
        return 0;
    }
}
