<?php
include_once "connection.php";

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Step 1: Receive User Input
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Step 2: Sanitize User Input
$searchTerm = mysqli_real_escape_string($conn, $searchTerm);

// Perform SQL query
$sql = "SELECT listing.*, CONCAT(account.first_name, ' ', account.last_name) AS name, account.email, account.address, account.profile FROM listing 
        INNER JOIN account ON listing.lister_id = account.id WHERE listing.description LIKE '%$searchTerm%'";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}

// Fetch data and store it in an array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);

// Output data as JSON
echo json_encode($data);
?>
