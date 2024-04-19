<?php
$db_server = "localhost:3307";
$db_user = "root";
$db_password = "password";
$db_name = "petresq";

$conn = "";

try {
    $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

} catch(mysqli_sql_exception) {
    echo "could not connect";
}
?>