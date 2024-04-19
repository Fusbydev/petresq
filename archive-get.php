<?php
require_once "connection.php";

if(isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];

    $sql = "SELECT listing.*, CONCAT(account.first_name, ' ', account.last_name) AS name, account.address AS account_address FROM listing 
                INNER JOIN account ON listing.lister_id = account.id WHERE listing.lister_id = $user_id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    $data = array(); // Initialize data array

    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Free result set
    mysqli_free_result($result);

    // Close connection
    mysqli_close($conn);

    // Output data as JSON
    echo json_encode($data);
} else {
    echo "No user_id provided.";
}
?>
