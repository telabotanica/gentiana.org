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
// CVS : $Id: ef_config_chemin.inc.php,v 1.18 2007-08-20 15:42:32 jp_milcent Exp $
/**
* Fichier de configuration des chemins des fichiers utilis�s par l'application eFlore.
*
* Fichier contenant des constantes et des variables globales permettant de configurer eFlore-consultation.
*
*@package eflore
*@subpackage configuration
//Auteur original :
*@author        Linda ANGAMA<linda_angama@yahoo.fr>
//Autres auteurs :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.18 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// D�finition des chemins de fichiers.
/** Constante stockant le chemin vers le dossier modules.*/
define('EF_CHEMIN_SERVICE', EF_CHEMIN_APPLI.'services/');
/** Constante stockant le chemin vers le dossier modules.*/
define('EF_CHEMIN_MODULE', EF_CHEMIN_APPLI.'modules/');
/** Constante stockant le chemin vers le dossier modules.*/
define('EF_CHEMIN_MODULE_RELATIF', EF_CHEMIN_APPLI_RELATIF.'modules/');
/** Constante stockant le chemin vers le dossier module commun.*/
define('EF_CHEMIN_COMMUN', EF_CHEMIN_MODULE.'ef_commun/');
/** Constante stockant le chemin vers le dossier actions du module commun.*/
define('EF_CHEMIN_COMMUN_ACTION', EF_CHEMIN_COMMUN.'actions/');
/** Constante stockant le chemin vers le dossier squelette du module commun.*/
define('EF_CHEMIN_COMMUN_SQUELETTE', EF_CHEMIN_COMMUN.'squelettes/');
/** Constante stockant le chemin vers le dossier actions du module commun.*/
define('EF_CHEMIN_COMMUN_VUE', EF_CHEMIN_COMMUN.'vues/');
/** Constante stockant le chemin vers le dossier des composants.*/
define('EF_CHEMIN_COMPOSANT', EF_CHEMIN_APPLI.'composants/');
/** Constante stockant le chemin relatif vers le dossier des composants.*/
define('EF_CHEMIN_COMPOSANT_RELATIF', EF_CHEMIN_APPLI_RELATIF.'composants/');
/** Constante stockant le chemin vers le dossier biblioth�que.*/
define('EF_CHEMIN_BIBLIO', EF_CHEMIN_APPLI.'bibliotheque/');
/** Constante stockant le chemin vers le dossier de la biblioth�que FPDF.*/
define('EF_CHEMIN_BIBLIO_FPDF', EF_CHEMIN_BIBLIO.'fpdf153/');
/** Constante stockant le chemin vers le dossier de la biblioth�que FPDI.*/
define('EF_CHEMIN_BIBLIO_FPDI', EF_CHEMIN_BIBLIO.'fpdi1.1/');
/** Constante stockant le chemin vers le dossier de la biblioth�que Fragmenteur.*/
define('EF_CHEMIN_BIBLIO_FRAGMENTEUR', EF_CHEMIN_BIBLIO.'fragmenteur/');
/** Constante stockant le chemin vers le dossier de la biblioth�que HTTP.*/
define('EF_CHEMIN_BIBLIO_HTTP', EF_CHEMIN_BIBLIO.'http/');
/** Constante stockant le chemin vers le dossier modele.*/
define('EF_CHEMIN_BIBLIO_MODELE', EF_CHEMIN_BIBLIO.'modele/');
/** Constante stockant le chemin vers le dossier metier.*/
define('EF_CHEMIN_BIBLIO_METIER', EF_CHEMIN_BIBLIO.'metier/');
/** Constante stockant le chemin vers le dossier noyau.*/
define('EF_CHEMIN_BIBLIO_NOYAU', EF_CHEMIN_BIBLIO.'noyau/');
/** Constante stockant le chemin vers le dossier de la biblioth�que Pear.*/
define('EF_CHEMIN_BIBLIO_PEAR', EF_CHEMIN_BIBLIO.'pear/');
/** Constante stockant le chemin vers l'API PEAR.*/
define('EF_CHEMIN_PEAR', PAP_CHEMIN_API_PEAR);
/** Constante stockant le chemin vers le dossier dao.*/
define('EF_CHEMIN_DAO', EF_CHEMIN_BIBLIO_MODELE.'dao/');
/** Constante stockant le chemin vers le dossier interfaces.*/
define('EF_CHEMIN_INTERFACE', EF_CHEMIN_BIBLIO_MODELE.'interfaces/');
/** Constante stockant le chemin vers le dossier abstractions.*/
define('EF_CHEMIN_ABSTRACTION', EF_CHEMIN_BIBLIO_MODELE.'abstractions/');
/** Constante stockant le chemin vers le dossier langues.*/
define('EF_CHEMIN_LANGUE', EF_CHEMIN_APPLI.'langues/');
/** Constante stockant le chemin vers le dossier pr�sentation.*/
define('EF_CHEMIN_PRESENTATION', EF_CHEMIN_APPLI.'presentations/');
/** Constante stockant le chemin vers le dossier styles.*/
define('EF_CHEMIN_STYLE', EF_CHEMIN_PRESENTATION.'styles/');
/** Constante stockant le chemin vers le dossier squelettes.*/
define('EF_CHEMIN_SQUELETTE', EF_CHEMIN_PRESENTATION.'squelettes/');
/** Constante stockant le chemin vers le dossier modele.*/
define('EF_CHEMIN_EFLORE_API', EF_CHEMIN_APPLI.'api/');

// +------------------------------------------------------------------------------------------------------+
// Les biblioth�ques PDF : FPDF et FPDFI
/** Constante stockant le chemin vers le dossier o� sont stock�s les polices pour la biblioth�ques FPDF.*/ 
define('FPDF_FONTPATH', EF_CHEMIN_BIBLIO_FPDF.'font/');
// Ajout des chemins des biblioth�ques de codes au chemin par d�faut
set_include_path(	get_include_path().PATH_SEPARATOR.EF_CHEMIN_BIBLIO_FPDF.
					PATH_SEPARATOR.EF_CHEMIN_BIBLIO_FPDI.
					PATH_SEPARATOR.EF_CHEMIN_BIBLIO_FRAGMENTEUR.
					PATH_SEPARATOR.EF_CHEMIN_BIBLIO_PEAR
					);

// +------------------------------------------------------------------------------------------------------+
// D�finition des chemins des fichiers pour la bibliobth�que cartographique
/** Constante stockant le chemin vers le dossier biblioth�que de la cartographie.*/
define('EF_CHEMIN_BIBLIO_CARTO', EF_CHEMIN_BIBLIO.'cartographie/');
/** Constante stockant le chemin vers le dossier des images png sources de la biblioth�que cartographique.*/
define('EF_CHEMIN_CARTE_SRC', EF_CHEMIN_BIBLIO_CARTO.'cartes/');
// +------------------------------------------------------------------------------------------------------+
// Tableaux sotckant les chemins des classes de l'api pour la fonction autoload
$GLOBALS['_EFLORE_']['api']['chemins'] = array(	'do/', 
												'dao/',
												'dao/interface/',
												'dao/sql/');

// +------------------------------------------------------------------------------------------------------+
// Tableaux sotckant les chemins des classes pour la fonction autoload
$GLOBALS['_EFLORE_']['chemins_classes'] = array(	EF_CHEMIN_DAO, 
													EF_CHEMIN_BIBLIO_NOYAU,
													EF_CHEMIN_BIBLIO_METIER,
													EF_CHEMIN_ABSTRACTION, 
													EF_CHEMIN_BIBLIO_MODELE, 
													EF_CHEMIN_COMMUN, 
													EF_CHEMIN_COMMUN_ACTION, 
													EF_CHEMIN_COMMUN_VUE, 
													EF_CHEMIN_BIBLIO_CARTO,
													EF_CHEMIN_BIBLIO_FRAGMENTEUR,
													EF_CHEMIN_COMPOSANT);


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ef_config_chemin.inc.php,v $
* Revision 1.18  2007-08-20 15:42:32  jp_milcent
* Ajout du chemin vers les composants.
*
* Revision 1.17  2007-08-05 09:17:48  jp_milcent
* Inclusion du path par d�faut apr�s les paths d�finis dans eFlore.
*
* Revision 1.16  2007-07-17 07:48:23  jp_milcent
* Ajout et modification des fichiers n�cessaires aux services web.
*
* Revision 1.15  2007-07-11 17:10:43  jp_milcent
* Ajout du chemin vers la biblioth�que Pear d'eFlore.
*
* Revision 1.14  2007-06-29 16:58:22  jp_milcent
* Ajout du chemin vers les fichiers du Fragmenteur.
*
* Revision 1.13  2007-01-19 17:32:55  jp_milcent
* Fusion avec la livraison Moquin-Tandon : corrections bogue chemin des font pour FPDF.
*
* Revision 1.11.2.2  2007/01/19 17:31:01  jp_milcent
* Transfert dans ef_config_chemin de FPDF_FONTPATH.
*
* Revision 1.12  2007/01/18 17:26:07  jp_milcent
* Fusion avec la livraison Moquin-Tandon : modification chemin API
*
* Revision 1.11.2.1  2007/01/18 17:21:35  jp_milcent
* L'api est maintenant int�gr� directement dans le dossier du projet.
*
* Revision 1.11  2007/01/12 13:17:51  jp_milcent
* Suppression du chemin vers le dossier d�bogage.
*
* Revision 1.10  2007/01/03 19:44:30  jp_milcent
* Ajout de chemin vers l'api d'eFlore.
*
* Revision 1.9  2006/07/12 14:27:45  jp_milcent
* Ajout du dossier metier.
*
* Revision 1.8  2006/06/20 15:38:29  jp_milcent
* Ajout des chemins des biblioth�ques de code au chemin par d�faut de PHP.
*
* Revision 1.7  2006/05/11 12:55:38  jp_milcent
* Ajout de chemins � l'autoload.
*
* Revision 1.6  2006/05/11 10:28:27  jp_milcent
* D�but modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.5  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conform�ment aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synth�se.
*
* Revision 1.4  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.3.2.2  2006/04/08 22:23:08  ddelon
* completion : bug chemins
*
* Revision 1.3.2.1  2006/04/07 10:50:29  ddelon
* Completion a la google suggest
*
* Revision 1.3  2006/03/03 17:29:17  jp_milcent
* Am�lioration de la gestion des variables de session.
* Ajout du nouveau projet ind�pendant de la BDNFF : BDNBE.
*
* Revision 1.2  2005/12/21 15:50:10  jp_milcent
* Am�lioration indentation.
*
* Revision 1.1  2005/12/21 15:11:13  jp_milcent
* Nouvelle gestion de la configuration.
*
* Revision 1.1  2005/12/21 14:36:35  jp_milcent
* Ajout du fichier config avanc�e.
*
* Revision 1.26  2005/12/21 14:34:37  jp_milcent
* Ajout de la constante indiquant la langue principale.
*
* Revision 1.25  2005/12/15 16:01:21  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.24  2005/12/09 16:51:34  jp_milcent
* Utilisation d'une variable globale pour passer � la fonction autoload les chemins o� rechercher les classes.
*
* Revision 1.23  2005/12/09 10:49:14  jp_milcent
* Ajout de constante de d�bogage pour g�rer les erreurs PEAR.
*
* Revision 1.22  2005/12/07 09:57:09  jp_milcent
* Configuration du fichier pour la version offici�le int�gr�e � Papyrus sur le site de Tela Botanica.
*
* Revision 1.21  2005/12/06 16:38:52  jp_milcent
* Ajout des chemins d'acc�s aux classes du module commun.
*
* Revision 1.20  2005/12/04 23:57:28  ddelon
* Recherche approchee
*
* Revision 1.19  2005/11/29 16:58:35  jp_milcent
* Correction erreur de constante non d�finie.
*
* Revision 1.18  2005/11/29 10:13:24  jp_milcent
* Ajout d'une url pour les cartes et du chemin o� �crire les nouvelles cartes.
*
* Revision 1.17  2005/11/23 18:07:23  jp_milcent
* D�but correction des bogues du module Fiche suite � mise en ligne eFlore Beta.
*
* Revision 1.16  2005/10/21 16:28:54  jp_milcent
* Am�lioration des onglets Synonymies et Synth�se.
*
* Revision 1.15  2005/10/18 17:17:20  jp_milcent
* D�but de la gestion des url d'eFlore.
*
* Revision 1.14  2005/10/13 16:25:05  jp_milcent
* Ajout de la classification � la synth�se.
*
* Revision 1.13  2005/10/11 17:30:32  jp_milcent
* Am�lioration gestion de la chorologie en cours.
*
* Revision 1.12  2005/09/29 16:16:14  jp_milcent
* Fin de la gestion de la synonymie.
* D�but de la gestion des noms vernaculaires.
*
* Revision 1.11  2005/09/26 15:48:15  jp_milcent
* Fin de l'onglet synth�se pour la fiche d'un taxon.
*
* Revision 1.10  2005/09/12 16:22:44  jp_milcent
* Fin de gestion de la recherche des noms latins pour tous les r�f�rentiels.
*
* Revision 1.9  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requ�te rapide.
* D�but gestion choix aplhab�tique des taxons.
*
* Revision 1.8  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des r�sultats des recherches taxonomiques (en cours).
*
* Revision 1.7  2005/08/04 15:51:45  jp_milcent
* Impl�mentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.6  2005/08/02 16:19:33  jp_milcent
* Am�lioration des requetes de recherche de noms.
*
* Revision 1.5  2005/08/01 16:18:40  jp_milcent
* D�but gestion r�sultat de la recherche par nom.
*
* Revision 1.4  2005/07/28 15:37:56  jp_milcent
* D�but gestion des squelettes et de l'API eFlore.
*
* Revision 1.3  2005/07/27 15:43:21  jp_milcent
* D�but d�bogage avec gestion de l'appli hors Papyrus.
*
* Revision 1.2  2005/07/26 16:27:29  jp_milcent
* D�but mise en place framework eFlore.
*
* Revision 1.1  2005/07/26 09:19:05  jp_milcent
* L�g�re modif.
*
* Revision 1.1  2005/07/25 14:24:36  jp_milcent
* D�but appli de consultation simplifi�e.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>