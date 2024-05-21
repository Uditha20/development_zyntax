<?php
require_once '../../../db/dbconfig.php';
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $passportNo = $_POST['PassportNo'];
    $passportExpire = $_POST['PassportExpire'];
    $nameInPassport = $_POST['NamePassport'];
    $mobile = $_POST['Mobile'];
    $email = $_POST['Email'];
    $address = $_POST['address'];
    $city = $_POST['city'];

    // Handle file uploads
    $cv = $_FILES['cv'];
    $passport = $_FILES['passport'];

    // Define directories to save uploaded files
    $cvDir = 'uploads/cv/';
    $passportDir = 'uploads/passport/';

    // Create the directories if they don't exist
    if (!is_dir($cvDir)) {
        mkdir($cvDir, 0755, true);
    }
    if (!is_dir($passportDir)) {
        mkdir($passportDir, 0755, true);
    }

    // Generate unique filenames using current date and time
    $timestamp = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
    $cvPath = $cvDir . $timestamp . '_' . basename($cv['name']);
    $passportPath = $passportDir . $timestamp . '_' . basename($passport['name']);

    // Save CV file
    if (move_uploaded_file($cv['tmp_name'], $cvPath)) {
        $response['cv'] = 'CV uploaded successfully.';
    } else {
        $response['cv'] = 'Failed to upload CV.';
    }

    // Save Passport file
    if (move_uploaded_file($passport['tmp_name'], $passportPath)) {
        $response['passport'] = 'Passport uploaded successfully.';
    } else {
        $response['passport'] = 'Failed to upload Passport.';
    }


    $stmt = $conn->prepare("INSERT INTO candidate (first_name, last_name, dob, gender, passport_no, pass_expire_date, name_in_pass_full, mobile, email, address, city, cv, passport) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $firstname, $lastname, $dob, $gender, $passportNo, $passportExpire, $nameInPassport, $mobile, $email, $address, $city, $cvPath, $passportPath);

    if ($stmt->execute()) {
        $response['db'] = 'Data saved successfully.';
    } else {
        $response['db'] = 'Failed to save data.';
    }

    $stmt->close();
    $conn->close();

    // Set the response code to 200 (OK)
    http_response_code(200);
} else {
    // Set the response code to 405 (Method Not Allowed) if the request method is not POST
    http_response_code(405);
    $response['error'] = 'Invalid request method';
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>