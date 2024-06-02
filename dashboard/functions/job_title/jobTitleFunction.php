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

function deactivateJobtitle($conn, $id) {
    // Prepare the SQL statement with a placeholder
    $stmt = $conn->prepare("UPDATE job_title SET isActive = 0 WHERE id = ?");
    
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

function fetchJobTitleDetailsById($conn, $jobTitleId) {
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT 
                                id, 
                                job_title_name, 
                                category_id, 
                                isActive 
                            FROM 
                                job_title 
                            WHERE 
                                id = ?");

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $jobTitleId);
    if ($stmt->execute()) {
      
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
          
            $jobTitleDetails = $result->fetch_assoc();
        } else {
            $jobTitleDetails = null;
        }
 
        $result->free();
    } else {
        echo "Error: " . $stmt->error;
        $jobTitleDetails = null; 
    }

    
    $stmt->close();

    // Return the job title details or null if not found
    return $jobTitleDetails;
}

