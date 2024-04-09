<?php

// Check if form is submitted
if(isset($_POST['submit'])) {
    // Extracting form data
    $scholarshipName = $_POST["scholarshipName"];
    $state = $_POST["state"];
    $caste = $_POST["caste"];
    $gender = $_POST["gender"];
    $tenthPercent = $_POST["tenthPercent"];
    $twelfthPercent = $_POST["twelfthPercent"];
    $diplomaScore = $_POST["diplomaScore"]; // New attribute
    $nationality = $_POST["nationality"]; 
    $annualIncome = $_POST["annualIncome"];
    $grantAmount = $_POST["grantAmount"];

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
    $sql = "INSERT INTO criteria (scholarshipName, state, caste, gender, tenthPercent, twelfthPercent, diplomaScore, nationality, annualIncome, grantAmount) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_stmt_init($conn);
    
    // Prepare statement
    if(mysqli_stmt_prepare($stmt, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssddisis", $scholarshipName, $state, $caste, $gender, $tenthPercent, $twelfthPercent, $diplomaScore, $nationality, $annualIncome, $grantAmount);
        
        // Execute statement
        if(mysqli_stmt_execute($stmt)) {
            // Redirect to view_company_scholarships.php
            header("Location: view_company_scholarships.php");
            exit();
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
    <title>Scholarship Criteria Form</title>
</head>
<body>
    <h2>Scholarship Criteria Form</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    
        <label for="scholarshipName">Scholarship Name:</label><br>
        <input type="text" id="scholarshipName" name="scholarshipName" required><br>
        
        <label for="state">State:</label><br>
        <input type="text" id="state" name="state" required><br>
        
        <label for="caste">Caste:</label><br>
        <input type="text" id="caste" name="caste" required><br>
        
        <label for="gender">Gender:</label><br>
        <select id="gender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br>
        
        <label for="tenthPercent">Minimum 10th Percentage:</label><br>
        <input type="number" id="tenthPercent" name="tenthPercent" min="0" max="100" required><br>
        
        <label for="twelfthPercent">Minimum 12th Percentage:</label><br>
        <input type="number" id="twelfthPercent" name="twelfthPercent" min="0" max="100" required><br>
        
        <label for="diplomaScore">Diploma Score:</label><br>
        <input type="number" id="diplomaScore" name="diplomaScore"><br>
        
        <label for="nationality">Nationality:</label><br>
        <input type="text" id="nationality" name="nationality" required><br>
        
        <label for="annualIncome">Maximum Annual Income:</label><br>
        <input type="number" id="annualIncome" name="annualIncome" required><br>

        <label for="grantAmount">Grant Amount:</label><br>
        <input type="number" id="grantAmount" name="grantAmount" required><br>
        
        <input type="submit" name="submit" value="Submit">
    
    </form>
</body>
</html>
