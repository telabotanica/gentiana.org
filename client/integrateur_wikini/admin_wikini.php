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
// CVS : $Id: admin_wikini.php,v 1.9 2006-04-28 12:41:26 florian Exp $
/**
* Application gérant les Wikini associe à Papyrus
*
*@package Admin_Wikini
//Auteur original :
*@author        David Delon <david.delon@clapas.net>
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.9 $
// +------------------------------------------------------------------------------------------------------+
*/


// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

/** Inclusion des fonctions  de cette application.*/
require_once 'bibliotheque/iw_admin_wikini.fonct.php';


function afficherContenuCorpsHTML() {
	return admin_afficherContenuCorpsHTML();
}

function afficherContenuCorps()
{

	return admin_afficherContenuCorps();
}
// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: admin_wikini.php,v $
* Revision 1.9  2006-04-28 12:41:26  florian
* corrections erreurs chemin
*
* Revision 1.8  2005/11/14 10:14:30  ddelon
* Projets Wikini
*
* Revision 1.7  2005/10/21 20:55:06  ddelon
* todo wikini
*
* Revision 1.6  2005/09/30 07:48:35  ddelon
* Projet Wikini
*
* Revision 1.5  2005/09/09 09:37:17  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.4  2005/09/06 08:35:36  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.3  2005/09/02 11:29:25  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.2  2005/08/31 17:34:52  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.1  2005/08/25 08:59:12  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.4  2005/03/09 10:46:17  jpm
* Changement d'un nom de fichier.
*
* Revision 1.3  2005/03/09 10:40:26  alex
* version initiale
*
* Revision 1.2  2005/02/28 10:32:59  jpm
* Changement de nom de dossier.
*
* Revision 1.1  2004/12/13 18:07:19  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
