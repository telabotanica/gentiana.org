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
// | Copyright  2003  Jean-Pascal MILCENT                                                                 |
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
// CVS : $Id: instal_fichier.inc.php,v 1.36 2007-08-28 14:37:11 jp_milcent Exp $
/**
* Page de creation des fichiers necessaire a l'installation de Papyrus.
*
* Page permettant de creer le fichier de configuration de Papyrus.
*
*@package Installateur
//Auteur original :
*@author        Hendrik MANS <hendrik@mans.de>
//Autres auteurs :
*@author        David DELON
*@author        Patrick PAUL
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.36 $ $Date: 2007-08-28 14:37:11 $
// +------------------------------------------------------------------------------------------------------+
**/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTï¿½TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// Numéro de l'étape d'installation :
$num_etape = 3;

// Initialisation du tableau contenant les valeurs de configuration de la base de données
$tableau = array(   'PAP_FTP_SERVEUR' => '', 'PAP_FTP_PORT' => '', 'PAP_FTP_UTILISATEUR' => '', 
                    'PAP_FTP_MOT_DE_PASSE' => '', 'PAP_FTP_RACINE' => '');
foreach ($tableau as $cle => $val) {
    if (!empty($_POST['fichier'][$cle])) {
        $fichier[$cle] = $_POST['fichier'][$cle];
    } else if (defined($cle)) {
        $fichier[$cle] = constant($cle);
    } else {
        if ($cle == 'PAP_FTP_SERVEUR') {
            $fichier[$cle] = $_SERVER['HTTP_HOST'];
        } else if ($cle == 'PAP_FTP_PORT') {
            $fichier[$cle] = 21;
        } else {
            $fichier[$cle] = '';
        }
    }
}

// Récupération des paramêtres de configuration du formulaire précédent
if (isset($_POST['pref_serial'])) {
    $pref = unserialize(stripslashes($_POST['pref_serial']));
}
if (isset($_POST['bdd'])) {
    $bdd = $_POST['bdd'];
} else if (isset($_POST['bdd_serial'])) {
    $bdd = unserialize(stripslashes($_POST['bdd_serial']));
}

// +------------------------------------------------------------------------------------------------------+
// |                                          CORPS du PROGRAMME                                          |
// +------------------------------------------------------------------------------------------------------+
// Affichage d'informations...
$sortie .= '<br /><h1>Étape n&deg;'.$num_etape.' sur '.INSTAL_NBRE_ETAPE.'.</h1>'."\n";

// Correction éventuelle des informations saisies par l'utilisateur
if (ereg('^[\/\\]', $fichier['PAP_FTP_RACINE']) == false) {
    // le chemin FTP ne doit pas commencer par un slash, nous le supprimons
    $fichier['PAP_FTP_RACINE'] = GEN_SEP.$fichier['PAP_FTP_RACINE'];
}

// Nous vérifions si nous sommes en phase de test du formulaire de config de l'écriture de fichier
$erreur = 0;
$sortie_verif = '';
if ($_GET['installation'] == 'verif_fichier') {
    // Test de la configuration du FTP
    $sortie_verif .= '    <br /><h2>Test de la connexion FTP</h2>'."\n";
    $erreur = testerConfig($sortie_verif, 'Test connexion FTP ...', $ftp = @ftp_connect($fichier['PAP_FTP_SERVEUR'], $fichier['PAP_FTP_PORT']), '', 1, $erreur);
    $erreur = testerConfig($sortie_verif, 'Test identification sur le serveur FTP ...', @ftp_login($ftp, $fichier['PAP_FTP_UTILISATEUR'],
                            $fichier['PAP_FTP_MOT_DE_PASSE']), 'Les param&ecirc;tres FTP saisies ne permettent pas l\'identification !', 1, $erreur);
    $sortie_verif .= '<br />'."\n";
    
    $configCode = "<?php\n// pap_config.inc.php construit le ".strftime("%c")."\n// ne changez pas la version de Papyrus manuellement!\n\n";
    $entries[] = 'define(\''.INSTAL_VERSION_NOUVELLE_NOM.'\',\''.INSTAL_VERSION_NOUVELLE.'\');'."\n";
    foreach ($bdd as $cle => $val) {
        $entries[] = 'define(\''.$cle.'\',\''.$val.'\');'."\n";
    }
    $entries[] = "define('PAP_DSN', 'mysql://'.PAP_BDD_UTILISATEUR.':'.PAP_BDD_MOT_DE_PASSE.'@'.PAP_BDD_SERVEUR.'/'.PAP_BDD_NOM);"."\n";
    foreach ($fichier as $cle => $val) {
        $entries[] = 'define(\''.$cle.'\',\''.$val.'\');'."\n";
    }
    foreach ($pref as $cle => $val) {
        // Nous recuperons uniquement les constantes a stocker dans le fichier de config (leur nom commence par PAP_)
        if (preg_match('/^PAP_/', $cle)) {
            if (preg_match('/^[0-9]+|(?i:true|false)$/', $val)) {
                $entries[] = 'define(\''.$cle.'\','.$val.');'."\n";
            } else {
                $entries[] = 'define(\''.$cle.'\',\''.$val.'\');'."\n";
            }
        }
    }
    $configCode .= implode("\n", $entries)."\n\n?>";
    if ($erreur == 0) {
		// +-----------------------------------------------------------------------------------------------------------+
		// Tentative d'écriture du fichier de config
	    $sortie_verif .= '    <h2>Ecriture des fichiers sur le serveur par FTP</h2>'."\n";
	    $chemin_fpt_absolu = $fichier['PAP_FTP_RACINE'].INSTAL_CHEMIN_CONFIG;
	    $url_ftp =  'ftp://'.$fichier['PAP_FTP_UTILISATEUR'].':'.$fichier['PAP_FTP_MOT_DE_PASSE'].
			'@'.$fichier['PAP_FTP_SERVEUR'].$chemin_fpt_absolu;
	    
	    // Dans le cas, ou nous mettons à jour Papyrus, il faut supprimer l'ancien fichier de config
	    if (INSTAL_VERSION_ANCIENNE != '') {
			$txt_suppression = 'Suppression de <tt>'.$chemin_fpt_absolu.'</tt>...';
			$txt_suppression_erreur =   '<p>Le fichier <tt>'.$chemin_fpt_absolu.'</tt> ne peut &ecirc;tre supprimer automatiquement. '.
									    'Veuillez utiliser un logiciel de transfert de fichier par FTP pour le supprimer.</p>';
			$erreur = testerConfig($sortie_verif, $txt_suppression, unlink($url_ftp), $txt_suppression_erreur, 1, $erreur);
	    }
	    
	    $tempfn = tempnam('','');
		$temp = fopen($tempfn, 'w');

		fwrite($temp, $configCode);
		fclose($temp);
		$fichier_config_source = $tempfn;
    	$fichier_config_cible = $fichier['PAP_FTP_RACINE'].'papyrus/configuration/pap_config.inc.php';
    	
	    // Nous écrivons le fichier de config sur le disque
	    $txt_ecriture_conf = '&Eacute;criture sur le serveur de <tt>'.$fichier_config_cible.'</tt>...';
	    $txt_ecriture_conf_erreur = '<span class="failed">AVERTISSEMENT:</span> Le fichier de configuration <tt>'.$fichier_config_cible.
			'</tt> n\'a pu &ecirc;tre cr&eacute;&eacute;. Veuillez vous assurez que votre serveur a les droits '.
			'd\'acc&egrave;s en &eacute;criture pour ce fichier. Si pour une raison quelconque vous ne pouvez pas '.
			'faire &ccedil;a vous devez copier les informations suivantes dans un fichier et les transf&eacute;rer '.
			'au moyen d\'un logiciel de transfert de fichier (ftp) sur le serveur dans un fichier '.
			'<tt>pap_config.inc.php</tt> directement dans le r&eacute;pertoire <tt>configuration</tt> du répertoire '.
			'<tt>papyrus</tt> de Papyrus. Une fois que vous aurez fait cela, votre site Papyrus devrait fonctionner '.
			'correctement.';	    
	    $txt_ecriture_conf_erreur .= '<div class="code"><code><pre>'.htmlentities($configCode).'</pre></code></div>'."\n";	    
	    $erreur = testerConfig($sortie_verif, $txt_ecriture_conf, 
	    						ftp_put($ftp, $fichier_config_cible, $fichier_config_source, FTP_ASCII), 
	    								$txt_ecriture_conf_erreur, 1, $erreur);

		// +-----------------------------------------------------------------------------------------------------------+
	    // Tentative d'écriture du fichier .htaccess
	    $fichier_htaccess_chemin = $fichier['PAP_FTP_RACINE'].'.htaccess';
	    $url_ftp_htaccess = 'ftp://'.$fichier['PAP_FTP_UTILISATEUR'].':'.$fichier['PAP_FTP_MOT_DE_PASSE'].
			'@'.$fichier['PAP_FTP_SERVEUR'].$fichier['PAP_FTP_RACINE'].'/.htaccess';
		if (isset($pref['PAP_HTACCESS_REGENERATION']) && $pref['PAP_HTACCESS_REGENERATION'] == 1) {
			$txt_suppression_htaccess = 'Suppression de <tt>'.$fichier_htaccess_chemin.'</tt>...';
			$txt_suppression_htaccess_erreur =	'<p>Le fichier <tt>'.$fichier_htaccess_chemin.'</tt> ne peut &ecirc;tre supprimer automatiquement. '.
												'Veuillez utiliser un logiciel de transfert de fichier par FTP pour le supprimer.</p>';
			$erreur = testerConfig($sortie_verif, $txt_suppression_htaccess, unlink($url_ftp_htaccess), $txt_suppression_htaccess_erreur, 1, $erreur);
		}
		$url_parse = parse_url('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$prefixe = dirname($url_parse['path']);
		// Gestion des urls du style : http://www.tela-botanica.org/~mon_home/
		$prefixe_tilde = '';
		if (preg_match('/^\/~/', $prefixe)) {
			$prefixe_tilde = $prefixe.'/';
		}
		
		$url = 'http://'.$_SERVER['HTTP_HOST'].$prefixe;
		if (isset($pref['PAP_URL_REECRITURE']) && $pref['PAP_URL_REECRITURE'] == 1) {
			$on_off = 'on';
		} else {
			$on_off = 'off';
		}
		$contenu_htaccess = '# Raccourci pour les menus et sites de Papyrus'."\n".
							'RewriteEngine '.$on_off."\n".
							'# si le fichier ou le dossier existe dans le système de fichier on l\'utilise directement'."\n".
							'RewriteCond %{REQUEST_FILENAME} !-d'."\n".
							'RewriteCond %{REQUEST_FILENAME} !-f'."\n\n".
							'# Réecriture d\'url pour valider les inscriptions'."\n".
							'RewriteRule ^ins_([0-9a-z]*)$ page:inscription?id=$1 [QSA,L]'."\n".
							'# Réecriture d\'url pour les applications de Papyrus n\'utilisant pas correctement Pap_URL'."\n".
							'# ATTENTION : ne marche pas pour les formulaires en mode POST !'."\n".
							'RewriteRule ^([^\/]+)&(.*)$ '.$url.'/$1?$2 [QSA,L,R=301]'."\n".
							'# Réecriture d\'url pour les vieux permaliens'."\n".
							'RewriteCond %{REQUEST_FILENAME}/ !-d'."\n".
							'RewriteRule ^([^\/\?:.]+)$ '.$url.'/page:$1 [QSA,L,R=301]'."\n".
							'# Redirection d\'url pour le sélecteur de site'."\n".
							'# Le point d\'interrogation sans rien aprés, vide la QUERY_STRING sinon elle est concacténée à l\'url et cela plante...'."_n".
							'# Le "/" initial dans la RewriteCond est obligatoire!'."\n".
							'RewriteCond %{REQUEST_URI}?%{QUERY_STRING} ^'.$prefixe.'/papyrus\.php\?site=([^&]+)$'."\n".
							'RewriteRule ^papyrus.php$ '.$url.'/site:%1? [L,R=301]'."\n\n".
							'# Réecriture d\'url pour les sites de Papyrus : à modifier si les valeurs par défaut ont été changées'."\n".
							'RewriteRule ^site:.+$ '.$prefixe_tilde.'papyrus.php [QSA,L]'."\n".
							'# Réecriture d\'url pour les menus de Papyrus : à modifier si les valeurs par défaut ont été changées'."\n".
							'RewriteRule ^page:.+$ '.$prefixe_tilde.'papyrus.php [QSA,L]'."\n\n".
							'# Gestion des erreurs 404'."\n".
							'ErrorDocument 404 '.$prefixe.'/erreur_http.php?erreur=404';
		
		if (file_exists($fichier_htaccess_chemin)) {
			$sortie_verif .='<p>Attention: Un fichier .htaccess est d&eacute;j&agrave; pr&eacute;sent sur le serveur.'.
							'<br />'.$fichier_htaccess_chemin.
							'<br />Veillez &agrave; le configurer correctement<br /><br />'.
							'Contenu par d&eacute;faut: <br /><br /> ErrorDocument 404 /erreur_404.php';
		} else {
			$tempfn = tempnam('', '');
			$temp = fopen($tempfn, 'w');
			fwrite($temp, $contenu_htaccess);
			fclose($temp);
			$fichier_config_source = $tempfn;
    		$fichier_config_cible = $fichier_htaccess_chemin;
    		$txt_ecriture_conf_erreur = 'AVERTISSEMENT: Le fichier .htaccess <tt>'.$fichier_config_cible.
			'</tt> n\'a pu &ecirc;tre cr&eacute;&eacute;. Veuillez vous assurez que votre serveur a les droits '.
			'd\'acc&egrave;s en &eacute;criture pour ce fichier. Si pour une raison quelconque vous ne pouvez pas '.
			'faire &ccedil;a vous devez copier les informations suivantes dans un fichier et les transf&eacute;rer '.
			'au moyen d\'un logiciel de transfert de fichier (ftp) sur le serveur dans un fichier '.
			'<tt>.htaccess</tt> directement &agrave la racine de '.
			'<tt>papyrus</tt> de Papyrus.';
			$txt_ecriture_conf_erreur .= '<div class="code"><code><pre>'.htmlentities($contenu_htaccess).'</pre></code></div>'."\n";
			$txt_ecriture_conf = '&Eacute;criture sur le serveur du fichier .htaccess... <tt>'.$fichier_config_cible.'</tt>'."\n";	
			$erreur = testerConfig($sortie_verif, $txt_ecriture_conf, ftp_put($ftp, $fichier_config_cible,$fichier_config_source, FTP_ASCII), $txt_ecriture_conf_erreur, 1, 0);

		}
//	   maj_fichier_config_appli($ftp,$fichier,'api/fckeditor/editor/filemanager/browser/default/connectors/php/config.php',array("Caldeira"=>"DDDDD"));
	}
}


// Mise à jour des fichiers de configuration de chaque application :
function maj_fichier_config_appli($ftp, $fichier, $fichierconfig, $elements) {
	$tempfn = tempnam('', '');
	ftp_get($ftp,$tempfn,$fichier['PAP_FTP_RACINE'].$fichierconfig,FTP_ASCII);
	$fp = fopen($tempfn, 'r');
	if ($fp) {
		while (!feof($fp)) {
			$cont .= fread($fp, 500);
		}	
		fclose($fp);		
		$fp = fopen($tempfn, 'w');
		if ($fp) {
			foreach ($elements as $element) {
				list($expr,$rempl)=$elements;
				preg_replace('/'.$expr.'/',$rempl,$cont);
			}
			fwrite($fp, $cont);
		    fclose($fp);		
		    ftp_put($ftp, $fichier['PAP_FTP_RACINE'].$fichierconfig, $tempfn, FTP_ASCII);
		}
	}	
}

// Gestion de l'affichage
if ($erreur == 0 && empty($sortie_verif)) {
    // Premier appel du fichier...
    $sortie .= creerFormulaire($fichier);
    $sortie .= '<li><input type="hidden" name="pref_serial" value="'.htmlentities(serialize($pref)).'" /></li>'."\n";
    $sortie .= '<li><input type="hidden" name="bdd_serial" value="'.htmlentities(serialize($bdd)).'" /></li>'."\n";
    $sortie .= '<li><input type="submit" value="Tester" /></li>'."\n";
    $sortie .= '      </ul>'."\n";
    $sortie .= '    </form>';
} else if ($erreur == 2 && !empty($sortie_verif)) {
    // Verification du fichier avec interuption...
    $sortie .= creerFormulaire($fichier);
    $sortie .= '<li><input type="hidden" name="pref_serial" value="'.htmlentities(serialize($pref)).'" /></li>'."\n";
    $sortie .= '<li><input type="hidden" name="bdd_serial" value="'.htmlentities(serialize($bdd)).'" /></li>'."\n";
    $sortie .= '<li><input type="submit" value="Tester &agrave; nouveau" /></li>'."\n";
    $sortie .= '      </ul>'."\n";
    $sortie .= '    </form>';
    $sortie .= $sortie_verif;
} else if (($erreur == 0 || $erreur == 1) && !empty($sortie_verif)) {
    // Verification du fichier sans interuption... passage a l'etape suivante
    $sortie .= creerFormulaire($fichier, true);
    $sortie .= '      </ul>'."\n";
    $sortie .= '    </form>';
    $sortie .= $sortie_verif;
    // Ecriture du fichier...
    fwrite($fp, $configCode);
    fclose($fp);
    $sortie .= '    <br /><p class="etape_info">Voila c\'est termin&eacute; ! Vous pouvez <a href="'.donnerUrlCourante().'">retourner sur votre site '.
                'Papyrus</a>. Il est conseill&eacute; de retirer l\'acc&egrave;s en &eacute;criture au fichier '.
                '<tt>pap_config.inc.php</tt>. Ceci peut &ecirc;tre une faille dans la s&eacute;curit&eacute;.</p>'."\n";
}

// +------------------------------------------------------------------------------------------------------+
// |                                            LISTE DES FONCTIONS                                       |
// +------------------------------------------------------------------------------------------------------+

// Creation du formulaire de configuration de la base de donnees
function creerFormulaire($fichier, $bln_lecture = false) {
    $disabled = '';
    if ($bln_lecture) {
        $disabled = ' disabled="disabled" ';
    }
    $sortie_form .= '    <form action="'.donnerUrlCourante().'?installation=verif_fichier" method="post">';
    $sortie_form .= '      <ul>'."\n";
    $sortie_form .=  '<li><br /><h2>Configuration du FTP et des chemins d\'acc&egrave;s</h2></li>'."\n";
    $sortie_form .= '<li>Entrer le nom de dommaine pour acc&eacute;der &agrave; votre d&eacute;p&ocirc;t FTP</li>'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="ftp_serveur">Nom du serveur FTP :</label>'.
                '<input id="ftp_serveur"'.$disabled.'type="text" size="30" name="fichier[PAP_FTP_SERVEUR]" value="'.$fichier['PAP_FTP_SERVEUR'].'" />'.
                '</li>'."\n";
    $sortie_form .= '<li>Le num&eacute;ro du port pour le service FTP sur la machine h&eacute;bergeant Papyrus. '.
                    'En g&eacute;n&eacute;ral c\'est 21.</li>'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="ftp_port">N&deg; du port d\'acc&egrave;s au serveur FTP :</label>'.
                '<input id="ftp_port"'.$disabled.'type="text" size="20" name="fichier[PAP_FTP_PORT]" value="'.$fichier['PAP_FTP_PORT'].'" />'.
                '</li>'."\n";
    $sortie_form .=  '<li>Nom et mot de passe FTP qui sera utilis&eacute; pour se connecter &agrave; au d&eacute;p&ocirc;t FTP.</li>'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="ftp_utilisateur">Nom d\'utilisateur pour le serveur FTP :</label>'.
                '<input id="ftp_utilisateur"'.$disabled.'type="text" size="20" name="fichier[PAP_FTP_UTILISATEUR]" value="'.$fichier['PAP_FTP_UTILISATEUR'].'" />'.
                '</li>'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="ftp_mot_de_passe">Mot de passe pour le serveur FTP :</label>'.
                '<input id="ftp_mot_de_passe"'.$disabled.'type="password" size="20" name="fichier[PAP_FTP_MOT_DE_PASSE]" value="'.$fichier['PAP_FTP_MOT_DE_PASSE'].'" />'.
                '</li>'."\n";
    $sortie_form .=  '<li>Lorsque vous vous connectez par FTP sur le serveur o&ugrave; vous avez d&eacute;pos&eacute; les fichiers de Papyrus, le '.
                'dossier le plus haut auquel vous pouvez acc&eacute;der dans l\'arborescence est la racine. Il vous faut donc '.
                'indiquez dans le champ ci-dessous le chemin absolu depuis cette racine jusqu\'au dossier contenant le fichier '.
                '<tt>papyrus.php</tt>. Exemple : <i>/www/</i></li>'."\n";
    $sortie_form .=  '<li>'."\n".
                '<label for="ftp_racine">Racine d&eacute;p&ocirc;t FTP :</label>'.
                '<input id="ftp_racine"'.$disabled.'type="text" size="60" name="fichier[PAP_FTP_RACINE]" value="'.$fichier['PAP_FTP_RACINE'].'" />'.
                '</li>'."\n";
    $sortie_form .= '<li>Si vous voulez générer un nouveau fichier .htaccess, cochez cette case (si vous ne savez pas ce qu\'est un fichier .htaccess '.
                    'n\'activez pas cette option).</li>'."\n";
	$sortie_form .=  '<li>'."\n".
                '<label for="htaccess_regeneration">Remplacer mon fichier .htacces :</label>'.
                '<input id="htaccess_regeneration"'.$disabled.'type="checkbox" name="pref[PAP_HTACCESS_REGENERATION]" value="1" />'.
                'Activation'.'</li>'."\n";
    return $sortie_form;
}

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: instal_fichier.inc.php,v $
* Revision 1.36  2007-08-28 14:37:11  jp_milcent
* Ajout des urls par défaut pour l'inscription et inscription_erreur.
*
* Revision 1.35  2007-06-26 12:08:18  jp_milcent
* Correction de l'encodage et de la création du htaccess.
*
* Revision 1.34  2007-04-20 14:55:24  alexandre_tb
* charset
*
* Revision 1.33  2007/04/20 12:55:07  ddelon
* config fckeditor
*
* Revision 1.32  2007/04/20 12:49:41  ddelon
* config fckeditor
*
* Revision 1.31  2007/04/20 10:15:15  alexandre_tb
* correction typo
*
* Revision 1.30  2007/04/20 09:18:09  alexandre_tb
* correction pb encodage
*
* Revision 1.29  2007/04/20 09:13:37  alexandre_tb
* correction pb encodage
*
* Revision 1.28  2007/04/20 09:05:46  alexandre_tb
* correction pb encodage
*
* Revision 1.27  2007/04/19 16:53:57  neiluj
* fix de l'upload des fichiers de conf (ftp_put)
*
* Revision 1.26  2007/04/19 15:34:35  neiluj
* préparration release (livraison) "Narmer" - v0.25
*
* Revision 1.25  2006/12/01 15:43:01  alexandre_tb
* prise en compte dans le rewriteengine de l'activation ou non de la reecriture
*
* Revision 1.24  2006/12/01 11:47:10  alexandre_tb
* suppression de var_dump
*
* Revision 1.23  2006/12/01 11:46:11  alexandre_tb
* correction creation .htaccess
*
* Revision 1.22  2006/11/30 17:41:30  alexandre_tb
* ecriture htaccess
*
* Revision 1.21  2006/11/30 17:36:29  alexandre_tb
* ecriture htaccess
*
* Revision 1.20  2006/11/30 16:41:42  alexandre_tb
* ecriture htaccess
*
* Revision 1.19  2006/11/30 15:50:25  ddelon
* installation fichier
*
* Revision 1.18  2006/11/30 15:34:51  alexandre_tb
* ecriture htaccess
*
* Revision 1.17  2006/11/30 15:27:31  alexandre_tb
* ecriture htaccess
*
* Revision 1.16  2006/11/30 14:52:42  alexandre_tb
* Ecriture du fichier htaccess lors de l installation
*
* Revision 1.15  2006/10/09 14:35:27  ddelon
* bug caractere invalie trainant dans fichier
*
* Revision 1.14  2006/10/06 15:34:30  florian
* mise en commentaire .htaccess
*
* Revision 1.13  2006/10/06 15:23:00  florian
* amelioration graphique de l'installateur
*
* Revision 1.12  2006/10/06 14:49:45  ddelon
* ecriture htaccess a l'installation
*
* Revision 1.11  2006/10/06 14:46:15  alexandre_tb
* ecriture du fichier .htaccess
*
* Revision 1.10  2005/09/23 14:20:23  florian
* Nouvel habillage installateur, plus correction de quelques bugs
*
* Revision 1.9  2005/04/12 16:09:45  jpm
* Amélioration de la gestion de la constante de redirection des urls et de la gestion des constantes de type entier et booléen.
*
* Revision 1.8  2004/10/25 16:26:35  jpm
* Début gestion des mises à jours.
*
* Revision 1.7  2004/10/25 10:22:48  jpm
* Correction de quelques bogues, ajouts d'explications pour l'utilisateur et modification des styles CSS.
*
* Revision 1.6  2004/10/22 17:39:14  jpm
* Correction gestion du slash devant le chemin racine ftp.
*
* Revision 1.5  2004/10/22 17:23:04  jpm
* Simplification del'installation de Papyrus.
*
* Revision 1.4  2004/10/19 17:01:12  jpm
* Correction bogues.
*
* Revision 1.3  2004/10/19 15:59:18  jpm
* Ajout de la gestion des valeurs propre à Papyrus à insérer dans la base de données.
* Ajout des constantes FTP.
*
* Revision 1.2  2004/10/18 09:12:09  jpm
* Changement de nom d'un fichier.
*
* Revision 1.1  2004/10/18 09:11:05  jpm
* Changement de nom du fichier.
*
* Revision 1.1  2004/10/15 18:28:59  jpm
* Début appli installateur de Papyrus.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>