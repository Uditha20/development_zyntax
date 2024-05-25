<?php
function fetchActiveCategories($conn)
{
    $stmt = $conn->prepare("SELECT * FROM category WHERE isActive = ?");
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


function insertJobTitle($jobTitleName, $categoryId,$conn) {
  
    $stmt = $conn->prepare("INSERT INTO job_title (job_title_name, category_id) VALUES (?, ?)");
    if ($stmt === false) {
        $conn->close();
        return 0;
    }

    $stmt->bind_param("si", $jobTitleName, $categoryId);

    $result = $stmt->execute() ? 1 : 0;

    $stmt->close();
    $conn->close();

    return $result;
}

function getJobTitles($conn) {
    $stmt = $conn->prepare("
        SELECT 
            job_title.id AS job_title_id,
            job_title.job_title_name,
            category.categoryName
        FROM 
            job_title
        INNER JOIN 
            category ON job_title.category_id = category.id
        WHERE
            job_title.isActive = ?
    ");

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $isActive = 1;
    $stmt->bind_param("i", $isActive);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $jobTitles = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $jobTitles[] = $row;
            }
        }

        $stmt->close();
        return $jobTitles;
    } else {
        echo "Error: " . $stmt->error;
        $stmt->close();
        return [];
    }
}