<?php

require 'dbConnect.php';

// Check database
$query = 'SELECT productAmount FROM SELECTEDPRODUCT WHERE USERID=' . $_COOKIE['userID'] . " AND PRODUCTID=" . $option;
$result = $mysqli->query($query, MYSQLI_STORE_RESULT);

while (list($originalProductAmount) = $result->fetch_row()) {
    if ($_POST['quantity'] < $originalProductAmount) {
        $query = 'UPDATE SELECTEDPRODUCT SET PRODUCTAMOUNT=? WHERE USERID=? AND PRODUCTID=?';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ddd', $productAmount, $userID, $productID);
        
        $productAmount = $originalProductAmount - $_POST['quantity'];
        $userID = $_COOKIE['userID'];
        $productID = $option;
        
        $stmt->execute();
        $stmt->close();
    } else {
        // Action depends on whether data exist
        $query = "DELETE FROM SELECTEDPRODUCT WHERE USERID=" . $_COOKIE['userID'] . " AND PRODUCTID=" . $option;
        $mysqli->query($query);
    }
}
$mysqli->close();

