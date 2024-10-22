<?php 





//database workflow
//1. connect to database, use dbconnect 
//2. create your sql command 
//3.prepare your statement
//4.bind any parameter
//5.exucute your SQL
//6. procces your result

//1. connect to database, use dbconnect 
require "dbConnect.PHP";
//creates connection object 
//PHP CANNOT use the . for object dot nottaion we use the -> symbol instead 
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//2.create SQL command
$sql= "SELECT name, description, presenter, date, time FROM wdv_events";

//3.prepare tour statment
$stmt=$conn->prepare($sql);// prepare SQL statment into the stament object

//4. BInd any parameter if any
//

//5. exucute your prepared statment

$stmt->execute();

//6. process the results 

 $stmt->setFetchMode(PDO::FETCH_ASSOC);

//$eventsArray = $stmt->fetchAll();// assume assocative array

//$row =$stmt-> fetch()
//echo $row["name"];

//while($row= $stmt->fetch()){
  //  echo $row["name"];
  //  echo" : ". $row["description"];
    //echo "<br>";
//}

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
            
            text-align: center;
        }
        .postCard{
            background-color: lightblue;
            display:flex ;
            flex-direction: column;
            width: 350px;
            height: auto;
            margin: 5%;
            
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
    
        <h1>DMACC Events </h1>
         
        <div id="flexContainer">
            <?php 

            if ($stmt->rowCount() == 0) {
                echo "No results found.";
            }
            else {
            
            while($row= $stmt->fetch()){
               // echo "<div class='postCard'>";
                //echo "<h2>". $row["name"]."</h2>";
                //echo "<p>".$row["description"]."</p>";
                //echo "<p>".$row["presenter"].""


            
            ?>
            <div class=postCard>
                <h2><?php echo $row["name"];?> </h2>
                <p><?php echo $row["description"];?></p>
                <p><?php echo $row["presenter"]; ?></p>
                <p><?php echo $row["date"]; ?></p>
                <p><?php echo $row["time"]; ?></p>
            </div>

            <?php 
            }}
            ?>
        </div>
</body>

</html>