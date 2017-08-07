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
// CVS : $Id: contact.php,v 1.3 2006-04-28 11:35:37 florian Exp $
/**
* Contact
*
* Un module d'envoi de mails a une personne de l'annuaire, choisie par une liste déroulante
*
*@package inscription
//Auteur original :
*@author        Florian SCHMITT <florian@ecole-et-nature.org>
*
*@copyright     Réseau Ecole et Nature 2005
*@version       $Revision: 1.3 $ $Date: 2006-04-28 11:35:37 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+


function afficherContenuCorps() {
	include_once 'client/contact/langues/contact.langue.'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php'; //appel du fichier de constantes des langues
	$url = preg_replace ('/&amp;/', '&', $GLOBALS['_GEN_commun']['url']->getURL()) ;
	if (isset($_POST['Destinataire'])) {
		$headers  = 'From: '.$_POST['Expediteur'].' <'.$_POST['Expediteur'].'>'."\n";
		$headers .= "X-Mailler: Florian\n";
		if ($_POST['Destinataire']==1) $destinataire='isabelle.lepeule@ecole-et-nature.org';
		elseif ($_POST['Destinataire']==2) $destinataire='roland.gerard@ecole-et-nature.org';
		elseif ($_POST['Destinataire']==3) $destinataire='fabienne.chadenier@ecole-et-nature.org';
		elseif ($_POST['Destinataire']==4) $destinataire='gaelle.haussaire@ecole-et-nature.org';
		elseif ($_POST['Destinataire']==5) $destinataire='gregoire.delforge@ecole-et-nature.org';
		elseif ($_POST['Destinataire']==6) $destinataire='delphine.vinck@ecole-et-nature.org';
		elseif ($_POST['Destinataire']==7) $destinataire='catherine.stoven@ecole-et-nature.org';
		elseif ($_POST['Destinataire']==8) $destinataire='florian@ecole-et-nature.org';
		elseif ($_POST['Destinataire']==0) $destinataire='info@ecole-et-nature.org';
		mail($destinataire, $_POST['Subject'], $_POST['Text'], $headers); // Envoi du mail
		$message='<p style="clear:both;border: 2px solid #F00;padding:5px;color:#F00;background:#FFF;text-decoration: blink;">'.CON_VOTRE_MESSAGE.' <em style="font-style: italic;color:#F00;background:#FFF;"> '.$_POST['Subject'].' </em> '.CON_A_ETE_ENVOYE.'</p>';
	}
	$res='';
	if (isset($message)) {$res .= $message;}
	$res .= '<h1>'.CON_CONTACTEZ_NOUS.'</h1>'."\n";
	$res .= '<br />'."\n";
	$res .= '<h3>Adresse postale:</h3>'."\n";
	$res .= '<strong>Réseau Ecole et Nature</strong><br />'."\n";
	$res .= 'Espace République<br />'."\n";
	$res .= '20 rue de la République<br />'."\n";
	$res .= '34 000 Montpellier'."\n";
	$res .= '<br /><br />'."\n";
	$res .= '<h3>Coordonnées téléphoniques:</h3>Tél : 04 67 06 18 70<br />'."\n";
	$res .= 'Fax : 04 67 92 02 58'."\n";
	$res .= '<br /><br />'."\n";
	$res .= '<h3>'.CON_ENVOYER_NOUS_MAIL.'</h3>'."\n";
	$form_contact = new HTML_QuickForm('inscription', 'post', $url);
	$squelette =& $form_contact->defaultRenderer();
	$squelette->setFormTemplate("\n".'<form {attributes}>'."\n".'{content}'."\n".'</form>'."\n");
	$squelette->setElementTemplate( '<label>{label}&nbsp;</label><br />'."\n".'{element}'."\n".
	 '<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required -->'."\n".'<br />'."\n");
	$squelette->setRequiredNoteTemplate("\n".'<span class="symbole_obligatoire">* {requiredNote}</span>'."\n");
	$option=array('style'=>'width:500px;', 'maxlength'=>100);
	$form_contact->setRequiredNote(CON_CHAMPS_REQUIS) ;
	$form_contact->setJsWarnings(CON_ERREUR_SAISIE,CON_VEUILLEZ_CORRIGER);
	$form_contact->addElement('text', 'Expediteur', CON_EXPEDITEUR, $option);
	$form_contact->addRule('Expediteur', CON_EMAIL_REQUIS, 'required','', 'client') ;
    $form_contact->addRule('Expediteur', CON_EMAIL_INCORRECT, 'email', '', 'client') ;
	$liste_destinataires[0]='service d\'information générale';
	$liste_destinataires[1]='relations nationales';
	$liste_destinataires[2]='relations internationales';
	$liste_destinataires[3]='formations et professionnalisation';
	$liste_destinataires[4]='dispositifs pédagogiques';
	$liste_destinataires[5]='soutien à l\'organisation des acteurs';
	$liste_destinataires[6]='communication / édition';
	$liste_destinataires[7]='service de comptabilité';
	$liste_destinataires[8]='service informatique / hébergement Internet';
	$option=array('style'=>'width:500px;');
	$form_contact->addElement('select', 'Destinataire', CON_DESTINATAIRE, $liste_destinataires, $option);
	$option=array('style'=>'width:500px;','maxlength'=>100);
    $form_contact->addElement('text', 'Subject', CON_SUJET, $option);
    $form_contact->addRule('Subject', CON_SUJET_REQUIS, 'required','', 'client') ;
	$option=array('style'=>'width:500px;height:200px;white-space: pre;padding:3px;');
	require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm/textarea.php';
	$formtexte= new HTML_QuickForm_textarea('Text', CON_MESSAGE, $option);
	$form_contact->addElement($formtexte) ;
	$form_contact->addRule('Text', CON_MESSAGE_REQUIS, 'required','', 'client') ;
	$form_contact->addElement('submit', 'Envoyer', CON_ENVOYER);
	$res .= $form_contact->toHTML();
	return $res ;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: contact.php,v $
* Revision 1.3  2006-04-28 11:35:37  florian
* ajout constantes chemin
*
* Revision 1.2  2006/01/19 10:24:37  florian
* champs obligatoires pour le formulaire de saisie
*
* Revision 1.1  2005/09/22 13:28:50  florian
* Application de contact, pour envoyer des mails. Reste a faire: configuration pour choisir les destinataires dans l'annuaire.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
