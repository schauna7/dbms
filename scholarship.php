<?php
session_start();

// Check if user is not logged in, then redirect to login page
if(!isset($_SESSION['username'])){
    header("Location: companylogin.php");
    exit();
}

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

// Retrieve the ID of the logged-in company
$companyID = $_SESSION['companyID'];

// Retrieve the name of the logged-in company from the database
$sql_company = "SELECT company_name FROM company WHERE id = $companyID";
$result_company = mysqli_query($conn, $sql_company);

if(mysqli_num_rows($result_company) > 0) {
    $row_company = mysqli_fetch_assoc($result_company);
    $companyName = $row_company['company_name'];

    // Retrieve scholarships associated with the logged-in company
    $sql_scholarships = "SELECT scholarshipName, grantAmount 
                         FROM criteria 
                         WHERE companyID = $companyID";
    $result_scholarships = mysqli_query($conn, $sql_scholarships);

} else {
    // Handle case where company ID is not found
    echo "Company ID not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Scholarships</title>
    <style>
        .scholarship-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>View Scholarships for <?php echo $companyName; ?></h2>
    <?php
    // Display scholarships
    while($row_scholarship = mysqli_fetch_assoc($result_scholarships)) {
        echo "<div class='scholarship-box'>";
        echo "<strong>Scholarship Name:</strong> " . $row_scholarship['scholarshipName'] . "<br>";
        echo "<strong>Grant Amount:</strong> " . $row_scholarship['grantAmount'];
        echo "</div>";
    }
    ?>
</body>
</html>
