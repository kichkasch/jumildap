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
 
English language file
- all information defined in there should start with "ST_"
 

I. Main window
*/

$ST_DETAIL_WORKADDRESS = "address (work)"; 
$ST_DETAIL_HOMEADDRESS = "address (home)";
$ST_DETAIL_HOMEPHONE = "phone (home)";
$ST_DETAIL_WORKPHONE = "phone (work)";
$ST_DETAIL_MOBILEPHONE = "phone (mobile)";
$ST_DETAIL_HOMEPAGE = "home page";

$ST_TOOLTIP_LABEL = "Create label for postal packet from this address";
$ST_TOOLTIP_ADDTOLIST = "add this address to address list";
$ST_TOOLTIP_EMAIL = "send email to this address"; 
 
$ST_NAME_FILTER = "name filter";
$ST_NAME = "name";
$ST_FIRSTNAME = "given name";
$ST_APPLY_FILTER ="apply filter";

$ST_ADDRESS_LIST = "adress list";
$ST_BUTTON_RESET = "reset";
$ST_BUTTON_PRINTLIST = "print list";

/* !--
 
II. Address list creation (PDF)
 
*/
//$ST_ADDRESS_LIST = "Adressliste";	// defined on main window already

?>