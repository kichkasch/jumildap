<?php
include 'config.php';

$action=$_REQUEST['action'];

switch($action) {
	case "addItem":
			$detail_name=$_REQUEST['familyName'];
			$detail_fistname=$_REQUEST['givenName'];
			
			$ds=ldap_connect($ldapHost, $ldapPort);  // must be a valid LDAP server! 
			if ($ds) {
				ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
				$r=ldap_bind($ds, $ldapWriteDN, $ldapWritePasswort);      
				
				   // prepare data
				   $info["sn"] = $detail_name;			//family name
				   $info["givenName"] = $detail_fistname;
				   $info["cn"] =  $info["givenName"] . " " . $info["sn"]; //display name
				   
					foreach ($_REQUEST as $key=>$value) {
						if( ( strcmp($key, "givenName"))  && ( strcmp($key, "familyName")) && ( strcmp($key, "action"))   ) {
							$info[$key] = $value;
						}
					}
				   
				   $info["objectclass"][0] = "inetOrgPerson";
				   $info["objectclass"][1] = "mozillaAbPersonAlpha";
				
					$dn = "cn=" . $info["cn"] . "," . $ldapWriteOU;
				
				ldap_add($ds, $dn, $info);
				
				ldap_unbind($ds);
			    echo "Sucess: " . $dn;
			} else {
			    echo "Unable to connect to LDAP server";
			}
			break;
	case "delItem":
			$del_distName = $_REQUEST['del_distName'];
			$ds=ldap_connect($ldapHost, $ldapPort);  // must be a valid LDAP server! 
			if ($ds) {
				ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
				$r=ldap_bind($ds, $ldapWriteDN, $ldapWritePasswort);  
				ldap_delete ($ds , $del_distName);			
				ldap_unbind($ds);
				echo "Sucess: ";
			} else {
			    echo "Unable to connect to LDAP server";
			}
			break;
	case "getEntryDetails":
			$details_distName = $_REQUEST['details_distName'];
			error_log("#DistName: " . $details_distName);
			$ds=ldap_connect($ldapHost, $ldapPort);  // must be a valid LDAP server! 
			if ($ds) {
				ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
				$r=ldap_bind($ds, $ldapWriteDN, $ldapWritePasswort);
				$cnTmp = ldap_explode_dn($details_distName,1);
				$cn = explode(" + ", $cnTmp[0]); 
				error_log("#DistName [0]: " . $cn[0]);
			   $sr=ldap_search($ds, $ldapDomain, "cn=" . $cn[0]);  
				$info = ldap_get_entries($ds, $sr);
    			for ($i=0; $i<$info["count"]; $i++) {
					echo json_encode($info[$i]);	
				}
				ldap_unbind($ds);
			} else {
			    echo "Unable to connect to LDAP server";
			}
			break;
	case "modifyItem":
			$mod_distName = $_REQUEST['mod_distName'];
			error_log($mod_distName);
			$detail_name=$_REQUEST['familyName'];
			$detail_fistname=$_REQUEST['givenName'];
			$ds=ldap_connect($ldapHost, $ldapPort);  // must be a valid LDAP server! 
			if ($ds) {
				ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
				$r=ldap_bind($ds, $ldapWriteDN, $ldapWritePasswort);  

				   // prepare data
				   $info["sn"] = $detail_name;			//family name
				   $info["givenName"] = $detail_fistname;
				   $info["cn"] =  $info["givenName"] . " " . $info["sn"]; //display name
				   
					foreach ($_REQUEST as $key=>$value) {
						if( ( strcmp($key, "givenName"))  && ( strcmp($key, "familyName")) && ( strcmp($key, "action")) && ( strcmp($key, "mod_distName"))  ) {
							//error_log("Key " . $key . "| Value " . $value);			
							$info[$key] = $value;
						}
					}
				   
				   $info["objectclass"][0] = "inetOrgPerson";
				   $info["objectclass"][1] = "mozillaAbPersonAlpha";
				
					$dn = $mod_distName;				
					//$dn = "cn=" . $info["cn"] . "," . $ldapWriteOU;

				ldap_modify($ds, $dn, $info);
				ldap_unbind($ds);
				echo "Sucess: ";
			} else {
			    echo "Unable to connect to LDAP server";
			}
			break;
			
}
?>