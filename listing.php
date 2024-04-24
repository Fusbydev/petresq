<?php
require_once "connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $user_id = $_GET['user_id'];
    $usersql = "SELECT CONCAT(first_name, ' ', last_name) AS name, email, address FROM account WHERE id = $user_id";
    $result = mysqli_query($conn, $usersql);
    // Fetch user data
    while($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $email = $row['email'];
        $address = $row['address'];
    }
    

    if(isset($_POST['upload'])) {
        if(isset($_POST['lost'])) {
            echo"<script>console.log($name)</script>";
            // Handle form data
            $description = filter_input(INPUT_POST, "descriptionText");
            $lastSeen = filter_input(INPUT_POST, "last-seen");

            $image_name = $_FILES['image']['name'];
            $image_size = $_FILES['image']['size'];
            $image_temp = $_FILES['image']['tmp_name'];
            $error = $_FILES['image']['error'];

            if($error === 0) {
                if($image_size < 0) {
                    echo "<script>alert('File size too big')</script>";
                } else {
                    $image_ex = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
                    $allowed_ex = array("png", "jpg", "jpeg");

                    if(in_array($image_ex, $allowed_ex)) {
                        $new_image_name = uniqid("IMG-", true) . '.' . $image_ex;
                        move_uploaded_file($image_temp, 'assets-pic/'.$new_image_name);
                        $sql = "INSERT INTO listing (lister_id, name, description, address, last_seen, date, email, image, lost) VALUES ('$user_id', '$name','$description','$address', '$lastSeen', NOW(), '$email', '$new_image_name', 1)";
                        mysqli_query($conn, $sql);
                        // Redirect to prevent form resubmission
                        header("Location: ".$_SERVER['REQUEST_URI']);
                        exit();
                    } else {
                        echo "<script>alert('cannot accept file type')</script>";
                    }
                }
            } else {
                echo"error occurred";
            }
        } else {
            /*IF LOST NOT SET*/
            $description = filter_input(INPUT_POST, "descriptionText");
            $lastSeen = filter_input(INPUT_POST, "last-seen");

            $image_name = $_FILES['image']['name'];
            $image_size = $_FILES['image']['size'];
            $image_temp = $_FILES['image']['tmp_name'];
            $error = $_FILES['image']['error'];

            if($error === 0) {
                if($image_size < 0) {
                    echo "<script>alert('File size too big')</script>";
                } else {
                    $image_ex = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
                    $allowed_ex = array("png", "jpg", "jpeg");

                    if(in_array($image_ex, $allowed_ex)) {
                        $new_image_name = uniqid("IMG-", true) . '.' . $image_ex;
                        move_uploaded_file($image_temp, 'assets-pic/'.$new_image_name);
                        $sql = "INSERT INTO listing (lister_id, name, description, address, email, date, last_seen, image, lost) VALUES ('$user_id', '$name','$description','$address', '$email', NOW(), ' ', '$new_image_name', 0)";
                        mysqli_query($conn, $sql);
                        // Redirect to prevent form resubmission
                        header("Location: ".$_SERVER['REQUEST_URI']);
                        exit();
                    } else {
                        echo "<script>alert('cannot accept file type')</script>";
                    }
                }
            } else {
                echo"error occurred";
            }
        }
    }
    //submit post
    if(isset($_POST["post"])){
        $lister_id = filter_input(INPUT_POST, "lister_id");
        $item_id = filter_input(INPUT_POST, "item_id");
        $desc = filter_input(INPUT_POST, "descriptionPost");
        $image = "IMG-661a972b3f8675.73217380.jpg";

        $sql = "INSERT INTO waiting (listing_id, item_id, description, image, name) VALUES ('$lister_id', '$item_id', '$desc', '$image', '$name')";
        header("Location: ".$_SERVER['REQUEST_URI']);   
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('post uploaded, wait for approval')</script>";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    }
}
?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js "></script>
        <link rel="stylesheet" href="magnify.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <script src="script.js"></script>
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap');
        body, h1, h2, h3, h4, h5, h6, p, a, button {
            font-family: "Lilita One", sans-serif;
        }
        body {
            overflow-x: hidden;
            background-image: url('background.png');
            background-size: cover;
            background-position: center;
        }

        .card {
            border: 2px solid black; /* Change the border color to blue */
            border-radius: 10px; 
            box-shadow: 10px 10px 100px rgba(0, 0, 0, 0.1);
        }
        .card img {
            
            border-radius: 10px;
            box-shadow: 10px 10px 100px rgba(0, 0, 0, 0.1);
        }

        .img-prev img{
            height:150px;
            width:200px;
            border: 3px solid black;
        }
        .img-prev {
            text-align:center;
        }
        .img-con {
        width: auto;
        height: 160px;
        position: relative;
        margin: 0 auto; /* Center the image horizontally */
    }
    .overlay {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        opacity: 0.5; /* Adjust the opacity as needed */
        background-color: black; /* Set the background color of the overlay */
        cursor: pointer;
        display: flex;
        align-items: center;
        border-radius: 10px;
        justify-content: center;
    }
    .name-cont {
        display:flex;
    }

.content {
    color: white; /* Set the text color of the content inside the overlay */
}
.mt-2 {
    margin-left:15px;
}
#search-input {
    border: 1px solid black;
    
}
#search {
    border: 1px solid black;
    font-weight: bold;
}
.container1 {
    background-color: #1679AB;
    width: 100%;
    height:auto;
}
.addimage {
      width: fit-content;
      border-radius: 20px;
      padding: 10px;
      background-color: #e0e0e0;
      display: inline-block;
      height: 45px;
    }

    .addimage input[type="file"] {
      display: none;
      width: 10px;
    }

    .addimage label {
      background-size: cover;
      cursor: pointer;
    }
    .la{
        color: white;

    }
    .containerCard{
        width: 350px;
        margin: auto;
    }
    .view {
        height: 25px;
        font-size: 12px;
        margin-left: 5px;
    }
    </style>
    </head>
    <body>
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
                    <li class="nav-item">
                        <a class="nav-link" href="#feed" id="profile">Accomplished</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
    <div class="container mt-3">
    <div class="row d-flex">
        <div class="col-md-8 text-center">
                <form class="d-flex mb-3" id="form-search">
                    <div class="input-group" style="margin-left:200px;">
                        <input class="form-control form-control-sm me-2" type="search" placeholder="Search" aria-label="Search" id="search-input">
                        <button class="btn btn-primary mt-0" type="button" id="search"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
            </div>
                <div class="col-md-4 mb-2">
                    <div class="btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-dark">
                            <input type="radio" name="lostFound" id="lost" autocomplete="off"> Lost
                        </label>
                        <label class="btn btn-outline-dark">
                            <input type="radio" name="lostFound" id="found" autocomplete="off"> Seen
                        </label>
                    </div>
                    </div>
                </form>
        </div>
    </div>
    <div id="pagination-container" class="d-flex justify-content-center mt-3">
        <div class="row justify-content-center" id="dataset">
            <!---dataset-->
        </div>
</div>
        
        <!-- Modal -->
        <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contactModalLabel">Contact Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="3" name="message"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="recepientEmail" readonly>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="sendEmail">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal for adding a listing -->
<div class="modal fade" id="listingModal" tabindex="-1" aria-labelledby="listingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listingModalLabel">ADD LISTING</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="#">
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="image">
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">LOST</label>
                        <input type="checkbox" name="lost" id="lost" class="lost">
                    </div>

                    <div class="mb-3">
                        <label for="descreptionText" class="form-label">Description</label>
                        <textarea class="form-control" id="descriptionText" rows="3" name="descriptionText"></textarea>
                    </div>

                    <div class="mb-3" id="last">
                        <label for="subject" class="form-label">last seen</label>
                        <input type="text" name="last-seen" id="lastSeen" class="lastSeen">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="uploadListing" name="upload">Upload</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>

<!---view list-->
<div class="modal fade" id="viewlistLost" tabindex="-1" aria-labelledby="viewlistLost" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewlistLost">MORE INFORMATION</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" class="img-fluid mx-auto d-block" alt="${item.name}" style="width: 300px; height:160px;" id="image1">
                <p id="name1"></p>
                <p id="desc"></p>
                <p id="address"></p>
                <p id="email"></p>
                <p id="lastseen"></p>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="viewlistSeen" tabindex="-1" aria-labelledby="viewlistSeen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewlistSeen">MORE INFORMATION</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" class="img-fluid mx-auto d-block" alt="${item.name}" style="width: 300px; height:160px;" id="image1s">
                <p id="name1s"></p>
                <p id="descs"></p>
                <p id="addresss"></p>
                <p id="emails"></p>
            </div>
            
        </div>
    </div>
</div>
<div id="postModal" class="modal" tabindex="-1" aria-labelledby="viewlistSeen" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post" enctype="multipart/form-data" action="#">
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="descriptionPost" name="descriptionPost" class="form-control" rows="4" cols="50"></textarea>
          </div>
          <div class="form-group">
            <label for="image">Image:</label>
            <div class="addimage">
              <input type="file" id="imagePost" name="image">
              <label for="image"><i class="fa fa-camera"></i></label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" id="submitPost" name="post">Post</button>
          <input type="text" name="lister_id" hidden value="" id="listerPost">
          <input type="text" name="item_id" hidden value="" id="itemPost">
        </form>
      </div>
    </div>
  </div>
</div>
<section id="feed">
    <div class="container1">
        <div class="container mt-5">
            <div class="row waiting-container">
                <h1 class="la mt-5">accomplished and user feedback</h1>

            </div>
        </div>
    </div>
</section>


    <div class="fixed-bottom-right">
        <button class="btn btn-primary btn-lg rounded-circle" onclick="addListing()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fi   ll="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                <path d="M8 1a.75.75 0 0 1 .75.75v6.5h6.5a.75.75 0 0 1 0 1.5h-6.5v6.5a.75.75 0 0 1-1.5 0v-6.5h-6.5a.75.75 0 0 1 0-1.5h6.5v-6.5A.75.75 0 0 1 8 1zm0 15a.75.75 0 0 1-.75-.75v-6.5H.75a.75.75 0 0 1 0-1.5H7.25V1.75a.75.75 0 0 1 1.5 0v6.5H15.25a.75.75 0 0 1 0 1.5H8.75v6.5c0 .414-.336.75-.75.75z"/>
            </svg>
        </button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="jquery.magnify.js"></script>
    <script>

$(document).ready(function() {
    $.ajax({
            url: "accomplished.php",
            method: "GET",
            dataType: "json",
            success: function(data) {
    $.each(data, function(index, item) {
        var cardHtml = `<div class="col-md-4 mb-4">
            <div class="card mt-5">
                <div class="card-body text-center">
                    <div class="profile-image mb-4">
                        <img src="assets-pic/${item.image}" alt="Profile Image" class="img-fluid zoom" style="width: 200px;">
                    </div>
                    <h5 class="card-title">${item.name}</h5>
                    <p class="card-text">${item.description}</p>
                    <div class="footer">
                        <!-- Add content or buttons here -->
                    </div>
                </div>
            </div>
        </div>`;
        $(".waiting-container").append(cardHtml);
    });

    // Loop through each .zoom element and set its attributes dynamically
    $('.zoom').each(function() {
        var imagePath = $(this).attr("src"); // Get the current image path
        $(this).attr("src", imagePath); // Update the src attribute
        $(this).attr("data-magnify-src", imagePath); // Update the data-magnify-src attribute
    });

    // Initialize magnify on .zoom elements
    $('.zoom').magnify();
},

            error: function(data) {
                console.log(data);
            }
        });
    var container = $("#dataset");
    $('#image').change(function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.img-prev').html('<img src="' + e.target.result + '" class="preview-image">');
            }
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').empty();
        }
    });

    $("#search").click(function(event) {
    event.preventDefault(); // Prevent form submission
        container.empty();
    var search = $("#search-input").val();
    // Make an AJAX request
    $.ajax({
        url: "search.php",
        type: "POST", // Specify the type of request
        data: { search: search }, // Pass the search term to the PHP script
        dataType: "json",
        success: function(data) {
    $.each(data, function(index, item) {
        listing(item.id, item.image, item.name, item.description, item.address, item.email, item.last_seen, item.lost, item.date, item.profile, item.lister_id);
    });
},
    error: function(data) {
        console.log(data);
    }
    });
});
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

    $("#last").hide();

        $(".lost").change(function() {
            if($(this).is(':checked')) {
                $("#last").show();
            } else {
                $("#last").hide();
            }
        });

    
    var email;
    var urlParams = new URLSearchParams(window.location.search);
    var userId = urlParams.get('user_id'); // Extracting user_id from URL

    function loadListings(filter) {
        container.empty(); // Clear existing listings
        $.ajax({
            url: "get-listing.php",
            method: "GET",
            dataType: "json",
            data: { filter: filter }, // Pass the filter parameter to the PHP script
            success: function(data) {
                $.each(data, function(index, item) {
                    listing(item.id, item.image, item.name, item.description, item.address, item.email, item.last_seen, item.lost, item.date, item.profile, item.lister_id);
                });
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    // Load all listings on page load


    // Filter event handlers
    $("#lost").change(function() {
        if ($(this).is(":checked")) {
            loadListings("lost"); // Load lost listings
        }
    });

    $("#found").change(function() {
        if ($(this).is(":checked")) {
            loadListings("found"); // Load found listings
        }
    });
    $.ajax({
    url: "get-listing.php",
    method: "GET",
    dataType: "json",

    success: function(data) {
    $.each(data, function(index, item) {
        listing(item.id, item.image, item.name, item.description, item.address, item.email, item.last_seen, item.lost, item.date, item.profile, item.lister_id);
    });
},
    error: function(data) {
        console.log(data);
    }
});



    $('#sendEmail').click(function() {
        var recipientEmail = $('#name').val();
        var subject = $('#subject').val();
        var message = $('#message').val();

        if ($('#message').empty() && $('#subject').empty()) {
            $.ajax({
                url: "send-email.php",
                method: "POST",
                data: {
                    recipientEmail: recipientEmail,
                    subject: subject,
                    message: message,
                    user_id: userId // Include user_id in the AJAX request data
                },
                success: function(response) {
                    alert(response);
                    $('.modal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log any errors for debugging
                }
            });
            
        } else {
            alert("please enter a valid subject and message");
        }
    });
});

function openModal(email) {
    var modalDialog = document.querySelector('.modal-dialog');
    modalDialog.classList.add('modal-dialog-centered');
    $("#name").val(email);
        var contactModal = new bootstrap.Modal(document.getElementById('contactModal'), {
            keyboard: false
        });
        contactModal.show();
}

function addListing() {
    var listingDialog = document.getElementById('listingModal').querySelector('.modal-dialog');
    listingDialog.classList.add('modal-dialog-centered');
    var listingModal = new bootstrap.Modal(document.getElementById('listingModal'), {
        keyboard: false
    });
    listingModal.show();
}

function openPostModal(lister_id, id) {
    console.log(lister_id);
    $("#listerPost").val(lister_id);
        $("#itemPost").val(id);
    var postModal = new bootstrap.Modal(document.getElementById('postModal'), {
        //$("#listerPost").val(lister_id);
        //$("#itemPost").val(id);
        
        keyboard: false
    });
    postModal.show();
}

function viewListLost(id, image, name, description, address, email, lastseen) {
console.log(id);
    var viewlistLost = document.getElementById('viewlistLost').querySelector('.modal-dialog');
    viewlistLost.classList.add('modal-dialog-centered');
    $("#image1").attr("src", "assets-pic/" + image);
    $("#name1").text("Name: "+name);
    $("#desc").text("Description: "+description);
    $("#email").text("Email: "+email);
    $("#address").text("Address: "+address);
    $("#lastseen").text("Last seen: "+lastseen);
    var listingModal = new bootstrap.Modal(document.getElementById('viewlistLost'), {
        keyboard: false
    });
    listingModal.show();
    console.log(id);
    
    $(".overlay").attr('hidden', true);
}

function viewListSeen(id, image, name, description, address, email) {
    var viewlistSeen = document.getElementById('viewlistSeen').querySelector('.modal-dialog');
    viewlistSeen.classList.add('modal-dialog-centered');
    $("#image1s").attr("src", "assets-pic/" + image);
    $("#name1s").text("Name: "+name);
    $("#descs").text("Description: "+description);
    $("#emails").text("Email: "+email);
    $("#addresss").text("Address: "+address);
    var listingModal = new bootstrap.Modal(document.getElementById('viewlistSeen'), {
        keyboard: false
    });
    listingModal.show();
    console.log(id);
}
function listing(id, image, name, description, address, email, lastSeen, lost, date, profile, lister_id) {
    console.log(profile.length);
    var container = $("#dataset");

    if (lost == 1) {
        var truncatedDescription = description.length > 100 ? description.substring(0, 50) + '...' : description;
        var cardHtml = `
        <div class="col-md-4 containerCard">
            <div class="card position-relative">
                <div class="card-body" style="padding: 10px;">
                    <div class="img-con">
                        <img src="assets-pic/${image}" class="img-fluid mx-auto d-block zoom" alt="${name}" style="width: 300px; height:160px;">
                    </div>
                    <div class="mt-2">
                    <div class="name-cont">
                    <img src="profile-pix/${profile}" alt="${name}" class="pfp" style="width: 40px; border-radius: 20px; margin-right:10px;">
                        <h4>${name}</h4>
                        <button class="btn btn-info btn-sm ml-2 view" onclick="viewListLost('${id}', '${image}', '${name}', '${description}','${address}', '${email}', '${lastSeen}')">
                        <i class="fas fa-eye"></i>
                    </button>
                    </div>
                        <p>Description: ${truncatedDescription}</p>
                        <p>Address: ${address}</p>
                        <p>Last Seen: ${lastSeen}</p>
                        <p style="opacity:0.5;">${date}</p>
                        <button class="btn btn-warning btn-sm position-absolute bottom-0 start-0 mb-2 me-2" onclick="startTextToSpeech('${name}', '${description}','${address}')">
                            <i class="fas fa-volume-up"></i>
                            </button>
                            <button class="btn btn-warning btn-sm position-absolute bottom-0 start-5 mb-2 me-2" onclick="openPostModal('${lister_id}','${id}')">create post</button>
                            <button class="btn btn-primary btn-sm position-absolute bottom-0 end-0 mb-2 me-2" onclick="openModal('${email}')">Message</button>
                    </div>
                </div>
            </div>
        </div>`;
        container.append(cardHtml);
    }
    else if (lost == 0) {
        var truncatedDescription = description.length > 100 ? description.substring(0, 50) + '...' : description;
        var cardHtml = `
        <div class="col-md-4 containerCard">
            <div class="card position-relative">
                <div class="card-body" style="padding: 10px;">
                    <div class="img-con">
                        <img src="assets-pic/${image}" class="img-fluid mx-auto d-block zoom" alt="${name}" style="width: 300px; height:160px;">
                    </div>
        
                    <div class="mt-2">
                    <div class="name-cont">
                    <img src="profile-pix/${profile}" alt="${name}" class="pfp" style=" width: 40px; border-radius: 20px; margin-right:10px;">
                        <h4>${name}</h4>
                        <button class="btn btn-info btn-sm ml-2 view" onclick="viewListLost('${id}', '${image}', '${name}', '${description}','${address}', '${email}', '${lastSeen}')">
                        <i class="fas fa-eye"></i>
                    </button>
                    </div>
                        
                        <p>Description: ${truncatedDescription}</p>
                        <p>Address: ${address}</p>
                        <p style="opacity:0.5;">${date}</p>
                        
                        <button class="btn btn-warning btn-sm position-absolute bottom-0 start-0 mb-2 me-2" onclick="startTextToSpeech('${name}', '${description}','${address}')">
                            <i class="fas fa-volume-up"></i>
                            </button>
                            <button class="btn btn-warning btn-sm position-absolute bottom-0 start-5 mb-2 me-2" onclick="openPostModal('${lister_id}','${id}')">create post</button>                                            
    <button class="btn btn-primary btn-sm position-absolute bottom-0 end-0 mb-2 me-2" onclick="openModal('${email}')">Message</button>
</button>
                    </div>
                </div>
            </div>
        </div>`;
        container.append(cardHtml);
    }
    $('.zoom').each(function() {   
        var imagePath = $(this).attr("src"); // Get the current image path
        $(this).attr("src", imagePath); // Update the src attribute
        $(this).attr("data-magnify-src", imagePath); // Update the data-magnify-src attribute
    });

    // Initialize magnify on .zoom elements
    $('.zoom').magnify();
    console.log(profile)
    
}

function startTextToSpeech(name, description, address) {
    
    if ('speechSynthesis' in window) {
            const textToRead = "This pet is " + description + ", and found by " + name + ", at the address " + address + ".";
            // Create a new SpeechSynthesisUtterance object
            const message = new SpeechSynthesisUtterance(textToRead);

            // Speak the text
            window.speechSynthesis.speak(message);
    } else {
        // If the browser doesn't support the Web Speech API
        alert('Sorry, your browser does not support text-to-speech functionality.');
    }
    console.log(description)
}

    </script>
    </body>
    </html>