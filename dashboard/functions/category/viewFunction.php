<?php
function fetchCategories($conn)
{
    $sql = "SELECT id, categoryName FROM category WHERE isActive=1";
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
    }

    // Close the connection
    $conn->close();

    return $data;
}



function deactivateCategory($conn, $id)
{
    // Prepare the SQL statement with a placeholder
    $stmt = $conn->prepare("UPDATE category SET isActive = 0 WHERE id = ?");

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


function getCategoryNameById($conn, $id) {
    $sql = "SELECT categoryName FROM category WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id); // Bind the $id parameter as an integer

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['categoryName'];
        } else {
            $stmt->close();
            return null; // No category found with the given id
        }
    } else {
        echo "Error: " . $stmt->error;
        $stmt->close();
        return null;
    }
}



function updateCategory($conn, $id, $categoryName) {
    // Prepare the SQL statement with placeholders
    $sql = "UPDATE category SET categoryName = ? WHERE id = ? AND isActive = 1";
    
    // Initialize the prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the placeholders
        $stmt->bind_param("si", $categoryName, $id);

        // Execute the statement
        if ($stmt->execute()) {
            // Check if any rows were updated
            if ($stmt->affected_rows > 0) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        return 0;
    }
}