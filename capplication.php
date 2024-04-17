<?php
session_start();

// Check if companyID is set in the session
if(!isset($_SESSION['company_id'])){
    // Redirect to login page if companyID is not set
    header("Location: login.php");
    exit(); // Ensure that script stops execution after redirection
}

// Get the logged-in company's ID from the session
$company_id = $_SESSION['company_id'];
// Check if form is submitted

if(isset($_POST['submit'])) {
    // Extracting form data
    $scholarship_name = $_POST["scholarshipName"];
    $state = $_POST["state"];
    $caste = $_POST["caste"];
    $gender = $_POST["gender"];
    $tenth_percent = $_POST["tenthPercent"];
    $twelfth_percent = $_POST["twelfthPercent"];
    $nationality = $_POST["nationality"]; 
    $annual_income = $_POST["annualIncome"];
    $grant_amount = $_POST["grantAmount"];
    $scholarship_description = $_POST["scholarshipDescription"];

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
    $sql = "INSERT INTO scholarship (scholarship_name, state, caste, gender, tenth_percent, twelfth_percent, nationality, annual_income, grantAmount,scholarship_description,company_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_stmt_init($conn);
    
    // Prepare statement
    if(mysqli_stmt_prepare($stmt, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssddisis", $scholarship_name, $state, $caste, $gender, $tenth_percent, $twelfth_percent, $nationality, $annual_income, $grant_amount,$scholarship_description,$company_id);
        
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
        
        
        
        <label for="nationality">Nationality:</label><br>
        <input type="text" id="nationality" name="nationality" required><br>
        
        <label for="annualIncome">Maximum Annual Income:</label><br>
        <input type="number" id="annualIncome" name="annualIncome" required><br>

        <label for="grantAmount">Grant Amount:</label><br>
        <input type="number" id="grantAmount" name="grantAmount" required><br>

        <label for="scholarshipDescription">Scholarship Description:</label><br>
        <textarea id="scholarshipDescription" name="scholarshipDescription" rows="4" cols="50"></textarea><br>

        <input type="submit" name="submit" value="Submit">
    
    </form>
</body>
</html>