<?php

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

// Retrieve scholarships from the database
$sql = "SELECT scholarshipName, grantAmount FROM criteria";
$result = mysqli_query($conn, $sql);

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
    <h2>View Scholarships</h2>
    <?php
    // Display scholarships
    while($row = mysqli_fetch_assoc($result)) {
        echo "<div class='scholarship-box'>";
        echo "<strong>Scholarship Name:</strong> " . $row['scholarshipName'] . "<br>";
        echo "<strong>Grant Amount:</strong> " . $row['grantAmount'];
        echo "</div>";
    }
    ?>
</body>
</html>
