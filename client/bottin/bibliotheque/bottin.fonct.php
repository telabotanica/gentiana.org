<?php

//vim: set expandtab tabstop=4 shiftwidth=4: 
// +-----------------------------------------------------------------------------------------------+
// | PHP version 4.0                                                                               |
// +-----------------------------------------------------------------------------------------------+
// | Copyright (c) 1997, 1998, 1999, 2000, 2001 The PHP Group                                      |
// +-----------------------------------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,                                | 
// | that is bundled with this package in the file LICENSE, and is                                 |
// | available at through the world-wide-web at                                                    |
// | http://www.php.net/license/2_02.txt.                                                          |
// | If you did not receive a copy of the PHP license and are unable to                            |
// | obtain it through the world-wide-web, please send a note to                                   |
// | license@php.net so we can mail you a copy immediately.                                        |
// +-----------------------------------------------------------------------------------------------+
/**
*
*Fichier des fonctions du bottin
*
*@package bottin
//Auteur original :
*@author                Florian SCHMITT <florian@ecole-et-nature.org>
//Autres auteurs :
*@copyright         Outils-reseaux 2006-2040
*@version           05 avril 2006
// +-----------------------------------------------------------------------------------------------+
//
// $Id$
// FICHIER : $RCSfile$
// AUTEUR    : $Author$
// VERSION : $Revision$
// DATE        : $Date$
*/


include_once 'inscription.fonct.wiki.php' ;
if (INS_UTILISE_SPIP) include_once 'inscription.fonct.spip.php' ;
include_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm.php';

/** function inscription_onglets()  Affiche les onglets de présentation de la structure
*
*
*
*	@return string HTML
*/
function inscription_onglets() {
	//on trouve l'id de la fiche en fonction de l'onglet choisi auparavant
	if (isset($_GET['voir_fiche'])) {
		$id_fiche=$_GET['voir_fiche'];
	} elseif (isset($_GET['voir_abonnement'])) {
		$id_fiche=$_GET['voir_abonnement'];
	} elseif (isset($_GET['voir_actus'])) {
		$id_fiche=$_GET['voir_actus'];
	} elseif (isset($_GET['voir_ressources'])) {
		$id_fiche=$_GET['voir_ressources'];
	} elseif (isset($_GET['voir_competences'])) {
		$id_fiche=$_GET['voir_competences'];
	} else {
		$id_fiche = '';
	}
	
	//preparation de l'affichage des onglets
	$res='<ul id="onglets_inscription">'."\n";
	//partie présentation
	$GLOBALS['ins_url']->addQueryString('voir_fiche', $id_fiche);
	$res .= '<li id="fiche"';
	if (isset($_GET['voir_fiche'])) $res .= ' class="onglet_actif" '; 
	$res .= '><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_PRESENTATION.'</a>'."\n".'</li>'."\n";
	$GLOBALS['ins_url']->removeQueryString('voir_fiche');
	if ($id_fiche==$GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID)) {
		//partie abonnement
		$GLOBALS['ins_url']->addQueryString('voir_abonnement', $id_fiche);
		$res .= '<li id="abonnements"';
		if (isset($_GET['voir_abonnement'])) $res .= ' class="onglet_actif" ';
		$res .= '><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_ABONNEMENTS.'</a></li>'."\n" ;
		$GLOBALS['ins_url']->removeQueryString('voir_abonnement');
	}
	//partie actualites
	$GLOBALS['ins_url']->addQueryString('voir_actus', $id_fiche);
	$res .= '<li id="actus"><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_ACTUALITES.'</a>'."\n".'</li>'."\n";
	$GLOBALS['ins_url']->removeQueryString('voir_actus');
	//partie ressources
	$GLOBALS['ins_url']->addQueryString('voir_ressources', $id_fiche);
	$res .= '<li id="ressources"><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_RESSOURCES.'</a>'."\n".'</li>'."\n";
	$GLOBALS['ins_url']->removeQueryString('voir_ressources');
	//partie competences
	//$GLOBALS['ins_url']->addQueryString('voir_competences', $id_fiche);
	//$res .= '<li id="competences"><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_COMPETENCES.'</a>'."\n".'</li>'."\n";
	//$GLOBALS['ins_url']->removeQueryString('voir_competences');
	$res.= '</ul>'."\n";
	return $res;
}

/** function affiche_onglet_info()  sélectionne le type d'information à montrer pour une fiche
*
*
*
*	@return string HTML
*/
function affiche_onglet_info() {
	include_once INS_CHEMIN_APPLI.'bibliotheque/inscription.fonct.php';
    include_once INS_CHEMIN_APPLI.'bibliotheque/inscription.class.php';
    if ( isset($_GET['voir_fiche']) ) {
    	$res=info($_GET['voir_fiche'], 'fiche');
    } elseif (isset($_GET['voir_abonnement'])) {
    	$res=info($_GET['voir_abonnement'], 'abonnement');
    } elseif (isset($_GET['voir_actus'])) {
    	$res=info($_GET['voir_actus'], 'actus');
    } elseif (isset($_GET['voir_ressources'])) {
    	$res=info($_GET['voir_ressources'], 'ressources');
    } elseif (isset($_GET['voir_competences'])) {
    	$res=info($_GET['voir_competences'], 'competences');
    }
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
    $res .= '<ul style="clear:both;">'."\n";
    if ($GLOBALS['AUTH']->getAuth()&&$affiche_form_mail) {
    	
    	$res .= '<form action="'.$GLOBALS['ins_url']->getURL().'" method="post" name="formmail">'."\n";
    	}
    $res .= '<ul>'."\n";
    for ($i=0;$i<count($donnees_membres);$i++) {
    	$id = array_shift($donnees_membres[$i]);
    	$GLOBALS['ins_url']->addQueryString('voir_fiche', $id);
    	$res .= '<li>'."\n";
    	if ($GLOBALS['AUTH']->getAuth()&&$affiche_form_mail) {
    		$res.='<input type="checkbox" name="select[]" value="'.$id.'" />'."\n";
    	}
    	$res .= '<a href="'.$GLOBALS['ins_url']->getURL().'">'."\n";    	
    	$res .= '<strong>'.$donnees_membres[$i][INS_CHAMPS_NOM].
				'&nbsp;'.$donnees_membres[$i][INS_CHAMPS_PRENOM].'</strong>'."\n".
    	        '&nbsp;'.$donnees_membres[$i][INS_CHAMPS_CODE_POSTAL].
    	        '&nbsp;'.$donnees_membres[$i][INS_CHAMPS_VILLE];
    	$res .= '</a>'."\n".'</li>'."\n";
    }
    $res .= '</ul>'."\n";
    if ($GLOBALS['AUTH']->getAuth()&&$affiche_form_mail) {
    	$res .= INS_CHECK_UNCHECK ;
    	$res .= '&nbsp;<input type="checkbox" name="selecttotal" onclick="javascript:setCheckboxes(\'formmail\');"><br />';
    	$res .= '<h3>'.INS_ENVOYER_MAIL.'</h3>'."\n";
    	$res .= '<p style="text-align:right;">'.INS_SUJET.'&nbsp;:&nbsp;<input style="border:1px solid #000;width:450px;" type="text" name="titre_mail"><br />'."\n".
           		INS_MESSAGE.'&nbsp;:&nbsp;<textarea style="border:1px solid #000;width:450px;" name="corps" rows="5" cols="60"></textarea></p>'."\n".
           		'<p style="width:100px;margin:4px auto;text-align:center;"><input name="bouton_envoi_mail" type="submit" value="'.INS_ENVOYER.'" /></p>'."\n".
           		'<p style="width:100px;margin:4px auto;text-align:center;"><input type="submit" value="'.INS_ENVOYER.'" /></p>'."\n".
           		'<input type="hidden" name="fin" value="true" /><input type="hidden" name="mailer" value="1" />'.
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
    
    $_POST['corps'] .= INS_PIED_MESSAGE;
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
    $_POST['corps'] .= "\n".INS_MESSAGE_ENVOYE_A." :\n $liste" ;
    
    mail (INS_MAIL_ADMIN_APRES_INSCRIPTION, stripslashes($_POST['titre_mail']), $_POST['corps'], $entete);
    $_POST['corps'] = '';
    $_POST['titre_mail'] = '';
    return '<div>'.INS_MAIL_ENVOYE.'</div>' ;
}

/** function carto_liste_fiches()
*
*
*	@return string  HTML
*/
function carto_liste_fiches(&$monde, $nom_table1, $nom_table2, $nom_champs_pays, $nom_champs_cp, $requete_sql) {

    global $mailer;
    global $select;//utilisé dans liste_inscrit.php
    
	$javascript = "
	function confirmer () {
        if (window.confirm ('Cliquez sur OK pour confirmer.')) {
            window.formmail.submit();
        }
    }

	function setCheckboxes(the_form) 
	{
    	var do_check=document.forms[the_form].elements['selecttotal'].checked;
    	var elts            = document.forms[the_form].elements['select[]'];
    	var elts_cnt = (typeof(elts.length) != 'undefined')
                        ? elts.length
                        : 0;
    	if (elts_cnt) {
        	for (var i = 0; i < elts_cnt; i++) {
            	elts[i].checked = do_check;
        	} // Fin for
    	} 
    	else {
       	 elts.checked = do_check;
    	} // Fin if... else
    	return true;
	} // Fin de la fonction 'setCheckboxes()'

	";
	GEN_stockerCodeScript($javascript);

	$res = '';
	$tabmonde = explode ('*',$monde->historique);
	
	// Premier cas, on vient de cliquer sur un pays qui n'est pas 
	// la France, on affiche les adhérents de ce pays
	if (count($tabmonde) == 3) {
    	$argument = $tabmonde[2];
    	$query = 'SELECT * FROM carto_PAYS WHERE CP_ID_pays="'.$argument.'"';
    	$result = $GLOBALS['ins_db']->query($query);
    	if (DB::isError($result)) {
    		die ($result->getMessage().'<br />'.$result->getDebugInfo()) ;
    	}
    	$row = $result->fetchRow(DB_FETCHMODE_OBJECT) ;    
    	$pays = $row->CP_Intitule_pays;
    	$monde->nom = $monde->nom.'*'.$pays;    
    	$tabonglet = explode ('*', $monde->historique);
    	$tabnom = explode ('*', $monde->nom);
    	$res .='<br /><strong>'.INS_RETOUR_A_LA_CARTE."\n";
    	foreach ($tabonglet as $key => $value) {
        	if ($key == 0) {
            	$chemin = $value;
            	$value = 'monde';
            	$res .= "<a class=\"chemin_carto\" href=\"".$monde->url."&amp;historique_cartes=$chemin\">&nbsp;&gt;&nbsp;".$tabnom[$key]."</a>";
        	} else if ($key == (count($tabonglet)-1)) {
            	$res .= "<a class=\"chemin_carto\">&nbsp;&gt;&nbsp;$pays</a>";
        	} else {
            	$chemin .= '*'.$value;
            	$res .= "<a class=\"chemin_carto\" href=\"".$monde->url."&amp;historique_cartes=$chemin\">&nbsp;&gt;&nbsp;".$tabnom[$key]."</a>";
        	}
    	}
        $res .= '</strong>'."\n";
    	$capitale = $row->CP_Intitule_capitale;
	    $query2 = ' SELECT count('.$nom_champs_cp.') as nbr'.
    	          ' FROM '.$nom_table1;
    	if ($nom_table2!=0) $query2 .=  ', '.$nom_table2;
    	$query2 .= ' WHERE '.$nom_champs_pays.'="'.$argument.'"';
    	if ($requete_sql!='') $query2 .=  ' AND ('.$requete_sql.')';
    	
    	$result2 = $GLOBALS['ins_db']->query($query2);
    	if (DB::isError($result2)) {
    		die ($result2->getMessage().'<br />'.$result2->getDebugInfo()) ;
    	}
	    $row2 = $result2->fetchRow(DB_FETCHMODE_OBJECT) ;
	    $res .= '<br /><br /><div class="info_pays">'.$pays.' (capitale: '.$capitale.') : ' ;
	    if ($row2->nbr == 0) {
		    $res .= INS_AUCUN_INSCRIT.' '.INS_LABEL_PROJET ;
		    
	    } 
	    else if ($row2->nbr == 1) {
		    $res .= $row2->nbr.' '.INS_INSCRIT.' '.INS_LABEL_PROJET ;
	    }
	    else {
		    $res .= $row2->nbr.' '.INS_INSCRIT.'s '.INS_LABEL_PROJET ;
	    }
	    $res .= "</div>\n";
	    if ($row2->nbr>0) {
		    if ((INS_NECESSITE_LOGIN)and(!$GLOBALS['AUTH']->getAuth())) {
			    $res .= '<br /><p class="zone_alert">'.INS_VOUS_DEVEZ_ETRE_INSCRIT.'</p>'."\n" ;
		    }
		    else {
			    $requete = 'SELECT '.INS_CHAMPS_ID.', '.INS_CHAMPS_NOM.', '.INS_CHAMPS_PRENOM.', '.INS_CHAMPS_VILLE.', '.INS_CHAMPS_CODE_POSTAL.' FROM '.$nom_table1;
			    if ($nom_table2!=0) $requete .=  ', '.$nom_table2;						 
			    $requete .= ' WHERE '.$nom_champs_pays.'="'.$argument.'"';
			    if ($requete_sql!='') $requete .=  ' AND ('.$requete_sql.')';
			    $requete .= ' ORDER BY '.INS_CHAMPS_NOM.', '.INS_CHAMPS_PRENOM;
				$resultat = $GLOBALS['ins_db']->query($requete);
				$i=0;
				while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
					$donnees_membres[$i++]=$ligne;
				}
				$res .= listes_inscrit($donnees_membres, 1);
				if ($mailer==1) {
				    if (!is_array($select)) {
					    $res .= "<div>".INS_NO_DESTINATAIRE."</div>";
				    }
				    else {
					    $res .= '<div class="zone_info">'.INS_MESSAGE_ENVOYE.'</div>'."\n" ;
					    carto_envoie_mail() ;
				    }
				}
				else {
				    $res .= carto_texte_cocher() ;
				}
				$res .= carto_formulaire() ;			   
		    }
	    }
		
		// 2 ème cas, on vient de cliquer sur un département français
		} else if (count($tabmonde) == 4) {
	    $argument = $tabmonde[3];
	    $query = 'SELECT * FROM '.INS_TABLE_DPT.' WHERE '.INS_CHAMPS_ID_DEPARTEMENT.'='.$argument;
	    $result = $GLOBALS['ins_db']->query($query);
	    if (DB::isError($result)) {
	        die ($result->getMessage() .'<br />'.$result->getDebugInfo());
	    }
	    $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	    $nom = $row[INS_CHAMPS_NOM_DEPARTEMENT];
	    
	    $query2 = ' SELECT count('.$nom_champs_cp.') as nbr'.
	              ' FROM '.$nom_table1;
	    if ($nom_table2!=0) $query2 .=  ', '.$nom_table2;
	    $query2 .= ' WHERE '.$nom_champs_cp.' LIKE "'.$argument.'%"'.
	              ' AND '.$nom_champs_pays.'="FR"';
	    if ($requete_sql!='') $query2 .=  ' AND ('.$requete_sql.')';
	    $result2 = $GLOBALS['ins_db']->query($query2);
	    if (DB::isError($result2)) {
	    	die ($result2->getMessage().'<br />'.$result2->getDebugInfo()) ;
	    }
	    
	    $row2 = $result2->fetchRow(DB_FETCHMODE_OBJECT);
	    $res .= '<br /><p class="zone_info">'."\n" ;
	    if ($row2->nbr == 0) {
	        $res .= INS_AUCUN_INSCRIT." ".INS_LABEL_PROJET ;
	    }
	    else if ($row2->nbr == 1) {
	        $res .= $row2->nbr." ".INS_INSCRIT." ".INS_LABEL_PROJET ;
	    } 
	    else {
	        $res .= $row2->nbr." ".INS_INSCRIT."s ".INS_LABEL_PROJET ;
	    }
	    $res .= '</p>'."\n";
	    if ($row2->nbr>0) {
		    if ((INS_NECESSITE_LOGIN)and(!$GLOBALS['AUTH']->getAuth())) {
		    	$res .= '<br /><p class="zone_alert">'.INS_VOUS_DEVEZ_ETRE_INSCRIT.'</p>'."\n" ;
		    } else {		    
			    $requete = 'SELECT '.INS_CHAMPS_ID.', '.INS_CHAMPS_NOM.', '.INS_CHAMPS_PRENOM.', '.INS_CHAMPS_VILLE.', '.INS_CHAMPS_CODE_POSTAL.' FROM '.$nom_table1;
			    if ($nom_table2!=0) $requete .=  ', '.$nom_table2;			    
			    
			    if (strlen($argument)==1) {
			    	$argument='0'.$argument;
			    }
			    
			    $requete .= ' WHERE '.$nom_champs_cp.' LIKE "'.$argument.'%"'.
			    ' AND '.$nom_champs_pays.'="FR"';
			    if ($requete_sql!='') $requete .=  ' AND ('.$requete_sql.')';
			    $requete .= ' ORDER BY '.INS_CHAMPS_NOM.', '.INS_CHAMPS_PRENOM;
				$resultat = $GLOBALS['ins_db']->query($requete);
				$i=0;
				while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
					$donnees_membres[$i++]=$ligne;
				}
				$res .= listes_inscrit($donnees_membres, 1);
		    	
			    if ($mailer==1) {
				    if (!is_array($select)) {
					    $res.= INS_NO_DESTINATAIRE;
				    } else {
					    $res .= '<p class="zone_info">'.INS_MESSAGE_ENVOYE."</p>\n" ;
					    carto_envoie_mail() ;
				    }
			    }
		    }
	    }
	}
	return $res;
}


/** function carto_texte_cocher ()
*
*
*	@return string  HTML
*/
function carto_texte_cocher() {
    $res = '<br />'.INS_CHECK_UNCHECK ;
    $res .= '&nbsp;<input type="checkbox" name="selecttotal" onclick="javascript:setCheckboxes(\'formmail\');" />'."\n";
    return $res ;
}


/** function carto_formulaire ()
*
*
*
*	@return string  HTML
*/
function carto_formulaire($titre_mail="", $corps="") {
	$res = '<br /><h2>'.INS_ENVOYER_MAIL.'</h2><br />'."\n".
		   INS_SUJET.' :<br /><input class="forml" type="text" name="titre_mail" size="60" value="'.$titre_mail.'" /><br /><br />'."\n".
		   INS_MESSAGE.' :<br /><textarea class="forml" name="corps" rows="5" cols="60">'.$corps.'</textarea><br /><br />'."\n".
		   '<input class="bouton" type="submit" onclick="javascript:confirmer();" value="'.INS_ENVOYER.'" />'."\n".
		   '</form>'."\n";
	return $res ;
}

/** envoie_mail()
 *
 *
 * @return  envoie l'email
 */
function carto_envoie_mail() {
    $requete = 'SELECT '.INS_CHAMPS_MAIL.' FROM '.INS_ANNUAIRE.' WHERE '.INS_CHAMPS_ID.'='.$GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID);
    $resultat = $GLOBALS['ins_db']->query($requete);
    if (DB::isError($resultat)) {
        die ($resultat->getMessage().'<br />'.$resultat->getDebugInfo());
    }
    $ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC);

    include_once PAP_CHEMIN_API_PEAR.'Mail.php' ;
    
    $entetes['From']    = $ligne[INS_CHAMPS_MAIL];

	$objet_mail =& Mail::factory('smtp');
	$entetes['Subject'] = $GLOBALS['titre_mail'];
	$entetes['Date'] = date("m-d-Y H:i") ;
    $GLOBALS['corps'] .= INS_TEXTE_FIN_MAIL;
    
    $liste = "" ;
    $destinataire = array() ;
    foreach ($GLOBALS['select'] as $key => $value) {
    	$requete = 'select '.INS_CHAMPS_MAIL.' from '.INS_ANNUAIRE.' where '.INS_CHAMPS_ID.'="'.$value.'"';
    	$mail = $GLOBALS['ins_db']->getOne($requete) ;
        array_push ($destinataire, $mail) ;
        $liste .= $mail."\n" ;
    }
    $objet_mail->send($destinataire, $entetes, $GLOBALS['corps']);
    
    $GLOBALS['corps'] .= "
----------------------------------------------------------------------------".INS_MESSAGE_ENVOYE_A."
$liste" ;
    
    mail(INS_MAIL_ADMIN, stripslashes(INS_SURVEILLANCE_ENVOI_MAIL.$GLOBALS['titre_mail']), $GLOBALS['corps'], $entetes);
    $GLOBALS['corps'] = '';
    $GLOBALS['titre_mail'] = '';
}

                                    
//-----Fonctions de l'inscription-----------------------------------------------------+


/**
 *	Inscription_demande
 *
 *	Cette fonction insere dans la table inscription_demande
 *	les donnees saisies dans le formulaire
 *	et envoi un mail de confirmation a l utilisateur
 *	Ce mail contient un lien pour valider l inscription
 *
 *	Le mail peut etre modifier via le modele de inscription_template
 *	ayant pour it_id_template = 2
 *
 * @param   array   les valeurs renvoyes par le formulaire
 * @return	void
 */
function inscription_demande($valeurs) {
    // On stocke les informations dans un variable de session
    // On coupe l'identifiant de session pour ne prendre que les 8 premiers caractères
    // afin d'éviter d'obtenir une url trop longue
    $chaine = substr (session_id(), 0, 8) ;
    $requete_verif = 'select * from inscription_demande where id_identifiant_session="'.$chaine.'"' ;
    $resultat_verif = $GLOBALS['ins_db']->query ($requete_verif) ;
    if ($resultat_verif->numRows() != 0) {
        $requete_suppression = 'delete from inscription_demande where id_identifiant_session="'.$chaine.'"' ;
        $GLOBALS['ins_db']->query ($requete_suppression) ;
    }
    $requete = 'insert into inscription_demande set id_identifiant_session="'.$chaine.'", id_donnees="'.
                addslashes(serialize($valeurs)).'", id_date=NOW()' ;
    $resultat = $GLOBALS['ins_db']->query ($requete) ;
    if (DB::isError ($resultat)) {
        echo ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
    }
    // On envoie un email de confirmation pour l'utilisateur
    $GLOBALS['ins_url']->addQueryString ('id', $chaine) ;
    
    
    if ($GLOBALS['ins_config']['ic_utilise_reecriture_url']) {
        $url = 'http://'.$GLOBALS['ins_url']->host.'/'.$GLOBALS['ins_config']['ic_url_prefixe'].$chaine ;
    } else {
        $url = str_replace ('&amp;', '&', $GLOBALS['ins_url']->getURL()) ;
    }
    
    require_once PAP_CHEMIN_RACINE.'api/pear/HTML/Template/IT.php';
    $tpl = new HTML_Template_IT() ;
    // Le gabarit du mail est dans un template
    
    if (!$tpl -> setTemplate(inscription::getTemplate(INS_TEMPLATE_MAIL_CONFIRMATION_CORPS, $GLOBALS['ins_config']['ic_id_inscription']))) {
    	echo 'erreur' ;	
    }
	$tpl->setVariable('URL_INSCRIPTION', $url) ;

    mail ($_POST['a_mail'], inscription::getTemplate(INS_TEMPLATE_MAIL_CONFIRMATION_SUJET, $GLOBALS['ins_config']['ic_id_inscription']), 
    			$tpl->get(),
    			'From: '.$GLOBALS['ins_config']['ic_from_mail_confirmation']) ;
}

/**
 *
 * @param   array   les valeurs renvoyés par le formulaire
 * @return
 */

function inscription_validee($valeurs) {
	inscription_insertion($valeurs) ;
	$GLOBALS['AUTH']->username = $valeurs['email'] ;
	$GLOBALS['AUTH']->password = $valeurs['mot_de_passe'] ;
	// On loggue l'utilisateur
	$GLOBALS['AUTH']->login() ;
	// inscription à la lettre d'information
	if ($GLOBALS['ins_config']['ic_mail_inscription_news'] != '' && isset ($valeurs['lettre'])) {
		inscription_lettre($GLOBALS['ins_config']['ic_mail_inscription_news']) ;
	}
}

/**
*   Renvoie l'accueil de l'inscription
*
*   @return string	HTML
*/
function inscription_AUTH_formulaire_login() {   
    require_once PAP_CHEMIN_RACINE.'api/pear/HTML/Template/IT.php';
    $tpl = new HTML_Template_IT() ;
    // Le formulaire pour se logguer est dans un template

    if (!$tpl -> setTemplate(inscription::getTemplate(INS_TEMPLATE_PAGE_ACCUEIL, $GLOBALS['ins_config']['ic_id_inscription']))) {
    	echo 'erreur' ;	
    }
	$tpl->setVariable('URL_INSCRIPTION', $GLOBALS['ins_url']->getURL());
    return $tpl->get() ;
    
}


/** formulaire_envoi_passe() - Renvoie le code HTML d'un formulaire d'envoi de mot de passe par mail 
*
* @return   string  HTML
*/
function inscription_formulaire_envoi_passe() {
    $res = '<h2>'.INS_SI_PASSE_PERDU.'</h2>'."\n" ;
    $GLOBALS['ins_url']->addQueryString('action', 'sendpasswd');
    $res .= '<form action="'.$GLOBALS['ins_url']->getURL().'" method="post">'."\n" ;
    $res .= '<p class="label100">'.INS_EMAIL.' : </p>'."\n" ;
    $res .= '<input type="text" value="';
    if (isset($_POST['username'])) $res .= $_POST['username'];
    $res .= '" name="mail" size="32" />'."\n" ;
    $res .= '<input type="submit" value="'.INS_ENVOIE_PASSE.'" />' ;
    $res .= '</form><br />'."\n" ;
    $GLOBALS['ins_url']->removeQueryString('action');
    $res .= inscription_AUTH_formulaire_login() ;
    return $res;
}


function inscription_insertion($valeur) {
    // ===========  Insertion dans l'annuaire ===================
	// Génération du nom wikini à partir du nom et du prénom
    if ($GLOBALS['ins_config']['ic_utilise_nom_wiki'] && $GLOBALS['ins_config']['ic_genere_nom_wiki']) {
        $valeur['nom_wiki'] = inscription_genere_nom_wiki ($valeur['a_nom'], isset ($valeur['a_prenom']) ?  $valeur['a_prenom'] : '') ;
    } else {
    	if (!$GLOBALS['ins_config']['ic_genere_nom_wiki'])	{
    		if (isset($valeur['nomwiki'])) $valeur['nom_wiki'] = $valeur['nomwiki'];	
    	}
    }    
    $id_utilisateur = inscription_nextId(INS_ANNUAIRE, INS_CHAMPS_ID, $GLOBALS['ins_db']) ;    
    $requete = 'INSERT INTO '.INS_ANNUAIRE.' SET '.
                INS_CHAMPS_ID.'="'.$id_utilisateur.'",'.
                inscription_requete_annuaire($valeur) ;

    $resultat = $GLOBALS['ins_db']->query($requete) ;
    if (DB::isError($resultat)) {
        return ($resultat->getMessage().$resultat->getDebugInfo()) ;
    }

    // ================ Insertion dans SPIP =========================================
    if (INS_UTILISE_SPIP) {
        inscription_spip($id_utilisateur, $valeur) ;
    }
	if ($GLOBALS['ins_config']['ic_utilise_nom_wiki']) inscription_interwikini_users('', $valeur) ;
	return $id_utilisateur ;
}


/**
*   Réalise une mise à jour dans la base de donnée
*
*   @param  array   un tableau de valeur avec en clé les noms des champs du formulaire
*   @return void
*/
function inscription_mise_a_jour($valeur, $id = '') {
    // ====================Mise à jour dans l'annuaire gen_annuaire ====================
	if ($id == '') {
		$id = $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID);
	}
    $requete = 'update '.INS_ANNUAIRE.' set '.
                inscription_requete_annuaire ($valeur).
                'where '.INS_CHAMPS_ID.'="'.$id.'"';
    $resultat = $GLOBALS['ins_db']->query ($requete) ;
    if (DB::isError($resultat)) {
        die ($resultat->getMessage().$resultat->getDebugInfo()) ;
    }
    unset ($resultat) ;

    // ========================= Mise à jour dans SPIP ================================
    if (INS_UTILISE_SPIP) {
        mod_inscription_spip($GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID), $valeur) ;
    }
}

/** requete_annuaire () - Renvoie une chaine contenant les champs de l'annuaire avec leur valeur suite à le fonction process de QuickForm
*
* @return   string  une requete du type champs="valeur",...
*/

function inscription_requete_annuaire($valeur) {
   
    // On recupere le template de l inscription
    include_once GEN_CHEMIN_API.'/formulaire/formulaire.fonct.inc.php';
    $tableau= formulaire_valeurs_template_champs($GLOBALS['ins_config']['ic_inscription_template']);
    $requete = '';
    for ($i=0; $i<count($tableau); $i++) {
		//cas des checkbox et des listes
		if ($tableau[$i]['type']=='checkbox' || $tableau[$i]['type']=='liste') {
			if (is_int($tableau[$i]['nom_bdd'])) {
				
			} else {
				if(isset($valeur[$tableau[$i]['nom_bdd']]))
					$requete .= $tableau[$i]['nom_bdd'].'="'.$valeur[$tableau[$i]['nom_bdd']].'",';
			}
		}
		//cas des fichiers
		elseif ($tableau[$i]['type']=='fichier_simple') {
			if (isset($valeur['texte_fichier'.$tableau[$i]['nom_bdd']]) && $valeur['texte_fichier'.$tableau[$i]['nom_bdd']]!='') {
				//baz_insertion_fichier($valeur['texte_fichier'.$tableau[$i]['nom_bdd']], $GLOBALS['_BAZAR_']['id_fiche'], 'fichier'.$tableau[$i]['nom_bdd']);
			} 
		}		
		
		//cas des images
		elseif ($tableau[$i]['type']=='image_simple') {
			if (isset($_FILES['image']['name']) && $_FILES['image']['name']!='') {
				//$requete .= baz_insertion_image($GLOBALS['_BAZAR_']['id_fiche']);
			}
		}
		
		//cas des champs texte
		elseif ( $tableau[$i]['type']=='texte' || $tableau[$i]['type']=='textelong'|| $tableau[$i]['type']=='champs_mail' 
						|| $tableau[$i]['type']=='champs_cache') {
			//on mets les slashes pour les saisies dans les champs texte et textearea
			$val=addslashes($valeur[$tableau[$i]['nom_bdd']]) ;
			$requete .= $tableau[$i]['nom_bdd'].'="'.$val.'", ' ;
		}
		 
		// Cas de la carte google
		elseif ($tableau[$i]['type'] == 'carte_google') {
			$requete .= 'a_latitude="'.$valeur['latitude'].'", a_longitude="'.$valeur['longitude'].'",';
		}	
		elseif ($tableau[$i]['type'] == 'mot_de_passe') {
			$requete .= $tableau[$i]['nom_bdd'].'="'.md5($valeur['mot_de_passe']).'",';
		}
	}
    // traitement du numéro de département pour la france
    if ($valeur['a_ce_pays'] == 'fr') {
        if (preg_match("/^97|98[0-9]*/", $valeur['a_code_postal'])) {
            $n_dpt = substr($valeur['a_code_postal'], 0, 3) ;
        } else {
            $n_dpt = substr($valeur['a_code_postal'], 0, 2) ;
        }
        $requete .= INS_CHAMPS_DEPARTEMENT.'="'.$n_dpt.'",';
    }
	$requete .= 'a_date_inscription=now()';
    return $requete ;
}



/** formulaire_defaults() - Renvoie un tableau avec les valeurs par défaut du formulaire d'inscription
*
* @return   array   Valeurs par défaut du formulaire d'inscription
*/
function inscription_formulaire_defaults($id = '') {
	if ($id == '') {
			$id = $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID);
	}
    $requete = 'select '.INS_ANNUAIRE.'.* '.
                'from '.INS_ANNUAIRE.' '.
                'where '.INS_ANNUAIRE.'.'.INS_CHAMPS_ID.'= "'.$id.'"' ;
    $resultat = $GLOBALS['ins_db']->query ($requete) ;
    if (DB::isError($resultat)) {
    	die ($resultat->getMessage().'<br />'.$resultat->getDebugInfo()) ;
    }
    $ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC) ;
    $valeurs_par_defaut = array() ;
    $valeurs_par_defaut['email'] = $ligne[INS_CHAMPS_MAIL];
    $valeurs_par_defaut['nom'] = $ligne[INS_CHAMPS_NOM];
    $valeurs_par_defaut['prenom'] = $ligne[INS_CHAMPS_PRENOM] ;
    $valeurs_par_defaut['pays'] = $ligne[INS_CHAMPS_PAYS] ;
    if (INS_UTILISE_WIKINI) {$valeurs_par_defaut['nomwiki'] = $ligne[INS_CHAMPS_NOM_WIKINI] ;}
    $valeurs_par_defaut['cp'] = $ligne[INS_CHAMPS_CODE_POSTAL] ;
    $valeurs_par_defaut['ville'] = $ligne[INS_CHAMPS_VILLE] ;
    $valeurs_par_defaut['adresse_1'] = $ligne[INS_CHAMPS_ADRESSE_1] ;
    $valeurs_par_defaut['adresse_2'] = $ligne[INS_CHAMPS_ADRESSE_2] ;
    $valeurs_par_defaut['telephone'] = $ligne[INS_CHAMPS_TELEPHONE] ;
    $valeurs_par_defaut['fax'] = $ligne[INS_CHAMPS_FAX] ;
    if (INS_CHAMPS_STRUCTURE != '' && isset($ligne[INS_CHAMPS_STRUCTURE])) {
    	$valeurs_par_defaut['structure'] = $ligne[INS_CHAMPS_STRUCTURE] ;
    	//$valeurs_par_defaut['type_structure'] = $ligne['a_type_structure'];	
    }
    $valeurs_par_defaut['site'] = $ligne[INS_CHAMPS_SITE_INTERNET] ;
    $valeurs_par_defaut['lettre'] = $ligne[INS_CHAMPS_LETTRE] ;
    $valeurs_par_defaut['visible'] = $ligne[INS_CHAMPS_VISIBLE] ;
    $valeurs_par_defaut['sigle_structure'] = $ligne[INS_CHAMPS_SIGLE_STRUCTURE] ;
    $valeurs_par_defaut['id_inscription'] = $ligne['a_ce_id_inscription'] ;
    if (INS_CHAMPS_NUM_AGREMENT != '') $valeurs_par_defaut['num_agrement'] = $ligne[INS_CHAMPS_NUM_AGREMENT] ;
    /*
    if ($GLOBALS['ins_config']['ic_google_key']) {
    	$valeurs_par_defaut['longitude'] = $ligne['a_longitude'] ;
    	$valeurs_par_defaut['latitude'] = $ligne['a_latitude'] ;
    }*/
    //$tableau = formulaire_valeurs_template_champs($GLOBALS['ins_config']['ic_inscription_template']);
    return $valeurs_par_defaut ;
}


/** info() - Renvoie une fiche d'information sur la personne ou la structure
* 
* @param  integer  identifiant de la fiche a afficher, mettre -1 pour voir sa propre fiche
* @param  text     nom de l'onglet de la fiche
*
* @return   text   Code HTML de la fiche
*/
function info($id=-1, $type_info='fiche') {
	if ($id==-1) $id=$GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID);
    $requete = 'SELECT * FROM '.INS_ANNUAIRE.' WHERE '.INS_ANNUAIRE.'.'
               .INS_CHAMPS_ID.'="'.$id.'"' ;          
    $resultat = $GLOBALS['ins_db'] -> query($requete) ; 
    if (DB::isError($resultat)) {
    	die ($resultat->getMessage().'<br />'.$resultat->getDebugInfo()) ;
    }

    $ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC) ;
    
    //voir la présentation de la fiche
    if ($type_info=='fiche' || $type_info == 'info') {
    	$res = '';
    	
	    if ($ligne[INS_CHAMPS_EST_STRUCTURE] == 1) {
	    	$res .= '<h2>'.INS_FICHE_STRUCTURE.'</h2>'."\n" ;
	    } else { 
	    	$res .= '<h2>'.INS_FICHE_PERSONNELLE.'</h2>'."\n" ;
	    }
	    $res .= '<div class="fiche">'."\n" ;
	    if ($ligne[INS_CHAMPS_LOGO] != NULL) {
    		$res .= '<img style="float:right;width:120px;height:120px;margin:0 0 10px 10px;" src="'.INS_CHEMIN_APPLI.'presentations/logos/'.$ligne[INS_CHAMPS_LOGO].'" alt="logo" />'."\n";
    	}
	    if ($ligne[INS_CHAMPS_EST_STRUCTURE] == 1) {	    
	    	$res .= '<h3>'.$ligne[INS_CHAMPS_NOM].'</h3>'."\n";	    		    		    
		    $res .= inscription_ligne(INS_SIGLE_DE_LA_STRUCTURE, $ligne[INS_CHAMPS_SIGLE_STRUCTURE]) ;
		    if (INS_CHAMPS_NUM_AGREMENT != '') $res .= inscription_ligne(INS_NUM_AGREMENT, $ligne[INS_CHAMPS_NUM_AGREMENT]) ;
	    } else {   	
	    	$res .= '<h3>'.$ligne[INS_CHAMPS_PRENOM].' '.$ligne[INS_CHAMPS_NOM].'</h3>'."\n";	    		    		    
	    }
	    	    
	    $res .= inscription_ligne(INS_ADRESSE_1, $ligne[INS_CHAMPS_ADRESSE_1]) ;
	    $res .= inscription_ligne(INS_ADRESSE_2, $ligne[INS_CHAMPS_ADRESSE_2]) ;
	    $res .= inscription_ligne(INS_CODE_POSTAL, $ligne[INS_CHAMPS_CODE_POSTAL]) ;
	    $res .= inscription_ligne(INS_VILLE, $ligne[INS_CHAMPS_VILLE]) ;
	    $pays = new ListeDePays($GLOBALS['ins_db']) ;
	    $res .= inscription_ligne(INS_PAYS, $pays->getNomPays($ligne[INS_CHAMPS_PAYS], INS_LANGUE_DEFAUT)) ;
	    $res .= inscription_ligne(INS_TELEPHONE, $ligne[INS_CHAMPS_TELEPHONE]) ;
	    $res .= inscription_ligne(INS_FAX, $ligne[INS_CHAMPS_FAX]) ;
	    
	    if ($ligne[INS_CHAMPS_SITE_INTERNET]!='') {
	    	$res .= inscription_ligne(INS_SITE_INTERNET, '<a href="'.$ligne[INS_CHAMPS_SITE_INTERNET].'" onclick="javascript:window.open(this.href);return false;">'.$ligne[INS_CHAMPS_SITE_INTERNET].'</a>');
	    }
	    
	    if ($GLOBALS['AUTH']->getAuth()) $res .= inscription_ligne(INS_EMAIL, '<a href="mailto:'.$ligne[INS_CHAMPS_MAIL].'">'.$ligne[INS_CHAMPS_MAIL].'</a>');
	    else $res .= '<br /><p class="zone_info">'.INS_PAS_IDENTIFIE.'</p>'."\n";
	    
	    if (INS_UTILISE_WIKINI) {
			$res .= inscription_ligne (INS_NOM_WIKI, $ligne[INS_CHAMPS_NOM_WIKINI])."\n" ;
		}
		
	    $res .= '</ul>'."\n";
	    if ($type_info == 'fiche') {
		    if ($id==$GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID)) {		    
			    $res .= '<ul style="margin-top:10px; clear:both;">'."\n";		    
			    if ($ligne[INS_CHAMPS_VISIBLE] == 1) {
			    	$res .= '<li>'.INS_VOUS_APPARAISSEZ.'</li>'."\n";
			    } else $res .= '<li>'.INS_VOUS_APPARAISSEZ_PAS.'</li>'."\n";
			    if (INS_CHAMPS_LETTRE != '') {
			    		if ($ligne[INS_CHAMPS_LETTRE] == 1) {
			    			$res .= '<li>'.INS_VOUS_RECEVEZ_LETTRE.'</li>'."\n";
			    		} else $res .= '<li>'.INS_VOUS_RECEVEZ_PAS_LETTRE.'</li>'."\n";
			    }
			    $res .= '</ul>'."\n";
			        
			    $res .= '<ul style="margin:15px;">'."\n";;
		    	$GLOBALS['ins_url']->addQueryString('id_inscription', $ligne['a_ce_id_inscription']);
			    $GLOBALS['ins_url']->addQueryString('action', 'modifier');
			    //$GLOBALS['ins_url']->addQueryString('id_inscription', $GLOBALS['ins_config']['ic_id_inscription']);
			    $res .= '<li><a href="'.$GLOBALS['ins_url']->getURL().'&amp;form_structure='.$ligne[INS_CHAMPS_EST_STRUCTURE].'">'.INS_MODIFIER_INSCRIPTION.'</a></li>'."\n" ;
			    $GLOBALS['ins_url']->addQueryString('action', 'supprimer');
			    $res .= '<li><a href="'.$GLOBALS['ins_url']->getURL().'&amp;form_structure='.$ligne[INS_CHAMPS_EST_STRUCTURE].'" onclick="javascript:return confirm(\''.INS_SUPPRIMER_INSCRIPTION.'?\');">'.INS_SUPPRIMER_INSCRIPTION.'</a></li>'."\n" ;
			    $GLOBALS['ins_url']->removeQueryString('id_inscription');
			    $GLOBALS['ins_url']->addQueryString('action', 'deconnexion');
			    $res .= '<li><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_DECONNEXION.'</a></li>'."\n" ;
			    $GLOBALS['ins_url']->removeQueryString('action');
			    $GLOBALS['ins_url']->removeQueryString('id_inscription');
			    $res .= '</ul>'."\n";
		    }
		    $res .= '</div>'."\n"; //div fiche
	    } 
	    
	//voir les abonnements presents dans les applis clientes    
    } elseif ($type_info=='abonnement') {
    	$res = '<h1>'.$ligne[INS_CHAMPS_PRENOM].' '.$ligne[INS_CHAMPS_NOM].'</h1>'."\n";
    	$res .= '<h2>'.INS_GESTION_DES_ABONNEMENTS.'</h2>'."\n" ;
    	
    	// Appel des actions d'abonnement des applications clientes
        $d = dir(GEN_CHEMIN_CLIENT);
        $abonnement='';
        $abonnements='';
		while (false !== ($repertoire = $d->read())) {
			if (file_exists(GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.'bibliotheque'.GEN_SEP.$repertoire.'.abonnement.inc.php')) {
				require_once GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.'bibliotheque'.GEN_SEP.$repertoire.'.abonnement.inc.php' ;
				$abonnements .= $abonnement;   
			}
		}
		$d->close();
		$res .= $abonnements;
		
    //voir les actus			
    } elseif ($type_info=='actus') {
    	$res = '<h1>'.$ligne[INS_CHAMPS_PRENOM].' '.$ligne[INS_CHAMPS_NOM].'</h1>'."\n";
    	$res .= '<h2>'.INS_ACTUALITES_DEPOSEES.'</h2>'."\n" ;
    	//require_once GEN_CHEMIN_CLIENT.'bazar'.GEN_SEP.'configuration'.GEN_SEP.'baz_config.inc.php';
    	//require_once GEN_CHEMIN_CLIENT.'bazar'.GEN_SEP.'bibliotheque'.GEN_SEP.'bazar.fonct.rss.php';
    	$_GET['action']=1;
    	$res .= RSSversHTML(gen_RSS('', '', $id, 1, ''), 0, 'jma', 0);
    	
	//voir les ressources	
    } elseif ($type_info=='ressources') {
    	$res = '<h1>'.$ligne[INS_CHAMPS_PRENOM].' '.$ligne[INS_CHAMPS_NOM].'</h1>'."\n";
    	$res .= '<h2>'.INS_RESSOURCES_ASSOCIEES.'</h2>'."\n" ;
    	$requete = 'SELECT bf_id_fiche, bf_titre FROM bazar_fiche, bazar_appropriation WHERE  ba_ce_id_fiche=bf_id_fiche AND ba_ce_id_structure='.$id ;
    	$resultat = $GLOBALS['ins_db'] -> query($requete) ;
    	$res .= '<ul>'."\n";
    	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
			$res .= '<li><a href="'.INS_URL_BAZAR.'&amp;action=8&amp;id_fiche='.$ligne['bf_id_fiche'].'" onclick="window.open(this.href,\'_blank\');return false;">'.$ligne['bf_titre'].'</a></li>'."\n";
		}
		$res .= '</ul><br />'."\n";
    
    //voir les competences		    
    } elseif ($type_info=='competences') {
    	$res = '<h1>'.$ligne[INS_CHAMPS_PRENOM].' '.$ligne[INS_CHAMPS_NOM].'</h1>'."\n";
    	$res .= '<h2>'.INS_COMPETENCES_ASSOCIEES.'</h2>'."\n" ;
    }
    return $res ;
}


/**	inscription_ligne() - Renvoie une ligne avec label et valeur
 *
 * @param string label Le label
 * @param string valeur
 * @return	string HTML
 */
function inscription_ligne($label, $valeur) {
    if ($valeur == '') {
        return;
    }
    if (($label == '')or($label == '&nbsp;')) {
    	return '<div class="inscription_infos">'.$valeur.'</div>'."\n";
    } else {
    	return '<div class="inscription_infos"><strong class="inscription_label">'."\n".$label.' : </strong>'.$valeur.'</div>'."\n";    	
    }
}


/** Renvoie vrai si l'email passé en paramètre n'est pas déjà dans l'annuaire
*   ou si, en cas de modification d'inscription, l'inscrit ne modifie pas son email
*
*   @return boolean 
*/
function inscription_verif_doublonMail($mail, $id = '') {
	if ($id == '') {
		if (isset ($GLOBALS['AUTH'])) {
			$id = $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID) ;
		}
	}
    if (isset ($id) && $id != '') {
        $requete_mail = "select ".INS_CHAMPS_MAIL." from ".INS_ANNUAIRE." where ".
        				INS_CHAMPS_ID."=".$id ;
        $resultat_mail = $GLOBALS['ins_db']->query ($requete_mail) ;
        if (DB::isError ($resultat_mail)) {
            die ("Echec de la requete : $requete_mail<br />".$resultat_mail->getMessage()) ;
        }
        $ligne_mail = $resultat_mail->fetchRow(DB_FETCHMODE_ASSOC) ;
        if ($mail == $ligne_mail[INS_CHAMPS_MAIL]) {
            return true ;
        }
    }
    $requete = "select ".INS_CHAMPS_MAIL." from ".INS_ANNUAIRE." where ".INS_CHAMPS_MAIL."= \"$mail\"" ;
    $resultat = $GLOBALS['ins_db']->query ($requete) ;
    if (DB::isError ($resultat)) {
    	die ($resultat->getMessage().'<br />'.$resultat->getDebugInfo()) ;
    }
    if ($resultat->numRows() == 0) return true ;
    return false ;
}


function inscription_envoie_passe() {
	$res='';
	$requete = 'SELECT '.INS_CHAMPS_MAIL.' FROM '.INS_ANNUAIRE.' WHERE '.INS_CHAMPS_MAIL.'="'.$_POST['mail'].'"' ;
    $resultat = $GLOBALS['ins_db']->query($requete) ;
    if (DB::isError($resultat)) {
        die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
    }
    if ($resultat->numRows() == 0) {
    	$res .= '<p class="erreur">'.INS_MAIL_INCONNU_DANS_ANNUAIRE.'</p>'."\n" ;
    } else {
    	include_once PAP_CHEMIN_RACINE.'api/pear/Mail.php' ;
    	$mail = & Mail::factory('mail') ;
    	$headers ['Return-Path'] = $GLOBALS['ins_config']['ic_from_mail_confirmation'] ;
    	$headers ['From'] = $GLOBALS['ins_config']['ic_from_mail_confirmation'] ;
    	$headers ['Subject'] = inscription::getTemplate(INS_TEMPLATE_MAIL_PASSE_SUJET, $GLOBALS['ins_config']['ic_id_inscription']) ;
    	$headers ['Reply-To'] = $GLOBALS['ins_config']['ic_from_mail_confirmation'] ;

    	$nouveau_passe = create_new_random(6) ;
    	// modification du mot de passe dans la base
    	$requete = 'UPDATE '.INS_ANNUAIRE.' SET '.INS_CHAMPS_PASSE.'=MD5("'.$nouveau_passe.'") WHERE '.INS_CHAMPS_MAIL.'="'.$_POST['mail'].'"' ;
    	$resultat = $GLOBALS['ins_db']->query($requete) ;
    	if (DB::isError($resultat)) {
    		die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
    	}
    	$body = inscription::getTemplate(INS_TEMPLATE_MAIL_PASSE_CORPS, $GLOBALS['ins_config']['ic_id_inscription']);
    	$body = str_replace('{MOT_DE_PASSE}', $nouveau_passe, $body);
    	
    	$mail->send($_POST['mail'], $headers, $body) ;
    	if (PEAR::isError($mail)) {
    		$res .= '<p class="erreur">'.INS_PROBLEME_ENVOI_MAIL.'</p>'."\n" ;
    		return $res ;
    	}
    	$res .= '<p class="info">'.INS_NOUVEAU_MOT_DE_PASSE_ENVOYE.'</p>'."\n" ;
    }
    return $res ;
}

/**
 *  Inscrit un adhérent à la lettre d'actualité par l'envoie d'un email subscribe / unsubscribe
 *  à la liste
 *
 * @global  AUTH    Un objet PEAR::Auth
 * @return  boolean true en cas de succès
 */

function inscription_lettre($action) {
    include_once PAP_CHEMIN_RACINE.'api/pear/Mail.php' ;
    $mail = & Mail::factory ('mail') ;
    $email = $GLOBALS['AUTH']->getUsername() ;
    $headers ['Return-Path'] = $email ;
    $headers ['From'] = "<".$email.">" ;
    $headers ['Subject'] = $action ;
    $headers ['Reply-To'] = $email ;
    
    $mail -> send ($action, $headers, "") ;
    if (PEAR::isError ($mail)) {
        echo '<p class="erreur">Le mail n\'est pas parti...</p>' ;
        return false ;
    }
    return true ;
}

/**
 *  desinscrit un adhérent à la lettre d'actualité par l'envoie d'un email subscribe / unsubscribe
 *  à la liste
 *
 * @global  AUTH    Un objet PEAR::Auth
 * @return  boolean true en cas de succès
 */

function desinscription_lettre($action) {
    include_once PAP_CHEMIN_RACINE.'api/pear/Mail.php' ;
    $mail = & Mail::factory ('mail') ;
    $email = $GLOBALS['AUTH']->getUsername() ;
    $headers ['Return-Path'] = $email ;
    $headers ['From'] = "<".$email.">" ;
    $headers ['Subject'] = $action ;
    $headers ['Reply-To'] = $email ;
    
    $mail -> send ($action, $headers, "") ;
    if (PEAR::isError ($mail)) {
        echo '<p class="erreur">Le mail n\'est pas parti...</p>' ;
        return false ;
    }
    return true ;
}

/**
 *
 * @global  ins_db  Un pointeur vers un objet PEAR::DB connecté
 * @return
 */

function inscription_envoie_mail() //A COMPLETER!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
{
    include_once PAP_CHEMIN_RACINE.'api/pear/Mail/mime.php' ;
    include_once PAP_CHEMIN_RACINE.'api/pear/Mail.php' ;
    $crlf="\n";
    
    $headers ['From'] = $GLOBALS['ins_config']['ic_from_mail_confirmation'] ;
    $headers ['Subject'] = INS_MAIL_COORD_SUJET ;
    $headers ['Reply-To'] = $GLOBALS['ins_config']['ic_from_mail_confirmation'] ;
    
    $mime = new Mail_mime($crlf);
    
    $requete = "select *, ".INS_CHAMPS_LABEL_PAYS." from ".INS_ANNUAIRE.",".INS_TABLE_PAYS.
            " where ".INS_CHAMPS_MAIL."=\"".$GLOBALS['AUTH']->getUsername()."\"".
            " and ".INS_CHAMPS_ID_PAYS."=".INS_CHAMPS_PAYS;

    $resultat = $GLOBALS['ins_db']->query($requete) ;
    if (DB::isError ($resultat)) {
        die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
    }
    $ligne  = $resultat->fetchRow(DB_FETCHMODE_ASSOC) ;
    $body_entete = INS_MAIL_COORD_CORPS."\n" ;
    $body = "mail : ".$ligne[INS_CHAMPS_MAIL]."\n" ;
    $body .= "------------------------------------------\n";
    $body .= INS_NOM.": ".unhtmlentities($ligne[INS_CHAMPS_NOM])." \n" ;
    $body .= INS_PRENOM.' : '.unhtmlentities($ligne[INS_CHAMPS_PRENOM])." \n" ;
    $body .= INS_PAYS." : ".unhtmlentities($ligne[INS_CHAMPS_LABEL_PAYS])." \n" ;
    $body .= "-------------------------------------------\n" ;
    
    $mime->setTXTBody($body);
    $mime->setHTMLBody(info()) ;
    
    $body = $mime->get();
    $headers = $mime->headers($headers);
    
    $mail = & Mail::factory('mail') ;
    
    $mail -> send ($ligne[INS_CHAMPS_MAIL], $headers, $body) ;
    
        // Envoi du mail aux administrateur du site
    foreach ($GLOBALS['mail_admin'] as $administrateur) {
        $mail -> send ($administrateur, $headers, $body) ;
    }
    if (PEAR::isError($mail)) {
        echo 'erreur d\'envoi' ;
        return false ;
    }
    return true ;
}


/**
 *  Génère un nom wiki valide à partir des données saisies par l'utilisateur
 *  fait une requete dans la base
 *
 * @return  string un nom wiki valide
 */

function inscription_genere_nom_wiki($prenom, $nom) {
    // 1. suppression des espaces
    $nom = trim ($nom) ;
    $prenom = trim ($prenom) ;
    
    // 2. suppression des caractères non ascii et ajout de la première lettre en majuscule
    $nom = inscription_trim_non_ascii ($nom) ;
    $prenom = inscription_trim_non_ascii ($prenom) ;
    
    // Vérification
    $nom_wiki = $prenom.$nom ;
    if (!preg_match('/^[A-Z][a-z]+[A-Z,0-9][A-Z,a-z,0-9]*$/', $nom_wiki)) {
        $nom_wiki = chr(rand(65, 90)).$nom_wiki.chr(rand(65, 90)) ;
    }
    return $nom_wiki ;
}

/**
 *	Cette fonction supprime les caractères autres que asccii et les chiffres
 *
 * @return	string la chaine épurée
 */

function inscription_trim_non_ascii ($nom) {
    $premiere_lettre = true ;
    for ($i = 0; $i < strlen ($nom); $i++) {
        if (!preg_match ('/[a-zA-Z0-9]/', $nom[$i])) {
            $nom[$i] = '_' ;
        }
    // remplacement de la première lettre en majuscule
        if (preg_match ('/[a-zA-Z]/', $nom[$i]) && $premiere_lettre) {
            $nom[$i] = strtoupper ($nom[$i]) ;
            $premiere_lettre = false ;
        } else {
            if (preg_match ('/[a-zA-Z]/', $nom[$i])) {
                $nom[$i] = strtolower ($nom[$i]) ;
            }
        }
    }
    $nom = preg_replace ('/_/', '', $nom) ;
    return $nom ;
}

// For users prior to PHP 4.3.0 you may do this:
//function unhtmlentities($string)
//{
//    $trans_tbl = array_flip ($trans_tbl);
//    return strtr ($string, $trans_tbl);
//}

//==============================================================================
/** function create_new_random($n,$type) permet de générer un nombre de caractères aléatoires.
*
*  
*
*  ENTREE :
*  - $n : créer un 'mot' de $n caractères
*  - $type : permet de définir la liste des caractères disponibles
*
*  SORTIE : chaine de $n caractères pris dans une liste $type
*/
function create_new_random($n,$type="")
{
    $str = "";

    switch ($type){
        default:{
            $chaine = "abcdefghkmnpqrstuvwxyzABCDEFGHKLMNPQRSTUVWXYZ23456789";
        }
            break;
    }
 
    srand((double)microtime()*1000000);
    for($i = 0; $i < $n; $i++){
        $str .= $chaine[rand()%strlen($chaine)];
    }
 
    return "$str";
}

//==============================================================================
/** function nextId () Renvoie le prochain identifiant numérique libre d'une table
*
*   On passe en paramètre le nom de la table et l'identifiant de la base selon PEAR DB
*
*   @param  mixed   handler de connexion
*   @param  string  Nom de la table
*   return  interger    l'identifiant
*/
function inscription_nextId($table, $colonne_identifiant)
{
    $requete = 'select MAX('.$colonne_identifiant.') as maxi from '.$table ;
    $resultat = $GLOBALS['ins_db']->query($requete) ;
    if (DB::isError($resultat)) {
        die (__FILE__ . __LINE__ . $resultat->getMessage() . $requete);
        return $GLOBALS['ins_db']->raiseError($resultat) ;
    }
    
    if ($resultat->numRows() > 1) {
        return $GLOBALS['ins_db']->raiseError("<br />La table $table a un identifiant non unique<br/>") ;
    }
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ;
    return $ligne->maxi + 1 ;
}


//-- Fin du code source    ------------------------------------------------------------
/*
* $Log$
* Revision 1.18  2007-06-26 09:32:33  neiluj
* debug inscription (warnings) et adaptation php5
*
* Revision 1.17  2007-06-25 15:37:57  alexandre_tb
* correction de bug
*
* Revision 1.16  2007-06-25 09:59:03  alexandre_tb
* ajout de carte_google, mise en place des templates avec api/formulaire, configuration de multiples inscriptions, ajout de modele pour les mails
*
* Revision 1.15  2007-06-01 15:10:25  alexandre_tb
* ajout d un chmod 0755 apres l upload du logo
*
* Revision 1.14  2007-05-25 14:31:24  alexandre_tb
* en cours
*
* Revision 1.13  2007/04/20 14:04:38  alexandre_tb
* inclusion de QuickForm qui manquait
*
* Revision 1.12  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.8.2.1  2007/01/26 10:28:43  alexandre_tb
* correction d un notice
*
* Revision 1.8  2006/12/01 13:23:15  florian
* integration annuaire backoffice
*
* Revision 1.7  2006/10/05 13:53:54  florian
* amÃ©lioration des fichiers sql
*
* Revision 1.6  2006/09/13 12:31:18  florian
* mÃ©nage: fichier de config Papyrus, fichiers temporaires
*
* Revision 1.5  2006/04/28 12:44:05  florian
* integration bazar
*
* Revision 1.4  2006/04/11 08:39:52  alexandre_tb
* correction de l'envoie de mail par la carto
*
* Revision 1.3  2006/04/10 14:21:51  florian
* correction bug affichage formulaire de mail en double
*
* Revision 1.2  2006/04/10 14:15:10  florian
* les cases Ã  cocher apparaissent Ã  nouveau
*
* Revision 1.1  2006/04/10 14:01:36  florian
* uniformisation de l'appli bottin: plus qu'un fichier de fonctions
*
*
*/
?>
