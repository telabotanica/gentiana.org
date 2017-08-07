<?php
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1																					  |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)							   	          |
// +------------------------------------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or										  |
// | modify it under the terms of the GNU Lesser General Public										      |
// | License as published by the Free Software Foundation; either										  |
// | version 2.1 of the License, or (at your option) any later version.								      |
// |																									  |
// | This library is distributed in the hope that it will be useful,									  |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of									      |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU									  |
// | Lesser General Public License for more details.													  |
// |																									  |
// | You should have received a copy of the GNU Lesser General Public									  |
// | License along with this library; if not, write to the Free Software								  |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA							  |
// +------------------------------------------------------------------------------------------------------+
/**
* Fonctions du module inscription
*
* Fonctions du module inscription
*
*@package inscription
//Auteur original :
*@author		Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@author	   	Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright		Tela-Botanica 2000-2004
*@version	   	$Id: inscription.class.php,v 1.3 2005/05/13 13:48:38 alex Exp $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |											ENTETE du PROGRAMME									   |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |										   LISTE de FONCTIONS										 |
// +------------------------------------------------------------------------------------------------------+

class HTML_formulaireInscription extends HTML_Quickform {
	
	var $mode_ajout = true;
	/**
	 *  Constructeur
	 *
	 * @param string formName Le nom du formulaire
	 * @param string method Méthode post ou get
	 * @param string action L'action du formulaire.
	 * @param int target La cible.
	 * @param Array attributes Les attributs HTML en plus.
	 * @param bool trackSubmit ??
	 * @return void
	 * @access public
	 */	
	function HTML_forumlaireInscription ( $formName,  $method = "post",  $action,  $target = "_self",  $attributes,  $trackSubmit = false ) {
		HTML_Quickform::HTML_Quickform($formName, $method, $action, $target, $attributes, $trackSubmit) ;
	}

	/**
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function construitFormulaire($url, $liste_pays)
	{
	$squelette =& $this->defaultRenderer();
	$squelette->setFormTemplate("\n".'<form{attributes}>'."\n".'{content}'."\n".'</form>'."\n");
	
	$modele_element_debut = '<li class="groupe_formulaire">'."\n".'<span class="inscription_label1">{label}<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required --></span>'.
									"\n".'{element}'."\n".''."\n".
									'<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
									''."\n" ;
	$modele_element_fin = "\n".'<span class="inscription_label2">{label}<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required --></span>'.
									"\n".'{element}'."\n".''."\n".
									'<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
									'</li>'."\n" ;
	
	$squelette->setElementTemplate( '<li class="liste_inscription">'."\n".'<span class="inscription_label">{label}<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required --></span>'.
									"\n".'{element}'."\n".''."\n".
									'<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
									'</li>'."\n");
	//$squelette->setElementTemplate(, ) ;
	// Les modèles pour les champs qui se tienne 2 par ligne
	foreach (array('mot_de_passe', 'nom', 'cp') as $valeur) $squelette->setElementTemplate( $modele_element_debut, $valeur);
	foreach (array('password_repete', 'prenom', 'ville') as $valeur) $squelette->setElementTemplate( $modele_element_fin, $valeur);
	
	$squelette->setElementTemplate( '<ul><li class="groupe_bouton">{element}', 'annuler');
	$squelette->setElementTemplate( '{element}</li></ul>', 'valider');
	
	$squelette->setRequiredNoteTemplate("\n".'<p>'."\n".'<span class="symbole_obligatoire">*</span> {requiredNote}'."\n".'</p>'."\n");
	
	$fieldset_debut =	'<fieldset>'."\n".
							'<legend>'.(($this->mode_ajout) ? INS_AJOUT_MEMBRE : INS_MODIF_MEMBRE).'</legend>'."\n".
							'<ul>'."\n";
	$this->addElement('html', $fieldset_debut);
	$this->addElement ('text', 'email', INS_EMAIL) ;
	$this->addRule ('email', INS_EMAIL_REQUIS, 'required','', 'client') ;
	$this->addRule ('email', INS_MAIL_INCORRECT, 'email', '', 'client') ;
	$this->registerRule('doublon', 'callback', 'verif_doublonMail') ;
	$this->addRule ('email', INS_MAIL_DOUBLE, 'doublon', true) ;
	
	$this->addElement('password', 'mot_de_passe', INS_MOT_DE_PASSE);
	$this->addElement('password', 'password_repete', INS_REPETE_MOT_DE_PASSE);
	$this->addRule ('mot_de_passe', INS_MOT_DE_PASSE_REQUIS, 'required', '', 'client') ;
	$this->addRule ('password_repete', INS_MOT_DE_PASSE_REQUIS, 'required', '', 'client') ;

	$this->addElement('text', 'nom', INS_NOM);
	$this->addElement('text', 'prenom', INS_PRENOM);
	$this->addRule ('nom', INS_NOM_REQUIS, 'required', '', 'client') ;
	$this->addRule ('prenom', INS_PRENOM_REQUIS, 'required', '', 'client') ;
	
	$this->addElement ('text', 'adresse_1', INS_ADRESSE_1) ;
	$this->addElement ('text', 'adresse_2', INS_ADRESSE_2) ;
	$this->addElement ('text', 'region', INS_REGION) ;
	
	$this->addElement('text', 'cp', INS_CODE_POSTAL) ;
	$this->addElement('text', 'ville', INS_VILLE) ;
	$this->addRule ('cp', INS_CODE_POSTAL_REQUIS, 'required', '', 'client') ;
	$this->addRule ('ville', INS_VILLE_REQUIS, 'required', '', 'client') ;
	
	// L'élément pays est construit à partir de la table des pays
	$s =& $this->createElement('select','pays',INS_PAYS);
	$s->loadArray($liste_pays,'fr');
	$this->addElement($s);
	
	if (INS_UTILISE_LISTE) {
		$element_lettre = new HTML_QuickForm_checkbox ('lettre', '', INS_LETTRE) ;
		$this->addElement($element_lettre) ;
	}
	
	$this->addElement ('text', 'site', INS_SITE_INTERNET) ;
	
	$fieldset_fin =	'</ul>'."\n".
						'</fieldset>'."\n";
	$this->addElement('html', $fieldset_fin);
	
	/* $fieldset_debut =	'<fieldset>'."\n".
							'<legend>'.INS_ADHERENT.'</legend>'."\n".
							'<ul>'."\n";
	$this->addElement('html', $fieldset_debut);

	$this->addElement ('text', 'organisme', INS_ORGANISME) ;
	$this->addElement ('text', 'fonction', INS_FONCTION) ;
	$fieldset_fin =	'</ul>'."\n".
						'</fieldset>'."\n";
	$this->addElement('html', $fieldset_fin);

	$fieldset_debut = '<fieldset>'."\n".
							'<legend>'.INS_ETES_BOTANISTE.'</legend>'."\n".
							'<ul>'."\n";
	$this->addElement('html', $fieldset_debut);
	
	// requete pour trouver les niveaux en botanique
	$requete = "select * from annuaire_LABEL_NIV" ;
	$resultat = $GLOBALS['ins_db']->query ($requete) ;
	if (DB::isError($resultat)) {
		die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
	}
	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
		$this->addElement ('radio', 'niveau', '', $ligne->LABEL_NIV, $ligne->ID_LABEL_NIV) ;
	}
	
	$fieldset_fin =	'</ul>'."\n".
						'</fieldset>'."\n";
	$this->addElement('html', $fieldset_fin);
  
  
	// L'activité professionnelle
	$fieldset_debut = '<fieldset>'."\n".
							'<legend>'.INS_ACTIVITE_PROFESSIONNELLE.'</legend>'."\n".
							'<ul>'."\n";
	$this->addElement('html', $fieldset_debut);

		
	// requete pour trouver les niveaux en botanique
	$requete = "select * from annuaire_LABEL_ACT" ;
	$resultat = $GLOBALS['ins_db']->query ($requete) ;
	if (DB::isError($resultat)) {
		die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
	}
	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
		$this->addElement ('radio', 'activite', '', $ligne->LABEL_ACT, $ligne->ID_LABEL_ACT) ;
	}
	
	$fieldset_fin =	'</ul>'."\n".
						'</fieldset>'."\n";
	$this->addElement('html', $fieldset_fin);
	
	// L'activité professionnelle
	$fieldset_debut = '<fieldset>'."\n".
							'<legend>'.INS_MEMBRE_ASSO.'</legend>'."\n".
							'<ul>'."\n";
	$this->addElement('html', $fieldset_debut);
	
	// requete pour trouver les niveaux en botanique
	$requete = "select * from annuaire_LABEL_ASS" ;
	$resultat = $GLOBALS['ins_db']->query ($requete) ;
	if (DB::isError($resultat)) {
		die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
	}
	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
		$this->addElement ('radio', 'asso', '', $ligne->LABEL_ASS, $ligne->ID_LABEL_ASS) ;
	}
	
	$fieldset_fin =	'</ul>'."\n".
						'</fieldset>'."\n";
	$this->addElement('html', $fieldset_fin);

	// Les spécialité
	$fieldset_debut = '<fieldset>'."\n".
							'<legend>'.INS_SPECIALISTE.'</legend>'."\n".
							'<ul>'."\n";
	$this->addElement('html', $fieldset_debut);
	$this->addElement ('textarea', 'specialite', '', array ('cols' => 50, 'rows' => 4)) ;
	$fieldset_fin =	'</ul>'."\n".
						'</fieldset>'."\n";
	$this->addElement('html', $fieldset_fin);
	

	// Les spécialité géographiques
	$fieldset_debut = '<fieldset>'."\n".
							'<legend>'.INS_SPE_ZONE.'</legend>'."\n".
							'<ul>'."\n";
	$this->addElement('html', $fieldset_debut);
	$this->addElement ('textarea', 'specialite_geo', '', array ('cols' => 50, 'rows' => 4)) ;
	$fieldset_fin =	'</ul>'."\n".
						'</fieldset>'."\n";
	$this->addElement('html', $fieldset_fin);*/
	
	if (!$this->mode_ajout)  {
		$this->addElement ('link', 'annuler', '', preg_replace ('/&amp;/', '&', $GLOBALS['ins_url']->getURL()), INS_ANNULER) ;
	}
	$this->addElement ('submit', 'valider', INS_VALIDER) ;
	
	$this->setRequiredNote(INS_NOTE_REQUIS) ;
	}
	
	/** Modifie le formulaire pour l'adapter au cas des structures
	 * 
	 *
	 * @return void
	 * @access public
	 */
	function formulaireStructure()
	{
		$this->removeElement('email', false) ;
		$mail = & HTML_QuickForm::createElement ('text', 'email', INS_MAIL_STRUCTURE) ;
		$this->insertElementBefore ($mail, 'mot_de_passe') ;
		$nom_structure = & HTML_QuickForm::createElement ('text', 'nom', INS_NOM_STRUCTURE) ;
		$this->insertElementBefore ($nom_structure, 'email') ;
		$this->removeElement ('site', false) ;
		$site_structure = & HTML_QuickForm::createElement ('text', 'site', INS_SITE_STRUCTURE) ;
		$this->insertElementBefore ($site_structure, 'pays') ;
		$this->addElement ('hidden', 'est_structure', 1) ;
		$sigle_structure = & HTML_QuickForm::createElement ('text', 'sigle_structure', INS_SIGLE_STRUCTURE) ;
		$this->insertElementBefore ($sigle_structure, 'nom') ;
		$this->addRule ('sigle_structure', INS_SIGLE_REQUIS, 'required', '', 'client') ;
	}
	/**
	 * 
	 *
	 * @return string
	 * @access public
	 */
	function toHTML( )
	{
		$res = HTML_QuickForm::toHTML() ;
		return $res ;
	} // end of member function toHTML
}

class ListeDePays extends PEAR{

	var $_db ;
	/** Constructeur
	 *  Vérifie l'existance de la table gen_pays_traduction
	 *
	 * @param  DB  Un objet PEAR::DB
	 * @return
	 */
	function ListeDePays (&$objetDB) {
		$this->_db = $objetDB ;
		$requete = 'SHOW TABLES';
		$resultat = $objetDB->query($requete) ;
		if (DB::isError ($resultat)) {
			die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
		}
		while ($ligne = $resultat->fetchRow()) {
			if ($ligne[0] == INS_TABLE_PAYS) {
				return ;
			}
		}
		return $this->raiseError('La table '.INS_TABLE_PAYS.' n\'est pas présente dans la base de donnée !') ;
	}
	
	/** Renvoie la liste des pays traduite
	 *
	 * @param  string  une chaine de type i18n ou une chaine code iso langue (fr_FR ou fr ou FR)
	 * @return  un tableau contenant en clé, le code iso du pays, en majuscule et en valeur le nom du pays traduit
	 */
	function getListePays ($i18n) {
		if (strlen($i18n) == 2) {
			$i18n = strtolower($i18n).'-'.strtoupper($i18n) ;
		}
		$requete = 	'SELECT '.INS_CHAMPS_ID_PAYS.', '.INS_CHAMPS_LABEL_PAYS.' '.
					'FROM '.INS_TABLE_PAYS.' '.
					'WHERE '.INS_CHAMPS_PAYS_LG.' = "fr" '.
					'ORDER BY '.INS_CHAMPS_LABEL_PAYS.' ';
		$resultat = $this->_db->query($requete);
		if (DB::isError($resultat)) {
			die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
		}
		if ($resultat->numRows() == 0) {
			return $this->raiseError('Le code fourni ne correspond à aucun pays ou n\'est pas dans la table!') ;
		}
		$retour = array() ;
		while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
			$retour[$ligne[INS_CHAMPS_ID_PAYS]] = $ligne[INS_CHAMPS_LABEL_PAYS];
		}
		return $retour;
	}
}



/* +--Fin du code ----------------------------------------------------------------------------------------+
* Revision 1.1  2004/06/18 09:20:47  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/

?>
