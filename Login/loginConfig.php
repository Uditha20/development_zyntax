<?php
session_start();
require_once '../db/dbconfig.php';

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted data and sanitize input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!empty($username) && !empty($password)) {
        // Prepare and execute the query securely to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, password FROM user WHERE userName = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($userId, $storedHashedPassword);
            $stmt->fetch();

            if (password_verify($password, $storedHashedPassword)) {
                // Regenerate session ID to prevent session fixation attacks
                session_regenerate_id();
                $_SESSION['loggedin'] = true;
                $_SESSION['userId'] = $userId;
                $_SESSION['username'] = $username;

                echo json_encode(["status" => "success", "message" => "Log in successful"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "User not found"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Please fill in all fields"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}



// Close the connection
$conn->close();
