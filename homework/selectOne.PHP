<?php 





//database workflow
//1. connect to database, use dbconnect 
//2. create your sql command 
//3.prepare your statement
//4.bind any parameter
//5.exucute your SQL
//6. procces your result

//1. connect to database, use dbconnect 
require "dbConnect.php";
//creates connection object 
//PHP CANNOT use the . for object dot nottaion we use the -> symbol instead 
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//2.create SQL command
$sql= "SELECT name, description FROM wdv_events WHERE presenter= :presenterName";
// where selects that item
//3.prepare tour statment
$stmt=$conn->prepare($sql);// prepare SQL statment into the stament object

//4. BInd any parameter if any
$recordId= 2;
//$stmt->bindParam(':recordId',$recordId);
$presenter="Carin Murphy";
$stmt->bindParam(':presenterName',$presenter);

//5. exucute your prepared statment

$stmt->execute();

//6. process the results 

 $stmt->setFetchMode(PDO::FETCH_ASSOC);

//$eventsArray = $stmt->fetchAll();// assume assocative array

//$row =$stmt-> fetch()
//echo $row["name"];


//foreach($eventsArray as $value){
//  echo $value;
//}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP homework</title>
    <meta name="keywords" content=" jacob, web development homework">
    <meta name="Author:" value="Jacob Scroggins">
    <meta name="destription" content="homework ">
    <meta charset="UTF-8">
    <meta name="viewprt" content="width=device-width, initial-scale=1.0">

    
    <style>
          body{
            background-image:url("./pexels-pixabay-256490.jpg") ;
            text-align: center;
        }
        .postCard{
            background-color: lightblue;
            display:flex ;
            flex-direction: column;
            width: 350px;
            height:350px ;
            margin: 5%;
            
        }

    </style>

    <script>
    
    </script>

</head>

<body >
    
    <h1>WDV341 Intro to PHP</h1>

    <div class="postCard">
        <?php 
            if ($stmt->rowCount() == 0) {
                echo "No results found.";
            }
            else {
        
                while($row= $stmt->fetch()){
                echo "<p>" . $row["name"]."</p>";
                echo "<p>". $row["description"]. "</p>";

                echo "<br>";
                } 
            }
        ?>
                
    </div>
</body>

</html>