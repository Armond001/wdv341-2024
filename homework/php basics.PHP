<?php 
/* 

Create a variable called yourName.  Assign it a value of your name.
Display the assignment name in an h1 element on the page. Include the elements in your output. 
Use HTML to put an h2 element on the page. Use PHP to display your name inside the element using the variable.
Create the following variables:  number1, number2 and total.  Assign a value to them.  
Display the value of each variable and the total variable when you add them together. 
Create a PHP variable that is an array containing the values 'PHP', 'HTML' and 'Javascript'. Then, use a PHP loop to iterate through the array and create a javascript array that contains those values. Lastly, write a javascript script that displays the values of the array on the page.
This may seem trivial and repetetive, but often times PHP objects/arrays will be returned to your javascript so that you can use the data to interact with the DOM. Especially when using AJAX to talk to your PHP.
*/
 $yourName = "Jacob Scroggins";

 $number1=1;
 $number2=2;

 $languge = array("php","HTML","JavaScript");

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

    </style>

    <script>
    
    </script>

</head>

<body >
    
    <?php
        echo "<h1> $yourName </h1>";
    ?>
    
    <h2>
       <?php 
            echo $yourName; 
       ?> 
    </h2>

    <p>
        <?php
        echo "$number1 + $number2 = ".$number1 + $number2;
        ?>

    </p>

    <script> 
            <?php
            foreach($languge as $langugeValue){
                        echo "document.write('<p>' + ' $langugeValue' + '</p>');";
            }
        ?>
    </script>



</body>

</html>