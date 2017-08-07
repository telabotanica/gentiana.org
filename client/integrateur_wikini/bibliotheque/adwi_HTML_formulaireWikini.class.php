<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or                                        |
// | modify it under the terms of the GNU General Public                                                  |
// | License as published by the Free Software Foundation; either                                         |
// | version 2.1 of the License, or (at your option) any later version.                                   |
// |                                                                                                      |
// | This library is distributed in the hope that it will be useful,                                      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU                                    |
// | General Public License for more details.                                                             |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public                                            |
// | License along with this library; if not, write to the Free Software                                  |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: adwi_HTML_formulaireWikini.class.php,v 1.12 2007-04-20 13:14:05 neiluj Exp $
/**
*
* Admin Wikini
*
* Classe affichage gestion des Wikini de Papyrus
*
*@package projet
//Auteur original :
*@author        David Delon <david.delon@clapas.net>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.12 $
// +------------------------------------------------------------------------------------------------------+
*/


// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

/** Inclure le fichier de langue pour utiliser cette classe de façon autonome. */

require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm.php' ;
require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm/checkbox.php' ;
require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm/select.php' ;

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE des constantes                                       |
// +------------------------------------------------------------------------------------------------------+


/**
 * class HTML_formulaireProjet
 * Cette classe représente un formulaire pour saisir un wikini ou le modifier
 */
class HTML_formulaireWikini extends HTML_QuickForm
{
    /**
     * Constructeur
     *
     * @param string formName Le nom du formulaire.
     * @param string method Soit get soit post, voir le protocole HTTP
     * @param string action L'action du formulaire.
     * @param string target La cible du formulaire.
     * @param Array attributes Des attributs supplémentaires pour la balise <form>
     * @param bool trackSubmit Pour repérer si la formulaire a été soumis.
     * @return void
     * @access public
     */
    function HTML_formulaireWikini( $formName = "",  $method = "post",  $action = "",  $target = "_self",  $attributes = "",  $trackSubmit = false )
    {
        HTML_QuickForm::HTML_QuickForm($formName, $method, $action, $target, $attributes, $trackSubmit) ;
    } // end of member function HTML_formulaireProjet

    /**
     * Renvoie le code HTML du formulaire.
     *
     * @return string
     * @access public
     */
    function toHTML( )
    {
        $res = HTML_QuickForm::toHTML() ;
        return $res ;
    } // end of member function toHTML

    /**
     * Ajoute les champs nécessaire au formulaire.
     *
     * @return void
     * @access public
     */
    function construitFormulaire($url_retour)
    {

        $this->addElement ('text', 'code_alpha_wikini', ADWI_NOM_WIKINI, array ('size' => 60)) ;
        $this->addRule ('code_alpha_wikini', ADWI_NOM_WIKINI_ALERTE, 'required', '', 'client') ;
		$this->addRule ('code_alpha_wikini', ADWI_NOM_WIKINI_NON_VALIDE, 'lettersonly', '', 'client');
        // Défault : PagePrincipale
        $this->addElement ('text', 'page', ADWI_PAGE, array ('size' => 60)) ;

        $this->addElement ('static', '', 'Configuration avancée : ') ;

        $this->addElement ('text', 'bdd_hote', ADWI_BDD_HOTE, array ('size' => 60)) ;
        $this->addElement ('text', 'bdd_nom', ADWI_BDD_NOM, array ('size' => 60)) ;
        $this->addElement ('text', 'bdd_utilisateur', ADWI_BDD_UTILISATEUR, array ('size' => 60)) ;
        $this->addElement ('password', 'bdd_mdp', ADWI_BDD_MDP, array ('size' => 60)) ;
        $this->addElement ('text', 'table_prefix', ADWI_TABLE_PREFIX, array ('size' => 60)) ;
        $this->addElement ('text', 'chemin', ADWI_CHEMIN, array ('size' => 60)) ;

        $this->setRequiredNote('<span style="color: #ff0000">*</span>'.ADWI_CHAMPS_REQUIS) ;

        // on fait un groupe avec les boutons pour les mettres sur la même ligne
        $buttons[] = &HTML_QuickForm::createElement('button', 'annuler', ADWI_ANNULER, array ("onclick" => "javascript:document.location.href='".str_replace ('&amp;', '&', $url_retour->getURL())."'",
        												'id' => 'annuler', 'class' => 'bouton'));
        $buttons[] = &HTML_QuickForm::createElement('submit', 'valider', ADWI_VALIDER, array ('id' => 'valider', 'class' =>'bouton'));
        $this->addGroup($buttons, null, null, '&nbsp;');

    } // end of member function _construitFormulaire
} // end of HTML_formulaireProjet
?>
