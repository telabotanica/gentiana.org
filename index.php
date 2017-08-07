<?php
/**
* gentiana - index.php
*
* Description :
*
*@package gentiana
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/
define('MAGPIE_DIR', 'api/syndication_rss/magpierss/');
define('MAGPIE_CACHE_DIR', 'tmp/magpie_cache');
define('MAGPIE_CACHE_ON', true);
define('RSS_URL', 'http://www.gentiana.org/page:actu_rss');//http://www.tela-botanica.org/actu/backend.php3
define('RSS_DESCRIPTION_LONGUEUR', 200);
require_once MAGPIE_DIR.'rss_fetch.inc';
require_once 'accueil/class.html2text.inc';
$rss = fetch_rss(RSS_URL);
function recupererImage($txt)
{
	if (preg_match('/<img .*src="([^"]+)"/', $txt, $match)) {
		return array('src' => $match[1], 'alt' => $match[2]);
	}
	return false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Gentiana</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<meta http-equiv="Content-style-type" content="text/css" />
		<meta http-equiv="Content-script-type" content="text/javascript" />
		<meta http-equiv="Content-language" content="fr" />
		<meta name="robots" content="noindex,nofollow" />
		<meta name="author" content="Tela Botanica" />
		<meta name="keywords" content="Gentiana, association, botanique, botanistes, isère, langue française, France, végétaux, nature, environnement, connaissance, protection, plante, plantes protégées, floristique, cartographie, découvrir, fleurs." />
		<meta name="description" content="Sites web de l'association Gentiana" />
		<link rel="stylesheet" type="text/css" media="screen" href="accueil/accueil_simple.css" />
		<style type="text/css" media="screen"><!-- @import "accueil/accueil_prairie.css"; --></style>
		<link rel="stylesheet" type="text/css" media="print" href="accueil/impression.css" />
		<link rel="alternate stylesheet" type="text/css" media="screen" href="accueil/accueil_bas_debit.css" title="Connexion bas débit" />
	</head>
	<body>
		<div id="centrage">
			<div id="cartouche">
				<h1><a href="/" title="Retour à la page d'accueil"><img id="logo_gentiana" src="accueil/logo_gentiana.png" alt="Gentiana"/></a></h1>
				<div id="zone_sites">
					<h1 id="titre_sites">Sites de l'association Gentiana</h1>
					<ul id="liste_sites">
						<li id="site_asso_gentiana"><a href="http://www.gentiana.org/site:gentiana">L'association Gentiana</a></li>
						<li id="site_flore_isere"><a href="http://www.gentiana.org/site:flore">La flore de l'Isère</a></li>
						<li id="site_gestion_raisonnable"><a href="http://www.gentiana.org/site:gestion">La gestion raisonnable</a></li>
						<!-- <li id="site_animation_botanique"><a href="http://www.gentiana.org/site:animation">Animation botanique</a></li> -->
					</ul>
				</div>
				<div id="zone_actu">
					<h1 id="titre_actu" title="<?=$rss->channel['title'];?>">Actualités &bull; Agenda</h1>
					<ul id="liste_actu">
					<?php foreach ($rss->items as $item) : ?>
						<?php 
							// Si Atom nous remplissons le champ description
							if (isset($item['atom_content']) && !isset($item['description'])) {
								$item['description'] = $item['atom_content'];
							}
							// Récupération d'une image présente dans le txt
							$image = recupererImage($item['description']);
							if ($image) {
								$item['image'] = $image;
							}
							// Nettoyage du html
							$h2t = new html2text($item['description']);
							$item['description'] = $h2t->get_text();
						?>
						<li class="rss_actu">
							<h2 class="rss_titre"><a href="<?=$item['link']; ?>"><?=$item['title']; ?></a></h2>
							<?php if ($image) : ?>
							<img class="rss_image" src="<?=$item['image']['src'];?>" alt="<?=$item['image']['alt'];?>" width="50" height="50"/>
							<?php endif; ?>
							<p class="rss_date">Publié le <?=strftime('%d.%m.%Y',strtotime($item['pubdate'])); ?></p>
							<p class="rss_description"><? echo substr($item['description'],0, RSS_DESCRIPTION_LONGUEUR).'...'; ?></p>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
				<div id="zone_logos">
					<h1 id="titre_logos">Les partenaires de Gentiana</h1>
					<ul id="liste_logos">
						<li id="logo_cg_isere"><a href="http://www.cg38.fr/" title="Aller sur le site du Conseil Générale de l'Isère"><img src="accueil/logo_cg_isere.png" alt="Conseil Générale de l'Isère"/></a></li>
						<li id="logo_tela_botanica"><a href="http://www.tela-botanica.org/" title="Aller sur le site de Tela Botanica"><img src="http://resources.tela-botanica.org/tb/img/128x128/logo_foncesurfondclair.png" alt="Tela Botanica" style="width: 70px;"/></a></li>
						<li id="logo_rhone_alpes"><a href="http://www.rhonealpes.fr/" title="Aller sur le site de Rhône-Alpes"><img src="accueil/logo_rhone_alpes.png" alt="Rhônes-Alpes"/></a></li>
					</ul>
				</div>
			</div>        
		</div>
		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
		<script type="text/javascript">_uacct = "UA-2735398-1";urchinTracker();</script>
	</body>
</html>
