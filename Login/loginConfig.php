<?php
require_once '../db/dbconfig.php';

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted data
    $username = $_POST['username'];
    $password = $_POST['password'];
    // function hashPassword($password)
    // {
    //     return password_hash($password, PASSWORD_BCRYPT);
    // }
    // $hashedPassword = hashPassword($password);

    // $stmt = $conn->prepare("INSERT INTO user (userName, password) VALUES (?, ?)");
    // $stmt->bind_param('ss', $username, $hashedPassword);
    // $stmt->execute();
    // $stmt->close();

    // // echo json_encode([ "username"=>  $username,"message"=> $password]);
    // // Validate input
    if (!empty($username) && !empty($password)) {
        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT password FROM user WHERE userName = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($storedHashedPassword);
            $stmt->fetch();

            if (password_verify($password, $storedHashedPassword)) {
                echo json_encode(["status" => "success", "message" => "Log in successful"]);
            }else{
                echo json_encode(["status" => "error", "message" => "Invalid Credenatials"]);

            }
        } else {
            echo json_encode(["status" => "fail", "message" => "error"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "fail", "message" => "erro successful"]);
    }
}




// Close the connection
$conn->close();
