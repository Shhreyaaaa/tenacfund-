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
    $phone   = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';
    $product = $_POST['product'] ?? 'General Enquiry';

    $subject = "Enquiry about $product";

    if (!$name || !$email || !$message || !$phone) {
        throw new Exception("All fields are required.");
    }

    //  Save enquiry in database
    $db->fireQuery("INSERT INTO `caller` (`name`, `email`, `phone`, `message`, `status`) VALUES ('$name', '$email', '$phone', 'Product: $product | Message: $message', 'Active')");

    $mail->isSMTP();
    $mail->Host       = 'smtp.EMAIL_PROVIDER_NAME.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'support@mail.in';
    $mail->Password   = 'YOUR_MAIL_PROVIDER';
    $mail->SMTPSecure = 'ssl';   // or 'tls'
    $mail->Port       = 465;     // or 587 for tls

    $mail->setFrom('support@mail.in', 'YOUR_WEBSITE_NAME');
    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);

    //  First mail 
    $mail->addAddress('support@mail.in');
    $mail->Subject = $subject;
    $mail->Body = "
        <div style=\"background:#f2f2f2; padding:20px; border-radius:5px;\">
            <h2 style=\"margin:0;\">Enquiry about $product</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <hr style=\"border:1px solid #ccc; border-top:none;\">
            <p><strong>Message:</strong></p>
            <p>$message</p>
        </div>
    ";

    if (!$mail->send()) {
        throw new Exception('Could not send enquiry to support.');
    }

    // auto-reply to user
    $mail->clearAddresses();
    $mail->addAddress($email, $name);

    $mail->Subject = "Your enquiry for $product has been received";
    $mail->Body = "
        <div style=\"background:#f2f2f2; padding:20px; border-radius:5px;\">
            <h3>Hi $name,</h3>
            <p>Thank you for your enquiry about <strong>$product</strong>.</p>
            <p>We have received your message and will get back to you shortly.</p>
            <p style=\"color:#555;\">Regards,<br>YOUR_COMPANY_NAME</p>
        </div>
    ";

    if (!$mail->send()) {
        throw new Exception('Could not send auto-reply to customer.');
    }

    echo 'OK';
} catch (Exception $e) {
    echo "Mailer Error: " . $e->getMessage();
}
?>
