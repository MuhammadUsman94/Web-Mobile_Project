<?php
// Init Mongo DB Connection String
include 'config.php';

// Gettting users collection
$collection = $client->restaurants->users;

// saving collections into users
$users = $collection->find([]);

// ajax posted value
$id = $_POST['id'];
$status = $_POST['status'];
// end ajax posted value

// updating the orders against the $id
$collection->updateOne(
   ['orders._id' => new MongoDB\BSON\ObjectID($id)],
   ['$set' => ['orders.$.status' => $status]]
);
// end update

// echo success for ajax function
echo 'success';

