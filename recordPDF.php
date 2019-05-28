<?php

#exampl1.php

require("fpdf16/fpdf.php");

$pdf = new FPDF( );
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Content
$pdf->SetFontSize(28);
$pdf->Cell(50, 10, "PhoneCart", 0, 0, 'L');
$pdf->Ln();

$pdf->Ln();

$pdf->SetFontSize(18);
$pdf->Cell(42, 8, "Transaction Record", 0, 0, 'L');
$pdf->Ln();

$pdf->Ln();

$pdf->SetFontSize(12);
$pdf->Cell(40, 8, "UserName: ", 0, 0, 'L');
$pdf->Cell(50, 8, $_COOKIE['username'], 0, 0, 'L');
$pdf->Ln();

$pdf->Cell(40, 8, "Transaction time: ", 0, 0, 'L');
$pdf->Cell(50, 8, $_GET['recordTime'], 0, 0, 'L');
$pdf->Ln();

$pdf->Ln();

$pdf->SetFillColor(0, 156, 0);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetDrawColor(64, 64, 64);

$pdf->Cell(63, 8, "ProductName", 1, 0, 'L', true);
$pdf->Cell(63, 8, "ProductAmount", 1, 0, 'L', true);
$pdf->Cell(63, 8, "ProductPrice", 1, 0, 'L', true);
$pdf->Ln();

require 'database/dbConnect.php';

$query = 'SELECT productList FROM RECORD WHERE USERID=' . $_COOKIE['userID'] . " and RECORDTIME='" . $_GET['recordTime'] . "'";
$result = $mysqli->query($query, MYSQLI_STORE_RESULT);
$sum = 0;

$pdf->SetTextColor(0, 0, 0);
while ($datas = $result->fetch_object()) {
    $row = explode(" ", $datas->productList);
    $textColor = false;
    foreach ($row as $product) {
        $productInfo = explode(",", $product);

        $productID = $productInfo[0];
        $productAmount = $productInfo[1];

        $detailQuery = 'SELECT productName, productPrice FROM PRODUCT WHERE PRODUCTID=' . $productID;
        $detailResult = $mysqli->query($detailQuery, MYSQLI_STORE_RESULT);

        while ($detailDatas = $detailResult->fetch_object()) {
            $textColor? $pdf->SetFillColor(0, 255, 0) : $pdf->SetFillColor(255, 255, 255);
            $textColor = !$textColor;
            
            $pdf->Cell(63, 8, $detailDatas->productName, 1, 0, 'L', true);
            $pdf->Cell(63, 8, $productAmount, 1, 0, 'L', true);
            $pdf->Cell(63, 8, "HKD" . $detailDatas->productPrice, 1, 0, 'L', true);
            $sum += $detailDatas->productPrice;
        }
        $pdf->Ln();
    }
}
$pdf->SetFillColor(156, 156, 156);
$pdf->Cell(189, 8, "Total Price: HKD" . $sum, 1, 0, 'R', true);

$mysqli->close();
// end Content

$pdf->Output();
?>