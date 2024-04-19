<?php
include_once "connection.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST["recipientEmail"], $_POST["subject"], $_POST["message"])) {
    $recipient_email = $_POST["recipientEmail"];
    if(isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        $sql_user = "SELECT CONCAT(first_name, ' ', last_name) AS name, email, address FROM account WHERE id = '$user_id'";
        $result_user = mysqli_query($conn, $sql_user);
        while($row = mysqli_fetch_assoc($result_user)) {
            $name = $row['name'];
            $sender_email = $row['email'];
            $address = $row['address'];
        }
    }
    try {
        $mail = new PHPMailer(true);

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'petresq4904@gmail.com';
        $mail->Password = 'heox htft eweh tytv';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom("petresq4904@gmail.com", $name); // Set sender's email address and name
        $mail->addAddress($recipient_email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $_POST["subject"];
        $mail->Body = $_POST["message"] . "<br><br><b>Sender's Address:</b> $address<br><br>Reply to the user using this email, $sender_email";
        
        // Send email
        $mail->send();
        echo 'Email sent successfully.';
    } catch (Exception $e) {
        echo "Email sending failed. Error: {$mail->ErrorInfo}";
    }
}
?>
