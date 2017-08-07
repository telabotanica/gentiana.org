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
// CVS : $Id: admin_application.php,v 1.9 2007-08-28 14:02:06 jp_milcent Exp $
/**
* Application gérant les applications de Papyrus
*
* Cette application permet de gérer les applications de papyrus
* elle permet de spécifier pour un monde quel annuaire utiliser
* et de gérer des authentifications de spip et ou wikini
*
*@package Admin_auth
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.9 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_PAP.'applications/admin_application/configuration/adap_configuration.inc.php';

//Utilisation de la bibliothèque PEAR NET_URL

/** Inclusion de la bibliothèque PEAR de conception de formulaire.*/
require_once ADAP_CHEMIN_BIBLIOTHEQUE_PEAR.'HTML/QuickForm.php';
require_once ADAP_CHEMIN_BIBLIOTHEQUE_PEAR.'HTML/QuickForm/select.php';

/** Inclusion de l'API de fonctions gérant les erreurs sql.*/
require_once ADAP_CHEMIN_BIBLIOTHEQUE_API.'debogage/BOG_sql.fonct.php';

/** Inclusion des fonctions de manipulation du sql.
* Permet la récupération d'un nouvel identifiant d'une table.*/
require_once ADAP_CHEMIN_BIBLIOTHEQUE_API.'sql/SQL_manipulation.fonct.php';

require_once ADAP_CHEMIN_BIBLIOTHEQUE_API.'html/HTML_TableFragmenteur.php' ;

/** <BR> Inclusion de la bibliothèque de fonctions concernant les tables "gen_site..." de Papyrus.*/
require_once ADAP_CHEMIN_BIBLIOTHEQUE_GEN.'pap_site.fonct.php';

/** <BR> Inclusion de la bibliothèque de fonctions concernant les tables "gen_menu..." de Papyrus.*/
require_once ADAP_CHEMIN_BIBLIOTHEQUE_GEN.'pap_menu.fonct.php';

/** <BR> Inclusion de la bibliothèque de fonctions concernant les tables "gen_applications..." de Papyrus.*/
require_once ADAP_CHEMIN_BIBLIOTHEQUE_GEN.'pap_application.fonct.php';

/** <BR> Inclusion de la bibliothèque de fonctions concernant l'affichage commun.*/
require_once ADAP_CHEMIN_BIBLIOTHEQUE.'adap_application.fonct.php';

require_once ADAP_CHEMIN_BIBLIOTHEQUE.'HTML_formulaireAppli.class.php' ;


// Inclusion des fichiers de traduction de l'appli ADME dePapyrus
if (file_exists(ADAP_CHEMIN_LANGUE.'adap_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once ADAP_CHEMIN_LANGUE.'adap_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once ADAP_CHEMIN_LANGUE.'adap_langue_'.ADAP_I18N_DEFAUT.'.inc.php';
}

// Stockage des styles de l'application
GEN_stockerStyleExterne('adap_standard', ADAP_CHEMIN_STYLE.'adap_standard.css');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

function afficherContenuCorps()
{
    $db = &$GLOBALS['_GEN_commun']['pear_db'] ;
    $url = $GLOBALS['_GEN_commun']['url'] ;
    $auth = &$GLOBALS['_GEN_commun']['pear_auth'] ;
    
    $res='';
    if (!$auth->getAuth()) {
    	$res .= '<p class="zone_alert">'.ADAP_IDENTIFIEZ_VOUS.'</p>'."\n" ;
		$res .= '<form id="form_connexion" style="clear:both;" class="form_identification" action="' ;
		$res .= $url->getURL();
		$res .= '" method="post">
                <fieldset>
                    <legend>Identifiez vous</legend>                    
                        <label for="username">Courriel : </label>
                        <input type="text"  id="username" name="username" maxlength="80" tabindex="1" value="courriel" />                    
                        <label for="password">Mot de passe : </label>
                        <input type="password" id="password" name="password" maxlength="80" tabindex="2" value="mot de passe" />                    
                        <input type="submit" id="connexion" name="connexion" tabindex="3" value="ok" />                    
                </fieldset>
                </form>';
        return $res ;
    } else {
	    // Le lien pour une nouvelle entrée
	    $url->addQueryString('action', 'nouveau');
	    $url_nouveau = $url->getURL();
	    $url->removeQueryString('action', 'nouveau');
	    $res .= '<a href="'.$url_nouveau.'">'.ADAP_AJOUTER.'</a>'."\n<br />" ;
	    // traitement de la suppression
	    if (isset ($_REQUEST['action']) && $_REQUEST['action'] == 'supprimer') adap_supprimer_application($_REQUEST['id_appl'], $db) ;
	    
	    // traitement de l'ajout
	    if (isset ($_REQUEST['action']) || isset ($_REQUEST['id_appl'])) {
	        $formulaire = new HTML_formulaireAppl('formulaire_appl', '', str_replace ('&amp;', '&', $url->getURL())) ;
	        $formulaire->construitFormulaire($url) ;
	        
	        // On ajoute un champs caché avec action=nouveau_v
	        if (isset ($_REQUEST['action']) && $_REQUEST['action'] == 'nouveau') {
	            $formulaire->addElement ('hidden', 'action', 'nouveau_v') ;
	            return $formulaire->toHTML() ;
	        }
	        if (isset ($_REQUEST['id_appl']) && !isset ($_REQUEST['action'])) {
	            $formulaire->addElement ('hidden', 'action', 'modifier_v') ;
	            $formulaire->addElement ('hidden', 'id_appl', $_REQUEST['id_appl']) ;
	            $formulaire->setDefaults(adap_valeurs_par_defaut($_REQUEST['id_appl'], $db)) ;
	            return $formulaire->toHTML() ;
	        }
	        if ($_REQUEST['action'] == 'modifier_v') {
	            if ($formulaire->validate()) {
	                mise_a_jour ($formulaire->getSubmitValues(), $db) ;
	            }
	        }
	        if ($_REQUEST['action'] == 'nouveau_v') {
	            if ($formulaire->validate()) {
	                insertion ($formulaire->getSubmitValues(), $db) ;
	            }
	        }
	        
	    }
	    // Comportement par défaut
	    // requete sur la table gen_application
	    $requete = 'SELECT gap_id_application, gap_nom FROM gen_application where gap_id_application <> 0 ORDER BY gap_nom ASC' ;
	    
	    $resultat = $db->query ($requete) ;
	    if (DB::isError ($resultat)) {
	        $GLOBALS['_GEN_commun']['debogage_erreur']->gererErreur(E_USER_WARNING, "Echec de la requete : $requete<br />".$resultat->getMessage(),
	                                                                        __FILE__, __LINE__, 'admin_appl')   ;
	        return ;
	    }
	    $liste = new HTML_TableFragmenteur () ;
	    $liste->construireEntete(array (ADAP_NOM_APPL, ADAP_SUPPRIMER)) ;
	    $tableau_appl = array() ;
	    while ($ligne = $resultat->fetchRow()) {
	        $url->addQueryString ('id_appl', $ligne[0]) ;
	        array_push ($tableau_appl, array ('<a href="'.$url->getURL().'">'.$ligne[1].'</a>'."\n",    // Première colonne, le nom de l'application
	                                            '<a href="'.$url->getURL().'&amp;action=supprimer" onclick="javascript:return confirm (\''.ADAP_SUPPRIMER.' ?\');">'.ADAP_SUPPRIMER.'</a>'."\n"
	                                            ));
	    }
	    $liste->construireListe($tableau_appl) ;
	    $res .= $liste->toHTML();
	    return $res ;
    }
}// Fin de la fonction afficherContenuCorps()

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: admin_application.php,v $
* Revision 1.9  2007-08-28 14:02:06  jp_milcent
* Correction bogue des liens lors de la redirection.
*
* Revision 1.8  2007-03-20 14:17:36  alexandre_tb
* remplacement des varaibles $GLOBALS par $_REQUEST, pour que l appli fonctionne avec les register_globals à Off
*
* Revision 1.7  2006/12/01 10:39:14  alexandre_tb
* Suppression des références aux applettes
*
* Revision 1.6  2006/10/06 10:40:51  florian
* harmonisation des messages d'erreur de l'authentification
*
* Revision 1.5  2006/09/07 13:28:39  jp_milcent
* Mise en majuscule des termes SQL et trie des application par ordre alphabétique.
*
* Revision 1.4  2005/03/09 10:46:17  jpm
* Changement d'un nom de fichier.
*
* Revision 1.3  2005/03/09 10:40:26  alex
* version initiale
*
* Revision 1.2  2005/02/28 10:32:59  jpm
* Changement de nom de dossier.
*
* Revision 1.1  2004/12/13 18:07:19  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
