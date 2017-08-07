<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of Integrateur Wikini.                                                             |
// |                                                                                                      |
// | Foobar is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | Foobar is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: iw_integrateur.fonct.php,v 1.19 2006-08-29 20:22:41 ddelon Exp $
/**
* Fonctions de l'integrateur de page Wikini
*
* Application permettant d'intégrer des pages wikini dans Papyrus.
*
*@package IntegrateurWikini
//Auteur original :
*@author        David Delon <david.delon@clapas.net>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.19 $ $Date: 2006-08-29 20:22:41 $
*
// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+




/** Inclusion de la classe PEAR de gestion des URL. */

$GLOBALS['_PAPYRUS_']['erreur']->setActive(0);

require_once PAP_CHEMIN_API_PEAR.'Net/URL.php';

// TODO : un seul fichier de configuration ?
/** Inclusion du fichier de configuration de cette application.*/
require_once 'client/integrateur_wikini/configuration/adwi_configuration.inc.php';

require_once ADWI_CHEMIN_BIBLIOTHEQUE.'adwi_wikini.fonct.php';

/** Inclusion du fichier de configuration général de IntegrateurWikini.*/
require_once 'client'.GEN_SEP.'integrateur_wikini'.GEN_SEP.'configuration'.GEN_SEP.'iw_config.inc.php';

/** Inclusion du fichier permettant d'encoder du texte mais pas les balises XHTML.*/
require_once IW_CHEMIN_BIBLIO.'iw_encodage.fonct.php';
/** Inclusion du fichier permettant d'inclure les données dans du XHTML.*/
require_once IW_CHEMIN_BIBLIO.'iw_affichage_xhtml.fonct.php';

global $wikini_config_defaut;
global $wiki;
global $wiki_p;

// $_REQUEST['wiki'] est obligatoire, car wakka.php envoie un redirect si non detecté, avec perte de tout l'environnement !

if ( ! isset( $_REQUEST['wiki'] ) ) {
	    $_REQUEST['wiki'] = $wikini_config_defaut['root_page'];
}

$server=$_SERVER['PHP_SELF'];
$_SERVER['PHP_SELF']="wakka.php";

// Utilise le wakkaconfig de la racine ...
// TODO : un wiki par défaut pour chaque papyrus à l'installation de Papyrus
// TODO : verifier bon dimensionnement des champs et clef de la table papyrus_wiki
// TODO : creation des tables par defaut à l'installation d'un wikini
// TODO : Fusion des fichiers de configuration ?

//echo IW_CHEMIN_WIKINI_COURANT.'wakka.php';
if (!file_exists(IW_CHEMIN_WIKINI_COURANT.'wakka.php')) {
	if (GEN_DEBOGAGE) {
            $GLOBALS['_GEN_commun']['debogage_info'] .=
                'ERREUR Papyrus : le fichier '.IW_CHEMIN_WIKINI_COURANT.'wakka.php n\'existe pas.<br />'.
                'Identifiant : '. $id_fichier .'<br />'.
                'Ligne n° : '. __LINE__ .'<br />'.
                'Fichier : '. __FILE__;
    }
    return  ;
}
ob_start();
include_once IW_CHEMIN_WIKINI_COURANT.'wakka.php';
include_once(IW_CHEMIN_WIKINI_COURANT."/formatters/tableaux.php");
include_once(IW_CHEMIN_WIKINI_COURANT."/actions/attach.class.php");

ob_end_clean();
$_SERVER['PHP_SELF']=$server;


// On surcharge la classe Wiki pour en faire ce qu'on en veut
Class Wiki_Papyrus extends Wiki {


	function Header() {

		return;
	}

 	function Footer() {
 		echo  "<div class=\"footer\">";
		echo  $this->HasAccess("write") ? "<a href=\"".$this->href("edit")."\" title=\"Cliquez pour modifier cette page.\">Modifier cette page</a> ::\n" : "";
		echo  $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"Cliquez pour voir les derni&egrave;res modifications sur cette page.\">".$this->GetPageTime()."</a> ::\n" : "";
		// 	if this page exists
		if ($this->page)
		{
		// if owner is current user
			if ($this->UserIsOwner())
			{
				echo
				"Propri&eacute;taire&nbsp;: vous :: \n",
				"<a href=\"",$this->href("acls")."\" title=\"Cliquez pour modifer les permissions de cette page.\">&Eacute;diter permissions</a> :: \n",
				"<a href=\"",$this->href("deletepage")."\">Supprimer</a> :: \n";
			}
			else
			{
				if ($owner = $this->GetPageOwner())
				{
					echo "Propri&eacute;taire : ",$this->Format($owner);
				}
				else
				{
					echo "Pas de propri&eacute;taire ";
					echo ($this->GetUser() ? "(<a href=\"".$this->href("claim")."\">Appropriation</a>)" : "");
				}
				echo " :: \n";
			}
		}
		echo "Vous &ecirc;tes ";
		echo $this->Format($this->GetUserName());
		echo "</div>";

 	}

	function FormOpen($method = "", $tag = "", $formMethod = "post") {

	// Le diff ne fonctionne pas avec la methode get dans papyrus. On surcharge avec du post.

		if (($method=="diff") && $formMethod=="get") {
			$formMethod="post";
		}

		if ($method=="edit") {
            $result = "<form id=\"ACEditor\" name=\"ACEditor\" action=\"".$this->href($method, $tag)."\" method=\"".$formMethod."\">\n";
            return $result;
		}

		return parent::FormOpen($method,$tag, $formMethod);

	}
	// Detournement des handlers : comme ca on peut faire ce que l'on veut ....
	function Method($method) {

		if ($method=="xml") {
			header("Content-type: text/xml");
			if ($pages = $this->LoadRecentlyChanged(50)) {
		
				$link=ereg_replace('&','&amp;',$this->Href());	            
			    $output = "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\n";
			    $output .= '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">' . "\n";
			    $output .= "<channel>\n";
			    $output .= "<title> Derniers changements sur ". $this->config["wakka_name"]  . "</title>\n";
			    $output .= "<link>" .  $link . "</link>\n";
			    $output .= "<description> Derniers changements sur " . $this->config["wakka_name"] . " </description>\n";
			    $output .= "<language>fr</language>\n";
			    $output .= '<generator>WikiNi ' . WIKINI_VERSION . "</generator>\n";
			    foreach ($pages as $i => $page)
			    {
			        $output .= "<item>\n";
			        $output .= "<title>" . $page["tag"] . "</title>\n";
			        $output .= '<dc:creator>' . $page["user"] . "</dc:creator>\n";
			        $output .= '<pubDate>' . date("r", strtotime($page['time'])) . "</pubDate>\n";
			        $output .= "<description> Modification de " . $page["tag"] . " --- par " .$page["user"] /* . " le " . $day ." - ". $hh .":". $mm */ . "</description>\n";
			        $link=ereg_replace('&','&amp;',$this->Href("",$page["tag"]));
			        $output .= "<link>" . $link . "&amp;time=" . rawurlencode($page["time"]) . "</link>\n";
			        $output .= "</item>\n";
			    }
			    $output .= "</channel>\n";
			    $output .= "</rss>\n";
			    echo $output ;

			}
			exit;
			return;
		}

		if ($method=="edit") {
			
			if ($this->HasAccess("write") && $this->HasAccess("read")) {
		
				$result='';
		
				if ($_POST) {
					if ($_POST["submit"] == "Sauver")	{
					// check for overwriting
						if ($this->page) {
							if ($this->page["id"] != $_POST["previous"]) {
								$error = "ALERTE : ".
								"Cette page a &eacute;t&eacute; modifi&eacute;e par quelqu'un d'autre pendant que vous l'&eacute;ditiez.<br />\n".
								"Veuillez copier vos changements et r&eacute;&eacute;diter cette page.\n";
							}
						}
						// store
						if (!$error) {
							$body = str_replace("\r", "", $_POST["body"]);
							// test si la nouvelle page est differente de la précédente
							if(rtrim($body)==rtrim($this->page["body"])) {
								$this->SetMessage("Cette page n\'a pas &eacute;t&eacute; enregistr&eacute;e car elle n\'a subi aucune modification.");
								$this->Redirect($this->href());
							}
		
							// add page (revisions)
							$this->SavePage($this->tag, $body);
		
							// now we render it internally so we can write the updated link table.
							$this->ClearLinkTable();
							$this->StartLinkTracking();
							$dummy = $this->Header();
							$dummy .= $this->Format($body);
							$dummy .= $this->Footer();
							$this->StopLinkTracking();
							$this->WriteLinkTable();
							$this->ClearLinkTable();
		
							// forward
							$this->Redirect($this->href());
						}
					}
				}
		
				// fetch fields
				if (!$previous = $_POST["previous"]) $previous = $this->page["id"];
				if (!$body = $_POST["body"]) $body = $this->page["body"];
		
				// preview?
				if ($_POST["submit"] == "Aperçu")
				{
					$result .=
						"<div class=\"prev_alert\"><strong>Aper&ccedil;u</strong></div>\n".
						$this->Format($body)."\n\n".
						$this->FormOpen("edit").
						"<input type=\"hidden\" name=\"previous\" value=\"".$previous."\" />\n".
						"<input type=\"hidden\" name=\"body\" value=\"".htmlentities($body)."\" />\n".
						"<br />\n".
						"<input name=\"submit\" type=\"submit\" value=\"Sauver\" accesskey=\"s\" />\n".
						"<input name=\"submit\" type=\"submit\" value=\"R&eacute;&eacute;diter \" accesskey=\"p\" />\n".
						"<input type=\"button\" value=\"Annulation\" onclick=\"document.location='".$this->href("")."';\" />\n".
						$this->FormClose()."\n";
					return $result;
				}
				else
				{
					$ACbuttonsBar='';
				    require_once(IW_CHEMIN_BIBLIO_ACEDITOR."ACeditor.buttonsBar.php");
		
					$result .=
					$this->FormOpen("edit").
					"<input type=\"hidden\" name=\"previous\" value=\"".$previous."\" />\n".$ACbuttonsBar.
					"<textarea onkeydown=\"fKeyDown()\" name=\"body\" cols=\"60\" rows=\"40\" wrap=\"soft\" class=\"edit\">\n".
					htmlspecialchars($body).
					"\n</textarea><br />\n".'<div class="boutons_wiki">'.
					($this->config["preview_before_save"] ? "" : "<input name=\"submit\" type=\"submit\" value=\"Sauver\" accesskey=\"s\" />\n").
					"<input name=\"submit\" type=\"submit\" value=\"Aper&ccedil;u\" accesskey=\"p\" />\n".
					"<input type=\"button\" value=\"Annulation\" onclick=\"document.location='".$this->href("")."';\" /></div>\n".
					$this->FormClose();
		
					return $result;
				}
		
			}
			else {
				echo "<i>Vous n'avez pas acc&egrave;s en &eacute;criture &agrave; cette page !</i>\n";
				
			}
		}
		else {
			return parent::Method($method);
		}
	}


	// Surcharge Format a cause probleme de chemin.

	function Format($text, $formatter = "wakka") {
		return $this->IncludeBuffered(IW_CHEMIN_WIKINI_COURANT_FORMATTER.$formatter.".php", "<i>Impossible de trouver le formateur \"$formatter\"</i>", compact("text"));
	}


	// Identification

	function SetUser($user, $remember) {
			// Appel à partir de Papyrus
				if ($user=='initwiki') {
					$remember=1;
					$wiki_prenom=$this->versChatMot($GLOBALS['_GEN_commun']['pear_auth']->getAuthData($GLOBALS['_GEN_commun']['info_auth_bdd']->chp_personne_prenom));
					$wiki_nom=$this->versChatMot($GLOBALS['_GEN_commun']['pear_auth']->getAuthData($GLOBALS['_GEN_commun']['info_auth_bdd']->chp_personne_nom));
					$_SESSION["user"]=array("name"=>$wiki_prenom.$wiki_nom,"password"=>"wikini","changescount"=> 100);
					$this->SetPersistentCookie("name", $user["name"], $remember);
					$this->SetPersistentCookie("password", $user["password"], $remember);
					$this->SetPersistentCookie("remember", $remember, $remember);
				}
				else {
					parent::Setuser($user,$remember);
				}

	}

	function LoadUser($name, $password = 0) {
		 return true; 
	}

	function LogoutUser() {
		$_SESSION["user"]="";
		$this->DeleteCookie("remember");
		parent::LogoutUser();
	}
	
	

	function versChatMot($entree) {
		$sortie = strtolower(trim(strtr($entree, "àâéêèëîïôöùûüç-", "aaeeeeiioouuuc ")));
		$sortie = ucwords($sortie);
		$sortie = str_replace(" ", "",$sortie);
		return $sortie;
	}

}



// Appel du fichier de traduction des textes de l'application Integrateur Wikini
if (file_exists(IW_CHEMIN_LANGUES.'iw_langue_'.IW_I18N.'.inc.php')) {
    /** Inclusion du fichier de traduction de l'application Integrateur Wikini. */
    include_once IW_CHEMIN_LANGUES.'iw_langue_'.IW_I18N.'.inc.php';
} else {
    /** Inclusion du fichier de traduction fr par défaut. */
    include_once IW_CHEMIN_LANGUES.'iw_langue_fr.inc.php';
}

$GLOBALS['_PAPYRUS_']['erreur']->setActive(1);
/**
 *
 * Fonction afficherPageMenuWikini()
 *
 * Renvoie le contenu de la page Menu de Wikini
 *
 * @return string
 * @access public
 */

function afficherPageMenuWikini()
{

	$GLOBALS['_PAPYRUS_']['erreur']->setActive(0);

	global $wiki;
	global $wikini_config_defaut;
	$sortie='';
    $wakkaConfig = $GLOBALS['wikini_config_defaut'];
    if (!class_exists('Wiki_Papyrus')) return ;
    $wiki  = new Wiki_Papyrus($wakkaConfig);

    // Suppression des slash.
    $_REQUEST['wiki'] = preg_replace("/^\//", '',  $_REQUEST['wiki']);

    // split into page/method
    $matches='';
    if ( preg_match( "#^(.+?)/(.*)$#",  $_REQUEST['wiki'], $matches ) ) {
        list(, $page, $method) = $matches;
    } else if ( preg_match( "#^(.*)$#",  $_REQUEST['wiki'], $matches ) ) {
        list(, $page) = $matches;
    }

    $server=$_SERVER['PHP_SELF'];
	$_SERVER['PHP_SELF']="wakka.php";

    $contenu=$wiki->LoadPage("PageMenu");

    $sortie.="<div id=\"menu_wikini\">";
	$sortie.=$wiki->Format($contenu['body']);
	$sortie.="</div>";

	$_SERVER['PHP_SELF']=$server;

	$GLOBALS['_PAPYRUS_']['erreur']->setActive(1);

	return $sortie;

}


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction afficherPageWikini() - Fonction appelé par le gestionnaire Papyrus.
*
* Elle retourne le contenu de l'application.
*
* @return  string  du code XHTML correspondant au contenu renvoyé par l'application.
*/
function afficherPageWikini()
{
	

	$GLOBALS['_PAPYRUS_']['erreur']->setActive(0);

	// Ajout d'une feuille de style externe
	GEN_stockerStyleExterne ('wikini', 'client/integrateur_wikini/presentations/styles/wikini.css') ;

	global $wiki;
	global $wikini_config_defaut;
	$sortie='';
    $wakkaConfig = $GLOBALS['wikini_config_defaut'];
    if (!class_exists ('Wiki_Papyrus')) return ; 
    $wiki  = new Wiki_Papyrus($wakkaConfig);

	if  ($GLOBALS['_GEN_commun']['pear_auth']->checkAuth()) {
	//	if (!isset($_SESSION["user"]) || ($_SESSION["user"]=="")) {
			$wiki->SetUser('initwiki');
	//	}
	}
	else {
		$wiki->LogoutUser();
	}

	// Gestion de la variable de session "linktracking"
    if ( ! isset( $_SESSION['linktracking'] ) ) {
        $_SESSION['linktracking'] = 1;
    }

    // Suppression des slash.
    $_REQUEST['wiki'] = preg_replace("/^\//", '',  $_REQUEST['wiki']);

    // split into page/method
    $matches='';
    if ( preg_match( "#^(.+?)/(.*)$#",  $_REQUEST['wiki'], $matches ) ) {
        list(, $page, $method) = $matches;
    } else if ( preg_match( "#^(.*)$#",  $_REQUEST['wiki'], $matches ) ) {
        list(, $page) = $matches;
    }

    // Vérification de la méthode d'affichage employée!
    if ( ! isset( $method ) ) {
        $method = '';
    }

    //Récupération du contenu de la page Wikini

    ob_start();

    $server=$_SERVER['PHP_SELF'];
	$_SERVER['PHP_SELF']="wakka.php";

	$wiki->Run($page, $method);

    $_SERVER['PHP_SELF']=$server;

    $sortie.= ob_get_contents();
    ob_end_clean();

	$GLOBALS['_PAPYRUS_']['erreur']->setActive(1);

	if ($method!="edit") {
		return remplacerEntiteHTLM("<script type=\"text/javascript\" src=\"".IW_CHEMIN_BIBLIO_ACEDITOR."ACeditor.js\"></script><div id=\"wikini_page\"  ondblclick=\"document.location='".$wiki->href("edit")."';"."\">"."\n".$sortie.'</div>'."\n");
	}
	else {
		return remplacerEntiteHTLM("<script type=\"text/javascript\" src=\"".IW_CHEMIN_BIBLIO_ACEDITOR."ACeditor.js\"></script><div id=\"wikini_page\">"."\n".$sortie.'</div>'."\n");
	}
	
	
}

?>