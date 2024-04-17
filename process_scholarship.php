<?php
// Assuming you have already established a database connection
// Replace DB_HOST, DB_USER, DB_PASSWORD, and DB_NAME with your actual database credentials
$conn = new mysqli("localhost", "schauna", "admin", "database1");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session to get the logged-in user's email
session_start();
if(!isset($_SESSION['user_email'])) {
    // Redirect or handle the case where the user is not logged in
    header("Location: login.php");
    exit();
}

// Escape user inputs for security
$scholarship_name = $conn->real_escape_string($_POST['scholarship_name']);
$state = $conn->real_escape_string($_POST['state']);
$caste = $conn->real_escape_string($_POST['caste']);
$gender = $conn->real_escape_string($_POST['gender']);
$tenth_score = $_POST['tenth_score'];
$twelfth_score = $_POST['twelfth_score'];
$nationality = $conn->real_escape_string($_POST['nationality']);
$annual_income = $_POST['annual_income'];
$grant_amount = $_POST['grant_amount'];
$company_email = $conn->real_escape_string($_SESSION['user_email']); // Get company email from session
$scholarship_description = $conn->real_escape_string($_POST['scholarship_description']);

// Prepare SQL statement
$sql = "INSERT INTO scholarship (scholarship_name, state, caste, gender, tenth_score, twelfth_score, nationality, annual_income, grant_amount, company_id, scholarship_description) 
        VALUES ('$scholarship_name', '$state', '$caste', '$gender', $tenth_score, $twelfth_score, '$nationality', $annual_income, $grant_amount, '$company_email', '$scholarship_description')";

if ($conn->query($sql) === TRUE) {
    echo "Scholarship created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>