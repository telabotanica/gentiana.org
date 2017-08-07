<?
// +--------------------------------------------------------------------------------+
// | liste_inscrit.php                                                              |
// +--------------------------------------------------------------------------------+
// | Copyright (c) 2002                                                             |
// +--------------------------------------------------------------------------------+
// |                                                                                |
// +--------------------------------------------------------------------------------+
// | Auteur : Alexandre Granier <alexandre@tela-botanica.org>                       |
// +--------------------------------------------------------------------------------+
//
// $Id: cartographie.fonct.liste_inscrit.php,v 1.5 2007/04/11 08:30:12 neiluj Exp $

global $HTTP_USER_AGENT;

$classe_titre = 'titlePage' ;

$javascript = 'function confirmer () 
    {
        if (window.confirm (\'Cliquez sur OK pour confirmer.\')) {
            window.formmail.submit();
        }
    }
function setCheckboxes(the_form) 
{
    var do_check=document.forms[the_form].elements[\'selecttotal\'].checked;
    var elts            = document.forms[the_form].elements[\'select[]\'];
    var elts_cnt = (typeof(elts.length) != \'undefined\')
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
}

';

GEN_stockerCodeScript($javascript);
$res = "";
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
        }
        else if ($key == (count($tabonglet)-1)) {
            $res .= "<a class=\"chemin_carto\">&nbsp;&gt;&nbsp;$pays</a>";
        }
        else {
            $chemin .= '*'.$value;
            $res .= "<a class=\"chemin_carto\" href=\"".$monde->url."&amp;historique_cartes=$chemin\">&nbsp;&gt;&nbsp;".$tabnom[$key]."</a>";
        }
    }
    
    $res .= "</b>\n";
    
    $capitale = $row->CP_Intitule_capitale;
    
    $query2 = " SELECT count(".INS_CHAMPS_ID.") as nbr".
            " from ".INS_ANNUAIRE.
            " where ".INS_CHAMPS_PAYS."='$argument'";
    
    $result2 = $GLOBALS['ins_db']->query($query2);
    if (DB::isError($result2)) {
    	die ($result2->getMessage().'<br />'.$result2->getDebugInfo()) ;
    }
	    $row2 = $result2->fetchRow(DB_FETCHMODE_OBJECT) ;
	    $res .= "<br /><br /><div class=\"$classe_titre\">$pays (capitale: $capitale) : " ;
	    if ($row2->nbr == 0) {
		    $res .= INS_AUCUN_INSCRIT.' '.INS_LABEL_PROJET ;
		    
	    } 
	    else if ($row2->nbr == 1) {
		    $res .= $row2->nbr.' '.INS_INSCRIT.INS_LABEL_PROJET ;
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
			    $requete = 'SELECT * FROM '.INS_ANNUAIRE.
			    ' WHERE '.INS_CHAMPS_PAYS.'="'.$argument.'"'.
			    ' ORDER BY '.INS_CHAMPS_NOM.', '.INS_CHAMPS_PRENOM;
			    
			    if ($row2->nbr > 1) {
				    $res .= listes_inscrit($requete, $select, $url) ;
				    if ($mailer==1) {
					    if (!is_array($select)) {
						    $res .= "<div>".INS_NO_DESTINATAIRE."</div>";
					    }
					    else {
						    $res .= "<div class=\"$classe_titre\">".INS_MESSAGE_ENVOYE."</div>\n" ;
						    carto_envoie_mail() ;
					    }
				    }
				    else {
					    $res .= carto_texte_cocher() ;
				    }
				    $res .= carto_formulaire($titre_mail, $corps) ;
			    }
		    }
	    }
}

// 2 ème cas, on vient de cliquer sur un département français

 else if (count($tabmonde) == 4) {
    $numero_departement = $tabmonde[3];
    
    $query = 'SELECT * FROM '.INS_TABLE_DPT.' WHERE '.INS_CHAMPS_ID_DEPARTEMENT.'='.$numero_departement;
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
            $res.= "<a class=\"chemin_carto\" href=\"".
            		$monde->url."&amp;historique_cartes=$chemin\">&nbsp;&gt;&nbsp;".$tabnom[$key]."</a>";
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
    
    $query2 = ' SELECT count('.INS_CHAMPS_ID.') as nbr'.
            ' FROM '.INS_ANNUAIRE.
            ' WHERE '.INS_CHAMPS_CODE_POSTAL.' LIKE "'.$numero_departement.'%"'.
            ' AND '.INS_CHAMPS_PAYS.'="FR"';
    $result2 = $GLOBALS['ins_db']->query($query2);
    if (DB::isError($result2)) {
    	die ($result2->getMessage().'<br />'.$result2->getDebugInfo()) ;
    }
    
    $row2 = $result2->fetchRow(DB_FETCHMODE_OBJECT);
    $res .= "<br /><br /><div class=\"$classe_titre\">" ;
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
		    $requete = 'SELECT * FROM '.INS_ANNUAIRE.
		    ' WHERE '.INS_CHAMPS_CODE_POSTAL.' LIKE "'.$argument.'%"'.
		    ' AND '.INS_CHAMPS_PAYS.'="FR"';
		    ' ORDER BY '.INS_CHAMPS_NOM.', '.INS_CHAMPS_PRENOM;
		    $res .= listes_inscrit($requete, $select, $_SERVER['REQUEST_URI']) ;
		    if ($mailer==1) {
			    if (!is_array($select)) {
				    $res.= INS_NO_DESTINATAIRE;
			    } else {
				    $res .= "<div class=\"$classe_titre\">".INS_MESSAGE_ENVOYE."</div>\n" ;
				    carto_envoie_mail() ;
			    }
		    } else {
			    $res .=carto_texte_cocher() ;
		    }
		    $res .= carto_formulaire() ;
	    }
    }
}
?>