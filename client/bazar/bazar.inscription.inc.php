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
// CVS : $Id: bazar.inscription.inc.php,v 1.8 2007-07-04 10:06:21 alexandre_tb Exp $
/**
* 
*@package bazar
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Florian Schmitt <florian@ecole-et-nature.org>
//Autres auteurs :
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.8 $
// +------------------------------------------------------------------------------------------------------+
*/

// RAPPEL : On se situe dans la fonction afficherContenuCorps() de inscription.php 

// requete pour récupérer l'ensemble des type d'annonces
if (!file_exists (INS_CHEMIN_APPLI.'../bazar/bazar.inscription.local.php')) {
	$requete = 'SELECT bn_id_nature FROM bazar_nature WHERE 1' ;
	$resultat = $GLOBALS['ins_db']->query ($requete);
	$SQL = '' ;
	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
		$SQL .= '('.$id_utilisateur.', '.$ligne->bn_id_nature.', 1),' ;	
	}
	
	$SQL = substr ($SQL, 0, strlen ($SQL) - 1) ;
	
	$requete = 'INSERT INTO bazar_droits VALUES '.$SQL;
	
	$resultat = $GLOBALS['ins_db']->query($requete);
	if (DB::isError($resultat)) {
		$msg = $resultat->getMessage().$resultat->getDebugInfo() ;
	}
	unset($resultat) ;
} else {
	include_once INS_CHEMIN_APPLI.'../bazar/bazar.inscription.local.php';
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: bazar.inscription.inc.php,v $
* Revision 1.8  2007-07-04 10:06:21  alexandre_tb
* ajout d un appel a bazar.inscription.local.php s il existe, pour personnaliser les actions lors d une inscription.
*
* Revision 1.7  2007-06-01 13:51:09  alexandre_tb
* suppression de l echo en cas d erreur
* mise en place de $msg pour recuperer les erreurs
*
* Revision 1.6  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.4.2.1  2007/03/07 16:50:42  jp_milcent
* Mise en majuscule des mots réservés par SQL
*
* Revision 1.4  2006/12/01 13:23:17  florian
* integration annuaire backoffice
*
* Revision 1.3  2006/04/28 16:10:17  florian
* inscrit d'office tous les utilisateurs en rÃ©dacteur de fiches
*
* Revision 1.2  2006/03/29 13:06:07  alexandre_tb
* Code initial
*
* Revision 1.1  2005/09/29 16:14:17  alexandre_tb
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
