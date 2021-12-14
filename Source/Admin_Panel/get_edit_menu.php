<?php

/** 
 * Menu Edit ajax posted data via menu edit page
 * */

// getting hotel id via ajax request
$hotel_id = $_POST['hotel_id'];

// getting menu id via ajax request
$edit_menu_id = $_POST['edit_menu_id'];


// converting menu id from string to edit
$int_menu_id = (int) $_POST['edit_menu_id'];

// getting posted fields via ajax request
$edit_name = $_POST['edit_name'];
$edit_desc = $_POST['edit_desc'];
$edit_price = $_POST['edit_price'];
// end posted fields via ajax request


// mongo connect string
include 'config.php';

// fetching hotels
$collection = $client->restaurants->hotels;


// setting up the menu data to pull data
$collection->updateOne( 
array("_id" => new MongoDB\BSON\ObjectID($hotel_id)),
    array( '$pull' => 
        array(
            "menu" => array(
            "id" => $edit_menu_id )
        )
    )
);


// fetching menu data
$collection->updateOne( 
array("_id" => new MongoDB\BSON\ObjectID($hotel_id)),
    array( '$pull' => 
        array(
            "menu" => array(
            "id" => $int_menu_id )
        )
    )
);

// creating array to perform the edit
$new_task = array(
  "id" => $int_menu_id,
  "name" => $edit_name,
  "desc" =>  $edit_desc,
  "price" => $edit_price
);

// updating the menu
$collection->updateOne(
  array("_id" => new MongoDB\BSON\ObjectID($hotel_id)), 
  array('$push' => array("menu" => $new_task))
);
