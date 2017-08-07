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
// CVS : $Id$
/**
* Phorum
*
* *Administration de l'application de forums
*
*@package inscription
//Auteur original :
*@author        Florian SCHMITT <florian@ecole-et-nature.org>
*
*@copyright     Outils-Reseaux 2006-2010
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/
// create a namespace for Phorum
function phorum_namespace($page)
{
    global $PHORUM;  // globalize the $PHORUM array
    include_once("./$page.php");
}

function phorum_custom_get_url ($page, $query_items, $suffix)
{
// on d�fini l'URL de tous les liens (qui conservent les GET) et rajoute les pages
$url_reecrite = $_SERVER['REQUEST_URI'];
$decoupe=explode("&param=",$url_reecrite);
$url_reecrite = $decoupe[0];
$url = "$url_reecrite&param=$page";

if(count($query_items)) $url.=",".implode(",", $query_items);

if(!empty($suffix)) $url.=$suffix;
return $url;
} 

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
class phorum_Admin {
    var $objet_pear_auth;
    var $objet_pear_db;
    var $objet_pear_url;
    var $sortie_xhtml; 
    
    /** Fonction afficherContenuCorps() - Affiche la partie administration
    *
    *
    *   @return  string  Le HTML
    */
    function afficherContenuCorps()  {
    	global $PHORUM; 
    	$sortie_xhtml = '' ;
		ob_start();
		include_once 'configuration/phorum.config.inc.php';
		chdir($PHORUM_DIR);
		$_SERVER["PHP_SELF"]=$_SERVER["PHP_SELF"].$_SERVER["REQUEST_URI"]; 
		if(file_exists('./admin.php')){
			phorum_namespace('admin');
		}		
		$sortie_xhtml .= ob_get_clean();
	    
		return $sortie_xhtml ;
    }
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.1  2006-04-28 12:40:44  florian
* Intégration de phorum, pas encore finalisée
*
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
