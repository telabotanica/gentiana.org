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
// CVS : $Id: installateur.php,v 1.16 2007-04-20 13:31:42 florian Exp $
/**
* Application Installateur de Papyrus.
*
* Application permettant de g�rer l'installation et les erreurs li�s � l'abscence de base de donn�es, 
* d'extenssin PHP...
*
*@package Installateur
//Auteur original :
*@author       
	               'AND gm_ce_i18n = "'.GEN_I18N_ID_DEFAUT.'" ';
	
				$resultat = $db->query($requete);

				(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
				$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
				
				if ($langue_test!=GEN_I18N_ID_DEFAUT) {
					return GEN_rechercheMenuIdentifiantVersionParDefaut($db,$ligne->gm_id_menu);
				}
		} Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.16 $ $Date: 2007-04-20 13:31:42 $
// +------------------------------------------------------------------------------------------------------+
**/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// Constante de l'application Installateur. On devrait cr�er un fichier de config et un de langue pour rendre l'appli portable...
preg_match('/^(.*)papyrus.php/', $_SERVER['SCRIPT_FILENAME'], $instal_tab_txt);
define('INSTAL_CHEMIN_ABSOLU', $instal_tab_txt[1]);
/** Nom du dossier contenant l'application Installateur.*/
define('INSTAL_DOSSIER_APPLI', INSTAL_CHEMIN_ABSOLU.GEN_CHEMIN_APPLICATION.'installateur'.GEN_SEP);
/** Nom du dossier contenant la biblioth�que de code de l'application Installateur.*/
define('INSTAL_DOSSIER_BIBLIO', INSTAL_DOSSIER_APPLI.'bibliotheque'.GEN_SEP);
/** Chemin vers le fichier de configuration de base de l'application Papyrus.*/
define('INSTAL_CHEMIN_CONFIG', GEN_CHEMIN_CONFIG.GEN_FICHIER_CONFIG);
/** Nom du fichier de configuration de Papyrus � cr�er.*/
define('INSTAL_FICHIER_CONFIG', GEN_FICHIER_CONFIG);
/** Chemin vers le fichier de configuration de base de l'application Papyrus.*/
define('INSTAL_CHEMIN_SQL', INSTAL_CHEMIN_ABSOLU.GEN_CHEMIN_INSTAL);
/** Nom de la constante stockant le num�ro de la nouvelle version de l'application Papyrus.*/
define('INSTAL_VERSION_NOUVELLE_NOM', 'PAP_VERSION');
/** Num�ro de la nouvelle version de l'application Papyrus.*/
define('INSTAL_VERSION_NOUVELLE', GEN_VERSION);
if (defined('PAP_VERSION')) {
    define('INSTAL_VERSION_ANCIENNE', PAP_VERSION);
} else {
    define('INSTAL_VERSION_ANCIENNE', '');
}
/** Nombre d'�tapes totale de l'installation.*/
define('INSTAL_NBRE_ETAPE', 3);

// Fichiers � inclure
require_once INSTAL_DOSSIER_BIBLIO.'instal_installation.fonct.php';

// +------------------------------------------------------------------------------------------------------+
// |                                          CORPS du PROGRAMME                                          |
// +------------------------------------------------------------------------------------------------------+
function afficherContenuCorps() 
{
    // Ent�tre XHTML des pages de l'installation de Papyrus
    $sortie = '';
    $sortie .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"'."\n";
    $sortie .= '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n";
    $sortie .= '<html xmlns="http://www.w3.org/1999/xhtml" lang="fr-FR" xml:lang="fr-FR">'."\n";
    $sortie .= '  <head>'."\n";
    $sortie .= '    <link rel="stylesheet" type="text/css" media="screen" title="Installateur" href="papyrus/applications/installateur/presentations/styles/installateur.css" />'."\n";
    $sortie .= '    <title>Installation de Papyrus</title>'."\n";
    $sortie .= '  </head>'."\n";
 	$sortie .= '  <body xml:lang="fr" lang="fr" >'."\n";
	$sortie .= '  <div id="page">'."\n";
    $sortie .= '  	<div id="zone_bandeau">'."\n";  
	$sortie .= '  		<div id="logo">'."\n";    
    $sortie .= '              <img src="papyrus/applications/installateur/presentations/images/Logo_papyrus.jpg" alt="Logo Papyrus" />'."\n";
    $sortie .= '        </div>'."\n";
    $sortie .= '        <div id="site_nom">'."\n";
    $sortie .= '          <h1>Installation de Papyrus</h1>'."\n";
    $sortie .= '        </div>'."\n";
    $sortie .= '      </div>'."\n";
    $sortie .= '      <div id="zone_contenu">'."\n";
    // Message situation de l'installation
    if (defined('PAP_VERSION')) {
        $sortie .=  '<p class="zone_info">Votre syst&egrave;me Papyrus existant a &eacute;t&eacute; reconnu comme &eacute;tant la version '.
                    INSTAL_VERSION_ANCIENNE.'.<br />'.
                    'Vous &ecirc;tes sur le point de <strong>mettre &agrave; jour</strong> Papyrus pour la version '.
                    INSTAL_VERSION_NOUVELLE.'.<br />'.
                    'Veuillez revoir vos informations de configuration ci-dessous.</p><br style="clear:both;">'."\n";
    } else {
        $sortie .=  '<p class="zone_info">Vous &ecirc;tes sur le point d\'installer Papyrus '.INSTAL_VERSION_NOUVELLE.'.<br />'.
                    'Veuillez configurer votre Papyrus en remplissant les formulaires &eacute;tape par &eacute;tape.</p><br style="clear:both;">'."\n";
    }
    
    if(!isset($_GET['installation']) || ($_GET['installation'] == 'form_pref' || $_GET['installation'] == 'verif_pref')) {
        include_once GEN_CHEMIN_APPLICATION.'installateur/instal_preference.inc.php';
    } else if($_GET['installation'] == 'form_bdd' || $_GET['installation'] == 'verif_bdd') {
        include_once GEN_CHEMIN_APPLICATION.'installateur/instal_base_de_donnees.inc.php';
    } else if($_GET['installation'] == 'form_fichier' || $_GET['installation'] == 'verif_fichier') {
        include_once GEN_CHEMIN_APPLICATION.'installateur/instal_fichier.inc.php';
    }
    
    // Pied XHTML des pages de l'installation de Papyrus
    $sortie .= '    </div>'."\n";
    $sortie .= '      <div id="zone_pied">'."\n";
    $sortie .= '       <div id="copyright">'."\n";
    $sortie .= '        <a href="http://frenchmozilla.org"><img src="papyrus/applications/installateur/presentations/images/logo-firefox.png" alt="Logo Firefox" /></a>&nbsp;'."\n";
    $sortie .= '        <a href="http://validator.w3.org/check?uri=referer"><img src="papyrus/applications/installateur/presentations/images/logo-xhtml11.png" alt="Logo XHTML" /></a>&nbsp;'."\n";
    $sortie .= '        <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="papyrus/applications/installateur/presentations/images/logo-css.png" alt="Logo CSS" /></a><br />'."\n";
    $sortie .= '        &copy;&nbsp;<a href="http://www.tela-botanica.org/">Tela Botanica</a> et  <a href="http://www.ecole-et-nature.org/">R&eacute;seau Ecole et Nature</a> / 2004-2006<br />'."\n";
    $sortie .= '        Site utilisant <a href="http://outils-reseaux.org/wiki_papyrus">Papyrus, le CMS coop&eacute;ratif</a>'."\n";
    $sortie .= '       </div>'."\n";
    $sortie .= '      </div>'."\n";
    $sortie .= '  </div>'."\n";
    $sortie .= ' </body>'."\n";
    $sortie .= '</html>';
    
    return $sortie;
}


// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: installateur.php,v $
* Revision 1.16  2007-04-20 13:31:42  florian
* remplacement des caracteres speciaux par des entite html
*
* Revision 1.15  2006/10/16 15:49:07  ddelon
* Refactorisation code mulitlinguisme et gestion menu invisibles
*
* Revision 1.14  2006/10/09 14:35:50  ddelon
* bug caractere invalide trainant dans fichier
*
* Revision 1.13  2006/10/05 15:17:29  florian
* changement presentation
*
* Revision 1.12  2006/10/05 15:11:17  florian
* changement presentation
*
* Revision 1.11  2006/10/05 14:41:53  florian
* changement presentation
*
* Revision 1.10  2005/09/23 14:20:23  florian
* nouvel habillage installateur, plus correction de quelques bugs
*
* Revision 1.9  2004/10/27 11:43:32  jpm
* Correction bogues diff mise � jour / installation.
*
* Revision 1.8  2004/10/25 10:22:48  jpm
* Correction de quelques bogues, ajouts d'explications pour l'utilisateur et modification des styles CSS.
*
* Revision 1.7  2004/10/22 17:23:04  jpm
* Simplification del'installation de Papyrus.
*
* Revision 1.6  2004/10/19 17:01:12  jpm
* Correction bogues.
*
* Revision 1.5  2004/10/19 16:47:28  jpm
* Transformation en fonction de l'appel de l'application.
*
* Revision 1.4  2004/10/19 15:59:18  jpm
* Ajout de la gestion des valeurs propre � Papyrus � ins�rer dans la base de donn�es.
* Ajout des constantes FTP.
*
* Revision 1.3  2004/10/18 09:12:09  jpm
* Changement de nom d'un fichier.
*
* Revision 1.2  2004/10/15 18:28:59  jpm
* D�but appli installateur de Papyrus.
*
* Revision 1.1  2004/06/16 14:33:13  jpm
* Changement de nom de G�n�sia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.6  2004/04/22 08:25:48  jpm
* Transformation de $GS_GLOBAL en $_GEN_commun.
*
* Revision 1.5  2004/04/08 13:21:05  jpm
* Le code pour l'installation uniquement.
*
* Revision 1.4  2004/04/08 12:25:16  jpm
* Suppression de tous le code r�alisant les v�rifications. L'application Installateur ne fera qu'installer G�n�sia et non v�rifier son bon fonctionnement.
*
* Revision 1.3  2004/04/02 16:37:51  jpm
* Modification des commentaires.
*
* Revision 1.2  2004/03/31 16:57:16  jpm
* Ajout de la gestion des erreur de base de donn�es, de la connexion � celle-ci et des extenssions php disponibles.
*
* Revision 1.1  2004/03/29 11:00:12  jpm
* Transfert d'un morceau de code g�rant les erreurs et l'installation mais qui a actuellement aucun effet sur G�n�sia.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>