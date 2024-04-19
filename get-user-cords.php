<?php 
require_once "connection.php";

// Check if user_id is set in the POST request
if(isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Log received user_id
    error_log("Received user_id: " . $user_id);

    // Prepare and execute the SQL query to fetch the user's address
    $sql = "SELECT address FROM account WHERE id = ?";
    $statement = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($statement, "i", $user_id);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    // Fetch the address
    $row = mysqli_fetch_assoc($result);
    $address = $row['address'];

    // Close statement and connection
    mysqli_stmt_close($statement);
    mysqli_close($conn);

    // Log retrieved address
    error_log("Retrieved address: " . $address);

    // Output address as JSON
    echo json_encode(array($address));
} else {
    // Handle the case when user_id is not set
    echo json_encode(array('error' => 'User ID is not set'));
}
?>
