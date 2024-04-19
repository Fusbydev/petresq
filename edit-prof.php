<?php
require_once "connection.php";
    if(isset($_GET["user_id"])) {
        $user_id = $_GET["user_id"];

        $sql = "SELECT * FROM account WHERE id = $user_id";
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