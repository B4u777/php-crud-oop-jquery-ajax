<?php

header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../classes/User.php";


$database = new Database();

$user = new User($database->conn);


$action = $_POST['action'] ?? $_GET['action'] ?? "";
$id=$_POST['user_id'] ??"";


if($action=="addUser"){

    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $gender   = trim($_POST['inlineRadioOptions'] ?? '');
    $banks    = $_POST['bank'] ?? [];

    // Validate
    if ($name === '' || mb_strlen($name) > 100) {
        exit(json_encode(['status' => 'error', 'message' => 'Invalid name.']));
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit(json_encode(['status' => 'error', 'message' => 'Invalid email.']));
    }

    if (strlen($password) < 6 || strlen($password) > 200) {
        exit(json_encode(['status' => 'error', 'message' => 'Invalid password.']));
    }

    if (!in_array($gender, ['Male', 'Female', 'Other'], true)) {
        exit(json_encode(['status' => 'error', 'message' => 'Invalid gender.']));
    }

    if (!is_array($banks) || count($banks) > 20) {
        exit(json_encode(['status' => 'error', 'message' => 'Invalid banks.']));
    }

    $banks = array_map('trim', $banks);
    $banks=implode(',', $banks);

    $image = null;
    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] !== UPLOAD_ERR_NO_FILE) {
       $image = $_FILES['imageUpload'];
    }
        $users = $user->addUser(
            $name,
            $email,
            $password,
            $image,
            $gender,
            $banks);

            echo json_encode([
                'status' => 'success',
                'message' => 'Thank you, ' . htmlspecialchars($name) . '! for sign up.'
            ]);
            exit; 


    }


if ($action == "getUsers") {

    $users = $user->getAllUsers();


    

    

    echo json_encode([
        "status" => true,
        "data" => $users
    ]);

    exit;
    
}


    
// =====================================
// DELETE
// =====================================
if ($action == "deleteUser") {

    $id=$_POST['user_id'] ??"";

    $users = $user->deleteUser($id);


    echo json_encode([
        "status" => true,
        "data" => $users
    ]);

    exit;
}
if($action=="updateUser"){
    $id     = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$name   = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
$email  = isset($_POST['user_email']) ? trim($_POST['user_email']) : '';
$gender = isset($_POST['user_gender']) ? trim($_POST['user_gender']) : '';
$image = null;

if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] !== UPLOAD_ERR_NO_FILE) {
    $image = $_FILES['imageUpload'];
}
//var_dump($image);
//exit;

// Get selected banks
$banks = '';

if (isset($_POST['user_banks']) && is_array($_POST['user_banks'])) {

    $banks = [];

    foreach ($_POST['user_banks'] as $bank) {
        $banks[] = trim($bank);
    }

    $banks = implode(', ', $banks);
}


    $result = $user->updateUser(
        $id,
        $name,
        $email,
        $gender,
        $image,
        $banks
    );

    if ($result) {
        echo json_encode([
            "status" => true,
            "message" => "User updated successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Update failed"
        ]);
    }


    exit;
}


echo json_encode([
    "status" => false,
    "message" => "Invalid action"
]);