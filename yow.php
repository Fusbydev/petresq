<?php
require_once "connection.php";
  if($_SERVER['REQUEST_METHOD'] == "POST") {
    $otp = $_POST["otp"];
        
        $sql = "SELECT otp_code FROM account WHERE otp_code = $otp";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
          if ($otp == $row["otp_code"]) {
            $update = "UPDATE account SET verified = 'true' WHERE otp_code = $otp";
            $res = mysqli_query($conn, $update);
            while($row = mysqli_fetch_assoc($res)) {
              header("location: login.php");
            }
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
    .container {
        width: 500px;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center" style="height: 100vh;">

<div class="container text-center">
  <form id="inputForm" action="#" method="POST">
    <div class="form-group">
        <h1 class="fs-md-5">ENTER VERIFICATION CODE SENT FROM YOUR EMAIL</h1>
      <input type="text" class="form-control" id="userInput" placeholder="Enter your code" name="otp">
    </div>
    <button type="button" class="btn btn-primary" onclick="processInput()">Submit</button>
  </form>
</div>

<!-- Bootstrap JS (optional, if you need JavaScript features) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
