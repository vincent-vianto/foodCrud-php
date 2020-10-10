<?php 
$conn = new mysqli('localhost','root','','foodCrud');

if ($conn->connect_error) {
    die("Could not connect the Database " . $conn->connect_error);
}