<?php
include 'config.php';
    
$detail_name=$_REQUEST['familyName'];
$detail_fistname=$_REQUEST['givenName'];
$detail_email=$_REQUEST['email'];
    
    
$ds=ldap_connect($ldapHost, $ldapPort);  // must be a valid LDAP server! 
if ($ds) {
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	$r=ldap_bind($ds, $ldapWriteDN, $ldapWritePasswort);      
	
	   // prepare data
	   $info["sn"] = $detail_name;			//family name
	   $info["givenName"] = $detail_fistname;
	   $info["cn"] =  $info["givenName"] . " " . $info["sn"]; //display name
	   $info["mail"] = $detail_email;
	   $info["objectclass"][0] = "inetOrgPerson";
	   $info["objectclass"][1] = "mozillaAbPersonAlpha";
	
		$dn = "cn=" . $info["cn"] . "," . $ldapWriteOU;
	
	ldap_add($ds, $dn, $info);
	
	ldap_unbind($ds);
    echo "Sucess: " . $dn;
} else {
    echo "Unable to connect to LDAP server";
}
?>