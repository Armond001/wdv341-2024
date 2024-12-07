<?php 
 session_start();
 if( isset($_SESSION['validUser']) ){
     //echo "Valid User Show the page";
 }
 else{
     //echo "BAD USER Go Away!!";
     header('Location: login.php');      //redirect unwanted users to the login page
 }
// called by the listEvent.php page 


echo " you  deleted an event";

$recipeID=$_GET["recipeID"];

echo $recipeID;

//1. connect to database, use dbconnect 
require "../dbConnect/dbConnect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//2.create SQL command
$sql= "DELETE  FROM recipes WHERE id=:recipeID";

//3.prepare tour statment
$stmt=$conn->prepare($sql);// prepare SQL statment into the stament object


$stmt->bindParam(':recipeID',$recipeID);
//5. exucute your prepared statment
$stmt->execute();

//6. process the results 
 $stmt->setFetchMode(PDO::FETCH_ASSOC);

$rows = $stmt->rowCount();
 echo "rows affected $rows";

?>


