<?php
    require_once "connection.php";

    if(isset($_POST["user_id"]) && isset($_POST["old_password"]) && isset($_POST["new_password"])) {
        $user_id = $_POST["user_id"];
        $oldPassword = $_POST["old_password"];
        $newPassword = $_POST["new_password"];

        $sql1 = "SELECT pasword FROM account WHERE id = $user_id";
        $result = mysqli_query($conn, $sql1);

        if($row = mysqli_fetch_assoc($result)) {
            $stored_pass = $row["pasword"]; // Corrected typo here
            if(password_verify($oldPassword, $stored_pass)) {
                $hashed_new_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE account SET pasword = '$hashed_new_password' WHERE id = $user_id";
                header("Location: ".$_SERVER['REQUEST_URI']);
                if(mysqli_query($conn, $sql)) {
                    echo "updated";
                } else {
                    echo "Error updating password: " . mysqli_error($conn);
                }
            } else {
                echo "Wrong Password";    
            }
        } else {
            echo "User not found";
        }
    } else {
        echo "updated";
    }
?>
