<?php
/* !--
JuMiLDAP - A Web-based LDAP browser
by Michael Pilgermann (kichkasch@gmx.de)
Copyright (C) 2010 Michael Pilgermann
 
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
 
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
The purpose of this PHP-Script is simply accessing a database, which contains recipe information
for reading purposes only in order to display them in a web browser. The accessed database must
be in the design given by the Anymeal (http://www.wedesoft.demon.co.uk/anymeal-api/) application.
This application will propably also be used for adding and modifying content in the database as
this web frontend is not capable of supporting this.
-->
*/

require('fpdf/fpdf.php');
include 'tools.php';

$mode=$_REQUEST['mode'];
$addresslist = $_REQUEST['addresslist'];

$pdf=new FPDF();
$pdf->AddPage();

if ((isset ($mode)) && (! empty ($mode)) && (! strcmp($mode, "addresslist")) ){

$addresslist = hex2bin($addresslist);

$pdf->SetFont('Arial','',12);


include 'config.php';


$ds=ldap_connect($ldapHost, $ldapPort);  // must be a valid LDAP server!

if (ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {

if ($ds) { 
    $r=ldap_bind($ds);     // this is an "anonymous" bind, typically
                           // read-only access

    $pdf->SetFont('Arial','B',12);
    $pdf->MultiCell(80,6, $ST_ADDRESS_LIST . "\n" . date(DATE_RFC822),0,1);
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
