<?php

require 'dbConnect.php';

$query = "SELECT * FROM PRODUCT WHERE PRODUCTNAME='" . $_POST['productName'] . "'";

$result = $mysqli->query($query, MYSQLI_STORE_RESULT);

$data = "";

while (list($productID, $productDescription, $productPrice) = $result->fetch_row()) {
    $data .= $productID.",".$productDescription.",".$productPrice;
}

echo $data;

$mysqli->close();
