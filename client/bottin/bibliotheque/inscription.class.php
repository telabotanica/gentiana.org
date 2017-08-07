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
// CVS : $Id: inscription.class.php,v 1.23 2007-06-26 09:32:33 neiluj Exp $
/**
* Inscription
*
* Un module d'inscription, en general ce code est specifique a
* un site web
*
*@package inscription
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.23 $ $Date: 2007-06-26 09:32:33 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm.php' ;

class ListeDePays extends PEAR{

    var $_db ;
    /** Constructeur
     *  Verifie l'existance de la table gen_pays_traduction
     *
     *  @param  DB  Un objet PEAR::DB
     * @return
     */
    
    function ListeDePays(&$objetDB) {
        $this->_db = $objetDB ;
        $requete = 'SHOW TABLES';
        $resultat = $objetDB->query ($requete) ;
        if (DB::isError ($resultat)) {
            die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
        }
        while ($ligne = $resultat->fetchRow()) {
            if ($ligne[0] == INS_TABLE_PAYS) {
                return ;
            }
        }
        return $this->raiseError('La table gen_i18n_pays n\'est pas presente dans la base de donnee !') ;
    }
    
    /** Renvoie la liste des pays traduite
     *
     *  @param  string  une chaine de type i18n ou une chaine code iso langue (fr_FR ou fr ou FR)
     * @return  un tableau contenant en cle, le code iso du pays, en majuscule et en valeur le nom du pays traduit
     */
    function getListePays($i18n) {
	    if (strlen($i18n) == 2) {
		    $i18n = strtolower($i18n)."-".strtoupper($i18n) ;
	    }
	    $requete = 'select '.INS_CHAMPS_ID_PAYS.', '.INS_CHAMPS_LABEL_PAYS.' from '.INS_TABLE_PAYS
							.' where '.INS_CHAMPS_I18N_PAYS.'="'.$i18n.'"';
	    $resultat = $this->_db->query($requete) ;
	    
	    if (DB::isError($resultat)) {
		    die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
	    }
	    if ($resultat->numRows() == 0) {
		    return $this->raiseError('Le code fourni ne correspond a aucun pays ou n\'est pas dans la table!') ;
	    }
	    $retour = array() ;
	    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
		    $retour[$ligne[INS_CHAMPS_ID_PAYS]] = $ligne[INS_CHAMPS_LABEL_PAYS] ;
	    }
	    return $retour ;
    }
    
    /** Renvoie le nom d'un pays traduit dans la langue passï¿½ en paramï¿½tre
     *
     *  @param  string  une chaine de type i18n ou une chaine code iso langue (fr_FR ou fr ou FR)
     * @return  un tableau contenant en cle, le code iso du pays, en majuscule et en valeur le nom du pays traduit
     */
    function getNomPays($codeIso, $i18n = INS_LANGUE_DEFAUT) {
	    if (strlen($i18n) == 2) {
		    $i18n = strtolower($i18n)."-".strtoupper($i18n) ;
	    }
	    $requete = 'select '.INS_CHAMPS_LABEL_PAYS.' from '.INS_TABLE_PAYS.
							' where '.INS_CHAMPS_I18N_PAYS.'="'.$i18n.'" and '.
							INS_CHAMPS_ID_PAYS.'="'.$codeIso.'"';
	    $resultat = $this->_db->query($requete) ;
	    
	    if (DB::isError($resultat)) {
		    die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
	    }
	    if ($resultat->numRows() == 0) {
		    return $this->raiseError('Le code fourni ne correspond a aucun pays ou n\'est pas dans la table!') ;
	    }
	    $ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC) ;
	    return $ligne[INS_CHAMPS_LABEL_PAYS] ;
    }
}

class HTML_formulaireInscription extends HTML_Quickform {

    
    /**
     *  Constructeur
     *
     * @param string formName Le nom du formulaire
     * @param string method Methode post ou get
     * @param string action L'action du formulaire.
     * @param int target La cible.
     * @param Array attributes Les attributs HTML en plus.
     * @param bool trackSubmit ??
     * @return void
     * @access public
     */
    
    function HTML_formulaireInscription( $formName,  $method = "post",  $action,  $target = "_self",  $attributes,  $trackSubmit = false ) {
        HTML_Quickform::HTML_Quickform($formName, $method, $action, $target, $attributes, $trackSubmit) ;
    }
   
    /**
     * 
     *
     * @return void
     * @access public
     */
    function construitFormulaire($url)
    {
		$squelette =& $this->defaultRenderer();
   		$squelette->setFormTemplate("\n".'<form {attributes}>'."\n".'<table style="border:0;width:100%;">'."\n".'{content}'."\n".'</table>'."\n".'</form>'."\n");
    	$squelette->setElementTemplate( '<tr>'."\n".
										'<td style="font-size:12px;width:140px;text-align:right;">'."\n".'{label}'.
										'<!-- BEGIN required --><span class="symbole_obligatoire">&nbsp;*</span><!-- END required -->'."\n".
										' :</td>'."\n".
										'<td style="text-align:left;padding:5px;"> '."\n".'{element}'."\n".
										'<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
										'</td>'."\n".
										'</tr>'."\n");  	  	
  	  	$squelette->setElementTemplate( '<tr><td colspan="2" style="font-size:12px;text-align:left;">{label}{element}</td></tr>'."\n", 'lettre');
        $squelette->setElementTemplate( '<tr><td colspan="2" style="font-size:12px;text-align:left;">{label}{element}</td></tr>'."\n", 'visible');
        $squelette->setElementTemplate( '<tr><td colspan="2" class="bouton" id="bouton_annuler">{label}{element}</td></tr>'."\n", 'groupe_bouton');        
        $squelette->setGroupTemplate('<tr><td colspan="2">{content}</td></tr>'."\n", 'groupe_bouton');
        $squelette->setRequiredNoteTemplate("\n".'<tr>'."\n".'<td colspan="2" class="symbole_obligatoire">* {requiredNote}</td></tr>'."\n");
		//Traduction de champs requis
		$this->setRequiredNote(INS_CHAMPS_REQUIS) ;
		$this->setJsWarnings(INS_ERREUR_SAISIE,INS_VEUILLEZ_CORRIGER);
	/*	
		$script = '
	        // Variables globales
	        var map = null;
	    	var geocoder = null;
			var lat = document.getElementById("latitude");
	        var lon = document.getElementById("longitude");
	        
	        function load() {
	        if (GBrowserIsCompatible()) {
	          map = new GMap2(document.getElementById("map"));
	          map.addControl(new GSmallMapControl());
			  map.addControl(new GMapTypeControl());
			  map.addControl(new GScaleControl());
			  map.enableContinuousZoom();
			
			  // On centre la carte sur le languedoc roussillon
			  center = new GLatLng(43.84245116699036, 3.768310546875);
	          map.setCenter(center, 7);
			  //marker = new GMarker(center, {draggable: true}) ;
	          GEvent.addListener(map, "click", function(marker, point) {
	  		    if (marker) {
	    	      map.removeOverlay(marker);
	    	      var lat = document.getElementById("latitude");
	              var lon = document.getElementById("longitude");
	    	      lat.value = "";
	              lon.value = "";
			    } else {
			      // On ajoute un marqueur a l endroit du clic et on place les coordonnees dans les champs latitude et longitude
			      marker = new GMarker(point, {draggable: true}) ;
			      GEvent.addListener(marker, "dragend", function () {
	                coordMarker = marker.getPoint() ;
	                var lat = document.getElementById("latitude");
	                var lon = document.getElementById("longitude");
		            lat.value = coordMarker.lat();
	                lon.value = coordMarker.lng();
	              });
		          map.addOverlay(marker);
		          setLatLonForm(marker);
	  		    }
	        });' ;
	        
			if($_REQUEST['action'] == 'modifier') {
				$requete_defaut = 'select a_longitude, a_latitude from annuaire where a_id='.$GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID);
				$resultat_defaut = $GLOBALS['ins_db']->query($requete_defaut);
				$ligne = $resultat_defaut->fetchRow(DB_FETCHMODE_OBJECT) ;
				if ($ligne->a_latitude != '' && $ligne->a_longitude != '') {
					$script .= '
							point = new GLatLng('.$ligne->a_latitude.', '.$ligne->a_longitude.');
							marker = new GMarker(point, {draggable: true});
							map.addOverlay(marker);' ;
				} 
			}
		    $script .= 'geocoder = new GClientGeocoder();
	    };' .
	    		'}
	    function showAddress() {
	      var adress_1 = document.getElementById("a_adresse1").value ;
	      var adress_2 = document.getElementById("a_adresse2").value ;
	      var ville = document.getElementById("a_ville").value ;
	      var cp = document.getElementById("a_code_postal").value ;
	      if (document.getElementById("a_ce_pays").type == "select-one") {
	      	var selectIndex = document.getElementById("a_ce_pays").selectedIndex;
	      	var pays = document.getElementById("a_ce_pays").options[selectIndex].text ;
	      } else {
	      	var pays = document.getElementById("a_ce_pays").value;
	      }
	      
	      var address = adress_1 + \' \' + adress_2 + \' \' + \' \' + cp + \' \' + ville + \' \' +pays ;
	      if (geocoder) {
	        geocoder.getLatLng(
	          address,
	          function(point) {
	            if (!point) {
	              alert(address + " not found");
	            } else {
	              map.setCenter(point, 13);
	              var marker = new GMarker(point, {draggable: true});
	              GEvent.addListener(marker, "dragend", function () {
	      coordMarker = marker.getPoint() ;
	      var lat = document.getElementById("latitude");
	      var lon = document.getElementById("longitude");
		  lat.value = coordMarker.lat();
	      lon.value = coordMarker.lng();
	    });
	
	              map.addOverlay(marker);
	              setLatLonForm(marker)
	              marker.openInfoWindowHtml(address+ "'.INS_GOOGLE_MSG.'");
	            }
	          }
	        );
	      }
	    }
	    function setLatLonForm(marker) {
	      coordMarker = marker.getPoint() ;
	      var lat = document.getElementById("latitude");
	      var lon = document.getElementById("longitude");
		  lat.value = coordMarker.lat();
	      lon.value = coordMarker.lng();
	    }
	    ';
	    */
		// Mise en place du systeme de template du bazar
		include_once GEN_CHEMIN_API.'/formulaire/formulaire.fonct.inc.php';
		$tableau= formulaire_valeurs_template_champs($GLOBALS['ins_config']['ic_inscription_template']);

		if (isset ($_REQUEST['action']) && $_REQUEST['action']=='modifier') {
			//Ajout des valeurs par defaut
			$requete_defaut = 'select * from annuaire where a_id='.$GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID);
			$resultat_defaut = $GLOBALS['ins_db']->query($requete_defaut);
			$valeurs_par_defaut = $resultat_defaut->fetchRow(DB_FETCHMODE_ASSOC);
			
			for ($i=0; $i<count($tableau); $i++) {
				if ( $tableau[$i]['type']=='liste' || $tableau[$i]['type']=='checkbox' ) {
					if (is_int ($tableau[$i]['nom_bdd'])) $def=$tableau[$i]['type'].$tableau[$i]['nom_bdd'];
							else $def = $tableau[$i]['nom_bdd'];
				}
				elseif ( $tableau[$i]['type']=='texte' || $tableau[$i]['type']=='textelong' || 
							$tableau[$i]['type']=='listedatedeb' || $tableau[$i]['type']=='listedatefin' ||
							 $tableau[$i]['type']=='champs_mail' || $tableau[$i]['type']=='champs_cache') {
					$def=$tableau[$i]['nom_bdd'];					
				} elseif ($tableau[$i]['type']=='carte_google') {
					$def = 'carte_google';
					$valeurs_par_defaut[$def] = array ('latitude' => $valeurs_par_defaut[$tableau[$i]['limite1']], 
												'longitude' => $valeurs_par_defaut[$tableau[$i]['limite2']]);
					GEN_stockerCodeScript($script);
				}
				$tableau[$i]['type']($this, $tableau[$i]['nom_bdd'], $tableau[$i]['label'], $tableau[$i]['limite1'],
			                         $tableau[$i]['limite2'], $valeurs_par_defaut[$def], $tableau[$i]['table_source'], 
			                         $tableau[$i]['obligatoire']) ;		           
			}
		}
		else {
			for ($i=0; $i<count($tableau); $i++) {
				if ($tableau[$i]['type'] == 'carte_google') {
					GEN_stockerCodeScript($script);	
				}
				$tableau[$i]['type']($this, $tableau[$i]['nom_bdd'], $tableau[$i]['label'], $tableau[$i]['limite1'],
			                         $tableau[$i]['limite2'], $tableau[$i]['defaut'], $tableau[$i]['table_source'], $tableau[$i]['obligatoire']) ;
			 }
		}
		
        $debut = inscription::getTemplate(INS_TEMPLATE_TITRE_FORMULAIRE, $GLOBALS['ins_config']['ic_id_inscription'])."\n";
        $this->addElement('html', $debut);
        /*
        $this->addElement('text', 'email', INS_EMAIL) ;
        $this->addRule('email', INS_EMAIL_REQUIS, 'required','', 'client') ;
        $this->addRule('email', INS_MAIL_INCORRECT, 'email', '', 'client') ; 
        /*       
        $this->addElement('password', 'mot_de_passe', INS_MOT_DE_PASSE, array('size' => '10')) ;
        $this->addElement('password', 'mot_de_passe_repete', INS_REPETE_MOT_DE_PASSE, array('size' => '10')) ;
        $this->addRule('mot_de_passe', INS_MOT_DE_PASSE_REQUIS, 'required', '', 'client') ;
        $this->addRule('mot_de_passe_repete', INS_MOT_DE_PASSE_REQUIS, 'required', '', 'client') ;
        $this->addRule(array ('mot_de_passe', 'mot_de_passe_repete'), INS_MOTS_DE_PASSE_DIFFERENTS, 'compare', '', 'client') ;

        $this->addElement('text', 'nom', INS_NOM) ;
        $this->addRule('nom', INS_NOM_REQUIS, 'required', '', 'client') ;
        $this->addElement('text', 'prenom', INS_PRENOM) ;
        $this->addRule('prenom', INS_PRENOM_REQUIS, 'required', '', 'client') ;
        if ($GLOBALS['ins_config']['ic_utilise_nom_wiki'] && ! $GLOBALS['ins_config']['ic_genere_nom_wiki']) {
        		$this->addElement('text', 'nomwiki', INS_NOM_WIKI, array('id' => 'nom_wiki')) ;
        }
        $this->addElement('text', 'adresse_1', INS_ADRESSE_1, array('id' => 'adresse_1')) ;
        $this->addElement('text', 'adresse_2', INS_ADRESSE_2, array('id' => 'adresse_2')) ;
        $this->addElement('text', 'cp', INS_CODE_POSTAL, array('id' => 'cp')) ;
        $this->addRule('cp', INS_CODE_POSTAL_REQUIS, 'required', '', 'client') ;
        $this->addElement('text', 'ville', INS_VILLE, array('id' => 'ville')) ;
        // L'element pays est construit a partir du tableau liste_pays
        $liste_pays = new ListeDePays($GLOBALS['ins_db']) ;
        $this->addElement('select', 'pays', INS_PAYS, $liste_pays->getListePays(INS_LANGUE_DEFAUT), array('id' => 'pays')) ;
        */
        //$this->addElement('text', 'telephone', INS_TELEPHONE, array('size' => '12')) ;
        //$this->addElement('text', 'fax', INS_FAX, array('size' => '12')) ;
        //$this->addElement('text', 'site', INS_SITE_INTERNET) ;
        /*
        $this->addElement('file', 'image', INS_LOGO_OU_IMAGE) ;
		$this->setMaxFileSize(150000); //logo de 15ko maximum
		*/
        //if (INS_CHAMPS_LETTRE != '') $this->addElement('checkbox', 'lettre',INS_LETTRE, '<br />') ;
        //$this->addElement('checkbox', 'visible',INS_VISIBLE, '<br />') ;
        /*
        $this->addElement('hidden', 'est_structure', 0) ;
        $defauts=array ('lettre'=>1,'pays'=>'FR');
        if (isset ($GLOBALS['ins_config']['ic_google_key']) && $GLOBALS['ins_config']['ic_google_key'] != '') {
	        $this->addElement('button', 'chercher_sur_carte', 'Vérifier mon adresse avec la carte', array("onclick" => "showAddress();"));
	        $this->addElement('html', '<tr><td colspan="2"	><div id="map" style="width: 600px; height: 450px"></div></td></tr>');
	        $this->addElement('text', 'latitude', 'Latitude', array('id' => 'latitude', 'size' => 6, 'readonly' => 'readonly'));
	        $this->addElement('text', 'longitude', 'longitude', array('id' => 'longitude', 'size' => 6, 'readonly' => 'readonly'));
	        
        } 
        */     
        //$this->setDefaults($defauts);	
        // on fait un groupe avec les boutons pour les mettres sur la meme ligne
        $boutons[] = &HTML_QuickForm::createElement('button', 'annuler', INS_ANNULER, array ("onclick" => "javascript:document.location.href='".$url."'",
        												'id' => 'annuler', 'class' => 'bouton'));
        $boutons[] = &HTML_QuickForm::createElement('submit', 'valider', INS_VALIDER, array ('id' => 'valider', 'class' =>'bouton'));
        $this->addGroup($boutons, 'groupe_bouton', '', "\n");
        
        if (isset ($GLOBALS['ins_config']['ic_google_key']) && $GLOBALS['ins_config']['ic_google_key'] != '') {
        	GEN_stockerFichierScript('googleMapScript', $GLOBALS['ins_config']['ic_google_key']);
        	
        	
	        
	    
        }
    } // end of member function construitFormulaire
    
    /** Modifie le formulaire pour l'adapter au cas des structures
     * 
     *
     * @return void
     * @access public
     */
    function formulaireStructure()
    {
        /*
        $this->removeElement('nom', false) ;
        $this->removeElement('prenom') ;
        $this->removeElement('email', false) ;
        $this->removeElement('telephone', false) ;
        $nom_structure = & HTML_QuickForm::createElement('text', 'nom', INS_NOM_STRUCTURE) ;
        $this->insertElementBefore($nom_structure, 'mot_de_passe') ;
        
        $mail = & HTML_QuickForm::createElement('text', 'email', INS_MAIL_STRUCTURE) ;
        $this->insertElementBefore($mail, 'mot_de_passe') ;
        
        $this->addRule('nom', INS_NOM_REQUIS, 'required', '', 'client') ;
        /*
        $sigle_structure = & HTML_QuickForm::createElement('text', 'sigle_structure', INS_SIGLE_DE_LA_STRUCTURE) ;
        $this->insertElementBefore($sigle_structure, 'email') ;
        */
        // not required
        //$this->addRule('sigle_structure', INS_SIGLE_REQUIS, 'required', '', 'client') ;
        
        // what's this ?
        //$num_agrement = & HTML_QuickForm::createElement('text', 'num_agrement', INS_NUM_AGREMENT) ;
        //$this->insertElementBefore($num_agrement, 'email') ;
        /*
        $telephone = & HTML_QuickForm::createElement('text', 'telephone', INS_TELEPHONE_STRUCTURE) ;
        $this->insertElementBefore($telephone, 'lettre') ;
        $fax = & HTML_QuickForm::createElement('text', 'fax', INS_FAX_STRUCTURE) ;
        $this->insertElementBefore($fax, 'lettre') ;
        
        $this->removeElement('site', false) ;
        $site_structure = & HTML_QuickForm::createElement('text', 'site', INS_SITE_STRUCTURE) ;
        $this->insertElementBefore($site_structure, 'lettre') ;
        
        // bloc contact
        $coord = & HTML_QuickForm::createElement('html', '<tr><td colspan="2"><strong>'.INS_COORD_CONTACT.'</strong></td></tr>') ;
        $nom = & HTML_QuickForm::createElement('text', 'nom_contact', INS_NOM_CONTACT) ;
        $prenom = & HTML_QuickForm::createElement('text', 'prenom_contact', INS_PRENOM_CONTACT) ;
        $poste = & HTML_QuickForm::createElement('text', 'poste_contact', INS_POSTE_CONTACT) ;
        $tel = & HTML_QuickForm::createElement('text', 'tel_contact', INS_TEL_CONTACT) ;
		$this->insertElementBefore($coord, 'lettre') ;
		$this->insertElementBefore($nom, 'lettre') ;
		$this->insertElementBefore($prenom, 'lettre') ;
		$this->insertElementBefore($poste, 'lettre') ;
		$this->insertElementBefore($tel, 'lettre') ;
        */
        $separateur = & HTML_QuickForm::createElement('html', '<tr><td colspan="2"><hr /></td></tr>') ;
        $this->insertElementBefore($separateur, 'lettre') ;
        
        //$fax = & HTML_QuickForm::createElement('text', 'fax', INS_FAX) ;
        //$image = & HTML_QuickForm::createElement('file', 'image', INS_LOGO_OU_IMAGE) ;
        
		//$this->insertElementBefore($image, 'lettre') ;
		//$this->setMaxFileSize(150000); //logo de 150 ko maximum
		
        $this->removeElement('est_structure', false) ;
        $this->addElement('hidden', 'est_structure', 1) ;
        $this->addElement('hidden', 'form_structure', 1) ;
        
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

?>
