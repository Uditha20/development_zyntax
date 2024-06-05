<?php
function insertCompany($companyName, $country, $phone, $email, $approval_Id, $address, $conn) {
   
    $stmt = $conn->prepare("INSERT INTO company (company_name, country, phone,email,approval_Id,address) VALUES (?, ?,?,?, ?, ?)");
    $stmt->bind_param("ssssss", $companyName, $country, $phone, $email, $approval_Id, $address);

    // Execute the statement
    if ($stmt->execute()) {
        // Return 1 if the insertion is successful
        $stmt->close();
        $conn->close();
        return 1;
    } else {
        // Handle errors
        echo "Error: " . $stmt->error;
        $stmt->close();
        $conn->close();
        return 0;
    }
}

?>