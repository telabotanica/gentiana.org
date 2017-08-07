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
// CVS : $Id: config.gentiana.inc.php,v 1.6 2007-10-05 09:44:43 jp_milcent Exp $
/**
* eflore_bp - config.gentiana.inc.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.6 $ $Date: 2007-10-05 09:44:43 $
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
define('RDD_MAIL_A', 'Pierre SALEN <p.salen@gentiana.org>, Mathias CHOUET <mathias@tela-botanica.org>');
/** Constante stockant l'adresse courriel de l'entête FROM du courriel.*/
define('RDD_MAIL_DE', 'recueil_de_donnees@tela-botanica.org');
/** Constante stockant le sujet du courriel.*/
define('RDD_MAIL_SUJET', 'Recueil de données');

// +------------------------------------------------------------------------------------------------------+
// Gestion de GoogleMap
/** Variable globale stockant les clés utilisées pour l'API GoogleMap.*/
$GLOBALS['_RDD_']['gg_cles'] = array(
	'http://localhost/eflore_v3_bp/' => 'ABQIAAAAmkYJlo9YK7fbQHhf011nXRTmvt3fDk8wTSsiZISdElE7zEJmpxT0Iuqd9XfFlcPznZUb32GRFyM_dA',
	'http://162.38.234.1/eflore_v3_bp/' => 'ABQIAAAAmkYJlo9YK7fbQHhf011nXRStiHs76HBlMoH9TTYES_wq0uEllxTpLifncaxvCJbFra-cEbtsE0B9aQ',
	'http://www.gentiana.org/' => 'ABQIAAAAmkYJlo9YK7fbQHhf011nXRR1SweJvhVSDQQ0_rm1Oa8_uxHFlhTZ-ZF67u_nQiSreBuuvDGrnYj9sQ',
	'http://gentiana.org/' => 'ABQIAAAAmkYJlo9YK7fbQHhf011nXRR1SweJvhVSDQQ0_rm1Oa8_uxHFlhTZ-ZF67u_nQiSreBuuvDGrnYj9sQ');

// +------------------------------------------------------------------------------------------------------+
// Gestion des erreurs
/** Constante stockant l'adresse courriel du destinataire du message contenant les observations dont l'envoi de courriel a échoué.*/
define('RDD_MAIL_ERREUR_A', RDD_MAIL_A);
/** Constante stockant le sujet du courriel en cas d'erreur.*/
define('RDD_MAIL_ERREUR_SUJET', 'Recueil de données : ERREUR');

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: config.gentiana.inc.php,v $
* Revision 1.6  2007-10-05 09:44:43  jp_milcent
* Utilisation d'un tableau pour gérer les clés GoogleMap.
*
* Revision 1.5  2007-10-04 17:50:11  jp_milcent
* Corrections bogues.
*
* Revision 1.4  2007-10-04 17:15:00  jp_milcent
* Ajout des infos sur les autres clés Google dispo.
*
* Revision 1.3  2007-10-04 16:59:06  jp_milcent
* Ajout d'une constante permettant de gérer le formulaire GoogleMap.
*
* Revision 1.2  2007-09-25 12:51:51  jp_milcent
* Formatage des courriels.
*
* Revision 1.1  2007-07-24 14:31:43  jp_milcent
* Ajout dans les fichiers de configuration de l'hôte smtp.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
