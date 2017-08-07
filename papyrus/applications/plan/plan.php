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
// CVS : $Id: plan.php,v 1.7 2006-10-11 18:05:15 jp_milcent Exp $
/**
* Application réalisant le plan d'un site web géré par Papyrus.
*
* Construit une liste de listes représentant le plans des sites web gérés par Papyrus.
* Cette application est fortement dépendante de Papyrus puisqu'elle se base sur 
* le modèle de données de Papyrus.
*
*@package Plan
//Auteur original :
*@author        Alexandre GRANIER <alexandrel@tela-botanica.org>
//Autres auteurs :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.7 $ $Date: 2006-10-11 18:05:15 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
/** Constante permettatn de configurer l'application en affichant que le plan du site courant si sa valeur vaut true.*/
define('PLAN_SITE_COURRANT', false);
define('PLAN_AFFICHER_PERMALIEN', false);

/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_PAP.'applications/plan/configuration/plan_config.inc.php';

// Inclusion des fichiers de traduction de l'applette.
if (file_exists(PLAN_CHEMIN_LANGUE.'plan_langue_'.$_GEN_commun['i18n'].'.inc.php')) {
    require_once PLAN_CHEMIN_LANGUE.'plan_langue_'.$_GEN_commun['i18n'].'.inc.php';
} else {
    require_once PLAN_CHEMIN_LANGUE.'plan_langue_'.PLAN_I18N_DEFAUT.'.inc.php';
}

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction afficherContenuTete() - Fonction appelé par le gestionnaire Papyrus.
*
* Elle retourne l'entête de l'application..
*
* @return  string  du code XHTML correspondant à la zone d'entête de l'application.
*/
function afficherContenuTete()
{
    return '';
}

/** Fonction afficherContenuCorps() - Fonction appelé par le gestionnaire Papyrus.
*
* Elle démarre la création de la liste contenant le plan du site.
*
* @return  string  le code HTML produit par l'application.
*/
function afficherContenuCorps()
{
    // Initialisation des variables
    $retour = '';
    $bdd =& $GLOBALS['_GEN_commun']['pear_db'];
    $site_courant_id = $GLOBALS['_GEN_commun']['info_site']->gs_id_site;
    
    // Si on veut seulement le plan du site courrant.
    if (PLAN_SITE_COURRANT) {
        $aso_sites = GEN_lireInfoSitePrincipal($bdd, $site_courant_id, DB_FETCHMODE_ASSOC);
        $retour .= '<h1 id="titre_page">'.PLAN_PLAN_DU_SITE.'</h1>'."\n";
    } else {
        $aso_sites = GEN_lireInfoSites($bdd, DB_FETCHMODE_ASSOC);
        $retour .= '<h1 id="titre_page">'.PLAN_PLAN_DES_SITES.'</h1>'."\n";
    }
    
    foreach ($aso_sites as $cle => $site) {
    	// On ignore le site admin
    	if ($site['gs_code_alpha'] == 'admin' && $GLOBALS['_GEN_commun']['info_site']->gs_code_alpha!='admin') continue;
    	
        if (count($aso_sites) >= 1) {
            if (!empty($site['gs_titre'])) {
                $titre = $site['gs_titre'];
            } else {
                $titre = $site['gs_nom'];
            }
            $url_site = new Pap_URL();
            $url_site->setUrlType('SITE');
            $url_site->setId($site['gs_id_site']);
            $retour .= '<h2><a href="'.$url_site->getUrl().'">'.htmlentities($titre).'</a></h2>'."\n";
        }
        $retour .= '<ul class="plan_site_'.$site['gs_nom'].'" >'."\n";
        $aso_menus = GEN_retournerTableauMenusSiteCodeAlpha($bdd, $site['gs_code_alpha']);
        $retour .= parserTableauMenus($aso_menus, PLAN_AFFICHER_PERMALIEN);
        $retour .= '</ul>'."\n";
    }
    
    return $retour;
}

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

function parserTableauMenus($aso_menus, $permalien)
    {
        $retour = '';
        
        // Création de l'url
        foreach ($aso_menus as $menu_id => $menu_valeur) {
            if ($menu_valeur['gm_date_fin_validite'] == '0000-00-00 00:00:00' || strtotime($menu_valeur['gm_date_fin_validite']) > time() ) {
                $retour .= '<li>';
                // Création de l'url
                $une_url = new Pap_URL();
                $une_url->setId($menu_id);
                
                // Construction de l'attribut title
                $title = '';
                if (!empty($menu_valeur['gm_titre'])) {
                    $title = ' title="'.htmlentities($menu_valeur['gm_titre']).'"';
                } elseif (!empty($menu_valeur['gm_titre_alternatif'])) {
                    $title = ' title="'.htmlentities($menu_valeur['gm_titre_alternatif']).'"';
                }
                
                // Construction du lien
                $retour .= '<a href="'.$une_url->getURL().'"'.$title.'>'.htmlentities($menu_valeur['gm_nom']).'</a>';
                
                // Nous affichons ou pas le permalien
                if ($permalien) {
                    $une_url->setPermalien(true);
                    $retour .= ' <span class="plan_permalien">'.'('.$une_url->getURL().')'.'</span>';
                    $une_url->setPermalien(false);
                }
                
                // Nous ajoutons les sous-menus s'il y en a.
                $retour_menus = parserTableauMenus($menu_valeur['sous_menus'], $permalien);
                if ($retour_menus != '') {
                    $retour .= "\n".'<ul>'."\n".$retour_menus."\n".'</ul>'."\n";
                }
                
                $retour .= '</li>'."\n";
            }
        }
        return $retour;
    }
// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: plan.php,v $
* Revision 1.7  2006-10-11 18:05:15  jp_milcent
* Ajout d'url sur les titres des sites
*
* Revision 1.6  2006/10/06 10:03:14  florian
* amelioration: affichage du plan des menus d'administration, dans le monde administration
*
* Revision 1.5  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.4.2.1  2006/02/28 14:02:09  ddelon
* Finition multilinguisme
*
* Revision 1.4  2005/10/14 11:49:51  alexandre_tb
* Pas d'affichage du site admin
*
* Revision 1.3  2005/04/19 17:21:02  jpm
* Amélioration de l'application.
* Gestion des dates  de fin de validité des menus.
*
* Revision 1.2  2005/02/28 10:38:24  jpm
* Modification de l'utilisation d'une variable globale.
*
* Revision 1.1  2004/06/16 14:34:53  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.7  2004/05/05 15:33:59  jpm
* Gestion de l'indication des langues disponibles pour un menu d'un site  donné.
*
* Revision 1.6  2004/05/05 14:33:00  jpm
* Gestion de l'indication de langue dans l'url.
* Utile que si on veut forcer la langue.
*
* Revision 1.5  2004/05/05 06:45:51  jpm
* Suppression de l'appel de la fonction générant le "vous êtes ici" dans la fonction affichant l'entête de l'application.
*
* Revision 1.4  2004/05/04 16:27:27  jpm
* Réduction de code pour la fonction afficherContenuTete().
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
