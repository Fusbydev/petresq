<?php
    include_once "connection.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

        if(isset($_POST["email"])) {
            $reciepient_email = $_POST["email"];
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
                $mail->setFrom("petresq4904@gmail.com"); // Set sender's email address and name
                $mail->addAddress($recipient_email);
        
                // Email content
                $mail->isHTML(true);
                $mail->Subject = "Someone tagged you in a post";
                $mail->Body = "Someone just made a post about your listing, verify the post";
                
                // Send email
                $mail->send();
                echo $reciepient_email;
            } catch (Exception $e) {
                echo "Email sending failed. Error: {$mail->ErrorInfo}";
            }
        }
?>