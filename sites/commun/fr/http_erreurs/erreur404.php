<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Page introuvable</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-language" content="fr" />
    <meta name="revisit-after" content="15 days" />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="author" content="Papyrus" />
    <meta name="description" content="Page d'erreur 404." />
  </head>
  <body>
      <h1>Page introuvable</h1>
      <p>
        L'URL requise n'a pu etre trouv&eacute;e sur ce serveur.
        La r&eacute;f&eacute;rence sur  <a href="<?php echo $_REQUEST['url']; ?>">la page <?php echo $_REQUEST['url']; ?></a> semble &ecirc;tre erron&eacute;e ou perim&eacute;e.
        N'h&eacute;sitez pas &agrave; envoyer un courriel pour signaler ce probl&egrave;me.
      </p>
  </body>
</html>