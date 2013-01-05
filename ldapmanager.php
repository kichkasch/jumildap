<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
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
?>

<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-32"/>
<!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/> -->
<meta name="description" content="description"/>
<meta name="keywords" content="keywords"/> 
<meta name="author" content="Michael" /> 
<link rel="stylesheet" type="text/css" href="default.css" media="screen"/>

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
    <style>
        label, input { display:block; }
        input.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        div#users-contain { width: 350px; margin: 20px 0; }
        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
    </style>
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

<title>JuMiLDAP Manager</title>

    <script>
    $(function() {
    	var name = $( "#name" ),
            givenname = $( "#givenname" ),
            email = $( "#email" );
            
        $( "#dialogAdd" ).dialog({ 
        		autoOpen: false,
				height: 400,
            width: 400,				
            modal: true,       		
            buttons: {
                "Create this account": function() {
								$.ajax({
								  url: "ldap_mods.php",
								  data: {
								  		"familyName": name.val(),
								  		"givenName": givenname.val(),
								  		"email": email.val()
								  		}
								}).done(function(data) {
								  alert("OK");
								});                			
                	
                        $( this ).dialog( "close" );
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
       });
    });
    </script>

</head>

<?php
include 'config.php';
include 'tools.php';

/* Evaluate parameters */
$detailcn=$_REQUEST['detailcn'];
$filter=$_REQUEST['filter'];
$namefilter=$_REQUEST['namefilter'];
$addressList=$_REQUEST['addresslist'];
$addressListItem=$_REQUEST['addresslistitem'];


if ((isset ($filter)) && (! empty ($filter)))
{
	$ldapFilter = hex2bin($filter); /* hex encoding of filter allows for special characters in filter to be passed on through URL*/
}

if ((isset ($namefilter)) && (! empty ($namefilter)))
{
	$surName = $_REQUEST['surname'];
	$firstName = $_REQUEST['firstname'];
	$ldapFilter = "(&(sn=". $surName .")(givenname=". $firstName ."))";
}
$ldapFilterHex = bin2hex($ldapFilter); /* hex encoding of filter allows for special characters in filter to be passed on through URL*/

if ((isset ($addressList)) && (! empty ($addressList)))
{
	$addressList = hex2bin($addressList);
} else {
	$addressList = "";
} 

if ((isset ($addressListItem)) && (! empty ($addressListItem)))
{
	if ($addressList == "")
		$addressList = $addressListItem;
	else
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

	 foreach ($ldapSortAttribues as $sortAtt) {
	 	ldap_sort($ds, $sr, $sortAtt);
	 }

/*    ldap_sort($ds, $sr, "sn");
    ldap_sort($ds, $sr, "givenname"); */

    $info = ldap_get_entries($ds, $sr);

    for ($i=0; $i<$info["count"]; $i++) {
	 if ((isset ($detailcn)) && (! empty ($detailcn)) && (! strcmp($detailcn, $info[$i]["cn"][0])) ){
		echo "<hr/>";		
		echo "<h1><a href='ldapmanager.php?filter=" . $ldapFilterHex . "&detailcn=" . $info[$i]["cn"][0] . "&addresslist=" . $addressListHex . "'>" . $info[$i]["title"][0] . " " . $info[$i]["givenname"][0] . " " . $info[$i]["sn"][0] . "</a> <a href='ldapmanager.php?filter=" . $ldapFilterHex . "&detailcn=" . $detailcn . "&addresslist=" . $addressListHex . "&addresslistitem=" . $info[$i]["cn"][0] .  "'><img src='img/liste.png' height='15' title='" . $ST_TOOLTIP_ADDTOLIST . "'/></a></h1>";
		print "<code>";
		if ($info[$i]["mail"][0]) 
			echo "<a href='mailto:" . $info[$i]["mail"][0] . "'>" . $info[$i]["mail"][0] . " <img src='img/email.png' height='15' title='" . $ST_TOOLTIP_EMAIL . "'/></a>\n\n";
		if ($info[$i]["homephone"][0])
			print $ST_DETAIL_HOMEPHONE . ": ". $info[$i]["homephone"][0] . "\n";
		if ($info[$i]["telephonenumber"][0])
			print $ST_DETAIL_WORKPHONE . ": ". $info[$i]["telephonenumber"][0] . "\n";
		if ($info[$i]["mobile"][0])
			print $ST_DETAIL_MOBILEPHONE . ": ". $info[$i]["mobile"][0] . "\n";
		print "\n";
		if ($info[$i]["mozillahomelocalityname"][0])
		{
		print "<b>" . $ST_DETAIL_HOMEADDRESS . "</b><a href='addresspdf.php?line1=" . $info[$i]["cn"][0] . "&line2=" . $info[$i]["mozillahomestreet"][0] . "&line3=" . $info[$i]["mozillahomepostalcode"][0] . " " .  $info[$i]["mozillahomelocalityname"][0] . "&line4=" . $info[$i]["mozillahomecountryname"][0]  . "'><img src='img/pdf_icon.gif' height='15' title='" . $ST_TOOLTIP_LABEL . "'></a>\n";
		if ($info[$i]["mozillahomestreet"][0])
			print $info[$i]["mozillahomestreet"][0] . "\n";
		if ($info[$i]["mozillahomepostalcode"][0])
			print $info[$i]["mozillahomepostalcode"][0] . " ";
		if ($info[$i]["mozillahomelocalityname"][0])
			print $info[$i]["mozillahomelocalityname"][0] . "\n";
		if ($info[$i]["mozillahomecountryname"][0])
			print $info[$i]["mozillahomecountryname"][0] . "\n";
		print "<br/>";
		}


		if ($info[$i]["l"][0])
		{ // business address
		if ($info[$i]["title"][0])
		{
			$title = $info[$i]["title"][0] . " ";
		} else {
			$title = "";
		}
		print "<b>" . $ST_DETAIL_WORKADDRESS . "</b><a href='addresspdf.php?line1=" . $title . $info[$i]["cn"][0] . "&line2=" . $info[$i]["o"][0] . "&line3=" . $info[$i]["street"][0] . "&line4=" . $info[$i]["postalcode"][0] . " " .  $info[$i]["l"][0] . "&line5=" . $info[$i]["c"][0]  . "'><img src='img/pdf_icon.gif' height='15' title='" . $ST_TOOLTIP_LABEL . "'></a>\n";
		if ($info[$i]["o"][0])
			print $info[$i]["o"][0] . "\n";
		if ($info[$i]["street"][0])
			print $info[$i]["street"][0] . "\n";
		if ($info[$i]["postalcode"][0])
			print $info[$i]["postalcode"][0] . " ";
		if ($info[$i]["l"][0])
			print $info[$i]["l"][0] . "\n";
		if ($info[$i]["c"][0])
			print $info[$i]["c"][0] . "\n";
		}

		if ($info[$i]["mozillahomeurl"][0])
		{
			print "\n" . $ST_DETAIL_HOMEPAGE . ": <a href='http://". $info[$i]["mozillahomeurl"][0] . "'>". $info[$i]["mozillahomeurl"][0] . "</a>\n";
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

			<h1><?php echo $ST_NAME_FILTER ?></h1>
			<form action="ldapmanager.php">
			<input type="hidden" name="namefilter" value="1"/>
			<input type="hidden" name="addresslist" value="<?php echo $addressListHex?>"/>
			<ul>
				<li><?php echo $ST_NAME ?><br/><input name="surname" value="*"/></li>
				<li><?php echo $ST_FIRSTNAME ?><br/><input name="firstname" value="*"/></li>
				<li><input type="submit" value="<?php echo $ST_APPLY_FILTER ?>"/></li>
			</ul>
			</form>


			<h1><?php echo $ST_ADDRESS_LIST ?></h1>
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
				<li><input type="button" name="emptyList" value="<?php echo $ST_BUTTON_RESET ?>" onclick="window.location.href='ldapmanager.php?filter=<?php echo $ldapFilterHex . "&detailcn=" . $detailcn; ?>'"> <input type="submit" value="<?php echo $ST_BUTTON_PRINTLIST ?>"/></li>
			</ul>
			</form>
			
			<h1>Modifications</h1>
			<input type="button" value="Add new entry to address book"/ onclick="$( '#dialogAdd').dialog( 'open' );" >			
			<div id="dialogAdd" title="Create new address book entry">
		    <form>
		    <fieldset>
		        <label for="givenname">Given Name</label>
		        <input type="text" name="givenname" id="givenname" class="text ui-widget-content ui-corner-all" />
		        <label for="name">Family Name</label>
		        <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
		        <label for="email">Email</label>
		        <input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all" />
		    </fieldset>
		    </form>			
    </div>

		</div>

		<div class="clearer"><span></span></div>

	</div>

	<div class="footer">&copy; 2010 <a href="mailto:kichkasch@gmx.de">Michael Pilgermann</a>. Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> &amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>. Template design by <a href="http://templates.arcsin.se">Arcsin</a>
	</div>

</div>

</body>

</html>
