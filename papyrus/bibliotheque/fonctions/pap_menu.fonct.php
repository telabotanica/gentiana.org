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
// CVS : $Id: pap_menu.fonct.php,v 1.31.2.3 2008-08-08 14:45:59 jp_milcent Exp $
/**
* Biblioth�que de fonction sur le rendu.
*
* Cette biblioth�que contient des fonctions utilis� par le rendu des pages de Papyrus.
*
*@package Papyrus
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Alexandre GRANIER <alexadandre@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.31.2.3 $ $Date: 2008-08-08 14:45:59 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            LISTE des FONCTIONS                                       |
// +------------------------------------------------------------------------------------------------------+

/** Fonction GEN_donnerProfondeurMax() - Renvoie le nombre de niveau de menu.
*
* Cette fonction calcule, pour un menu donn�, le nombre de niveau de menu fils compl�tant
* l'arbre des menus jusqu'au feuilles.
* Ici on l'utilise en passant l'argument �gal � z�ro c'est � dire
* en partant du menu racine d'un site gmr_id_menu_02 = 0.
* C'est une fonction r�cursive.
* Noter que la variable $prof est statique.
*
* @param integer identifiant du site sur lequel la profondeur est calcul�.
* @param integer identifiant du menu � partir duquel on souhaite calculer la profondeur.
* @return integer le nombre de niveau de menu.
*/
function GEN_donnerProfondeurMax($id_site, $id_menu)
{
    global $db;
    static $prof = 0;

    // Requ�te sur les relations de type "avoir p�re" entre menus
    $requete =  'SELECT gmr_id_menu_01 '.
                'FROM gen_menu, gen_menu_relation '.
                'WHERE gmr_id_menu_02 = '.$id_menu.' '.
                'AND gmr_id_menu_01 = gm_id_menu '.
                'AND gm_ce_site = '.$id_site.' '.
                'AND gmr_id_valeur = 1 '.
                'ORDER BY gmr_ordre ASC';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    if ($resultat->numRows() == 0) {
        return $prof;
    }
    $prof++;
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
        $prof = GEN_donnerProfondeurMax($id_site, $ligne->gmr_id_menu_01);
    }
    return $prof;
}

/** Fonction GEN_donnerProfondeur() - Renvoie le niveau du menu.
*
* Cette fonction calcule, pour un menu donn�, son niveau par rapport � la racine.
* C'est une fonction r�cursive.
* Noter que la variable $prof est statique.
*
* @param integer identifiant du site sur lequel la profondeur est calcul�.
* @param integer identifiant du menu dont on souhaite conna�tre la profondeur.
* @param integer profondeur de d�part (par d�faut 0). Ne devrait pas �tre modifi�...
* @return integer le nombre de niveau de menu.
*/
function GEN_donnerProfondeur($id_site, $id_menu, $prof = 0)
{
    global $db;

    // Requ�te sur les relations de type "avoir p�re" entre menus
    $requete =  'SELECT gmr_id_menu_02 '.
                'FROM gen_menu, gen_menu_relation '.
                'WHERE gmr_id_menu_01 = '.$id_menu.' '.
                'AND gmr_id_menu_01 = gm_id_menu '.
                'AND gm_ce_site = '.$id_site.' '.
                'AND gmr_id_valeur = 1 '.
                'ORDER BY gmr_ordre ASC';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    if ($resultat->numRows() != 0) {
	    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
	        $prof = GEN_donnerProfondeur($id_site, $ligne->gmr_id_menu_02, ++$prof);
	    }
    }
    return $prof;
}

/** Fonction GEN_donnerDernierFreres() - Renvoie l'id du dernier menu fr�re.
*
* Cette fonction regarde si un menu donn� poss�de au moins un fr�re dans l'arbre
* des menus. Elle retourne l'id du dernier menu fr�re en utilisant gmr_ordre.
* Cette fonction fait appel � la fonction : GEN_lireIdentifiantMenuPere().
*
* @param integer identifiant du menu.
* @return boolean renvoi l'id du dernier menu fr�re sinon faux.
*/
function GEN_donnerDernierFreres($id_menu)
{
    // Initialisation des variables.
    global $db;

    $requete =  'SELECT gmr_id_menu_01 '.
                'FROM gen_menu_relation '.
                'WHERE gmr_id_menu_02 = '.GEN_lireIdentifiantMenuPere($id_menu).' '.
                'AND gmr_id_valeur = 1 '.
                'AND gmr_id_menu_01 <> '.$id_menu.' '.
                'ORDER BY gmr_ordre DESC';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    if ($resultat->numRows() > 0) {
        return $ligne->gmr_id_menu_01;
    } else {
        return false;
    }
}

/** Fonction GEN_etreFreres() - Renvoie vrai si les menus ont le m�me p�re.
*
* Cette fonction regarde si deux menus donn�s sont fr�res dans l'arbre
* des menus. Nous regardons si les menus ont le m�me identifiant comme p�re.
*
* @param integer identifiant du premier menu.
* @param integer identifiant du seconde menu.
* @return boolean renvoi vrai si les deux menus sont fr�res sinon faux.
*/
function GEN_etreFreres($id_menu_1, $id_menu_2)
{
    // Initialisation des variables.
    global $db;

    $requete =  'SELECT gmr_id_menu_02 '.
                'FROM gen_menu_relation '.
                'WHERE gmr_id_menu_01 = '.$id_menu_1.' '.
                'AND gmr_id_valeur = 1 ';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $id_pere_1 = $ligne->gmr_id_menu_02;
    $resultat->free();

    $requete =  'SELECT gmr_id_menu_02 '.
                'FROM gen_menu_relation '.
                'WHERE gmr_id_menu_01 = '.$id_menu_2.' '.
                'AND gmr_id_valeur = 1 ';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $id_pere_2 = $ligne->gmr_id_menu_02;
    $resultat->free();

    return ($id_pere_1 == $id_pere_2);
}

/** Fonction GEN_etreAncetre() - Renvoie vrai si le premier argument (identifiant de menu) est un anc�tre du second.
*
* Nous r�cup�rons l'identifiant du p�re du menu pass� en argument num�ro 2. Puis,
* nous le comparons � l'argument 1. Si c'est les m�me on retourne faux. Sinon on rapelle
* la fonction avec l'identifiant du p�re trouv� pour l'argument 2. Ainsi de suite jusqu'a
* renvoy� vrai o� tomber sur un menu racine (idetifiant du p�re = 0).
* Si les variable sont null nous retournons false.
* C'est une fonction r�cursive.
*
* @param integer identifiant d'un menu num�ro 1.
* @param integer identifiant d'un menu num�ro 2.
* @return boolean vrai si le menu num�ro 1 est anc�tre du second.
*/
function GEN_etreAncetre($id_menu_1, $id_menu_2)
{
    //Test erreur
    if (is_null($id_menu_1) || is_null($id_menu_2)) {
        return false;
    }

    // Initialisation des variables.
    global $db;

    $requete =  'SELECT gmr_id_menu_02 '.
                'FROM gen_menu_relation '.
                'WHERE gmr_id_menu_01 = '.$id_menu_2.' '.
                'AND gmr_id_valeur = 1 ';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die (BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $resultat->free();
    if (isset($ligne)) {
	    if  ($ligne->gmr_id_menu_02 == 0) {
	        return false;
	    } else if ($ligne->gmr_id_menu_02 == $id_menu_1) {
	        return true;
	    } else {
	        return GEN_etreAncetre($id_menu_1, $ligne->gmr_id_menu_02);
	    }
    }
}

/** Fonction GEN_lireIdentifiantMenuAncetre() - Renvoie l'identifiant du menu anc�tre du menu pass� en param�tre.
*
*   Cette fonction parcours la table gen_menu_relation et retourne l'identifiant du
*   menu dont le p�re est le menu racine (identifiant = 0) pour le menu pass� en param�tre.
*
*   @global mixed   objet Pear DB de connexion � la base de donn�es..
*   @param  int     identifiant du menu dont il faut rechercher le p�re.
*   @return int     identifiant du menu anc�tre du menu pass� en param�tre.
*/
function GEN_lireIdentifiantMenuAncetre($id_menu)
{
    global $db;
    // On teste si on est au niveau d'un menu racine i.e GM_ID_PERE=0
    $requete =  'SELECT gmr_id_menu_02 '.
                'FROM gen_menu_relation '.
                'WHERE gmr_id_menu_01 = '.$id_menu.' '.
                'AND gmr_id_valeur = 1 ';// 1 = avoir "p�re"

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $resultat->free();

    // Dans le cas o� le menu en param�tre est un menu racine
    if ($ligne->gmr_id_menu_02 == 0) {
        return $id_menu;
    }

    return GEN_lireIdentifiantMenuAncetre($ligne->gmr_id_menu_02);
}

/** Fonction GEN_lireIdentifiantMenuPere() - Renvoie l'identifiant du p�re du menu pass� en param�tre.
*
* Cette fonction parcours la table gen_menu_relation et retourne l'identifiant du
* menu p�re du menu pass� en param�tre.
*
* @global mixed   objet Pear DB de connexion � la base de donn�es..
* @param  int     l'identifiant du fils
* @param  mixed     une instance de la classse Pear DB.
* @return mixed   l'identifiant du p�re,ou false en cas d'erreur.
*/
function GEN_lireIdentifiantMenuPere($id_menu, $db = null)
{
    if (is_null($db)) {
        $db =& $GLOBALS['_GEN_commun']['pear_db'];
    }

    $requete =  'SELECT gmr_id_menu_02 '.
                'FROM gen_menu_relation '.
                'WHERE gmr_id_menu_01 = '.$id_menu.' '.
                'AND gmr_id_valeur = 1 ';// 1 = avoir "p�re"

    $resultat = $db->getOne($requete) ;
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    return $resultat;
}

/** Fonction GEN_lireInfoMenu() - Renvoie un objet ou un tableau contenant une ligne de la table gen_menu
*
* Retourne la ligne de la table gen_menu concernant le menu ayant pour identifiant la valeur
* pass�e en param�tre.
* Ancien nom : getLevel()
*
* @param  mixed     une instance de la classse Pear DB.
* @param  int       l'identifiant d'un menu.
* @param  string    le mode dans Pear DB dans lequel on veut recevoir les infos du menu.
* @return  mixed    un objet ou tableau r�sultat de Pear DB contenant une ligne de la table gen_menu, ou false en cas d'erreur.
*/
function GEN_lireInfoMenu($db, $id_menu, $mode = DB_FETCHMODE_OBJECT)
{

    //----------------------------------------------------------------------------
    // Recherche des informations sur le menu
    $requete =  'SELECT * '.
                'FROM gen_menu '.
                'WHERE gm_id_menu = '.$id_menu;

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    if ($resultat->numRows() != 1) {
        return false;
    }

    //----------------------------------------------------------------------------
    // R�cup�ration des infos
    $info_menu = $resultat->fetchRow($mode);
    $resultat->free();

    return $info_menu;
}
/** Fonction GEN_retournerMenuCodeNum() - Renvoie le code num d'un menu en fonction du code Alphanum�rique
*
* Retourne le code num�rique d'un menu en fonction du code alphanum�rique.
*
* @param  mixed  une instance de la classse Pear DB.
* @param  string le code alphanum�rique d'un menu.
* @return mixed le code num�rique du menu sinon false.
*/
function GEN_retournerMenuCodeNum($db, $code_alphanum)
{
    //----------------------------------------------------------------------------
    // Recherche des informations sur le menu
    $requete =  'SELECT gm_code_num '.
                'FROM gen_menu '.
                'WHERE gm_code_alpha = "'.$code_alphanum.'"';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    if ($resultat->numRows() != 1) {
        return false;
    }

    //----------------------------------------------------------------------------
    // R�cup�ration des infos
    $info_menu = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $code_num = $info_menu->gm_code_num;
    $resultat->free();

    return $code_num;
}

/** Fonction GEN_retournerMenuCodeAlpha() - Renvoie le code alphanum�rique d'un menu en fonction du code num�rique
*
* Retourne le code alphanum�rique d'un menu en fonction du code num�rique.
*
* @param  mixed  une instance de la classse Pear DB.
* @param  string le code num�rique d'un menu.
* @return mixed le code alphanum�rique du menu sinon false.
*/
function GEN_retournerMenuCodeAlpha($db, $code_num)
{
    //----------------------------------------------------------------------------
    // Recherche des informations sur le menu
    $requete =  'SELECT gm_code_alpha '.
                'FROM gen_menu '.
                'WHERE gm_code_num = '.$code_num;

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    if ($resultat->numRows() != 1) {
        return false;
    }

    //----------------------------------------------------------------------------
    // R�cup�ration des infos
    $info_menu = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $code_alphanum = $info_menu->gm_code_alpha;
    $resultat->free();

    return $code_alphanum;
}

/** Fonction GEN_lireContenuMenu() - Renvoie un objet ou un tableau contenant une ligne de la table gen_menu_contenu
*
* Retourne la ligne de la table gen_menu_contenu concernant le menu ayant pour identifiant la valeur
* pass�e en param�tre. Seul la derni�re version du contenu du menu est retourn�.
*
* @param  mixed     une instance de la classse Pear DB.
* @param  int       l'identifiant d'un menu.
* @param  string    le mode dans Pear DB dans lequel on veut recevoir les infos du menu.
* @return  mixed    un objet ou tableau r�sultat de Pear DB contenant une ligne de la table gen_menu_contenu, ou false en cas d'erreur.
*/
function GEN_lireContenuMenu($db, $id_menu, $mode = DB_FETCHMODE_OBJECT)
{
    //----------------------------------------------------------------------------
    // Gestion des erreurs

    //----------------------------------------------------------------------------
    // Recherche des informations sur le menu
    $requete =  'SELECT * '.
                'FROM gen_menu_contenu '.
                'WHERE gmc_ce_menu = '.$id_menu.' '.
                'AND gmc_bool_dernier = 1';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    if ($resultat->numRows() != 1) {
        return false;
    }

    //----------------------------------------------------------------------------
    // R�cup�ration des infos
    $info_menu = $resultat->fetchRow($mode);
    $resultat->free();

    return $info_menu;
}

/** Fonction GEN_lireContenuMenuHistorique() - Renvoie un objet ou un tableau contenant une ligne de la table gen_menu_contenu
*
* Retourne la ligne de la table gen_menu_contenu concernant le menu ayant pour identifiant la valeur
* pass�e en param�tre. Toutes les versions archiv�es du contenu du menu sont retourn�es.
*
* @param  mixed     une instance de la classse Pear DB.
* @param  int       l'identifiant d'un menu.
* @param  string    le mode dans Pear DB dans lequel on veut recevoir les infos du menu.
* @return  mixed    un objet ou tableau r�sultat de Pear DB contenant une ligne de la table gen_menu_contenu, ou false en cas d'erreur.
*/
function GEN_lireContenuMenuHistorique($db, $id_menu, $mode = DB_FETCHMODE_OBJECT)
{
    //----------------------------------------------------------------------------
    // Gestion des erreurs

    //----------------------------------------------------------------------------
    // Recherche des informations sur le menu
    $requete =  'SELECT * '.
                'FROM gen_menu_contenu '.
                'WHERE gmc_ce_menu = '.$id_menu;

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    if ($resultat->numRows() < 1) {
        return false;
    }
	
	$resultat =& $db->query($requete);
    (PEAR::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	while ($menu_contenu = $resultat->fetchRow($mode)) {
		$aso_info[] = $menu_contenu;
	}
    return $aso_info;
}

/** Fonction GEN_retournerMenus() - Renvoie un tableau contenant les id de l'ensemble des menus
*
* Retourne un tableau contenant les id de l'ensemble des menus des diff�rents sites de Papyrus.
*
* @param  mixed     une instance de la classse Pear DB.
* @return array    tableau contenant les id de chaque menu.
*/
function GEN_retournerMenus($db)
{
    //----------------------------------------------------------------------------
    // Gestion des erreurs

    //----------------------------------------------------------------------------
    // Recherche des informations sur le menu
    $requete =  'SELECT gm_id_menu '.
                'FROM gen_menu ';

    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

    //----------------------------------------------------------------------------
    // R�cup�ration des infos
    $tab_retour = array();
    while ($info_menu = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
        array_push($tab_retour, $info_menu->gm_id_menu);
    }
    $resultat->free();

    return $tab_retour;
}

/** Fonction GEN_lireInfoMenuRelation() - Renvoie un objet ou un tableau contenant une ligne de la table gen_menu_relation
*
* Par d�faut recherche une relation de type p�re.
* Ancien nom : getMenuRelation().
*
* @param  mixed   Une instance de la classse PEAR_DB
* @param  int  l'identifiant d'un menu.
* @param  int  l'identifiant d'une valeur de relation.
* @param  string  le mode dans Pear DB dans lequel on veut recevoir les infos du menu.
* @return  mixed  un objet ou tableau r�sultat Pear DB, ou false en cas d'erreur.
*/
function GEN_lireInfoMenuRelation($db, $menuid, $id_valeur = 1, $mode = DB_FETCHMODE_OBJECT)
{
    //----------------------------------------------------------------------------
    // Recherche des informations sur la relation de menu
    $requete =  'SELECT * '.
                'FROM gen_menu_relation '.
                'WHERE gmr_id_menu_01 = '.$menuid.' '.
                'AND gmr_id_valeur = '.$id_valeur;

    $result = $db->query($requete);
    (DB::isError($result)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $result->getMessage(), $requete)) : '';

    if ($result->numRows() != 1) {
        return false;
    }

    //----------------------------------------------------------------------------
    // R�cup�ration des infos
    $info_menu_relation = $result->fetchRow($mode);
    $result->free();

    return $info_menu_relation;
}

/** Fonction GEN_verifierPresenceCodeMenu() - V�rifie l'existence d'un code de menu
*
* Permet de v�rifier dans la base de donn�es si le code fournie (alphanum�rique ou num�rique) a d�j�
* �t� attribu� � un menu ou pas!
*
* @param  mixed   Une instance de la classse PEAR_DB
* @param  string  le type du code (int ou string).
* @param  integer l'identifiant du menu courant.
* @param  mixed   le code num�rique ou alphanum�rique.
* @return mixed   retourne l'identifiant du menu poss�dant le code sinon false.
*/
function GEN_verifierPresenceCodeMenu($db, $type, $id_menu, $code)
{
    // Gestion des erreurs
    if ($code == '') {
        return true;
    }

    // Requete pour v�rifier l'abscence du code num�rique et alphanum�rique de la table gen_menu
    $requete =  'SELECT gm_id_menu '.
                'FROM gen_menu '.
                'WHERE gm_id_menu <> '.$id_menu.' ';

    // Compl�ment de requ�te en fonction du type de code
    if ($type == 'int') {
        $requete .= 'AND gm_code_num = '.$code;
    } else {
        $requete .= 'AND gm_code_alpha = "'.$code.'"';
    }
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
            die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    $nombre_reponse = $resultat->numRows();
    if ($nombre_reponse >= 1) {
        return true;
    } else {
        return false;
    }
}
/** Fonction GEN_lireInfoMenuMotsCles() - Renvoie un objet ou un tableau contenant des lignes de la table gen_menu
*
* Renvoie un objet ou un tableau contenant une ligne de la table gen_menu en fonction des mots cl�s pr�sents dans
* la table gen_menu.
*
* @param  mixed   Une instance de la classse PEAR_DB
* @param  array  un tableau de mots cl�s.
* @param  string  la condition s�parant chaque rechercher de mots-cl�s (AND ou OR).
* @param  string  l'ordre d'affichage des Menus (ASC ou DESC).
* @param  string  le mode dans Pear DB dans lequel on veut recevoir les infos du menu.
* @param  boolean  true pour grouper les r�sultats (voir Pear DB : getAssoc() ) sinon false.
* @return  mixed   un objet ou tableau r�sultat Pear DB, ou false en cas d'erreur.
*/
function GEN_lireInfoMenuMotsCles($db, $tab_mots, $condition = 'OR', $ordre = 'ASC', $mode = DB_FETCHMODE_OBJECT, $groupe = false)
{
    //----------------------------------------------------------------------------
    // Recherche des informations sur les menus en fonctions des mots cl�s
    $requete =  'SELECT DISTINCT * '.
                'FROM gen_menu '.
                'WHERE ';
    for ($i = 0; $i < count($tab_mots); $i++) {
        if ($i == 0) {
            $requete .= 'gm_mots_cles LIKE "%'.$tab_mots[$i].'%" ';
        } else {
            $requete .= $condition.' gm_mots_cles LIKE "%'.$tab_mots[$i].'%" ';
        }
    }
    $requete .= 'ORDER BY gm_date_creation '.$ordre;
    $aso_info =& $db->getAssoc($requete, false, array(), $mode, $groupe);
    (PEAR::isError($aso_info)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $aso_info->getMessage(), $requete)) : '';

    return $aso_info;
}

/** Fonction GEN_lireInfoMenuMeta() - Renvoie un objet ou un tableau contenant des lignes de la table gen_menu
*
* Renvoie un objet ou un tableau contenant une ligne de la table gen_menu en fonction des mots cl�s,
* cat�gories, id_menu,
* la table gen_menu.
*
* @param  mixed   Une instance de la classse PEAR_DB
* @param  array  un tableau de mots cl�s.
* @param  string  la condition s�parant chaque rechercher de mots-cl�s (AND ou OR).
* @param  string  l'ordre d'affichage des Menus (ASC ou DESC).
* @param  string  le mode dans Pear DB dans lequel on veut recevoir les infos du menu.
* @param  boolean  true pour grouper les r�sultats (voir Pear DB : getAssoc() ) sinon false.
* @return  mixed   un objet ou tableau r�sultat Pear DB, ou false en cas d'erreur.
*/
function GEN_lireInfoMenuMeta($db, $tab_mots, $tab_cat, $condition = 'OR', $condition2 = 'OR', $ordre = 'ASC', $mode = DB_FETCHMODE_OBJECT, $groupe = false)
{
    //----------------------------------------------------------------------------
    // Recherche des informations sur les menus en fonctions des mots cl�s
    $requete =  'SELECT DISTINCT * '.
                'FROM gen_menu '.
                'WHERE ';
    for ($i = 0; $i < count($tab_mots); $i++) {
        if ($tab_mots[$i] != '') {
	        if ($i == 0) {
	            $requete .= 'gm_mots_cles LIKE "%'.$tab_mots[$i].'%" ';
	        } else {
	            $requete .= $condition.' gm_mots_cles LIKE "%'.$tab_mots[$i].'%" ';
	        }
        }
    }
    if (count($tab_mots) != 0 && $tab_cat[0] != '') {
    	$requete .= 'AND ' ;
    }
    for ($i = 0; $i < count($tab_cat); $i++) {
        if ($tab_cat[$i] != '') {
	        if ($i == 0) {
	            $requete .= 'gm_categorie LIKE "%'.$tab_cat[$i].'%" ';
	        } else {
	            $requete .= $condition2.' gm_categorie LIKE "%'.$tab_cat[$i].'%" ';
	        }
        }
    }
    $requete .= 'ORDER BY gm_date_creation '.$ordre;
    $aso_info =& $db->getAssoc($requete, false, array(), $mode, $groupe);
    (PEAR::isError($aso_info)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $aso_info->getMessage(), $requete)) : '';

    return $aso_info;
}
/** Fonction GEN_lireInfoMenuCategorie() - Renvoie un objet ou un tableau contenant des lignes de la table gen_menu
*
* Renvoie un objet ou un tableau contenant une ligne de la table gen_menu en fonction des cat�gories pr�sentes dans
* la table gen_menu.
*
* @param  mixed   Une instance de la classse PEAR_DB
* @param  array  un tableau de cat�gorie(s).
* @param  string  le mode dans Pear DB dans lequel on veut recevoir les infos du menu.
* @param  boolean  true pour grouper les r�sultats (voir Pear DB : getAssoc() ) sinon false.
* @return  mixed   un objet ou tableau r�sultat Pear DB, ou false en cas d'erreur.
*/
function GEN_lireInfoMenuCategorie($db, $tab_categories, $mode = DB_FETCHMODE_OBJECT, $groupe = false)
{
    //----------------------------------------------------------------------------
    // Recherche des informations sur les menus en fonctions des mots cl�s
    $requete =  'SELECT DISTINCT * '.
                'FROM gen_menu '.
                'WHERE ';
    for ($i = 0; $i < count($tab_categories); $i++) {
        if ($i == 0) {
            $requete .= 'gm_categorie LIKE "%'.$tab_categories[$i].'%" ';
        } else {
            $requete .= 'OR gm_categorie LIKE "%'.$tab_categories[$i].'%" ';
        }
    }
    $requete .= 'ORDER BY gm_date_creation DESC';
    $aso_info =& $db->getAssoc($requete, false, array(), $mode, $groupe);
    (PEAR::isError($aso_info)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $aso_info->getMessage(), $requete)) : '';

    return $aso_info;
}
/** Fonction GEN_lireInfoMenuContenuDate() - Renvoie un objet ou un tableau contenant des lignes de la table gen_menu
*
* Renvoie un objet ou un tableau contenant une ligne de la table gen_menu en fonction des cat�gories pr�sentes dans
* la table gen_menu.
*
* @param  mixed   Une instance de la classse PEAR_DB
* @param  array  le type de modification.
* @param  array  le code alphanum�rique du site ou de plusieurs sites s�par�s par des virgules.
* @param  string  le mode dans Pear DB dans lequel on veut recevoir les infos du menu.
* @param  boolean  true pour grouper les r�sultats (voir Pear DB : getAssoc() ) sinon false.
* @return  mixed   un objet ou tableau r�sultat Pear DB, ou false en cas d'erreur.
*/
function GEN_lireInfoMenuContenuDate($db, $type_modif = '', $site = '', $categorie='', $mode = DB_FETCHMODE_OBJECT, $groupe = false)
{
    $type_modif_sql = 'AND gmc_ce_type_modification IN (%s) ';
    if (!empty($type_modif)) {
        $type_modif = sprintf($type_modif_sql, $type_modif);
    } else {
        $type_modif = sprintf($type_modif_sql, '1, 2');
    }
    $site_sql = 'AND gs_code_alpha IN (%s) ';
    if (!empty($site)) {
        $site = sprintf($site_sql, '"'.implode('", "', array_map('trim', explode(',', $site))).'"');
    } else {
        $site = '';
    }

    if (!empty($categorie)) {
        $categorie = 'AND gm_categorie like "%'.$categorie.'%"' ;
    } else {
        $categorie = '';
    }
    // Recherche des informations sur les menus en fonctions des mots cl�s
    $requete =  'SELECT DISTINCT gen_menu.*, gs_code_alpha, gmc_date_modification, gmc_resume_modification, gmc_ce_type_modification '.
                'FROM gen_site, gen_menu, gen_menu_contenu '.
                'WHERE gmc_date_modification <= "'.date('Y-m-d H:i:s', time()).'" '.
                'AND (gm_ce_site = gs_id_site OR gm_ce_site = 0) '.
                'AND gm_id_menu = gmc_ce_menu '.
                'AND gmc_bool_dernier = 1 '.
                $site.
                $type_modif.
                $categorie.
                'ORDER BY gmc_date_modification DESC';
	
    $aso_info =& $db->getAssoc($requete, false, array(), $mode, $groupe);
    (PEAR::isError($aso_info)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $aso_info->getMessage(), $requete)) : '';

    return $aso_info;
}
/** Fonction GEN_retournerTableauMenusSiteCodeAlpha() - Renvoie un tableau de tableau contenant des lignes de la table gen_menu
*
* Renvoie un tableau de tableau contenant les lignes de la table gen_menu pour un site donn�. Les tableaux sont imbriqu�es
* pour reproduire l'arborescence des menus.
*
* @param  mixed  Une instance de la classse PEAR_DB
* @param  string le code alphanum�rique du site.
* @return  array   un tableau de tableau contenant des lignes de la table gen_menu.
*/
function GEN_retournerTableauMenusSiteCodeAlpha($db, $site, $id_pere = 0, $aso_site_menus = array())
{
	
	global $_GEN_commun;

    $id_langue = $_GEN_commun['i18n'];//identifiant de la langue choisie
    
    if ($id_langue != GEN_I18N_ID_DEFAUT) {
    	$i18n_url=$id_langue;
    } 
    
    
	if (isset($id_langue) && ($id_langue!='')) {
		$langue_test=$id_langue;
	} else {
		$langue_test=GEN_I18N_ID_DEFAUT;
	}
    

    $requete =  'SELECT gen_menu.* '.
                'FROM gen_site, gen_menu, gen_menu_relation AS GMR01, gen_menu_relation AS GMR02 '.
                'WHERE GMR01.gmr_id_menu_02 = '.$id_pere.' '.
                'AND GMR01.gmr_id_menu_01 = gm_id_menu '.
                'AND gs_code_alpha = "'.$site.'" '.
                'AND gm_ce_site = gs_id_site '.
                'AND GMR01.gmr_id_valeur = 1 '.// 1 = avoir "p�re"
                'AND GMR02.gmr_id_menu_02 = gm_id_menu '.
                'AND GMR02.gmr_id_menu_01 = GMR02.gmr_id_menu_02 '.
                'AND GMR02.gmr_id_valeur = 100 '.// 100 = type "menu classique"
                'ORDER BY GMR01.gmr_ordre ASC';
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
    }

    if ($resultat->numRows() > 0) {
        while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
        	
       		$requete_restriction =    'SELECT gmr_id_menu_02 '.
	                                  'FROM  gen_menu_relation '.
	                                   'WHERE '.$ligne['gm_id_menu'].' = gmr_id_menu_01 ' .
	                                   'AND  gmr_id_valeur  = 106 ';// 106 restriction de menu
			$resultat_restriction = $db->query($requete_restriction);
			(DB::isError($resultat_restriction))             ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_restriction->getMessage(), $requete_restriction))
				: '';
					       
		    if ($resultat_restriction->numRows()>0 && $langue_test!=$ligne['gm_ce_i18n']) {
		    	$select_menu=0;
		    }
		    else {
		    	$select_menu=1;
		    }
        	
//        	if ($select_menu) {
	            $aso_site_menus[$ligne['gm_id_menu']] = $ligne;
    	        $aso_site_menus[$ligne['gm_id_menu']]['sous_menus'] = GEN_retournerTableauMenusSiteCodeAlpha($db, $site, $ligne['gm_id_menu']);
  //      	}
        }
    }
    return $aso_site_menus;
}


// Code menu --> Identifiant
// Identifiant menu --> Identifiant version originale
// Identifiant menu --> Identifiant version par d�faut
// Identifiant menu --> Contenu 
// Identifiant menu --> Contenu version originale
// Identifiant menu --> Contenu version par d�faut

// Identifiant menu --> Identifiant version originale

/** Fonction GEN_rechercheMenuIdentifiant() - Recherche code menu � partir de l'identifiant d'un site
*
*
* @param  object objet Pear de connection � la base de donn�es.
*/

function GEN_rechercheMenuIdentifiant($db, $id_menu)
{
		$requete =  'SELECT  gm_code_num   '.
        	        'FROM gen_menu  '.
            	    'WHERE gm_id_menu =  '.$id_menu.' ';
		$resultat = $db->query($requete);
		
		(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';


		$ligne = $resultat->fetchrow(DB_FETCHMODE_OBJECT);
		
		return $ligne->gm_code_num;
		
}

/** Fonction GEN_retournerIdMenuParCodeNum()
* 
* Recherche les info d'une menu � partir du code num�rique du menu d'un site et en fonction de la langue.
*
* @param  object objet Pear de connection � la base de donn�es.
* @param  integer code num�rique du menu
* @return identifiant menu
*/
function GEN_retournerIdMenuParCodeNum($db, $code_menu)
{
	// Si identifiant existe pour la langue choisie : retour identifiant
	// Si identifiant n'existe pas : retour identifiant de la langue par defaut :
	// Recherche de l'identifiant par defaut 
	// Recherche de l'identifiant de la langue du site
	// Recherche de l'identifiant par defaut 
	$id_langue = $GLOBALS['_GEN_commun']['i18n'];
	if (isset($id_langue) && ($id_langue!='')) {
		$langue_test=$id_langue;
	} else {
		$langue_test=GEN_I18N_ID_DEFAUT;
	}

	$requete =  'SELECT gm_id_menu, gm_code_num   '.
				'FROM gen_menu  '.
				'WHERE gm_code_num =  '.$code_menu.' '.
				'AND gm_ce_i18n = "'.$langue_test.'" ';
	$resultat = $db->query($requete);

	(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	
	if ( $resultat->numRows() > 0 ) {
		$ligne = $resultat->fetchrow(DB_FETCHMODE_OBJECT);
		return $ligne->gm_id_menu;
	} else {
		// Recherche defaut :
		$requete =  'SELECT gm_id_menu, gm_code_num   '.
           'FROM gen_menu  '.
           'WHERE gm_code_num =  '.$code_menu.' ';
           'AND gm_ce_i18n = "'.GEN_I18N_ID_DEFAUT.'" ';

		$resultat = $db->query($requete);

		(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
		
		if ( $resultat->numRows() > 0 ) {
			$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
			if ($langue_test!=GEN_I18N_ID_DEFAUT) {
				return GEN_rechercheMenuIdentifiantVersionParDefaut($db,$ligne->gm_id_menu);
				
			} else {
				return $ligne->gm_id_menu;
			}
		}
	}
}

/** Fonction GEN_rechercheMenuCode()
* 
* Allias de GEN_retournerIdMenuAvecCodeNum().
*
* @param  object objet Pear de connection � la base de donn�es.
* @param  integer code num�rique du menu
* @return identifiant menu
*/
function GEN_rechercheMenuCode($db, $code_menu) {
	return GEN_retournerIdMenuParCodeNum($db, $code_menu);
}

/* Fonction GEN_rechercheContenu
*
*/
function GEN_rechercheContenu($db, $id_menu, $type_fetch = DB_FETCHMODE_OBJECT) {
 	
	$requete  =	'SELECT gmc_contenu , gmc_ce_type_contenu, gmc_ce_menu '.
				'FROM gen_menu_contenu  '.
				'WHERE gmc_ce_menu = '.$id_menu.' '.
				'AND gmc_ce_type_contenu in (1,2) '.
				'AND gmc_bool_dernier = 1';
	
	$resultat = $db->query($requete);
	(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

	// Rien trouv� ? : Pas encore de contenu 
	// Recherche identifiant par d�faut 
	if ( $resultat->numRows() == 0 ) {
		$id_menu_defaut = GEN_rechercheMenuIdentifiantVersionParDefaut($db,$id_menu);
		$requete  =	'SELECT gmc_contenu , gmc_ce_type_contenu, gmc_ce_menu '.
					'FROM gen_menu_contenu  '.
					'WHERE gmc_ce_menu = '.$id_menu_defaut.' '.
					'AND gmc_ce_type_contenu in (1,2) '.
					'AND gmc_bool_dernier = 1';
		
		$resultat = $db->query($requete);
		(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

		if ( $resultat->numRows() == 0 ) {
			// Toujours rien ? 
			// Tentative recherche dans la langue du site par defaut 
			$id_menu_origine = GEN_rechercheMenuIdentifiantVersionOriginale($db, $id_menu);
		
			$requete  =  'SELECT gmc_contenu , gmc_ce_type_contenu, gmc_ce_menu '.
	               			'FROM gen_menu_contenu  '.
			                'WHERE gmc_ce_menu = '.$id_menu_origine.' '.
	    		            'AND gmc_ce_type_contenu in (1,2) '.
	            		    'AND gmc_bool_dernier = 1';
		
			$resultat = $db->query($requete);
			(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
		
		}
	}
	
	$ligne_contenu = $resultat->fetchRow($type_fetch);
	return $ligne_contenu;
}

function GEN_rechercheContenuIdentifiant($db, $id_contenu, $mode = DB_FETCHMODE_OBJECT) {
 	
	$requete  =	'SELECT gmc_contenu , gmc_ce_type_contenu, gmc_ce_menu, gmc_date_modification '.
				'FROM gen_menu_contenu  '.
				'WHERE gmc_id_contenu = '.$id_contenu.' ';
	
	$resultat = $db->query($requete);
	(DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';

	if ($resultat->numRows() != 1) {
		return false;
	}

	$ligne_contenu = $resultat->fetchRow($mode);
	return $ligne_contenu;
}

/** Fonction GEN_rechercheMenuIdentifiantVersionOriginale() - Recherche identifiant de la version orginale d'un menu
*
*
* @param  object objet Pear de connection � la base de donn�es.
* @param  identifiant menu
* @return identifiant menu
*/
function GEN_rechercheMenuIdentifiantVersionOriginale($db, $id_menu) {
	
	$requete  = 'SELECT gmr_id_menu_01 '.
				'FROM gen_menu_relation '.
				'WHERE gmr_id_menu_02  = ' . $id_menu .' '.
				'AND gmr_id_valeur = 2  '; // 2 = "avoir traduction"
				
	
	$resultat = $db->query($requete) ;
	  	
	if (DB::isError($resultat)) {
	    die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
	}
	
		
	if ($resultat->numRows() > 0) {
		$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
		return $ligne->gmr_id_menu_01;
	}
	else {
		return $id_menu;
	}
	
}
		

/** Fonction GEN_rechercheMenuIdentifiantVersionParDefaut() - Recherche identifiant par defaut d'un menu
*
*
* @param  object objet Pear de connection � la base de donn�es.
* @param  identifiant menu
* @return identifiant menu
*/
function GEN_rechercheMenuIdentifiantVersionParDefaut($db, $id_menu) {

	$identifiantVersionOrginale=GEN_rechercheMenuIdentifiantVersionOriginale($db, $id_menu);

	$requete  = 'SELECT gmr_id_menu_02 '.
				'FROM gen_menu_relation '.
				'WHERE gmr_id_menu_01  = ' . $identifiantVersionOrginale .' '.
				'AND gmr_id_valeur = 105  '; // 105
	
	$resultat = $db->query($requete) ;
	  	
	if (DB::isError($resultat)) {
	    die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
	}
		
	if ($resultat->numRows() > 0) {
		$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
		return $ligne->gmr_id_menu_02;
	}
	else {
		return $identifiantVersionOrginale;
	}
}




/* +--Fin du code ---------------------------------------------------------------------------------------+
* $Log: pap_menu.fonct.php,v $
* Revision 1.31.2.3  2008-08-08 14:45:59  jp_milcent
* Fusion avec la branche principale.
*
* Revision 1.34  2008-08-08 14:42:14  jp_milcent
* Ajout d'une fonction donnant la profondeur d'un menu par rapport à la racine.
*
* Revision 1.33  2007-11-22 17:24:09  jp_milcent
* Fusion avec la livraison AHA : 22 novembre 2007
*
* Revision 1.31.2.2  2007-11-22 17:22:30  jp_milcent
* Ajout d'un trie par date sur la requêtre retournant les menus de la même catégorie.
*
* Revision 1.31.2.1  2007-11-19 10:20:23  ddelon
* Gestion des menus reservés à une langue
*
* Revision 1.31  2007-06-26 15:39:46  jp_milcent
* Ajout de fonctions utiles pour la gestion du contenu des menus.
*
* Revision 1.30  2006-12-12 17:19:58  jp_milcent
* Ajout de test suppl�mentaire pour �viter les erreurs.
*
* Revision 1.29  2006/12/12 13:32:58  jp_milcent
* Mise en forme.
*
* Revision 1.28  2006/12/08 20:13:57  jp_milcent
* Mise en allias de GEN_rechercherMenuCode(), remplac�e par GEN_retournerIdMenuParCodeNum().
*
* Revision 1.27  2006/10/16 15:50:10  ddelon
* Refactorisation code mulitlinguisme et gestion menu invisibles
*
* Revision 1.26  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.25.2.1  2005/12/20 14:40:24  ddelon
* Fusion Head vers Livraison
*
* Revision 1.25  2005/11/08 17:43:46  ddelon
* Bug Nouveaute ne s'affichant pas pour les menu communs
*
* Revision 1.24  2005/09/20 17:01:22  ddelon
* php5 et bugs divers
*
* Revision 1.23  2005/08/29 09:05:12  ddelon
* Suppression message debug
*
* Revision 1.22  2005/07/08 15:16:37  alexandre_tb
* ajout de la fonction GEN_lireInfoMenuMeta() qui permet de s�lectionner des menus en fonction de leur mot cl� et leur cat�gorie
*
* Revision 1.21  2005/06/08 19:11:43  jpm
* Ajout de ordre et condition pour la fonction de lecture des infos sur les menus.
*
* Revision 1.20  2005/05/26 08:00:51  jpm
* Correction dans la fonction GEN_retournerTableauMenusSiteCodeAlpha().
*
* Revision 1.19  2005/05/25 13:46:58  jpm
* Changement du sql de la fonction GEN_lireContenuMenu().
*
* Revision 1.18  2005/04/19 17:21:19  jpm
* Utilisation des r�f�rences d'objets.
*
* Revision 1.17  2005/04/18 16:41:25  jpm
* Ajout d'une fonction pour r�cup�rer tous les menus d'un site avec son code alphanum�rique.
*
* Revision 1.16  2005/04/14 17:40:31  jpm
* Modification fonction pour les actions.
*
* Revision 1.15  2005/04/14 13:56:53  jpm
* Modification d'une ancienne fonction.
*
* Revision 1.14  2005/04/12 16:13:50  jpm
* Ajout de fonction renvoyant des infos sur un menu en fonction des mots cl�s, cat�gories ou date de modification du contenu.
*
* Revision 1.13  2005/03/30 08:53:59  jpm
* Ajout de fonctions permettant de r�cup�rer les codes alphanum�riques ou num�riques en fonction de l'un ou de l'autre.
*
* Revision 1.12  2005/02/28 11:12:03  jpm
* Modification des auteurs.
*
* Revision 1.11  2004/12/06 19:49:35  jpm
* Ajout d'une fonction permettant de r�cup�rer le contenu d'un menu.
*
* Revision 1.10  2004/12/06 17:53:55  jpm
* Ajout fonction GEN_retournerMenus().
*
* Revision 1.9  2004/11/29 18:34:42  jpm
* Correction bogue.
*
* Revision 1.8  2004/11/10 17:25:51  jpm
* Modification de fonction suite � des bogues.
*
* Revision 1.7  2004/11/09 17:55:26  jpm
* Suppresion de fonctions inutiles et mise en conformit�.
*
* Revision 1.6  2004/11/08 17:39:32  jpm
* Suppression d'une fonction inutile.
* GEN_etreFils() n'est pas utile. On peut utiliser GEN_etreAncetre() � la place.
*
* Revision 1.5  2004/11/04 12:51:45  jpm
* Suppression de message de d�bogage.
*
* Revision 1.4  2004/11/04 12:23:50  jpm
* Nouvelles fonctions sur les menus fr�res.
*
* Revision 1.3  2004/10/25 14:16:21  jpm
* Suppression de code comment�.
*
* Revision 1.2  2004/10/21 18:15:21  jpm
* Ajout de gestion d'erreur aux fonctions.
*
* Revision 1.1  2004/06/15 15:11:37  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.43  2004/05/05 06:13:27  jpm
* Extraction de la fonction g�n�rant le "vous �tes ici", transform�e en applette.
*
* Revision 1.42  2004/05/04 16:24:06  jpm
* Am�lioration de la fonction g�n�rant le "vous �tes ici".
*
* Revision 1.41  2004/05/04 16:17:31  jpm
* Ajout de la fonction g�n�rant le "vous �tes ici".
*
* Revision 1.40  2004/05/03 11:18:17  jpm
* Normalisation de deux fonctions issues du fichier fontctions.php.
*
* Revision 1.39  2004/05/01 16:17:11  jpm
* Suppression des fonctions li�es � la cr�ation des listes de menu. Elles ont �t� transform�es en applette.
*
* Revision 1.38  2004/05/01 11:43:16  jpm
* Suppression des fonction GEN_afficherMenuCommun() et GEN_afficherSelecteurSites() transform�es en applette.
*
* Revision 1.37  2004/04/30 16:18:41  jpm
* Correction d'un bogue dans les fonctions de gestion des scripts.
*
* Revision 1.36  2004/04/28 12:04:40  jpm
* Changement du mod�le de la base de donn�es.
*
* Revision 1.35  2004/04/09 16:23:41  jpm
* Prise en compte des tables i18n.
*
* Revision 1.34  2004/04/02 16:34:44  jpm
* Extraction de variable globale des fonction, remplac� par un passage en param�tre.
*
* Revision 1.33  2004/04/01 11:24:51  jpm
* Ajout et modification de commentaires pour PhpDocumentor.
*
* Revision 1.32  2004/03/31 16:52:30  jpm
* Modification du code vis � vis du mod�le revision 1.9 de G�n�sia.
*
* Revision 1.31  2004/03/29 17:13:05  jpm
* Suppression de fonction, passer en code classique.
*
* Revision 1.30  2004/03/27 11:11:58  jpm
* D�but changement nom de variable dans fonction creerInfoPageEtApplication().
*
* Revision 1.29  2004/03/26 12:52:25  jpm
* Ajout des fonctions creerInfoPageEtApplication() et donnerIdPremiereApplicationLiee().
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
