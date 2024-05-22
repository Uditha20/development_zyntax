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

    // Validate form data (example validation)
    $namePattern = '/^[A-Z\s]+$/';
    $phonePattern = '/^\+?\d{10,12}$/';
    $emailPattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';

    if (preg_match($namePattern, $name) && preg_match($namePattern, $country) && preg_match($phonePattern, $phone) && preg_match($emailPattern, $email)) {
        // If all validations pass, process the data (e.g., insert into database)
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($db->connect_error) {
            die(json_encode(['success' => false, 'message' => 'Database connection failed']));
        }

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
        // Send failure response if validation fails
        echo json_encode(['success' => false, 'message' => 'Invalid form data']);
    }
} else {
    // Send failure response if not a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>