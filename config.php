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

/*
 
Apply your ldap settings here
 
*/
 
$ldapHost = "192.168.200.20";
$ldapPort = 389;
$ldapDomain = "dc=kichkasch,dc=local";

$ldapFilter = "mozillaCustom4=*";
$ldapSortAttribues = array('sn', 'givenname');

$ldapWriteDN = "cn=admin,dc=kichkasch,dc=local";
$ldapWritePasswort = "****";
$ldapWriteOU = "ou=people," . $ldapDomain;

/* Choose your language file - check languages directory for options */
include 'languages/lang_en.php'; 
/* include 'languages/lang_de.php';	*/
 
/* !--
 
end configuration
 
*/
?>