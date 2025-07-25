<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include_once __DIR__ . '/../secure_panel/api/sqlConnection.php';

$db = new sqlConnection();
$mail = new PHPMailer(true);

try {
    $name    = $_POST['name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? 'New Message from Website';
    $message = $_POST['message'] ?? '';

    if ($name && $email && $message) {
        $qry = $db->fireQuery("INSERT INTO `caller` (`name`, `email`, `phone`, `message`, `status`) VALUES ('$name', '$email', '', '$subject: $message', 'Active')");
        if (!$qry) {
            throw new Exception("Could not save enquiry to database.");
        }
    }


    //  Setup SMTP 
    $mail->isSMTP();
    $mail->Host       = 'smtp.EMAIL_PROVIDER_NAME.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'support@mail.in';
    $mail->Password   = 'YOUR_MAIL_PASSWORD';
    $mail->SMTPSecure = 'ssl';   // or 'tls'
    $mail->Port       = 465;     // or 587 for tls

    $mail->setFrom('support@mail.in', 'YOUR_WEBSITE_NAME');
    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);

    //  support mailbox
    $mail->addAddress('support@mail.in');
    $mail->Subject = $subject;
    $mail->Body = "
        <div style=\"background-color: #f2f2f2; padding: 20px; border-radius: 8px; font-family: Arial, sans-serif;\">
            <h2 style=\"margin-top: 0; color: #333;\">$subject</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <hr style=\"border: none; border-top: 1px solid #ccc;\">
            <p><strong>Message:</strong></p>
            <p style=\"white-space: pre-wrap;\">$message</p>
        </div>
        
    ";


    if (!$mail->send()) {
        throw new Exception('Could not send main email.');
    }

    // auto-reply
    $mail->clearAddresses();
    $mail->addAddress($email, $name);

    $mail->Subject = "Your request has been received";
    $mail->Body = "
        <div style=\"background-color: #f2f2f2; padding: 20px; border-radius: 8px; font-family: Arial, sans-serif;\">
            <h2 style=\"margin-top: 0; color: #333;\">Ticket Raised: $subject</h2>
            <p>Hi $name,</p>
            <p>Thank you for contacting Us. We have received your message and our team will get back to you shortly.</p>
            <p><strong>Your Message:</strong></p>
            <p style=\"white-space: pre-wrap;\">$message</p>
            <br>
            <p style=\"color: #555;\">Regards,<br> Team</p>
        </div>
    ";

    if (!$mail->send()) {
        throw new Exception('Could not send auto-reply.');
    }

    echo 'OK';
} catch (Exception $e) {
    echo "Mailer Error: " . $e->getMessage();
}
?>
