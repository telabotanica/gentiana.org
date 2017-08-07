<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Outils Reseaux (info@outils-reseaux.org)                                          |
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
// CVS : $Id: questionnaire.admin.php,v 1.1 2007-04-19 14:51:10 florian Exp $
/**
* 
*@package Questionnaire
//Auteur original :
*@author        Florian Schmitt <florian@ecole-et-nature.org>
//Autres auteurs :
*@copyright     Outils Reseaux 2006
*@version       $Revision: 1.1 $ $Date: 2007-04-19 14:51:10 $
// +------------------------------------------------------------------------------------------------------+
*/
// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm.php' ;
require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm/textarea.php' ;
//appel du fichier de constantes des langues
include_once 'langues/questionnaire.langue.'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php'; 


// +------------------------------------------------------------------------------------------------------+
// |                                                 CLASSE                                               |
// +------------------------------------------------------------------------------------------------------+

class Questionnaire_Admin {
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
        //-------------------------------------------------------------------------------------------------------------------
        // Initialisation des attributs
        $this->objet_pear_auth = $GLOBALS['_GEN_commun']['pear_auth'];
        $this->objet_pear_db = $GLOBALS['_GEN_commun']['pear_db'];
        $this->objet_pear_url = $GLOBALS['_GEN_commun']['url'];
        $this->sortie_xhtml = '<h1>'.QUESTIONNAIRE_CONFIG.'</h1>'."\n";        
        
        //-------------------------------------------------------------------------------------------------------------------
        // Gestion des boutons de l'interface
        if (isset($_POST['afficheur_annuler'])) {
            return false;
        } else if (isset($_POST['afficheur_enregistrer_quitter'])) {
            $requete = 'UPDATE gen_menu SET gm_application_arguments="num_questionnaire='.$_POST['num_questionnaire'].
					   '||mail_questionnaire='.$_POST['mail_questionnaire'].'||texte_questionnaire_envoye='.$_POST['texte_questionnaire_envoye'].'" WHERE gm_id_menu='.$_GET['adme_menu_id'];            
            $resultat = $this->objet_pear_db->query($requete) ;
            if (DB::isError($resultat)) {
            	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
            }
            return false;
        }
        
        //--------------------------------------------------------------------------------------------------------------
        // Gestion des valeurs par defauts, en fonctions des donnees sauvees dans le menu
        $requete = 'SELECT gm_application_arguments FROM gen_menu WHERE gm_id_menu='.$_GET['adme_menu_id'];
        $resultat = $this->objet_pear_db->query($requete) ;
        //echo $requete;
        if (DB::isError($resultat)) {
        	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
        }
        $valeurs_par_defaut = array();
        if ($resultat->numRows()>0) {        	        	
        	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {        		
        		$arguments = explode('||', $ligne->gm_application_arguments);        	
 				for ($i = 0; $i < count($arguments); $i++) {
 					$attr = explode('=', $arguments[$i], 2);
 					if ($attr[0] != '') {
 						$info_application->$attr[0] = (isset($attr[1]) ? $attr[1] : '');
 					}
 			   	}
 			}
        	//valeurs par defaut enregistrees dans la table        	
        	if (isset($info_application)) {
        		$valeurs_par_defaut['num_questionnaire']=$info_application->num_questionnaire; 
        		$valeurs_par_defaut['mail_questionnaire']=$info_application->mail_questionnaire;   
        		$valeurs_par_defaut['texte_questionnaire_envoye']=$info_application->texte_questionnaire_envoye;
        	}      
        } else {
        	//valeurs par defaut pour afficher une carto des structures
        	$valeurs_par_defaut['num_questionnaire']='';
        	$valeurs_par_defaut['mail_questionnaire']='';
        	$valeurs_par_defaut['texte_questionnaire_envoye']='';
        }
        
        //--------------------------------------------------------------------------------------------------------------
        // Gestion du questionnaire
        $this->objet_pear_url->addQueryString('adme_site_id', $_GET['adme_site_id']);
        $this->objet_pear_url->addQueryString('adme_menu_id', $_GET['adme_menu_id']);
        $this->objet_pear_url->addQueryString('adme_action', 'administrer');
        $form = new HTML_QuickForm('form_param_questionnaire', 'post', str_replace('&amp;', '&', $this->objet_pear_url->getUrl()));
        $squelette =& $form->defaultRenderer();
        $squelette->setFormTemplate("\n".'<form {attributes}>'."\n".'{content}'."\n".'</form>'."\n");
        $squelette->setElementTemplate( '<p>'."\n".
                                        '<label style="width:100px;padding:5px;text-align:right;">{label}'.
                                        '<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required -->'."\n".
                                        '<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
										' : </label>'."\n".'{element}'."\n".
										'</p>'."\n" );
        
        // on récupère tous les questionnaires
        $requete = 'SELECT bti_id, bti_nom FROM pap_formulaires WHERE bti_groupe="questionnaire" AND bti_i18n LIKE "'.$GLOBALS['_GEN_commun']['i18n'].'%"' ;      
        $resultat = $this->objet_pear_db->query($requete) ;
        if (DB::isError($resultat)) {
        	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
        }              
        if ($resultat->numRows()>0) { 
        	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
        		$select[$ligne->bti_id]=$ligne->bti_nom;        		
    		}           	
        }
        $option=array('style'=>'width: 200px;');
		$select= new HTML_QuickForm_select('num_questionnaire', QUESTIONNAIRE_CHOIX, $select, $option);
		$select->setSize(1);
		$select->setMultiple(0);
		$form->addElement($select) ;
		$formtexte= new HTML_QuickForm_textarea('texte_questionnaire_envoye', QUESTIONNAIRE_TEXTE_MESSAGE_ENVOYE, array('style'=>'white-space: normal;'));
		$formtexte->setCols(40);
		$formtexte->setRows(10);
		$form->addElement($formtexte) ;	
		$form->applyFilter('texte_questionnaire_envoye', 'addslashes') ;
        $form->addElement('text', 'mail_questionnaire', QUESTIONNAIRE_MAIL);                
        $liste_bouton_debut = '<ul class="liste_bouton">'."\n";
        $form->addElement('html', $liste_bouton_debut);
        $form->addElement('submit', 'afficheur_enregistrer_quitter', QUESTIONNAIRE_ENREGISTRER_ET_QUITTER);
        $form->addElement('submit', 'afficheur_annuler', QUESTIONNAIRE_ANNULER);
        $liste_bouton_fin = '</ul>'."\n";
        $form->addElement('html', $liste_bouton_fin);
        $form->setDefaults($valeurs_par_defaut);
        $this->sortie_xhtml .= $form->toHTML()."\n";	
        return $this->sortie_xhtml;
    }

}// Fin de la classe

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+
?>