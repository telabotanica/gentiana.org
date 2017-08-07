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
//Autres auteurs :
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/
// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                                 CLASSE                                               |
// +------------------------------------------------------------------------------------------------------+
class Annuaire_Backoffice_Admin {
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
        require_once INS_CHEMIN_APPLI.'configuration/cartographie.config.inc.php';
        require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm.php' ;
                
        //-------------------------------------------------------------------------------------------------------------------
        // Initialisation des attributs
        $this->objet_pear_auth = $GLOBALS['_GEN_commun']['pear_auth'];
        $this->objet_pear_db = $GLOBALS['ins_db'];
        $this->objet_pear_url = $GLOBALS['_GEN_commun']['url'];
        $this->sortie_xhtml = '<h1>'.INS_CONFIG_ANNUAIRE_BACKOFFICE.'</h1><br />'."\n";        
        
        //-------------------------------------------------------------------------------------------------------------------
        // Gestion des boutons de l'interface
        if (isset($_POST['afficheur_annuler'])) {
            return false;
        } else if (isset($_POST['afficheur_enregistrer_quitter'])) {
            $requete = 'UPDATE gen_menu SET gm_application_arguments="type_annuaire='.$_POST['type_annuaire'].'" WHERE gm_id_menu='.$_GET['adme_menu_id'];            
            $resultat = $this->objet_pear_db->query($requete) ;
            if (DB::isError($resultat)) {
            	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
            }
            return false;
        }
        
        //--------------------------------------------------------------------------------------------------------------
        // Gestion des valeurs par defauts, en fonctions des donnees sauvees dans carto_config
        $requete = 'SELECT gm_application_arguments FROM gen_menu WHERE gm_id_menu='.$_GET['adme_menu_id'];
        $resultat = $this->objet_pear_db->query($requete) ;
        if (DB::isError($resultat)) {
        	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
        }
        $valeurs_par_defaut = array();
        if ($resultat->numRows()>0) {
        	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
 				$arguments = explode(' ', $ligne->gm_application_arguments);
 				var_dump($arguments);
 				for ($i = 0; $i < count($arguments); $i++) {
 					$attr = explode('=', $arguments[$i]);
 					if ($attr[0] != '') {
 						$info_application->$attr[0] = (isset($attr[1]) ? $attr[1] : '');
 					}
 			   	}
 			}
        	//valeurs par defaut enregistrees dans la table        	
        	$valeurs_par_defaut['type_annuaire']=$info_application->type_annuaire;      
        } else {
        	//valeurs par defaut pour afficher une carto des structures
        	$valeurs_par_defaut['type_annuaire']=0;       	
        }
        
        //--------------------------------------------------------------------------------------------------------------
        // Gestion du formulaire
        $this->objet_pear_url->addQueryString('adme_site_id', $_GET['adme_site_id']);
        $this->objet_pear_url->addQueryString('adme_menu_id', $_GET['adme_menu_id']);
        $this->objet_pear_url->addQueryString('adme_action', 'administrer');
        $form = new HTML_QuickForm('form_param_annuaire_backoffice', 'post', str_replace('&amp;', '&', $this->objet_pear_url->getUrl()));
        $squelette =& $form->defaultRenderer();
        $squelette->setFormTemplate("\n".'<form{attributes}>'."\n".'{content}'."\n".'</form>'."\n");
        $squelette->setElementTemplate( '<p>'."\n".
                                        '<label style="width:100px;padding:5px;text-align:right;">{label}'.
                                        '<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required -->'."\n".
                                        '<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
										' : </label>'."\n".'{element}'."\n".
										'</p>'."\n" );
        $option_tables[0] = INS_ANNUAIRE_BOTTIN;
        $option_tables[1] = INS_ANNUAIRE_ADMIN_PAPYRUS;
        $form->addElement('select', 'type_annuaire', INS_TYPE_ANNUAIRE, $option_tables);         
        $liste_bouton_debut = '<ul class="liste_bouton">'."\n";
        $form->addElement('html', $liste_bouton_debut);
        $form->addElement('submit', 'afficheur_enregistrer_quitter', INS_ENREGISTRER_ET_QUITTER);
        $form->addElement('submit', 'afficheur_annuler', INS_ANNULER);
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