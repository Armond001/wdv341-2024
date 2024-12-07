<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$email = $_POST["email"];
$comments = $_POST["comments"];
$date = date('n/d/Y');
$to = $email;

$subject = "Thank you for contacting us";
$subjectReceived = "$email has contacted you";

$message = "
<html>
<head>
   <title>Thank you for contacting us</title>
</head>
<body style='background-color:rgb(107, 138, 165); color:black;'>
   <h1>Thank you  for your submission</h1>
   <p>We will be in touch within three to five business days .</p>
   <p>Have a wonderful day!</p>
</body>
</html>";

$headers = "MIME-Version: 1.0"."\r\n";
$headers .= "From: jacobscroggins@jascroggins.com"."\r\n";
$headers .= "Content-type: text/html; charset=UTF-8"."\r\n";
$headers .= "Reply-To: jacobscroggins@jascroggins.com>"."\r\n";

// Validate email address
if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
    die("Invalid recipient email address.");
}

// Send email to the user
if (!mail($to, $subject, $message, $headers)) {
    die("Failed to send email to $to.");
}

// Prepare and send the confirmation email
$userContactInfo = "
Date Submitted: $date\n
Name: $firstName $lastName\n

Email: $email\n


Comments: $comments";

$headerReceived = "From: <$email>\r\n";
$headerReceived .= "Reply-To: $email\r\n";
$headerReceived .= "Content-type: text/plain\r\n";

if (!mail("jacobscroggins@jascroggins.com", $subjectReceived, $userContactInfo, $headerReceived)) {
    die("Failed to send confirmation email.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<link rel="stylesheet" href="../StyleSheets/contactpage.css">
<title>WDV101 Basic Form Handler Example</title>
<style>
  
</style>
</head>

<body>
      <header>
        <h1>Jacob's Recipe Manager</h1>
      </header>
   <main>
   <p>Thank you for contacting us!</p>
   </main>
</body>
</html>
