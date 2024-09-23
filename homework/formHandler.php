<?php 
$firstName= $_POST["first_name"];
$lastName= $_POST["last_name"];
$SchoolName= $_POST["school_name"];
$email=$_POST["email"];
$major=$_POST["major"];
$comments=$_POST["comments"];



if (isset($_POST["academicStanding"] ) ){
    $academicStanding=$_POST["academicStanding"];
 }
 else{
	$academicStanding= " no academic standing ";
 }


 if (isset($_POST["contactMe"] ) ){
    $contactMe=$_POST["contactMe"];
	
 }
 else{
	$contactMe= " do not contact me with information";
 }



 if (isset($_POST["contactAdvisor"] ) ){
    $contactAdvisor=$_POST["contactAdvisor"];
	
 }
 else{
	$contactAdvisor= " i do not wish to speeak to an advisor";
 }


?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WDV101 Basic Form Handler Example</title>


<style>
	body {
	align-items: center;
	padding: none;
	justify-content: center;
	height: 100vh;
	background-image:url("pexels-pixabay-256490.jpg") ;
	}

	main{
		margin: auto;
		width: 70%;
		background-color: white;
	}


	a{
		text-decoration: none;
	}
	
</style>
</head>

<body>
	

<main>
<h2>Dear <?php echo $firstName ?>,</h2>

<p>Thank for you for your interest in DMACC.</p>  

<p>We have you listed as an <?php echo $academicStanding ?> starting this fall. </p>

<p>You have declared <?php echo $major ?> as your major. </p>

<p>Based upon your responses we will provide the following information in our confirmation email to you at <?php echo $email ?>.</p>


<p><?php echo $contactMe ?></p>

<p><?php echo $contactAdvisor ?></p>

You have shared the following comments which we will review:
<p><?php echo $comments ?></p>

<a href="input form.html"><p> back to contact From</p></a>
</main>
</body>
</html>