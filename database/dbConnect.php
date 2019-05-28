<?php

$mysqli = new mysqli();

$host = 'localhost';
$user = 'root';
$password = 'password';
$database = 'phoneCart';

$mysqli->connect($host, $user, $password, $database);

if (mysqli_connect_errno()) {
    echo ("Usage: ").  mysqli_connect_error();
    exit();
}