<?php
function deactivateAssign($conn, $id) {
    // Prepare the SQL statement with a placeholder
    $stmt = $conn->prepare("UPDATE assign_to_job SET isActive = 0 WHERE id = ?");
    
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
