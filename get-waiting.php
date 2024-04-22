<?php
    require_once "connection.php";
    $user_id = $_GET["user_id"];

$sql = "SELECT * FROM waiting WHERE listing_id = $user_id";
$result = mysqli_query($conn, $sql);

if ($result) {
    $data = []; // Initialize data array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_free_result($result);

    // Close connection
    mysqli_close($conn);

    // Output data as JSON
    echo json_encode($data);
} else {
    echo "Error in query: " . mysqli_error($conn);
}

?>