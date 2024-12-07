<?php

/*
recipe aside 
    should collect recipe data from database(img,name,description) 
    then display as text to page to then be called using ajax on the the frontend 
*/



//1.  connect to database
require "../dbConnect/dbConnect.php";

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//2. create SQL command
$sql=  "SELECT id, recipeName, description, image FROM recipes LIMIT 3 " ;


// creates php array of objects
$stmt=$conn->prepare($sql);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);


if ($stmt->rowCount() == 0) {
    echo "No results found.";
}
else{

    
    while($row= $stmt->fetch()){
   
      $recipeCard[]=array(
        "recipeName"=>$row["recipeName"],
        "recipeDescription"=>$row["description"],
        "image"=>$row["image"],
        "id"=>$row["id"]
      );
       
      
}
}

// encode to json to then be called using AJAX





// encode to json to then be called using AJAX


?> 