<?php

ini_set("display_errors",1);
error_reporting(E_ALL);
/*
require('pdf/fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();
*/

require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF("P", "mm", "A4", true, "UTF-8" );
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->SetFont('kozminproregular', '', 20);

$pdf->Image("images/logo_eart.png", 0, 5, 140, 20, 'png', '', 'M', false, 300, 'L', false, false, 0, true, false, false );
$pdf->Text( 95, 30, "領収書" );
$pdf->SetFont('kozminproregular', '', 10);
$pdf->Text( 120, 50, "発行日　：2017/04/01" );
$pdf->Text( 120, 55, "注文番号：A00000001-170406133306-5800" );
$pdf->Text( 120, 60, "注文日　：2017/03/01" );

$pdf->Text( 120, 70, "〒102-0084" );
$pdf->Text( 120, 75, "東京都千代田区二番町５番地２麹町駅プラザ９階" );
$pdf->Text( 120, 80, "株式会社ニューディメンション" );

$pdf->Image("images/syaban.png", 130, 70, 20, 20, 'png', '', 'M', false, 300, 'R', false, false, 0, true, false, false );

$pdf->Text( 10, 120, "作品タイトル" );
$pdf->Text( 60, 120, "作者" );
$pdf->Text( 100, 120, "作品番号" );
$pdf->Text( 130, 120, "単価" );
$pdf->Text( 160, 120, "数量" );
$pdf->Text( 175, 120, "価格" );


$pdf->Text( 10, 130, "タイトルですね" );
$pdf->Text( 60, 130, "中村　綾花" );
$pdf->Text( 100, 130, "00000001" );
$pdf->Text( 130, 130, "1,000,000" );
$pdf->Text( 160, 130, "1" );
$pdf->Text( 175, 130, "1,000,000" );


$pdf->Text( 160, 140, "小計" );
$pdf->Text( 175, 140, "1,000,000" );

$pdf->Text( 160, 150, "消費税" );
$pdf->Text( 175, 150, "80,000" );

$pdf->Text( 160, 160, "合計" );
$pdf->Text( 175, 160, "1,080,000" );


$pdf->Output("test.pdf", "I");

//$pdf->Image('./images/im-e-art.png', 100, 100, 100.0);

?>