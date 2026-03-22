<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(403);
    exit("There was a problem with your submission, please try again.");
}

$name = strip_tags(trim($_POST["name"] ?? ""));
$name = str_replace(array("\r", "\n"), " ", $name);
$email = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
$mobile = trim($_POST["mobile"] ?? "");
$service = trim($_POST["service"] ?? "");
$message = trim($_POST["message"] ?? "");

if (
    empty($name) ||
    empty($email) ||
    empty($mobile) ||
    empty($service) ||
    empty($message) ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    http_response_code(400);
    exit("Please complete the form correctly and try again.");
}

$recipient = "anand8615@gmail.com";
$subject = "New MassServices Contact Form Inquiry";

$email_content = "Name: {$name}\n";
$email_content .= "Email: {$email}\n";
$email_content .= "Mobile: {$mobile}\n";
$email_content .= "Service: {$service}\n\n";
$email_content .= "Message:\n{$message}\n";

$email_headers = "From: {$name} <{$email}>\r\n";
$email_headers .= "Reply-To: {$email}\r\n";
$email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($recipient, $subject, $email_content, $email_headers)) {
    header("Location: thankyou.html");
    exit;
}

http_response_code(500);
exit("Oops! Something went wrong and your message could not be sent.");

?>
