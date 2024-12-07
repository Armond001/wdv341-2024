<?php 
require "../dbConnect/dbConnect.php";

$formRequested = true; // Flag to check if the form is displayed
$honeypotFieldName = 'extra_field'; // Honeypot field name

if (isset($_POST['submit'])) {
    // Check if honeypot is filled
    if (!empty($_POST[$honeypotFieldName])) {
        // Honeypot was filled, possible bot detected
        echo '<p>Access Denied. <a href="contactpage.php">Reload</a></p>';
        exit; // Stop further execution
    }

    // Validate and process form data
    $formRequested = false; // Form has been submitted

    // Here you can add further form processing and database insertion logic
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Recipe Project</title>
    <meta name="keywords" content=" jacob, web development homework">
    <meta name="Author:" value="Jacob Scroggins">
    <meta name="description" content="homework">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../StyleSheets/contactpage.css">
</head>

<body>
    <header>
        <h1>Jacob's Recipe Manager</h1>
    </header>

    <?php
    if ($formRequested) {
        // Display the form
    ?>
        <form method="post" action="">
    <legend>Contact Us</legend>
    <div class="formTextInputs">
        <!-- First Name -->
        <p class="flexForm">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" required />
        </p>
        <!-- Last Name -->
        <p class="flexForm">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" required />
        </p>
        <!-- Email -->
        <p class="flexForm">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required />
        </p>
        <!-- Comments -->
        <p class="flexForm">
            <label for="comments">Comments:</label>
            <textarea name="comments" id="comments" required></textarea>
        </p>
        <!-- Honeypot Field (Hidden) -->
        <p class="flexForm" style="display:none;">
            <label for="extra_field">Do not fill this field:</label>
            <input type="text" name="extra_field" id="extra_field" />
        </p>
        <!-- Submit Button -->
        <p>
            <button type="submit" name="submit">Submit</button>
        </p>
    </div>
</form>

    <?php 
    } else {
        // Confirmation message
    ?>
        <p>Thank you for contacting us!</p>
    <?php
    }
    ?>
</body>

</html>
