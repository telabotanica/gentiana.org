<?php

// +----------------------------------------------------------------------------+
// |car_config.inc.php                                                            |
// +----------------------------------------------------------------------------+
// | Copyright (c) 2004 Tela Botanica                                            |
// +----------------------------------------------------------------------------+
// | Le module d'inscription am�lior�, configuration                            |
// +----------------------------------------------------------------------------+
// | Auteur : Alexandre Granier <alexandre@tela-botanica.org>                     |
// +----------------------------------------------------------------------------+
//
// $Id: cartographie.config.inc.php,v 1.2 2006/04/04 12:23:05 florian Exp $

//==================================== CONSTANTES ==================================
// Constantes
//==================================================================================
define ('INS_MAIL_ADMIN', 'florian@ecole-et-nature.org') ;     // L'email de l'administrateur de la carto pour envoyer un message en double
define ('INS_NECESSITE_LOGIN', 0) ;     // Precise si les infos sont visibles pour tous (mettre 0) ou pour les identifies seulement (mettre 1)
define ('INS_ECHELLE_DEPART', 'europe') ;     // Affiche l'�chelle de d�part � afficher pour la carto
define ('INS_AFFICHE_ECHELLE', 1) ;     // Affiche l'�chelle de la carto  (mettre 1) ou non  (mettre 0)
define ('INS_AFFICHE_ZONE_ROUGE', 1) ;  // Affiche la liste d�roulante permettant de mettre une zone au choix en rouge pour la reconnaitre  (mettre 1) ou non  (mettre 0)
?>