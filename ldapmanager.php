<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-32"/>
<!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/> -->
<meta name="description" content="description"/>
<meta name="keywords" content="keywords"/> 
<meta name="author" content="author"/> 
<link rel="stylesheet" type="text/css" href="default.css" media="screen"/>
<title>JuMiLDAP Manager</title>
</head>

<?php
$ldapHost = "192.168.200.20";
$ldapPort = 389;
$ldapDomain = "dc=kichkasch,dc=local";
$ldapFilter = "mozillaCustom4=*"; //"(&(mozillaCustom4=*)(cn=*Alexander Guse*))";


$detailcn=$_REQUEST['detailcn'];
$filter=$_REQUEST['filter'];
$namefilter=$_REQUEST['namefilter'];
$addressList=$_REQUEST['addresslist'];
$addressListItem=$_REQUEST['addresslistitem'];


if ((isset ($filter)) && (! empty ($filter)))
{
	$ldapFilter = hex2bin($filter);
}

if ((isset ($namefilter)) && (! empty ($namefilter)))
{
	$surName = $_REQUEST['surname'];
	$firstName = $_REQUEST['firstname'];
	$ldapFilter = "(&(sn=". $surName .")(givenname=". $firstName ."))";
}
$ldapFilterHex = bin2hex($ldapFilter);

if ((isset ($addressList)) && (! empty ($addressList)))
{
	$addressList = hex2bin($addressList);
} else {
	$addressList = "";
} 

if ((isset ($addressListItem)) && (! empty ($addressListItem)))
{
	$addressList = $addressList . "@" . $addressListItem;
}
$addressListHex = bin2hex($addressList);

?>

<body>
<div class="container">
	<div class="header">				
		<div class="title">
			<h1><a href="ldapmanager.php">JuMiLDAP Manager</a></h1>
		</div>
	</div>
	<div class="navigation">
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=A*)(cn=B*))") . "&addresslist=" . $addressListHex; ?>">A-B</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=C*)(cn=D*))") . "&addresslist=" . $addressListHex; ?>">C-D</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=E*)(cn=F*))") . "&addresslist=" . $addressListHex; ?>">E-F</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=G*)(cn=H*))") . "&addresslist=" . $addressListHex; ?>">G-H</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=I*)(cn=J*))") . "&addresslist=" . $addressListHex; ?>">I-J</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=K*)(cn=L*))") . "&addresslist=" . $addressListHex; ?>">K-L</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=M*)(cn=N*))") . "&addresslist=" . $addressListHex; ?>">M-N</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=O*)(cn=P*))") . "&addresslist=" . $addressListHex; ?>">O-P</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=Q*)(cn=R*))") . "&addresslist=" . $addressListHex; ?>">Q-R</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=S*)(cn=T*))") . "&addresslist=" . $addressListHex; ?>">S-T</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=U*)(cn=V*))") . "&addresslist=" . $addressListHex; ?>">U-V</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=W*)(cn=X*))") . "&addresslist=" . $addressListHex; ?>">W-X</a>
			<a href="ldapmanager.php?filter=<?php echo bin2hex("(|(cn=Y*)(cn=Z*))") . "&addresslist=" . $addressListHex; ?>">Y-Z</a>
			<div class="clearer"><span></span></div>
		</div>
	<div class="main">			
		<div class="content">


<?php

$ds=ldap_connect($ldapHost, $ldapPort);  // must be a valid LDAP server!

if (ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {

if ($ds) { 
    $r=ldap_bind($ds);     // this is an "anonymous" bind, typically
                           // read-only access

    $sr=ldap_search($ds, $ldapDomain, $ldapFilter);  
    $info = ldap_get_entries($ds, $sr);

	//echo "Detailcn: " . $detailcn;
	//echo "Filter: " . $ldapFilter;
    for ($i=0; $i<$info["count"]; $i++) {
	if ((isset ($detailcn)) && (! empty ($detailcn)) && (! strcmp($detailcn, $info[$i]["cn"][0])) ){
		echo "<hr/>";		
		echo "<h1><a href='ldapmanager.php?filter=" . $ldapFilterHex . "&detailcn=" . $info[$i]["cn"][0] . "&addresslist=" . $addressListHex . "'>" .$info[$i]["givenname"][0] . " " . $info[$i]["sn"][0] . "</a> <a href='ldapmanager.php?filter=" . $ldapFilterHex . "&detailcn=" . $detailcn . "&addresslist=" . $addressListHex . "&addresslistitem=" . $info[$i]["cn"][0] .  "'><img src='img/liste.png' height='15'/></a></h1>";
		print "<code>";
		if ($info[$i]["mail"][0]) 
			echo "<a href='mailto:" . $info[$i]["mail"][0] . "'>" . $info[$i]["mail"][0] . " <img src='img/email.png' height='15'/></a>\n\n";
		if ($info[$i]["homephone"][0])
			print "Telefon (Home): ". $info[$i]["homephone"][0] . "\n";
		if ($info[$i]["telephonenumber"][0])
			print "Telefon (Arbeit): ". $info[$i]["telephonenumber"][0] . "\n";
		if ($info[$i]["mobile"][0])
			print "Telefon (Handy): ". $info[$i]["mobile"][0] . "\n";
		print "\n";
		if ($info[$i]["mozillahomelocalityname"][0])
		{
		print "<b>Adresse (zu Hause)</b><a href='addresspdf.php?line1=" . $info[$i]["cn"][0] . "&line2=" . $info[$i]["mozillahomestreet"][0] . "&line3=" . $info[$i]["mozillahomepostalcode"][0] . " " .  $info[$i]["mozillahomelocalityname"][0] . "&line4=" . $info[$i]["mozillahomecountryname"][0]  . "'><img src='img/pdf_icon.gif' height='15'></a>\n";
		if ($info[$i]["mozillahomestreet"][0])
			print $info[$i]["mozillahomestreet"][0] . "\n";
		if ($info[$i]["mozillahomepostalcode"][0])
			print $info[$i]["mozillahomepostalcode"][0] . " ";
		if ($info[$i]["mozillahomelocalityname"][0])
			print $info[$i]["mozillahomelocalityname"][0] . "\n";
		if ($info[$i]["mozillahomecountryname"][0])
			print $info[$i]["mozillahomecountryname"][0] . "\n";
		}
		print "</code>";
		echo "<hr/> ";		
	} else {	
	echo "<h1><a href='ldapmanager.php?filter=" . $ldapFilterHex . "&detailcn=" . $info[$i]["cn"][0] . "&addresslist=" . $addressListHex . "'>" .$info[$i]["givenname"][0] . " " . $info[$i]["sn"][0] . "</a></h1>";
	if ($info[$i]["mail"][0]) 
		echo "<div class='descr'>" . $info[$i]["mail"][0] . "</div>";
	}
    }

    ldap_close($ds);

} 
}
?>

		</div>

		<div class="sidenav">

			<h1>Namensfilter</h1>
			<form action="ldapmanager.php">
			<input type="hidden" name="namefilter" value="1"/>
			<input type="hidden" name="addresslist" value="<?php echo $addressListHex?>"/>
			<ul>
				<li>Name<br/><input name="surname" value="*"/></li>
				<li>Vorname<br/><input name="firstname" value="*"/></li>
				<li><input type="submit" value="Filter anwenden"/></li>
			</ul>
			</form>

<!--
			<h1>Gruppenfilter</h1>
			<ul>
				<li><input type="checkbox" name="micha" checked/> Micha</li>
				<li><input type="checkbox" name="jule" checked/> Jule</li>
				<li><input type="checkbox" name="gxp" checked/> GXP</li>
				<li><input type="checkbox" name="fhh" checked/> FHH</li>
			</ul> -->

			<h1>Adressliste</h1>
			<form action="addresspdf.php">
			<input type="hidden" name="mode" value="addresslist"/>
			<input type="hidden" name="addresslist" value="<?php echo $addressListHex?>"/>
			<ul>
				<li><select name="addressList" size="5" width="50"> 
				<?php
				$tok = strtok($addressList, "@");
				while ($tok !== false) {
				    echo "<option>" . $tok . "</option>";
				    $tok = strtok("@");
				}
				?>
				</select></li>
				<li><input type="button" name="emptyList" value="Reset" onclick="window.location.href='ldapmanager.php?filter=<?php echo $ldapFilterHex . "&detailcn=" . $detailcn; ?>'"> <input type="submit" value="Liste Drucken"/></li>
			</ul>
			</form>

		</div>

		<div class="clearer"><span></span></div>

	</div>

	<div class="footer">&copy; 2009 <a href="mailto:michael.pilgermann@gmx.de">Michael Pilgermann</a>. Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> &amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>. Template design by <a href="http://templates.arcsin.se">Arcsin</a>
	</div>

</div>

</body>

</html>


<?php
// Convert a hex-string to binary-string (the way back from bin2hex)

function hex2bin($h)
  {
  if (!is_string($h)) return null;
  $r='';
  for ($a=0; $a<strlen($h); $a+=2) { $r.=chr(hexdec($h{$a}.$h{($a+1)})); }
  return $r;
  }
?>
