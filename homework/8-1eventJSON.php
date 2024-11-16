<?php
    //- This application will access the WDV341 database to get the events data
    //- It will create an Event object using the Event class
    //- It will load the events data into that object
    //Format the Event object into a JSON format
    //echo the object back to the client

    //  1. Connect to the database
    //  2. Create your SQL query
    //  3. Prepare your PDO Statement
    //  4. Bind Variables to the PDO Statement, if any
    //  5. Execute the PDO Statement - run your SQL against the database
    //  6. Process the results from the query
    try{
        require 'dbConnect.php';            //access to the database
    
        $sql= "SELECT id, name, description, presenter, event_date  FROM wdv_events";
    
        $stmt = $conn->prepare($sql);       //prepared statement PDO - returns statement object
    
        //Bind Parameters - n/a
    
        $stmt->execute();   //Execute the PDO Prepared statement, save results in $stmt object
    
        $stmt->setFetchMode(PDO::FETCH_ASSOC);    //return values as an ASSOC array
    }
    catch(PDOException $e){
        echo "Database Failed " . $e->getMessage();
    }

    require 'Event.php';        //gets access to the Event class

    $eventObject = new Event(); //create an Event object
    //fetch an event from the result
    // get each column of data and set it into the eventObject

    //fetch one event from the 
   // $eventRow = $stmt->fetch();     //this will pull one row from the result set

    $eventArray=[];
    while ($eventRow = $stmt->fetch() ){

        $eventObject = new Event(); 
        $eventObject->setEventsID( $eventRow["id"] );
        $eventObject->setEventsName( $eventRow["name"]);
        $eventObject->setEventsDescription( $eventRow["description"]);
        $eventObject->setEventsPresenter( $eventRow['presenter']);
        //add object to array
        array_push($eventArray,$eventObject);
       // echo "<p>Events ID " . $eventObject->getEventsID();
        //echo "<p>Events Name " . $eventObject->getEventsName();
        //echo "<p>Events Description " . $eventObject->getEventsDescription();
        //echo "<p>Events Presenter " . $eventObject->getEventsPresenter();
    }
    echo json_encode($eventArray);
?>