<?php

// +--------------------------------------------------------------------------------+
// | annuaire_moteur_fonction.php 		                      						|
// +--------------------------------------------------------------------------------+
// | Copyright (c) 2000 - 2003 Tela Botanica 							        	|
// +--------------------------------------------------------------------------------+
// | Les fonctions de annuaire_moteur.php                                           |
// +--------------------------------------------------------------------------------+
// | Auteur : Alexandre Granier <alexandre@tela-botanica.org> 		  		        |
// +--------------------------------------------------------------------------------+
//
// $Id: annuaire_backoffice.fonct.php,v 1.12 2007-06-25 09:59:03 alexandre_tb Exp $


/** function mkengine ()
*
*
*
*	@return
*/

include_once PAP_CHEMIN_API_PEAR.'Pager/Pager.php' ;
include_once PAP_CHEMIN_API_PEAR.'HTML/Table.php';

function mkengine()
  {
    global $nbr_total;
    global $bouton, $HTTP_POST_VARS ;
    
    $requete = mkquery() ;
    $ret = '<div>'. $requete .'</div>';
    // Deux requetes, une avec tous les resultats, l'autre avec les r�sultats affich�s

    $result_final = $GLOBALS['ins_db']->query($requete) ;
    if (DB::isError($result_final)) {
    	echo $result_final->getMessage().'<br />'.$requete ;	
    }
    $nbr_final = $result_final->numRows() ;
    
    $_SESSION['requete_mail_tous'] = $requete ;
    
    $donnees = array();
	while ($ligne = $result_final->fetchRow(DB_FETCHMODE_ASSOC)) {
		$donnees[] = $ligne ;	
	}
	
	if (!isset($_REQUEST['setPerPage'])) $_REQUEST['setPerPage'] = 50 ;
	
	$param_pager = array (
                    'mode' => 'Jumping',
                    'delta' => 5,
                    'itemData' => $donnees
             ) ;
    $pager = & Pager::factory($param_pager);
	
	
    $mes_vars = array ("recherche", "nom", "ville", "mail" ,"dept", "prenom", "cotisant", "pays", "sort", "T_REPONSE", "lettre","statut") ;
    
    // Deux cas , soit on a clique sur rechercher, soit on a clique sur un lien
    foreach ($mes_vars as $key=>$value) {
        if (!$bouton) {     // on a clique sur un lien
            if (empty($HTTP_POST_VARS[$value])) {
             
            }
        } else {
            // Si on clique sur le bouton rechercher
            if (empty ($HTTP_POST_VARS[$value])) {
                $$value = "" ;
            } else {
                $$value = $HTTP_POST_VARS[$value] ;
            }
        }
    }
    // Comptage du nombre total de donnees dans la table (hors CACHER = 1)
    $requete_nbre_inscrit = "select count(*) as CPT from ".INS_ANNUAIRE;
    $resultat_nbre_inscrit = $GLOBALS['ins_db']->query($requete_nbre_inscrit) ;
    

  if ($resultat_nbre_inscrit->numRows() == 1) {
        $tmp_nb = $resultat_nbre_inscrit->fetchRow(DB_FETCHMODE_OBJECT);
        $nbr_total = $tmp_nb->CPT;
        $chaine = "parmi $nbr_total donn&eacute;es";
        if ($nbr_total <= 0) $ret .= "<B>Erreur</B> lors du comptage des structures ($nbr_total trouv&eacute;es) : $requete_nbre_inscrit";
    }
  else $ret .=  "<B>Erreur</B> lors du comptage des structures : $requete_nbre_inscrit";


  // fin comptage

  	//$ret = '';
	$ret .= '<h1>'.AM_L_TITRE.' '.$chaine.'</h1>'."\n" ;
  // construction du moteur de str
 
    $ret .= '<form action="'.$GLOBALS['ins_url']->getURL().'" method="post">'."\n";
    $ret .= '<table summary="recherche">'."\n";
    
    // ligne de recherche
    $ret .= "<tr>\n";
    $ret .= "<td>".AM_L_RECHERCHER." :\n</td>\n<td>";
    $ret .= form_mk_chaineI(isset ($_REQUEST['recherche']) ? stripslashes($_REQUEST['recherche']) : '', "recherche")."&nbsp;";
    $ret .= '</td><td colspan="4">'.AM_L_PAYS." : \n" ;
    
    // formulaire contenant les pays, avec par defaut soit le pays en cours
    // soit "tous les pays"
    $liste_pays = new ListeDePays($GLOBALS['ins_db']) ;
    $tableau_pays = $liste_pays->getListePays(INS_LANGUE_DEFAUT) ;
    
    $ret .= "<select name=\"pays\">\n" ;
    $ret .= "<option value=\"tous\">Tous les pays</option>\n" ;
    foreach ($tableau_pays as $codeIso => $labelPays) {
        $ret .= '<option value="'.$codeIso.'"' ;
        if (!empty($pays)) {
                if ($pays == $codeIso) $ret .= " selected" ;
        }
        $ret .= '>'.$labelPays.'</option>'."\n" ;
    }
    $ret .= "</select>\n" ;
    $ret .= "</td></tr>\n" ;
  
	$ret .= "<tr>\n";
    $ret .= "<td>".AM_L_NOM." :\n</td><td>";
    $ret .= form_mk_chaineI(isset ($_REQUEST['nom']) ? stripslashes($_REQUEST['nom']) : '', "nom")."&nbsp;</td>\n<td>" ;
    $ret .= AM_L_PRENOM."&nbsp;:</td>\n<td>".form_mk_chaineI(isset ($_REQUEST['prenom']) ? stripslashes($_REQUEST['prenom']) : '', "prenom")."&nbsp;</td>\n<td class=\"insLabel\">" ;
    $ret .= AM_L_VILLE."&nbsp;:</td>\n<td>".form_mk_chaineI(isset ($_REQUEST['ville']) ? stripslashes($_REQUEST['ville']) : '', "ville")."&nbsp;</td>" ;
    $ret .= "</tr><tr>\n" ;
    $ret .= "<td>".AM_L_DEPARTEMENT."&nbsp;: </td>\n<td>" ;
    
    // Construction du <select> des departements
    $requete_dpt = 'select '.INS_CHAMPS_ID_DEPARTEMENT.', '.INS_CHAMPS_NOM_DEPARTEMENT.' from '.INS_TABLE_DPT ;
    $resultat_dpt = $GLOBALS['ins_db']->query($requete_dpt) ;
    if (DB::isError($resultat_dpt)) {
    	echo 'Echec de la requete<br />'.$requete_dpt.'<br />'.$resultat_dpt->getMessage();	
    }
    $ret .= "<select name=\"dept\">\n" ;
    $ret .= "<option value=\"tous\">tous</option>\n" ;
    while ($ligne_dpt = $resultat_dpt->fetchRow(DB_FETCHMODE_ASSOC)) {
        $ret .= '<option value="'.$ligne_dpt[INS_CHAMPS_ID_DEPARTEMENT].'"' ;
        if (isset ($_REQUEST['dept']) && $_REQUEST['dept'] == $ligne_dpt[INS_CHAMPS_ID_DEPARTEMENT]) $ret .= " selected" ;
        $ret .= '>'.$ligne_dpt[INS_CHAMPS_ID_DEPARTEMENT].' - '.$ligne_dpt[INS_CHAMPS_NOM_DEPARTEMENT].'</option>'."\n" ;
    }
    $ret .= "</select></td>\n" ;
    
    $ret .= '<td>'.AM_L_MAIL.'&nbsp;: </td><td colspan="3">'.form_mk_chaineI(isset ($_REQUEST['mail']) ? stripslashes($_REQUEST['mail']) : '', "mail")."</td>\n" ;
    $ret .= "</tr>" ;
    
    // Les statuts des inscrits

    $ret .= "<tr>\n";
    $ret .= "<td>\n";
    $ret .= AM_L_GRP_RES." : </td>" ;
    $ret .= '<td>'.$pager->getperpageselectbox (50 , 200, 50 , false ,'%d').'</td>'."\n" ;
    $ret .= '<td colspan="4">'."\n";
    $ret .= "<input type=\"submit\" value=\"".AM_L_RECHERCHER."\" name =\"bouton\">\n";
    $ret .= "</td></tr></table></form>\n";
    
    $ret .= "\n<div>" ;
    
    // La liste des lettres de l'alphabet
    for ($i = 65 ; $i <91 ; $i++) {
    	$GLOBALS['ins_url']->addQueryString('lettre', chr($i)) ;
        $ret .= "\t<a href=\"".$GLOBALS['ins_url']->getURL();
        $ret .= '">';
        $ret .= chr($i) ;
        $ret .= "</a> \n";
	}
	$GLOBALS['ins_url']->addQueryString ('lettre', 'tous') ;
	$ret .= " <a href=\"".$GLOBALS['ins_url']->getURL().'">'.AM_L_TOUS."</a>\n" ;
    $ret .= "</div>\n" ;
    $ret .= '<div>'.$nbr_final.' r&eacute;sultat(s)</div>' ;
    $GLOBALS['ins_url']->removeQueryString('lettre') ;
    
    // Menu Ajouter un inscrit
    $GLOBALS['ins_url']->addQueryString('ajouter', '1') ;
    $ret .= '<div><a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_AJOUT_MEMBRE.'</a></div>'."\n";
    $GLOBALS['ins_url']->removeQueryString('ajouter') ;
	$data  = $pager->getPageData();
	
	$table = new HTML_Table(array ('class' => 'table_bazar')) ;
	$table->addRow(array(
				'<a href="'.$GLOBALS['ins_url']->getURL().'&amp;sort='.INS_CHAMPS_NOM.'">Identit&eacute;</a>',
				'<a href="'.$GLOBALS['ins_url']->getURL().'&amp;sort='.INS_CHAMPS_MAIL.'">Adresse mail</a>',
				'<a href="'.$GLOBALS['ins_url']->getURL().'&amp;sort='.INS_CHAMPS_VILLE.'">'.AM_L_VILLE.'</a>',
				'Pays ou Dpt (fr)',
				INS_SUPPRIMER
			), '', 'TH') ;
	
	$debut = isset($_REQUEST['pageID']) ? $_REQUEST['pageID'] : 1 ; 
	for ($i = ($debut - 1) * $_REQUEST['setPerPage']; 
				$i < $_REQUEST['setPerPage'] * $debut;
				$i++) {
		// On teste s'il y une valeur, si oui on ajoute la ligne
		if (isset ($data[$i])) {
			$urlPop = $GLOBALS['ins_url']->getURL().'&amp;'.INS_CHAMPS_ID.'='.$data[$i][INS_CHAMPS_ID];
			$ligne_inscrit = array ("<a href=\"$urlPop\">".$data[$i][INS_CHAMPS_NOM].' '.$data[$i][INS_CHAMPS_PRENOM].
								'</a>', $data[$i][INS_CHAMPS_MAIL], $data[$i][INS_CHAMPS_VILLE]) ;
								
			// Pour la france on met le departement, sinon on laisse le nom du pays
			if ($data[$i][INS_CHAMPS_PAYS] != 'fr') {
				array_push ($ligne_inscrit, $data[$i][INS_CHAMPS_LABEL_PAYS]);
			} else {
		        $req_dpt = 'select '.INS_CHAMPS_NOM_DEPARTEMENT.' from '.INS_TABLE_DPT.",".INS_ANNUAIRE.
							" where ".INS_ANNUAIRE.'.'.INS_CHAMPS_ID.'='.$data[$i][INS_CHAMPS_ID] ;
		        $req_dpt .= " and ".INS_ANNUAIRE.'.'.INS_CHAMPS_DEPARTEMENT.'='.INS_TABLE_DPT.'.'
		        					.INS_CHAMPS_ID_DEPARTEMENT ;
		        $resultat_dpt = $GLOBALS['ins_db']->query($req_dpt) ;
		        if (DB::isError($resultat_dpt)) {
		        	echo $resultat_dpt->getMessage().$resultat_dpt->getDebugInfo();		        	
		        }
		        $ligne_dpt = $resultat_dpt->fetchRow(DB_FETCHMODE_ASSOC) ;
				array_push ($ligne_inscrit, $ligne_dpt[INS_CHAMPS_NOM_DEPARTEMENT]) ;
				$GLOBALS['ins_url']->addQueryString(ANN_VARIABLE_ACTION, ANN_ACTION_SUPPRIMER_INSCRIT);
				$GLOBALS['ins_url']->addQueryString(INS_VARIABLE_ID_INSCRIT, $data[$i][INS_CHAMPS_ID]);
				array_push ($ligne_inscrit, '<a href="'.$GLOBALS['ins_url']->getURL().
						'" onclick="javascript:return confirm(\''.INS_SUPPRIMER.' ?\');">'.INS_SUPPRIMER.'</a>');
			}
			
			$table->addRow($ligne_inscrit) ;
		}
	}
	$ret .= $table->toHTML();
	$links = $pager->getLinks();
	$ret .= $links['all'] ;

    $ret .= '<div><a href="'.$GLOBALS['ins_url']->getURL().'&amp;action='.ANN_MAIL_TOUS
    			.'">'.AM_L_MAIL_SELECTION."</a></div>\n" ;
 
    return $ret;
}

/** function form_mk_chaineI () Renvoie une balise de type <input>
*
*   @param  string  l'attribut value de la balise
*   @param  string  l'attibut name de la balise
*   @param  string  la classe CSS
*   @return string  HTML
*/
function form_mk_chaineI($value="", $name, $class="insInputForm")
{
    return "<input type=\"text\" size=\"15\" value=\"$value\" name=\"$name\" class=\"$class\">";
}

function form_mk_select($value="", $name="", $class="insInputForm") {
	$res = "<select name=\"$name\" class=\"$class\">\n" ;
	$res .= "<option value=\"1\"" ;
	if ($value == 1) $res .= " selected" ;
	$res .= ">Cotisants</option>\n" ;
	$res .= "<option value=\"2\"" ;
	if ($value == 2) $res .= " selected" ;
	$res .= ">Non cotisants</option>\n" ;
	$res .= "<option value=\"3\"" ;	
	if ($value == 3 || $value == "") $res .= " selected" ;
	$res .= ">Tous</option>\n" ;
	$res .= "</select>\n" ;
	return $res ;
  }

function mkquery()
{
    
	// Requete sur l'annuaire pour extraire le nom, prenom, ville, nom du departement (jointure),
	// l'etat de la cotisation (jointure) 
	
	// le tableau suivant contient tous les champs de la table annuaire_tela sur lesquels on peut effectuer une recherche
	$fields_annu = array("nom" => INS_CHAMPS_NOM, "prenom" => INS_CHAMPS_PRENOM , "mail" => INS_CHAMPS_MAIL , "ville" => INS_CHAMPS_VILLE,
			"dept" => INS_CHAMPS_DEPARTEMENT, "pays" => INS_CHAMPS_PAYS ) ;

    $mes_vars = array ("recherche", "nom", "ville", "mail" ,"dept", "prenom", "cotisant", "pays", "sort", "T_REPONSE", "lettre","statut") ;

	$queries = "select ".INS_ANNUAIRE.".*" ;
    $queries .= ", ".INS_TABLE_PAYS.'.'.INS_CHAMPS_LABEL_PAYS ;
	$queries .= " from ".INS_ANNUAIRE ;
    $queries .= ",".INS_TABLE_PAYS ;
 
	// Construction en fonction des champs saisies
 
	// juste le champs "rechercher", on regarde partout
	
	$where = ' where ' ;
    if (isset ($_REQUEST['recherche']) && $_REQUEST['recherche'] != "") {
        $where .= '('.INS_CHAMPS_NOM.' like "%'.$_REQUEST['recherche'].'%"' ; // le premier
        foreach($fields_annu as $key=>$value) {
			if ($key == "nom" || $key == 'dept') continue ;
            $where .= ($key == "pays" ? 
                $_REQUEST['pays'] == "tous" ? ")" :
                ") and $value = '".$_REQUEST['pays']."'" : ' or '.$value.' like "%'.$_REQUEST['recherche'].'%"') ;	// les autres
        }
        if (isset ($_REQUEST['dept']) && $_REQUEST['dept'] != 'tous') {
        	$where .= 'and '.INS_CHAMPS_DEPARTEMENT.'="'.$_REQUEST['dept'].'"' ;	
        }	
	} else {

		// si un ou plusieurs autres champs ont ete indique, on les rajoute ici

		$or_flag = false ;
		foreach($fields_annu as $key=>$valeur) {
            if ($key != "") {
                if ($key == "pays") {
                    if (!isset($_REQUEST[$key]) || $_REQUEST[$key] == "tous") {
                    	$where .= " and ".INS_CHAMPS_PAYS." like '%'";
                    } else {
                    	$where .= " and $valeur like \"%".$_REQUEST[$key]."%\"" ;
                    }
                } else {
                    if ($key == "dept") {
                        if (isset($_REQUEST[$key]) && $_REQUEST[$key] != "tous") {
                            $where .= " and ".INS_CHAMPS_DEPARTEMENT."=".$_REQUEST[$key] ;
                            if ($fields_annu["pays"] != "fr") $where .= " and ".INS_CHAMPS_PAYS."=\"fr\"" ;
                        }
                        
                    } else {
                        if (isset ($_REQUEST[$key]) && $or_flag) {
                        	$where .= "$valeur like \"%".$_REQUEST[$key]."%\"" ;
                        } else {
                        	$where .= "$valeur like \"%%\"" ;
                        }
                        if ($key != "ville") $where .= " and " ;
                    }
                }
                $or_flag = true ;
            }
		}
		// ici le cas ou rien n'a ete saisie du tout, on affiche tout
		if (!$or_flag) {
				$where .= INS_CHAMPS_NOM." like '%')" ;
		}
	}

    if (isset($_REQUEST['lettre'])) {
    	if ($_REQUEST['lettre'] == 'tous') $_REQUEST['lettre'] = '';
    	$where = ' where '.INS_CHAMPS_NOM.' like "'.$_REQUEST['lettre'].'%"' ;
    }
    $where .= " and ".INS_ANNUAIRE.".".INS_CHAMPS_PAYS."=".INS_TABLE_PAYS.".".INS_CHAMPS_ID_PAYS."" ;

    if (isset($nom) && $nom != "") $where .= " and ".INS_CHAMPS_NOM." like \"%$nom%\"" ;
    if (isset($_REQUEST['prenom']) && $_REQUEST['prenom'] != "") 
    				$where .= " and ".INS_CHAMPS_PRENOM.' like "%'.$_REQUEST['prenom'].'%"' ;
    if (isset($ville) && $ville != "") $where .= " and ".INS_CHAMPS_VILLE." like \"%$ville%\"" ;
    if (isset($mail) && $mail != "") $where .= " and ".INS_CHAMPS_MAIL." like \"%$mail%\"" ;
    $where .= ' and  gip_id_i18n like "%'.$GLOBALS['lang'].'%"' ;

	if (isset ($_REQUEST['lettre']) && $_REQUEST['lettre'] == "tous") $_REQUEST['lettre'] = "" ;
    if (!isset ($_REQUEST['lettre'])) $_REQUEST['lettre'] = '' ;
	

    $queries .= $where ;
    
  if (isset($_REQUEST['sort']) && $_REQUEST['sort'] != "") $queries .= ' order by '.$_REQUEST['sort'] ;
  return $queries;
}
  

function ajouterInscrit() {
	$res = '';
	$GLOBALS['ins_url']->addQueryString ('ajouter', '1');
	$GLOBALS['ins_url']->addQueryString ('ajouter_v', '1');
	$formulaire = new HTML_formulaireInscription('inscription',  '', 
						str_replace ('&amp;', '&', $GLOBALS['ins_url']->getURL()), '', '') ;
	$formulaire->construitFormulaire(str_replace ('&amp;', '&', $GLOBALS['ins_url']->getURL())) ;
	$msg = '';
	if (isset($_REQUEST['ajouter_v'])) {
		if ($formulaire->validate()) {
			$id_utilisateur = insertion($formulaire->getSubmitValues()) ;
			
			// Appel des actions desinscriptions des applications clientes
	        $d = dir(GEN_CHEMIN_CLIENT);
			while (false !== ($repertoire = $d->read())) {
				if (file_exists(GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.inscription.inc.php'))
				include_once GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.inscription.inc.php' ;
				$msg .= GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.inscription.inc.php<br />';
			}
			$d->close();
			if (INS_CHAMPS_LETTRE != '' && isset ($valeurs['lettre'])) {
				inscription_lettre(INS_MAIL_INSCRIPTION_LISTE) ;
			}
			if (!isset ($msg)) $msg = ''; 
		    return $msg.mkengine();
        } 
	}
	return $formulaire->toHTML();	
}
?>
