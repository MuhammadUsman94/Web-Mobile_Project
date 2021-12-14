<?php

// getting menu id getting from ajax request
$menu_id = $_GET['menu_id'];

// converting menu id into integer
$int_menu_id = (int) $_GET['menu_id'];

// getting hotel id from ajax request
$hotel_id = $_GET['hotel_id'];


// connection init
include 'config.php';

// getting hotel collections from mongo db
$collection = $client->restaurants->hotels;


// finding menu against the hotels using menu id
$collection->updateOne( 
array("_id" => new MongoDB\BSON\ObjectID($hotel_id)),
    array( '$pull' => 
        array(
            "menu" => array(
            "id" => $menu_id )
        )
    )
);
// end finding menu against the hotels using menu id

// delete the menu via hotel and menu id
$collection->updateOne( 
array("_id" => new MongoDB\BSON\ObjectID($hotel_id)),
    array( '$pull' => 
        array(
            "menu" => array(
            "id" => $int_menu_id )
        )
    )
);
// end delete the menu via hotel and menu id

// redirecting to details page
header("Location: http://localhost/crm//view_details.php?id=$hotel_id");