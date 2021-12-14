<?php
/*
***
** Config.php for loading up the vendor files in order to perform functionality 
** to load the mongo DB library in our project.
***/

// library include for mongo db using php
require_once __DIR__ . "/vendor/autoload.php";
// init the name space to use the mongo functionality using mongo library
use MongoDB\BSON\ObjectId;

// Mongo DB Connectiion String
$client = new MongoDB\Client('mongodb+srv://dbUser:Admin123!@cluster0.aikdi.mongodb.net/restaurants?retryWrites=true&w=majority');
