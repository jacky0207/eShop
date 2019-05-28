<?php

require 'dbConnect.php';

$originalProductAmount = 0;

// Check database
$query = 'SELECT productAmount FROM SELECTEDPRODUCT WHERE USERID=' . $_COOKIE['userID'] . " AND PRODUCTID=" . $_POST['productID'];
$result = $mysqli->query($query, MYSQLI_STORE_RESULT);

while (list($productAmount) = $result->fetch_row()) {
    $originalProductAmount = $productAmount;
}

// Action depends on whether data exist
if ($originalProductAmount == 0) {
    $query = 'INSERT INTO SELECTEDPRODUCT VALUES (?,?,?)';
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ddd', $userID, $productID, $productAmount);
    $userID = $_COOKIE['userID'];
    $productID = $_POST['productID'];
    $productAmount = 1;
} else {
    $query = 'UPDATE SELECTEDPRODUCT SET PRODUCTAMOUNT=? WHERE USERID=? AND PRODUCTID=?';
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ddd', $productAmount, $userID, $productID);
    $productAmount = $originalProductAmount+1;
    $userID = $_COOKIE['userID'];
    $productID = $_POST['productID'];
}

$stmt->execute();
$stmt->close();
$mysqli->close();
