<?php
require('fpdf/fpdf.php');

$mode=$_REQUEST['mode'];
$pdf=new FPDF();
$pdf->AddPage();

if ((isset ($mode)) && (! empty ($mode)) && (! strcmp($mode, "addresslist")) ){

$addresslist = hex2bin($_REQUEST['addresslist']); 

$pdf->SetFont('Arial','B',18);
$pdf->Cell(40,10,"List to be coming soon.",0,1);
$pdf->Cell(40,10,"<" . utf8_decode($addresslist5) . ">",0,0);

} else {
$line1=$_REQUEST['line1'];
$line2=$_REQUEST['line2'];
$line3=$_REQUEST['line3'];
$line4=$_REQUEST['line4'];
$line5=$_REQUEST['line5'];

$pdf->SetFont('Arial','B',18);
$pdf->Cell(40,10,utf8_decode($line1),0,1);
$pdf->Cell(40,10,utf8_decode($line2),0,1);
$pdf->Cell(40,10,utf8_decode($line3),0,1);
$pdf->Cell(40,10,utf8_decode($line4),0,1);
$pdf->Cell(40,10,utf8_decode($line5),0,0);

}
$pdf->Output();


// Convert a hex-string to binary-string (the way back from bin2hex)

function hex2bin($h)
  {
  if (!is_string($h)) return null;
  $r='';
  for ($a=0; $a<strlen($h); $a+=2) { $r.=chr(hexdec($h{$a}.$h{($a+1)})); }
  return $r;
  }
?>
