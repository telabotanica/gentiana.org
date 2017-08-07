<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.3                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-consultation.                                                            |
// |                                                                                                      |
// | Foobar is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | Foobar is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: ef_config_bdd.inc.php,v 1.9 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Fichier de configuration de la base de données d'eFlore.
*
* Contient les constantes de connexion à la base de données d'eFlore.
*
*@package eflore
*@subpackage configuration
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.9 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// +------------------------------------------------------------------------------------------------------+
//Constante définissant le type de débogage désiré.
/** Constante définissant le type de débogage désiré dans l'API
 * Pas de débogage. Valeur : 0.*/ 
define('EF_DEBOG_AUCUN', 0);
/** Débogage du SQL. Valeur : 1*/
define('EF_DEBOG_SQL', 1);

// +------------------------------------------------------------------------------------------------------+
// Paramétrage de la valeur du DSN pour Pear DB.
/** Constante stockant le DSN permetant de se connecter à la base de données principale.*/
define('EF_DSN_PRINCIPAL', EF_BDD_PROTOCOLE.'://'.EF_BDD_UTILISATEUR.':'.EF_BDD_MOT_DE_PASSE.'@'.EF_BDD_SERVEUR.'/'.EF_BDD_NOM_PRINCIPALE);
/** Constante stockant le DSN permetant de se connecter à la base de données historique.*/
define('EF_DSN_HISTORIQUE', EF_BDD_PROTOCOLE.'://'.EF_BDD_UTILISATEUR.':'.EF_BDD_MOT_DE_PASSE.'@'.EF_BDD_SERVEUR.'/'.EF_BDD_NOM_HISTORIQUE);
$GLOBALS['_EFLORE_']['dsn'] = EF_DSN_PRINCIPAL;

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ef_config_bdd.inc.php,v $
* Revision 1.9  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.8  2005-12-21 15:11:13  jp_milcent
* Nouvelle gestion de la configuration.
*
* Revision 1.7  2005/12/15 16:01:21  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.6  2005/12/04 23:57:28  ddelon
* Recherche approchee
*
* Revision 1.5  2005/10/06 18:48:47  jp_milcent
* Modif
*
* Revision 1.4  2005/08/30 16:11:13  jp_milcent
* La recherche dans la classification fonctionne de manière récursive.
*
* Revision 1.3  2005/07/28 15:37:56  jp_milcent
* Début gestion des squelettes et de l'API eFlore.
*
* Revision 1.2  2005/07/26 16:27:29  jp_milcent
* Début mise en place framework eFlore.
*
* Revision 1.1  2005/07/26 09:19:05  jp_milcent
* Légère modif.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>