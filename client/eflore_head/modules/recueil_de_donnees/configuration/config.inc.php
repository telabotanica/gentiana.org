<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
// |                                                                                                      |
// | eflore_bp is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_bp is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: config.inc.php,v 1.4 2007-10-05 09:44:43 jp_milcent Exp $
/**
* eflore_bp - config.inc.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.4 $ $Date: 2007-10-05 09:44:43 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// +------------------------------------------------------------------------------------------------------+
// L'envoi de courriel
/** Constante stockant le nom du serveur smtp.*/
define('RDD_SMTP_HOTE', 'localhost');
/** Constante stockant l'adresse courriel du destinataire du message contenant les observations.*/
define('RDD_MAIL_A', 'mathias@tela-botanica.org');
/** Constante stockant l'adresse courriel de l'entête FROM du courriel.*/
define('RDD_MAIL_DE', 'reccueil_de_donnees@tela-botanica.org');
/** Constante stockant le sujet du courriel.*/
define('RDD_MAIL_SUJET', 'Recueil de données');

// +------------------------------------------------------------------------------------------------------+
// Gestion de GoogleMap
/** Variable globale stockant les clés utilisées pour l'API GoogleMap.*/
$GLOBALS['_RDD_']['gg_cles'] = array(
	'http://localhost/eflore_v3_bp/' => 'ABQIAAAAmkYJlo9YK7fbQHhf011nXRTmvt3fDk8wTSsiZISdElE7zEJmpxT0Iuqd9XfFlcPznZUb32GRFyM_dA',
	'http://162.38.234.1/eflore_v3_bp/' => 'ABQIAAAAmkYJlo9YK7fbQHhf011nXRStiHs76HBlMoH9TTYES_wq0uEllxTpLifncaxvCJbFra-cEbtsE0B9aQ');

// +------------------------------------------------------------------------------------------------------+
// Gestion des erreurs
/** Constante stockant l'adresse courriel du destinataire du message contenant les observations dont l'envoi de courriel a échoué.*/
define('RDD_MAIL_ERREUR_A', RDD_MAIL_A.', jpm@tela-botanica.org');
/** Constante stockant le sujet du courriel en cas d'erreur.*/
define('RDD_MAIL_ERREUR_SUJET', 'Recueil de données : ERREUR');

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: config.inc.php,v $
* Revision 1.4  2007-10-05 09:44:43  jp_milcent
* Utilisation d'un tableau pour gérer les clés GoogleMap.
*
* Revision 1.3  2007-10-04 16:59:06  jp_milcent
* Ajout d'une constante permettant de gérer le formulaire GoogleMap.
*
* Revision 1.2  2007-07-24 14:31:43  jp_milcent
* Ajout dans les fichiers de configuration de l'hôte smtp.
*
* Revision 1.1  2007-07-10 16:46:50  jp_milcent
* Ajout du fichier de config.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
