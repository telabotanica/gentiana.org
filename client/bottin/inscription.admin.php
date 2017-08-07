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
* 
*@package bottin
//Auteur original :
*@author        Florian Schmitt <florian@ecole-et-nature.org>
*@author		Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@copyright     Tela-Botanica 2000-2007
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/
// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                                 CLASSE                                               |
// +------------------------------------------------------------------------------------------------------+

include_once 'configuration/bottin.config.inc.php';
include_once INS_CHEMIN_APPLI.'langues/bottin.admin.langue_fr.php';

class Inscription_Admin {
    var $objet_pear_auth;
    var $objet_pear_db;
    var $objet_pear_url;
    var $sortie_xhtml;
    
    /** Fonction redigerContenu() - Affiche le formulaire de r?action
    *
    *
    *   @return  string  Le HTML
    */
    function afficherContenuCorps()
    {
        /** Inclusion du fichier de configuration de cette application.*/
        require_once PAP_CHEMIN_RACINE.'client/bottin/configuration/bottin.config.inc.php';
        //require_once INS_CHEMIN_APPLI.'configuration/cartographie.config.inc.php';
        require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm.php' ;
                
        //-------------------------------------------------------------------------------------------------------------------
        // Initialisation des attributs
        $this->objet_pear_auth = $GLOBALS['_GEN_commun']['pear_auth'];
        $this->objet_pear_db = $GLOBALS['ins_db'];
        $this->objet_pear_url = $GLOBALS['_GEN_commun']['url'];
        $this->sortie_xhtml = '<h1>'.INS_CONFIG_INSCRIPTION.'</h1><br />'."\n";        
        
        //-------------------------------------------------------------------------------------------------------------------
        // Gestion des boutons de l'interface
        if (isset($_POST['afficheur_annuler'])) {
            return false;
        } 
        

        $requete = 'SELECT gm_application_arguments FROM gen_menu WHERE gm_id_menu='.$_GET['adme_menu_id'];
        $resultat = $this->objet_pear_db->query($requete) ;
        if (DB::isError($resultat)) {
        	return ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
        }
        $valeurs_par_defaut = array();
        if ($resultat->numRows()>0) {    	
        	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {        		
        		$arguments = explode(' ', $ligne->gm_application_arguments);        	
 				for ($i = 0; $i < count($arguments); $i++) {
 					$attr = explode('=', $arguments[$i]);
 					if ($attr[0] != '') {
 						$info_application->$attr[0] = (isset($attr[1]) ? $attr[1] : '');
 					}
 			   	}
 			}
        	//valeurs par defaut enregistrees dans la table        	
        	if (isset ($info_application->type_annuaire))$valeurs_par_defaut['type_annuaire']=$info_application->type_annuaire;      
        } else {
        	//valeurs par defaut pour afficher une carto des structures
        	$valeurs_par_defaut['type_annuaire']=0;  	
        }
        
        //-------------------------------------------------------------------------------------------------------------
        // Si le formulaire vient d etre poste, on met a jour la table inscription_configuration
        
        if (isset($_POST['enregistrer_quitter'])) {
        	if (isset ($_POST['id_inscription'])) {
	        	$req = 'update inscription_configuration set '.
	        			'ic_nom_inscription="'.$_POST['ic_nom_inscription'].'", '.
	        			'ic_url_bazar="'.$_POST['ic_url_bazar'].'", '.
	        			(isset ($_POST['ic_inscription_modere']) ? 'ic_inscription_modere="'.$_POST['ic_inscription_modere'].'", ':'ic_inscription_modere=0, ').
	        			'ic_mail_moderateur="'.$_POST['ic_mail_moderateur'].'", '.
	        			'ic_from_mail_confirmation="'.$_POST['ic_from_mail_confirmation'].'", '.
	        			'ic_utilise_nom_wiki="'.$_POST['ic_utilise_nom_wiki'].'", '.
	        			(isset ($_POST['ic_genere_nom_wiki']) ? 'ic_genere_nom_wiki="'.$_POST['ic_genere_nom_wiki'].'", ':'').
	        			(isset ($_POST['ic_utilise_reecriture_url']) ? 'ic_utilise_reecriture_url="'.$_POST['ic_utilise_reecriture_url'].'", ':'').
	        			'ic_url_prefixe="'.$_POST['ic_url_prefixe'].'", '.
	        			(isset ($_POST['ic_mail_valide_inscription']) ? 'ic_mail_valide_inscription="'.$_POST['ic_mail_valide_inscription'].'", ':'').
	        			'ic_google_key="'.$_POST['ic_google_key'].'", '.
	        			'ic_mail_inscription_news="'.$_POST['ic_mail_inscription_news'].'", '.
	        			'ic_inscription_template="'.$_POST['ic_inscription_template'].'", '.
	        			'ic_mail_admin_apres_inscription="'.$_POST['ic_mail_admin_apres_inscription'].'"'.
	        			' where ic_id_inscription="'.$_GET['id_inscription'].'"';
	        	
	        	$GLOBALS['ins_db']->query($req);
        	}
        	if (isset($_POST['id_template'])) {
        		$req = 'update inscription_template set ' .
        				'it_nom_template="'.$_POST['it_nom_template'].'",' .
        				'it_template="'.$_POST['it_template'].'" ' .
        				'where it_id_template="'.$_POST['id_template'].'"';
        		$GLOBALS['ins_db']->query($req);
        	}
        }
        
        
        // Requete pour recuperer les valeurs de la table inscription_config
        $requete = 'select * from inscription_configuration order by ic_id_inscription';
        $resultat = $GLOBALS['ins_db']->query($requete) ;
        if (DB::isError($resultat)) {
        	return ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
        }
        if ($resultat->numRows() == 0) {
        	return 'La table inscription_configuration est vide. Il faut qu\'elle contienne au moins une ligne';
        }
        
        $GLOBALS['ins_url']->addQueryString('adme_site_id', $_GET['adme_site_id']);
        $GLOBALS['ins_url']->addQueryString('adme_menu_id', $_GET['adme_menu_id']);
        $GLOBALS['ins_url']->addQueryString('adme_action', 'administrer');
	        
        // Affichage des inscriptions disponible
        $this->sortie_xhtml .= '<ul>';
        while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
        	$GLOBALS['ins_url']->addQueryString('id_inscription', $ligne['ic_id_inscription']);
        	$this->sortie_xhtml .= '<li><a href="'.$GLOBALS['ins_url']->getURL().'">'.$ligne['ic_nom_inscription'];
        	$this->sortie_xhtml .= '</a></li>';
        }
        $this->sortie_xhtml .= '</ul>';
        
        if (isset ($_GET['id_inscription'])) {
        	$requete = 'select * from inscription_configuration where ic_id_inscription="'.$_GET['id_inscription'].'"';
        	$resultat = $GLOBALS['ins_db']->query($requete) ;
	        if (DB::isError($resultat)) {
	        	return ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
	        }
	        if ($resultat->numRows() == 0) {
        		return 'La table inscription_configuration est vide. Il faut qu\'elle contienne au moins une ligne';
        	}
        	$ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC);
        	$this->sortie_xhtml .= '<h2>'.$ligne['ic_nom_inscription'].'</h2>';
	        
	        //-------------------------------------------------------------------------------------------------------------
	        // Gestion du formulaire
	        
	        $GLOBALS['ins_url']->addQueryString('id_inscription', $ligne['ic_id_inscription']);
	        $form =  new HTML_QuickForm('form_param_inscription', 'post', str_replace('&amp;', '&', $GLOBALS['ins_url']->getUrl()));
	        $squelette =& $form->defaultRenderer();
	        $squelette->setFormTemplate("\n".'<form {attributes}>'."\n".'{content}'."\n".'</form>'."\n");
	        $squelette->setElementTemplate( '<p>'."\n".
	                                        '<label style="width:100px;padding:5px;text-align:right;">{label}'.
	                                        '<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required -->'."\n".
	                                        '<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
											' : </label>'."\n".'{element}'."\n".
											'</p>'."\n" );

	        $form->addElement('text', 'ic_nom_inscription', INS_NOM_INSCRIPTION);
	        $form->addElement('checkbox', 'ic_inscription_modere', INS_INSCRIPTION_MODERE);
	        $form->addElement('textarea', 'ic_mail_moderateur', INS_MAILS_MODERATEURS, array('cols' => 30, 'rows' => 4));
	        $form->addElement('checkbox', 'ic_mail_valide_inscription', INS_INSCRIPTION_VERIFICATION_EMAIL);
	        $form->addElement('textarea', 'ic_mail_admin_apres_inscription', INS_MAILS_ADMIN, array('cols' => 30, 'rows' => 4));
	        $form->addElement('text', 'ic_from_mail_confirmation', INS_FROM_MAIL_CONFIRMATION, array('size' => '50'));
	       
	        $form->addElement('checkbox', 'ic_utilise_nom_wiki', INS_CHAMPS_WIKI);
	        $form->addElement('checkbox', 'ic_genere_nom_wiki', INS_GENERE_NOM_WIKI);
	        $form->addElement('checkbox', 'ic_utilise_reecriture_url', INS_REECRITURE_URL);
	        $form->addElement('text', 'ic_url_prefixe', INS_PREFIXE_URL);
	        $form->addElement('text', 'ic_mail_inscription_news', INS_MAIL_INSCRIPTION_NEWS, array('size' => '50'));
	        
	        $form->addElement('text', 'ic_url_bazar', INS_URL_BAZAR);
	        $form->addElement('hidden', 'id_inscription', $_GET['id_inscription']);
	        $form->addElement('submit', 'enregistrer_quitter', INS_ENREGISTRER_ET_QUITTER);
	        $form->addElement('button', 'afficheur_annuler', INS_ANNULER);
	        
	        $form->setDefaults($ligne);
	        $this->sortie_xhtml .= $form->toHTML()."\n";
	        $this->sortie_xhtml .= '<hr /><br />';
	        
	        // recuperation des templates
	        $requete = 'select * from inscription_template where it_ce_inscription="'.$_GET['id_inscription'].'"';
	        $resultat = $GLOBALS['ins_db']->query($requete) ;
	        if (DB::isError($resultat)) {
	        	return ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
	        }
	        if ($resultat->numRows() == 0) {
        		$this->sortie_xhtml .= 'La table inscription_template est vide. Ca n\'est pas normal';
        	}
        	$this->sortie_xhtml .= '<ul>';
        	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
        		$GLOBALS['ins_url']->addQueryString('id_template', $ligne['it_id_template']);
        		$this->sortie_xhtml .= '<li><a href="'.$GLOBALS['ins_url']->getURL().'">'.$ligne['it_nom_template'].'</a></li>'."\n";
        	}
        	$this->sortie_xhtml .= '</ul>';
        	// Si un template a ete clique, on affiche le formulaire
        	if (isset ($_GET['id_template'])) {
        		$requete = 'select * from inscription_template where it_id_template="'.$_GET['id_template'].'"';
        		if (isset ($GLOBALS['langue'])) $requete .= ' and it_i18n="'.$GLOBALS['langue'].'"';
        		$requete .= ' and it_ce_inscription="'.$_GET['id_inscription'].'"';
	        	$resultat = $GLOBALS['ins_db']->query($requete) ;
		        if (DB::isError($resultat)) {
		        	return ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
		        }
		        if ($resultat->numRows() == 0) {
	        		return 'Pas de template avec ce numero.';
	        	}
	        	$ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC);
	        	$this->sortie_xhtml .= '<h2>'.$ligne['it_nom_template'].'</h2>';
		        
		        //-------------------------------------------------------------------------------------------------------------
		        // Gestion du formulaire
		        
		        $GLOBALS['ins_url']->addQueryString('id_template', $ligne['it_id_template']);
		        $form =  new HTML_QuickForm('form_inscription_template', 'post', str_replace('&amp;', '&', $GLOBALS['ins_url']->getUrl()));
		        $form->addElement('text', 'it_nom_template', INS_NOM_MODELE, array ('size' => 40));
		        
		        // Recherche des langues
		        
		        $form->addElement('textarea', 'it_template', INS_CONTENU_MODELE, array('cols' => 80, 'rows' => 12));
		        
		        require_once PAP_CHEMIN_API_PEAR.'I18Nv2/Language.php';
		        $lang =  new I18Nv2_Language('fr', 'iso-8859-1');
		        
		        
		        // Les langues utilisees dans le site sont gen_i18n_langue
		        $requete_langue = 'select * from gen_i18n_langue';
		        $resultat_langue = $GLOBALS ['ins_db']->query($requete_langue);
		        while ($ligne_langue = $resultat_langue->fetchRow(DB_FETCHMODE_OBJECT)) {
		        	$langues[$ligne_langue->gil_id_langue] = $ligne_langue->gil_nom;
		        }
		        
		        $form->addElement('html', '<tr><td>'.INS_LANGUE.' : '.$lang->getName($ligne_langue->it_i18n).'</td></tr>');
		        $form->addElement('hidden', 'id_template', $ligne['it_id_template']);
		        $form->addElement('submit', 'enregistrer_quitter', INS_ENREGISTRER_ET_QUITTER);
		        $form->addElement('button', 'afficheur_annuler', INS_ANNULER);
		        $form->setDefaults($ligne);
		        $this->sortie_xhtml .= $form->toHTML()."\n";
		        $this->sortie_xhtml .= '<hr /><br />';
        	}
        	
        }
        return $this->sortie_xhtml;
    }

}// Fin de la classe

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+
?>