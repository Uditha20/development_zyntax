<?php
function insertCategory($categoryName,$conn) {
   
    $stmt = $conn->prepare("INSERT INTO category (categoryName) VALUES (?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s",$categoryName);

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
