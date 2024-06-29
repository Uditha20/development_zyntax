<?php
function insertCompany($email, $company_name, $country, $phone, $conn)
{

    $stmt = $conn->prepare("INSERT INTO company (email,company_name, country, phone) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $email, $company_name, $country, $phone);

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

function fetchActiveCategories1($conn)
{
    $stmt = $conn->prepare("SELECT * FROM zyntax.company WHERE isActive = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $isActive = 1;
    $stmt->bind_param("i", $isActive);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $categories = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        $stmt->close();
        $conn->close();
        return $categories;
    } else {

        echo "Error: " . $stmt->error;
        $stmt->close();
        $conn->close();
        return [];
    }
}
