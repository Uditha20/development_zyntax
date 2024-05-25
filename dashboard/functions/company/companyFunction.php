<?php

function insertCompany($companyName, $country, $phone, $email,$conn) {
   
    $stmt = $conn->prepare("INSERT INTO company (company_name, country, phone, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $companyName, $country, $phone, $email);

    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result ? 1 : 0;
}

function fetchCompany($conn) {
    $sql = "SELECT id,company_name, country, email, phone FROM company WHERE isActive = 1";
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}
