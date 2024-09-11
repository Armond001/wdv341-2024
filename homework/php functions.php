<?php 
/*
Create a function that will accept a Unix Timestamp as a parameter and format it into mm/dd/yyyy format.
Create a function that will accept a Unix Timestamp as a parameter and format it into dd/mm/yyyy format to use when working with international dates.
Create a function that will accept a string parameter.  It will do the following things to the string:
Display the number of characters in the string
Trim any leading or trailing whitespace
Display the string as all lowercase characters
Will display whether or not the string contains "DMACC" either upper or lowercase
Create a function that will accept a number parameter and display it as a formatted phone number.   Use 1234567890 for your testing.
Create a function that will accept a number parameter and display it as US currency with a dollar sign.  Use 123456 for your testing.
*/


// date test variable and functions
    $date1 =  date_create('2036-12-24 13:59:59');
    
    function usDate($inDate){
        echo date_format($inDate, 'n/d/Y' );
    } 

    function internationalDate($inInternationalDate){
        echo date_format($inInternationalDate, 'd/n/Y');
    } 


//string test variables and function
    $testStringUppercase = "I am attending DMACC";

    $testStringLowercase = "I am attending dmacc";

    $testString = "I am attening ISU";

    
        function  stringFormat($input) {

            echo "string contains ".strlen($input)." characters<br>";	

            echo trim($input);
        
            $substring = "DMACC";
            
            if (stripos($input, $substring) !== false) {
                echo " <br> string contains DMACC";;
            } else {
                echo "<br> string dosent contain DMACC";
            }
        }

// phone number formator and variables
$testPhoneNumber = +1234567890;
function phoneNumberFormat($inPhoneNumber){
    echo substr($inPhoneNumber, -10, -7) . "-" .
    substr($inPhoneNumber, -7, -4) . "-" .
    substr($inPhoneNumber, -4);

}

//currencey formator and test variables 
$testCurrenyAmount= 123456;

function currencyFormat($inCurrency){
   
   $numberFormat = number_format($inCurrency);
   echo "$".$numberFormat;
}


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
<p> <?php echo usDate($date1);?> </p>
<p> <?php echo internationalDate($date1);?> </p>
<p>test string with uppercase DMACC: <?php  stringFormat($testStringUppercase) ?></p>
<p>test string with lowercase dmacc: <?php  stringFormat($testStringLowercase) ?></p>
<p>test string without dmacc: <?php  stringFormat($testString) ?></p>
<p>test phone number format <?php  phoneNumberFormat($testPhoneNumber) ?></p>
<p>test currency format format <?php currencyFormat($testCurrenyAmount)   ?></p>



</body>

</html>