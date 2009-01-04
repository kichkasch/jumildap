<?php
// basic sequence with LDAP is connect, bind, search, interpret search
// result, close connection

echo "<h3>LDAP query test</h3>";
echo "Connecting ...";
$ds=ldap_connect("192.168.200.20", 389);  // must be a valid LDAP server!
echo "connect result is " . $ds . "<br />";

if (ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) {
echo "Using LDAPv3";
} else {
echo "Failed to set protocol version to 3";
}


if ($ds) { 
    echo "Binding ..."; 
    $r=ldap_bind($ds);     // this is an "anonymous" bind, typically
                           // read-only access
    echo "Bind result is " . $r . "<br />";

    echo "Searching for gxp entries ...";
    $sr=ldap_search($ds, "dc=kichkasch,dc=local", "mozillaCustom4=*gxp*");  
    echo "Search result is " . $sr . "<br />";

    echo "Number of entires returned is " . ldap_count_entries($ds, $sr) . "<br />";

    echo "Getting entries ...<p>";
    $info = ldap_get_entries($ds, $sr);
    echo "Data for " . $info["count"] . " items returned:<p>";

    for ($i=0; $i<$info["count"]; $i++) {
        //echo "dn is: " . $info[$i]["dn"] . "<br />";
        //echo "first cn entry is: " . $info[$i]["cn"][0] . "<br />";
        //echo "first email entry is: " . $info[$i]["mail"][0] . "<br />";
	echo "First Name: " . $info[$i]["givenname"][0] . " -- Last Name: " . $info[$i]["sn"][0] . "<br />";
	if ($info[$i]["homephone"][0]) 
		echo "home phone number is: " . $info[$i]["homephone"][0] . "<br />";
	if ($info[$i]["telephonenumber"][0]) 
		echo "work phone number is: " . $info[$i]["telephonenumber"][0] . "<br />";
	if ($info[$i]["mobile"][0]) 
		echo "mobile number is: " . $info[$i]["mobile"][0] . "<br />";

	echo "<hr />";
    }

    echo "Closing connection";
    ldap_close($ds);

} else {
    echo "<h4>Unable to connect to LDAP server</h4>";
}
?>

