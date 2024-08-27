<?php
//MODEL - DATA
//THE MODEL IS AT THE TOP OG THE PAGE/CODE
// assign variables at the top of the page
//access databaes at the top of the bage

$firstName = "mary";// this is a php variable  its defined with a $ unlike JS "Let "X" = ;

$colors = array("red","green","blue") ;
// CONTROLLER - business logic/gernal code


//VIEW - the user interface or what the user sees 
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP homework</title>
    <meta name="keywords" content=" jacob, web development homework">
    <meta name="Author:" value="Jacob Scroggins">
    <meta name="destription" content="homework ">
    <meta charset="UTF-8">
    <meta name="viewprt" content="width=device-width, initial-scale=1.0">

</head>
<body>
    <h1>Wdv341 Intro to PHP</h1>
    <h2>PHP basics and examples</h2>
    
    <?php 
        // echo = document.write in JS
        echo "<h3> php is displaying html in the view </h3>" ;
    ?>


        
    <h3> 
        <?php   
            // php works anywhhere on the page like this h3 tag or this radio button
            echo "<p> mary </p>";
         ?> 
    </h3>
    <p>
    
        <?php 
            for ($i = 0; $i < count($colors); $i++) {
                echo "<lable for='color'". $colors[$i] ."'>".$colors[$i] ."</lable>";
                echo  "<input type='radio' name='color". $colors[$i] ."'value="."$colors[$i]>";
        };
        ?>

    </p>
</body>
</html>