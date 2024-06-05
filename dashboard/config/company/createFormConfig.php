<?php
require_once '../../../db/dbconfig.php';
require_once '../../functions/company/createFormFuntion.php';
header('Content-Type: application/json');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    echo "<script> alret($name); </script> ";

    $stmt = $db->prepare('INSERT INTO companies (name, country, phone, email) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $name, $country, $phone, $email);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database insertion failed']);
    }

    $stmt->close();
    $db->close();
    
} else {
    // Send filure response if not a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>