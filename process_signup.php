<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "user_registration"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debug: Check if form data is being received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}

// Get form data
$fullname = $_POST["fullname"] ?? null;
$email = $_POST["email"] ?? null;
$contact = $_POST["contact"] ?? null;
$username = $_POST["username"] ?? null;
$password = $_POST["password"] ?? null;
$confirm_password = $_POST["confirm_password"] ?? null;
$branch = $_POST["branch"] ?? null;

// Check if all form fields are filled
if (!$fullname || !$email || !$contact || !$username || !$password || !$confirm_password || !$branch) {
    die("All fields are required.");
}

// Check if passwords match
if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// SQL query to insert data into users table
$sql = "INSERT INTO users (fullname, email, contact, username, password, branch) VALUES ('$fullname', '$email', '$contact', '$username', '$hashed_password', '$branch')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Registration successful! Redirecting to login page...');
    window.location.href='login.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
