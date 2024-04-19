<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="home.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap');
        body, h1, h2, h3, h4, h5, h6, p, a, button {
            font-family: "Lilita One", sans-serif;
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
                <h1>Welcome to Home Page</h1>
            </div>
        </div>
    </section>
    
    <section class="description1">
        <div class="description-item1">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nibh nulla, sodales sed massa quis, commodo congue orci. Praesent sed nisi felis. Maecenas fermentum sagittis tortor nec lobortis. Suspendisse hendrerit eros orci, nec aliquam arcu ultricies sit amet. Fusce fringilla libero vitae dui porta, a mattis risus posuere. Sed venenatis eu odio mattis mattis. Etiam ultricies odio mi, nec efficitur risus ultricies ut. Curabitur sapien felis, vulputate eget risus eget, luctus condimentum ante. Nunc vel efficitur turpis.</p>
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

    <footer class="mt-5">
        <div class="container">
            <p>&copy; 2024 Home Page | Contact: info@example.com | Phone: +1234567890</p>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

