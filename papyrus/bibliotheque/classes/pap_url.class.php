<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: pap_url.class.php,v 1.7 2007-05-24 16:53:04 jp_milcent Exp $
/**
* Classe de gestion des url de Papyrus
*
* Permet de gérer la réecriture des url.
*
*@package Papyrus
*@subpackage Classes
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.7 $ $Date: 2007-05-24 16:53:04 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+



// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class Pap_URL extends Net_URL {
    /** Identifiant du menu
    *
    * @var integer
    */
    var $id;
    /** Chaine contenant le permalien.
    *
    * @var string
    */
    var $permalien = '';
    /** Booléen indiquant si on affiche ou pas un permalien.
    *
    * @var boolean
    */
    var $permalien_bool;
    /** Chaine indiquant le type d'url.
    *
    * @var string
    */
    var $url_type = 'MENU';
    /** Code numérique du menu courant
    *
    * @var integer
    */
    var $code_num;
    /** Code alphanumérique du menu courant
    *
    * @var string
    */
    var $code_alpha;
    /**
    * PHP4 Constructeur
    *
    * @see __construct()
    */
    function Pap_URL($url = null, $useBrackets = true)
    {
        $this->__construct($url, $useBrackets);
		// Gestion de la réecriture d'url
		if (defined('PAP_URL_REECRITURE') AND PAP_URL_REECRITURE == '1') {
			$this->setPermalienBool(true);
		}
    }
    /** Méthode setId() - Définit l'id du menu courant
    * 
    * @param integer l'identifiant du menu courant.
    * @return mixed false en cas d'erreur 
    * @access public
    */
    function setId($id)
    {
        // Nous transformons en entier l'identifiant
        settype($id, "integer");
        // Nous vérifions que l'identifiant est bien un entier
        if (is_integer($id)) {
            $this->id = $id;
        } else {
            return false;
        }
    }
    /** Méthode getId() - Retourne l'id du menu courant
    * 
    * @return integer l'identifiant du menu courant.
    * @access public
    */
    function getId()
    {
        return $this->id;
    }
    /** Méthode setPermalien() - Définit le permaliens
    * 
    * @param string valeur
    * @return mixed false en cas d'erreur 
    * @access public
    */
    function setPermalien($chaine = '')
    {
        // Nous vérifions que l'identifiant est bien un entier
        if (is_string($chaine) && $chaine != '') {
            if ($this->permalien != '') {
            	$this->permalien .= PAP_URL_REECRITURE_SEP;
            } else {
            	$this->permalien = constant('PAP_URL_REECRITURE_'.$this->getUrlType()).PAP_URL_REECRITURE_SEP;
            }
            $this->permalien .= $chaine;
        } else if ($chaine == '') {
        	$this->permalien = '';
        } else {
            return false;
        }
    }
    /** Méthode getPermalien() - Retourne le permalien
    * 
    * @return string le permalien
    * @access public
    */
    function getPermalien()
    {
        return $this->permalien;
    }
    /** Méthode setUrlType() - Définit le type d'URL
    * 
    * @param string type d'URL (SITE ou MENU)
    * @return mixed false en cas d'erreur 
    * @access public
    */
    function setUrlType($type)
    {
        // Nous vérifions que l'identifiant est bien un entier
        if (is_string($type) && ($type == 'MENU' || $type == 'SITE')) {
            $this->url_type = $type;
        } else {
            return false;
        }
    }
    /** Méthode getUrlType() - Retourne le type de l'URL
    * 
    * @return string le type d'URL
    * @access public
    */
    function getUrlType()
    {
        return $this->url_type;
    }
    /** Méthode setPermalienBool() - Définit le type d'utilisation des permaliens
    * 
    * @param boolean true ou false
    * @return mixed false en cas d'erreur 
    * @access public
    */
    function setPermalienBool($bool)
    {
        // Nous vérifions que l'identifiant est bien un entier
        if (is_bool($bool)) {
            $this->permalien_bool = $bool;
        } else {
            return false;
        }
    }
    /** Méthode getPermalienBool() - Retourne booléen indiquant si on utilise ou pas les permaliens
    * 
    * @return boolean true ou false
    * @access public
    */
    function getPermalienBool()
    {
        return $this->permalien_bool;
    }
    /** Méthode setCodeAlpha() - Définit le code alphanumérique de l'url
    * 
    * @param string le code alphanumérique pour l'url du menu
    * @return mixed false en cas d'erreur 
    * @access public
    */
    function setCodeAlpha($code_alpha)
    {
        if (is_string($code_alpha)) {
            $this->code_alpha = $code_alpha;
        } else {
            return false;
        }
    }
    /** Méthode getCodeNum() - Retourne le code numérique de l'url
    * 
    * @return string le code numérique pour l'url du menu
    * @access public
    */
    function getCodeNum()
    {
        return $this->code_num;
    }
    /** Méthode setCodeNum() - Définit le code numérique de l'url
    * 
    * @param string le code numérique pour l'url du menu
    * @return mixed false en cas d'erreur 
    * @access public
    */
    function setCodeNum($code_num)
    {
        if (is_integer($code_num)) {
            $this->code_num = $code_num;
        } else {
            return false;
        }
    }
    
    /** Méthode getCodeAlpha() - Retourne le code alphanumérique de l'url
    * 
    * @return string le code alphanumérique pour l'url du menu
    * @access public
    */
    function getCodeAlpha()
    {
        return $this->code_alpha;
    }
    /**
    * Méthode getURL() - Retourne l'url
    *
    * @return string l'url complète.
    * @access public
    */
    function getURL()
    {
        // Identifiant de la langue choisie
        if ( (isset($GLOBALS['_GEN_commun']['i18n'])) && (!empty($GLOBALS['_GEN_commun']['i18n'])) ) {
        	if ($GLOBALS['_GEN_commun']['i18n'] != GEN_I18N_ID_DEFAUT) {
            	$this->addQueryString(GEN_URL_CLE_I18N, $GLOBALS['_GEN_commun']['i18n']);
        	}
        }
            
        // Nous regardons si un id de menu existe
        if ($this->getId() != '') {
            // Préparation des noms des champs des codes pour le site et le menu
            $champs_code_site = (GEN_URL_ID_TYPE_SITE == 'int') ? 'gs_code_num' : 'gs_code_alpha';
            $champs_code_menu = (GEN_URL_ID_TYPE_MENU == 'int') ? 'gm_code_num' : 'gm_code_alpha';
            if ($this->getUrlType() == 'MENU') {
	            // Récupération du nom de l'entrée du menu à afficher
	            $requete =  'SELECT gm_code_alpha, gm_code_num, gm_ce_i18n, gm_ce_site '.
	                        'FROM gen_menu '.
	                        'WHERE gm_id_menu = '.$this->id.' ';
	            
	            $resultat = $GLOBALS['_GEN_commun']['pear_db']->query($requete);
	            (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	            
	            $ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC);
	            $resultat->free();
	            // Nous vérifions si nous avons à faire à un menu commun ou pas
	            if ($ligne['gm_ce_site'] != 0) {
	                // Récupération des infos sur le site
	                $bln_url_site = false;
	                $requete_site = 'SELECT gs_code_alpha, gs_code_num '.
	                                'FROM gen_site '.
	                                'WHERE gs_id_site = '.$ligne['gm_ce_site'].' ';
	                
	                $resultat_site = $GLOBALS['_GEN_commun']['pear_db']->query($requete_site);
	                (DB::isError($resultat_site)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_site->getMessage(), $requete_site)) : '';
	                
	                $ligne_site = $resultat_site->fetchRow(DB_FETCHMODE_ASSOC);
	                $resultat_site->free();
	            } else {
	                // Menu commun
	                $bln_url_site = true;
	                $ligne_site[$champs_code_site] = $GLOBALS['_GEN_commun']['info_site']->$champs_code_site;
	            }
	            $this->addQueryString(GEN_URL_CLE_MENU, $ligne[$champs_code_menu]);
            	$this->setCodeAlpha($ligne['gm_code_alpha']);
            	$this->setCodeNum($ligne['gm_code_num']);
            } else if ($this->getUrlType() == 'SITE') {
            	$bln_url_site = true;
            	$requete_site = 'SELECT gs_code_alpha, gs_code_num '.
                                'FROM gen_site '.
                                'WHERE gs_id_site = '.$this->getId().' ';
                
                $resultat_site = $GLOBALS['_GEN_commun']['pear_db']->query($requete_site);
                (DB::isError($resultat_site)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_site->getMessage(), $requete_site)) : '';
                
                $ligne_site = $resultat_site->fetchRow(DB_FETCHMODE_ASSOC);
                $resultat_site->free();
            	$this->setCodeAlpha($ligne_site['gs_code_alpha']);
            	$this->setCodeNum($ligne_site['gs_code_num']);
            	// Suppression de l'éventuel identifiant de menu passé dans l'url...
            	$this->removeQueryString(GEN_URL_CLE_MENU);
            } else {
            	$message = 	'ERREUR Papyrus : le type d\'url est inconnu : seul "MENU" et "SITE" existent. <br />'.
			            	'Type : '.$this->getUrlType().' <br />'.
			            	'Ligne n° : '. __LINE__ .'<br />'.
			            	'Fichier : '. __FILE__ ;
            	trigger_error($message, E_USER_ERROR);
            }
            
            // Préparation de l'url de l'entrée
            if ($bln_url_site) {
                $this->addQueryString(GEN_URL_CLE_SITE, $ligne_site[$champs_code_site]);
            }
            
            if ( (isset($GLOBALS['_GEN_commun']['url_i18n'])) && (!empty($GLOBALS['_GEN_commun']['url_i18n'])) ) {
                $this->addQueryString(GEN_URL_CLE_I18N, $GLOBALS['_GEN_commun']['url_i18n']);
            }
            
            if ( (isset($GLOBALS['_GEN_commun']['url_date'])) && (!empty($GLOBALS['_GEN_commun']['url_date'])) ) {
                $this->addQueryString(GEN_URL_CLE_DATE, $GLOBALS['_GEN_commun']['url_date']);
            }
            
            if ( (isset($GLOBALS['_GEN_commun']['url_format'])) && (!empty($GLOBALS['_GEN_commun']['url_format'])) ) {
                $this->addQueryString(GEN_URL_CLE_FORMAT, $GLOBALS['_GEN_commun']['url_format']);
            }
        }
        
		// Construction du permalien ou pas
        if ($this->getPermalienBool()) {
            // Récupération du chemin jusqu'au fichier principal de Papyrus
            //$this->path = (dirname($this->path) == DIRECTORY_SEPARATOR) ? DIRECTORY_SEPARATOR : dirname($this->path).DIRECTORY_SEPARATOR;
            // La ligne ci-dessus semble poser problème, je l'ai remplacé par l'expression régulière ci-dessous (jpm - 24 mai 2007)
            $this->path = preg_replace('/^(.*\/)[^\/]*$/', '$1', $this->path);

            // On vide le permalien construite par les appels à getUrl() avant de le remplir
            $this->setPermalien();
            if (constant('GEN_URL_RACCOURCI_ID_TYPE_'.$this->getUrlType()) == 'int') {
                $this->setPermalien($this->getCodeNum());
            } else {
                $this->setPermalien($this->getCodeAlpha());
            }
			$this->removeQueryString(GEN_URL_CLE_SITE);
            $this->removeQueryString(GEN_URL_CLE_MENU);
            $querystring = $this->getQueryString();
        } else {
            $querystring = $this->getQueryString();
        }
        
        // Construction de l'url
        $this->url = $this->protocol . '://'
                   . $this->user . (!empty($this->pass) ? ':' : '')
                   . $this->pass . (!empty($this->user) ? '@' : '')
                   . $this->host . ($this->port == $this->getStandardPort($this->protocol) ? '' : ':' . $this->port)
                   . $this->path
                   . $this->getPermalien()
                   . (!empty($querystring) ? '?' . $querystring : '')
                   . (!empty($this->anchor) ? '#' . $this->anchor : '');
        
        return $this->url;
    }
    
    /** Méthode retournant la valeur d'un paramêtre de l'URL.
    *
    * @return mixed la valeur du paramêtre demandé ou false
    * @access public
    */
    function retournerUnParametre($parametre)
    {
        if (!empty($this->querystring)) {
            if (isset($this->querystring[$parametre])) {
                return $this->querystring[$parametre];
            }
        }
        
        return FALSE;
    }

}

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_url.class.php,v $
* Revision 1.7  2007-05-24 16:53:04  jp_milcent
* Utilisation d'une expression régulière pour créer le path du permalien à la place de dirname.
*
* Revision 1.6  2006-12-08 20:12:21  jp_milcent
* Ajout d'un message d'erreur si un mauvais type de menu est utilisé.
*
* Revision 1.5  2006/12/08 20:02:52  jp_milcent
* Suppression de l'éventuel identifiant de menu passé en paramêtre des url de site.
*
* Revision 1.4  2006/10/11 18:04:11  jp_milcent
* Gestion avancée de la réecriture d'URL.
*
* Revision 1.3  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.2.2.1  2005/12/27 15:56:00  ddelon
* Fusion Head vers multilinguisme (wikini double clic)
*
* Revision 1.2  2005/04/18 16:40:50  jpm
* Modifications pour contrôler les permaliens.
*
* Revision 1.1  2005/04/14 13:56:25  jpm
* Ajout de la classe URL de Papyrus.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
