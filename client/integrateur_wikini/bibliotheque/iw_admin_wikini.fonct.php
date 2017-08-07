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
// CVS : $Id: iw_admin_wikini.fonct.php,v 1.5 2006-09-21 14:18:06 florian Exp $
/**
* Application gérant les Wikini associe à Papyrus
*
* Cette application permet de gérer les parametre des wikini associés à l'ensemble d'un papyrus
* TODO : Gestion mise a jour wakka.config.php !!!!!
* TODO : afficher les utilisations par les menus.
* TODO : synchronisation FTP ? .... : creation, suppression, liste (renommer ???)
* TODO : chemin vers le wikini ... (non, calcul en fonction du code alpha) , mais controles ? Pas dans un
* premier temps ...
* TODO : installation des wikini (tables présentes etc, et gestion ... (suppression ...)
* TODO : un wiki par défaut pour chaque papyrus, ce wiki sert de modèle
*
*@package Admin_Wikini
//Auteur original :
*@author        David Delon <david.delon@clapas.net>
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.5 $
// +------------------------------------------------------------------------------------------------------+
*/


// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
/** Inclusion du fichier de configuration de cette application.*/
require_once PAP_CHEMIN_RACINE.'client/integrateur_wikini/configuration/adwi_configuration.inc.php';

//Utilisation de la bibliothèque PEAR NET_URL

/** Inclusion de la bibliothèque PEAR de conception de formulaire.*/
require_once ADWI_CHEMIN_BIBLIOTHEQUE_PEAR.'HTML/QuickForm.php';
require_once ADWI_CHEMIN_BIBLIOTHEQUE_PEAR.'HTML/QuickForm/select.php';

/** Inclusion de l'API de fonctions gérant les erreurs sql.*/
require_once ADWI_CHEMIN_BIBLIOTHEQUE_API.'debogage/BOG_sql.fonct.php';

/** Inclusion des fonctions de manipulation du sql.
* Permet la récupération d'un nouvel identifiant d'une table.*/
require_once ADWI_CHEMIN_BIBLIOTHEQUE_API.'sql/SQL_manipulation.fonct.php';

require_once ADWI_CHEMIN_BIBLIOTHEQUE_API.'html/HTML_TableFragmenteur.php' ;

require_once ADWI_CHEMIN_BIBLIOTHEQUE.'adwi_wikini.fonct.php';

require_once ADWI_CHEMIN_BIBLIOTHEQUE.'adwi_HTML_formulaireWikini.class.php' ;


// Inclusion des fichiers de traduction de l'appli ADME dePapyrus
if (file_exists(ADWI_CHEMIN_LANGUE.'adwi_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once ADWI_CHEMIN_LANGUE.'adwi_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once ADWI_CHEMIN_LANGUE.'adwi_langue_'.ADWI_I18N_DEFAUT.'.inc.php';
}


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

function admin_afficherContenuCorpsHTML() {
	return admin_afficherContenuCorps();
}

function admin_afficherContenuCorps()
{
/* Gestion de Deux "écrans" et des actions associées : liste des Wikini en base de donnees et ajout-modification
 * d'un Wikini
 */
    $db = &$GLOBALS['_GEN_commun']['pear_db'] ;
    $url = $GLOBALS['_GEN_commun']['url'] ;
    $auth = &$GLOBALS['_GEN_commun']['pear_auth'] ;

    isset ($GLOBALS['action']) ? '' : $GLOBALS['action'] = '' ; // On déclare action si elle n'existe pas

    if (!$auth->getAuth()) {
        return 'Identifiez-vous' ;
    }

    // Le lien pour une nouvelle entrée
    $res = '<a href="'.$url->getURL().'&amp;action=nouveau">'.ADWI_AJOUTER.'</a>'."\n<br />" ;


    // traitement de la suppression
    if (isset ($GLOBALS['action']) && $GLOBALS['action'] == 'supprimer') adwi_supprimer_wikini($GLOBALS['id_wikini'], $db) ;

    // traitement de l'ajout et de la modification de la ligne selectionnée

    if (isset ($GLOBALS['action']) || isset ($GLOBALS['id_wikini'])) {

        $formulaire = new HTML_formulaireWikini('formulaire_wikini', '', str_replace ('&amp;', '&', $url->getURL())) ;
        $formulaire->construitFormulaire($url) ;

        // C'est une demande d'ajout : Affichage du masque de saisie et ajout d'un champs caché avec action=nouveau_v

        if ($GLOBALS['action'] == 'nouveau') {
            $formulaire->addElement ('hidden', 'action', 'nouveau_v') ;
            return $formulaire->toHTML() ;
        }

        // C'est une demande de modification : Affichage du masque de saisie et ajout d'un champs caché avec action=modifier_v

        if (isset ($GLOBALS['id_wikini']) && $GLOBALS['action'] != 'modifier_v' && $GLOBALS['action'] != 'supprimer') {
            $formulaire->addElement ('hidden', 'action', 'modifier_v') ;
            $formulaire->addElement ('hidden', 'id_wikini', $GLOBALS['id_wikini']) ;
            $formulaire->setDefaults(adwi_valeurs_par_defaut($GLOBALS['id_wikini'], $db)) ;
            return $formulaire->toHTML() ;
        }

        // Enregistrement de la modification et retour à la liste

        if ($GLOBALS['action'] == 'modifier_v') {
            if ($formulaire->validate()) {
                mise_a_jour ($formulaire->getSubmitValues(), $db) ;
            }
        }

        // Enregistrement de l'ajout et retour à la liste

        if ($GLOBALS['action'] == 'nouveau_v') {
            if ($formulaire->validate()) {
                insertion ($formulaire->getSubmitValues(), $db) ;
            }
        }

    }


    // Comportement par défaut
    // requete sur la table gen_wikini pour affichage de la liste des Wikini
    $requete = "select  gewi_id_wikini, gewi_code_alpha_wikini, gewi_page from gen_wikini" ;
    $resultat = $db->query ($requete) ;
    if (DB::isError ($resultat)) {
        $GLOBALS['_GEN_commun']['debogage_erreur']->gererErreur(E_USER_WARNING, "Echec de la requete : $requete<br />".$resultat->getMessage(),
                                                                        __FILE__, __LINE__, 'admin_wikini')   ;
        return ;
    }
    $liste = new HTML_TableFragmenteur () ;
    $liste->construireEntete(array (ADWI_NOM_WIKINI, ADWI_PAGE, ADWI_MODIFIER, ADWI_SUPPRIMER,ADWI_VISITER)) ;
    $tableau_wikini = array() ;
    while ($ligne = $resultat->fetchRow()) {
        $url->addQueryString ('id_wikini', $ligne[0]) ;
        array_push ($tableau_wikini, array ($ligne[1]."\n",    // Première colonne, le nom de l'application
        									$ligne[2]."\n",    // Deuxieme colonne, la page par defaut
        								  '<a href="'.$url->getURL().'">'.ADWI_MODIFIER.'</a>'."\n",
                                          '<a href="'.$url->getURL().'&amp;action=supprimer" onclick="javascript:return confirm (\''.ADWI_SUPPRIMER.' ?\');">'.ADWI_SUPPRIMER.'</a>'."\n",
                                          '<a href="'.ADWI_CHEMIN_WIKINI.$ligne[1].'">'.ADWI_VISITER.'</a>'."\n"
                                            ));
    }
    $liste->construireListe($tableau_wikini) ;
    $res .= $liste->toHTML();
    return $res ;
}




// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: iw_admin_wikini.fonct.php,v $
* Revision 1.5  2006-09-21 14:18:06  florian
* changement du wiki de base (ajout du gestionnaire d'extension), amÃ©lioration de l'intÃ©grateur wiki
*
* Revision 1.4  2006/06/02 09:12:16  florian
* ajout constante chemin
*
* Revision 1.3  2006/05/10 16:02:49  ddelon
* Finition multilinguise et schizo flo
*
* Revision 1.2  2006/04/28 12:41:26  florian
* corrections erreurs chemin
*
* Revision 1.1  2005/11/14 10:14:30  ddelon
* Projets Wikini
*
* Revision 1.7  2005/10/21 20:55:06  ddelon
* todo wikini
*
* Revision 1.6  2005/09/30 07:48:35  ddelon
* Projet Wikini
*
* Revision 1.5  2005/09/09 09:37:17  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.4  2005/09/06 08:35:36  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.3  2005/09/02 11:29:25  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.2  2005/08/31 17:34:52  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.1  2005/08/25 08:59:12  ddelon
* Integrateur Wikini et administration des Wikini
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
