<?php
require_once '../../../db/dbconfig.php';

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

    // Save CV file if uploaded
    if (!empty($cv['tmp_name']) && move_uploaded_file($cv['tmp_name'], $cvPath)) {
        $cvUploaded = true;
        $response['cv'] = 'CV uploaded successfully.';
    } else {
        $cvUploaded = false;
        $cvPath = null;
        $response['cv'] = 'Failed to upload CV.';
    }

    // Save Passport file if uploaded
    if (!empty($passport['tmp_name']) && move_uploaded_file($passport['tmp_name'], $passportPath)) {
        $passportUploaded = true;
        $response['passport'] = 'Passport uploaded successfully.';
    } else {
        $passportUploaded = false;
        $passportPath = null;
        $response['passport'] = 'Failed to upload Passport.';
    }

    // Save profile file if uploaded
    if (!empty($profile['tmp_name']) && move_uploaded_file($profile['tmp_name'], $profilePath)) {
        $profileUploaded = true;
        $response['profile'] = 'Profile uploaded successfully.';
    } else {
        $profileUploaded = false;
        $profilePath = null;
        $response['profile'] = 'Failed to upload profile.';
    }

    // Build the update query dynamically based on which files were uploaded
    $updateQuery = "UPDATE candidate SET 
                        first_name = ?, 
                        last_name = ?, 
                        dob = ?, 
                        gender = ?, 
                        passport_no = ?, 
                        pass_expire_date = ?, 
                        name_in_pass_full = ?, 
                        mobile = ?, 
                        email = ?, 
                        address = ?, 
                        city = ?, 
                        landphone = ?";

    if ($cvUploaded) {
        $updateQuery .= ", cv = ?";
    }
    if ($passportUploaded) {
        $updateQuery .= ", passport = ?";
    }
    if ($profileUploaded) {
        $updateQuery .= ", profile = ?";
    }

    $updateQuery .= " WHERE id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($updateQuery);

    // Bind parameters dynamically based on which files were uploaded
    if ($cvUploaded && $passportUploaded && $profileUploaded) {
        $stmt->bind_param("sssssssssssssssi", $firstname, $lastname, $dob, $gender, $passportNo, $passportExpire, $nameInPassport, $mobile, $email, $address, $city, $landPhone, $cvPath, $passportPath, $profilePath, $candidateid);
    } elseif ($cvUploaded && $passportUploaded) {
        $stmt->bind_param("ssssssssssssssi", $firstname, $lastname, $dob, $gender, $passportNo, $passportExpire, $nameInPassport, $mobile, $email, $address, $city, $landPhone, $cvPath, $passportPath, $candidateid);
    } elseif ($cvUploaded && $profileUploaded) {
        $stmt->bind_param("ssssssssssssssi", $firstname, $lastname, $dob, $gender, $passportNo, $passportExpire, $nameInPassport, $mobile, $email, $address, $city, $landPhone, $cvPath, $profilePath, $candidateid);
    } elseif ($passportUploaded && $profileUploaded) {
        $stmt->bind_param("ssssssssssssssi", $firstname, $lastname, $dob, $gender, $passportNo, $passportExpire, $nameInPassport, $mobile, $email, $address, $city, $landPhone, $passportPath, $profilePath, $candidateid);
    } elseif ($cvUploaded) {
        $stmt->bind_param("sssssssssssssi", $firstname, $lastname, $dob, $gender, $passportNo, $passportExpire, $nameInPassport, $mobile, $email, $address, $city, $landPhone, $cvPath, $candidateid);
    } elseif ($passportUploaded) {
        $stmt->bind_param("sssssssssssssi", $firstname, $lastname, $dob, $gender, $passportNo, $passportExpire, $nameInPassport, $mobile, $email, $address, $city, $landPhone, $passportPath, $candidateid);
    } elseif ($profileUploaded) {
        $stmt->bind_param("sssssssssssssi", $firstname, $lastname, $dob, $gender, $passportNo, $passportExpire, $nameInPassport, $mobile, $email, $address, $city, $landPhone, $profilePath, $candidateid);
    } else {
        $stmt->bind_param("ssssssssssssi", $firstname, $lastname, $dob, $gender, $passportNo, $passportExpire, $nameInPassport, $mobile, $email, $address, $city, $landPhone, $candidateid);
    }

    if ($stmt->execute()) {
        $response['db'] = 'Data updated successfully.';
    } else {
        $response['db'] = 'Failed to update data.';
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

echo json_encode($response);
