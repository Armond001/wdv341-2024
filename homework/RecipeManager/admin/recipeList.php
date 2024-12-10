<?php  
session_start();
if( isset($_SESSION['validUser']) ){
    //echo "Valid User Show the page";
}
else{
    //echo "BAD USER Go Away!!";
    header('Location: login.php');      //redirect unwanted users to the login page
}
/*
delete an event from the database
     connect to database

     pick event we want to delete
     button to delete
     sql delete command 
     corfirm delete

     what events do we have display avaibale events
        connect to database
         pull data from database - select query'
         display??? - format as table, format as list format as a set of divs 




*/

//1. connect to database, use dbconnect 
require "../dbConnect/dbConnect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//2.create SQL command
$sql= "SELECT id, recipeName, ingredients, description FROM recipes";

//3.prepare tour statment
$stmt=$conn->prepare($sql);// prepare SQL statment into the stament object

//5. exucute your prepared statment
$stmt->execute();

//6. process the results 
 $stmt->setFetchMode(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP homework</title>
    <meta name="keywords" content=" jacob, web development homework">
    <meta name="Author:" value="Jacob Scroggins">
    <meta name="destription" content="homework ">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../StyleSheets/adminList.css">

    
    <style>
        body{
            
            text-align: center;
        }
        table{
            border:solid  thin black;
            width: 500px;
        }
        td{
            width: 100px;
        border: thin solid black;
        }

        #flexContainer{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            height: 980px;
        }

       
    </style>

    <script>

    </script>

</head>

<body >
    <div id="adminList">
     <h1>WDV341 Intro PHP </h1>
        <nav>
            <ul>
                <li><a href="../recipeManager/ajaxHome page.php">Home</a></li>
                <li><a href="../recipeManager/allRecipePage.php">all recipes</a></li>
                <li><a href="login.php">login</a></li>
            </ul>
        </nav>
     
     <h2>list of Recipes</h2>

     

<table id="adminRecipeTable">
    <tr>
        <th style="width: 25%;">Recipe Name</th>
        <th style="width: 40%;">Actions</th>
        
    </tr>
    <?php 
    if ($stmt->rowCount() == 0) {
        echo "<tr><td colspan='4'>No results found.</td></tr>";
    } else {
        while ($row = $stmt->fetch()) {
    ?>
    <tr>
        <td><?php echo htmlspecialchars($row["recipeName"]); ?></td>
        
        <td>
            <a href="updateRecipe.php?recipeID=<?php echo $row['id']; ?>"><button>Update</button></a>
            <a href="deleteRecipe.php?recipeID=<?php echo $row['id']; ?>"><button>Delete</button></a>
        </td>
    </tr>
    <?php 
        }
    }
    
    ?>
</table>
<footer>
            <?php 
            echo "<p>recipe manager". date("Y") . "©</p>";
            ?>
    </footer>
      
</div>

</body>

</html>