<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("Location: home.php");
        exit(); // Ensure that script stops execution after redirection
    }
?>
<?php
    include("connection.php");
    if(isset($_POST['submit'])){
        // Escape all inputs to prevent SQL injection
        $username = mysqli_real_escape_string($conn, $_POST['user']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpass']);
        // Additional fields
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $caste = mysqli_real_escape_string($conn, $_POST['caste']);
        $tenth_score = mysqli_real_escape_string($conn, $_POST['tenth_score']);
        $twelfth_score = mysqli_real_escape_string($conn, $_POST['twelfth_score']);
        $annual_income = mysqli_real_escape_string($conn, $_POST['annual_income']);
        $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        
        // Check if username or email already exists
        $sql="SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        $count_user = mysqli_num_rows($result);

        $sql="SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $count_email = mysqli_num_rows($result);

        // If username and email are unique
        if($count_user == 0 && $count_email == 0){
            // Check if passwords match
            if($password == $cpassword){
                // Hash the password
                $hash = password_hash($password, PASSWORD_DEFAULT);
                // Insert user data into the database
                $sql = "INSERT INTO users(username, email, password, dob, state, caste, tenth_score, twelfth_score, annual_income, nationality, gender) 
                        VALUES('$username', '$email', '$hash', '$dob', '$state', '$caste', '$tenth_score', '$twelfth_score', '$annual_income', '$nationality', '$gender')";
                $result = mysqli_query($conn, $sql);
                if($result){
                    // Redirect to login page upon successful registration
                    header("Location: login.php");
                    exit(); // Ensure that script stops execution after redirection
                } else {
                    // Error handling if insertion fails
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                // Passwords don't match
                echo '<script>
                    alert("Passwords do not match");
                    window.location.href = "signup.php";
                </script>';
            }
        } else {
            // Username or email already exists
            echo '<script>
                window.location.href="signup.php";
                alert("Username or email already exists!!");
            </script>';
        }
        
    }
?>
<?php
    include("navbar.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
  <body>
    <div id="form">
        <h1 id="heading">Sign Up Form</h1><br>
        <form name="form" action="signup.php" method="POST">
            <label>Enter Username: </label>
            <input type="text" id="user" name="user" required><br><br>
            <label>Enter Email: </label>
            <input type="email" id="email" name="email" required><br><br>
            <label>Enter Date of Birth: </label>
            <input type="date" id="dob" name="dob" required><br><br>
            <label>Select State: </label>
            <select id="state" name="state" required>
                <option value="State 1">Maharashtra</option>
                <option value="State 2">Goa</option>
                <!-- Add more options as needed -->
            </select><br><br>
            <label>Enter Caste: </label>
            <input type="text" id="caste" name="caste" required><br><br>
            <label>Enter Tenth Score: </label>
            <input type="text" id="tenth_score" name="tenth_score" required><br><br>
            <label>Enter Twelfth Score: </label>
            <input type="text" id="twelfth_score" name="twelfth_score" required><br><br>
            <label>Enter Annual Income: </label>
            <input type="text" id="annual_income" name="annual_income" required><br><br>
            <label>Enter Nationality: </label>
            <input type="text" id="nationality" name="nationality" required><br><br>
            <label>Select Gender: </label><br>
            <input type="radio" id="male" name="gender" value="Male" required>
            <label for="male">Male</label><br>
            <input type="radio" id="female" name="gender" value="Female" required>
            <label for="female">Female</label><br>
            <!-- Add more options as needed -->
            <br>
            <label>Create Password: </label>
            <input type="password" id="pass" name="pass" required><br><br>
            <label>Retype Password: </label>
            <input type="password" id="cpass" name="cpass" required><br><br>
            <input type="submit" id="btn" value="Sign Up" name="submit"/>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>
