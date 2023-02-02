<?php
session_start();

$host = "localhost"; /* Host name */
$user = "rochaa6_Admin1"; /* User */
$password = "Baseball97!"; /* Password */
$dbname = "rochaa6_beatlesMerch"; /* Database name */

$conn = mysqli_connect($host, $user, $password, $dbname);
// Check connection
if(!$conn){
    die("Error". mysqli_connect_error()); 
} 