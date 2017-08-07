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
// | Copyright  2003  Eric FELDSTEIN                                                                      |
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
// CVS : $Id: instal_base_de_donnees.inc.php,v 1.35 2007-08-28 14:37:11 jp_milcent Exp $
/**
* Page de crï¿½ation de la base de donnï¿½es de Papyrus.
*
* Page permettant de crï¿½er la base de donnï¿½es de Papyrus.
*
*@package Installateur
//Auteur original :
*@author        Hendrik MANS <hendrik@mans.de>
//Autres auteurs :
*@author        David DELON
*@author        Patrick PAUL
*@author        Eric FELDSTEIN
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.35 $ $Date: 2007-08-28 14:37:11 $
// +------------------------------------------------------------------------------------------------------+
**/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTï¿½TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// Numéro de l'étape d'installation :
$num_etape = 2;

// Initialisation du tableau contenant les valeurs de configuration de la base de données
$tableau = array('PAP_BDD_SERVEUR' => '', 'PAP_BDD_NOM' => '', 'PAP_BDD_UTILISATEUR' => '', 'PAP_BDD_MOT_DE_PASSE' => '');
foreach ($tableau as $cle => $val) {
    if ($_POST['bdd'][$cle] != '') {
        $bdd[$cle] = $_POST['bdd'][$cle];
    } else if (defined($cle)) {
        $bdd[$cle] = constant($cle);
    } else {
        $bdd[$cle] = '';
    }
}

// Récupération des paramêtres de configuration du formulaire précédent
if (isset($_POST['pref'])) {
    $pref = $_POST['pref'];
} else if (isset($_POST['pref_serial'])) {
    $pref = unserialize(stripslashes($_POST['pref_serial']));
}

// +------------------------------------------------------------------------------------------------------+
// |                                          CORPS du PROGRAMME                                          |
// +------------------------------------------------------------------------------------------------------+

// Affichage d'informations...
$sortie .= '<br /><h1>Etape n&deg;'.$num_etape.' sur '.INSTAL_NBRE_ETAPE.'.</h1>'."\n";

// Nous vérifions si nous sommes en phase de test du formulaire de config de la base de donnï¿½es
$erreur = 0;
$sortie_verif = '';
if ($_GET['installation'] == 'verif_bdd') {
    // Test de la configuration à la base de donnï¿½es
    $sortie_test .= '    <br /><h2>Test de la configuration de la base de donn&eacute;es</h2>'."\n";
    $dblink = @mysql_connect($bdd['PAP_BDD_SERVEUR'], $bdd['PAP_BDD_UTILISATEUR'], $bdd['PAP_BDD_MOT_DE_PASSE']);
    $erreur = testerConfig($sortie_test, 'Test connexion au serveur MySQL, recherche base de donn&eacute;es ...', @mysql_select_db($bdd['PAP_BDD_NOM'], $dblink), 
                    '<br />La base de donn&eacute;es, le serveur MySQL, ou votre identifiant / mot de passe sont invalides, veuillez vérifier vos paramêtres.', 1, $erreur);
    $sortie .= '<br />'."\n";
    if ($erreur==0) {
	    // L'exécution du SQL peut commencer...
	    if (!defined('PAP_VERSION')) {
		    $version_actuelle = 0.1;
	    } else {
		    // On ajoute pour éviter l'étape qui a déjà eu lieu lors d'une installation précédente!
		    $version_actuelle = PAP_VERSION + 0.01;
	    }
	    if (!defined('GEN_VERSION')) {
		    $version_maj = 0.1;
	    } else {
		    $version_maj = GEN_VERSION + 0.01;
	    }
	    
	    $sortie_test .= '<h2>Insertion des informations dans la base de donn&eacute;es</h2>';
	    
	    for ( $version = $version_actuelle; $version <= $version_maj; $version = $version + 0.01) {
	    	
			//Insertion des requêtes présentes dans le fichier sql
			$file_sql_contenu = INSTAL_CHEMIN_SQL.'papyrus_v'.$version.'.sql';
			
			if (file_exists($file_sql_contenu)) {
				$sortie_verif .= '<h2>Insertion des donn&eacute;es du fichier sql version '.$version.'</h2>';
				$sql_contenu = PMA_readFile($file_sql_contenu);
			} else 
				unset($sql_contenu);
	    	
			
			$tab_requete_sql = array();
			PMA_splitSqlFile($tab_requete_sql, $sql_contenu, '');
			foreach ($tab_requete_sql as $value) {
			    $table_nom = '';
			    if (!empty($value['table_nom'])) {
				$table_nom = $value['table_nom'];
			    }
			    $requete_type = '';
			    if (!empty($value['type'])) {
				$requete_type = $value['type'];
			    }
			    if ($requete_type == 'create') {
				$erreur = testerConfig( $sortie_verif, 'Cr&eacute;ation table '.$table_nom.'...', @mysql_query($value['query'], $dblink), 
							'D&eacute;j&agrave; cr&eacute;&eacute;e ?', 0, $erreur);
			    } else if ($requete_type == 'alter') {
				$erreur = testerConfig( $sortie_verif, 'Modification structure table '.$table_nom.'...', @mysql_query($value['query'], $dblink), 
							'D&eacute;j&agrave; modifi&eacute;e ?', 0, $erreur);
			    } else if ($requete_type == 'insert') {
				$erreur = testerConfig( $sortie_verif, 'Insertion table '.$table_nom.'...', @mysql_query($value['query'], $dblink), 
							'Donn&eacute;es d&eacute;j&agrave; pr&eacute;sente ?', 0, $erreur);
			    }
			}
		
		
			// Chargement des hooks sql : fichier sql de configuration spécifiques à chaque application
	
			$d = dir(GEN_CHEMIN_CLIENT);
			
			$sql_contenu_hook = '';
		 	while (false !== ($repertoire = $d->read())) {
					$hook=GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.'documentation'.GEN_SEP.$repertoire.'_v'.$version.'.sql';
					if (file_exists($hook)) {
					    $sortie_verif .= '<h2>Insertion des informations dans la base de données, fichier : '.$hook.'  </h2>';
						$sql_contenu_hook = PMA_readFile($hook);
	
						$tab_requete_sql = array();
						PMA_splitSqlFile($tab_requete_sql, $sql_contenu_hook, '');
						foreach ($tab_requete_sql as $value) {
						    $table_nom = '';
						    if (!empty($value['table_nom'])) {
							$table_nom = $value['table_nom'];
						    }
						    $requete_type = '';
						    if (!empty($value['type'])) {
							$requete_type = $value['type'];
						    }
						    if ($requete_type == 'create') {
							$erreur = testerConfig( $sortie_verif, 'Cr&eacute;ation table '.$table_nom.'...', @mysql_query($value['query'], $dblink), 
										'D&eacute;j&agrave; cr&eacute;&eacute; ?', 0, $erreur);
						    } else if ($requete_type == 'alter') {
							$erreur = testerConfig( $sortie_verif, 'Modification structure table '.$table_nom.'...', @mysql_query($value['query'], $dblink), 
										'D&eacute;j&agrave; modifi&eacute;e ?', 0, $erreur);
						    } else if ($requete_type == 'insert') {
							$erreur = testerConfig( $sortie_verif, 'Insertion table '.$table_nom.'...', @mysql_query($value['query'], $dblink), 
										'Donn&eacute;es d&eacute;j&agrave; pr&eacute;sente ?', 0, $erreur);
						    }
						}
					}
		 	}
						
	    }
	    
    
		//Insertion des requêtes dépendant du formulaire d'installation
		
		$sortie_verif .= '<h2>Insertion des donn&eacute;es d&eacute;pendant du formulaire pr&eacute;c&eacute;dent</h2>';
		$requete_admin =    'INSERT INTO gen_annuaire VALUES (1, "'.$pref['ADMIN_I18N'].'", "'.$pref['ADMIN_NOM'].
				    '", "'.$pref['ADMIN_PRENOM'].'", "'.md5($pref['ADMIN_MDP_01']).'", "'.
				    $pref['ADMIN_MAIL'].'");';
		$erreur = testerConfig($sortie_verif, 'Insertion de l\'administrateur...', @mysql_query($requete_admin, $dblink), 
					'Donn&eacute;es d&eacute;j&agrave; pr&eacute;sente ?', 0, $erreur);
		$requete_auth = 'INSERT INTO gen_site_auth_bdd VALUES (1, "mysql://'.
				    $bdd['PAP_BDD_UTILISATEUR'].':'.$bdd['PAP_BDD_MOT_DE_PASSE'].'@'.$bdd['PAP_BDD_SERVEUR'].'/'.$bdd['PAP_BDD_NOM'].'", "gen_annuaire", "ga_mail", '.
				    '"ga_mot_de_passe", "md5","chp_personne_prenom=ga_prenom chp_personne_nom=ga_nom");';
		$erreur = testerConfig($sortie_verif, 'Insertion de l\'authentification...', @mysql_query($requete_auth, $dblink), 
					'Données déjà présente ?', 0, $erreur);
		$url_inscription = preg_replace ('/papyrus\.php/', 'page:inscription', $pref['PAP_URL']);
		$url_inscription_erreur = preg_replace ('/papyrus\.php/', 'page:inscription?action&#61;mdp_oubli', $pref['PAP_URL']); 
        $requete_auth =    'INSERT INTO gen_site_auth_bdd VALUES (2, "mysql://'.
        $bdd['PAP_BDD_UTILISATEUR'].':'.$bdd['PAP_BDD_MOT_DE_PASSE'].'@'.$bdd['PAP_BDD_SERVEUR'].'/'.$bdd['PAP_BDD_NOM'].'", "annuaire", "a_mail", '.
                                               '"a_mot_de_passe", "md5","chp_personne_prenom=a_prenom chp_personne_nom=a_nom '.
                                               'url_inscription='.$url_inscription.' url_inscription_modif='.$url_inscription.' url_erreur='.$url_inscription_erreur.'");';

		$erreur = testerConfig($sortie_verif, 'Insertion de l\'authentification utilisateurs ...', @mysql_query($requete_auth, $dblink), 
					'Donn&eacute;es d&eacute;j&agrave; pr&eacute;sente ?', 0, $erreur);
					
	    
	    
    }
    
}

// Gestion de l'affichage de sortie
if ($erreur == 0 && empty($sortie_verif)) {
    // Premier appel du fichier...
    $sortie .= creerFormulaire($bdd);
    $sortie .= '<li><input type="hidden" name="pref_serial" value="'.htmlentities(serialize($pref)).'" /></li>'."\n";
    $sortie .= '<li><input type="submit" value="Tester" /></li>'."\n";
    $sortie .= '      </ul>'."\n";
    $sortie .= '    </form>';
} else if ($erreur == 2 && !empty($sortie_test)) {
    // Vérification du fichier avec interuption...
    $sortie .= creerFormulaire($bdd);
    $sortie .= $sortie_test;
    $sortie .= '<li><input type="hidden" name="pref_serial" value="'.htmlentities(serialize($pref)).'" /></li>'."\n";
    $sortie .= '<li><input type="submit" value="Tester &agrave; nouveau" /></li>'."\n";
    $sortie .= '      </ul>'."\n";
    $sortie .= '    </form>';
    //$sortie .= '<div class="code"><code>'.$sortie_verif.'</code></div>';
} else if (($erreur == 0 || $erreur == 1) && !empty($sortie_verif)) {
    // Vérification du fichier sans interuption... passage à l'étape suivante
    $sortie .= creerFormulaire($bdd, true);
    $sortie .= $sortie_test;
    $sortie .= '      </ul>'."\n";
    $sortie .= '    </form>';
    $sortie .= '<div class="code"><code>'.$sortie_verif.'</code></div>';
    $sortie .= '   <br /><p class="etape_info">A l\'&eacute;tape suivante, le programme d\'installation va essayer d\'&eacute;crire le fichier de '.
                'configuration <tt>'.INSTAL_FICHIER_CONFIG.'</tt>.<br />Assurez vous que le serveur web a bien le '.
                'droit d\'&eacute;crire dans ce fichier, sinon vous devrez le modifier manuellement.</p>'."\n";
    
    $sortie .= '    <form style="clear:both;" action="'.donnerUrlCourante().'?installation=form_fichier" method="POST" />'."\n";
    $sortie .= '      <input type="hidden" name="bdd_serial" value="'.htmlentities(serialize($bdd)).'" />'."\n";
    $sortie .= '      <input type="hidden" name="pref_serial" value="'.htmlentities(serialize($pref)).'" />'."\n";
    $sortie .= '      <input type="submit" value="Continuer" />'."\n";
    $sortie .= '    </form>'."\n";
}
// +------------------------------------------------------------------------------------------------------+
// |                                            LISTE DES FONCTIONS                                       |
// +------------------------------------------------------------------------------------------------------+

// Création du formulaire de configuration de la base de données
function creerFormulaire($bdd, $bln_lecture = false) {
    $disabled = '';
    if ($bln_lecture) {
        $disabled = ' disabled="disabled" ';
    }
    
    $sortie_form .= '    <form action="'.donnerUrlCourante().'?installation=verif_bdd" method="post">';
    $sortie_form .= '      <ul>'."\n";
    $sortie_form .= '<li><br /><h2>Configuration de la base de donn&eacute;es</h2></li>'."\n";
    $sortie_form .= '<li>La machine sur laquelle se trouve votre serveur MySQL. En g&eacute;n&eacute;ral c\'est "localhost" '.
                    '(ie, la m&ecirc;me machine que celle o&ugrave; se trouve les pages de Papyrus.).</li>'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="mysql_serveur">Nom du serveur MySQL :</label>'.
                '<input id="mysql_serveur"'.$disabled.'type="text" size="30" name="bdd[PAP_BDD_SERVEUR]" value="'.$bdd['PAP_BDD_SERVEUR'].'" />'.
                '</li>'."\n";
    $sortie_form .=  '<li>La base de donn&eacute;es MySQL &agrave; utiliser pour Papyrus. Cette base de donn&eacute;es doit d&eacute;j&agrave; '.
                'exister avant de pouvoir continuer.</li>'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="mysql_database">Base de donn&eacute;es MySQL :</label>'.
                '<input id="mysql_database"'.$disabled.'type="text" size="30" name="bdd[PAP_BDD_NOM]" value="'.$bdd['PAP_BDD_NOM'].'" />'.
                '</li>'."\n";
    $sortie_form .=  '<li>Nom et mot de passe de l\'utilisateur MySQL qui sera utilis&eacute; pour se connecter &agrave; votre base de donn&eacute;es.</li>'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="mysql_user">Nom de l\'utilisateur MySQL :</label>'.
                '<input id="mysql_user"'.$disabled.'type="text" size="30" name="bdd[PAP_BDD_UTILISATEUR]" value="'.$bdd['PAP_BDD_UTILISATEUR'].'" />'.
                '</li>'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="mysql_password">Mot de passe MySQL :</label>'.
                '<input id="mysql_password"'.$disabled.'type="password" size="30" name="bdd[PAP_BDD_MOT_DE_PASSE]" value="'.$bdd['PAP_BDD_MOT_DE_PASSE'].'" />'.
                '</li>'."\n";
    return $sortie_form;
}
// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: instal_base_de_donnees.inc.php,v $
* Revision 1.35  2007-08-28 14:37:11  jp_milcent
* Ajout des urls par défaut pour l'inscription et inscription_erreur.
*
* Revision 1.34  2007-06-26 12:08:18  jp_milcent
* Correction de l'encodage et de la création du htaccess.
*
* Revision 1.33  2007-06-25 12:15:07  alexandre_tb
* merge from narmer
*
* Revision 1.32  2007/04/20 09:05:46  alexandre_tb
* correction pb encodage
*
* Revision 1.31  2007/04/19 16:19:45  neiluj
* optimisation
*
* Revision 1.30  2007/04/19 16:18:05  neiluj
* correction bug lecture fichier SQL
*
* Revision 1.29  2006/12/01 14:05:57  alexandre_tb
* affichage des mesages d erreurs quand on se trompe dans les parametres mysql
*
* Revision 1.28  2006/10/06 15:23:00  florian
* amelioration graphique de l'installateur
*
* Revision 1.27  2006/10/06 10:35:38  alexandre_tb
* correction du lien vers l'inscription.
*
* Revision 1.26  2006/10/05 18:38:36  ddelon
* reglage inititialisation base de donnes : authorisation utilisateur
*
* Revision 1.25  2006/10/05 17:56:37  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.24  2006/10/05 17:39:35  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.23  2006/10/05 17:16:21  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.22  2006/10/05 16:44:02  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.21  2006/10/05 16:39:01  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.20  2006/10/05 16:25:58  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.19  2006/10/05 15:38:22  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.18  2006/10/05 15:27:53  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.17  2006/10/05 15:04:00  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.16  2006/10/05 15:00:56  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.15  2006/10/05 14:41:12  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.14  2006/10/05 14:24:58  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.13  2006/10/05 14:01:21  ddelon
* Gestion hooks creation base de donnee
*
* Revision 1.12  2005/09/23 14:20:23  florian
* nouvel habillage installateur, plus correction de quelques bugs
*
* Revision 1.11  2004/11/03 17:31:13  jpm
* Corrections bogues erreurs noms de variables (suite).
*
* Revision 1.10  2004/11/03 17:26:19  jpm
* Corrections bogues erreurs noms de variables.
*
* Revision 1.9  2004/10/27 11:43:32  jpm
* Correction bogues diff mise ï¿½ jour / installation.
*
* Revision 1.8  2004/10/26 18:41:12  jpm
* Correction bogue pour la mise ï¿½ jour.
*
* Revision 1.7  2004/10/25 16:26:35  jpm
* Dï¿½but gestion des mises ï¿½ jours.
*
* Revision 1.6  2004/10/25 10:22:48  jpm
* Correction de quelques bogues, ajouts d'explications pour l'utilisateur et modification des styles CSS.
*
* Revision 1.5  2004/10/22 17:56:28  jpm
* Correction erreur auth.
*
* Revision 1.4  2004/10/22 17:23:04  jpm
* Simplification del'installation de Papyrus.
*
* Revision 1.3  2004/10/19 16:47:28  jpm
* Transformation en fonction de l'appel de l'application.
*
* Revision 1.2  2004/10/19 15:59:18  jpm
* Ajout de la gestion des valeurs propre ï¿½ Papyrus ï¿½ insï¿½rer dans la base de donnï¿½es.
* Ajout des constantes FTP.
*
* Revision 1.1  2004/10/15 18:28:59  jpm
* Dï¿½but appli installateur de Papyrus.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>