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
*Page permettant l'affichage des informations de cartographie des inscrits
*
*@package cartographie
//Auteur original :
*@author                Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@copyright         Tela-Botanica 2000-2004
*@version             03 mai 2004
// +-----------------------------------------------------------------------------------------------+
//
// $Id: cartographie.fonct.php,v 1.4 2007/04/11 08:30:12 neiluj Exp $
// FICHIER : $RCSfile: cartographie.fonct.php,v $
// AUTEUR    : $Author: neiluj $
// VERSION : $Revision: 1.4 $
// DATE        : $Date: 2007/04/11 08:30:12 $
*/

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
    	$res .= "<b>\n";
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
        $res .= "</b>\n";
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
			    $requete = 'SELECT * FROM '.$nom_table1;
			    if ($nom_table2!=0) $requete .=  ', '.$nom_table2;
			    $requete .= ' WHERE '.$nom_champs_pays.'="'.$argument.'"';
			    if ($requete_sql!='') $requete .=  ' AND ('.$requete_sql.')';
			    //todo: gerer l'ordre ' ORDER BY '.INS_CHAMPS_NOM.', '.INS_CHAMPS_PRENOM;
			    
			    if ($row2->nbr >= 1) {
				    $res .= listes_inscrit($requete, $select, $_SERVER['REQUEST_URI']) ;
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
	    
	    $tabonglet=explode ('*', $monde->historique);
	    $tabnom=explode ('*', $monde->nom);
	    $res.="<div><b>\n";
	    foreach ($tabonglet as $key=>$value) {
	        if ($key==0) {
	            $chemin=$value;
	            $value='monde';
	            $res.= "<a class=\"chemin_carto\" href=\"".$monde->url."&amp;historique_cartes=$chemin\">&nbsp;&gt;&nbsp;".$tabnom[$key]."</a>";
	        }
	        else if ($key==(count($tabonglet)-1)) {
	            $res.="<a class=\"chemin_carto\">&nbsp;&gt;&nbsp;$nom</a>";
	        }
	        else {
	            $chemin.='*'.$value;
	            $res.= "<a class=\"chemin_carto\" href=\"".$monde->url."&amp;historique_cartes=$chemin\">&nbsp;&gt;&nbsp;".$tabnom[$key]."</a>";
	        }
	    }
	    $res .= "</b></div>\n";	
	    
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
	    $res .= '<br /><br /><div class="nb_inscrits">' ;
	    if ($row2->nbr == 0) {
	        $res .= INS_AUCUN_INSCRIT." ".INS_LABEL_PROJET ;
	    }
	    else if ($row2->nbr == 1) {
	        $res .= $row2->nbr." ".INS_INSCRIT." ".INS_LABEL_PROJET ;
	    } 
	    else {
	        $res .= $row2->nbr." ".INS_INSCRIT."s ".INS_LABEL_PROJET ;
	    }
	    $res .= "</div><br />\n";
	    if ($row2->nbr>0) {
		    if ((INS_NECESSITE_LOGIN)and(!$GLOBALS['AUTH']->getAuth())) {
		    	$res .= '<br /><p class="zone_alert">'.INS_VOUS_DEVEZ_ETRE_INSCRIT.'</p>'."\n" ;
		    } else {		    
			    $requete = 'SELECT * FROM '.$nom_table1;
			    if ($nom_table2!=0) $requete .=  ', '.$nom_table2;			    
			    
			    if (strlen($argument)==1) {
			    	$argument='0'.$argument;
			    }
			    
			    $requete .= ' WHERE '.$nom_champs_cp.' LIKE "'.$argument.'%"'.
			    ' AND '.$nom_champs_pays.'="FR"';
			    	
			    if ($requete_sql!='') $requete .=  ' AND ('.$requete_sql.')';			
			    //todo: ' ORDER BY '.INS_CHAMPS_NOM.', '.INS_CHAMPS_PRENOM;
			    $res .= listes_inscrit($requete, $select, $_SERVER['REQUEST_URI']) ;
			    if ($mailer==1) {
				    if (!is_array($select)) {
					    $res.= INS_NO_DESTINATAIRE;
				    } else {
					    $res .= '<p class="zone_info">'.INS_MESSAGE_ENVOYE."</p>\n" ;
					    carto_envoie_mail() ;
				    }
			    } else {
				    $res .=carto_texte_cocher() ;
			    }
			    $res .= carto_formulaire() ;
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
    $res = "<div class=\"texte\">".INS_CHECK_UNCHECK ;
    $res .= "&nbsp;<input type=\"checkbox\" name=\"selecttotal\" onclick=\"javascript:setCheckboxes('formmail');\" /></div>";
    return $res ;
}


/** function carto_formulaire ()
*
*
*
*	@return string  HTML
*/
function carto_formulaire($titre_mail="", $corps="") {
	$res = "<br /><h2>".INS_ENVOYER_MAIL."</h2><br />\n";
	$res .= INS_SUJET.' :<br /><input class="forml" type="text" name="titre_mail" size="60" value="'.$titre_mail.'" /><br /><br />'."\n"
	.INS_MESSAGE.' :<br /><textarea class="forml" name="corps" rows="5" cols="60">'.$corps.'</textarea><br />'."\n";
	$res.='<br /><input class="bouton" type="submit" onclick="javascript:confirmer();" value="'.INS_ENVOYER.'" /></form>'."\n";
	return $res ;
}

/**
 *  Renvoie le code HTML de la liste des inscrits
 *  en fonction de la requete passé en parametre
 *
 * @return  Renvoie le code HTML de la liste des inscrits
 */

function listes_inscrit($requete, $select, $url) {
    $res='';
    $resultat= $GLOBALS['ins_db']->query($requete);
    if (DB::isError($resultat)) {
        die ($resultat->getMessage().'<br />'.$resultat->getDebugInfo()) ;
    }
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
    	$res.='<input type="checkbox" name="select[]" value="'.$ligne[INS_CHAMPS_MAIL].'" />'."\n".
               $ligne[INS_CHAMPS_NOM].'&nbsp;'.$ligne[INS_CHAMPS_PRENOM].'&nbsp;'.
               $ligne[INS_CHAMPS_CODE_POSTAL].'&nbsp;'.$ligne[INS_CHAMPS_VILLE].'&nbsp;'.
               date("d.m.Y", strtotime($ligne[INS_CHAMPS_DATE_INSCRIPTION])).'<br /><br />'."\n";
    }    
    $res .= '<input type="hidden" name="mailer" value="1" />'."\n";
    $res .= '<input type="hidden" name="select" value="'.$select.'" /><br />'."\n";
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
    $entete = "From: <".$ligne[INS_CHAMPS_MAIL].">\n";
    
    $GLOBALS['corps'] .= INS_TEXTE_FIN_MAIL;
    $GLOBALS['corps'] = stripslashes($GLOBALS['corps']) ;
    $liste = "" ;
    foreach ($GLOBALS['select'] as $key => $value) {
        mail ($value, stripslashes($GLOBALS['titre_mail']), $GLOBALS['corps'] , $entete) ;
        $liste .= $value."\n" ;
    }
    
    $GLOBALS['corps'] .= "\n----------------------------------------------------------------------------";
    $GLOBALS['corps'] .= "\n".INS_MESSAGE_ENVOYE_A." :\n $liste" ;
    
    mail(INS_MAIL_ADMIN, stripslashes(INS_SURVEILLANCE_ENVOI_MAIL.$GLOBALS['titre_mail']), $GLOBALS['corps'], $entete);
    $GLOBALS['corps'] = '';
    $GLOBALS['titre_mail'] = '';
}
//-- Fin du code source    ------------------------------------------------------------
/*
* $Log: cartographie.fonct.php,v $
* Revision 1.4  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.2  2006/04/04 12:23:05  florian
* modifs affichage fiches, gÃ©nÃ©ricitÃ© de la carto, modification totale de l'appli annuaire
*
* Revision 1.1  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.2  2005/09/22 13:30:49  florian
* modifs pour compatibilitÃ© XHTML Strict + corrections de bugs (mais ya encore du boulot!!)
*
* Revision 1.1  2004/12/15 13:30:20  alex
* version initiale
*
*
*/
?>