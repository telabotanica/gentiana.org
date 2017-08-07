<?php
/** Inclusion du fichier principal de l'application (eflore)*/
require_once 'eflore.php';
$contenu_navigation = afficherContenuNavigation();
$contenu_tete = afficherContenuTete();
$contenu_corps = afficherContenuCorps();
$titre = $GLOBALS['_EFLORE_']['titre'];
$contenu_pied = afficherContenuPied();
$contenu_menu = afficherContenuMenu();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
	<head xml:lang="fr" lang="fr">
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
		<meta http-equiv="Content-style-type" content="text/css" />
		<meta http-equiv="Content-script-type" content="text/javascript" />
		<meta http-equiv="Content-language" content="fr" />
		
		<title><?php echo $titre; ?></title>
		
		<meta name="revisit-after" content="15 days" />
		<meta name="robots" content="index,follow" />
		<meta name="author" content="Tela Botanica" />
		<meta name="description" content="L'application eFlore fonctionnant sans le gestionnaire de contenu Papyrus." />
		
		<script type="text/javascript" src="http://www.tela-botanica.org/sites/commun/fr/scripts/commun.js"></script>
		
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo EF_URL_CSS_TB_SIMPLE; ?>" />
		<style type="text/css" media="screen">
			@import "<?php echo EF_URL_CSS_TB_COMPLEXE; ?>";
			@import "<?php echo EF_URL_CSS_EFLORE; ?>";
			/*--------------------------------------------------------------------------------------------------------------*/
			/* Tableau du chronométrage du programme */
			#pied_texte #chrono {
				text-align: center;
				margin:0 auto;}
			#chrono table {
				display:block;
				border:3px solid #6495ed;
				border-collapse:collapse;}
			#chrono thead, tfoot {
				background-color:#D0E3FA;
				border:1px solid #6495ed;}
			#chrono tbody {
				background-color:#FFFFFF;
				border:1px solid #6495ed;}
			#chrono th {
				font-family:monospace;
				border:1px dotted #6495ed;
				padding:5px;
				background-color:#EFF6FF;
				width:25%;}
			#chrono td {
				font-family:sans-serif;
				font-size:80%;
				border:1px solid #6495ed;
				padding:5px;
				text-align:center;}
			#chrono caption {
				font-family:sans-serif;
				text-align: center;
				width:90%;
				margin:auto;}
			.debogage{
				color:black;
				border:3px solid #6495ed;}
			.debogage_fichier, .debogage_ligne{
				font-size:10px;
  				color:#A9A9A9;}
		</style>
		<link rel="stylesheet" type="text/css" media="print" href="<?php echo EF_URL_CSS_TB_IMPRESSION; ?>" />
		<link rel="shortcut icon" type="image/x-icon" href="http://www.tela-botanica.org/favicon.ico" />
		<link rel="icon" type="image/png" href="http://www.tela-botanica.org/sites/commun/generique/images/favicones/tela_botanica.png" />
    </head>
    <body xml:lang="fr" lang="fr">
    	<div id="reducteur">
      	<div id="logo_tela">
				<a href="/" title="Retour à l'accueil du site">
					<img src="http://www.tela-botanica.org/sites/reseau/generique/images/graphisme/logo_jaune.gif" alt="le logo de Tela Botanica"/>
				</a>
      	</div>
      	<div id="acces_direct">
				<a href="#nav_gauche">Aller aux menus</a> <a href="#contenu">Aller au texte</a>
			</div>
      	<div id="bandeau">
				<div id="bandeau_contenu">
					<div id="titre_monde"><h1>Flore électronique <sup>BETA</sup></h1></div>
          		<div id="plan_contact">&nbsp;</div>
				</div>
			</div>
      	<div id="droite">
				<div id="pos_recherche">
					<p>Vous êtes ici : 
					<a id="menu_1_38" href="http://www.tela-botanica.org/38" hreflang="fr" title="Flore électronique" name="menu_1_38">Flore électronique</a>
					<span class="separateur_vei">&gt;</span> France métropolitaine
	          	</p>
	        	</div>
				<div id="onglets">
		      	<?php echo $contenu_navigation; ?>
				</div>
				<div id="contenu">
					<div id="entete">
		            <?php echo $contenu_tete; ?>
					</div>
					<div id="texte">
		            <?php echo $contenu_corps; ?>
					</div>
					<div id="pied_texte">
						<?php
						echo $contenu_pied; 
						if (EF_DEBOGAGE) {
							$GLOBALS['_DEBOGAGE_'] .= $GLOBALS['_EFLORE_']['erreur']->retournerErreur();
							echo $GLOBALS['_DEBOGAGE_'];
						}
						if (EF_DEBOGAGE_CHRONO) {
							echo $GLOBALS['_EFLORE_']['chrono']->afficherChrono();
						}
						?>
					</div>
				</div>
			</div>
			<div id="nav_gauche">
				<div id="menus">
					<ul class="menu_classique_n1">
						<li class="menu_inactif"><a href="<?php echo EF_URL; ?>index.php">Accueil</a></li>
						<li class="menu_inactif"><a href="<?php echo EF_URL; ?>index.php?module=saisie">Saisie</a></li>
						<li class="menu_inactif">Chorologie						
							<ul class="menu_classique_n2">
								<li class="menu_inactif"><a href="<?php echo EF_URL; ?>index.php?module=chorologie&amp;action=acces_par_carte">Accés par carte</a></li>
								<li class="menu_inactif"><a href="<?php echo EF_URL; ?>index.php?module=chorologie&amp;action=acces_par_taxon">Accés par taxon</a></li>
								<li class="menu_inactif"><a href="<?php echo EF_URL; ?>index.php?module=chorologie&amp;action=acces_par_zone">Accés par zones</a></li>
							</ul>  
						</li>
						<li class="menu_inactif"><a href="<?php echo EF_URL; ?>index.php?module=recueil_de_donnees">Recueil de données</a></li>
						<li class="menu_inactif"><a href="<?php echo EF_URL; ?>index.php?module=commun&amp;action=test">Test</a></li>
					</ul>
				</div>
				<div id="menu_contextuel">
					<?php echo $contenu_menu; ?>
					<?php if (!defined(PAP_VERSION) AND $GLOBALS['_EFLORE_']['identification']->verifierIdentite()) : ?>
  					<p><a href="<?='http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'&amp;deconnexion=1';?>">Déconnexion</a></p> 
					<?php endif; ?>
				</div>
			</div>
			<div id="pied">
				<p> &copy;<a href="http://www.tela-botanica.org/" accesskey="1">Tela Botanica</a> / 2000-2004 - Le réseau des Botanistes Francophones</p>
			</div>
		</div>
	</body>
</html>


