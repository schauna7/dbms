<?php
// Assuming you have already established a database connection
// Replace DB_HOST, DB_USER, DB_PASSWORD, and DB_NAME with your actual database credentials
include 'connection.php';

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Scholarship</title>
</head>
<body>
    <h2>Create Scholarship</h2>
    <form action="process_scholarship.php" method="post">
        <label for="scholarship_name">Scholarship Name:</label><br>
        <input type="text" id="scholarship_name" name="scholarship_name" required><br><br>

        <label for="state">State:</label><br>
        <input type="text" id="state" name="state" required><br><br>

        <label for="caste">Caste:</label><br>
        <input type="text" id="caste" name="caste" required><br><br>

        <label for="gender">Gender:</label><br>
        <input type="text" id="gender" name="gender" required><br><br>

        <label for="tenth_score">10th Score:</label><br>
        <input type="number" id="tenth_score" name="tenth_score" required><br><br>

        <label for="twelfth_score">12th Score:</label><br>
        <input type="number" id="twelfth_score" name="twelfth_score" required><br><br>

        <label for="nationality">Nationality:</label><br>
        <input type="text" id="nationality" name="nationality" required><br><br>

        <label for="annual_income">Annual Income:</label><br>
        <input type="number" id="annual_income" name="annual_income" required><br><br>

        <label for="grant_amount">Grant Amount:</label><br>
        <input type="number" id="grant_amount" name="grant_amount" required><br><br>

        <!-- Remove the company_id input field -->

        <label for="scholarship_description">Scholarship Description:</label><br>
        <input type="text" id="scholarship_description" name="scholarship_description" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
