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
// CVS : $Id: annuaire.fonct.php,v 1.7 2007/04/11 08:30:12 neiluj Exp $
/**
* Fonctions du module annuaire
*
* Fonctions du module annuaire
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

//include_once "HTML/QuickForm.php" ;

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

/** function inscription_onglets()  Affiche les onglets de présentation de la structure
*
*
*
*	@return string HTML
*/
function inscription_onglets() {
	$res='<ul id="onglets_inscription">'."\n";
	//partie présentation
	$GLOBALS['ins_url']->addQueryString('voir_fiche', $_GET['voir_fiche']);
	$res .= '<li id="fiche"><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_PRESENTATION.'</a>'."\n".'</li>'."\n";
	$GLOBALS['ins_url']->removeQueryString('voir_fiche');
	//partie abonnement
	$GLOBALS['ins_url']->addQueryString('voir_abonnement', $_GET['voir_fiche']);
	$res .= '<li id="abonnements"><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_ABONNEMENTS.'</a></li>'."\n" ;
	$GLOBALS['ins_url']->removeQueryString('voir_abonnement');
	//partie actualites
	$GLOBALS['ins_url']->addQueryString('voir_actus', $_GET['voir_fiche']);
	$res .= '<li id="actus"><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_ACTUALITES.'</a>'."\n".'</li>'."\n";
	$GLOBALS['ins_url']->removeQueryString('voir_actus');
	//partie ressources
	$GLOBALS['ins_url']->addQueryString('voir_ressources', $_GET['voir_fiche']);
	$res .= '<li id="ressources"><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_RESSOURCES.'</a>'."\n".'</li>'."\n";
	$GLOBALS['ins_url']->removeQueryString('voir_ressources');
	//partie competences
	$GLOBALS['ins_url']->addQueryString('voir_competences', $_GET['voir_fiche']);
	$res .= '<li id="competences"><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_COMPETENCES.'</a>'."\n".'</li>'."\n";
	$GLOBALS['ins_url']->removeQueryString('voir_competences');
	$res.= '</ul>'."\n";
	return $res;
}

/** function Annuaire_recherche ()  Moteur de recherche dans l'annuaire des inscrits
*
*
*
*	@return string HTML
*/
function Annuaire_recherche() {
	$res ='<h2>'.INS_RECHERCHE_ANNUAIRE_DES_INSCRITS.'</h2>'."\n";
	$form = new HTML_QuickForm('form_recherche_annuaire', 'post', str_replace('&amp;', '&', $GLOBALS['ins_url']->getURL()));
    $squelette =& $form->defaultRenderer();
    $squelette->setFormTemplate("\n".'<form{attributes}>'."\n".'<table>'."\n".'{content}'."\n".'</table>'."\n".'</form>'."\n");
    $squelette->setElementTemplate( '<tr>'."\n".
                                    '<td style="padding:5px;text-align:right;">{label}'.
                                    '<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required -->'."\n".
                                    '<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
									' : </td>'."\n".
                                    '<td style="padding:5px;text-align:left;">{element}</td>'."\n".
                                    '</tr>'."\n" );
    $squelette->setElementTemplate( '<tr>'."\n".'<td colspan=2 style="padding:5px;">{label}{element}</td>'."\n".'</tr>'."\n", 'bouton_rechercher');
    
    $option_type=array ('0' => INS_PERSONNES_OU_STRUCTURES,
                        '1' => INS_PERSONNES,
                        '2' => INS_STRUCTURES);
    $form->addElement('select', 'nom_type', INS_JE_RECHERCHE, $option_type);
    
    //requete pour recuperer la liste des pays
    $requete = 'SELECT '.INS_CHAMPS_ID_PAYS.', '.INS_CHAMPS_LABEL_PAYS.' FROM '.INS_TABLE_PAYS.' WHERE '.INS_CHAMPS_I18N_PAYS.'="fr-FR"';
	$resultat = $GLOBALS['ins_db']->query($requete) ;
	if (DB::isError($resultat)) {
	    die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
	}
	$option_pays = array('zz' => INS_TOUS_PAYS) ;
	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
	    $option_pays[$ligne[INS_CHAMPS_ID_PAYS]] = $ligne[INS_CHAMPS_LABEL_PAYS] ;
	}
    $form->addElement('select', 'nom_pays', INS_PAYS, $option_pays);
    
    //requete pour recuperer la liste des départements
    $requete = 'SELECT '.INS_CHAMPS_ID_DEPARTEMENT.', '.INS_CHAMPS_NOM_DEPARTEMENT.' FROM '.INS_TABLE_DPT;
	$resultat = $GLOBALS['ins_db']->query($requete) ;
	if (DB::isError($resultat)) {
	    die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
	}
	$option_departements = array('0' => INS_TOUS_DEPARTEMENTS) ;
	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
	    $option_departements[$ligne[INS_CHAMPS_ID_DEPARTEMENT]] = $ligne[INS_CHAMPS_NOM_DEPARTEMENT] ;
	}
    $form->addElement('select', 'nom_departement', INS_DEPARTEMENT_POUR_LA_FRANCE, $option_departements);
	
	$form->addElement('text', 'nom_annuaire', INS_NOM_ANNUAIRE);
	
	$form->addElement('submit', 'bouton_rechercher', INS_RECHERCHER);
	
	//valeurs par defaut
	$defauts=array('nom_pays'=>'fr','nom_departement'=>'0');
	$form->setDefaults($defauts);
	
	//affichage du formulaire
	$res .=$form->toHtml();
	
	//on teste si l'on affiche le resultat de la recherche ou 
	if (isset($_POST['nom_type'])) {
		$requete = 'SELECT '.INS_CHAMPS_ID.', '.INS_CHAMPS_NOM.', '.INS_CHAMPS_PRENOM.', '.INS_CHAMPS_VILLE.', '.INS_CHAMPS_CODE_POSTAL;
		$requete .= ' FROM '.INS_ANNUAIRE.' WHERE ';
		$req_where=0;
		if ($_POST['nom_type']==1) {
			$requete .= INS_CHAMPS_EST_STRUCTURE.'=0 ';
			$req_where=1;
		} elseif ($_POST['nom_type']==2) {
			$requete .= INS_CHAMPS_EST_STRUCTURE.'=1 ';
			$req_where=1;
		}
		if ($_POST['nom_pays']!='0'and$_POST['nom_pays']!='zz') {
			if ($req_where) {
				$requete .= 'AND ';
			} else {
				$req_where=1;
			} 
			$requete .= INS_CHAMPS_PAYS.'="'.$_POST['nom_pays'].'" ';
		}
		if ($_POST['nom_departement']!='0') {
			if ($req_where) {
				$requete .= 'AND ';
			} else {
				$req_where=1;
			} 
			$requete .= INS_CHAMPS_DEPARTEMENT.'="'.$_POST['nom_departement'].'" ';
		}
		if ($_POST['nom_annuaire']!='') {
			if ($req_where) {
				$requete .= 'AND ';
			} else {
				$req_where=1;
			} 
			$requete .= '('.INS_CHAMPS_NOM.' LIKE "%'.$_POST['nom_annuaire'].'%"'.
						' OR '.INS_CHAMPS_PRENOM.' LIKE "%'.$_POST['nom_annuaire'].'%"'.
						' OR '.INS_CHAMPS_SIGLE_STRUCTURE.' LIKE "%'.$_POST['nom_annuaire'].'%"'.
						' OR '.INS_CHAMPS_DESCRIPTION.' LIKE "%'.$_POST['nom_annuaire'].'%") ';
		}
		if (!$req_where) $requete .= '1';
		$requete .=' ORDER BY '.INS_CHAMPS_NOM;
		$resultat = $GLOBALS['ins_db']->query($requete);
		if ($resultat->numRows()>0) {
			$res .='<h2>'.INS_RESULTATS_RECHERCHE.' ('.$resultat->numRows().' '.INS_ENTREES.')</h2>'."\n";
			$res .='<p class="zone_info">'.INS_CLIQUER_ELEMENT_LISTE.'</p>'."\n";
			$i=0;
			while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
				$donnees_membres[$i++]=$ligne;
			}
		    $res .= listes_inscrit($donnees_membres);
		}
		else {
			$res .='<h2>'.INS_RESULTATS_RECHERCHE.'</h2>'."\n";
			$res .= '<p class="zone_alert">'.INS_PAS_DE_RESULTATS.'</p>'."\n";
		}
	} else {		
		$res .='<h2>'.INS_DIX_DERNIERES_INSCRIPTIONS.'</h2>'."\n";
		$requete = 'SELECT '.INS_CHAMPS_ID.', '.INS_CHAMPS_NOM.', '.INS_CHAMPS_PRENOM.', '.INS_CHAMPS_VILLE.', '.INS_CHAMPS_CODE_POSTAL;
		$requete .= ' FROM '.INS_ANNUAIRE.' ORDER BY '.INS_CHAMPS_DATE.' DESC LIMIT 0 , 10';
		$resultat = $GLOBALS['ins_db']->query($requete);
		if ($resultat->numRows()>0) {
			$i=0;
			while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
				$donnees_membres[$i++]=$ligne;
			}
		    $res .= listes_inscrit($donnees_membres, 0);
		}
		else {
			$res .= '<p class="zone_alert">'.INS_PAS_DE_RESULTATS.'</p>'."\n";
		}
	}
    return $res ;
}

/**
 *  Renvoie le code HTML de la liste des inscrits
 *  en fonction de la requete passé en parametre
 *
 * @return  Renvoie le code HTML de la liste des inscrits
 */

function listes_inscrit(& $donnees_membres, $affiche_form_mail=1) {
    $res = '';
    if ($GLOBALS['AUTH']->getAuth()&&$affiche_form_mail) {$res .= '<form action="'.$GLOBALS['ins_url']->getURL().'" method="post" name="formmail">'."\n";}
    $res .= '<ul>'."\n";
    for ($i=0;$i<count($donnees_membres);$i++) {
    	$id = array_shift($donnees_membres[$i]);
    	$GLOBALS['ins_url']->addQueryString('voir_fiche', $id);
    	$res .= '<li><a href="'.$GLOBALS['ins_url']->getURL().'">'."\n";
    	if ($GLOBALS['AUTH']->getAuth()&&$affiche_form_mail) {
    		$res.='<input type="checkbox" name="select[]" value="'.$id.'">'."\n";
    	}
    	$res .= '<strong>'.$donnees_membres[$i][INS_CHAMPS_NOM].
				'&nbsp;'.$donnees_membres[$i][INS_CHAMPS_PRENOM].'</strong>'."\n".
    	        '&nbsp;'.$donnees_membres[$i][INS_CHAMPS_CODE_POSTAL].
    	        '&nbsp;'.$donnees_membres[$i][INS_CHAMPS_VILLE];
    	$res .= '</a></li>'."\n";
    }
    $res .= '</ul>'."\n";
    if ($GLOBALS['AUTH']->getAuth()&&$affiche_form_mail) {
    	$res .= INS_CHECK_UNCHECK ;
    	$res .= '&nbsp;<input type="checkbox" name="selecttotal" onclick="javascript:setCheckboxes(\'formmail\');"><br />';
    	$res .= '<h3>'.INS_ENVOYER_MAIL.'</h3>'."\n";
    	$res .= '<p style="text-align:right;">'.INS_SUJET.'&nbsp;:&nbsp;<input style="border:1px solid #000;width:450px;" type="text" name="titre_mail"><br />'."\n".
           		INS_MESSAGE.'&nbsp;:&nbsp;<textarea style="border:1px solid #000;width:450px;" name="corps" rows="5" cols="60"></textarea></p>'."\n".
           		'<p style="width:100px;margin:4px auto;text-align:center;"><input type="submit" value="'.INS_ENVOYER.'" /></p>'."\n".
				'</form>'."\n";
	} else {
		if ($affiche_form_mail) $res .='<br /><p class="zone_info">'.INS_PAS_IDENTIFIE.'</p>'."\n";
    }
    return $res ;
}



/** envoie_mail_depuis_annuaire()
 *
 *
 * @return  envoie l'email
 */

function envoie_mail_depuis_annuaire() {
    $requete = "select ".INS_CHAMPS_MAIL." from ".INS_ANNUAIRE.
            " where ".INS_CHAMPS_ID."='".$GLOBALS['AUTH']->getAuthData (INS_CHAMPS_ID)."'";
    $resultat = $GLOBALS['ins_db']->query($requete);
    if (DB::isError($resultat)) {
        die ($resultat->getMessage().'<br />'.$resultat->getDebugInfo());
    }
    $ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC);
    $entete = "From: <".$ligne[INS_CHAMPS_MAIL].">\n";
    
    $_POST['corps'] .= ANN_PIED_MESSAGE;
    $_POST['corps'] = stripslashes($_POST['corps']) ;
    $liste = "" ;
    $liste_numero = implode (',', $_POST['select']) ;
    $requete_liste_mail = 'select '.INS_CHAMPS_MAIL.' from '.INS_ANNUAIRE.' where '.INS_CHAMPS_ID.
    						' in ('.$liste_numero.')' ; 
    $resultat_liste_mail = $GLOBALS['ins_db']->query($requete_liste_mail);
    
    while ($ligne_liste_mail = $resultat_liste_mail->fetchRow(DB_FETCHMODE_ASSOC)) {
        mail ($ligne_liste_mail[INS_CHAMPS_MAIL], stripslashes($_POST['titre_mail']), $_POST['corps'] , $entete) ;
        $liste .= $ligne_liste_mail[INS_CHAMPS_MAIL]."\n" ;
    }
    
    $_POST['corps'] .= "\n----------------------------------------------------------------------------";
    $_POST['corps'] .= "\n".ANN_MESSAGE_ENVOYE_A." :\n $liste" ;
    
    mail (INS_MAIL_ADMIN_APRES_INSCRIPTION, stripslashes($_POST['titre_mail']), $_POST['corps'], $entete);
    $_POST['corps'] = '';
    $_POST['titre_mail'] = '';
    return '<div>'.ANN_MAIL_ENVOYER.'</div>' ;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: annuaire.fonct.php,v $
* Revision 1.7  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.4  2006/04/10 14:01:36  florian
* uniformisation de l'appli bottin: plus qu'un fichier de fonctions
*
* Revision 1.3  2006/04/04 12:23:05  florian
* modifs affichage fiches, gÃ©nÃ©ricitÃ© de la carto, modification totale de l'appli annuaire
*
* Revision 1.2  2005/09/29 16:13:54  alexandre_tb
* En cours de production.
*
* Revision 1.1  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.4  2005/09/22 13:30:49  florian
* modifs pour compatibilitÃ© XHTML Strict + corrections de bugs (mais ya encore du boulot!!)
*
* Revision 1.3  2005/03/24 08:24:29  alex
* --
*
* Revision 1.2  2005/01/06 15:18:31  alex
* modification de la fonction de formulaire d'authentification
*
* Revision 1.1.1.1  2005/01/03 17:27:49  alex
* Import initial
*
* Revision 1.1  2005/01/03 17:18:49  alex
* retour vers la liste des participants après un ajout.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>