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
// CVS : $Id: HTML_formulaireAuth.class.php,v 1.5 2007-06-26 14:18:53 florian Exp $
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
class HTML_formulaireAuth extends HTML_QuickForm
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
    function HTML_formulaireAuth($formName = '', $method = 'post', $action = '', $target = '_self', $attributes = '', $trackSubmit = false)
    {
        HTML_QuickForm::HTML_QuickForm($formName, $method, $action, $target, $attributes, $trackSubmit);
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
//        $squelette->setFormTemplate("\n".'<form{attributes}>'."\n".'{content}'."\n".'</form>'."\n");
//        $squelette->setElementTemplate(  '<li>'."\n".
//                                    '{label}'."\n".
//                                    '{element}'."\n".
//                                    '<!-- BEGIN required --><span class="symbole_obligatoire">'.ADAU_SYMBOLE_CHP_OBLIGATOIRE.'</span><!-- END required -->'."\n".
//                                    '<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
//                                    '</li>'."\n");
//        $squelette->setRequiredNoteTemplate("\n".'<p><span class="symbole_obligatoire">'.ADAU_SYMBOLE_CHP_OBLIGATOIRE.'</span> {requiredNote}</p>'."\n");
    } // end of member function HTML_formulaireProjet

    /**
     * Renvoie le code HTML du formulaire.
     *
     * @return string
     * @access public
     */
    function toHTML()
    {
        $res = HTML_QuickForm::toHTML();
        return $res;
    } // end of member function toHTML

    /**
     * Ajoute les champs nécessaire au formulaire.
     *
     * @return void
     * @access public
     */
    function construitFormulaire($url_retour)
    {
        $tab_index = 1000;
        $size = 35;
        $cols = 50;
        $rows = 6;
        
        $form_debut = '<fieldset>'."\n".'<legend>'.ADAU_NOM_FORM.'</legend>'."\n";
        $this->addElement('html', $form_debut);
        
        $id = 'nom_auth';
        $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => $size);
        $label = '<label for="'.$id.'">'.ADAU_NOM_AUTH.'</label>';
        $this->addElement('text', $id, $label, $aso_attributs);
        $this->addRule('nom_auth', ADAU_NOM_AUTH_ALERTE, 'required', '', 'client');
        
        $id = 'abreviation';
        $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => $size);
        $label = '<label for="'.$id.'">'.ADAU_ABREVIATION.'</label>';
        $this->addElement('text', $id, $label, $aso_attributs);
        $this->addRule('abreviation', ADAU_ABREVIATION_ALERTE, 'required', '', 'client');
        
        $id = 'dsn';
        $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => $size);
        $label = '<label for="'.$id.'">'.ADAU_DSN.'</label>';
        $this->addElement('text', $id, $label, $aso_attributs);
        $this->addRule('dsn', ADAU_DSN_ALERTE, 'required', '', 'client');
        
        $id = 'nom_table';
        $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => $size);
        $label = '<label for="'.$id.'">'.ADAU_NOM_TABLE.'</label>';
        $this->addElement('text', $id, $label, $aso_attributs);
        $this->addRule('nom_table', ADAU_NOM_TABLE_ALERTE, 'required', '', 'client');
        
        $id = 'champs_login';
        $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => $size);
        $label = '<label for="'.$id.'">'.ADAU_CHAMPS_LOGIN.'</label>';
        $this->addElement('text', $id, $label, $aso_attributs);
        $this->addRule('champs_login', ADAU_CHAMPS_LOGIN_ALERTE, 'required', '', 'client');
        
        $id = 'champs_passe';
        $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => $size);
        $label = '<label for="'.$id.'">'.ADAU_CHAMPS_PASSE.'</label>';
        $this->addElement('text', $id, $label, $aso_attributs);
        $this->addRule('champs_passe', ADAU_CHAMPS_PASSE_ALERTE, 'required', '', 'client');
        
        $id = 'cryptage';
        $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => $size);
        $label = '<label for="'.$id.'">'.ADAU_CRYPTAGE.'</label>';
        $this->addElement('text', $id, $label, $aso_attributs);
        $this->addRule('cryptage', ADAU_CRYPTAGE_ALERTE, 'required', '', 'client');
        
        $id = 'parametres';
        $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'rows' => $rows, 'cols' => $cols);
        $label = '<label for="'.$id.'">'.ADAU_PARAMETRE.'</label>';
        $this->addElement('textarea', $id, $label, $aso_attributs);
        
        $form_fin = "\n".'</fieldset>'."\n";
        $this->addElement('html', $form_fin);
        
        // Gestion des boutons
        $buttons[] = &HTML_QuickForm::createElement('link', 'annuler', ADAU_ANNULER, 
                 str_replace ("&amp;", "&", $url_retour->getURL()), ADAU_ANNULER); // Le preg_replace contourne un pb de QuickForm et Net_URL
                                                                                         // qui remplacent deux fois les & par des &amp;
		//Bouton de validation du formulaire                                                 // ce qui fait échouer le lien
		$buttons[] = &HTML_QuickForm::createElement('submit', 'valider', ADAU_VALIDER);
		$this->addGroup($buttons, 'form_boutons', null, '&nbsp;');
        
        
//        $liste_bouton_debut = '<ul class="liste_bouton">'."\n";
//        $this->addElement('html', $liste_bouton_debut);
//        
//        $this->addElement('submit', 'valider', ADAU_VALIDER);
//        
//        $bouton_annuler = '<li><a class="bouton" href="'.str_replace ('&amp;', '&', $url_retour->getURL()).'">'.ADAU_ANNULER.'</a></li>'."\n";
//        $this->addElement('html', $bouton_annuler);
//        
//        $liste_bouton_fin = '</ul>'."\n";
//        $this->addElement('html', $liste_bouton_fin);
        
        
        $this->setRequiredNote(ADAU_CHAMPS_REQUIS);
        
    } // end of member function _construitFormulaire

} // end of HTML_formulaireProjet
?>
