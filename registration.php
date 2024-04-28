<?php
require_once "connection.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        $email = $_POST['email'];
        $fname = $_POST['name'];
        $lname = $_POST['last_name']; // Corrected variable name
        $password = $_POST['password']; // Corrected variable name
        $confirm = $_POST['retype_password']; // Corrected variable name
        $address = $_POST['address']; // Corrected variable name

        // Check if the email already exists in the database
        $check_email_query = "SELECT * FROM account WHERE email = '$email'";
        $result = mysqli_query($conn, $check_email_query);
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Email is already taken. Please choose another email.')</script>";
            
        } else {
            if (strlen($password) < 8) { // Corrected function name
                echo "<script>alert('Password too short')</script>"; // Corrected alert message
            } else {
                if ($password === $confirm) {
                    // Hash the password before storing it in the database for security reasons
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    // Generate a random 5-digit number
                    $random_number = mt_rand(10000, 99999);
                    // Prepare and execute the SQL query
                    $sql = "INSERT INTO account (email, first_name, last_name, pasword, address, profile, otp_code, verified) VALUES ('$email','$fname','$lname','$hashed_password','$address', 'no-profile-picture-15257.png', '$random_number','false')";
                    if (mysqli_query($conn, $sql)) {
                        sendEmail($email, $random_number);
                        header("location: verification.php");
                        exit;
                    } else {
                        echo "<script>alert('Error: " . mysqli_error($conn) . "')</script>";
                    }
                } else {
                    echo "<script>alert('Passwords do not match')</script>";
                }
            }
        }
    }
}

function sendEmail($email, $otp) {
  try {
    $mail = new PHPMailer(true);

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'petresq4904@gmail.com';
    $mail->Password = 'heox htft eweh tytv';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Sender and recipient
    $mail->setFrom("petresq4904@gmail.com"); // Set sender's email address and name
    $mail->addAddress($email);

    // Email content
    $mail->isHTML(true);
    $mail->Subject ="OTP code for Verification";
    $mail->Body = $otp;
    
    // Send email
    $mail->send();
    echo 'Email sent successfully.';
} catch (Exception $e) {
    echo "Email sending failed. Error: {$mail->ErrorInfo}";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Page</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap');
body {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-image:url("background.png");
  font-family: "Lilita One", sans-serif;

}


.registration-form {
  width: 400px; /* Adjust width as needed */
  padding: 30px;
  background-color: white;
  border-radius: 50px;
  background-color: #3C62D1;
  background-color: ;
}


.registration-form h1 {
  text-align: center;
  margin-bottom: 20px;
}


.registration-form label {
  display: block;
  margin-bottom: 5px; /* Adjust spacing between label and input */
}


.registration-form input[type="text"],
.registration-form input[type="password"],
.registration-form input[type="email"] {
  width: 90%; /* Full width for each input */
  padding: 10px;
  border: 1px solid black;
  border-radius: 3px;
  margin-bottom: 15px; /* Adjust spacing between inputs */
}


.registration-form textarea {
  width: 90%; /* Full width for textarea */
  padding: 10px;
  border: 1px solid black
  border-radius: 3px;
  margin-bottom: 15px; /* Adjust spacing between textarea and button */
}


.registration-form button {
  width: 100%; /* Match container width */
  padding: 10px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  margin-top: 20px; /* Move button below login link */
}


.login-button {
  color: #4CAF50;
  text-align: center;
  display: block;
  margin-top: 20px; /* Add space above the link */
}

input{
  background: transparent;
  color: black;
  border: 1px solid black;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}
textarea{
  background: transparent;
  color: black;
  border: 1px solid black;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); 
}

::placeholder {
  color: black;
  font-family: "Lilita One", sans-serif;
}


a {
  color: black;
}
.login-button{
  color: black;
  text-decoration: none;
}
.lab{
  letter-spacing: 1px;
}
.msg{
  position: absolute;
  padding: 0px 3px 0px 3px;
  border-radius: 10px;
  margin-left: 50px;
  margin-top: -2px;
  height: 20px;
}
.msg p {
  margin-top: 0;
  color: orange;
}
button {
  font-family:"Lilita One", sans-serif;
}
/* Media query for smaller screens (adjust as needed) */
@media only screen and (max-width: 576px) {
  .registration-form {
    width: auto; /* Adjust width for responsiveness */
  }
}

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="registration-form">
  <h1 class="lab">Register Account</h1>
  <form action="" method="post" onsubmit="return validateForm()">
  <div class="msg" hidden>
      <p class="warning">email taken*</p>
    </div>
    <label for="email">Email</label>
    
    <input type="email" id="email" name="email" placeholder="Enter Email" required>
    <label for="name">First Name</label>
    <input type="text" id="name" name="name" placeholder="Enter First Name" required>
    <label for="last_name">Last Name</label>
    <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" required>
    <label for="address">Address</label>
    <textarea id="address" name="address" placeholder="Enter Address" required></textarea>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter Password" required>
    <label for="retype_password">Confirm Password</label>
    <input type="password" id="retype_password" name="retype_password" placeholder="Confirm Password">
    <p class="login-button">Already have an account? <a href="index.php">Click Here</a></p>
    <button type="submit" name="register">Register<i class="bi bi-box-arrow-in-right"></i></button>
    
  </form>
</div>


<script>
function validateForm() {
  // Check if any input field has a value
  const inputs = document.querySelectorAll('.registration-form input, .registration-form textarea');
  let hasValue = false;
  for (let i = 0; i < inputs.length; i++) {
    if (inputs[i].value.trim() !== '') {
      hasValue = true;
      break;
    }
  }
 
  if (!hasValue) {
    alert("Please fill out the required field before returning to the login page.");
    return false; // Prevent form submission
  }
 
  return true; // Allow form submission if a field has a value
}

//CREATED BY FUSBYDEV FINAL PROJECT APRIL 27 2024
</script>

</body>
</html>
