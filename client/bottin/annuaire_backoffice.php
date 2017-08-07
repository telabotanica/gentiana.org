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
// CVS : $Id: annuaire_backoffice.php,v 1.7 2007-06-01 13:39:52 alexandre_tb Exp $
/**
* programme principal du module annuaire_moteur
*
* programme principal du module annuaire_moteur
*
*@package annuaire
//Auteur original :
*@author        Alexandre Granier <alexandre@tela-botanica.org>
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

include_once INS_CHEMIN_APPLI.'bibliotheque/annuaire_backoffice.fonct.php';
include_once INS_CHEMIN_APPLI.'bibliotheque/inscription.class.php';
include_once INS_CHEMIN_APPLI.'bibliotheque/inscription.fonct.php';
include_once INS_CHEMIN_APPLI.'bibliotheque/bottin.fonct.php';

$lang=INS_LANGUE_DEFAUT;
define ("ANN_MAIL_TOUS", 1) ;
define ("ANN_MAIL_TOUS_ENVOIE", 2) ;

// Action pour valider une demande d inscription
define ('ANN_ACTION_VALIDER_INSCRIPTION', 3);

// Action pour supprimer une demande d inscription
define ('ANN_ACTION_SUPPRIMER_DEMANDE_INSCRIPTION', 4);

// Action pour supprimer un inscrit
define ('ANN_ACTION_SUPPRIMER_INSCRIT', 5);

// TODO: Nom de la variable action, a modifier dans le programme
define ('ANN_VARIABLE_ACTION', 'action');
define ('INS_VARIABLE_ID_DEMANDEUR', 'id_demandeur');
define ('INS_VARIABLE_ID_INSCRIT', 'id_inscrit');

// Recherche parametres menu actif : ils ne sont pas present dans le contexte, quel dommage !
$requete_menu =  'SELECT gm_application_arguments '.
                 'FROM gen_menu '.
                 'WHERE gm_id_menu = '.$_GET['menu'];         
$resultat_menu = $GLOBALS['_GEN_commun']['pear_db']->query($requete_menu);
$info_menu = $resultat_menu->fetchRow(DB_FETCHMODE_OBJECT);
$resultat_menu->free();
if (isset($info_menu->gm_application_arguments)) {
	$arguments = explode(' ', $info_menu->gm_application_arguments);
   	for ($i = 0; $i < count($arguments); $i++) {
   		$attr = explode('=', $arguments[$i]);
   		if ($attr[0] != '') {
	    	$info_application->$attr[0] = (isset($attr[1]) ? $attr[1] : '');
   		}
   	}
}
//cas de l'annuaire admin papyrus, on modifie certaines constantes
if (isset ($info_application->type_annuaire)  && $info_application->type_annuaire==1) {
	include_once INS_CHEMIN_APPLI.'configuration/annuaire_backoffice.config.inc.php';
}
// recuperation de la configuration
include_once INS_CHEMIN_APPLI.'bibliotheque/bottin.class.php';
$GLOBALS['ins_config'] = inscription::getConfig();
// Template du formulaire
$GLOBALS['ins_config']['ic_inscription_template'] = inscription::getTemplate(INS_TEMPLATE_FORMULAIRE, 
    				$GLOBALS['ins_config']['ic_id_inscription']);

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
function afficherContenuCorps () {
	$res = '';
    if (!$GLOBALS['AUTH']->getAuth())  {
        $res .= AUTH_formulaire_login() ;
    } else {
        if (isset($_REQUEST[INS_CHAMPS_ID])) {
            include_once (INS_CHEMIN_APPLI.'bibliotheque/edition_fiche.php');
            $GLOBALS['ins_url']->addQueryString (INS_CHAMPS_ID, $_REQUEST[INS_CHAMPS_ID]) ;
            return putFrame() ;
        }
        
        // Les actions 	1 => envoie d un mail a tous
        //				2 => valider une demande d inscription
        //				3 => supprimer une demande d inscription
        // 				5 => supprimer un inscrit
        if (isset ($_GET[ANN_VARIABLE_ACTION])) {
            switch ($_GET[ANN_VARIABLE_ACTION]) {
            	case ANN_MAIL_TOUS :
            	case ANN_MAIL_TOUS_ENVOIE :
            	include_once (INS_CHEMIN_APPLI.'bibliotheque/mail_tous.php') ;
            	return putFrame() ;
            	break;
            	case ANN_ACTION_VALIDER_INSCRIPTION : $res .= inscription::validerInscription();
            	break;
            	case ANN_ACTION_SUPPRIMER_DEMANDE_INSCRIPTION: $res .= inscription::supprimerDemandeInscription();
            	break;
            	case ANN_ACTION_SUPPRIMER_INSCRIT : $res .= inscription::supprimerInscription();
            	break;
            }
        }
        if (isset($_REQUEST['ajouter'])) {
        	return ajouterInscrit() ;	
        }
        $res .= "<div>".mkengine()."</div>\n" ;
        
        // Liste des inscrits en attente de moderation
        $res .= '<h1>'.INS_EN_ATTENTE_DE_MODERATION.'</h1>';
        //$res .= print_r(inscription::getInscritEnAttenteModeration(), true);
        $res .= inscription::getTableauEnAttente((inscription::getInscritEnAttenteModeration()));
        
    }
    return $res ;
}

?>