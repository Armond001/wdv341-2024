<?php 

session_start();
if( isset($_SESSION['validUser']) ){
    //echo "Valid User Show the page";
}
else{
    //echo "BAD USER Go Away!!";
    header('Location: login.php');      //redirect unwanted users to the login page
}

require "../dbConnect/dbConnect.php";
// self psoting form  
// flag/switch variable will tell is wether or not form has been submitted 

$formRequested=true;
$validForm=true;
$nameError="";
$descriptionError="";
$cookingTimeError="";
$difficultyError="";
$directionError="";
$ingredientError="";
$imgError="";
if( isset ($_POST ['submit'] )){

    // simple validation
    if(empty($_POST["recipeName"])){
        $nameError="Enter Recipe Name";
        $validForm=false;
    }

    if(empty($_POST["recipeDescription"])){
        $descriptionError="Enter Recipe Description";
        $validForm=false;
    }

    if(empty($_POST['recipeDifficulty'])){
        $difficultyError="choose ricipe  difficulty";
        $validForm=false;
    }
    if(empty($_POST['recipeCookingTime'])){
        $cookingTimeError="choose Recipe cooking time";
        $validForm=false;
    }
    if(empty($_POST['recipeIngredients'][0])){
        $ingredientError="Enter at least one ingredient";
        $validForm=false;
    }
    if(empty($_POST['recipeDirection'][0])){
        $directionError="Enter at least one direction";
        $validForm=false;
    }

    if (empty($_FILES['recipeIamge'])){
        $imgError="Enter an Image";
        $validForm=false;
    }
   
 



  if($validForm)  { 
    // the form has been submitted
    
    // process the data submitted
    $formRequested=false;
  
  // process the form data into the database 
     // process the data submitted
    $recipeName=$_POST["recipeName"];
    $recipeDescription=$_POST["recipeDescription"];
    $recipeDifficulty=$_POST['recipeDifficulty'];
    $recipeCookingTime=$_POST['recipeCookingTime'];
    $recipeDirection=$_POST['recipeDirection'];
    $recipeIngredients=$_POST['recipeIngredients'];
    //image 
    $recipeiMAGE=$_FILES['recipeIamge'];
        $imageName=$_FILES['recipeIamge']["name"];
        $imageTmpName=$_FILES['recipeIamge']["tmp_name"];
        $imageSize=$_FILES['recipeIamge']["size"];
        $imageError=$_FILES['recipeIamge']["error"];
        $imageType=$_FILES['recipeIamge']["type"];

        $imageExt= explode(".", $imageName);
        $imageActualExt=strtolower(end($imageExt));

        $allowedImage=array("jpg", "JPEG","png");

        if(in_array($imageActualExt,$allowedImage)){
           if($imageError===0){

            if($imageSize<500000){
                $imageNewName=uniqid("",true).".".$imageActualExt; 
                $imageDestination="../images/".$imageNewName;
                move_uploaded_file($imageTmpName,$imageDestination);
               
            }
            else{ 
                $imgError="file is too big";
                $validForm=false;
               }
           }
           else{ 
            $imgError="error with file upload";
            $validForm=false;
           }
           
        }
        else{
            $imgError="Enter an Image";
            $validForm=false;
        }
    

    $ingredientsStr=implode(",", $recipeIngredients );
    $directionStr=implode(",", $recipeDirection );
     //collect data 
     $data=[
        'recipeName'=> $recipeName,
        'description' => $recipeDescription,
        'difficulty' => $recipeDifficulty,
        'cookingTime'=>$recipeCookingTime,
        'instructions'=>$directionStr,
        'ingredients'=>$ingredientsStr,
        'image'=>$imageNewName

     ];
     
     // insert into database 
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $sql= "INSERT INTO recipes (recipeName, description, difficulty, cookingTime, instructions, ingredients, image) VALUES( :recipeName, :description, :difficulty, :cookingTime, :instructions, :ingredients, :image)";
     $stmt= $conn->prepare($sql);
     $stmt->execute($data);
     //validate the form data
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Recipe Project</title>
    <meta name="keywords" content=" jacob, web development homework">
    <meta name="Author:" value="Jacob Scroggins">
    <meta name="destription" content="homework ">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../StyleSheets/inputRecipe.css">
    <script
        src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
        crossorigin="anonymous"></script>


    
    <style>
        .errMsg{
            color: red;
        }


    </style>

    <script>
        //validate form before server 
            // image should be png/jpg and shouldnt be above a certain file size 
            // REQUIRE ALL FEILDS 
            function onload(){  
                document.querySelector("#addIngredient").onclick=addIngredient;
                document.querySelector("#addDirection").onclick=addDirection;
      
            }
            let ingredientCount=0;

            function addIngredient(){
    
                ingredientCount+=1;

                let newIngredient= document.createElement("p");
                let newInput = document.createElement("input"); 
                newInput.type = "text";
                newInput.className = "recipeIngredients";
                
                newInput.name = "recipeIngredients["+[ingredientCount]+"]";

                newIngredient.appendChild(newInput)
                
                //places new div at bottom
                document.querySelector("#ingredientContainer").append(newIngredient);

            }
            let directionCount=0;
            function addDirection(){
    
                directionCount+=1;

                let newDirection= document.createElement("p");
                let newInput = document.createElement("input"); 
                newInput.type = "text";
                newInput.className = "recipeDirection";
                
                
                newInput.name = "recipeDirection["+[directionCount]+"]";

                newDirection.appendChild(newInput)
                
                //places new div at bottom
                document.querySelector("#directionContainer").append(newDirection);

            }

    </script>

</head>

<body onload="onload()" class="recipeInputPage">
<div class="inputForm">
    <header>
        
        <h1>Jacob's Recipe Manager</h1>
    </header>

    <?php
        if ($formRequested){
            //form has been requested 
            // display form 
          
    ?>
    
        <form method="post" action="./inputRecipePage.php" enctype="multipart/form-data" >
            <p>
                <lable for="recipeName">Recipe Name</lable>
                <input type="text" name="recipeName" id="recipeName">
                <span class="errMsg"><?php  echo $nameError; ?></span>
                
            </p>

            <p>
                <lable for="recipeDescription">Recipe Description</lable>
                <input type="text" name="recipeDescription" id="recipeDescription">
                <span class="errMsg"><?php  echo $descriptionError; ?></span>
            </p>

            <p>
                <lable for="recipeIamage">Recipe Iamge</lable>
                <input type="file" name="recipeIamge" id="recipeImage" accept="image/png, image/jpeg">
                <span class="errMsg"><?php  echo $imgError; ?></span>
            </p>

            <p>
                Recipe Difficulty
                <span class="errMsg"><?php  echo $difficultyError; ?></span>
            </p>

            <p>
            
            <input type="radio" id="easy" name="recipeDifficulty" value="easy">
            <label for="easy">Easy</label><br>
            <input type="radio" id="intermediate" name="recipeDifficulty" value="intermediate">
            <label for="intermediate">Intermediate</label><br>
            <input type="radio" id="masterChef" name="recipeDifficulty" value="master chef">
            <label for="masterChef">Master Chef</label>  
            </p>

            
            <p>
                <lable for="recipeCookingTime">Cooking Time</lable>
                <input type="text" name="recipeCookingTime" id="recipeCookingTime">
                <span class="errMsg"><?php  echo $cookingTimeError; ?></span>
            </p>

            <p>
                <lable for="recipeIngredients">Recipe Ingredients</lable>
                <span class="errMsg"><?php  echo $ingredientError; ?></span>
                <div id="ingredientContainer">
                    <p> <input type="text" name="recipeIngredients[0]" class="recipeIngredients"></p>
                </div>
               
            </p>

            <p>
                <lable for="recipeDirection">Recipe Directions</lable>
                <span class="errMsg"><?php  echo $directionError; ?></span>
                <div id="directionContainer">
                    <p><input type="text" name="recipeDirection[0]" class="recipeDirection"></p>
                </div>
               

            </p>

            <p>
                <input type="submit" value="submit" name="submit">
                <input type="reset" value="reset" name="reset">
            </p>
        </form>
        <div id="addButtons">
        <button onclick="addIngredient()" id="addIngredient">add ingredient</button>
        <button onclick="addDirection()" id="addDirection">add direction</button>
        </div>
</div>
     
    <?php 
        }
        else{
            //comfirmation message 
            // link back to allRecipiePage or homePage 
    ?>
        <p>recipe has been submitted</p>
    <?php
        }
    ?>
     <footer>
            <?php 
            echo "recipe manager". date("Y") . "©";
            ?>
    </footer>
</body>

</html>