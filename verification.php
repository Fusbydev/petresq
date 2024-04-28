<?php
require_once "connection.php";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST["submit"])) {
        $otp = $_POST["otp"];
        
        // Prepare and execute the SQL query with a prepared statement
        $sql = "SELECT otp_code FROM account WHERE otp_code = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $otp); // Bind the parameter
        mysqli_stmt_execute($stmt);
        
        // Check for errors in the prepared statement
        if(mysqli_stmt_error($stmt)) {
            die("Error in prepared statement: " . mysqli_stmt_error($stmt));
        }
        
        // Get the result of the query
        $result = mysqli_stmt_get_result($stmt);
        
        // Fetch the row
        $row = mysqli_fetch_assoc($result);
        
        // Check if OTP code matches
        if ($row && $otp == $row["otp_code"]) {
            // Update the 'verified' field
            $update = "UPDATE account SET verified = 'true' WHERE otp_code = ?";
            $stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($stmt, "s", $otp); // Bind the parameter
            mysqli_stmt_execute($stmt);
            
            // Redirect to login.php
            header("location: index.php");
            exit(); // Ensure that no code is executed after redirection
        } else {
            echo "<script>alert('INVALID CODE');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Single Input Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap');
        body, h1, h2, h3, h4, h5, h6, p, a, button, label {
            font-family: "Lilita One", sans-serif;
        }
        body {
            background-image: url('background.png');
    background-size: cover;
    background-position: center;
        }
    .container {
        width: 500px;
        background-color: #3C62D1;
        border-radius: 30px;
        border-color: black!important;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    input {
        background-color:#3C62D1;
    border: 1px solid black;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    .btn-primary {
        background-color: pink; /* Change button background color to green */
        border-color: green; /* Change button border color to green */
        color: black;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center p-3" style="height: 100vh;">

<div class="container text-center border rounded-5 p-3">
  <form id="inputForm" action="#" method="POST">
    <div class="form-group">
        <h3 class="fs-md-5">ENTER VERIFICATION CODE SENT FROM YOUR EMAIL</h3>
      <input type="text" class="form-control" id="userInput" placeholder="Enter your code" name="otp">
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </form>
</div>

<!-- Bootstrap JS (optional, if you need JavaScript features) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
