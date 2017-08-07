<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                         |
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
// CVS : $Id: ef_config_url.inc.php,v 1.20 2007-01-17 17:54:27 jp_milcent Exp $
/**
* Eflore : constantes de configuration des urls
*
* Contient les constantes de configurations des URLs.
*
*@package eFlore
*@subpackage configuration
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.20 $ $Date: 2007-01-17 17:54:27 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// Les URLs
/** Constante stockant l'URL de la page d'accueil de Photoflora.*/
define('EF_URL_PHOTOFLORA', 'http://photoflora.free.fr/');
/** Constante stockant l'URL de la page de Photoflora affichant toutes les images d'un taxon données.*/
define('EF_URL_PHOTOFLORA_TAXON', EF_URL_PHOTOFLORA.'FiTax.php?NumTaxon=%s');
/** Constante stockant l'URL du dossier de photoflora contenant les images miniatures.*/
define('EF_URL_PHOTOFLORA_IMG_MIN', 'http://www.tela-botanica.org/~photoflo/photos/%s/min/%s');
/** Constante stockant l'URL du dossier de photoflora contenant les images normale.*/
define('EF_URL_PHOTOFLORA_IMG_MAX', 'http://www.tela-botanica.org/~photoflo/photos/%s/max/%s');
/** Constante stockant l'expression régulière récupérant l'abréviation du photographe et le nom du fichier.*/
define('EF_URL_PHOTOFLORA_REGEXP', '/\/photos\/([^\/]+)\/max\/(.+)$/');
/** Constante stockant l'URL du service XML de Photoflora.*/
define('EF_URL_PHOTOFLORA_SERVICE', EF_URL_PHOTOFLORA.'ef_photoflora.php?nt=%s');

/** Constante stockant l'URL de base de l'application recherche de plante sous forme d'objet Pear URL.
 * Cette variable peut être modifiée.*/
$GLOBALS['_EFLORE_']['url'] = $GLOBALS['_GEN_commun']['url'];
/** Variable globale stockant l'URL de base de l'application recherche de plante sous forme d'objet Pear URL.
 * Cette variable ne doit pas être modifiée.*/
$GLOBALS['_EFLORE_']['url_base'] = $GLOBALS['_GEN_commun']['url'];
/** Variable globale stockant l'URL de base pour les permaliens sous forme d'objet Pear URL..*/
$GLOBALS['_EFLORE_']['url_permalien'] = new EfloreUrl(EF_URL);

// +------------------------------------------------------------------------------------------------------+
// Les paramtres des URLs.
// Inter-Modules 
define('EF_LG_URL_MODULE', 'module');
define('EF_LG_URL_ACTION', 'action');
define('EF_LG_URL_FORMAT', 'format');
define('EF_LG_URL_ONGLET', 'onglet');
define('EF_LG_URL_NN', 'nn');
define('EF_LG_URL_NT', 'nt');
define('EF_LG_URL_RG', 'rg');
define('EF_LG_URL_LE', 'le');
define('EF_LG_URL_NVP', 'nvp');

// Modules
define('EF_LG_URL_MODULE_RECHERCHE', 'recherche');
define('EF_LG_URL_MODULE_FICHE', 'fiche');

// Formats
define('EF_LG_URL_FORMAT_PDF', 'pdf');
define('EF_LG_URL_FORMAT_HTML', 'html');

// Module : général
define('EF_LG_URL_ACTION_ONGLET', 'onglet');

// Module : ef_recherche
define('EF_LG_URL_ACTION_FORM_NOM', 'form_nom');
define('EF_LG_URL_ACTION_RECH_NOM', 'recherche_nom');
define('EF_LG_URL_ACTION_FORM_TAX', 'form_taxon');
define('EF_LG_URL_ACTION_RECH_TAX', 'recherche_taxon');
define('EF_LG_URL_ACTION_FICHE_SYNTH', 'fiche_synthese');
// Module : ef_fiche
define('EF_LG_URL_ACTION_SYNTHESE', 'synthese');
define('EF_LG_URL_ACTION_SYNONYMIE', 'synonymie');
define('EF_LG_URL_ACTION_VERNACULAIRE', 'vernaculaire');
define('EF_LG_URL_ACTION_CHOROLOGIE', 'chorologie');
define('EF_LG_URL_ACTION_ILLUSTRATION', 'illustration');
define('EF_LG_URL_ACTION_PERMALIEN', 'permalien');
define('EF_LG_URL_ACTION_EXPORT', 'export');

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ef_config_url.inc.php,v $
* Revision 1.20  2007-01-17 17:54:27  jp_milcent
* Fusion avec la livraison Passy avant nouvelle livraison.
*
* Revision 1.19  2007/01/05 13:45:27  jp_milcent
* Modification du nom d'une classe pour rester compatible avec le nom du fichier et la fonction autoload.
*
* Revision 1.18.2.1  2006/11/29 16:20:31  jp_milcent
* Correction URL photoflora.
*
* Revision 1.18  2006/11/15 10:53:50  jp_milcent
* Fin des réglages de l'utilisation du service XML venant de Photoflora.
*
* Revision 1.17  2006/07/11 16:19:19  jp_milcent
* Intégration de l'appllette Xper.
*
* Revision 1.16  2006/05/11 10:28:27  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.15  2006/04/26 16:57:04  ddelon
* Fusion bdnbe + saisie assistee
*
* Revision 1.14  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.13.2.1  2006/04/08 22:23:08  ddelon
* completion : bug chemins
*
* Revision 1.13  2005/12/27 15:06:13  ddelon
* Image Costes en premier
*
* Revision 1.12  2005/12/21 15:11:13  jp_milcent
* Nouvelle gestion de la configuration.
*
* Revision 1.11  2005/12/15 17:01:01  jp_milcent
* Correction url cartes.
*
* Revision 1.10  2005/12/15 16:17:44  jp_milcent
* Modification de l'url pour les photos max de Photoflora.
*
* Revision 1.9  2005/12/09 16:27:24  jp_milcent
* Ajout de constante pour gérer les fichiers css dans index.php.
*
* Revision 1.8  2005/12/04 23:57:28  ddelon
* Recherche approchee
*
* Revision 1.7  2005/11/29 10:13:23  jp_milcent
* Ajout d'une url pour les cartes et du chemin où écrire les nouvelles cartes.
*
* Revision 1.6  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.5  2005/10/26 16:36:25  jp_milcent
* Amélioration des pages Synthèses, Synonymie et Illustrations.
*
* Revision 1.4  2005/10/19 16:46:48  jp_milcent
* Correction de bogue liés à la modification des urls.
*
* Revision 1.3  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.2  2005/09/16 16:41:45  jp_milcent
* Gestion de l'onglet Synthèse en cours.
* Création du modèle pour l'attribution des noms vernaculaires aux taxons.
*
* Revision 1.1  2005/07/28 15:37:56  jp_milcent
* Début gestion des squelettes et de l'API eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>