<?php
    require_once "connection.php";

    $sql = "SELECT COUNT(*) AS user FROM listing";
    $result = mysqli_query($conn, $sql);
        if($row = mysqli_fetch_assoc($result)) {
            $total_user = $row['user'];
        }

        $sql1 = "SELECT COUNT(*) AS accom FROM accomplished";
        $result = mysqli_query($conn, $sql1);
            if($row = mysqli_fetch_assoc($result)) {
                $total_accom = $row['accom'];
            }
        $total = $total_user + $total_accom;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="home-page.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap');
        body, h1, h2, h3, h4, h5, h6, p, a, button {
            font-family: "Lilita One", sans-serif;
        }
        .description1 .description-item1 {
            padding: 0px 50px 0px 50px;
            background-color: none;
            color: black;
        }
        #sp {
            color: red;
        }

        </style>
    </head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="#">Logo</a>
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
    </header>

    <section class="banner">
        <div class="container">
            <div class="banner-content">
                <h1>Welcome to Pet Finder</h1>
                <p>"Lost & Found: Reuniting Paws with Hearts."</p>
            </div>
        </div>
    </section>
    
    <section class="description1">
        <div class="description-item1">
            <h4>"Welcome to our compassionate community dedicated to reuniting lost pets with their loving families. 
                With a proven track record of successfully reuniting countless furry friends with their owners, 
                we provide a beacon of hope in times of distress. Join our network of caring pet lovers, where every success story strengthens our 
                bond and commitment to bringing lost pets back home. Together, we've achieved a remarkable success rate, with <span id="sp"><?php echo $total_accom?></span>
                successful reunions out of <span id="sp"><?php echo $total;?></span> pet being lost. Join us in our mission of compassion, 
                hope, and reunion!"</h4>
        </div>
    </section>


    <section class="description">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="description-item"> 
                        <img src="shrek.png" alt="Image 1" class="img-fluid">
                    </div>
                </div>
                <div class="col">
                    <div class="description-item">
                        <img src="shrek.png" alt="Image 2" class="img-fluid">
                    </div>
                </div>
                <div class="col">
                    <div class="description-item">
                        <img src="shrek.png" alt="Image 3" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

<footer class="mt-5 d-flex justify-content-between align-items-center footer-bg">
        <div class="container">
          <div class="contact-info d-flex flex-wrap">
            <p>Email: <a href="#">youremail@email.com</a></p>
            <p>Phone: <a href="#">555-555-5555</a></p>
            <p>Address: 123 Main Street, Anytown, CA 12345</p>
          </div>
          <p>&copy; 2024 PetFinder. All Rights Reserved.</p>
          
        </div>
      </footer>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var userId = urlParams.get('user_id'); // Extracting user_id from URL
            
            $("#listing").click(function() {
                window.location.href = "listing.php?user_id=" + userId;
            });
            $("#profile").click(function() {
                window.location.href = "Profile.php?user_id=" + userId;
            });
            $("#home").click(function() {
                window.location.href = "home-page.php?user_id=" + userId;
            });
});

    </script>
</body>
</html>

