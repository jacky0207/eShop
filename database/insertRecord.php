<?php

require 'dbConnect.php';

$query = 'INSERT INTO RECORD VALUES (?,?,?,?)';
$stmt = $mysqli->prepare($query);
$stmt->bind_param('dsds', $userID, $productList, $productSum, $recordTime);

$userID = $_COOKIE['userID'];
$productList = $_POST['productList'];
$productSum = $_POST['productSum'];
$recordTime = $_POST['recordTime'];

$stmt->execute();
$stmt->close();
$mysqli->close();
