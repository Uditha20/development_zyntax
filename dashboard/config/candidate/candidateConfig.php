<?php
require_once '../../../db/dbconfig.php';
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastname = ucwords(strtolower(htmlspecialchars($_POST['lastname'])));
    $firstname = ucwords(strtolower(htmlspecialchars($_POST['firstname'])));
    $dob = htmlspecialchars($_POST['dob']);
    $gender = htmlspecialchars($_POST['gender']);
    $passportNo = htmlspecialchars($_POST['PassportNo']);
    $passportExpire = htmlspecialchars($_POST['PassportExpire']);
    $nameInPassport = ucwords(strtolower(htmlspecialchars($_POST['NamePassport'])));
    $mobile = htmlspecialchars($_POST['Mobile']);
    $landPhone = htmlspecialchars($_POST['land']);
    $email = htmlspecialchars($_POST['Email']);
    $address = ucwords(strtolower(htmlspecialchars($_POST['address'])));
    $city = ucwords(strtolower(htmlspecialchars($_POST['city'])));
    $candidateid = htmlspecialchars($_POST['candidateid']);


    $cv = $_FILES['cv'];
    $passport = $_FILES['passport'];
    $profile = $_FILES['profile'];

    // Define directories to save uploaded files
    $cvDir = 'uploads/cv/';
    $passportDir = 'uploads/passport/';
    $profileDir = 'uploads/profile/';

    // Create the directories if they don't exist
    if (!is_dir($cvDir)) {
        mkdir($cvDir, 0755, true);
    }
    if (!is_dir($passportDir)) {
        mkdir($passportDir, 0755, true);
    }
    if (!is_dir($profileDir)) {
        mkdir($profileDir, 0755, true);
    }

    // Generate unique filenames using current date and time
    $timestamp = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
    $cvPath = $cvDir . $timestamp . '_' . basename($cv['name']);
    $passportPath = $passportDir . $timestamp . '_' . basename($passport['name']);
    $profilePath = $profileDir . $timestamp . '_' . basename($profile['name']);

    $response = [];

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

    // Save profile file
    if (move_uploaded_file($profile['tmp_name'], $profilePath)) {
        $response['profile'] = 'Profile uploaded successfully.';
    } else {
        $response['profile'] = 'Failed to upload profile.';
    }

    $stmt = $conn->prepare("INSERT INTO candidate (first_name, last_name, dob, gender, passport_no, pass_expire_date, name_in_pass_full, mobile, email, address, city,employee_id, cv, passport,profile,landphone) VALUES (?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");
    $stmt->bind_param("ssssssssssssssss", $firstname, $lastname, $dob, $gender, $passportNo, $passportExpire, $nameInPassport, $mobile, $email, $address, $city, $candidateid, $cvPath, $passportPath, $profilePath, $landPhone);

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
