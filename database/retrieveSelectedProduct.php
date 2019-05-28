<?php

require 'dbConnect.php';

$query = 'SELECT productID, productAmount FROM SELECTEDPRODUCT WHERE USERID=' . $_COOKIE['userID'] . " ORDER BY PRODUCTID";
$result = $mysqli->query($query, MYSQLI_STORE_RESULT);

$string = "<table class=\"table\" border=\"5\">";
$string .= "<thead><tr><th><input type=\"checkbox\" name=\"selectAll\" class=\"checkboxs\"></th><th>Product Name</th><th>Product Image</th><th>Product Amount</th><th>Product Price</th></tr></thead>";
$string .= "<tbody>";

$rowExist = false;
$productList = "";
$sum = 0;

while ($datas = $result->fetch_object()) {
    $detailQuery = 'SELECT productName, productPrice FROM PRODUCT WHERE PRODUCTID=' . $datas->productID;
    $detailResult = $mysqli->query($detailQuery, MYSQLI_STORE_RESULT);

    while ($detailDatas = $detailResult->fetch_object()) {
        $rowExist = true;
        $string .= "<tr><td><input type=\"checkbox\" name=\"option[]\" value=\"$datas->productID\" class=\"checkbox\"></td><td>$detailDatas->productName</td><td><img src=\"database\getImage.php?productID=$datas->productID\" class='img-responsive img-thumbnail' width=\"100\" height=\"200\"></td><td>$datas->productAmount</td><td>HKD$detailDatas->productPrice</td><tr>";
        $productList .= ($productList == "") ? "" : " ";
        $productList .= $datas->productID.",".$datas->productAmount;
        $sum += $datas->productAmount*$detailDatas->productPrice;
    }
}

$string .= "<tr><td></td><td></td><td></td><td>Total Price: </td><td>HKD$sum</td></tr>";
$string .= "</tbody>";
$string .= "</table>";

echo $string;

$mysqli->close();
