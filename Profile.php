<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="Profilestyle.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap');
        body, h1, h2, h3, h4, h5, h6, p, a, button {
            font-family: "Lilita One", sans-serif;
        }
        body {
          background-image: url('background.png');
          background-size: cover;
          background-position: center;
        }
        .navbar {
    background-color: #074173!important;
}

  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
    <a class="navbar-brand me-auto" href="#">PET FINDR<i class="bi bi-search-heart-fill" style="color: pink;"></i>.</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#" id="home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="listing">Listing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="profile">Profile</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="center-content">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="text-center">
          <?php
            require_once "connection.php";
              if(isset($_GET['user_id'])) {
                $userid = $_GET['user_id'];
                  $sql = "SELECT CONCAT(first_name, ' ', last_name) AS name, address, profile FROM account WHERE id = $userid";
                  $result = mysqli_query($conn, $sql);
                  while($row = mysqli_fetch_assoc($result)) {
                    if(strlen($row['profile']) <= 0) {
                      echo "<img src='profile-pix/no-profile-picture-15257.png'alt='Profile Picture' class='profile-picture mt-4 mx-auto d-block'>";
                    } else {
                      echo "<img src='profile-pix/". $row['profile']. "'alt='Profile Picture' class='profile-picture mt-4 mx-auto d-block'>";
                    }
                    
                    echo "<h2 class='mt-3'>".$row['name']. "</h2>";
                    echo "<p>". $row['address']. "</p>";
                }
              }
          ?>
        </div>
        <div class="row mt-4">
          <div class="col-md-6 text-center"> <!-- Centering the buttons -->
            <button class="btn btn-primary btn-block mb-2" id="edit">EDIT PROFILE <i class="bi bi-pencil"></i></button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 text-center"> <!-- Centering the buttons -->
            <button class="btn btn-secondary btn-block mb-2" id="archive">MY LISTING <i class="bi bi-envelope-paper"></i></button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 text-center"> <!-- Centering the buttons -->
            <button class="btn btn-danger btn-block" id="log-out">LOG OUT <i class="bi bi-box-arrow-right start-0"></i></button>
          </div>
        </div>
      </div>
      <div class="col-md-4 text-center">
        <img src="logolog.png" alt="Logo" class="img-fluid mt-4 mx-auto d-block">
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var userId = urlParams.get('user_id'); 
        $("#listing").click(function() {
            window.location.href = "listing.php?user_id=" + userId;
        });
        $("#profile").click(function() {
            window.location.href = "Profile.php?user_id=" + userId;
        });
        $("#home").click(function() {
            window.location.href = "home-page.php?user_id=" + userId;
        });

        $("#archive").click(function() {
            window.location.href = "archive.php?user_id=" + userId;
        });

        $("#edit").click(function() {
            window.location.href = "edit-profile.php?user_id=" + userId;
        });

        $("#log-out").click(function(){
    // Redirect the user to the login page
    window.location.href = "login.php";
    
});


    });
</script>
</body>
</html>