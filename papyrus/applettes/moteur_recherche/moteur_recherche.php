<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of Papyrus.                                                                        |
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
// CVS : $Id: moteur_recherche.php,v 1.21.2.1 2007-11-30 14:01:50 alexandre_tb Exp $
/**
* Applette : moteur de recherche
*
* Génère un formulaire contenant une zone de saisie permettant de taper un texte à rechercher sur l'ensemble
* des sites gérés par Papyrus.
* Utilisation des bibliothèques inclue par Papyrus :
* - Papyrus pap_meta.fonct.php
* - PEAR NET_URL
*
*@package Applette
*@subpackage Moteur_recherche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.21.2.1 $ $Date: 2007-11-30 14:01:50 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherMoteurRecherche';
$GLOBALS['_GEN_commun']['info_applette_balise'] = 	'(?:<!-- '.$GLOBALS['_GEN_commun']['balise_prefixe'].'(MOTEUR_RECHERCHE) -->|'.
													'\{\{[[Mm]oteurRecherche\s*\}\})';

// --------------------------------------------------------------------------------------------------------
//Utilisation de la bibliothèque Papyrus pap_meta.fonct.php inclue par Papyrus
//Utilisation de la bibliothèque PEAR NET_URL inclue par Papyrus
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_APPLETTE.'moteur_recherche/configuration/more_configuration.inc.php';
/** Inclusion du fichier de configuration des Spip.*/
require_once GEN_CHEMIN_APPLETTE.'moteur_recherche/configuration/more_config_spip.inc.php';

// Inclusion des fichiers de traduction de l'appli ADME de Papyrus
if (file_exists(MORE_CHEMIN_LANGUE.'more_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once MORE_CHEMIN_LANGUE.'more_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once MORE_CHEMIN_LANGUE.'more_langue_'.MORE_I18N_DEFAUT.'.inc.php';
}

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

if (isset($_POST['more_motif']) && $_POST['more_motif'] != '') {
    // Initialisation de variable extérieures
    $GLOBALS['_VEI_']['usurpation'] = MORE_LG_USURPATION.htmlentities(stripslashes($_POST['more_motif']));
    $GLOBALS['_PAPYRUS_']['general']['application_chemin'] = null;
    // Modification des meta de l'entête de la page
    GEN_modifierMetaHttpEquiv('Content-Type', 'text/html; charset=ISO-8859-15');
    GEN_modifierMetaHttpEquiv('Content-style-type', 'text/css');
    GEN_modifierMetaHttpEquiv('Content-script-type', 'text/javascript');
    GEN_modifierMetaHttpEquiv('Content-language', $GLOBALS['_GEN_commun']['i18n']);
    
    GEN_modifierMetaName('revisit-after', '15 days');
    GEN_modifierMetaName('robots', 'index,follow');
    GEN_modifierMetaName('author', 'Tela Botanica');
    GEN_modifierMetaName('keywords', 'Recherche, résultat.');
    GEN_modifierMetaName('description', 'Page de résultats du moteur de recherche de Papyrus.');
    
    GEN_viderMeta('dc');
}

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

/** Fonction afficherMoteurRecherche() - Fournit un formulaire de recherche.
*
* Renvoie un formulaire permettant de rechercher une chaine de caractères dans les sites
* gérés par Papyrus.
* Necessite l'utilisation de Pear Net_URL par le programme appelant cette fonction.
*
* @param  array  tableau d'éventuel arguments présent dans la balise transmis à la fonction. 
* @param  array  tableau global de Papyrus.
* @return string  formulaire XHTML de recherche.
*/
function afficherMoteurRecherche($tab_applette_arguments, $_GEN_commun)
{
    // --------------------------------------------------------------------------------------------------------
    // Initialisation de variable de configuration.
    $liste_type_site = '102, 103';// Les id des types des sites pouvant apparaître dans le sélecteur
    $objet_pear_db =& $_GEN_commun['pear_db'];//objet Pear créé par DB contenant la connexion à la base de données.
    $GLOBALS['_MOTEUR_RECHERCHE_']['bd']['papyrus'] =& $_GEN_commun['pear_db'];// Connexion à la BD de Papyrus
    $GLOBALS['_MOTEUR_RECHERCHE_']['variables'] = array();
    $code_site = $_GEN_commun['url_site'];// identifiant du site courant.
    $url = $_GEN_commun['url'];
    $url_id_type_site = GEN_URL_ID_TYPE_SITE;
    $indent_origine = 12;// Indentation de départ en nombre d'espace
    $indent_pas     = 4;// Pas d'indentation en nombre d'espace
    $retour = '';
    $retour_resultats = '';
    
    // --------------------------------------------------------------------------------------------------------
    // Lancement de la recherche si nécessaire
    $aso_squelette = array('formulaire' => MORE_FORM_SQUELETTE);
    //$_SESSION['_MOTEUR_RECHERCHE_']['rechercher']['more_motif'] = '';
	$GLOBALS['_MOTEUR_RECHERCHE_']['formulaire']['form_url'] = $url->getUrl();
	$GLOBALS['_MOTEUR_RECHERCHE_']['formulaire']['form_tab'] = MORE_FORM_MOTIF_TAB;
	$GLOBALS['_MOTEUR_RECHERCHE_']['formulaire']['more_motif_base'] = MORE_LG_FORM_MOTIF_VALUE;
    if (!isset($_POST['more_motif']) || $_POST['more_motif'] == '') {
        $GLOBALS['_MOTEUR_RECHERCHE_']['formulaire']['more_motif'] = MORE_LG_FORM_MOTIF_VALUE;
    } else {
        // Ajout du squelette de résultat
        $aso_squelette['resultat'] = MORE_RESULTAT_SQUELETTE;
		// Titre de la page
		$GLOBALS['_PAPYRUS_']['rendu']['TITRE_PAGE'] = MORE_LG_TITRE.htmlentities(stripslashes($_POST['more_motif']));
		$_SESSION['_MOTEUR_RECHERCHE_']['rechercher']['more_motif'] = $_POST['more_motif'];
		$GLOBALS['_MOTEUR_RECHERCHE_']['formulaire']['more_motif'] =  htmlentities(stripslashes($_POST['more_motif']));
		
        /** Inclusion de la classe Recherche.*/
        require_once MORE_CHEMIN_BIBLIO.'more_recherche.class.php';
        /** Inclusion de la classe Recherche_Papyrus_Menu.*/
        require_once MORE_CHEMIN_BIBLIO.'more_recherche_papyrus_menu.class.php';
        /** Inclusion de la classe Recherche_Spip_Article.*/
        require_once MORE_CHEMIN_BIBLIO.'more_recherche_spip_article.class.php';
        if (isset($_SESSION['_MOTEUR_RECHERCHE_']['rechercher']['more_motif'])) {
            $more_motif = $_SESSION['_MOTEUR_RECHERCHE_']['rechercher']['more_motif'];
        } else {
            $more_motif = '';
        }
        $moteur = new More_Recherche($more_motif);
        $recherche_papyrus_menu = new More_Recherche_Papyrus_Menu($more_motif);
        $recherche_spip_article = new More_Recherche_Spip_Article($more_motif);
        $moteur->ajouterRecherche($recherche_papyrus_menu);
        $moteur->ajouterRecherche($recherche_spip_article);
        $GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['resultats'] = $moteur->rechercherMotif();
        //$GLOBALS['_DEBOGAGE_'] = '<pre>'.print_r($GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['resultats'], true).'</pre>';
        $nbre_pages = count($GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['resultats']);
		$GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['nbre_pages'] = $nbre_pages;
		$GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['vide'] = MORE_LG_RESULTAT_VIDE;
        if ($nbre_pages <= 1) {
        	$GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['titre'] = sprintf(MORE_LG_RESULTAT_TITRE, $nbre_pages);
        } else {
        	$GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['titre'] = sprintf(MORE_LG_RESULTAT_TITRE_PLURIEL, $nbre_pages);
        }
		foreach ($GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['resultats'] as $cle => $val) {
			if (empty($val['url'])) {
                unset($GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['resultats'][$cle]);
			} else {
				$GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['resultats'][$cle]['score'] = trim($val['score']);
				$GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['resultats'][$cle]['date_creation'] = trim($val['date_creation']);
				$GLOBALS['_MOTEUR_RECHERCHE_']['resultat']['resultats'][$cle]['description'] = trim($val['description']);
			}
		}
	}

	// Génération du contenu à partir des squelettes
	foreach ($aso_squelette as $squelette => $fichier) {
		// Extrait les variables et les ajoutes à l'espace de noms local
		extract($GLOBALS['_MOTEUR_RECHERCHE_'][$squelette]);
		// Démarre le buffer
		ob_start();
		// Inclusion du fichier
		include(MORE_CHEMIN_SQUELETTE.$fichier);
		// Récupérer le  contenu du buffer
		$retour = ob_get_contents();
		// Arrête et détruit le buffer
		ob_end_clean();
		// Retourne le contenu
		switch ($squelette) {
			case 'resultat' :
				// L'applette fournie un résultat qui écrase le contenu de la page courrante
				$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_NAVIGATION'] = '';
				$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_TETE'] = '';
				$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_CORPS'] = $retour;
				$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_PIED'] = '';
				$GLOBALS['_GEN_commun']['info_menu'] = '';
				break;
			case 'formulaire' :
				// L'applette est appelée par défaut
				$retour_formulaire = $retour;
				break;
			default:
				$e = "Squellette <$squelette> pour le moteur de recherche inconnu!";
				trigger_error($e, E_USER_WARNING);
		}
	}
	return $retour_formulaire;
}

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: moteur_recherche.php,v $
* Revision 1.21.2.1  2007-11-30 14:01:50  alexandre_tb
* conformite xhtml
*
* Revision 1.21  2007-10-29 18:29:30  jp_milcent
* Ajout d'un prÃ©fixe devant les classes de l'applette pour Ã©viter les conflits avec d'autres classes provenant des applis clientes.
*
* Revision 1.20  2007-06-15 12:27:39  jp_milcent
* Ajout de fonctionnalités Javascript au moteur de recherche.
*
* Revision 1.19  2007-01-02 18:49:22  jp_milcent
* Amélioration de la gestion du motif.
* Ajout de la gestion des expressions complête via l'utilisation de guillemets.
*
* Revision 1.18  2006/12/12 13:53:54  jp_milcent
* Mise en place du nouveau format des balises d'applette.
*
* Revision 1.17  2006/12/01 16:33:40  florian
* Amélioration de la gestion des applettes et compatibilité avec le nouveau mode de gestion de l'inclusion des applettes.
*
* Revision 1.16  2006/11/20 09:36:59  jp_milcent
* Correction bogue zéro résultat et ajout d'url simple pour indiquer la page de l'article.
*
* Revision 1.15  2006/11/14 16:10:13  jp_milcent
* Extraction du XHTML et utilisation de squelettes à la place.
* Possibilité de configurer le squlette voulu via le fichier de conf.
*
* Revision 1.14  2006/10/10 13:28:14  jp_milcent
* Suppression d'une variable et utilisation de la constante PAP_URL
*
* Revision 1.13  2006/10/10 12:02:30  jp_milcent
* Suppression d'une bibliothèque Pear qu'il est inutile d'inclure.
* Ajout du chemin vers la bibliotheque Pear de Papyrus.
*
* Revision 1.12  2006/06/16 09:45:10  jp_milcent
* Correction bogue lié à la suppression de l'objet info_menu.
*
* Revision 1.11  2006/05/23 13:39:13  florian
* corection bug notice de jean pascal ;-)
*
* Revision 1.10  2006/05/19 10:04:55  jp_milcent
* Ajout d'un moteur de recherche analysant les articles des sites sous Spip.
*
* Revision 1.9  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.8  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.7.2.2  2005/12/27 15:56:00  ddelon
* Fusion Head vers multilinguisme (wikini double clic)
*
* Revision 1.7.2.1  2005/12/20 14:40:25  ddelon
* Fusion Head vers Livraison
*
* Revision 1.7  2005/09/27 09:07:32  ddelon
* size applette et squelettes
*
* Revision 1.6  2005/05/25 13:49:22  jpm
* Corection erreur pour la recherche dans le contenu.
*
* Revision 1.5  2005/05/19 12:46:12  jpm
* Correction bogue accesskey.
* Ajout d'un id à la liste.
* Arrondissement des score.
*
* Revision 1.4  2005/04/14 17:39:34  jpm
* Amélioration du moteur de rechercher :
*  - pourcentage
*  - ajout d'info
*
* Revision 1.3  2005/02/22 19:27:21  jpm
* Changement de nom de variables.
* Suppression de l'attribut nam de la balise form via une méthode de HTML_Common.
*
* Revision 1.2  2005/02/22 17:44:03  jpm
* Suppression de référence posant problème.
*
* Revision 1.1  2004/12/07 10:24:01  jpm
* Moteur de recherche version de départ.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
