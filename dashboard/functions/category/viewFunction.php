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
