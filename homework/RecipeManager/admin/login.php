<?php
    session_start();        //join an existing session or start a new one if needed

    // $_SESSION        //associative array -  Session Variable is a name value pairs

    $errMsg = "";       //initial value for the variables
    $validUser = false; 

    /*
        if validUser then display Admin HTML - ALREADY SIGNED ON, need back to the login page
        
        if form is submitted
        pull the data from the form
        go to the database and see of there is a matching record
        if we find a match (a valid user)
            display "Welcome ???"
            display admin options
        else (invalid user)
            display an error message
            display the form back to the customer
    */

    if( isset($_POST['submit']) ){
        //echo "Form Submitted";

        $inUserName = $_POST['inUserName'];
        $inPassword = $_POST['inPassword'];

        require '../dbConnect/dbConnect.php';     //connect to the database

        $sql = "SELECT user_name , user_password FROM users WHERE user_name = :username and user_password = :password";
    
        $stmt = $conn->prepare($sql);       //prepare the statement

        $stmt->bindParam(':username', $inUserName);     //bind the parameters
        $stmt->bindParam(':password', $inPassword);

        $stmt->execute();       //execute the sql statement

        //Process the result - did the SELECT find a matching record??
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();      //get a row of data

        //echo count($row);   //valid data - two rows/username/password,
                            //invalid data - false
        if($row){
            //echo "valid data";
            $validUser = true;
            $_SESSION['validUser'] = true;      //create a Session variable and assign a value
            $_SESSION['username']=$inUserName;
            //display Welcome message with username
            //display the admin options
            //not display the login form
        }
        else{
            //display an error message
            $errMsg = "Invalid username and password!";
            //display the form back to the customer
        }

    
    }
    else{
        //echo "Display Form";
        //if validUser is True then display Admin - set the validUser to true
        if( isset($_SESSION['validUser']) ){
            $validUser = true;      //tell the system to display Admin HTML
        }
        //else show the form 
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../StyleSheets/recipeMangerStyleSheet.css">

    <title>Event Login</title>
    <style>
        .errorFormat {
            color:red;
        }
    </style>
</head>
<body>


<?php
    /*
        if( valid sign on)
            display the admin HTML
        else
            display the form HTML

    */

    if($validUser){
    //display the admin HTML in the following area
?>
<div class="logInPage">
<nav>
            <ul>
                <li><a href="../recipeManager/ajaxHome page.php">home</a></li>
                <li><a href="../recipeManager/allRecipePage.php">all recipes</a></li>
                <li><a href="login.php">login</a></li>
            </ul>
    </nav>
    <h2>Welcome to the Admin System</h2>
    <h3>You are signed as: <?php echo $_SESSION['username']; ?></h3>
    
    <div id="adminOptions">
    <ul>Admin Options available to you:
        <li><a href="inputRecipePage.php">Enter new recipes</a></li>
        <li><a href="recipeList.php" >recipe list</a></li>
        <li><a href="logout.php">Sign off</a></li>
    </ul>
    </div>
</div>
<?php
    }
    else{
        //echo "display form";
    //display the login form in the following area 
?>
<div class="logInPage">
<nav>
            <ul>
                <li><a href="recipeManagerHomePage.php">Home</a></li>
                <li><a href="allRecipePage.php">all recipes</a></li>
                <li><a href="../admin/login.php">login</a></li>
            </ul>
    </nav>
    <h1>Event Login System</h1>

    
    <form method="post" action="login.php" id="loginForm">
        <h2>Login Form</h2>
        <p>
            <label for="inUserName">Username: </label>
            <input type="text" name="inUserName" id="inUserName" placeholder="Username">
            <span class="errorFormat"><?php echo $errMsg; ?></span>
        </p>
        <p>
            <label for="inPassword">Password: </label>
            <input type="password"  name="inPassword" id="inPassword">
        </p>
        <p>
            <input type="submit" name="submit" value="Login In">
            <input type="reset">
        </p>
    </form>
    </div>
<?php 
    }
?>
</body>
</html>