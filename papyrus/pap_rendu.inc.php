<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// Copyright (C) 1999-2004 Tela Botanica (accueil@tela-botanica.org)
//
// Ce logiciel est un programme informatique servant � g�rer du contenu et des
// applications web.
                                                                                                      
// Ce logiciel est r�gi par la licence CeCILL soumise au droit fran�ais et
// respectant les principes de diffusion des logiciels libres. Vous pouvez
// utiliser, modifier et/ou redistribuer ce programme sous les conditions
// de la licence CeCILL telle que diffus�e par le CEA, le CNRS et l'INRIA 
// sur le site "http://www.cecill.info".

// En contrepartie de l'accessibilit� au code source et des droits de copie,
// de modification et de redistribution accord�s par cette licence, il n'est
// offert aux utilisateurs qu'une garantie limit�e.  Pour les m�mes raisons,
// seule une responsabilit� restreinte p�se sur l'auteur du programme,  le
// titulaire des droits patrimoniaux et les conc�dants successifs.

// A cet �gard  l'attention de l'utilisateur est attir�e sur les risques
// associ�s au chargement,  � l'utilisation,  � la modification et/ou au
// d�veloppement et � la reproduction du logiciel par l'utilisateur �tant 
// donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � 
// manipuler et qui le r�serve donc � des d�veloppeurs et des professionnels
// avertis poss�dant  des  connaissances  informatiques approfondies.  Les
// utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation  du
// logiciel � leurs besoins dans des conditions permettant d'assurer la
// s�curit� de leurs syst�mes et ou de leurs donn�es et, plus g�n�ralement, 
// � l'utiliser et l'exploiter dans les m�mes conditions de s�curit�. 

// Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez 
// pris connaissance de la licence CeCILL, et que vous en avez accept� les
// termes.
// ----
// CVS : $Id: pap_rendu.inc.php,v 1.40.4.2 2007-11-29 10:52:30 jp_milcent Exp $
/**
* Rendu : programme traitant l'url demand�e et retournant la page compress� au navigateur.
*
* Ce programme contient la partie collectant les informations sur la page demand�e par le navigateur client.
* Elle v�rifie que la page ne soit pas d�j� pr�sente en cache et la renvoie si elle est disponible.
* Elle recherche ensuite l'application li�e � la page demand�e. Elle ex�cute cette application et r�cup�re le
* contenu XHTML � afficher, le stocke en cache, le compresse et le renvoi au navigateur client.
*
*@package Papyrus
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Laurent COUDOUNEAU <laurent.coudouneau@ema.fr>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.40.4.2 $ $Date: 2007-11-29 10:52:30 $
// +------------------------------------------------------------------------------------------------------+
*/

// TODO : revoir les initialisation en l'absence de menu par defaut

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

/** Inclusion de la biblioth�que de fonctions servant � l'insertion de meta informations pour une page donn�e.*/
include_once GEN_CHEMIN_BIBLIO.'pap_meta.fonct.php';

/** Inclusion de la biblioth�que de fonctions servant � l'insertion de styles pour une page donn�e.*/
include_once GEN_CHEMIN_BIBLIO.'pap_style.fonct.php';

/** Inclusion de la biblioth�que de fonctions servant � l'insertion de scripts pour une page donn�e.*/
include_once GEN_CHEMIN_BIBLIO.'pap_script.fonct.php';

/** Inclusion de la classe servant au rendu de Papyrus.*/
include_once GEN_CHEMIN_BIBLIO_CLASSE.'pap_rendu.class.php';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// Recherche du squelette de la page demand�e.


// Ouverture du squelette
if (empty($GLOBALS['_GEN_commun']['info_menu']->gm_fichier_squelette)) {
    if (isset($GLOBALS['_GEN_commun']['traduction_info_site'])) {
        $GLOBALS['_PAPYRUS_']['general']['chemin_squelette'] = $GLOBALS['_GEN_commun']['traduction_info_site']->gs_fichier_squelette;
    } else {
        $GLOBALS['_PAPYRUS_']['general']['chemin_squelette'] = $GLOBALS['_GEN_commun']['info_site']->gs_fichier_squelette;
    }
} else {
    if (isset($GLOBALS['_GEN_commun']['traduction_info_menu'])) {
        $GLOBALS['_PAPYRUS_']['general']['chemin_squelette'] = $GLOBALS['_GEN_commun']['traduction_info_menu']->gm_fichier_squelette;
    } else {
        $GLOBALS['_PAPYRUS_']['general']['chemin_squelette'] = $GLOBALS['_GEN_commun']['info_menu']->gm_fichier_squelette;
    }
}

// Si l'information concernant le chemin est r�ellement un chemin
if (! file_exists($GLOBALS['_PAPYRUS_']['general']['chemin_squelette'])) {
    //Si ce n'est qu'un nom de fichier squelette
    $GLOBALS['_PAPYRUS_']['general']['chemin_test'] =  GEN_CHEMIN_SITES.
                    $GLOBALS['_GEN_commun']['info_site']->gs_code_alpha.'/'.
                    $GLOBALS['_GEN_commun']['i18n'].'/'.GEN_DOSSIER_SQUELETTE.'/'.$GLOBALS['_PAPYRUS_']['general']['chemin_squelette'];
    if (! file_exists($GLOBALS['_PAPYRUS_']['general']['chemin_test'])) {
        die('ERREUR Papyrus : Impossible de trouver de fichier de squelette. <br />'.
            'Chemin fichier squelette : '.$GLOBALS['_PAPYRUS_']['general']['chemin_squelette'].' <br />'.
            'Ligne n� : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__ );
    } else {
        $GLOBALS['_PAPYRUS_']['general']['chemin_squelette'] = $GLOBALS['_PAPYRUS_']['general']['chemin_test'];
    }
}

// +------------------------------------------------------------------------------------------------------+
// R�cup�ration du contenu du fichier de squelette de la page demand�e.
/*
// Lecture du fichier de squelette XHTML en PHP 4.1.2
$tab_fichier_squelette = file($chemin_squelette);
$contenu_squelette = '';
for ($i = 0; $i < count($tab_fichier_squelette); $i++) {
    $contenu_squelette .= $tab_fichier_squelette[$i];
}
*/
// Lecture du fichier de squelette XHTML en PHP 4.3




// +------------------------------------------------------------------------------------------------------+
// Gestion des traductions

// Si le r<E9>sultat de la n<E9>gociation de l'internationalisation donne une langue diff<E9>rente
//  de celle du site principal, nous r<E9>cup<E9>rons les <E9>ventuelles valeurs traduite pour le site.


$id_langue = $GLOBALS['_GEN_commun']['i18n'];

if (isset($id_langue) && ($id_langue!='')) {
       $langue_test=$id_langue;
} else {
       $langue_test=GEN_I18N_ID_DEFAUT;
}

    $requete =  'SELECT * '.
                'FROM gen_site '.
                'WHERE gs_ce_i18n = "'.$langue_test.'" '.
//                'WHERE gs_ce_i18n = "'.$_GEN_commun['i18n'].'" '.
                'AND gs_code_num = "'.$GLOBALS['_GEN_commun']['info_site']->gs_code_num.'"';
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    // Nous cr<E9><E9>ons l'entr<E9>e 'traduction_info_site' dans _GEN_commun que si nous avons bien trouv<E9> une
    // traduction pour le site. Il faut donc tester l'existence de cette entr<E9>e avant de l'utiliser.


    if ($resultat->numRows() > 0) {
        $GLOBALS['_GEN_commun']['traduction_info_site'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    }
    $resultat->free();

// Si le r<E9>sultat de la n<E9>gociation de l'internationalisation donne une langue diff<E9>rente
//  de celle du menu, nous r<E9>cup<E9>rons les <E9>ventuelles valeurs traduite pour le menu.

   // si pas d'application, $GLOBALS['_GEN_commun']['info_menu'] => NULL
   // donc on test pour pr�venir d'une erreur en bas de page :
   // trying to get property of non-object element.
   // --julien
   if(isset($GLOBALS['_GEN_commun']['info_menu']))
   {
    
	    // R<E9>cup<E9>ration des informations sur la traduction du menu
	    $requete =  'SELECT * '.
	                'FROM gen_menu '.
	                'WHERE gm_ce_i18n = "'.$langue_test.'" '.
	//                'WHERE gm_ce_i18n = "'.$_GEN_commun['i18n'].'" '.
	                'AND gm_code_num = "'.$GLOBALS['_GEN_commun']['info_menu']->gm_code_num.'"';
	
	    $resultat = $db->query($requete);
	    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	
	    // Nous cr<E9><E9>ons l'entr<E9>e 'traduction_info_menu' dans _GEN_commun que si nous avons bien trouv<E9> une
	    // traduction pour le menu. Il faut donc tester l'existence de cette entr<E9>e avant de l'utiliser.
	    if ($resultat->numRows() > 0) {
	        $_GEN_commun['traduction_info_menu'] = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
	    }
	    $resultat->free();
   }


if (isset($GLOBALS['_GEN_commun']['traduction_info_site'])) {
       $type_site='traduction_info_site';
}
else {
       $type_site='info_site';
}

if (isset($GLOBALS['_GEN_commun']['traduction_info_menu'])) {
       $type_menu='traduction_info_menu';
}
else {
       $type_menu='info_menu';
}


$GLOBALS['_PAPYRUS_']['general']['contenu_squelette'] = file_get_contents($GLOBALS['_PAPYRUS_']['general']['chemin_squelette']);

// +------------------------------------------------------------------------------------------------------+
// Recherche des informations pour la compl�tion de l'ent�te du squelette de la page demand�e.

if (isset($GLOBALS['_GEN_commun'][$type_menu])) {
	// Construction du titre.
	if (! empty($GLOBALS['_GEN_commun'][$type_menu]->gm_titre)) {
	    $GLOBALS['_PAPYRUS_']['page']['titre'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_titre);
	} else if (! empty($GLOBALS['_GEN_commun']['info_menu']->gm_titre_alternatif)) {
	    $GLOBALS['_PAPYRUS_']['page']['titre'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_titre_alternatif);
	} else {
	    $GLOBALS['_PAPYRUS_']['page']['titre'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_nom);
	}
}
else {
	$GLOBALS['_PAPYRUS_']['page']['titre']='';
}	
$GLOBALS['_PAPYRUS_']['rendu']['TITRE_PAGE'] = $GLOBALS['_PAPYRUS_']['page']['titre'];

// Construction des infos sur le site
$GLOBALS['_PAPYRUS_']['page']['nom_site'] = htmlentities($GLOBALS['_GEN_commun'][$type_site]->gs_nom);
$GLOBALS['_PAPYRUS_']['rendu']['SITE_NOM'] = $GLOBALS['_PAPYRUS_']['page']['nom_site'];
$GLOBALS['_PAPYRUS_']['page']['langue_site'] = htmlentities($GLOBALS['_GEN_commun']['i18n']);
$GLOBALS['_PAPYRUS_']['rendu']['SITE_LANGUE'] = $GLOBALS['_PAPYRUS_']['page']['langue_site'];
$GLOBALS['_PAPYRUS_']['page']['code_alpha_site'] = htmlentities($GLOBALS['_GEN_commun'][$type_site]->gs_code_alpha);
$GLOBALS['_PAPYRUS_']['rendu']['SITE_CODE_ALPHA'] = $GLOBALS['_PAPYRUS_']['page']['code_alpha_site'];

// Construction des infos sur le menu pour g�n�rer les balises
$GLOBALS['_PAPYRUS_']['rendu']['INFO_MENU_ID'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_id_menu);
$GLOBALS['_PAPYRUS_']['rendu']['INFO_MENU_CODE_ALPHA'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_code_alpha);
$GLOBALS['_PAPYRUS_']['rendu']['INFO_MENU_CODE_NUM'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_code_num);

//Construction des infos sur le contexte d'affichage de la page
$une_url = new Net_URL();
$une_url->addQueryString("site",$GLOBALS['_GEN_commun']['url_site']);
$une_url->removeQueryString("langue");
$GLOBALS['_PAPYRUS_']['rendu']['PAGE_URL'] = $une_url->getUrl();


// Construction des Meta "http-equiv".
$_GEN_commun['meta_http_equiv'] = array();
$GLOBALS['_PAPYRUS_']['page']['jeu_de_caracteres'] = htmlentities(strtoupper($_GEN_commun['info_i18n']->gi_jeu_de_caracteres));
$GLOBALS['_PAPYRUS_']['rendu']['SITE_JEU_DE_CARACTERES'] = $GLOBALS['_PAPYRUS_']['page']['jeu_de_caracteres'];
$GLOBALS['_PAPYRUS_']['page']['langue'] = htmlentities($GLOBALS['_GEN_commun']['info_i18n_langue']->gil_id_langue);
$GLOBALS['_PAPYRUS_']['rendu']['SITE_LANGUE'] = $GLOBALS['_PAPYRUS_']['page']['langue'];
GEN_stockerMetaHttpEquiv('Content-Type', 'text/html; charset='.$GLOBALS['_PAPYRUS_']['page']['jeu_de_caracteres']);
GEN_stockerMetaHttpEquiv('Content-style-type', 'text/css');
GEN_stockerMetaHttpEquiv('Content-script-type', 'text/javascript');
GEN_stockerMetaHttpEquiv('Content-language', $GLOBALS['_PAPYRUS_']['page']['langue']);

// Construction des Meta "name".
$GLOBALS['_GEN_commun']['meta_name'] = array();
if (isset($GLOBALS['_GEN_commun'][$type_menu])) {
	$GLOBALS['_PAPYRUS_']['page']['robot'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_robot);
	$GLOBALS['_PAPYRUS_']['page']['auteur'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_auteur);
}
else {
	$GLOBALS['_PAPYRUS_']['page']['robot'] = '';
	$GLOBALS['_PAPYRUS_']['page']['auteur'] = '';
}
		
if (empty($GLOBALS['_PAPYRUS_']['page']['auteur'])) {
    $GLOBALS['_PAPYRUS_']['page']['auteur'] = htmlentities($GLOBALS['_GEN_commun'][$type_site]->gs_auteur);
}
if (isset($GLOBALS['_GEN_commun']['info_menu'])) {
	$GLOBALS['_PAPYRUS_']['page']['mots_cles'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_mots_cles);
}
if (empty($GLOBALS['_PAPYRUS_']['page']['mots_cles'])) {
    $GLOBALS['_PAPYRUS_']['page']['mots_cles'] = htmlentities($GLOBALS['_GEN_commun'][$type_site]->gs_mots_cles);
}
if (isset($GLOBALS['_GEN_commun']['info_menu'])) {
	$GLOBALS['_PAPYRUS_']['page']['description_libre'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_description_libre);
}
if (empty($GLOBALS['_PAPYRUS_']['page']['description_libre'])) {
    $GLOBALS['_PAPYRUS_']['page']['description_libre'] = htmlentities($GLOBALS['_GEN_commun'][$type_site]->gs_description);
}


GEN_stockerMetaName('revisit-after', '15 days');
GEN_stockerMetaName('robots', $GLOBALS['_PAPYRUS_']['page']['robot']);
GEN_stockerMetaName('author', $GLOBALS['_PAPYRUS_']['page']['auteur']);
GEN_stockerMetaName('keywords', $GLOBALS['_PAPYRUS_']['page']['mots_cles']);
GEN_stockerMetaName('description', $GLOBALS['_PAPYRUS_']['page']['description_libre']);

// Construction des Meta Meta "name" du Dublin Core.

if (isset($GLOBALS['_GEN_commun']['info_menu'])) { 
	$GLOBALS['_PAPYRUS_']['page']['titre_alternatif'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_titre_alternatif);
	$GLOBALS['_PAPYRUS_']['page']['auteur'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_auteur);
	$GLOBALS['_PAPYRUS_']['page']['description_resume'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_description_resume);
	$GLOBALS['_PAPYRUS_']['page']['description_table_matieres'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_description_table_matieres);
	$GLOBALS['_PAPYRUS_']['page']['publieur'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_editeur);
	$GLOBALS['_PAPYRUS_']['page']['contributeur'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_contributeur);
	$GLOBALS['_PAPYRUS_']['page']['date_creation'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_date_creation);
	$GLOBALS['_PAPYRUS_']['page']['date_soumission'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_date_soumission);
	$GLOBALS['_PAPYRUS_']['page']['date_acceptation'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_date_acceptation);
	$GLOBALS['_PAPYRUS_']['page']['periode_validite'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_date_debut_validite);
	$GLOBALS['_PAPYRUS_']['page']['date_copyright'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_date_copyright);
	$GLOBALS['_PAPYRUS_']['page']['source'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_source);
}
else {
	$GLOBALS['_PAPYRUS_']['page']['titre_alternatif'] = '';
	$GLOBALS['_PAPYRUS_']['page']['auteur'] = '';
	$GLOBALS['_PAPYRUS_']['page']['description_resume'] = '';
	$GLOBALS['_PAPYRUS_']['page']['description_table_matieres'] = '';
	$GLOBALS['_PAPYRUS_']['page']['publieur'] = '';
	$GLOBALS['_PAPYRUS_']['page']['contributeur'] = '';
	$GLOBALS['_PAPYRUS_']['page']['date_creation'] = '';
	$GLOBALS['_PAPYRUS_']['page']['date_soumission'] = '';
	$GLOBALS['_PAPYRUS_']['page']['date_acceptation'] = '';
	$GLOBALS['_PAPYRUS_']['page']['periode_validite'] = '';
	$GLOBALS['_PAPYRUS_']['page']['date_copyright'] = '';
	$GLOBALS['_PAPYRUS_']['page']['source'] = '';
}

if ((isset($GLOBALS['_GEN_commun']['info_i18n_pays'])) && ($GLOBALS['_GEN_commun']['info_i18n_pays']->gip_id_pays != '')) {
    $GLOBALS['_PAPYRUS_']['page']['langue_rfc_3066'] = $GLOBALS['_PAPYRUS_']['page']['langue'].'-'.htmlentities($GLOBALS['_GEN_commun']['info_i18n_pays']->gip_id_pays);
} else {
    $GLOBALS['_PAPYRUS_']['page']['langue_rfc_3066'] = $GLOBALS['_PAPYRUS_']['page']['langue'];
}
if (isset($GLOBALS['_GEN_commun']['info_menu'])) {
	$GLOBALS['_PAPYRUS_']['page']['type_portee_spatiale'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_ce_type_portee_spatiale);
	$GLOBALS['_PAPYRUS_']['page']['portee_spatiale'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_portee_spatiale);
	$GLOBALS['_PAPYRUS_']['page']['type_portee_temporelle'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_ce_type_portee_temporelle);
	$GLOBALS['_PAPYRUS_']['page']['portee_temporelle'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_portee_temporelle);
	$GLOBALS['_PAPYRUS_']['page']['licence'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_licence);
	$GLOBALS['_PAPYRUS_']['page']['public'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_public);
	$GLOBALS['_PAPYRUS_']['page']['public_niveau'] = htmlentities($GLOBALS['_GEN_commun'][$type_menu]->gm_public_niveau);
}
else {
	$GLOBALS['_PAPYRUS_']['page']['type_portee_spatiale'] = '';
	$GLOBALS['_PAPYRUS_']['page']['portee_spatiale'] = '';
	$GLOBALS['_PAPYRUS_']['page']['type_portee_temporelle'] = '';
	$GLOBALS['_PAPYRUS_']['page']['portee_temporelle'] = '';
	$GLOBALS['_PAPYRUS_']['page']['licence'] = '';
	$GLOBALS['_PAPYRUS_']['page']['public'] = '';
	$GLOBALS['_PAPYRUS_']['page']['public_niveau'] = '';
	
}

GEN_stockerMetaNameDC('DC.Title', $GLOBALS['_PAPYRUS_']['page']['titre'], $GLOBALS['_PAPYRUS_']['page']['langue']);
GEN_stockerMetaNameDC('DC.Title.alternative', $GLOBALS['_PAPYRUS_']['page']['titre_alternatif'], $GLOBALS['_PAPYRUS_']['page']['langue']);
GEN_stockerMetaNameDC('DC.Creator', $GLOBALS['_PAPYRUS_']['page']['auteur']);
GEN_stockerMetaNameDC('DC.Subject', $GLOBALS['_PAPYRUS_']['page']['mots_cles'], $GLOBALS['_PAPYRUS_']['page']['langue']);
GEN_stockerMetaNameDC('DC.Description', $GLOBALS['_PAPYRUS_']['page']['description_libre'], $GLOBALS['_PAPYRUS_']['page']['langue']);
GEN_stockerMetaNameDC('DC.Description.abstract', $GLOBALS['_PAPYRUS_']['page']['description_resume'], $GLOBALS['_PAPYRUS_']['page']['langue']);
GEN_stockerMetaNameDC('DC.Description.tableOfContents', $GLOBALS['_PAPYRUS_']['page']['description_table_matieres'], $GLOBALS['_PAPYRUS_']['page']['langue']);
GEN_stockerMetaNameDC('DC.Publisher', $GLOBALS['_PAPYRUS_']['page']['publieur']);
GEN_stockerMetaNameDC('DC.Contributor', $GLOBALS['_PAPYRUS_']['page']['contributeur']);
GEN_stockerMetaNameDC('DC.Date.created', $GLOBALS['_PAPYRUS_']['page']['date_creation'], '', 'W3CDTF');
GEN_stockerMetaNameDC('DC.Date.valid', $GLOBALS['_PAPYRUS_']['page']['periode_validite'], '', 'W3CDTF');
//Ajouter la gestion des dates valid et available en utilisant les dates de la table gen_page_contenu.
GEN_stockerMetaNameDC('DC.Date.dateSubmitted', $GLOBALS['_PAPYRUS_']['page']['date_soumission'], '', 'W3CDTF');
GEN_stockerMetaNameDC('DC.Date.dateCopyrighted', $GLOBALS['_PAPYRUS_']['page']['date_copyright'], '', 'W3CDTF');
GEN_stockerMetaNameDC('DC.Date.dateAccepted', $GLOBALS['_PAPYRUS_']['page']['date_acceptation'], '', 'W3CDTF');
GEN_stockerMetaNameDC('DC.Source', $GLOBALS['_PAPYRUS_']['page']['source'], '', 'URI');
GEN_stockerMetaNameDC('DC.Language', $GLOBALS['_PAPYRUS_']['page']['langue_rfc_3066'], '', 'RFC3066');
GEN_stockerMetaNameDC('DC.Coverage.spatial', $GLOBALS['_PAPYRUS_']['page']['portee_spatiale'], '', $GLOBALS['_PAPYRUS_']['page']['type_portee_spatiale']);
GEN_stockerMetaNameDC('DC.Coverage.temporal', $GLOBALS['_PAPYRUS_']['page']['portee_temporelle'], '', $GLOBALS['_PAPYRUS_']['page']['type_portee_temporelle']);
GEN_stockerMetaNameDC('DC.Rights', $GLOBALS['_PAPYRUS_']['page']['licence'], '', 'URI');
GEN_stockerMetaNameDC('DC.Audience', $GLOBALS['_PAPYRUS_']['page']['public']);
GEN_stockerMetaNameDC('DC.Audience.educationLevel', $GLOBALS['_PAPYRUS_']['page']['public_niveau']);

// Construction des CSS
// D�claration des constantes contenant les CSS � afficher sur la page.
$GLOBALS['_GEN_commun']['style_type']  = 'text/css';
$GLOBALS['_GEN_commun']['style_integree']  = '';
$GLOBALS['_GEN_commun']['style_externe']   = array();

// Construction du Javascript
// D�claration des constantes contenant le Javascript � afficher sur la page.
$GLOBALS['_GEN_commun']['script_type']    = 'text/javascript';
$GLOBALS['_GEN_commun']['script_code']     = '';
$GLOBALS['_GEN_commun']['script_fonction'] = array();
$GLOBALS['_GEN_commun']['script_fichier']  = array();

// +------------------------------------------------------------------------------------------------------+
// Gestion de l'espace de nom pour les balise Papyrus
$GLOBALS['_GEN_commun']['balise_prefixe'] = 'PAPYRUS_';
$GLOBALS['_GEN_commun']['balise_prefixe_client'] = 'CLIENT_';

// +------------------------------------------------------------------------------------------------------+
// Gestion des inclusions des fichiers d'applettes pr�sentes dans le squelette
// TODO : Supprimer des fichiers du coeur de Papyrus, pr�c�dent ce fichier, la variable : $_GEN_commun['info_applette']
$GLOBALS['_PAPYRUS_']['info_applette'] = array();
$PapRendu = new Pap_Rendu();
$PapRendu->parserBaliseApplette($GLOBALS['_PAPYRUS_']['general']['contenu_squelette']);

// +------------------------------------------------------------------------------------------------------+
// Gestion de l'int�gration de l'application li�e au menu

// Une fois les applettes appel�es et execut�es nous appelons l'application qui peut avoir
// besoins des infos des applettes (c'est le cas, pour l'applette IDENTIFICATION).
$GLOBALS['_PAPYRUS_']['general']['application_chemin'] = '';
if (isset($GLOBALS['_GEN_commun']['info_application']->gap_chemin)) {
    $GLOBALS['_PAPYRUS_']['general']['application_chemin'] = $GLOBALS['_GEN_commun']['info_application']->gap_chemin;
}

// Affichage contenu si identifi� (parametre : lecture = + )

$lecture = 0;
if ((isset($GLOBALS['_GEN_commun']['info_application']->lecture)) && ($GLOBALS['_GEN_commun']['info_application']->lecture=="+")) {
	if ($GLOBALS['_GEN_commun']['pear_auth']->getAuth()) {
		$lecture=1;
	}
}
// Emplacement pour traiter les futurs cas :
else {
	$lecture=1;
}

if (!$lecture) {
	function afficherContenuCorps()
    {
        return '<p class="pap_erreur">'.'Pas autoris�, veuillez vous identifier.'.'</p>';
    }
}

// $application_chemin contient le chemin de l'application
// Si $application_chemin est vide, on d�fini putFrame comme ne retournant rien.

if (empty($GLOBALS['_PAPYRUS_']['general']['application_chemin']) ) {
    function afficherContenuCorps()
    {
        return '<p class="pap_erreur">'.'Pas d\'application.'.'</p>';
    }
} else {
    if (file_exists($GLOBALS['_PAPYRUS_']['general']['application_chemin'])) {
    	if (!function_exists('afficherContenuCorps')) {
        	include_once($GLOBALS['_PAPYRUS_']['general']['application_chemin']);
    	} 
    } else {
        die('ERREUR Papyrus : application impossible � charger. <br />'.
            'Chemin application : '.$GLOBALS['_PAPYRUS_']['general']['application_chemin'].' <br />'.
            'Ligne n� : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__ );
    }
}


	
// +------------------------------------------------------------------------------------------------------+
// Recherche des informations provenant de l'application pour la compl�tion du squelette

// Contenu navigation
// Appel de la fonction afficherContenuNavigation() si elle existe.
$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_NAVIGATION'] = (function_exists('afficherContenuNavigation') ? afficherContenuNavigation() : '<!-- '.'Aucune navigation'.' -->');

// Contenu t�te
// Appel de la fonction afficherContenuTete() si elle existe.
$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_TETE'] = (function_exists('afficherContenuTete') ? afficherContenuTete() : '<!-- '.'Aucun contenu t�te'.' -->');

// Contenu corps
// Appel de la fonction afficherContenuCorps().
if (function_exists('afficherContenuCorps') ) {
    $GLOBALS['_PAPYRUS_']['rendu']['CONTENU_CORPS'] = afficherContenuCorps();
} else {
    $GLOBALS['_PAPYRUS_']['rendu']['CONTENU_CORPS'] = 
        'ERREUR Papyrus : fonction afficherContenuCorps() introuvable dans l\'application demand�e. <br />'.
        'Ligne n� : '. __LINE__ .'<br />'.
        'Fichier : '. __FILE__;
}

// Appel de la fonction afficherContenuMenu() si elle existe.
if (isset($GLOBALS['_PAPYRUS_']['rendu']['CONTENU_MENU'])) {
	$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_MENU'] .= (function_exists('afficherContenuMenu') ? afficherContenuMenu() : '<!-- '.'Aucun menu pour cette application'.' -->');
}
else {
	$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_MENU'] = (function_exists('afficherContenuMenu') ? afficherContenuMenu() : '<!-- '.'Aucun menu pour cette application'.' -->');
}

// Contenu pied
// Appel de la fonction afficherContenuPied() si elle existe.
$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_PIED'] = (function_exists('afficherContenuPied') ? afficherContenuPied() : '<!-- '.'Aucun contenu pied'.' -->');

// Compilation du contenu de l'application
$GLOBALS['_PAPYRUS_']['general']['contenu_application'] = 	$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_NAVIGATION'].
															$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_TETE'].
															$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_CORPS'].
															$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_MENU'].
															$GLOBALS['_PAPYRUS_']['rendu']['CONTENU_PIED'];

// +------------------------------------------------------------------------------------------------------+
// Continuation recherche d'info provenant de Papyrus pour la compl�tion du squelette

// Une fois l'application appel� est execut� nous affichons le contenu de l'ent�te qui a pu 
// �tre modifi� par l'application.
$GLOBALS['_PAPYRUS_']['rendu']['META_HTTP_EQUIV'] = GEN_afficherMeta('http-equiv');
$GLOBALS['_PAPYRUS_']['rendu']['META_NAME'] = GEN_afficherMeta('name');
$GLOBALS['_PAPYRUS_']['rendu']['META_NAME_DC'] = GEN_afficherMeta('dc');
// Nous r�cup�rons tout les styles CSS pour l'afficher dans l'ent�te de la page.
$GLOBALS['_PAPYRUS_']['rendu']['STYLES'] = GEN_afficherStyle();
// Nous r�cup�rons tout le Javascript pour l'afficher dans l'ent�te de la page.
$GLOBALS['_PAPYRUS_']['rendu']['SCRIPTS'] = GEN_afficherScript();
$GLOBALS['_PAPYRUS_']['rendu']['VERSION'] = PAP_VERSION;

// +------------------------------------------------------------------------------------------------------+
// Remplacement des balises des applettes de Papyrus et des Clients dans le squelette avant les appli
$PapRendu->remplacerBaliseApplette();

// +------------------------------------------------------------------------------------------------------+
// Gestion des inclusions des fichiers d'applettes pr�sentes dans le contenu g�n�r� par l'application
if (!isset($GLOBALS['_PAPYRUS_']['applette']['analyse']) || $GLOBALS['_PAPYRUS_']['applette']['analyse'] == true) {
	// Puisque l'application autorise l'analyse, nous l'effectuons:
	$PapRendu->parserBaliseApplette($GLOBALS['_PAPYRUS_']['general']['contenu_application'], true);
}

// +------------------------------------------------------------------------------------------------------+
// Remplacement des balises Papyrus dans le squelette, le contenu g�n�r� par l'appli est remplac�.
foreach ($GLOBALS['_PAPYRUS_']['rendu'] as $GLOBALS['_PAPYRUS_']['tmp']['cle'] => $GLOBALS['_PAPYRUS_']['tmp']['val']) {
    $GLOBALS['_PAPYRUS_']['general']['contenu_squelette'] = 
                    str_replace(   '<!-- '.$_GEN_commun['balise_prefixe'].$GLOBALS['_PAPYRUS_']['tmp']['cle'].' -->',
                                    $GLOBALS['_PAPYRUS_']['tmp']['val'], 
                                    $GLOBALS['_PAPYRUS_']['general']['contenu_squelette']);
}

// +------------------------------------------------------------------------------------------------------+
// Remplacement des balises des applettes de Papyrus et des Clients dans le contenu de l'application si n�cessaire
if ($PapRendu->getBoolBaliseAppli()) {
	$PapRendu->remplacerBaliseApplette();
}

// +------------------------------------------------------------------------------------------------------+
// Stokage du squelette dans un variable globale apr�s avoir remplacer les balises Papyrus.
$GLOBALS['_GEN_commun']['sortie'] = $GLOBALS['_PAPYRUS_']['general']['contenu_squelette'];

/* +--Fin du code ---------------------------------------------------------------------------------------+
*
* $Log: pap_rendu.inc.php,v $
* Revision 1.40.4.2  2007-11-29 10:52:30  jp_milcent
* Correction du bogue nom de balise identique à une applette.
*
* Revision 1.40.4.1  2007-11-27 14:01:10  alexandre_tb
* Ajout de balise Papyrus concernant le menu.
*
* Revision 1.40  2007/04/20 14:08:24  neiluj
* correction bug
*
* Revision 1.39  2007/04/19 16:54:52  ddelon
* backport mulitlinguisme
*
* Revision 1.38  2007/04/19 15:34:35  neiluj
* préparration release (livraison) "Narmer" - v0.25
*
* Revision 1.37  2007/04/13 09:41:09  neiluj
* réparration cvs
*
* Revision 1.36  2006/12/13 17:17:41  jp_milcent
* Suppression de l'analyse par Text_Wiki.
*
* Revision 1.35  2006/12/12 17:15:57  jp_milcent
* Correction bogue : mauvais ordre pour parser les balises.
*
* Revision 1.34  2006/12/12 13:56:33  jp_milcent
* Modification de l'ordre de remplacement des balises pour permettre aux apllettes d'int�ragir sur le contenu de l'application.
*
* Revision 1.33  2006/12/08 15:59:17  jp_milcent
* Suppression de code inutile.
*
* Revision 1.32  2006/12/01 17:05:34  florian
* Correction bogue d'op�rateur.
*
* Revision 1.31  2006/12/01 16:59:45  florian
* Ajout d'une variable parametrant la recherche de balise d'applette dans le contenu g�n�r� par l'appli.
*
* Revision 1.30  2006/12/01 16:41:04  florian
* D�but gestion de l'appel des applettes dans le squelette comme dans le contenu g�n�r� par l'application.
*
* Revision 1.29  2006/04/20 09:45:30  alexandre_tb
* ligne 92, remplacement de gs_fichier_squelette par gm_fichier_squelette, car on appelle le squelette du menu (s'il existe) et non du site.
* Posait un pb lors de l'affichage de squelettes (de menu) des traductions de menu
*
* Revision 1.28  2006/03/13 21:00:20  ddelon
* Suppression messages d'erreur multilinguisme
*
* Revision 1.27  2006/03/02 13:45:27  ddelon
* Balise url page
*
* Revision 1.26  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.25  2005/12/09 15:07:07  florian
* suppression de debogage.css, pour optimiser les performances (c'est intégré dans la feuille de style par défaut dorénavant)
*
* Revision 1.24.2.6  2006/03/01 22:28:15  ddelon
* Balise url page
*
* Revision 1.24.2.5  2006/03/01 22:09:49  ddelon
* Balise url page
*
* Revision 1.24.2.4  2006/02/28 15:54:07  ddelon
* Integration branche principale
*
* Revision 1.24.2.3  2006/02/28 14:02:09  ddelon
* Finition multilinguisme
*
* Revision 1.24.2.2  2006/01/19 21:26:20  ddelon
* Multilinguisme site + bug ftp
*
* Revision 1.24.2.1  2005/12/20 14:40:24  ddelon
* Fusion Head vers Livraison
*
* Revision 1.25  2005/12/09 15:07:07  florian
* suppression de debogage.css, pour optimiser les performances (c'est intégré dans la feuille de style par défaut dorénavant)
*
* Revision 1.24  2005/10/21 22:22:16  ddelon
* projet wikini : fiche synthese
*
* Revision 1.23  2005/10/20 13:12:18  ddelon
* Gestion protection menu
*
* Revision 1.22  2005/10/20 10:28:25  ddelon
* Wikini complet dans l'int�grateur Wikini
*
* Revision 1.21  2005/10/17 13:41:34  ddelon
* Projet Wikini
*
* Revision 1.20  2005/10/17 10:52:00  jp_milcent
* Mise en majuscule du jeu de caract�re, conform�ment � la recommandation.
*
* Revision 1.19  2005/10/12 17:20:33  ddelon
* Reorganisation calendrier + applette
*
* Revision 1.18  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.17  2005/09/20 17:01:22  ddelon
* php5 et bugs divers
*
* Revision 1.16  2005/07/12 09:13:15  alexandre_tb
* d�placement de l'appel de la fonction afficherContenuMenu APRES l'appel de afficherContenuCorps.
* Le menu d'une application �tant calcul� apr�s les op�rations de l'application.
*
* Revision 1.15  2005/07/08 21:13:15  ddelon
* Gestion indentation menu
*
* Revision 1.14  2005/05/11 14:31:45  jpm
* Ajout de la fonction afficherContenuMenu() pour les applications.
*
* Revision 1.13  2005/04/21 16:46:39  jpm
* Gestion via Papyrus du XHTML de Text_Wiki_Papyrus.
*
* Revision 1.12  2005/03/02 11:04:36  jpm
* Modification de l'utilisation d'une variable globale.
*
* Revision 1.11  2005/02/28 11:20:42  jpm
* Modification des auteurs.
*
* Revision 1.10  2005/01/26 16:20:46  jpm
* Correction bogue meta : auteurs et mots-cl�s m�lang�s.
*
* Revision 1.9  2004/12/06 19:39:40  jpm
* Correction langue DC.
*
* Revision 1.8  2004/11/26 19:02:07  jpm
* Comptabilisation du nombre d'appel de chaque applette dans le squelette.
*
* Revision 1.7  2004/11/24 18:33:29  jpm
* Encapsulation des variables dans le tableau global _PAPYRUS_.
*
* Revision 1.6  2004/11/15 17:40:21  jpm
* Gestion d'un espace de nom pour les balises Papyrus.
*
* Revision 1.5  2004/10/26 18:42:54  jpm
* Gestion de la fonction de navigation pour les appli Papyrus.
*
* Revision 1.4  2004/10/25 16:28:47  jpm
* Ajout de nouvelles balises Papyrus, ajout v�rification mise � jour de Papyrus, meilleure gestion des sessions...
*
* Revision 1.3  2004/10/22 17:23:35  jpm
* Am�lioration de la gestion de l'erreur si pas d'appli.
*
* Revision 1.2  2004/06/17 08:04:44  jpm
* Changement de constante pour les chemin d'acc�s � la biblio de code de Papyrus.
*
* Revision 1.1  2004/06/16 08:13:58  jpm
* Changement de nom de G�n�sia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.32  2004/05/10 12:24:55  jpm
* Am�lioration de la recherche des fichiers de squelette.
*
* Revision 1.31  2004/05/05 10:42:35  jpm
* Am�lioration de la gestion de l'internationalisation.
*
* Revision 1.30  2004/05/05 08:25:37  jpm
* Modification de la fa�on d'ajouter la feuille de style de d�bogage pour qu'elle soit prise en compte par d�faut.
*
* Revision 1.29  2004/05/03 14:12:04  jpm
* Suppression du fichier biblioth�quie de fonctions sur gen_menu.
*
* Revision 1.28  2004/05/03 11:21:58  jpm
* Fin de la gestion des applettes et suppression de l'info_menu_hierarchie de _GEN_commun.
*
* Revision 1.27  2004/05/01 17:22:55  jpm
* Appel de la biblioth�que de fonctions concernant les menus.
*
* Revision 1.26  2004/05/01 16:19:36  jpm
* Suppression du code ayant pu �tre transform� en applettes (menu multi-niveaux, menu unique, menu commun, identification, s�lecteur de sites).
*
* Revision 1.25  2004/05/01 11:39:38  jpm
* D�placement du code g�rant les applettes et du code de r�cup�ration du contenu du fichier squelette.
*
* Revision 1.24  2004/04/28 12:04:31  jpm
* Changement du mod�le de la base de donn�es.
*
* Revision 1.23  2004/04/22 08:30:47  jpm
* Transformation de $GS_GLOBAL en $_GEN_commun.
*
* Revision 1.22  2004/04/21 07:55:02  jpm
* Ajout de la feuille de style de d�bogage si le d�bogage de G�n�sia est activ�.
*
* Revision 1.19  2004/04/09 16:20:54  jpm
* Extraction de la gestion du cache et de l'envoi.
* Gestion des tables i18n.
*
* Revision 1.18  2004/04/08 12:29:48  jpm
* D�but am�lioration de la gestion du cache et de la compression des pages de G�n�sia.
*
* Revision 1.17  2004/04/05 16:38:04  jpm
* Utilisation des nouvelles fonctions g�rant l'insertion du Javascript.
*
* Revision 1.16  2004/04/02 16:30:56  jpm
* Gestion de la balise G�n�sia IDENTIFICATION permettant l'envoie d'un formulaire de login.
*
* Revision 1.15  2004/04/01 11:27:13  jpm
* Ajout et modification de commentaires pour PhpDocumentor.
*
* Revision 1.14  2004/03/31 16:50:10  jpm
* Prise en compte du nouveau mod�le de G�n�sia r�vision 1.9.
*
* Revision 1.13  2004/03/27 11:07:45  jpm
* Modification des commentaires vis � vis du nouveau mod�le.
* Mise en conformit� avec la convention de codage.
* Am�lioration du code.
*
* Revision 1.12  2004/03/23 17:06:44  jpm
* Ajout de commentaire dans l'ent�te.
* Mise en conformit� avec la convention de codage.
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
