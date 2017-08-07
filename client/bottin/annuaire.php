<?
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
// CVS : $Id: annuaire.php,v 1.7 2007/04/11 08:30:12 neiluj Exp $
/**
* programme principal du module annuaire
*
* programme principal du module annuaire
*
*@package annuaire
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Florian SCHMITT <florian@ecole-et-nature.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.7 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
include_once 'configuration/bottin.config.inc.php';
include_once 'configuration/annuaire.config.inc.php';
include_once INS_CHEMIN_APPLI.'bibliotheque/bottin.fonct.php';

if (!isset($GLOBALS['lang'])) {
    $GLOBALS['lang'] = INS_LANGUE_DEFAUT ;
}
include_once INS_CHEMIN_APPLI."langues/annuaire.langue.".$GLOBALS['lang'].".inc.php" ;

if ( isset($_GET['voir_fiche']) or isset($_GET['voir_abonnement']) or isset($_GET['voir_actus']) or isset($_GET['voir_ressources']) or isset($_GET['voir_competences']) ) {
	//---------------le menu de l'appli-----------
	function afficherContenuNavigation () {
		$res =inscription_onglets();
		return $res ;
	}
}

/**
 *  Renvoie le code HTML de l'application
 *
 * @return  string  HTML
 */
function afficherContenuCorps () {
    if ( isset($_GET['voir_fiche']) or isset($_GET['voir_abonnement']) or isset($_GET['voir_actus']) or isset($_GET['voir_ressources']) or isset($_GET['voir_competences']) ) {
    	$res = affiche_onglet_info();    		     	
    } else {
    	$res = '<h1 class="annuaire_titre1">'.INS_ANNUAIRE_MEMBRES.'</h1>'."\n" ;
	    if (!$GLOBALS['AUTH']->getAuth()&&INS_NECESSITE_LOGIN)  {
	        $res .= '<p class="zone_alert">'.INS_VOUS_DEVEZ_ETRE_INSCRIT.'</p>'."\n" ;
	    } else {
	        // S'il y a un mail a envoyé, on l'envoie
	        if (isset($_POST['select']) && is_array ($_POST['select'])) $res .= envoie_mail_depuis_annuaire() ;
			
			//affichage du formulaire de recherche
	        $res .= Annuaire_recherche() ;
	    }
    }
    return $res;
}

/**------------------------------------------------------------------------------
* $Log: annuaire.php,v $
* Revision 1.7  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.5  2006/04/10 14:01:36  florian
* uniformisation de l'appli bottin: plus qu'un fichier de fonctions
*
* Revision 1.4  2006/04/04 12:23:05  florian
* modifs affichage fiches, gÃ©nÃ©ricitÃ© de la carto, modification totale de l'appli annuaire
*
* Revision 1.3  2005/10/03 09:38:42  alexandre_tb
* Lorsque non loggué, on renvoie un message et non un formulaire
*
* Revision 1.2  2005/09/29 16:07:51  alexandre_tb
* En cours de production.
*
* Revision 1.1  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.4  2005/09/22 13:30:49  florian
* modifs pour compatibilité XHTML Strict + corrections de bugs (mais ya encore du boulot!!)
*
*
*-- End of source  ------------------------------------------------------------*/
?>
