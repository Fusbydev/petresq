<?php
require_once "connection.php";
$user_id = $_GET['listing_id'];
if(isset($_GET["deletePost"])) {
    // Retrieve the parameter
    $id = $_GET["deletePost"];

    // Prepare and execute the delete query
    $sql = "DELETE FROM waiting WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // Check if the deletion was successful
    if(mysqli_stmt_affected_rows($stmt) > 0) {
        echo "<script>alert('item deleted')</script>";
        header("Location: archive.php?user_id=$user_id");
    } else {
        echo "Error: Item not found or could not be deleted.";
    }
} else {
    echo "Error: No post ID provided.";
}
?>
