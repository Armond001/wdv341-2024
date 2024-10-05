<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$schoolName = $_POST["school_name"];
$email = $_POST["email"];
$academicStanding = $_POST["academicStanding"] ?? "no academic standing";
$major = $_POST["major"];
$contactMe = $_POST["contactMe"] ?? "do not contact me with information";
$contactAdvisor = $_POST["contactAdvisor"] ?? "I do not wish to speak to an advisor";
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
   <h1>Thank you $firstName for your submission</h1>
   <p> we have noted your interest in $schoolName</p>
   <p>We will be in touch within three to five business days as of $date.</p>
   <p>Have a wonderful day!</p>
</body>
</html>";

$headers = "MIME-Version: 1.0\r\n";
$headers .= "From: JaScroggins.com <jacobscroggins@jascroggins.com>\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "Reply-To: jacobscroggins@jascroggins.com>\r\n";

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
School Name: $schoolName\n
Email: $email\n
Academic Standing: $academicStanding\n
Majors: $major\n
Contact Me: $contactMe\n
Contact Advisor: $contactAdvisor\n
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
<title>WDV101 Basic Form Handler Example</title>
<style>
   body {
      align-items: center;
      text-align: center;
      justify-content: center;
      height: 100vh;
   }

   main {
      width: 600px;
      height: 600px;
      padding: 20px;
      background-color: rgb(107, 138, 165);	
      margin: auto;
      margin-top: 10%;
      box-shadow: 2px 2px 5px 1px rgba(0, 0, 0, .2);
   }
</style>
</head>

<body>
   <main>
      <h2>Dear <?php echo htmlspecialchars($firstName); ?>,</h2>
      <p>Thank you for your interest in DMACC.</p>  
      <p>We have you listed as an <?php echo htmlspecialchars($academicStanding); ?> starting this fall.</p>
      <p>You have declared <?php echo htmlspecialchars($major); ?> as your major.</p>
      <p>Based on your responses, we will provide the following information in our confirmation email to you at <?php echo htmlspecialchars($email); ?>.</p>
      <p><?php echo htmlspecialchars($contactMe); ?></p>
      <p><?php echo htmlspecialchars($contactAdvisor); ?></p>
      <p>You have shared the following comments which we will review:</p>
      <p><?php echo htmlspecialchars($comments); ?></p>
      <a href="emailForm.html"><p>Back to contact form</p></a>
   </main>
</body>
</html>
