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
// CVS : $Id: annuaire.fonct.php,v 1.1 2005/03/24 08:46:07 alex Exp $
/**
* Fonctions du module annuaire
*
* Fonctions du module annuaire
*
*@package annuaire
//Auteur original :
*@author		Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@author		Aucun
*@copyright	 Tela-Botanica 2000-2004
*@version	   $Revision: 1.1 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |											ENTETE du PROGRAMME									   |
// +------------------------------------------------------------------------------------------------------+



// +------------------------------------------------------------------------------------------------------+
// |										   LISTE de FONCTIONS										 |
// +------------------------------------------------------------------------------------------------------+

function AUTH_formulaire_login() {
	$res = '';
	
	$url = preg_replace ('/&amp;/', '&', $GLOBALS['ann_url']->getURL()) ;

	$res .= '<p>'.ANN_IDENTIFICATION_PRESENTATION_XHTML.'</p>'."\n" ;
	
	$form = new HTML_QuickForm ('inscription', 'post', $url) ;
	$form->addElement ('text', 'username', ANN_EMAIL) ;
	$form->addElement ('password', 'password', ANN_MOT_DE_PASSE) ;
	$form->addElement('submit', 'valider', ANN_VALIDER);
	$res .= $form->toHTML() ;

	return $res;
}

/** function parcourrirAnnu ()  Affiche l'annuaire à partir d'une lettre
*
*
*
*	@return string HTML
*/
function parcourrirAnnu() {

	$res = '<p id="annuaire_alphabet">';

	// Alphabet pour la rechercher par lettre du nom des inscrits
	for ($i = 65 ; $i < 91 ; $i++) {
		$GLOBALS['ann_url']->addQueryString('lettre', chr($i));
		$url_lettre = $GLOBALS['ann_url']->getURL();
		$GLOBALS['ann_url']->removeQueryString('lettre');
		$res .= '<a href="'.$url_lettre.'">'.chr($i).'</a>&nbsp;'."\n";
	}
	$GLOBALS['ann_url']->addQueryString('lettre', 'tous');
	$url_lettre = $GLOBALS['ann_url']->getURL();
	$GLOBALS['ann_url']->removeQueryString('lettre');
	$res .= '<a href="'.$url_lettre.'">'.'Tous'.'</a>'."\n";
	$res .= '</p>'."\n";

	// Si aucune lettre n'est sélectionnée, attribution de la lettre par défaut
	if (empty($_REQUEST['lettre'])) {
		$_REQUEST['lettre'] = ANN_LETTRE_DEFAUT;
	}
	// Si une lettre est sélectionnée
	if (!empty($_REQUEST['lettre'])) {
		$requete = 	'SELECT '.ANN_ANNUAIRE.'.*, '.ANN_TABLE_PAYS.'.* '.
					'FROM '.ANN_ANNUAIRE.','.ANN_TABLE_PAYS.' '.
					'WHERE '.ANN_CHAMPS_PAYS.' = '.ANN_GC_ID.' ';
		if ($_REQUEST['lettre'] != 'tous') {
			$requete .= ' AND '.ANN_CHAMPS_NOM.' LIKE "'.$_REQUEST['lettre'].'%" ' ;
		}
		$requete .= 'ORDER BY '.ANN_CHAMPS_NOM;
		
		$res .= listes_inscrit ($requete, $GLOBALS['ann_url']->getURL(), '', $GLOBALS['ann_db'], $niveau = 'pays').
				carto_texte_cocher().
				carto_formulaire();
	}
	return $res;
}

/**
 *  Renvoie le code HTML de la liste des inscrits
 *  en fonction de la requete passé en parametre
 *
 * @return  Renvoie le code HTML de la liste des inscrits
 */
function listes_inscrit($requete, $url, $argument, &$db, $niveau = 'pays') {
	$resultat = $GLOBALS['ann_db']->query($requete);
	(DB::isError($resultat)) ? die($resultat->getMessage().'<br />'.$resultat->getDebugInfo()) : '';
	
	if ($resultat->numRows() > 0) {
		$res = '<form action="'.$url.'?mailer=1&amp;lettre='.$_REQUEST['lettre'].'" method="post" name="formmail">'."\n";
		$res .= '<div id="annuaire" class="conteneur_table">	
					<table id="table_inscrit" class="table_cadre">
						<colgroup>
							<col />
							<col />
							<col />
							<col />
							<col />
							<col />
							<col />
						</colgroup>
							<thead class="entete_fixe">
								<tr>
									<th>&nbsp;</th>
									<th>'.ANN_NOM.'</th>
									<th>'.ANN_PRENOM.'</th>
									<th>'.ANN_DATE_INS.'</th>
									<th>'.ANN_CP.'</th>
									<th>'.ANN_VILLE.'</th>
									<th>'.ANN_PAYS.'</th>
								</tr>
							</thead>
							<tbody class="contenu_deroulant">';
		$indic = 0;
		$i = 1;
		while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
			if ($indic == 0) {
				$res .= '<tr class="ligne_impaire">'."\n";
				$indic = 1;
			} else {
				$res .= '<tr class="ligne_paire">'."\n";
				$indic = 0;
			}
			$res.= '<td><input type="checkbox" name="select[]" value="'.$ligne[ANN_CHAMPS_MAIL].'" /></td>'."\n".
							'<td>'.strtoupper($ligne[ANN_CHAMPS_NOM]).'&nbsp;</td>'."\n".
							'<td>'.str_replace(' - ', '-', ucwords(strtolower(str_replace('-', ' - ', $ligne[ANN_CHAMPS_PRENOM])))).'&nbsp;</td>'."\n".
							'<td>'.date('d m Y', strtotime($ligne[ANN_CHAMPS_DATE_INS])).'&nbsp;</td>'."\n".
							'<td>'.$ligne[ANN_CHAMPS_CODE_POSTAL].'&nbsp;</td>'."\n".
							'<td>'.strtoupper($ligne[ANN_CHAMPS_VILLE]).'&nbsp;</td>'."\n".
							'<td>'.str_replace(' - ', '-', ucwords(strtolower(str_replace('-', ' - ', ($ligne[ANN_GC_NOM]))))).'&nbsp;</td>'."\n";
			$res .= '</tr>'."\n";
		}
		$res .= '</tbody></table></div>'."\n";
	} else {
		$res = '<p class="information">'.'Aucun inscrit n\'a de nom commençant par '.$_REQUEST['lettre'].'</p>'."\n";
	}
	return $res;
}


function carto_formulaire() {
	$res = '<h2 class="chapo">'.ANN_ENVOYER_MAIL.'</h2>'."\n";
	$res .= '<p class="attention surveillance">'.ANN_SURVEILLANCE.'</p>'."\n";
	$res .= '<p class="information message_a_tous">'.sprintf(ANN_MESSAGE_A_TOUS, '<a href="'.ANN_URL_ACTUALITE.'">'.ANN_ACTUALITE.'</a>').'</p>'."\n";
	$res .= '<table>'."\n".
			'<tr><td class="texte">'.ANN_SUJET.' :</td>'."\n".
			'<td><input class="forml" type="text" name="titre_mail" size="60" value="'.$_POST['titre_mail'].'"/></td>'."\n".
			'</tr><tr><td class="texte" valign="top">'.ANN_MESSAGE.'&nbsp;:&nbsp;</td>'."\n".
			'<td><textarea class="forml" name="corps" rows="5" cols="60">'.$_POST['corps'].'</textarea></td>'."\n".
			'</tr><tr><td></td><td align="center">';
	$res .= '<input class="spip_bouton" type="submit" value="'.ANN_ENVOYER.'" />'."\n";
	$res .= '</td>'."\n";
	$res .= '</tr>'."\n";
	$res .= '</table>'."\n";
	$res .= '</form>'."\n";
	return $res;
}


/** function carto_texte_cocher ()
*
*
*	@return string  HTML
*/
function carto_texte_cocher() {
	$res .= '<div class="texte">'.ANN_CHECK_UNCHECK."\n";
	$res .= '&nbsp;<input type="checkbox" name="selecttotal" onclick="javascript:setCheckboxes(\'formmail\');"/>'."\n";
	$res .= '</div>';
	return $res;
}


/** envoie_mail()
 *
 *
 * @return  envoie l'email
 */
function envoie_mail($selection, $titre_mail, $corps) {
	$requete = 	'SELECT '.ANN_CHAMPS_MAIL.' '.
				'FROM '.ANN_ANNUAIRE.' '.
				'WHERE '.ANN_CHAMPS_ID.' = "'.$GLOBALS['AUTH']->getAuthData(ANN_CHAMPS_ID).'" ';
	$resultat = $GLOBALS['ann_db']->query($requete);
	if (DB::isError($resultat)) {
		die($resultat->getMessage().'<br />'.$resultat->getDebugInfo());
	}
	$ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC);
	$entete = 'From: <'.$ligne[ANN_CHAMPS_MAIL].">\n";

	$corps .= "\n".ANN_PIED_MESSAGE;

	$liste = '';
	foreach ($selection as $key => $value) {
		mail($value, $titre_mail, $corps, $entete);
		$liste .= $value."\n";
	}
	
	$corps .= "\n----------------------------------------------------------------------------";
	$corps .= "\n".ANN_MESSAGE_APPLI."\n" ;
	$corps .= "\n".ANN_MESSAGE_ENVOYE_A." :\n $liste" ;
	
	mail(ANN_MAIL_ADMIN, $titre_mail, $corps, $entete);

	return '<div class="information">'.ANN_MAIL_ENVOYER.'</div>' ;
}
/** translittererVersIso88591()
 *
 * Convertit les caractères CP1252 (= ANSI) non présent dans l'ISO-8859-1 par un équivalant ressemblant.
 *
 * @return  envoie l'email
 */
function translittererCp1252VersIso88591($str, $translit = true) {
	$cp1252_entite_map = array(
	   '\x80' => '&#8364;', /* EURO SIGN */
	   '\x82' => '&#8218;', /* SINGLE LOW-9 QUOTATION MARK */
	   '\x83' => '&#402;',     /* LATIN SMALL LETTER F WITH HOOK */
	   '\x84' => '&#8222;', /* DOUBLE LOW-9 QUOTATION MARK */
	   '\x85' => '&#8230;', /* HORIZONTAL ELLIPSIS */
	   '\x86' => '&#8224;', /* DAGGER */
	   '\x87' => '&#8225;', /* DOUBLE DAGGER */
	   '\x88' => '&#710;',     /* MODIFIER LETTER CIRCUMFLEX ACCENT */
	   '\x89' => '&#8240;', /* PER MILLE SIGN */
	   '\x8a' => '&#352;',     /* LATIN CAPITAL LETTER S WITH CARON */
	   '\x8b' => '&#8249;', /* SINGLE LEFT-POINTING ANGLE QUOTATION */
	   '\x8c' => '&#338;',     /* LATIN CAPITAL LIGATURE OE */
	   '\x8e' => '&#381;',     /* LATIN CAPITAL LETTER Z WITH CARON */
	   '\x91' => '&#8216;', /* LEFT SINGLE QUOTATION MARK */
	   '\x92' => '&#8217;', /* RIGHT SINGLE QUOTATION MARK */
	   '\x93' => '&#8220;', /* LEFT DOUBLE QUOTATION MARK */
	   '\x94' => '&#8221;', /* RIGHT DOUBLE QUOTATION MARK */
	   '\x95' => '&#8226;', /* BULLET */
	   '\x96' => '&#8211;', /* EN DASH */
	   '\x97' => '&#8212;', /* EM DASH */
	   '\x98' => '&#732;',     /* SMALL TILDE */
	   '\x99' => '&#8482;', /* TRADE MARK SIGN */
	   '\x9a' => '&#353;',     /* LATIN SMALL LETTER S WITH CARON */
	   '\x9b' => '&#8250;', /* SINGLE RIGHT-POINTING ANGLE QUOTATION*/
	   '\x9c' => '&#339;',     /* LATIN SMALL LIGATURE OE */
	   '\x9e' => '&#382;',     /* LATIN SMALL LETTER Z WITH CARON */
	   '\x9f' => '&#376;'      /* LATIN CAPITAL LETTER Y WITH DIAERESIS*/
	);
	$translit_map = array(
	   '&#8364;' => 	'Euro', /* EURO SIGN */
	   '&#8218;' => ',', /* SINGLE LOW-9 QUOTATION MARK */
	   '&#402;' => 'f',  /* LATIN SMALL LETTER F WITH HOOK */
	   '&#8222;' => ',,', /* DOUBLE LOW-9 QUOTATION MARK */
	   '&#8230;' => '...', /* HORIZONTAL ELLIPSIS */
	   '&#8224;' => '+', /* DAGGER */
	   '&#8225;' => '++', /* DOUBLE DAGGER */
	   '&#710;' => '^',  /* MODIFIER LETTER CIRCUMFLEX ACCENT */
	   '&#8240;' => '0/00', /* PER MILLE SIGN */
	   '&#352;' => 'S',  /* LATIN CAPITAL LETTER S WITH CARON */
	   '&#8249;' => '<', /* SINGLE LEFT-POINTING ANGLE QUOTATION */
	   '&#338;' => 'OE',  /* LATIN CAPITAL LIGATURE OE */
	   '&#381;' => 'Z',  /* LATIN CAPITAL LETTER Z WITH CARON */
	   '&#8216;' => "'", /* LEFT SINGLE QUOTATION MARK */
	   '&#8217;' => "'", /* RIGHT SINGLE QUOTATION MARK */
	   '&#8220;' => '"', /* LEFT DOUBLE QUOTATION MARK */
	   '&#8221;' => '"', /* RIGHT DOUBLE QUOTATION MARK */
	   '&#8226;' => '*', /* BULLET */
	   '&#8211;' => '-', /* EN DASH */
	   '&#8212;' => '--', /* EM DASH */
	   '&#732;' => '~',  /* SMALL TILDE */
	   '&#8482;' => '(TM)', /* TRADE MARK SIGN */
	   '&#353;' => 's',  /* LATIN SMALL LETTER S WITH CARON */
	   '&#8250;' => '>', /* SINGLE RIGHT-POINTING ANGLE QUOTATION*/
	   '&#339;' => 'oe',  /* LATIN SMALL LIGATURE OE */
	   '&#382;' => 'z',  /* LATIN SMALL LETTER Z WITH CARON */
	   '&#376;' => 'Y'   /* LATIN CAPITAL LETTER Y WITH DIAERESIS*/
	);
	$str = strtr($str, $cp1252_entite_map);
	if ($translit) {
		$str = strtr($str, $translit_map);
	}
	return $str;
}
?>