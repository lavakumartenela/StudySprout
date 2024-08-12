<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$input_username = $_POST['username'] ?? null;
$input_password = $_POST['password'] ?? null;

if (!$input_username || !$input_password) {
    echo "<script>alert('All fields are required.'); window.location.href='login.html';</script>";
    exit();
}

$sql = "SELECT username, password, branch FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $input_username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($db_username, $db_password, $db_branch);
$stmt->fetch();

if ($stmt->num_rows > 0) {
    if (password_verify($input_password, $db_password)) {
        $_SESSION['username'] = $db_username;
        $_SESSION['branch'] = $db_branch;

        switch ($db_branch) {
            case 'AIML':
                header("Location: aiml_page.html");
                break;
            case 'CSE':
                header("Location: cse_page.html");
                break;
            case 'IT':
                header("Location: it_page.html");
                break;
            default:
                echo "<script>alert('Unknown branch.'); window.location.href='login.html';</script>";
        }
        exit();
    } else {
        echo "<script>alert('Invalid username or password.'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('Invalid username or password.'); window.location.href='login.html';</script>";
}

$stmt->close();
$conn->close();
?>
