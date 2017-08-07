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
// CVS : $Id: integrateur_wikini.admin.php,v 1.7 2007-04-06 08:40:13 neiluj Exp $
/**
* Gestion des Wikini associé à un menu pour papyrus : lit et stocke les informations dans la
* champs gm_application_arguments de la table gen_menu 
* 
* Principe :
* Lecture arguments, decodage et affichage : Nom Wiki et Page Demarrage
* Affichage de l'ensemble des Wiki Disponible (avec leur page par Defaut)
* Choix d'un wiki
* Mise à jour
* 
* TODO : gerer le defaut sur demmarage
* 
*        ------------                   --------------
* Wiki : |          | Page Principale : |            |
*        ------------                   --------------
* 
* Fragmenteur choix (selection uniquement)
* 
* --------------------------------------
* | Nom Wiki         | Page Demmarage   |
* --------------------------------------
* | Wikini_01        |                  |
* ---------------------------------------
* | Wikini_02        | ChatMot          |
* ---------------------------------------
* 
* Valider - Annuler
* 
* 
*@package IntegrateurWikini
//Auteur original :
*@author        David Delon <david.delon@clapas.net>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.7 $ $Date: 2007-04-06 08:40:13 $
// +------------------------------------------------------------------------------------------------------+
*/


// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// TODO GEN_GER_STYLE !!!
//GEN_stockerStyleExterne('afficheur', AFFI_CHEMIN_STYLE.'afficheur.css');
// +------------------------------------------------------------------------------------------------------+
// |                                                 CLASSE                                               |
// +------------------------------------------------------------------------------------------------------+

/** Inclusion du fichier de configuration de cette application.*/
require_once 'configuration/adwi_configuration.inc.php';


/** Inclusion de l'API de fonctions gérant les erreurs sql.*/
require_once ADWI_CHEMIN_BIBLIOTHEQUE_API.'debogage/BOG_sql.fonct.php';

require_once ADWI_CHEMIN_BIBLIOTHEQUE_API.'html/HTML_TableFragmenteur.php' ;

require_once ADWI_CHEMIN_BIBLIOTHEQUE.'adwi_wikini.fonct.php';

// Inclusion des fichiers de traduction de l'appli ADWI dePapyrus
if (file_exists(ADWI_CHEMIN_LANGUE.'adwi_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once ADWI_CHEMIN_LANGUE.'adwi_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once ADWI_CHEMIN_LANGUE.'adwi_langue_'.ADWI_I18N_DEFAUT.'.inc.php';
}


class Integrateur_Wikini_Admin {
    
    /** Fonction redigerContenu() - Affiche le formulaire de rédaction
    *
    *
    *   @return  string  Le HTML
    */
    function afficherContenuCorps()
    {


        $res='';

	    $db = &$GLOBALS['_GEN_commun']['pear_db'] ;
	    $url = $GLOBALS['_GEN_commun']['url'] ;
	    $auth = &$GLOBALS['_GEN_commun']['pear_auth'] ;
	    
	    $url_origine=$url;
	    
	    $url->addQueryString('adme_site_id',  $_GET['adme_site_id']);
        $url->addQueryString('adme_menu_id', $_GET['adme_menu_id']);
        $url->addQueryString('adme_action', $_GET['adme_action']);
        
        
        // Recherche parametres menu actif : ils ne sont pas present dans le contexte, quel dommage !
	    
       $requete_menu =  'SELECT gen_menu.* '.
                        'FROM gen_menu '.
                        'WHERE gm_id_menu = '.$_GET['adme_menu_id'];
            
       $resultat_menu = $db->query($requete_menu);
       (DB::isError($resultat_menu))
         ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete_menu))
    	   : '';
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
	    
	    
	    isset ($GLOBALS['action']) ? '' : $GLOBALS['action'] = '' ; // On déclare action si elle n'existe pas
	    
	    if (!$auth->getAuth()) {
	        return 'Identifiez-vous' ;
	    }


		//  Mise à jour ? 
		if (isset ($GLOBALS['action'])) {
    	
    		
    		$arguments_menu="";
    		if ((isset($_POST['code_alpha_wikini'])) && (!empty($_POST['code_alpha_wikini']))) {
    		
    			$arguments_menu.="wikini=".($_POST['code_alpha_wikini'])." ";
    				
    		}
    		
    		if ((isset($_POST['page'])) && (!empty($_POST['page']))) {
    		
    			$arguments_menu.="page=".($_POST['page'])." ";
    				
    		}
    		
	    	$requete = "update gen_menu set  gm_application_arguments = '".$arguments_menu .
    	            "' where gm_id_menu =".$_GET['adme_menu_id'];
    	    
    		$resultat = $db->query ($requete) ;
    		if (DB::isError ($resultat)) {
        			trigger_error("Echec de la requete : $requete<br />".$resultat->getMessage(),E_USER_WARNING) ;

	        }
		}
    
		// Affichage par defaut 
		
		// Formulaire Selection Wiki 
	    
        $formulaire = new HTML_QuickForm('form_selection_wiki', 'post', str_replace('&amp;', '&', $url->getUrl()));
        

		$res .= "<h2>". ADWI_TITRE_SELECTION." ".$info_menu->gm_nom."</h2";
		         
		$squelette =& $formulaire->defaultRenderer();
		
		$squelette->setGroupTemplate('<table>{content}</table>', 'id');
		
		$squelette->setGroupElementTemplate('<tr><td>{element}<!-- BEGIN required --><!-- END required-->{label}</td></tr>', 'id');
		
		
		$formulaire->addElement ('text', 'code_alpha_wikini', ADWI_NOM_WIKINI, array ('size' => 20));
		$formulaire->addElement ('text', 'page', ADWI_PAGE_DEMARRAGE , array ('size' => 20));
	     			    


        // on fait un groupe avec les boutons pour les mettres sur la même ligne
        $buttons[] = &HTML_QuickForm::createElement('button', 'retour', ADWI_RETOUR, array ("onclick" => "javascript:document.location.href='".str_replace ('&amp;', '&', $url_origine->getURL())."'"));
        $buttons[] = &HTML_QuickForm::createElement('submit', 'valider', ADWI_VALIDER);
        $formulaire->addGroup($buttons, null, null, '&nbsp;');

	    
	    // Initialisation 
	    
	    if ((isset($_GET['id_wikini'])) && (!empty($_GET['id_wikini']))) {
	    
	    	$requete = "select * from gen_wikini where gewi_id_wikini=".$_GET['id_wikini'] ;
    		$resultat = $db->query ($requete) ;
    		if (DB::isError ($resultat)) {
        		trigger_error("Echec de la requete : $requete<br />".$resultat->getMessage(), E_USER_WARNING) ;
        	return ;
    		}
    	
	    	$info_wikini = $resultat->fetchRow (DB_FETCHMODE_OBJECT) ;
		    $formulaire->setDefaults(array('code_alpha_wikini'=>$info_wikini->gewi_code_alpha_wikini)) ;
		    $formulaire->setDefaults(array('page'=>$info_wikini->gewi_page)) ;
		    $resultat->free();
		    
	    }	
	    else {
	    	
			if ((isset($info_application->wikini)) && (!empty($info_application->wikini))) {
				$formulaire->setDefaults(array('code_alpha_wikini'=>$info_application->wikini)) ;
			}
		    
	    
	    	
	    
			if ((isset($info_application->page)) && (!empty($info_application->page))) {
				$formulaire->setDefaults(array('page'=>$info_application->page)) ;
			}
	     	
	    }		    
	    $res .= $formulaire->toHTML() ;

		$res .='<br/>';

		$res .= "<h2>". ADWI_LISTE_WIKINI.": </h2";
	    
	    // Comportement par défaut
	    // requete sur la table gen_wikini pour affichage de la liste des Wikini 
	    $requete = "select  gewi_id_wikini, gewi_code_alpha_wikini, gewi_page from gen_wikini" ;
	    
	    $resultat = $db->query ($requete) ;
	    if (DB::isError ($resultat)) {
	        $GLOBALS['_GEN_commun']['debogage_erreur']->gererErreur(E_USER_WARNING, "Echec de la requete : $requete<br />".$resultat->getMessage(),
	                                                                        __FILE__, __LINE__, 'admin_wikini')   ;
	        return ;
	    }
	    
		
	    $liste = new HTML_TableFragmenteur () ;
	    $liste->construireEntete(array (ADWI_NOM_WIKINI,ADWI_PAGE, ADWI_SELECTIONNER)) ;
	    
	    $tableau_wikini = array() ;
	    
	    while ($ligne = $resultat->fetchRow()) {
	        $url->addQueryString ('id_wikini', $ligne[0]) ;
	        array_push ($tableau_wikini, array ($ligne[1]."\n",    // Première colonne, le nom de l'application
										        $ligne[2]."\n",    // Deuxieme colonne, la page par defaut
	        								  '<a href="'.$url->getURL()."&amp;action=validation".'">'.ADWI_CHOISIR.'</a>'."\n",
	                                            ));
	    }
	    $liste->construireListe($tableau_wikini) ;
	    $res .= $liste->toHTML();
	    return $res ;
	    
    }
    
}// Fin de la classe

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: integrateur_wikini.admin.php,v $
* Revision 1.7  2007-04-06 08:40:13  neiluj
* update suite correction bugs intÃ©grateur wikinis
*
* Revision 1.5  2006/04/28 12:41:26  florian
* corrections erreurs chemin
*
* Revision 1.4  2005/09/30 07:48:35  ddelon
* Projet Wikini
*
* Revision 1.3  2005/09/14 09:12:15  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.2  2005/09/06 08:35:36  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.1  2005/09/02 11:29:25  ddelon
* Integrateur Wikini et administration des Wikini
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>