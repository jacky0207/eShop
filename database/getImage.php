<?php

require 'dbConnect.php';

$query = 'SELECT productImage FROM PRODUCT WHERE PRODUCTID=' . $_GET['productID'];

$result = $mysqli->query($query, MYSQLI_STORE_RESULT);

while ($datas = $result->fetch_object()) {
    header("Content-type: image/jpeg");
    echo $datas->productImage;
}

$mysqli->close();
