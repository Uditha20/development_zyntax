<?php

function insertCompany($companyName, $country, $phone, $email, $approval_Id, $address, $conn)
{

    $stmt = $conn->prepare("INSERT INTO company (company_name, country, phone,email,approval_Id,address) VALUES (?, ?,?,?, ?, ?)");
    $stmt->bind_param("ssssss", $companyName, $country, $phone, $email, $approval_Id, $address);

    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result ? 1 : 0;
}

function fetchCompany($conn)
{
    $sql = "SELECT id,company_name, country, email, phone,approval_Id,address FROM company WHERE isActive = 1";
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

function fetchCompanydetailsForEdit($conn, $id)
{
    $sql = "SELECT id, company_name, country, email, phone, approval_Id, address 
            FROM company 
            WHERE isActive = 1 AND id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $stmt->close();

    return $data;
}


function updateCompanyDetails($conn, $id, $company_name, $country, $email, $phone, $approval_Id, $address) {
   
   
    // Prepare SQL UPDATE statement
    $sql = "UPDATE company 
            SET company_name = ?, country = ?, email = ?, phone = ?, approval_Id = ?, address = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        return json_encode(['status' => 'error', 'message' => 'Error preparing statement: ' . $conn->error]);
    }

    // Bind parameters
    $stmt->bind_param("ssssssi", $company_name, $country, $email, $phone, $approval_Id, $address, $id);

    // Execute statement and check for errors
    if ($stmt->execute()) {
        $stmt->close();
        return 1;
    } else {
        $stmt->close();
        return 0;
    }
}

function deactivateCompany($conn, $id) {
    // Prepare the SQL statement with a placeholder
    $stmt = $conn->prepare("UPDATE company SET isActive = 0 WHERE id = ?");
    
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

