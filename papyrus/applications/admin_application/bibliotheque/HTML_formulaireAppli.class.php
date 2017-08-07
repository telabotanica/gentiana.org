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
// CVS : $Id: HTML_formulaireAppli.class.php,v 1.5 2007-06-26 14:18:53 florian Exp $
/**
* Application projet
*
* La classe HTML_formulaireAuth
*
*@package projet
//Auteur original :
*@author        Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.5 $
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
 * Cette classe représente un formulaire pour saisir un projet ou le modifier.
 */
class HTML_formulaireAppl extends HTML_QuickForm
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
    function HTML_formulaireAppl( $formName = "",  $method = "post",  $action = "",  $target = "_self",  $attributes = "",  $trackSubmit = false )
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
        $squelette =& $this->defaultRenderer();
        $squelette->setFormTemplate("\n".'<form {attributes}>'."\n".'{content}'."\n".'</form>'."\n");
		$squelette->setElementTemplate( '<p class="formulaire_element"><span class="form_label">'."\n".
			'{label}'."\n".
			'<!-- BEGIN required --><span style="color:red; width:5px; margin:0; padding:0;">*</span><!-- END required -->'."\n".		
			'</span>'."\n".'{element}'."\n".
			'<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
			'</p>'."\n");
		$squelette->setGroupElementTemplate('<p style="display:inline">{element}</p>', 'form_boutons');
		$squelette->setRequiredNoteTemplate("\n".'<p class="symbole_obligatoire">*&nbsp;:&nbsp;{requiredNote}</p>'."\n");
		//Note pour les erreurs javascript
		$this->setJsWarnings('Erreur de saisie', 'Veuillez verifier vos informations saisies');
	    // Note de fin de formulaire
	    $this->setRequiredNote('Indique les champs obligatoires');
        $this->addElement ('text', 'nom_appl', ADAP_NOM_APPL, array ('size' => 35)) ;
        $this->addRule ('nom_appl', ADAP_NOM_APPL_ALERTE, 'required', '', 'client') ;        
        $this->addElement ('textarea', 'description', ADAP_DESCRIPTION, array ('cols' => 50, 'rows' => 5)) ;
        $this->addElement ('text', 'chemin', ADAP_CHEMIN, array('size' => 35)) ;
        $this->addElement('html', '<br />');
        $this->setRequiredNote(ADAP_CHAMPS_REQUIS) ;
        // on fait un groupe avec les boutons pour les mettres sur la même ligne
        $buttons[] = &HTML_QuickForm::createElement('button', 'annuler', ADAP_ANNULER, array ("onclick" => "javascript:document.location.href='".str_replace ('&amp;', '&', $url_retour->getURL())."'"));
        $buttons[] = &HTML_QuickForm::createElement('submit', 'valider', ADAP_VALIDER);
        $this->addGroup($buttons, 'form_boutons', null, '&nbsp;');
    } // end of member function _construitFormulaire
} // end of HTML_formulaireProjet
?>
