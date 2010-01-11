<?php
require('fpdf/fpdf.php');

$mode=$_REQUEST['mode'];
$addresslist = $_REQUEST['addresslist'];

$pdf=new FPDF();
$pdf->AddPage();

if ((isset ($mode)) && (! empty ($mode)) && (! strcmp($mode, "addresslist")) ){

$addresslist = hex2bin($addresslist);

$pdf->SetFont('Arial','',12);


include 'config.php';
include 'tools.php';


$ds=ldap_connect($ldapHost, $ldapPort);  // must be a valid LDAP server!

if (ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {

if ($ds) { 
    $r=ldap_bind($ds);     // this is an "anonymous" bind, typically
                           // read-only access

    $pdf->SetFont('Arial','B',12);
    $pdf->MultiCell(80,6,"Adressliste" . "\n" . date(DATE_RFC822),0,1);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(80,6,"",0,1);

    $tok = strtok($addresslist, "@");
    $counter = 0;
	
    while ($tok !== false) {
	$ldapFilter = "cn=". $tok;

	$sr=ldap_search($ds, $ldapDomain, $ldapFilter);  
	$info = ldap_get_entries($ds, $sr);

	$text = $info[0]["givenname"][0] . " " . $info[0]["sn"][0] . "\n" . $info[0]["mozillahomestreet"][0] . "\n" . $info[0]["mozillahomepostalcode"][0] . " " . $info[0]["mozillahomelocalityname"][0] . "\n" . $info[0]["mozillahomecountryname"][0];
	$pdf->MultiCell(80,6, utf8_decode($text),"T",1);
	$pdf->Cell(80,6,"",0,1);

	$counter = $counter + 1;
	$tok = strtok("@");
    }

}}

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
$pdf->Output("addressoutput.pdf","I");
?>
