<?php

/**
 * add_menu.php
 * This page is for saving ajax request from the view_details.php
 * following are the variable we are saving into mongo db 
 * collection using ajax request from the hotel.php 
 * */

// Capturing variable posted from view_details.php page
$hotel_id = $_POST['hotel_id'];
$name = $_POST['name'];
$desc = $_POST['desc'];
$price = $_POST['price'];
$hotel_id = $_POST['hotel_id'];

// Generating random unique integer based on 6 digits for mongo DB collection ID
$key = random_int(0, 999999);
$key = str_pad($key, 6, 0, STR_PAD_LEFT);
// End Generating random unique integer based on 6 digits for mongo DB collection ID

// Including Config.php for MONGO Connection String
include 'config.php';

// Initiate the Hotel Collection
$collection = $client->restaurants->hotels;

// Finding hotel ID
$hotel = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($hotel_id)]);

// Creating array for saving data into hotel collection as objects
$new_task = array(
  "id" => $key,
  "name" => $name,
  "desc" => $desc,
  "price" => $price,
);

// Inserting data into hotel object as menu
$collection->updateOne(
  array("_id" => new MongoDB\BSON\ObjectID($hotel_id)), 
  array('$push' => array("menu" => $new_task))
);

// Redirecting to menu page once data saved.
header("Location: http://localhost/crm//view_details.php?id=$hotel_id");





