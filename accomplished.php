<?php
    require_once "connection.php";

    $sql = "SELECT * FROM accomplished";

    $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
mysqli_free_result($result);

// Close connection
mysqli_close($conn);

// Output data as JSON
echo json_encode($data);
?>