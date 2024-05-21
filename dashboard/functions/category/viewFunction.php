<?php
function fetchCategories($conn) {
    $sql = "SELECT id, categoryName, isActive FROM category";
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
?>