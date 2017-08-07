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
// CVS : $Id: admin_auth.php,v 1.6 2006-10-06 10:40:51 florian Exp $
/**
* Application gérant les authentifications de Papyrus
*
* Cette application permet de gérer les authentifications de papyrus
* elle permet de spécifier pour un monde quel annuaire utiliser
* et de gérer des authentifications de spip et ou wikini
*
*@package Admin_auth
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.6 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_PAP.'applications/admin_auth/configuration/adau_configuration.inc.php';

//Utilisation de la bibliothèque PEAR NET_URL
/** Inclusion de la bibliothèque PEAR de conception de formulaire.*/
require_once ADAU_CHEMIN_BIBLIOTHEQUE_PEAR.'HTML/QuickForm.php';
/** Inclusion de la bibliothèque PEAR de conception de formulaire : select.*/
require_once ADAU_CHEMIN_BIBLIOTHEQUE_PEAR.'HTML/QuickForm/select.php';

/** Inclusion de l'API de fonctions gérant les erreurs sql.*/
require_once ADAU_CHEMIN_BIBLIOTHEQUE_API.'debogage/BOG_sql.fonct.php';
/** Inclusion des fonctions de manipulation du sql.
* Permet la récupération d'un nouvel identifiant d'une table.*/
require_once ADAU_CHEMIN_BIBLIOTHEQUE_API.'sql/SQL_manipulation.fonct.php';
/** Inclusion de la bibliothèque premettant de créer des Tableau HTML fragmentés.*/
require_once ADAU_CHEMIN_BIBLIOTHEQUE_API.'html/HTML_TableFragmenteur.php' ;

/** Inclusion de la bibliothèque de fonctions concernant les tables "gen_site..." de Papyrus.*/
require_once ADAU_CHEMIN_BIBLIOTHEQUE_GEN.'pap_site.fonct.php';
/** Inclusion de la bibliothèque de fonctions concernant les tables "gen_menu..." de Papyrus.*/
require_once ADAU_CHEMIN_BIBLIOTHEQUE_GEN.'pap_menu.fonct.php';
/** Inclusion de la bibliothèque de fonctions concernant les tables "gen_applications..." de Papyrus.*/
require_once ADAU_CHEMIN_BIBLIOTHEQUE_GEN.'pap_application.fonct.php';

/** Inclusion de la bibliothèque de fonctions concernant l'affichage commun.*/
require_once ADAU_CHEMIN_BIBLIOTHEQUE.'adau_auth.fonct.php';
/** Inclusion de la classe créer les formulaire des l'appli.*/
require_once ADAU_CHEMIN_BIBLIOTHEQUE.'HTML_formulaireAuth.class.php' ;


// Inclusion des fichiers de traduction de l'appli ADME dePapyrus
if (file_exists(ADAU_CHEMIN_LANGUE.'adau_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once ADAU_CHEMIN_LANGUE.'adau_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once ADAU_CHEMIN_LANGUE.'adau_langue_'.ADAU_I18N_DEFAUT.'.inc.php';
}

// Stockage des styles de l'application
GEN_stockerStyleExterne('adau_standard', ADAU_CHEMIN_STYLE.'adau_standard.css');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

function afficherContenuCorps()
{
    $db =& $GLOBALS['_GEN_commun']['pear_db'] ;
    $url =& $GLOBALS['_GEN_commun']['url'] ;
    $auth =& $GLOBALS['_GEN_commun']['pear_auth'] ;
    isset ($GLOBALS['action']) ? '' : $GLOBALS['action'] = '' ; // On déclare action si elle n'existe pas
    $res='';
    if (!$auth->getAuth()) {
    	$res .= '<p class="zone_alert">'.ADAU_IDENTIFIEZ_VOUS.'</p>'."\n" ;
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
	    $res = '<a href="'.$url->getURL().'&amp;action=nouveau">'.ADAU_AJOUTER.'</a>'."\n".'<br />';
	    // traitement de la suppression
	    if (isset ($GLOBALS['action']) && $GLOBALS['action'] == 'supprimer') adau_supprimer_authentification($GLOBALS['id_auth'], $db);
	    
	    // Traitement de l'ajout
	    if (isset ($GLOBALS['action']) || isset ($GLOBALS['id_auth'])) {
	        $formulaire = new HTML_formulaireAuth('formulaire_auth', '', str_replace ('&amp;', '&', $url->getURL()));
	        $formulaire->construitFormulaire($url);
	        
	        // On ajoute un champs caché avec action=nouveau_v
	        if ($GLOBALS['action'] == 'nouveau') {
	            $formulaire->addElement ('hidden', 'action', 'nouveau_v');
	            return $formulaire->toHTML();
	        }
	        if (isset ($GLOBALS['id_auth']) && $GLOBALS['action'] != 'modifier_v' && $GLOBALS['action'] != 'supprimer') {
	            $formulaire->addElement ('hidden', 'action', 'modifier_v');
	            $formulaire->addElement ('hidden', 'id_auth', $GLOBALS['id_auth']);
	            $formulaire->setDefaults(adau_valeurs_par_defaut($GLOBALS['id_auth'], $db));
	            return $formulaire->toHTML();
	        }
	        if ($GLOBALS['action'] == 'modifier_v') {
	            if ($formulaire->validate()) {
	                mise_a_jour ($formulaire->getSubmitValues(), $db);
	            }
	        }
	        if ($GLOBALS['action'] == 'nouveau_v') {
	            if ($formulaire->validate()) {
	                insertion ($formulaire->getSubmitValues(), $db);
	            }
	        }
	        
	    }
	    // Comportement par défaut
	    // requete sur la table gen_site_auth
	    $requete =  'SELECT gsa_ce_auth_bdd, gsa_nom, gsab_nom_table '.
	                'FROM gen_site_auth, gen_site_auth_bdd '.
	                'WHERE gsa_id_auth <> 0 '.
	                'AND gsa_ce_auth_bdd = gsab_id_auth_bdd';
	    
	    $resultat = $db->query($requete);
	    if (DB::isError($resultat)) {
	        trigger_error('Échec de la requete : '.$requete.'<br />'.$resultat->getMessage(), E_USER_WARNING);
	        return ;
	    }
	    $liste = new HTML_TableFragmenteur() ;
	    $liste->construireEntete(array (ADAU_NOM_AUTH, ADAU_NOM_TABLE, ADAU_MODIFIER, ADAU_SUPPRIMER));
	    $tableau_auth = array();
	    while ($ligne = $resultat->fetchRow()) {
	        $url->addQueryString('id_auth', $ligne[0]);
	        array_push ($tableau_auth, array ('<a href="'.$url->getURL().'">'.$ligne[1].'</a>'."\n",    // Première colonne, le nom de l'authentification
	                                            $ligne[2],  // deuxième colonne, le nom de la table d'annuaire
	                                            '<a href="'.$url->getURL().'">'.ADAU_MODIFIER.'</a>'."\n",   // Colonne modifier
	                                            '<a href="'.$url->getURL().'&amp;action=supprimer" onclick="javascript:return confirm(\''.ADAU_SUPPRIMER_MESSAGE.'\');">'.ADAU_SUPPRIMER.'</a>'."\n"
	                                            ));
			$url->removeQueryString('id_auth');
	    }
	    $liste->construireListe($tableau_auth);
	    $res .= $liste->toHTML();
	    return $res;
    }
}// Fin de la fonction afficherContenuCorps()

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: admin_auth.php,v $
* Revision 1.6  2006-10-06 10:40:51  florian
* harmonisation des messages d'erreur de l'authentification
*
* Revision 1.5  2006/09/21 15:22:04  jp_milcent
* Nettoyage dans l'url de la querystring id_auth.
*
* Revision 1.4  2005/04/14 13:54:51  jpm
* Amélioration de l'interface et mise en conformité.
*
* Revision 1.3  2005/03/09 10:50:08  jpm
* Changement d'un nom de fichier.
*
* Revision 1.2  2005/02/28 10:32:37  jpm
* Changement de nom de dossier.
*
* Revision 1.1  2004/12/06 11:31:59  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
