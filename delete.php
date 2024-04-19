<?php
require_once "connection.php";

if(isset($_GET["delete"]) && isset($_GET['user_id'])) {
    $delete_item = $_GET["delete"];
    $user_id = $_GET['user_id'];
    $sql = "DELETE FROM listing WHERE id = $delete_item";
    mysqli_query($conn, $sql);
    
    // Redirect the user to archive.php with user_id parameter
    header("Location: archive.php?user_id=$user_id");
    exit(); // Ensure that script execution stops after redirection
}
?>
