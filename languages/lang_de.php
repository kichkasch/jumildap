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
 
German language file
- all information defined in there should start with "ST_"
 

I. Main window
*/
 
$ST_DETAIL_WORKADDRESS = "Adresse (Arbeit)"; 
$ST_DETAIL_HOMEADDRESS = "Adresse (zu Hause)";
$ST_DETAIL_HOMEPHONE = "Telefon (zu Hause)";
$ST_DETAIL_WORKPHONE = "Telefon (Arbeit)";
$ST_DETAIL_MOBILEPHONE = "Telefon (Handy)";
$ST_DETAIL_HOMEPAGE = "Home page";

$ST_TOOLTIP_LABEL = "Paketaufdruck von dieser Adresse erstellen";
$ST_TOOLTIP_ADDTOLIST = "Zu Addressliste hinzuf&uuml;gen";
$ST_TOOLTIP_EMAIL = "Email an diese Adresse senden";
 
$ST_NAME_FILTER = "Namensfilter";
$ST_NAME = "Name";
$ST_FIRSTNAME = "Vorname";
$ST_APPLY_FILTER ="Filter anwenden";

$ST_ADDRESS_LIST = "Adressliste";
$ST_BUTTON_RESET = "Reset";
$ST_BUTTON_PRINTLIST = "Liste drucken";

/* !--
 
II. Address list creation (PDF)
 
*/
//$ST_ADDRESS_LIST = "Adressliste";	// defined on main window already

?>