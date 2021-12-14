<?php

/**
 * Add_hotel.php
 * This page is for saving ajax request from the hotels.php
 * following are the variable we are saving into mongo db 
 * collection using ajax request from the hotel.php 
 * */

$name = $_POST['name'];
$address = $_POST['address'];
$cuisines = $_POST['cuisines'];
$feature_image = $_POST['feature_image'];
$thumbnail_image = $_POST['thumbnail_image'];

// Initiate the DB connection string
include 'config.php';

// Initiate the hotels collection
$collection = $client->restaurants->hotels;


// Saving ajax posted data via variable into hotel hotel collection
$insertOneResult = $collection->insertOne([
    'name' => $name,
    'address' => $address,
    'cuisines' => $cuisines,
    'feature_image' => $feature_image,
    'thumbnail_image' => $thumbnail_image,
    'rating' => "4.2",
    'reviews' => "900",
    'menu' => array()
]);
// data save end


// Once data saved redirecting to hotels.php
header("Location: http://localhost/crm//hotels.php");
