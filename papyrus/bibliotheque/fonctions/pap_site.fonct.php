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
// CVS : $Id: pap_site.fonct.php,v 1.8 2007-04-04 15:15:22 neiluj Exp $
/**
* Biblioth�que de fonctions concernant les sites.
*
* Biblioth�que de fonctions permettant de manipuler les tables :
* - gen_site,
* - gen_site_auth,
* - gen_site_auth_bdd,
* - gen_site_auth_ldap,
* - gen_site_categorie,
* - gen_site_categorie_valeur.
*
*@package Papyrus
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.8 $ $Date: 2007-04-04 15:15:22 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

/** Fonction GEN_lireInfoSites() - Renvoie un tableau contenant les lignes de la table gen_site
*
* Retourne un tableau contenant les lignes de la table gen_site pour les sites "classiques".
*
* @param  mixed  une instance de la classse Pear DB.
* @param  string  le mode dans Pear DB dans lequel on veut recevoir les infos du menu.
* @param  integer le type de site (par d�faut 102 = site "principal")
* @return array  un tableau contenant les lignes de la table gen_site pour les sites "principaux".
*/
function GEN_lireInfoSites(&$bdd, $mode = DB_FETCHMODE_OBJECT, $type_site = 102)
{
    $aso_sites = array();
    
    $requete =  'SELECT gen_site.* '.
                'FROM gen_site, gen_site_relation '.
                'WHERE gs_id_site = gsr_id_site_01 '.
                'AND gsr_id_site_01 = gsr_id_site_02 '.
                'AND gsr_id_valeur = '.$type_site.' '; // 102 = par d�faut site "principal"
    
    $resultat = $bdd->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    if ($resultat->numRows() > 0) {
        while ($ligne = $resultat->fetchRow($mode)) { 
            array_push($aso_sites, $ligne);
        }
    }
    $resultat->free();
    
    return $aso_sites;
}

/** Fonction GEN_lireInfoSitePrincipal() - Renvoie un objet contenant une ligne de la table gen_site
*
* Retourne la ligne de la table gen_site concernant le site principal ayant pour identifiant la valeur
* pass�e en param�tre.
*
* @param  mixed   une instance de la classse Pear DB.
* @param  string  l'identifiant du site.
* @param  string  le mode dans Pear DB dans lequel on veut recevoir les infos du menu.
* @return  mixed  un objet r�sultat de Pear DB contenant une ligne de la table gen_site, ou false en cas d'erreur.
*/
function GEN_lireInfoSitePrincipal(&$objet_pear_db, $site_id, $mode = DB_FETCHMODE_OBJECT)
{
    
    $requete =  'SELECT * '.
                'FROM gen_site, gen_site_relation '.
                'WHERE gs_id_site = '.$site_id.' '.
                'AND gs_id_site = gsr_id_site_01 '.
                'AND gsr_id_site_01 = gsr_id_site_02 '.
                'AND gsr_id_valeur = 102'; // 102 = site "principal"
    
    $resultat = $objet_pear_db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    if ($resultat->numRows() != 1) {
        // Impossible de r�cup�rer des informations sur le site principal ayant pour code alpha $code_alpha
        return false;
    }
    
    $info_site_principal = $resultat->fetchRow($mode);
    $resultat->free();
    
    return $info_site_principal;
}

/** Fonction GEN_lireInfoSitePrincipalCodeAlpha() - Renvoie un objet contenant une ligne de la table gen_site
*
* Retourne la ligne de la table gen_site concernant le site principal ayant pour code alphanum�rique la valeur
* pass�e en param�tre.
* Ancien nom : getProjectInfos()
*
* @param  mixed   une instance de la classse Pear DB.
* @param  string  le code alphanum�rique du site.
* @param  string  le mode dans Pear DB dans lequel on veut recevoir les infos du site.
* @return  mixed  un objet r�sultat de Pear DB contenant une ligne de la table gen_site, ou false en cas d'erreur.
*/
function GEN_lireInfoSitePrincipalCodeAlpha(&$objet_pear_db, $code_alpha, $mode = DB_FETCHMODE_OBJECT)
{
    
    $requete =  'SELECT * '.
                'FROM gen_site, gen_site_relation '.
                'WHERE gs_code_alpha = "'.$code_alpha.'" '.
                'AND gs_id_site = gsr_id_site_01 '.
                'AND gsr_id_site_01 = gsr_id_site_02 '.
                'AND gsr_id_valeur = 102 '; // 102 = site "principal"
    
    $resultat = $objet_pear_db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    if ($resultat->numRows() != 1) {
        // Impossible de r�cup�rer des informations sur le site principal ayant pour code alpha $code_alpha
        return false;
    }
    
    $info_site_principal = $resultat->fetchRow($mode);
    $resultat->free();
    
    return $info_site_principal;
}

/** Fonction GEN_lireInfoSiteI18nCodeAlpha() - Renvoie un objet contenant une ligne de la table gen_site
*
* Retourne la ligne de la table gen_site concernant un site ayant pour code alphanum�rique et identifiant
* i18n les valeurs pass�es en param�tres.
* Ancien nom :getSiteI18nInfos():
*
* @param  mixed   une instance de la classse Pear DB.
* @param  string  le code alphanum�rique du site recherch�.
* @param  string  l'identifiant i18n poss�d� par le site recherch�.
* @param  string  le mode dans Pear DB dans lequel on veut recevoir les infos du site.
* @return  mixed  un objet r�sultat de Pear DB contenant une ligne de la table gen_site, ou false en cas d'erreur.
*/
function GEN_lireInfoSiteI18nCodeAlpha(&$objet_pear_db, $code_alpha, $i18n, $mode = DB_FETCHMODE_OBJECT)
{
    $requete =  'SELECT * '.
                'FROM gen_site '.
                'WHERE gs_code_alpha = "'.$code_alpha.'" '.
                'AND gs_ce_i18n = "'.$i18n.'" ';
    
    $resultat = $objet_pear_db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    if ($resultat->numRows() != 1) {
        return false;
    }
    
    $info_site = $resultat->fetchRow($mode);
    $resultat->free();
    
    return $info_site;
}

/** Fonction GEN_retournerTableauTypeSiteExterne() - Renvoie un tableau des types site externe
*
* Retourne un tableau de tableaux associatifs contenant les valeurs des types des sites externes.
*
* @param  mixed   une instance de la classse Pear DB.
* @return  mixed  un tableau de tableaux associatifs contenant les valeurs des types des sites externes
*/
function GEN_retournerTableauTypeSiteExterne(&$objet_pear_db)
{
    $requete =  'SELECT * '.
                'FROM gen_site_categorie_valeur '.
                'WHERE gscv_id_categorie = 3 ';// 3 = type de site externe
    
    $resultat = $objet_pear_db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    if ($resultat->numRows() == 0) {
        return false;
    }
    $tab_type = array();
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ) {
        $aso_type_site_externe = array('id' => $ligne->gscv_id_valeur, 'intitule' => $ligne->gscv_intitule_valeur);
        array_push($tab_type, $aso_type_site_externe);
    }
    $resultat->free();
    
    return $tab_type;
}

/** Fonction GEN_retournerSiteCodeNum() - Renvoie le code num d'un site en fonction du code Alphanum�rique
*
* Retourne le code num�rique d'un site en fonction du code alphanum�rique.
*
* @param  mixed  une instance de la classe Pear DB.
* @param  string le code alphanum�rique d'un site.
* @return mixed le code num�rique du site sinon false.
*/
function GEN_retournerSiteCodeNum($db, $code_alphanum)
{
    //----------------------------------------------------------------------------
    // Recherche des informations sur le menu
    $requete =  'SELECT gs_code_num '.
                'FROM gen_site '.
                'WHERE gs_code_alpha = "'.$code_alphanum.'"';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    if ($resultat->numRows() != 1) {
        return false;
    }

    //----------------------------------------------------------------------------
    // R�cup�ration des infos
    $info_site = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $code_num = $info_site->gs_code_num;
    $resultat->free();

    return $code_num;
}

/** Fonction GEN_retournerSiteCodeAlpha() - Renvoie le code alphanum�rique d'un site en fonction du code num�rique
*
* Retourne le code alphanum�rique d'un site en fonction du code num�rique.
*
* @param  mixed  une instance de la classse Pear DB.
* @param  string le code num�rique d'un site.
* @return mixed le code alphanum�rique du site sinon false.
*/
function GEN_retournerSiteCodeAlpha($db, $code_num)
{
    //----------------------------------------------------------------------------
    // Recherche des informations sur le menu
    $requete =  'SELECT gs_code_alpha '.
                'FROM gen_site '.
                'WHERE gs_code_num = '.$code_num;

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    if ($resultat->numRows() != 1) {
        return false;
    }

    //----------------------------------------------------------------------------
    // R�cup�ration des infos
    $info_site = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $code_alphanum = $info_site->gs_code_alpha;
    $resultat->free();

    return $code_alphanum;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_site.fonct.php,v $
* Revision 1.8  2007-04-04 15:15:22  neiluj
* débug pour nom wiki
*
* Revision 1.7  2006/12/08 20:15:21  jp_milcent
* Correction bogue requete sql dans fonction GEN_lireInfoSiteI18nCodeAlpha().
*
* Revision 1.6  2006/12/08 18:48:43  jp_milcent
* Am�lioration du mode de reception des donn�es pour GEN_lireInfoSiteI18nCodeAlpha().
*
* Revision 1.5  2006/10/11 18:04:11  jp_milcent
* Gestion avanc�e de la r�ecriture d'URL.
*
* Revision 1.4  2005/04/19 17:21:19  jpm
* Utilisation des r�f�rences d'objets.
*
* Revision 1.3  2004/12/03 19:22:30  jpm
* Ajout d'une fonction retournant les types de sites externes g�r�s par Papyrus.
*
* Revision 1.2  2004/11/04 12:25:35  jpm
* Ajout d'une fonction permettant de r�cup�rer les infos sur un site � partir de son id.
*
* Revision 1.1  2004/06/15 15:13:37  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.1  2004/05/03 16:26:07  jpm
* Ajout de la biblioth�que de fonctions permettant de manipuler les informations issues des tables "gen_site_..." de G�n�sia.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
