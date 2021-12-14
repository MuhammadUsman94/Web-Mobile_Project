<?php
/** 
 * Performing delete hotel request that data sent via ajax
 * */

// Getting Hotel ID
$hotel_id = $_GET['id'];


// Validating if hotel id is not empty
if (empty($hotel_id)) {

   // If empty it will redirect to hotels.php
   header("Location: http://localhost/crm//hotels.php");
   die();
}

// Init the mongo DB connection
include 'config.php';

// Selecting the Hotels
$collection = $client->restaurants->hotels;

// Delete the one hotel against the hotel ID
$hotel = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectID($hotel_id)]);

// Performing redirecting to hotels.php
header("Location: http://localhost/crm//hotels.php");
?>