<?php
require_once "connection.php";

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

                    // Prepare and execute the SQL query
                    $sql = "INSERT INTO account (email, first_name, last_name, pasword, address, profile) VALUES ('$email','$fname','$lname','$hashed_password','$address', 'no-profile-picture-15257.png')";
                    if (mysqli_query($conn, $sql)) {
                        echo "<script>alert('Registration successful');</script>";
                        header("location: login.php");
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
/* Media query for smaller screens (adjust as needed) */
@media only screen and (max-width: 576px) {
  .registration-form {
    width: auto; /* Adjust width for responsiveness */
  }
}

</style>
</head>
<body>
<div class="registration-form">
  <h1 class="lab">Register Account</h1>
  <form action="" method="post" onsubmit="return validateForm()">
  <div class="msg" hidden>
      <p class="warning">email taken*</p>
    </div>
    <label for="email">Email</label>
    
    <input type="email" id="email" name="email" placeholder="Enter Email">
    <label for="name">First Name</label>
    <input type="text" id="name" name="name" placeholder="Enter First Name">
    <label for="last_name">Last Name</label>
    <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name">
    <label for="address">Address</label>
    <textarea id="address" name="address" placeholder="Enter Address"></textarea>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter Password">
    <label for="retype_password">Confirm Password</label>
    <input type="password" id="retype_password" name="retype_password" placeholder="Confirm Password">
    <p href="login.php" class="login-button">Already have an account? <a href="login.php">Click Here</a></p>
    <button type="submit" name="register">Register</button>
    
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
</script>


</body>
</html>
