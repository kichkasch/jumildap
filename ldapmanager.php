<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
/* !--
JuMiLDAP - A Web-based LDAP browser
by Michael Pilgermann (kichkasch@gmx.de)
Copyright 2010 Michael Pilgermann
 
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
<!--<meta http-equiv="content-type" content="text/html; charset=UTF-32"/>-->
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/> 
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
    		var 
    			name = $( "#name" ),
            givenname = $( "#givenname" );
         
         <!-- map json identifiers to ldap schema names -->			
			fields_mapping = {
				"#email": "mail",
				"#nickname": "mozillaNickname",
				"#workphone": "telephoneNumber",
				"#homephone": "homePhone",
				"#fax": "facsimileTelephoneNumber",
				"#mobile": "mobile",
				"#streetHome": "mozillaHomeStreet",
				"#street2Home": "mozillaHomeStreet2",
				"#cityHome": "mozillaHomeLocalityName",
				"#stateHome": "mozillaHomeState",
				"#zipHome": "mozillaHomePostalCode",
				"#countryHome": "mozillaHomeCountryName",
				"#titleBusiness": "title",
				"#depBusiness": "ou",
				"#orgBusiness": "o",
				"#streetBusiness": "street",
				"#street2Business": "mozillaWorkStreet2",
				"#cityBusiness": "l",
				"#stateBusiness": "st",
				"#zipBusiness": "postalCode",
				"#countryBusiness": "c",
				"#otherWeb": "mozillaHomeUrl",
				"#otherDesc": "description"
				};

		  $( "input[type=submit], button, input[type=button]" )
		      .button();
		  $( "#otherGroupCB").buttonset();
		  $( "#otherGroupCB1").buttonset();
            
        $( "#dialogAdd" ).dialog({ 
            resizable: false,
        		autoOpen: false,
				height: 600,
            width: 500,				
            modal: true,       		
            buttons: {
                "Create this entry": function() {
                			parameters = {
                					"action": "addItem",
								  		"familyName": name.val(),
								  		"givenName": givenname.val()
								  		};
								for (key in fields_mapping){
									if ($("" + key).val()){
										parameters[fields_mapping[key]] = $("" + key).val();
									}
								}
								stGroups = "";
								if ($('#checkGroup1').attr('checked')) {
									stGroups = stGroups + 'jule,'; 
								}
								if ($('#checkGroup2').attr('checked')) {
									stGroups = stGroups + 'micha,'; 
								}
								if ($('#checkGroup3').attr('checked')) {
									stGroups = stGroups + 'fhh,'; 
								}
								if ($('#checkGroup4').attr('checked')) {
									stGroups = stGroups + 'gxp,'; 
								}
								if (stGroups){
									parameters['mozillaCustom4'] = stGroups;
								}
								$.ajax({
								  url: "ldap_mods.php",
								  data: parameters
								}).done(function(data) {
		                    window.location.reload(true);
								});                			
                	
                        $( this ).dialog( "close" );
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            open: function() {
               $('#tabs_fields').tabs();
                
            }            
       });

        $( "#dialogChange" ).dialog({ 
            resizable: false,
        		autoOpen: false,
				height: 600,
            width: 500,				
            modal: true,       		
            buttons: {
                "Modify this entry": function() {
                			parameters = {
                					"action": "modifyItem",
								  		"familyName": name1.val(),
								  		"givenName": givenname1.val()
//								  		"familyName": "Test",
//								  		"givenName": "Aanton"
								  		};
								for (key in fields_mapping){
									if ($("" + key + "1").val()){
										parameters[fields_mapping[key]] = $("" + key + "1").val();
									}
								}
								stGroups = "";
								if ($('#checkGroup11').attr('checked')) {
									stGroups = stGroups + 'jule,'; 
								}
								if ($('#checkGroup12').attr('checked')) {
									stGroups = stGroups + 'micha,'; 
								}
								if ($('#checkGroup13').attr('checked')) {
									stGroups = stGroups + 'fhh,'; 
								}
								if ($('#checkGroup14').attr('checked')) {
									stGroups = stGroups + 'gxp,'; 
								}
								if (stGroups){
									parameters['mozillaCustom4'] = stGroups;
								}
								$.ajax({
								  url: "ldap_mods.php",
								  data: parameters
								}).done(function(data) {
		                    window.location.reload(true);
								});                			
                	
                        $( this ).dialog( "close" );
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            open: function() {
            	$('#name1').val('Test');
            	$('#givenname1').val('Aanton')
               $('#tabs_fields1').tabs();
                
            }            
       });

       
       $( "#dialogConfirmDelete").dialog({
            resizable: false,
        		autoOpen: false,
            height:180,
            modal: true,
            buttons: {
                "Delete this item": function() {
								$.ajax({
								  url: "ldap_mods.php",
								  data: {"action": "delItem", "del_distName": $(this).dialog("option", "distName")}
								}).done(function(data) {
		                    window.location.reload(true);
								});                			
                	
                    $( this ).dialog( "close" );
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            open: function() {
                $('#dialogDeleteSt').text($(this).dialog("option", "detailcn") );
            }                        
       });
    });
    </script>

</head>
<body>

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
$distName = "";

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
	 	$distName = $info[$i]["dn"];
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
	if ($info[$i]["mail"]){	
		if ($info[$i]["mail"][0]) 
			echo "<div class='descr'>" . $info[$i]["mail"][0] . "</div>";
	}
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
			<div style="margin:10pt;">
			<button id="bAdd" onclick="$( '#dialogAdd').dialog( 'open' );" style="width:100%;">Add new entry</button>
			<button id="bChange" onclick="$( '#dialogChange').dialog( 'open' );"style="width:100%;">Change active entry</button>
			<?php
			echo "<button id=\"bDelete\" onclick=\"$('#dialogConfirmDelete').dialog( 'option', 'distName', '" . $distName . "' ); $('#dialogConfirmDelete').dialog( 'option', 'detailcn', '" . $detailcn . "' ); $( '#dialogConfirmDelete').dialog( 'open' );\" style=\"width:100%;\">";
			?>
			Delete active entry</button> 
			
			</div>
			
			<div id="dialogAdd" title="Create new address book entry">
				<div id="tabs_fields">
					    <ul>
					      <li><a href="#tab-name">Name</a></li>
					      <li><a href="#tab-phone">Phone</a></li>
					      <li><a href="#tab-personal">Personal details</a></li>
					      <li><a href="#tab-business">Business details</a></li>
					      <li><a href="#tab-grouping">Misc</a></li>
					    </ul>
					    <div id="tab-name">
						    <form>
						    <fieldset>
						        <label for="givenname">Given name</label>
						        <input type="text" name="givenname" id="givenname" class="text ui-widget-content ui-corner-all" />
						        <label for="name">Family name</label>
						        <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
						        <label for="nickname">Nick name</label>
						        <input type="text" name="nickname" id="nickname" class="text ui-widget-content ui-corner-all" />
						        <label for="email">Email</label>
						        <input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all" />
						    </fieldset>
						    </form>			
					    </div>
					    <div id="tab-phone">
						    <form>
						    <fieldset>
						        <label for="workphone">Work phone</label>
						        <input type="text" name="workphone" id="workphone" class="text ui-widget-content ui-corner-all" />
						        <label for="homephone">Home phone</label>
						        <input type="text" name="homephone" id="homephone" class="text ui-widget-content ui-corner-all" />
						        <label for="fax">Fax</label>
						        <input type="text" name="fax" id="fax" class="text ui-widget-content ui-corner-all" />
						        <label for="mobile">Mobile phone</label>
						        <input type="text" name="mobile" id="mobile" value="" class="text ui-widget-content ui-corner-all" />
						    </fieldset>
						    </form>			
					    </div>
					    <div id="tab-personal">
						    <form>
						    <fieldset>
						        <label for="streetHome">Street</label>
						        <input type="text" name="streetHome" id="streetHome" class="text ui-widget-content ui-corner-all" />
						        <label for="street2Home">Street (more)</label>
						        <input type="text" name="street2Home" id="street2Home" class="text ui-widget-content ui-corner-all" />
						        <label for="cityHome">City (Locality)</label>
						        <input type="text" name="cityHome" id="cityHome" class="text ui-widget-content ui-corner-all" />
						        <label for="stateHome">State</label>
						        <input type="text" name="stateHome" id="stateHome" value="" class="text ui-widget-content ui-corner-all" />
						        <label for="zipHome">Zip code</label>
						        <input type="text" name="zipHome" id="zipHome" value="" class="text ui-widget-content ui-corner-all" />
						        <label for="countryHome">Country</label>
						        <input type="text" name="countryHome" id="countryHome" value="" class="text ui-widget-content ui-corner-all" />
						    </fieldset>
						    </form>			
					    </div>
					    <div id="tab-business">
						    <form>
						    <fieldset>
						        <label for="titleBusiness">Title/Position</label>
						        <input type="text" name="titleBusiness" id="titleBusiness" class="text ui-widget-content ui-corner-all" />
						        <label for="depBusiness">Department</label>
						        <input type="text" name="depBusiness" id="depBusiness" class="text ui-widget-content ui-corner-all" />
						        <label for="orgBusiness">Organizsation</label>
						        <input type="text" name="orgBusiness" id="orgBusiness" class="text ui-widget-content ui-corner-all" />
						        <label for="streetBusiness">Street</label>
						        <input type="text" name="streetBusiness" id="streetBusiness" class="text ui-widget-content ui-corner-all" />
						        <label for="street2Business">Street (more)</label>
						        <input type="text" name="street2Business" id="street2Business" class="text ui-widget-content ui-corner-all" />
						        <label for="cityBusiness">City (Locality)</label>
						        <input type="text" name="cityBusiness" id="cityBusiness" class="text ui-widget-content ui-corner-all" />
						        <label for="stateBusiness">State</label>
						        <input type="text" name="stateBusiness" id="stateBusiness" value="" class="text ui-widget-content ui-corner-all" />
						        <label for="zipBusiness">Zip code</label>
						        <input type="text" name="zipBusiness" id="zipBusiness" value="" class="text ui-widget-content ui-corner-all" />
						        <label for="countryBusiness">Country</label>
						        <input type="text" name="countryBusiness" id="countryBusiness" value="" class="text ui-widget-content ui-corner-all" />
						    </fieldset>
						    </form>			
					    </div>
					    <div id="tab-grouping">
						    <form>
						    <fieldset>
						        <label for="otherWeb">Web site</label>
						        <input type="text" name="otherWeb" id="otherWeb" class="text ui-widget-content ui-corner-all" />
						        <label for="otherDesc">Description</label>
						        <input type="text" name="otherDesc" id="otherDesc" class="text ui-widget-content ui-corner-all" />
						        <label for="otherGroupCB">Groups</label>
									<div id="otherGroupCB">
									    <input type="checkbox" id="checkGroup1" checked="checked"/><label for="checkGroup1">jule</label>
									    <input type="checkbox" id="checkGroup2" checked="checked"/><label for="checkGroup2">micha</label>
									    <input type="checkbox" id="checkGroup3" /><label for="checkGroup3">fhh</label>
									    <input type="checkbox" id="checkGroup4" checked="checked"/><label for="checkGroup4">gxp</label>
									</div>
						    </fieldset>
						    </form>			
					    </div>
				
									
				</div>
		   </div> <!-- dialogAdd -->
		   
		   <div id="dialogConfirmDelete" title="Delete active entry">
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Item <span id="dialogDeleteSt">...</span> will be deleted. Please confirm.</p>
			</div>

			<div id="dialogChange" title="Modify active address book entry">
				<div id="tabs_fields1">
					    <ul>
					      <li><a href="#tab-name1">Name</a></li>
					      <li><a href="#tab-phone1">Phone</a></li>
					      <li><a href="#tab-personal1">Personal details</a></li>
					      <li><a href="#tab-business1">Business details</a></li>
					      <li><a href="#tab-grouping1">Misc</a></li>
					    </ul>
					    <div id="tab-name1">
						    <form>
						    <fieldset>
						        <label for="givenname1">Given name</label>
						        <input type="text" name="givenname1" id="givenname1" class="text ui-widget-content ui-corner-all" readonly/>
						        <label for="name1">Family name</label>
						        <input type="text" name="name1" id="name1" class="text ui-widget-content ui-corner-all" readonly/>
						        <label for="nickname1">Nick name</label>
						        <input type="text" name="nickname1" id="nickname1" class="text ui-widget-content ui-corner-all" />
						        <label for="email1">Email</label>
						        <input type="text" name="email1" id="email1" value="" class="text ui-widget-content ui-corner-all" />
						    </fieldset>
						    </form>			
					    </div>
					    <div id="tab-phone1">
						    <form>
						    <fieldset>
						        <label for="workphone1">Work phone</label>
						        <input type="text" name="workphone1" id="workphone1" class="text ui-widget-content ui-corner-all" />
						        <label for="homephone1">Home phone</label>
						        <input type="text" name="homephone1" id="homephone1" class="text ui-widget-content ui-corner-all" />
						        <label for="fax1">Fax</label>
						        <input type="text" name="fax1" id="fax1" class="text ui-widget-content ui-corner-all" />
						        <label for="mobile1">Mobile phone</label>
						        <input type="text" name="mobile1" id="mobile1" value="" class="text ui-widget-content ui-corner-all" />
						    </fieldset>
						    </form>			
					    </div>
					    <div id="tab-personal1">
						    <form>
						    <fieldset>
						        <label for="streetHome1">Street</label>
						        <input type="text" name="streetHome1" id="streetHome1" class="text ui-widget-content ui-corner-all" />
						        <label for="street2Home1">Street (more)</label>
						        <input type="text" name="street2Home1" id="street2Home1" class="text ui-widget-content ui-corner-all" />
						        <label for="cityHome1">City (Locality)</label>
						        <input type="text" name="cityHome1" id="cityHome1" class="text ui-widget-content ui-corner-all" />
						        <label for="stateHome1">State</label>
						        <input type="text" name="stateHome1" id="stateHome1" value="" class="text ui-widget-content ui-corner-all" />
						        <label for="zipHome1">Zip code</label>
						        <input type="text" name="zipHome1" id="zipHome1" value="" class="text ui-widget-content ui-corner-all" />
						        <label for="countryHome1">Country</label>
						        <input type="text" name="countryHome1" id="countryHome1" value="" class="text ui-widget-content ui-corner-all" />
						    </fieldset>
						    </form>			
					    </div>
					    <div id="tab-business1">
						    <form>
						    <fieldset>
						        <label for="titleBusiness1">Title/Position</label>
						        <input type="text" name="titleBusiness1" id="titleBusiness1" class="text ui-widget-content ui-corner-all" />
						        <label for="depBusiness1">Department</label>
						        <input type="text" name="depBusiness1" id="depBusiness1" class="text ui-widget-content ui-corner-all" />
						        <label for="orgBusiness1">Organizsation</label>
						        <input type="text" name="orgBusiness1" id="orgBusiness1" class="text ui-widget-content ui-corner-all" />
						        <label for="streetBusiness1">Street</label>
						        <input type="text" name="streetBusiness1" id="streetBusiness1" class="text ui-widget-content ui-corner-all" />
						        <label for="street2Business1">Street (more)</label>
						        <input type="text" name="street2Business1" id="street2Business1" class="text ui-widget-content ui-corner-all" />
						        <label for="cityBusiness1">City (Locality)</label>
						        <input type="text" name="cityBusiness1" id="cityBusiness1" class="text ui-widget-content ui-corner-all" />
						        <label for="stateBusiness1">State</label>
						        <input type="text" name="stateBusiness1" id="stateBusiness1" value="" class="text ui-widget-content ui-corner-all" />
						        <label for="zipBusiness1">Zip code</label>
						        <input type="text" name="zipBusiness1" id="zipBusiness1" value="" class="text ui-widget-content ui-corner-all" />
						        <label for="countryBusiness1">Country</label>
						        <input type="text" name="countryBusiness1" id="countryBusiness1" value="" class="text ui-widget-content ui-corner-all" />
						    </fieldset>
						    </form>			
					    </div>
					    <div id="tab-grouping1">
						    <form>
						    <fieldset>
						        <label for="otherWeb1">Web site</label>
						        <input type="text" name="otherWeb1" id="otherWeb1" class="text ui-widget-content ui-corner-all" />
						        <label for="otherDesc1">Description</label>
						        <input type="text" name="otherDesc1" id="otherDesc1" class="text ui-widget-content ui-corner-all" />
						        <label for="otherGroupCB1">Groups</label>
									<div id="otherGroupCB1">
									    <input type="checkbox" id="checkGroup11" checked="checked"/><label for="checkGroup11">jule</label>
									    <input type="checkbox" id="checkGroup12" checked="checked"/><label for="checkGroup12">micha</label>
									    <input type="checkbox" id="checkGroup13" /><label for="checkGroup13">fhh</label>
									    <input type="checkbox" id="checkGroup14" checked="checked"/><label for="checkGroup14">gxp</label>
									</div>
						    </fieldset>
						    </form>			
					    </div>
				
									
				</div>
		   </div> <!-- dialogChange -->

		</div>

		<div class="clearer"><span></span></div>

	</div>

	<div class="footer">&copy; 2010 <a href="mailto:kichkasch@gmx.de">Michael Pilgermann</a>. Valid <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> &amp; <a href="http://validator.w3.org/check?uri=referer">XHTML</a>. Template design by <a href="http://templates.arcsin.se">Arcsin</a>
	</div>

</div>

</body>

</html>
