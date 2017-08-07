<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (c) 2002, Hendrik Mans <hendrik@mans.de>                                                   |
// | Copyright 2002, 2003 David DELON                                                                     |
// | Copyright 2002 Patrick PAUL                                                                          |
// | All rights reserved.                                                                                 |
// | Redistribution and use in source and binary forms, with or without                                   |
// | modification, are permitted provided that the following conditions                                   |
// | are met:                                                                                             |
// | 1. Redistributions of source code must retain the above copyright                                    |
// | notice, this list of conditions and the following disclaimer.                                        |
// | 2. Redistributions in binary form must reproduce the above copyright                                 |
// | notice, this list of conditions and the following disclaimer in the                                  |
// | documentation and/or other materials provided with the distribution.                                 |
// | 3. The name of the author may not be used to endorse or promote products                             |
// | derived from this software without specific prior written permission.                                |
// |                                                                                                      |
// | THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR                                 |
// | IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES                            |
// | OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.                              |
// | IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT,                                     |
// | INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT                             |
// | NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,                            |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY                                |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT                                  |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF                             |
// | THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.                                    |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: instal_preference.inc.php,v 1.12 2006-10-06 15:23:00 florian Exp $
/**
* Page d'initialisation de l'installation de Papyrus.
*
* Contenu de la page par défaut de l'installation de Papyrus.
*
*@package Installateur
//Auteur original :
*@author        Hendrik MANS <hendrik@mans.de>
//Autres auteurs :
*@author        David DELON
*@author        Patrick PAUL
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.12 $ $Date: 2006-10-06 15:23:00 $
// +------------------------------------------------------------------------------------------------------+
**/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// Numéro de l'étape d'installation :
$num_etape = 1;

// Initialisation du tableau contenant les valeurs de configuration de la base de données
$tableau = array('ADMIN_PRENOM' => '', 'ADMIN_NOM' => '', 'ADMIN_MAIL' => '', 'ADMIN_MDP_01' => '', 
                'ADMIN_MDP_02' => '', 'ADMIN_I18N' => '', 'PAP_URL' => '', 'PAP_CHEMIN_RACINE' => '', 'PAP_URL_REECRITURE' => '0');
foreach ($tableau as $cle => $val) {
    if (!empty($_POST['pref'][$cle])) {
        $pref[$cle] = $_POST['pref'][$cle];
    } else if (defined($cle)) {
        $pref[$cle] = constant($cle);
        if ($cle == 'PAP_CHEMIN_RACINE') $pref[$cle] = INSTAL_CHEMIN_ABSOLU;
    } else {
        if ($cle == 'PAP_URL') {
            $pref[$cle] =   'http://'.$_SERVER['SERVER_NAME'].
                            ($_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '').
                            $_SERVER['REQUEST_URI'];
        } else if ($cle == 'PAP_CHEMIN_RACINE') {
            $pref[$cle] = INSTAL_CHEMIN_ABSOLU;
        } else {
            $pref[$cle] = '';
        }
    }
}

// +------------------------------------------------------------------------------------------------------+
// |                                          CORPS du PROGRAMME                                          |
// +------------------------------------------------------------------------------------------------------+

// Affichage d'informations...
$sortie .= '<br /><h1>Etape n°'.$num_etape.' sur '.INSTAL_NBRE_ETAPE.'.</h1>'."\n";
$sortie .= '<p>NOTE: Ce programme d\'installation va essayer de modifier les options de configurations dans le '.
                'fichier <tt>pap_config.inc.php</tt>, situ&eacute; dans le r&eacute;pertoire <tt>configuration</tt> du réportoire '.
                '<tt>papyrus</tt>. Pour que cela fonctionne, veuillez vous assurez que votre serveur a les droits d\'acc&egrave;s '.
                'en &eacute;criture pour ce fichier. Si pour une raison quelconque vous ne pouvez pas faire &ccedil;a vous '.
                'devrez modifier ce fichier manuellement (ce programme d\'installation vous dira comment).</p><br />'."\n";

// Nous vérifions si nous sommes en phase de test du formulaire de config des préférences
if ($_GET['installation'] == 'verif_pref' ) {
    $sortie_verif = '';
    $sortie_verif .= testerPresenceExtension();
    // En mise à jour, nous n'affichons pas les champs pour saisir un administrateur
    if (!defined(INSTAL_VERSION_NOUVELLE_NOM)) {
        // Nous vérifions que l'utilisateur à bien saisie les infos dans les champs du formulaire
        if(empty($_POST['pref']['ADMIN_PRENOM'])) {
            $sortie_verif .= '<p class="erreur">Le champ "Prénom" ne doit pas être vide!</p>'."\n";
        }
        if(empty($_POST['pref']['ADMIN_NOM'])) {
            $sortie_verif .= '<p class="erreur">Le champ "Nom" ne doit pas être vide!</p>'."\n";
        }
        if(empty($_POST['pref']['ADMIN_MAIL'])) {
            $sortie_verif .= '<p class="erreur">Le champ "Courriel" ne doit pas être vide!</p>'."\n";
        }
        if(empty($_POST['pref']['ADMIN_MDP_01'])) {
            $sortie_verif .= '<p class="erreur">Le champ "Mot de passe" ne doit pas être vide!</p>'."\n";
        }
        if($_POST['pref']['ADMIN_MDP_01'] != $_POST['pref']['ADMIN_MDP_02']) {
            $sortie_verif .= '<p class="erreur">Le deux mots de passes saisis pour le compte administrateur sont différents!</p>'."\n";
        }
    }
}

// Gestion de l'affichage de sortie
if (!isset($sortie_verif) && empty($sortie_verif)) {
    // Premier appel du fichier...
    $sortie .= creerFormulaire($pref);
    $sortie .= '      </ul>'."\n";
    $sortie .= '<input type="submit" value="Passer à l\'étape suivante" />'."\n";
    $sortie .= '</form>';
} else if (isset($sortie_verif) && !empty($sortie_verif)) {
    // Vérification du fichier avec interuption...
    $sortie .= $sortie_verif;
    $sortie .= creerFormulaire($pref);
    $sortie .= '      </ul>'."\n";
    $sortie .= '<input type="submit" value="Tester à nouveau" />'."\n";
    $sortie .= '    </form>';
} else if (isset($sortie_verif) && empty($sortie_verif)) {
    // Vérification du fichier sans interuption... passage à l'étape suivante
    $sortie .= creerFormulaire($pref, true);
    $sortie .= '      </ul>'."\n";
    $sortie .= '    </form>';
    $sortie .= '    <br /><p class="etape_info">La configuration est OK. A l\'&eacute;tape suivante, le programme d\'installation va essayer de configurer '.
                    'et créer la base de données.</p>'."\n";
    $sortie .= '    <form style="clear:both;" action="'.donnerUrlCourante().'?installation=form_bdd" method="post">'."\n";
    $sortie .= '      <input type="hidden" name="pref_serial" value="'.htmlentities(serialize($pref)).'" />'."\n";
    $sortie .= '      <input type="submit" value="Continuer" />'."\n";
    $sortie .= '    </form>'."\n";
}
// +------------------------------------------------------------------------------------------------------+
// |                                            LISTE DES FONCTIONS                                       |
// +------------------------------------------------------------------------------------------------------+

// Création du formulaire de configuration de la base de donneés
function creerFormulaire($pref, $bln_lecture = false) {
    $disabled = '';
    if ($bln_lecture) {
        $disabled = ' disabled="disabled" ';
    }
    $sortie_form = '';
    $sortie_form .= '    <form action="'.donnerUrlCourante().'?installation=verif_pref" method="post">'."\n";
    $sortie_form .= '<ul>'."\n";
    // En mise à jour, nous n'affichons pas les champs pour saisir un administrateur
    if (!defined(INSTAL_VERSION_NOUVELLE_NOM)) {
        $sortie_form .= '<li><h2>Configuration d\'un administrateur de Papyrus</h2></li>'."\n";        
	$sortie_form .=  '<li>Tous les champs ci-dessous sont obligatoires.</li>'."\n";
        $sortie_form .=  '<li>'."\n".
                    '<label for="admin_prenom">Prénom :</label>'.
                    '<input id="admin_prenom"'.$disabled.'type="text" size="30" name="pref[ADMIN_PRENOM]" value="'.$pref['ADMIN_PRENOM'].'" />'.
                    '</li>'."\n";
        $sortie_form .=  '<li>'."\n".
                    '<label for="admin_nom">Nom :</label>'.
                    '<input id="admin_nom"'.$disabled.'type="text" size="30" name="pref[ADMIN_NOM]" value="'.$pref['ADMIN_NOM'].'" />'.
                    '</li>'."\n";
        $sortie_form .=  '<li>'."\n".
                    '<label for="admin_mail">Courriel :</label>'.
                    '<input id="admin_mail"'.$disabled.'type="text" size="30" name="pref[ADMIN_MAIL]" value="'.$pref['ADMIN_MAIL'].'" />'.
                    '</li>'."\n";
        $sortie_form .=  '<li>'."\n".
                    '<label for="admin_mdp_01">Mot de passe :</label>'.
                    '<input id="admin_mdp_01"'.$disabled.'type="password" size="10" name="pref[ADMIN_MDP_01]" value="'.$pref['ADMIN_MDP_01'].'" />'.
                    '</li>'."\n";
        $sortie_form .=  '<li>'."\n".
                    '<label for="admin_mdp_02">Taper à nouveau votre mot de passe :</label>'.
                    '<input id="admin_mdp_02"'.$disabled.'type="password" size="10" name="pref[ADMIN_MDP_02]" value="'.$pref['ADMIN_MDP_02'].'" />'.
                    '</li>'."\n";
        $sortie_form .=  '<li>'."\n".
                    '<label for="admin_i18n">Langue :</label>'.
                    '<select id="admin_i18n"'.$disabled.'name="pref[ADMIN_I18N]">'.
                        '<option value="fr-FR" selected="selected">français</option>'.
                    '</select>'.
                    '</li>'."\n";
    }
    $sortie_form .=  '<li>&nbsp;</li>'."\n".'<li><h2>Configuration de l\'URL</h2></li>'."\n";
    $sortie_form .=  '<li>L\'URL courante dans la barre d\'adresse de votre navigateur devrait correspondre à la valeur '.
                'présente dans le champ ci-dessous. Si ce n\'est pas le cas, veuillez corriger la valeur ci-dessous.'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="url_courante">URL courante :</label>'.
                '<input id="url_courante"'.$disabled.'type="text" size="60" name="pref[PAP_URL]" value="'.$pref['PAP_URL'].'" />'.
                '</li>'."\n";
    $sortie_form .= '<li>Le mode "redirection automatique" doit &ecirc;tre s&eacute;lectionn&eacute; uniquement si '.
                    'vous utilisez Papyrus avec la redirection d\'URL (si vous ne savez pas ce qu\'est la redirection d\'URL '.
                    'n\'activez pas cette option).</li>'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="rewrite_mode">Mode "redirection" :</label>'.
                '<input id="rewrite_mode"'.$disabled.'type="checkbox" name="pref[PAP_URL_REECRITURE]" value="1" />'.
                'Activation'.'</li>'."\n";
    $sortie_form .= '<li>Le champ suivant devrait contenir le chemin d\'accès absolu vers le fichier <tt>papyrus.php</tt> '.
                    'sur le serveur où sont déposés les fichiers de Papyrus.</li>'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="web_racine">Dossier de <tt>papyrus.php</tt> :</label>'.
                '<input id="web_racine"'.$disabled.'type="text" size="60" name="pref[PAP_CHEMIN_RACINE]" value="'.$pref['PAP_CHEMIN_RACINE'].'" />'.
                '</li>'."\n";
    
    return $sortie_form;
}

// Vérification des variables d'environnement de PHP.
function testerPresenceExtension() {
    $message = '';
    $phrase_deb = '<p class="erreur">Pour fonctionner Papyrus à besoin que l\'extension PHP : ';
    $phrase_fin = 'soit installée sur le serveur.<br /> Sans cette extension vous ne pourrez pas installer Papyrus !</p>';
    // Nous avons besoin de quelques extensions
    if (! extension_loaded('mysql')) {
        $message .= $phrase_deb.'MYSQL'.$phrase_fin;
    }
    if (! extension_loaded('ftp')) {
        $message .= $phrase_deb.'FTP'.$phrase_fin;
    }
    if (! extension_loaded('gd')) {
        $message .= $phrase_deb.'GD'.$phrase_fin;
    }
    return $message;
}
// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: instal_preference.inc.php,v $
* Revision 1.12  2006-10-06 15:23:00  florian
* amelioration graphique de l'installateur
*
* Revision 1.11  2006/10/05 15:14:18  alexandre_tb
* Mise en place du chemin par défaut
*
* Revision 1.10  2005/09/23 14:20:23  florian
* nouvel habillage installateur, plus correction de quelques bugs
*
* Revision 1.9  2005/04/12 16:09:45  jpm
* Amélioration de la gestion de la constante de redirection des urls et de la gestion des constantes de type entier et booléen.
*
* Revision 1.8  2004/10/27 11:43:32  jpm
* Correction bogues diff mise à jour / installation.
*
* Revision 1.7  2004/10/25 10:22:48  jpm
* Correction de quelques bogues, ajouts d'explications pour l'utilisateur et modification des styles CSS.
*
* Revision 1.6  2004/10/22 17:23:04  jpm
* Simplification del'installation de Papyrus.
*
* Revision 1.5  2004/10/22 09:07:18  jpm
* Début simplification installateur.
*
* Revision 1.4  2004/10/19 17:01:12  jpm
* Correction bogues.
*
* Revision 1.3  2004/10/19 16:47:28  jpm
* Transformation en fonction de l'appel de l'application.
*
* Revision 1.2  2004/10/19 15:59:18  jpm
* Ajout de la gestion des valeurs propre à Papyrus à insérer dans la base de données.
* Ajout des constantes FTP.
*
* Revision 1.1  2004/10/15 18:28:59  jpm
* Début appli installateur de Papyrus.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>