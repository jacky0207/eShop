<?php

require 'dbConnect.php';

if (isset($_POST['productCompany']) && $_POST['productCompany'] != "All") {
    $query = "SELECT productID, productName, productDescription, productPrice FROM PRODUCT WHERE PRODUCTCOMPANY='" . $_POST['productCompany'] . "' ORDER BY PRODUCTID";
} else {
    $query = 'SELECT * FROM PRODUCT ORDER BY PRODUCTID';
}

$result = $mysqli->query($query, MYSQLI_STORE_RESULT);

$string = "<div class=\"row\">";

while ($datas = $result->fetch_object()) {
    $string .= "<div class=\"product\">
                    <dl>
                        <dt><img src=\"database\getImage.php?productID=$datas->productID\" class='img-responsive img-thumbnail' title=\"Name: $datas->productName\nDescription: $datas->productDescription\nPrice: $datas->productPrice\" width=\"100\" height=\"200\"></dt>
                        <dd>$datas->productName</dd>
                        <button value=\"$datas->productID\" id='addToCart'>Add to cart</button>
                    </dl>
                </div>";
}

$string .= "</div>";

echo $string;

$mysqli->close();
