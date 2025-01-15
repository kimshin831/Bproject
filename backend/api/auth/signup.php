<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "green609b";
$password = "green609!";
$dbname = "green609b";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['name'], $data['username'], $data['password'], $data['birthYear'], $data['birthMonth'], $data['birthDay'])) {
    echo json_encode(["status" => "error", "message" => "Invalid input data"]);
    exit();
}

$name = $data['name'];
$username = $data['username'];
$password = $data['password'];
$birthYear = $data['birthYear'];
$birthMonth = $data['birthMonth'];
$birthDay = $data['birthDay'];

if (empty($name) || empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit();
}

$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Username already exists"]);
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO users (name, username, password, birth_year, birth_month, birth_day) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiii", $name, $username, $hashedPassword, $birthYear, $birthMonth, $birthDay);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User registered successfully"]);
} else {
    error_log("Registration failed: " . $stmt->error);
    echo json_encode(["status" => "error", "message" => "Registration failed"]);
}

$stmt->close();
$conn->close();
