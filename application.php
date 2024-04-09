<?php

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Extracting form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $dob = $_POST["dob"];
    $state = $_POST["state"];
    $caste = $_POST["caste"];
    $tenth_score = $_POST["tenth_score"];
    $twelfth_score = $_POST["twelfth_score"];
    $diploma_score = $_POST["diploma_score"];
    $annual_income = $_POST["annual_income"];
    $nationality = $_POST["nationality"]; // New attribute

    // Database connection parameters
    $host = "localhost";
    $dbname = "database1";
    $username = "schauna";
    $password = "admin";
    
    // Connect to database
    $conn = mysqli_connect($host, $username, $password, $dbname);
    
    // Check connection
    if(mysqli_connect_errno()) {
        die("Connection error: " . mysqli_connect_error());
    }

    // Prepare SQL statement
    $sql = "INSERT INTO applicant (name, email, phone_number, dob, state, caste, tenth_score, twelfth_score, diploma_score, annual_income, nationality) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_stmt_init($conn);
    
    // Prepare statement
    if(mysqli_stmt_prepare($stmt, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssssiiiss", $name, $email, $phone_number, $dob, $state, $caste, $tenth_score, $twelfth_score, $diploma_score, $annual_income, $nationality);
        
        // Execute statement
        if(mysqli_stmt_execute($stmt)) {
            echo "Data inserted successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Form</title>
</head>
<body>
    <h2>Applicant Form</h2>
    <form action="application.php" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="phone_number">Phone Number:</label><br>
        <input type="text" id="phone_number" name="phone_number" required><br>
        
        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob" required><br>
        
        <label for="state">State:</label><br>
        <input type="text" id="state" name="state" required><br>
        
        <label for="caste">Caste:</label><br>
        <input type="text" id="caste" name="caste" required><br>
        
        <label for="tenth_score">10th Score:</label><br>
        <input type="number" id="tenth_score" name="tenth_score" required><br>
        
        <label for="twelfth_score">12th Score:</label><br>
        <input type="number" id="twelfth_score" name="twelfth_score"><br>
        
        <label for="diploma_score">Diploma Score:</label><br>
        <input type="number" id="diploma_score" name="diploma_score"><br>
        
        <label for="annual_income">Annual Income:</label><br>
        <input type="number" id="annual_income" name="annual_income" required><br>
        
        <label for="nationality">Nationality:</label><br> <!-- New attribute -->
        <input type="text" id="nationality" name="nationality" required><br><br> <!-- New attribute -->
        
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>