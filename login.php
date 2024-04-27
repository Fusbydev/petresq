<?php
require_once "connection.php";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['username'];
    $password = $_POST['password'];

    $stmnt = $conn->prepare("SELECT id, email, pasword, verified FROM account WHERE email = ?");
    $stmnt->bind_param("s", $email);
    $stmnt->execute();
    $result = $stmnt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_pass = $row["pasword"];
            $user_id = $row["id"];
            $verify = $row["verified"];
            if (password_verify($password, $stored_pass)) {
                if($verify == "false") {
                    header("location: verification.php");
                } else if($verify == "true") {
                    header("location: home-page.php?user_id=$user_id");
                }
                
            }
        } else {
            echo "<script>alert('user not found');</script>";
        }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<title>Login Page</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap');
        body, h1, h2, h3, h4, h5, h6, p, a, button, label {
            font-family: "Lilita One", sans-serif;
        }
body {
    
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-image: url('background.png');
    background-size: cover;
    background-position: center;
}
.login-form {
    width: 400px; /* Increase the width of the form */
    padding: 40px; /* Increase the padding for more spacing */
    background-color: #3C62D1;
    border-radius: 50px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    height: 400px;
    border: 1px solid black;
}

.login-form label {
    display: block;
    margin-bottom: 10px;
}

.login-form input[type="text"],
.login-form input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #black;
    border-radius: 3px;
    margin-bottom: 10px;
}

.login-form button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.register-button {
    display: block;
    text-align: center;
    margin-top: 10px;
    color: black;
    text-decoration: none;
}

.logo img {
    width: 500px; /* Make the image responsive */
    display: block; /* Ensure the image is centered */
    margin: 0 auto; /* Center the image horizontally */
    
}
::placeholder {
    color: black;
}
a {
    color: black;
}
input {
    background-color:transparent;
    border: 1px solid black;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}
</style>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <h1 class="text-center">PET FINDR.</h1>
        <div class="col-md-6 d-flex justify-content-center mt-5"> <!-- Added d-flex justify-content-center class -->
            <div class="login-form">
                <h1><center>Login</center></h1>
                <form action="" method="post">
                    <label for="username">Email</label>
                    <input type="text" id="username" name="username" placeholder="Email" required>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
                <p class="register-button">don't have an account? <a href="registration.php">click here</a></p>
            </div>
        </div>
        <div class="col-md-6 pic">
            <div class="logo">
                <img src="logolog.png" alt="Petfinder-logo">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

