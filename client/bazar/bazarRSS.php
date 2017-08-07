<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or                                        |
// | modify it under the terms of the GNU Lesser General Public                                           |
// | License as published by the Free Software Foundation; either                                         |
// | version 2.1 of the License, or (at your option) any later version.                                   |
// |                                                                                                      |
// | This library is distributed in the hope that it will be useful,                                      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU                                    |
// | Lesser General Public License for more details.                                                      |
// |                                                                                                      |
// | You should have received a copy of the GNU Lesser General Public                                     |
// | License along with this library; if not, write to the Free Software                                  |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: bazarRSS.php,v 1.7 2007-04-11 08:30:12 neiluj Exp $
/**
* Générateur de flux RSS à partir du bazar 
*
*@package bazar
//Auteur original :
*@author        Florian SCHMITT <florian@ecole-et-nature.org>
*@author        Alexandre Granier <alexandre@tela-botanica.org>
*
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.7 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

include_once 'configuration/baz_config.inc.php'; //fichier de configuration de Bazar
include_once 'bibliotheque/bazar.fonct.rss.php'; //fichier des fonctions RSS de Bazar

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS DU PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

if (isset($_GET['annonce'])) { 
	$annonce=$_GET['annonce'];
}
else {
	$annonce='';
}

if (isset($_GET['categorie_nature'])) { 
	$categorie_nature=$_GET['categorie_nature'];
}
else {
	$categorie_nature='';
}

if (isset($_GET['nbitem'])) { 
	$nbitem=$_GET['nbitem'];
}
else {
	$nbitem='';
}

if (isset($_GET['emetteur'])) { 
	$emetteur=$_GET['emetteur'];
}
else {
	$emetteur='';
}

if (isset($_GET['valide'])) { 
	$valide=$_GET['valide'];
}
else {
	$valide=1;
}

if (isset($_GET['sql'])) { 
	$requeteSQL=$_GET['sql'];
}
else {
	$requeteSQL='';
}

echo html_entity_decode(gen_RSS($annonce, $nbitem, $emetteur, $valide, $requeteSQL, '', '', $categorie_nature));


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: bazarRSS.php,v $
* Revision 1.7  2007-04-11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.4  2006/05/19 13:54:32  florian
* stabilisation du moteur de recherche, corrections bugs, lien recherche avancee
*
* Revision 1.3  2005/07/21 19:03:12  florian
* nouveautÃ©s bazar: templates fiches, correction de bugs, ...
*
* Revision 1.1.1.1  2005/02/17 18:05:11  florian
* Import initial de Bazar
*
* Revision 1.1.1.1  2005/02/17 11:09:50  florian
* Import initial
*
* Revision 1.1.1.1  2005/02/16 18:06:35  florian
* import de la nouvelle version
*
* Revision 1.3  2004/07/08 15:06:48  alex
* modification de la date
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/

?>
