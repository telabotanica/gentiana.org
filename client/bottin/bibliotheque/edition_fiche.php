<?php

// +--------------------------------------------------------------------------------+
// | admin_annu.php 				                          						|
// +--------------------------------------------------------------------------------+
// | Copyright (c) 2002 					   							        	|
// +--------------------------------------------------------------------------------+
// | Administration des inscrits à un annuaire de type annuaire_tela			    |
// | de Gsite, 													                    |
// | Sont également mises en jeux les tables gen_COUNTRY, gen_FRENCH_DPT,	        |
// | LABELS															                |
// | Plus spécifique la fonction cotisation($id) en bas permet de				    |
// | gérer les cotisations versées par les inscrits, avec la table					|
// | annuaire_COTISATION													                |
// +--------------------------------------------------------------------------------+
// | Auteur : Alexandre Granier <alexandre@tela-botanica.org> 		  		        |
// +--------------------------------------------------------------------------------+
//
// $Id: edition_fiche.php,v 1.5 2007/04/11 08:30:12 neiluj Exp $


define ("URL_RECU", $GLOBALS['ins_url']->protocol. '://'.$GLOBALS['ins_url']->host."/client/annuaire/voir_recu_pdf.php") ;

include_once ("HTML/Table.php") ;

// admin_annu est une application cliente de gsite elle commence donc
// dans une fonction putFrame()


function putFrame()
{

    $url = $GLOBALS['ins_url']->getURL() ;

    // mise à jour si il y lieu

    if (isset ($_REQUEST['action']) && $_REQUEST['action'] == 'up') {
        upSQL() ;
	}

    // Requete de pour récupérer toutes les infos d'un usager

    $query = 'select '.INS_ANNUAIRE.'.* ,'.INS_TABLE_PAYS.'.'.INS_CHAMPS_LABEL_PAYS ;
    $query .= ' from '.INS_ANNUAIRE.','.INS_TABLE_PAYS.','.INS_TABLE_DPT ;
    $query .= ' where '.INS_CHAMPS_ID.'='.$_REQUEST[INS_CHAMPS_ID] ;
    $query .= ' and '.INS_ANNUAIRE.'.'.INS_CHAMPS_PAYS.'='.INS_TABLE_PAYS.'.'.INS_CHAMPS_ID_PAYS ;

    $result = $GLOBALS['ins_db']->query($query) ;
    if (DB::isError($result)) {
        echo $result->getMessage().'<br />'.$query ;
    }

    $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ;

    $res = '<h1>Edition d\'un adh&eacute;rent : '.$row[INS_CHAMPS_NOM].' '.$row[INS_CHAMPS_PRENOM].'</h1>'."\n" ;
    $res .= "<div>".form("Nom : ", INS_CHAMPS_NOM, $row[INS_CHAMPS_NOM])."</div>\n" ;
    $res .= "<div>".form("Pr&eacute;nom : ", INS_CHAMPS_PRENOM, $row[INS_CHAMPS_PRENOM])."</div>\n" ;
    $res .= "<div>".form("Adresse mail : ", INS_CHAMPS_MAIL, $row[INS_CHAMPS_MAIL])."</div>\n" ;
    $res .= "<div>".form("Date d'inscription : ", INS_CHAMPS_DATE, $row[INS_CHAMPS_DATE])."</div>\n" ;
    $res .= "<div>".form("Adresse 1 : ", INS_CHAMPS_ADRESSE_1, $row[INS_CHAMPS_ADRESSE_1])."</div>\n" ;
    $res .= "<div>".form("Adresse 2 : ", INS_CHAMPS_ADRESSE_2, $row[INS_CHAMPS_ADRESSE_2])."</div>\n" ;
    $res .= "<div>".form("Région : ", "a_region", $row['a_region'])."</div>\n" ;
    $res .= "<div>".form("Code postal : ", INS_CHAMPS_CODE_POSTAL, $row[INS_CHAMPS_CODE_POSTAL])."</div>\n" ;
    $res .= "<div>".form("Ville : ", INS_CHAMPS_VILLE, $row[INS_CHAMPS_VILLE])."</div>\n" ;
    $res .= "<div>".form("Pays : ", INS_CHAMPS_PAYS, $row[INS_CHAMPS_PAYS])."</div>\n" ;
    $res .= "<div>".form("Site web personnel : ", INS_CHAMPS_SITE_INTERNET, $row[INS_CHAMPS_SITE_INTERNET])."</div>\n" ;
	$res .= suppression($row[INS_CHAMPS_ID]) ;
    $formulaire = new HTML_formulaireInscription('formulaire_inscription', 'post',
    					 preg_replace('/&amp;/', '&', $GLOBALS['ins_url']->getURL()), '_self', '', 0) ;
    
    $formulaire->construitFormulaire(preg_replace('/&amp;/', '&', $GLOBALS['ins_url']->getURL()));
    if (isset($_REQUEST['form_structure'])) {
    	if ($_REQUEST['form_structure']==1) {
    		$formulaire->formulaireStructure() ;
    	}
    }
    
    //pour la modification d'une inscription, on charge les valeurs par défauts
    if (isset ($_REQUEST[INS_CHAMPS_ID]) == 'modifier') {
        $formulaire->addElement('hidden', 'modifier_v', '1') ;
        $formulaire->setDefaults(formulaire_defaults($_REQUEST[INS_CHAMPS_ID])) ;
    }
    
    if (isset ($_REQUEST['modifier_v'])) {
        if ($formulaire->validate()) {
            mise_a_jour($formulaire->getSubmitValues(), $_REQUEST[INS_CHAMPS_ID]);
        } else {
        	return $res.$formulaire->toHTML();	
        }
        return $res;
    }
    $res .= $formulaire->toHTML();
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'suppr_adh') {
    	$res .= suppression($_REQUEST[INS_CHAMPS_ID]) ;
    	return ;	
    }
    return $res ;
}


// form construit soit un formulaire de type <input type="text" ...> et
// de nom $field_ et place un $label devant
// soit construit un lien vers un formulaire à partir du champs $field_


function form($label, $field_, $value)
{
    global $u_id, $GS_GLOBAL, $field ;

    $url = $GLOBALS['ins_url']->getURL() ;

    if ($field != $field_) {
        $res = "<b>$label</b>" ;
        $res .= "<a href=\"$url&amp;field=$field_\">" ;
		$res .= $value ? $value : "(vide)";
        $res .= "</a>\n" ;
    }
    if ($field == $field_) {
        $res = '<form action="'.$url.'&amp;'.INS_CHAMPS_ID.'='.$_REQUEST[INS_CHAMPS_ID].'&amp;action=up&amp;field_='.$field_.'" method="post">' ;
        $res .= "<b>$label</b>\n" ;
        switch ($field_) {
            case INS_CHAMPS_PAYS :
                $res .= select (INS_TABLE_PAYS, INS_CHAMPS_ID_PAYS, INS_CHAMPS_LABEL_PAYS, $value);
            break ;
            default :
                $res .= '<input type="text" size="40" name="'.$field_.'" value="'.$value.'">'."\n" ;
        }
        $res .= '<input type="submit" value="valider">'."\n" ;
        $res .= "</form>" ;
    }
    return $res ;
}


// upSQL met à jour la table annuaire_tela

function upSQL()
{
    global $field_ ;

    // Recherche de l'ancien mail
    $req_am = 'select '.INS_CHAMPS_MAIL.' from '.INS_ANNUAIRE.' where '.INS_CHAMPS_ID.'='.$_REQUEST[INS_CHAMPS_ID] ;
    $res_am = $GLOBALS['ins_db']->query ($req_am) ;
    $ligne_am = $res_am->fetchRow(DB_FETCHMODE_ASSOC) ;
    $ancien_mail = $ligne_am[INS_CHAMPS_MAIL] ;
    
    if ($field_ == INS_CHAMPS_PAYS) {
        $field_ = INS_CHAMPS_PAYS ;
        $_REQUEST[$field_] = $_REQUEST[INS_TABLE_PAYS] ;
    }
    $query = 'update '.INS_ANNUAIRE.' set '.$field_.'="'.$_REQUEST[$field_].'" where '.INS_CHAMPS_ID.'='.$_REQUEST[INS_CHAMPS_ID] ;
    $GLOBALS['ins_db']->query($query) ;
    // Traitement du département
    if ($field_ == INS_CHAMPS_CODE_POSTAL) {
        if (preg_match("/^97|98[0-9]*/", $HTTP_POST_VARS[INS_CHAMPS_CODE_POSTAL])) {
            $n_dpt = substr($HTTP_POST_VARS[INS_CHAMPS_CODE_POSTAL], 0, 3) ;
        } else {
            $n_dpt = substr($HTTP_POST_VARS[INS_CHAMPS_CODE_POSTAL], 0, 2) ;
        }
        $GLOBALS['ins_db']->query ('update '.INS_ANNUAIRE.' set '.INS_CHAMPS_DEPARTEMENT.'='.$n_dpt.' where '.INS_CHAMPS_ID.'='.$_REQUEST[INS_CHAMPS_ID]) ;
    }
}

function suppression($u_id) {
    

    $url = $GLOBALS['ins_url']->getURL() ;

    $res = "<div>Supprimer l'inscription</div>\n" ;
    $res .="<div><form action=\"$url&action=suppr_adh\" method=\"post\">\n" ;
    $res .= "<input type=\"submit\" value=\"Supprimer\" " ;
    $res .= "onclick=\"javascript:return confirm('&ecirc;tes-vous s&ucirc;r de vouloir supprimer cet adh&eacute;rent');\">\n" ;
    $res .= "</form></div>\n" ;

    if (isset ($_REQUEST['action']) && $_REQUEST['action'] =="suppr_adh") {
        $queryLogin = 'select '.INS_CHAMPS_MAIL.' from '.INS_ANNUAIRE.' where '.INS_CHAMPS_ID.'='.$_REQUEST[INS_CHAMPS_ID] ;
        $resultLogin = $GLOBALS['ins_db']->query($queryLogin) ;
        $rowLogin = $resultLogin->fetchRow(DB_FETCHMODE_ASSOC) ;
        $mail = $rowLogin[INS_CHAMPS_MAIL];

        // suppression
        $query = 'delete from '.INS_ANNUAIRE.' where '.INS_CHAMPS_ID.'='.$_REQUEST[INS_CHAMPS_ID] ;
        $GLOBALS['ins_db']->query($query);
        
         // Appel des actions desinscriptions des applications clientes
        $d = dir(GEN_CHEMIN_CLIENT);
		$id_utilisateur = $_REQUEST[INS_CHAMPS_ID];
		while (false !== ($repertoire = $d->read())) {
			if (file_exists(GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.desinscription.inc.php'))
			include_once GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.desinscription.inc.php' ;   
		}
		$d->close();
    }
    return $res ;
}

function select ($table, $champs_id, $champs_label, $defaut = '') {
    $requete = 'select * from '.$table.' where gip_id_i18n like "'.$GLOBALS['lang'].'%"' ;
    $resultat = $GLOBALS['ins_db']->query($requete) ;
    if (DB::isError($resultat)) {
        echo $resultat->getMessage().'<br />'.$requete ;
    }
    $res = '<select name="'.$table.'">' ;
    
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
        $res .= '<option value="'.$ligne[$champs_id].'"' ;
        if ($defaut != '' && $defaut == $ligne[$champs_id]) $res .= ' selected' ;
        $res .= '>'.$ligne[$champs_label].'</option>' ;
    }
    $res .= '</select>' ;
    return $res ;
}

?>
