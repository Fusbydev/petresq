<?php
require_once "connection.php";

if(isset($_GET["insert_id"]) && isset($_GET["listing_id"])) {
    $accept = $_GET["insert_id"];
    $user_id = $_GET["listing_id"];
    $result = mysqli_query($conn, "SELECT * FROM waiting WHERE id = $accept");

    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $image = $row["image"];
            $name = $row["name"];
            $description = $row["description"];
            $listing_id = $row["listing_id"];
            $item_id = $row["item_id"];

            $insert = "INSERT INTO accomplished (image, name, description, listing_id, item_id) VALUES ('$image', '$name', '$description', '$listing_id', '$item_id')";
            if(mysqli_query($conn, $insert)) {
                mysqli_query($conn, "DELETE FROM waiting WHERE id = $accept");
                mysqli_query($conn, "DELETE FROM listing WHERE id = $item_id");
                header("Location: archive.php?user_id=$user_id");
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error: Unable to fetch data from 'waiting' table.";
    }
} else {
    echo "Error: 'accept_id' or 'listing_id' not provided.";
}
?>
