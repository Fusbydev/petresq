<?php
require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["formname"];
    $description = $_POST["formdesc"];
    $address = $_POST["formadd"];
    $lastSeen = $_POST["formlastseen"];
    $itemId = $_POST["formid"];

    // Check if the file has been uploaded
    // Check if the file has been uploaded
if (isset($_FILES['image'])) {
    $image_name = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_temp = $_FILES['image']['tmp_name'];
    $error = $_FILES['image']['error'];

    $allowed_ex = array("png", "jpg", "jpeg"); // Define allowed file extensions

    if ($error === 0) {
        $image_ex = strtolower(pathinfo($image_name, PATHINFO_EXTENSION)); // Get the file extension

        // Check if the file type is allowed
        if (in_array($image_ex, $allowed_ex)) {
            // Generate a unique name for the uploaded file
            $new_image_name = uniqid("IMG-", true) . '.' . $image_ex;

            // Move the uploaded file to the desired location
            if (move_uploaded_file($image_temp, 'assets-pic/' . $new_image_name)) {
                // Construct the SQL query with the new image name
                if (strlen($lastSeen) > 0) {
                    $sql = "UPDATE listing SET name='$name', image = '$new_image_name', description='$description', address='$address', last_seen='$lastSeen', lost = 1 WHERE id='$itemId'";
                } else {
                    $sql = "UPDATE listing SET name='$name', image = '$new_image_name', description='$description', address='$address', last_seen='$lastSeen', lost = 0 WHERE id='$itemId'";
                }

                // Execute the query
                if (mysqli_query($conn, $sql)) {
                    // Redirect to prevent form resubmission
                    header("Location: " . $_SERVER['REQUEST_URI']);
                    exit();
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            } else {
                echo "Error moving uploaded file";
            }
        } else {
            echo "<script>alert('Cannot accept file type')</script>";
        }
    } else {
        if (strlen($lastSeen) > 0) {
            $sql = "UPDATE listing SET name='$name', description='$description', address='$address', last_seen='$lastSeen', lost = 1 WHERE id='$itemId'";
        } else {
            $sql = "UPDATE listing SET name='$name', description='$description', address='$address', last_seen='$lastSeen', lost = 0 WHERE id='$itemId'";
        }

        mysqli_query($conn, $sql);
    }
    } else {
        if (strlen($lastSeen) > 0) {
            $sql = "UPDATE listing SET name='$name', description='$description', address='$address', last_seen='$lastSeen', lost = 1 WHERE id='$itemId'";
        } else {
            $sql = "UPDATE listing SET name='$name', description='$description', address='$address', last_seen='$lastSeen', lost = 0 WHERE id='$itemId'";
        }

        mysqli_query($conn, $sql);
    }
}

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap');
        body, h1, h2, h3, h4, h5, h6, p, a, button {
            font-family: "Lilita One", sans-serif;
        }
        table {
            border: 1 solid black;
        }
        /* Add custom styles for image size */
        .table-img {
            max-width: 100px; /* Adjust the maximum width of the image */
            height: auto; /* Maintain aspect ratio */
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

    <div class="container-fluid con">
    <div class="table-responsive">
    <table class="table table-bordered table-striped text-center">
        <thead>
            <th>NAME</th>
            <th>IMAGE</th>
            <th>DESCRIPTION</th>
            <th>ADDRESS</th>
            <th>LAST SEEN</th>
            <th>ACTION</th>
        </thead>
        <tbody class="table-body">

        </tbody>
    </table>
    </div>
    </div>

    <div class="modal fade" id="viewlistLost" tabindex="-1" aria-labelledby="viewlistLost" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <form id="lostForm" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewlistLost">EDIT INFO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" class="img-fluid mx-auto d-block mb-2" alt="${item.name}" style="width: 300px; height:160px;" id="image1">
                    <input type="file" class="img-edit" name="image">
                    <p class="mb-0">Name</p>
                    <input type="text" id="name1" class="form-control mb-2" name="formname" readonly>
                    <p class="mb-0">Description</p>
                    <textarea type="text" id="desc" class="form-control mb-2" name="formdesc" style="height:150px;"></textarea>
                    <p class="mb-0">Address</p>
                    <input type="text" id="address" class="form-control mb-2" name="formadd">
                    <p class="mb-0">Last Seen (If pet was lost)</p>
                    <input type="text" id="lastseen" class="form-control mb-2" name="formlastseen">
                    <input type="text" id="item-id" hidden="true" name="formid">
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="submit" id="submit1">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.img-edit').change(function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image1').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        } else {
            $('#image1').empty();
        }
    });


        var urlParams = new URLSearchParams(window.location.search);
        var userId = urlParams.get('user_id'); // Extracting user_id from URL
        $.ajax({
            url: "archive-get.php",
            type: "post",
            dataType: "json",
            data: {user_id: userId},
            success: function(data){
                var body = ""; // Declare body outside the loop
                $.each(data, function(index, item) { // Correct the parenthesis placement
                    var truncatedDescription = item.description.length > 100 ? item.description.substring(0, 50) + '...' : item.description;
                    body += `<tr>
                                    <td class='text-center'>${item.name}</td>
                                    <td class='text-center'><img src='assets-pic/${item.image}' class='table-img'></td>
                                    <td class='text-center' style='width: 150px;'>${truncatedDescription}</td>
                                    <td class='text-center'>${item.account_address}</td>
                                    <td class='text-center'>${item.last_seen}</td>
                                    <td class='text-center'>
                                        <a href="#" class='btn btn-info' onclick="viewListLost(${item.id}, '${item.image}', '${item.name}', '${item.description}', '${item.address}', '${item.email}', '${item.last_seen}')" id="submit">
                                            <span class='bi bi-pencil'></span>Edit
                                        </a>
                                        <a href='delete.php?delete=${item.id}&user_id=${item.lister_id}' class='btn btn-warning'>
                                            <span class='glyphicon glyphicon-trash'></span>Delete
                                        </a>
                                    </td>
                                </tr>`;
                });
                $(".table-body").append(body); // Append body after the loop
            }
        });
    });

    function viewListLost(id, image, name, description, address, email, lastseen) {
    console.log(id);
    var viewlistLost = document.getElementById('viewlistLost').querySelector('.modal-dialog');
    viewlistLost.classList.add('modal-dialog-centered');
    $("#image1").attr("src", "assets-pic/" + image);
    $("#name1").val(name);
    $("#desc").val(description);
    $("#email").val(email);
    $("#address").val(address);
    $("#lastseen").val(lastseen);
    $("#item-id").val(id);
    var listingModal = new bootstrap.Modal(document.getElementById('viewlistLost'), {
        keyboard: false
    });
    listingModal.show();
    console.log(id);
}

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

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
