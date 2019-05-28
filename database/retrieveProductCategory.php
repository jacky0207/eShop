<?php

require 'dbConnect.php';

$query = 'SELECT productCompany FROM PRODUCT ORDER BY PRODUCTID';
$result = $mysqli->query($query, MYSQLI_STORE_RESULT);

$string = "<select name=\"productCompany\" id=\"productCompany\">";
$string .= "<option>All</option>";
$currentProductCompany = "ABC";

while ($datas = $result->fetch_object()) {
    if ($datas->productCompany == $currentProductCompany)
        continue;
    $string .= "<option>$datas->productCompany</option>";
    $currentProductCompany = $datas->productCompany;
}

$string .= "</select>";

echo $string;

$mysqli->close();
