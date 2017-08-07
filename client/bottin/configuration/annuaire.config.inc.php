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
// CVS : $Id: annuaire.config.inc.php,v 1.2 2006/04/04 12:23:05 florian Exp $
/**
* Fichier de configuration de l'annuaire
*
* A éditer de façon spécifique à chaque déploiement
*
*@package inscription
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.2 $
// +------------------------------------------------------------------------------------------------------+
*/
//include_once INS_CHEMIN_APPLI.'langues/annuaire.langue.'.INS_LANGUE_DEFAUT.'.inc.php'; //appel du fichier de constantes des langues
define ('INS_NECESSITE_LOGIN', 0) ;     // Precise si les infos sont visibles pour tous (mettre 0) ou pour les identifies seulement (mettre 1)


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: annuaire.config.inc.php,v $
* Revision 1.2  2006/04/04 12:23:05  florian
* modifs affichage fiches, gÃ©nÃ©ricitÃ© de la carto, modification totale de l'appli annuaire
*
* Revision 1.1  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.4  2005/09/22 13:30:49  florian
* modifs pour compatibilitÃ© XHTML Strict + corrections de bugs (mais ya encore du boulot!!)
*
* Revision 1.3  2005/03/24 08:46:29  alex
* version initiale
*
* Revision 1.2  2005/03/08 09:43:34  alex
* --
*
* Revision 1.1.1.1  2005/01/03 17:27:49  alex
* Import initial
*
* Revision 1.1  2005/01/03 17:19:20  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>