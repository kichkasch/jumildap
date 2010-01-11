<?php
/*
 
Apply your ldap settings here
 
*/
 
$ldapHost = "192.168.200.20";
$ldapPort = 389;
$ldapDomain = "dc=kichkasch,dc=local";

$ldapFilter = "mozillaCustom4=*";
$ldapSortAttribues = array('sn', 'givenname');

 
/* !--
 
end configuration
 
*/
?>