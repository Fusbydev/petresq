<?php
require_once "connection.php";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['username'];
    $password = $_POST['password'];

    $stmnt = $conn->prepare("SELECT id, email, pasword FROM account WHERE email = ?");
    $stmnt->bind_param("s", $email);
    $stmnt->execute();
    $result = $stmnt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_pass = $row["pasword"];
            $user_id = $row["id"];
            if (password_verify($password, $stored_pass)) {
                header("location: home-page.php?user_id=$user_id");
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
body {
    font-family: sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-image: url('mainbackground.jpg');
    background-size: cover;
    background-position: center;
}
.login-form {
    width: 400px; /* Increase the width of the form */
    padding: 40px; /* Increase the padding for more spacing */
    background-color: lightblue;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
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
}

.register-button {
    display: block;
    text-align: center;
    margin-top: 10px;
    color: #4CAF50;
    text-decoration: none;
}

.logo img {
    height: 400px;
    width: 300px;
    margin-left: 50px;
}
</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 d-flex justify-content-center"> <!-- Added d-flex justify-content-center class -->
            <div class="login-form">
                <h1><center>Login</center></h1>
                <form action="" method="post">
                    <label for="username">Email</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Login</button>
                </form>
                <a href="registration.php" class="register-button">Don't have an account? Register Here</a>
            </div>
        </div>
        <div class="col-md-6 text-center pic">
            <div class="logo">
                <img src="mainlogo.png" alt="Petfinder-logo">
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
