<?php
// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    require_once "connection.php";

    // Get the user ID from the POST data
    $userId = $_GET["user_id"];

    // Get the updated values from the POST data
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    // Update the user's profile information in the database
    $sql = "UPDATE account SET first_name = '$firstName', last_name = '$lastName', email = '$email', address = '$address' WHERE id = $userId";

    if (mysqli_query($conn, $sql)) {
        // Check if a file is uploaded
        if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0){
            $errors= array();
            $file_name = $_FILES['profile_picture']['name'];
            $file_tmp = $_FILES['profile_picture']['tmp_name'];
            $file_ext=explode('.',$_FILES['profile_picture']['name']);
            $file_ext=strtolower(end($file_ext));
            
            $extensions= array("jpeg","jpg","png");
            
            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            
            if(empty($errors)==true) {
                move_uploaded_file($file_tmp,"profile-pix/".$file_name);
                // Update the user's profile picture in the database
                $updatePictureSql = "UPDATE account SET profile = '$file_name' WHERE id = $userId";
                mysqli_query($conn, $updatePictureSql);
            }else{
                print_r($errors);
            }
        }
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Edit Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap');
        body, h1, h2, h3, h4, h5, h6, p, a, button {
            font-family: "Lilita One", sans-serif;
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
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h2>Edit Profile</h2>
    
    <form id="editForm" method="POST" enctype="multipart/form-data">
        <div class="form-group text-center">
            <label for="profile-picture">Profile Picture:</label><br>
            <img src="" alt="" class="mb-5" style="width:150px; border-radius:75px;" id="pfp"><br>
            <input type="file" class="form-control-file" id="profile-picture" name="profile_picture">
        </div>

        <div class="form-group">
            <label for="fname">First Name:</label>
            <input type="text" class="form-control" id="fname" name="first_name" placeholder="Enter your first name">
        </div>
        <div class="form-group">
            <label for="lname">Last Name:</label>
            <input type="text" class="form-control" id="lname" name="last_name" placeholder="Enter your last name">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" readonly>
            <button type="button" class="btn btn-secondary mt-2" id="editPasswordBtn" data-toggle="modal" data-target="#passwordModal">Edit Password</button>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your address"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" id="submit">Save Changes</button>
    </form>
</div>

<!-- Password Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Edit Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="oldPassword">Old Password:</label>
                    <input type="password" class="form-control" id="oldPassword" name="old_password" placeholder="Enter your old password">
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password:</label>
                    <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="Enter your new password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="savePasswordBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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

    // Fetch user data
    $.ajax({
        url: "edit-prof.php",
        type: "GET", // Changed to GET method since we're passing user_id in the URL
        data: {user_id: userId}, // Removed dataType since we're not expecting JSON directly
        success: function(data) {
            // Parse JSON data
            data = JSON.parse(data);
            var image = data[0].profile;

            if(image.length > 0) {
                $("#pfp").attr('src', 'profile-pix/'+image+'');
            } else {
                $("#pfp").attr('src', 'profile-pix/no-profile-picture-15257.png');
            }
            
            $('#fname').val(data[0].first_name); // Accessing the first element of the array
            $('#lname').val(data[0].last_name);
            $('#email').val(data[0].email);
            $('#address').val(data[0].address);
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });

    // Handle click on edit password button
    $('#editPasswordBtn').click(function() {
        // Clear old password field
        $('#oldPassword').val('');
        // Clear new password field
        $('#newPassword').val('');
    });

    // Handle click on save password button
    $('#savePasswordBtn').click(function() {
        var oldPassword = $('#oldPassword').val();
        var newPassword = $('#newPassword').val();

        // Send AJAX request to update password
        $.ajax({
            url: "update-password.php",
            type: "POST",
            data: {
                user_id: userId,
                old_password: oldPassword,
                new_password: newPassword
            },
            success: function(response) {
                // Handle response from server (e.g., display success or error message)
                alert(response);
                $('#passwordModal').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    });
});

</script>
</body>
</html>
