<?php
 ##     Traduction française pour Phorum 5.1.6a
 ##    -----------------------------------------------------------------
 ##     Version : 5.1.6a-FR-1.1.0
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 18/01/2006 
 ##     Modifications :
 ##     * Modifications pour la version 5.1.6a
 ##	* Les entrées données comme 'Deprecated' ont été maintenues
 ##	* car elles sont dans english.php livré avec la 5.1.6a
 ##	* et certaines sont nouvelles !?!
 ##    	* Quelques corrections d'orthographe et de sens
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.20-FR-1.0.11
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 01/12/2005 
 ##     Modifications :
 ##      * Remplacement de mél par adresse électronique ou courriel selon le contexte
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.20-FR-1.0.10
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 22/11/2005 
 ##     Modifications :
 ##      * Modification locale pour fr_FR
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.20-FR-1.0.9
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 14/11/2005 
 ##     Modifications :
 ##      * Correction orthographe : MsgRedirect
 ##      * Remplacement de prévisualisation par aperçu
 ##      * Modification de YouWantToFollow
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.20-FR-1.0.8
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 24/10/2005 
 ##     Modifications :
 ##      * Validation Phorum 5.0.20
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.19-FR-1.0.7
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 24/10/2005 
 ##     Modifications :
 ##      * Modification ConfirmReportMessage
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.19-FR-1.0.6
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 19/10/2005 
 ##     Modifications :
 ##      * Modification ViewJoinGroups
 ##    	* Modification DateActive
 ##      * Modification DateReg
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.19-FR-1.0.5
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 19/10/2005 
 ##     Modifications :
 ##      * Validation sur Phorum 5.0.19
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.16-FR-1.0.4
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 19/10/2005 
 ##     Modifications :
 ##      * Remplacement de Unbookmark par Enlever le signet
 ##    	* Correction de quelques coquilles
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.16-FR-1.0.2
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 15/07/2005 
 ##     Modifications :
 ##      * Remplacement de "Soumettre" par "Appliquer"
 ##    	* Remplacement de "Conversation" par "Discussion"
 ##      * Correction de quelques fautes d'orthographe
 ##      * Modification de "VerifyRegEmailSubject"
 ##      * Modification de "ViewJoinGroups"
 ##      * Modification de "Anouncement"
 ##    	* Remplacement de "présider" par "modérer" (moins pompeux 8))
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.15a-FR-1.0.11
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 23 avril 2005
 ##     Modifications :
 ##    	* Modification des formats de date
 ##    	* Modification de la valeur pour "LOCALE"
 ##    	* Modif "ListForums"
 ##    	* Modif "ListThreads"
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.15a-FR-1.0.10
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 22 avril 2005
 ##     Modifications :
 ##    	* Remplacement de Informations personnelles par Profil pour faire plus court
 ##    	* Correction d'accentuation et de fautes d'orthographes
 ##    	* Remplacement de encore par Ressaisir pour le mot clef again utilisé pour la saisie du mot de passe
    $language="Français";
    // uncomment this to hide this language from the user-select-box
    //$language_hide=1;    
    
    // check the php-docs for the syntax of these entries (http://www.php.net/manual/en/function.strftime.php)
    // One tip, don't use T for showing the time zone as users can change their time zone.
    $PHORUM['long_date']="%a %e %B %Y %H:%M:%S";
    $PHORUM['short_date']="%d/%m/%y %H:%M";
    
    // locale setting for localized times/dates
    // see that page: http://www.w3.org/WAI/ER/IG/ert/iso639.htm
    // for the needed string
    $PHORUM['locale']="fr_FR";
    
    // charset for use in converting html into safe valid text
    // also used in the header template for the <xml> and for
    // the Content-Type header. for a list of supported charsets, see
    // http://www.php.net/manual/en/function.htmlentities.php
    // you may also need to set a meta tag with a charset in it.
    $PHORUM["DATA"]['CHARSET']="iso-8859-1";

    // some languages need additional meta tags
    // to set encoding, etc.
    $PHORUM["DATA"]['LANG_META']="";

    // encoding set for outgoing mails
    $PHORUM["DATA"]["MAILENCODING"]="8bit";

    /*-----------------------------------------------------*/

    $PHORUM["DATA"]["LANG"]=array(

        "AccountSummaryTitle"   =>      "Mes préférences",
        "Action"                =>      "Action",
        "Activity"              =>      "Montrer seulement les envois de moins de",
        "Add"                   =>      "Ajouter",
        "AddSig"                =>      "Ajouter ma signature à cet envoi.",
        "AddSigDefault"         =>      "Choisir &quot;Ajouter ma signature&quot; par défaut",
        "AddToGroup"            =>      "Ajouter un nouveau membre au groupe :",
        "AdminOnlyMessage"      =>      "Ce forum est actuellement indisponible. Cette situation est temporaire. Réessayez plus tard.",
        "again"                 =>      "Ressaisir",
        "AllDates"              =>      "Toutes les dates",
        "AllNotShown"           =>      "Tous les messages cachés",
        "AllowReplies"          =>      "Les réponses sont autorisées",
        "AllWords"              =>      "Tous les mots",
        "AllowSeeActivity"      =>      "Permettre que les autres voient lorsque je suis connecté",
        "AllowSeeEmail"         =>      "Permettre que les autres voient mon adresse électronique",
        "Announcement"          =>      "Avis ",
        "AnonymousUser"         =>      "Utilisateur anonyme",
        "AnyWord"               =>      "Mot quelconque",
        "Approved"              =>      "Validé",
        "ApproveUser"           =>      "Valider",
        "ApproveMessageShort"   =>      "Valider",
        "ApproveMessage"        =>      "Valider le message",
        "ApproveMessageReplies" =>      "Valider le message et les réponses",
        "AreYouSure"            =>      "&Ecirc;tes-vous sûr ?",
        "Attach"                =>      "Joindre",
        "AttachAFile"           =>      "Joindre un fichier",
        "AttachAnotherFile"     =>      "Joindre un autre fichier",
        "AttachCancel"          =>      "Votre envoi a été refusé.",
	"AttachDone"		=>	"Les fichiers ont été joints",
        "AttachFiles"           =>      "Joindre des fichiers",
        "AttachFileTypes"       =>      "Types de fichier autorisés :",
        "AttachFileSize"        =>      "La taille d'un fichier ne peut pas excéder",
        "AttachMaxAttachments"  =>      "%count% fichiers supplémentaires peuvent être joints à ce message",
	"AttachTotalFileSize"   =>      "L'ensemble des fichiers ne peut excéder %size%",
        "AttachInstructions"    =>      "Après avoir joint les fichiers, cliquez sur Envoyer",
        "AttachInvalidType"     =>      "Ce fichier n'est pas autorisé",
        "AttachFull"            =>      "Vous avez atteint le nombre maximum de pièces jointes.",
        "AttachInfo"            =>      "Votre envoi sera sauvegardé sur le serveur. Vous avez la possibilité de le modifier à nouveau avant qu'il ne soit publié.",
        "AttachmentAdded"       =>      "Votre fichier a été joint au message",
        "Attachments"           =>      "Pièces jointes",
        "AttachmentsMissing"    =>      "L'adjonction de fichiers a échoué, recommencez.",
        "AttachNotAllowed"      =>      "Désolé, vous ne pouvez pas joindre de fichiers à ce message.",
        "Author"                =>      "Auteur",

        "BacktoForum"           =>      "Retourner au Forum",
        "BackToForumList"       =>      "Retourner à la liste des forums",
        "BackToList"            =>      "Cliquer pour retourner à la liste des messages.",
        "BackToThread"          =>      "Cliquer pour retourner à la discussion.",
        "BackToSearch"          =>      "Cliquer pour retourner à la recherche.",
        "BookmarkedThread"      =>      "Vous suivez la discussion dans votre centre de commande.",
        "Buddies"               =>      "Contacts",
        "Buddy"                 =>      "Contact",
        "BuddyAdd"              =>      "Ajouter l'utilisateur à mes contacts",
        "BuddyAddFail"          =>      "L'utilisateur ne peut être ajouté à vos contacts",
        "BuddyAddSuccess"       =>      "L'utilisateur a été ajouté à vos contacts",
        "BuddyListIsEmpty"      =>      "Votre liste de contacts est vide.<br/>Pour ajouter un utilisateur, allez dans son profil et cliquez sur \"Ajouter l'utilisateur à mes contacts\".",
        "by"                    =>      "par",
                 
        "Cancel"                =>      "Annuler",
        "CancelConfirm"         =>      "&Ecirc;tes-vous sûr de vouloir annuler ?",
        "CannotBeRunFromBrowser" =>     "Cette procédure ne peut être exécutée depuis un butineur.",
        "ChangeEMail"           =>      "Changer d'adresse électronique",
        "ChangePassword"        =>      "Changer de mot de passe",  
        "ChangesSaved"          =>      "Les modifications n'ont pas été enregistrées.",
        "CheckToDelete"         =>      "Cocher pour supprimer",
        "ClickHereToLogin"      =>      "Cliquer ici pour s'identifier",
        "CloseThread"           =>      "Fermer cette discussion",
        "ConfirmDeleteMessage"  =>      "&Ecirc;tes vous sûr de vouloir supprimer ce message ?",
        "ConfirmDeleteThread"   =>      "&Ecirc;tes vous sûr de vouloir supprimer cette discussion ?",
        "ConfirmReportMessage"  =>      "&Ecirc;tes vous sûr de vouloir signaler cet envoi ?",
        "CurrentPage"           =>      "Page courante",

        "Date"                  =>      "Date",
        "DateActive"            =>      "Dernière connexion",
        "DateAdded"             =>      "Date ajoutée",
        "DatePosted"            =>      ", envoyé dernièrement",
        "DateReg"               =>      "Date d'enregistrement",        
        "Day"                   =>      "Jour",
        "Days"                  =>      "Jours",
        "Default"               =>      "Défaut",
        "DeleteAnnouncementForbidden"   =>  "Désolé, seul un administrateur peut supprimer un avis.",
        "MoveAnnouncementForbidden" => "Les avis ne peuvent être déplacés.",
        "DeleteMessage"         =>      "Supprimer le message",
        "DeleteMessageShort"    =>      "Suppr",
        "DelMessReplies"        =>      "Supprimer le message et les réponses",
        "DelMessRepliesShort"   =>      "Suppr+",
        "Delete"                =>      "Supprimer",
        "DeletePost"            =>      "Supprimer l'envoi",
        "DeleteThread"          =>      "Supprimer la discussion",
        "DenyUser"              =>      "Refuser",
        "Detach"                =>      "Supprimer",
        
        "EditBoardsettings"     =>      "Options de Forum",
        "EditFolders"           =>      "Modifier les dossiers",
        "EditPost"              =>      "Modifier l'envoi",
        "EditPostForbidden"     =>      "Vous n'avez pas la permission de modifier cet envoi. Si l'administrateur a limité la période de modification, elle est peut-être expirée.",
        "EditedMessage"         =>      "Modifié %count% fois. Dernière modification le %lastedit% par %lastuser%.",
        "EditMailsettings"      =>      "Modifier mon adresse électronique",
        "EditMyFiles"           =>      "Modifier mes fichiers",
        "EditPrivacy"           =>      "Modifier mes options privées",
        "EditSignature"         =>      "Modifier ma signature",
        "EditUserinfo"          =>      "Modifier mon profil",
        "EmailReplies"          =>      "Envoyer les réponses à cette discussion via ma messagerie électronique",
        "Email"                 =>      "Adresse électroniques",
        "EmailConfirmRequired"  =>      "Confirmation par courriel obligatoire.",
        "EmailVerify"           =>      "Contrôle de courriel",
        "EmailVerifyDesc"       =>      "Contrôle des nouvelles adresses électroniques",
        "EmailVerifyEnterCode"  =>      "Entrez le code de contrôle qui vous a été fourni.",
        "EmailVerifySubject"    =>      "Contrôle de votre nouvelle adresse électronique",
        "EmailVerifyBody"       =>      "Bonjour %uname%,\n\nCe message vous parvient car vous avez demandé une modification de votre adresse électronique dans votre profil. Pour confirmer que cette adresse est valide, ce message contient un code de confirmation.\nN'en tenez pas compte si vous n'étes pas %uname%.\n\nLa nouvelle adresse électronique est : %newmail%\nLe code de confirmation est : %mailcode%\n\nSaisissez ce code dans votre profil pour confirmer cette adresse électronique :\n\t\t<%cc_url%>",
        "EnableNotifyDefault"   =>      "Activer la notification par courriel par défaut",
        "EnterToChange"         =>      "Entrer pour changer",
        "Error"                 =>      "Erreur",
        "ErrInvalid"            =>      "Les données sont invalides.",
        "ErrAuthor"             =>      "Renseignez le champ Auteur.",
        "ErrSubject"            =>      "Renseignez le champ Sujet.",
        "ErrBody"               =>      "Renseignez le corps du message.",
        "ErrBodyTooLarge"       =>      "Réduisez vos messages, le corps est trop grand.",
        "ErrEmail"              =>      "L'adresse électronique saisie semble incorrecte. Essayez à nouveau.",
        "ErrEmailExists"        =>      "L'adresse électronique saisie est enregistrée avec un autre utilisateur.",
        "ErrUsername"           =>      "Renseignez le champ Utilisateur.",
        "ErrPassword"           =>      "Soit le champ Mot de passe est vide soit il est incorrect. Recommencez.",
        "ErrUserAddUpdate"      =>      "Utilisateur non ajouté ou modifié. Erreur inconnue.",
        "ErrRequired"           =>      "Renseignez tous les champs obligatoires.",
        "ErrBannedContent"      =>      'Un mot utilisé dans votre envoi est interdit. Utilisez un mot différent ou contactez les administrateurs.',
        "ErrBannedIP"           =>      "Vous ne pouvez pas faire d'envois car votre adresse IP ou votre FAI a été bloqué. Contactez les administrateurs du forum.",
        "ErrBannedName"         =>      "Vous ne pouvez pas faire d'envois car le nom utilisé est banni. Utilisez un nom différent ou contactez les administrateurs.",
        "ErrBannedEmail"        =>      "Vous ne pouvez pas faire d'envois car l'adresse électronique utilisée est bannie. Utilisez une autre adresse électronique ou contactez les administrateurs.",
	"ErrBannedUser"         =>      'L\'utilisateur "%name%" a été interdit.',

	"ErrRegisterdEmail"     =>      "L'adresse électronique saisie est utilisée par un utilisateur enregistré. Si vous étes cet utilisateur, identifiez vous, sinon utilisez une autre adresse électronique.",
        "ErrRegisterdName"      =>      "Le nom saisi est utilisé par un autre utilisateur enregistré. Si vous êtes cet utilisateur, identifiez vous, sinon utilisez un autre nom.",
        "ExactPhrase"           =>      "Phrase exacte",

        "FileForbidden"         =>      "Les liens vers les fichiers de ce forum ne sont pas autorisés depuis l'extérieur du forum.",
        "FileSizeLimits"        =>      "Merci de ne pas transférer de fichiers supérieurs à {$PHORUM['max_file_size']}k.",
        "FileQuotaLimits"       =>      "Vous ne pouvez pas stocker plus de {$PHORUM['file_space_quota']}k sur le serveur.",
        "FileTypeLimits"        =>      "Seuls les types de fichiers suivants peuvent être transférés : " . str_replace(";", ", ", $PHORUM['file_types']) . ".",
        "Filename"              =>      "Nom du fichier",
        "FileOverQuota"         =>      "Votre fichier ne peut être transféré. La taille de ce fichier vous fait dépasser votre quota. Vous ne pouvez stocker plus de {$PHORUM['file_space_quota']}k sur le serveur.",
        "Files"                 =>      "Mes fichiers",
        "Filesize"              =>      "Taille du fichier",
        "FileTooLarge"          =>      "le fichier est trop grand pour être transféré. Ne tranférez pas de fichiers plus grands que {$PHORUM['max_file_size']}k",
        "FileWrongType"         =>      "Le serveur ne permet pas le transfert de fichiers de ce type. Les types permis sont : " . str_replace(";", ", ", $PHORUM['file_types']) . ".",
        "Filter"                =>      "Filtre",
        "FirstPage"             =>      "Première page",
        "Folders"               =>      "Dossiers",
        "FollowExplanation"     =>      "Les discussions suivies sont dans votre centre de commande.<br />Vous pouvez choisir de recevoir un courriel lorsque la discussion est mise à jour.",
        "FollowExplination"     =>      "Les discussions suivies sont dans votre centre de commande.<br />Vous pouvez choisir de recevoir un courriel lorsque la discussion est mise à jour.",
        "FollowThread"          =>      "Suivre cette discussion",            
        "FollowWithEmail"       =>      "Voulez vous recevoir un courriel lorsque cette discussion sera mise à jour ?",
        "Forum"                 =>      "Forum",
        "ForumFolder"           =>      "Répertoire de forum",
        "Forums"                =>      "Forums",
        "ForumList"             =>      "Liste des Forums",
        "From"                  =>      "De",

        "Go"                    =>      "Aller",
        "GoToTop"               =>      "Messages récents",
        "Goto"                  =>      "Aller à",
        "GoToNew"               =>      "Voir les nouveautés",
        "GotoThread"            =>      "Aller à une discussion",
        "Group"                 =>      "Groupe",
        "GroupJoinFail"         =>      "Votre inscription au groupe a échoué.",
        "GroupJoinSuccess"      =>      "Vous avez rejoint le groupe.",
        "GroupJoinSuccessModerated" =>  "Vous avez rejoint le groupe. Comme c'est un groupe modéré, votre participation doit être approuvée avant de prendre effet.",
        "GroupMembership"       =>      "Mes groupes",
        "GroupMemberList"       =>      "Liste des membres du groupe : ",

        "Hidden"                =>      "Caché",
        "HideEmail"             =>      "Cacher mon adresse électronique aux autres utilisateurs",
        "HideMessage"           =>      "Cacher le message et les réponses",
        "HowToFollowThreads"    =>      "Vous pouvez suivre la discussion en cliquant \"Suivre cette discussion\" lorsque vous lisez un message. De plus, si vous sélectionnez \"Envoyer les réponses à cette discussion via un courriel \" lorsque vous créez un envoi, le message sera ajouté à la liste des discussion que vous suivez.",

        "INBOX"                 =>      "Boîte de réception",
        "InReplyTo"             =>      "En réponse à",
        "InvalidLogin"          =>      "Cet identifiant / mot de passe est introuvable ou inactif. Recommencez.",
        "IPLogged"              =>      "Adresse IP journalisée",
        "IsDST"                 =>      "DST actif",

        "Join"                  =>      "Rejoindre",
        "JoinAGroup"            =>      "Rejoindre un groupe",
        "JoinGroupDescription"  =>      "Pour rejoindre un groupe, sélectionner le dans la liste. Les groupes marqués d'un * sont modérés, votre adhésion devra être approuvée par un modérateur du groupe pour prendre effet.",

        "KeepCopy"              =>      "Garder une copie de mes éléments envoyés",
        
        "Language"              =>      "Langage",
        "Last30Days"            =>      "30 derniers jours",
        "Last90Days"            =>      "90 derniers jours",
        "Last365Days"           =>      "année dernière",

        "LastPost"              =>      "Dernier envoi",
        "LastPostLink"          =>      "Dernier envoi",
        "LastPage"              =>      "Dernière page",
        "ListForums"            =>      "Voir les forums",
        "ListThreads"           =>      "Voir les discussions suivies",
        "LogIn"                 =>      "Identification",
        "LogOut"                =>      "Désidentification",
        "LoginTitle"            =>      "Saisissez votre nom d'utilisateur et votre mot de passe pour vous identifier.",
        "LostPassword"          =>      "Avez vous oublié votre mot de passe ?",
        "LostPassError"         =>      "L'adresse électronique saisie est introuvable.",
        "LostPassInfo"          =>      "Saisissez votre adresse électronique ci-dessous et un nouveau mot de passe vous sera transmis.",
        "LostPassEmailSubject"  =>      "Votre identification sur $PHORUM[title]",
        "LostPassEmailBody1"    =>      "Quelqu'un (nous espérons vous) a demandé un nouveau mot de passe pour votre compte sur $PHORUM[title]. Si ce n'est pas vous, ignorez ce courriel et continuez d'utiliser votre ancien mot de passe.\n\nSi c'est vous, voici votre nouvelle identification sur le forum.",
        "LostPassEmailBody2"    =>      "Vous pouvez vous identifier sur $PHORUM[title] à ".phorum_get_url(PHORUM_LOGIN_URL)."\n\nMerci, $PHORUM[title]",
        "LostPassSent"          =>      "Un nouveau mot de passe a été envoyé à l'adresse fournie.",

        "MakeSticky"            =>      "Note",
        "MakeAnnouncement"      =>      "Avis",
        "MarkForumRead"         =>      "Marquer le forum comme lu",
        "MarkRead"              =>      "Marquer tous les messages comme lus",
        "MarkThreadRead"        =>      "Marquer la discussion comme lue",
        "MatchAllForums"        =>      "Chercher dans tous les forums",
        "MatchThisForum"        =>      "Chercher seulement dans ce forum",
        "MatchAll"              =>      "Tous les mots",
        "MatchAny"              =>      "N'importe quel mot",
        "MatchPhrase"           =>      "La phrase exacte",
        "MembershipType"        =>      "Type d'adhésion",
        "MergeThread"           =>      "Fusionner la discussion",
        "MergeThreadCancel"     =>      "Annuler la fusion",
        "MergeThreads"          =>      "Fusionner les discussions",
        "MergeThreadAction"     =>      "Les discussions suivantes peuvent être fusionnées en une seule",
        "MergeThreadInfo"       =>      "Maintenant, allez sur la discussion qui doit être fusionnée avec la discussion sélectionnée et faites 'Fusionner la discussion' à nouveau.",
        "MergeThreadWith"       =>      "Fusionner la discussion avec",
        "MessageList"           =>      "Liste des messages",
        "MessageNotFound"       =>      "Désolé, le message demandé est introuvable.",
        "Message"               =>      "Message",
        "Moderate"              =>      "Modérer",
        "Moderator"             =>      "Modérateur",
        "ModeratedForum"        =>      "C'est un forum modéré. Votre message restera caché jusqu'à ce qu'il soit approuvé par un modérateur ou un administrateur.",
        "ModFuncs"              =>      "Fonctions du modérateur",
        "ModerationMessage"     =>      "Modération",
        "Month"                 =>      "Mois",
        "Months"                =>      "Mois",
        "MoreMatches"           =>      "Plus de correspondances",
        "MovedSubject"          =>      "Déplacé",
        "MovedMessage"          =>      "Cette discussion a été déplacée. Vous allez être redirigé vers son nouvel emplacement.",
        "MovedMessageTo"        =>      "Vers l'emplacement actuel de cette discussion.",
        "MoveNotification"      =>      "Laisser un avis de déplacement",
        "MoveThread"            =>      "Déplacer la discussion",
        "MoveThreadTo"          =>      "Déplacer la discussion vers le forum",
        "MsgApprovedOk"         =>      "Message(s) approuvé(s)",
        "MsgDeletedOk"          =>      "Message(s) supprimé(s)",
        "MsgHiddenOk"           =>      "Message(s) caché(s)",
        "MsgMergeCancel"        =>      "'Fusionner les discussions' a été annulé.",
        "MsgMergeOk"            =>      "Les discussions ont été fusionnées en une seule.",
        "MsgMoveOk"             =>      "La discussion a été déplacée vers le forum indiqué.",
        "MsgRedirect"           =>      "Vous allez être redirigé pour continuer. Cliquez ici si vous n'étes pas redirigé automatiquement.",
        "MsgModEdited"          =>      "Le message modifié a été enregistré.",
        "MsgSplitOk"            =>      "La discussion a été scindée en deux.",
        "Mutual"                =>      "Mutuel",
        "MyProfile"             =>      "Mon Centre de Commande",

        "Navigate"              =>      "Navigation",
        "NewMessage"            =>      "Nouveau Message",
        "NewModeratedMessage"   =>      "Un nouveau message a été envoyé sur un forum que vous modérez.\nLe sujet est %subject%\nIl peut être relu et approuvé sur l'URL suivant\n%approve_url%\n\n",
        "NewModeratedSubject"   =>      "Nouveau message dans un forum modéré",
        "NewUnModeratedMessage" =>      "Un nouveau message a été envoyé sur un forum que vous modérez.\nLe message a été envoyé par %author% Le sujet est %subject%\n. Il peut être lu sur l'URL suivant\n%read_url%\n\n",        
        "NewPrivateMessages"    =>      "Vous avez de nouveaux messages privés",
        "NewReplyMessage"       =>      "Bonjour,\n\nVous recevez ce courriel car vous suivez la discussion :\n\n  %subject%\n  <%read_url%>\n\nPour arrêter de recevoir cette discussion, cliquez ici :\n<%remove_url%>\n\nPour arrêter de recevoir des courriels mais laisser cette discussion dans votre liste de suivi, cliquez ici :\n<%noemail_url%>\n\nPour voir les discussions que vous suivez, cliquez ici :\n<%followed_threads_url%>",
        "NewReplySubject"       =>      "[%forumname%] Nouvelle réponse: %subject%",
        "NewTopic"              =>      "Nouveau sujet",
        "NewerMessages"         =>      "Messages plus récents",
        "NewerThread"           =>      "Discussion plus récente",
        "newflag"               =>      "Nouveau",
        "NextMessage"           =>      "Message suivant",
        "NextPage"              =>      "Suivant",
        "No"                    =>      "Non",
        "NoForums"              =>      "Désolé, aucun forum n'est visible ici.",
        "NoMoreEmails"          =>      "Vous ne recevrez plus de courriels quand cette discussion sera mise à jour.",
        "None"                  =>      "Tout",
        "NoPost"                =>      "Désolé, vous n'avez pas la permission d'envoyer ou de répondre dans ce forum.",
        "NoPrivateMessages"     =>      "Vous n'avez pas de nouveau message privé",
        "NoRead"                =>      "Désolé, vous n'avez pas la permission de lire ce forum",
        "NotRegistered"         =>      "Pas encore enregistré ? Cliquez ici pour vous enregistrer maintenant.",
        "NoResults"             =>      "Aucun résultat trouvé.",
        "NoResultsHelp"         =>      "Votre recherche ne correspond à aucun message.<br /><br />Suggestions:<ul><li>Vérifiez que tous les mots sont correctement orthographiés.</li><li>Essayez des mots clefs différents.</li><li>Essayez des mots clefs plus généraux.</li><li>Essayez moins de mots clefs.</li></ul>",
        "NoUnapprovedMessages"  =>      "Il n'y a pas de messages non approuvés",
        "NoUnapprovedUsers"     =>      "Il n'y a pas d'utilisateurs non approuvés",
        
        "OlderMessages"         =>      "Messages plus anciens",
        "OlderThread"           =>      "Discussion plus ancienne",
        "on"                    =>      "le",  // as in: Posted by user on 01-01-01 01:01pm
        "of"                    =>      "parmi",  // as in: 1 - 5 of 458
        "Options"               =>      "Options",

        "Pages"                 =>      "Aller à la Page",
        "Password"              =>      "Mot de passe",
        "Past180Days"           =>      "Depuis 180 jours",
        "Past30Days"            =>      "Depuis 30 jours",
        "Past60Days"            =>      "Depuis 60 jours",
        "Past90Days"            =>      "Depuis 90 jours",
        "PastYear"              =>      "Depuis un an",
        "PeriodicLogin"         =>      "Pour votre protection, vous devez confirmer votre identification lorsque vous avez quitter le site.",
        "PermAdministrator"     =>      "Vous êtes administrateur.",
        "PermAllowPost"         =>      "Permission d'envoyer",
        "PermAllowRead"         =>      "Permission de lire",        
        "PermAllowReply"        =>      "Permission de répondre",
        "PermGroupModerator"    =>      "Modérateur pour l'adhésion au Groupe",
        "Permission"            =>      "Permission",
        "PermModerator"         =>      "Modérateur",
        "PersProfile"           =>      "Profil personnel",
        "PleaseLoginPost"       =>      "Désolé, seuls les utilisateurs enregistrés peuvent envoyer dans ce forum.",
        "PleaseLoginRead"       =>      "Désolé, seuls les utilisateurs enregistrés peuvent lire dans ce forum.",
        "PMAddRecipient"        =>      "Ajouter un destinataire",
        "PMCloseMessage"        =>      "Fermer",
        "PMDeleteMessage"       =>      "Supprimer ce message",
        "PMDisabled"            =>      "La messagerie privée est inactive.",
        "PMFolderCreate"        =>      "Créer un nouveau dossier",
        "PMFolderExistsError"   =>      "Impossible de créer le dossier, il existe déjà.",
        "PMFolderCreateSuccess" =>      "Le dossier a été créé.",
        "PMFolderIsEmpty"       =>      "Il n'y a pas de message dans ce dossier.",
        "PMFolderDelete"        =>      "Supprimer le dossier",
        "PMFolderDeleteExplain" =>      "<b>Attention :</b> Si vous supprimez un dossier, tous les messages contenus seront aussi supprimés ! Une fois supprimés, il ne sera pas possible de les récupérer. Si vous désirez conserver les messages, vous devez les déplacer dans un autre dossier.",
        "PMFolderDeleteConfirm" =>      "&Ecirc;tes vous sûr de supprimer le dossier et tous les messages qu'il contient ?",
        "PMFolderDeleteSuccess" =>      "Le dossier a été supprimé",
        "PMFolderNotAvailable"  =>      "Le dossier demandé n'est pas disponible",
        "PMFolderRename"        =>      "Renommer le dossier",
        "PMFolderRenameTo"      =>      "en",
        "PMFolderRenameSuccess" =>      "Le dossier a été renommé",
        "PMNoRecipients"        =>      "Votre message n'a pas de destinataire",
        "PMNotAvailable"        =>      "Le message privé demandé n'est pas disponible.",
        "PMNotifyEnableSetting" =>      "Prévenir par couriel des messages privés",
        "PMNotifyMessage"       =>      "Vous avez reçu un nouveau message privé.\n\n&Eacute;metteur : %author%\nSujet : %subject%\n\nVous pouvez lire ce message sur la page suivante :\n\n%read_url%\n\nThanks, $PHORUM[title]",
        "PMNotifySubject"       =>      "Nouveau message privé sur $PHORUM[title]",
        "PMRead"                =>      "Lu",
        "PMUnread"              =>      "Non lu",
        "PMReply"               =>      "Répondre",
        "PMReplyToAll"          =>      "Répondre à tous",
        "PMRequiredFields"      =>      "Vous devez fournir le sujet et le message.",
        "PMSelectAFolder"       =>      "Choisir un dossier ...",
        "PMSelectARecipient"    =>      "Choisir un destinataire ...",
        "PMFromMailboxFull"     =>      "Vous ne pouvez pas garder une copie de ce message.<br/>Votre boîte aux lettres est pleine.",
        "PMMoveToFolder"        =>      "Déplacer",
        "PMNotSent"             =>      "Votre message privé n'a pas été émis. Erreur inconnue.",
        "PMSent"                =>      "Votre message privé a été émis.",
        "PMReadMessage"         =>      "Lire le message",
        "PMSpaceLeft"           =>      "Vous pouvez encore enregistrer %pm_space_left% message(s) privé(s).",
        "PMSpaceFull"           =>      "Votre boîte aux lettres est pleine.",
        "PMToMailboxFull"       =>      "Le message ne peut être émis.<br/>La boîte aux lettres du destinataire '%recipient%' est pleine.",
        "Post"                  =>      "Envoyer",
        "Posted"                =>      "Envoyé",
        "Postedby"              =>      "Envoyé par",   // as in: Posted by user on 01-01-01 01:01pm
        "PostErrorOccured"      =>      "Une erreur est survenue durant l'envoi de ce message.",
        "Posts"                 =>      "Envois",
        "Preview"               =>      "Aperçu",
        "PreviewExplain"        =>      "Aperçu avant publication.",
        "PreviewNoClickAttach"  =>      "Les pièces jointes ne peuvent pas être ouvertes depuis l'aperçu",
        "PreviousMatches"       =>      "Correspondances précédentes",
        "PreviousMessage"       =>      "Message précédent",
        "PrevPage"              =>      "Page précédente",
        "PrivateMessages"       =>      "Messages privés",
        "PrivateReply"          =>      "Répondre par message privé",
        "ProfileUpdatedOk"      =>      "Profil correctement mis à jour.",

	"OnlyUnapproved"        =>      "seulement les messages non approuvés",

        "Quote"                 =>      "Citation",
        "QuoteMessage"          =>      "Citer ce Message",

        "read"                  =>      "lu",
        "ReadOnlyMessage"       =>      "Ce forum est en lecture seule. C'est une situation temporaire. Réessayez plus tard.",
        "ReadPrivateMessages"   =>      "Lire les messages privés",
        "RealName"              =>      "Vrai nom",
        "Received"              =>      "Reçu",
        "ReceiveModerationMails"=>      "Je veux recevoir les couriels de modération",
        "Recipients"            =>      "destinataires",
        "RegApprovedSubject"    =>      "Votre compte a été approuvé.",
        "RegApprovedEmailBody"  =>      "Votre compte sur $PHORUM[title] a été approuvé. Vous pouvez vous identifier sur $PHORUM[title] à ".phorum_get_url(PHORUM_LOGIN_URL)."\n\nMerci, $PHORUM[title]",
        "RegAcctActive"         =>      "Votre compte est maintenant actif.",
        "RegBack"               =>      "Cliquez ici pour vous identifier.",
        "Register"              =>      "Créer un nouveau profil",
        "RegThanks"             =>      "Merci de vous être enregistré.",
        "RegVerifyEmail"        =>      "Merci de vous être enregistré. Vous aller recevoir un courriel avec des instructions pour activer votre compte.",
        "RegVerifyFailed"       =>      "Désolé, il y a une erreur de vérification de votre compte. Assurez vous d'avoir bien utiliser la totalité de l'URL que vous avez reçu par courriel.",
        "RegVerifyMod"          =>      "Merci de vous être enregistré. L'approbation d'un modérateur est nécessaire à l'activation de votre compte. Vous recevrez un courriel après qu'un modérateur ait validé vos informations.",
        "RemoveFollowed"        =>      "Vous ne suivez plus cette discussion.",
        "RemoveFromGroup"       =>      "Retirer du groupe",
        "ReopenThread"          =>      "Réouvrir cette discussion",
        "Reply"                 =>      "Repondre à ce message",
        "ReportPostEmailBody"   =>      "%reportedby% a signalé le message suivant..\n\n<%url%>\n------------------------------------------------------------------------\nForum:   %forumname%\nSujet: %subject%\nAuteur:  %author%\nIP:      %ip%\nDate:    %date%\n\n%body%\n\n------------------------------------------------------------------------\nPour supprimer ce message cliquer ici :\n<%delete_url%>\n\nPour cacher ce message cliquer ici :\n<%hide_url%>\n\nPour modifier ce message cliquer ici :\n<%edit_url%>\n\nLe profil personnel de %reportedby% est ici :\n<%reporter_url%>",
        "ReportPostEmailSubject"=>      "[%forumname%] Envoi signalé aux modérateurs",
        "ReportPostExplanation" =>      "Vous pouvez joindre une explication au signalement de cet envoi. Elle sera transmise aux modérateurs avec l'alerte. Elle peut aider le modérateur a comprendre pourqoi vous signalez cet envoi.",
        "ReportPostNotAllowed"  =>      "Vous devez être identifié pour signaler un envoi.",
        "ReportPostSuccess"     =>      "Cet envoi a été signalé aux modérateurs du forum.",
        "Required"              =>      "éléments obligatoires",
        "Results"               =>      "Résultats",
        "Report"                =>      "Signaler ce message",
        "RSS"                   =>      "RSS",

        "SaveChanges"           =>      "Enregistrer les modifications",
        "ScriptUsage"           =>      "Utilisation : php script.php [--module=<module_name> | --scheduled] [options]
        --module=<module_name>   Exécute le module spécifié.
        --scheduled              Exécute tous les modules qui ne nécessitent pas d'entrées (modules planifiés).
        [options]                Lors de l'exécution, ces options sont passées au module.
                                 Consultez la documentation du module pour connaitre ses options.
                                 Avec --scheduled, elles sont ignorées.\n",
        "Search"                =>      "Chercher",
        "SearchAuthor"		=>      "Auteur",
        "SearchAuthors"		=>      "Auteurs",
        "SearchBody" 	        =>      "Texte",
        "SearchMessages"        =>      "Chercher dans les messages",
        "SearchResults"         =>      "Résultats de recherche",
        "SearchRunning"         =>      "Recherche en cours, patientez.",
	"SearchSubject"		=>	"Sujet",
	"SearchTip"		=>	"AND est l'opérateur par défaut. Ainsi, une recherche pour chien et chat trouvera tous les messages qui contiennent ces mots n'importe où.<br /><br />Les guillemets (\") permettent la recherche de phrases. De cette façon, une recherche avec \"chien chat\" trouvera les messages qui contiennent la phrase exacte avec l'espace.<br /><br />Le moins (-) élimine des mots. Une recherche avec chien et -chat trouvera tous les messages qui contiennent chien mais pas chat. On peut utiliser le moins avec une phrase entre guillemets. Par exemple : chien -\"chat siamois\".<br /><br />Le moteur est insensible à la casse et recherche sur le titre, le corps et l'auteur.",
	"SearchTips"		=>	"Astuces de recherche",
        "SelectGroupMod"        =>      "Sélectionner un groupe à modérer",
        "SelectForum"           =>      "Sélectionner le Forum ...",
        "SendPM"                =>      "Envoyer un message privé",
        "SentItems"             =>      "Eléments envoyés",
        "Showing"               =>      "Montrer",
        "ShowOnlyMessages"      =>      "Montrer les messages",
        "Signature"             =>      "Signature",
        "Special"               =>      "Spécial",
        "SplitThread"           =>      "Scinder la discussion",
        "SplitThreadInfo"       =>      "Faire de ce message et de ses réponses une discussion.",
        "SrchMsgBodies"         =>      "Corps des messages (plus lent)",
        "StartedBy"             =>      "Commencé par",
        "Sticky"                =>      "Note ",
        "Subject"               =>      "Sujet",
        "Submit"                =>      "Appliquer",
        "Subscribe"             =>      "S'inscrire à ce Forum",
        "Subscriptions"         =>      "Discussions suivies",
        "Suspended"             =>      "Suspendu",

        "Template"              =>      "Modèle",
        "ThankYou"              =>      "Merci",
        "ThreadAnnouncement"    =>      "Vous ne pouvez pas répondre aux avis.",
        "ThreadClosed"          =>      "Cette discussion a été fermée",
        "ThreadClosedOk"        =>      "La discussion a été fermée.",
        "Thread"                =>      "Discussion",
        "Threads"               =>      "Discussions",
        "ThreadReopenedOk"      =>      "La discussion a été réouverte.",
        "ThreadViewList"        =>      "Survol des discussions - Liste",
        "ThreadViewRead"        =>      "Survol des discussions - Lues",		
        "Timezone"              =>      "Fuseau horaire de l'utilisateur",
        "To"                    =>      "à",
        "Today"                 =>      "Aujourd'hui",
        "Total"                 =>      "Total",
        "TotalFiles"            =>      "Total des fichiers",
        "TotalFileSize"         =>      "Espace utilisé",
        
        "Unapproved"            =>      "Non approuvé",
        "UnapprovedGroupMembers" =>     "Il y a des adhésions non approuvées",
        "UnapprovedMessage"     =>      "Message non approuvé",        
        "UnapprovedMessages"    =>      "Messages non approuvés",
        "UnapprovedMessagesLong" =>     "Il y a des messages non approuvés",
        "UnapprovedUsers"       =>      "Utilisateurs non approuvés",
        "UnapprovedUsersLong"   =>      "Il y a des utilisateurs non approuvés",
        "Unbookmark"            =>      "Enlever le signet",
        "UnknownUser"           =>      "Cet utilisateur n'existe pas",
        "Unsubscribe"           =>      "Désabonner",
        "UnsubscribeError"      =>      "Vous ne pouvez pas vous désabonner de cette discussion.",
        "UnsubscribeOk"         =>      "Vous avez été désabonné de la discussion.",
        "Update"                =>      "Mettre à jour",
        "UploadFile"            =>      "Transférer un nouveau fichier",
        "UploadNotAllowed"      =>      "Vous n'étes pas autorisé à transférer des fichiers sur ce serveur.",        
        "UserAddedToGroup"      =>      "L'utilisateur a été ajouté au groupe.",
        "Username"              =>      "Nom d'utilisateur",
        "UserNotFound"          =>      "Le destinataire de votre message est introuvable. Vérifiez le nom et recommencez.",
        "UserPermissions"       =>      "Permissions de l'utilisateur",
        "UserProfile"           =>      "Informations personnelles",
        "UserSummary"           =>      "Mon panneau de commande",

        "VerifyRegEmailSubject" =>      "Validez votre inscription",
        "VerifyRegEmailBody1"   =>      "Pour valider votre compte sur $PHORUM[title], cliquer sur l'URL ci-dessous.",
        "VerifyRegEmailBody2"   =>      "Une fois controlé, vous pourrez vous identifier sur $PHORUM[title] à ".phorum_get_url(PHORUM_LOGIN_URL)."\n\nMerci, $PHORUM[title]",
        "ViewFlat"              =>      "Vue à plat",
        "ViewJoinGroups"        =>      "Rejoindre un groupe",
        "ViewProfile"           =>      "Voir mon profil",
        "ViewThreaded"          =>      "Voir par discussion",
        "Views"                 =>      "Vues",

        "WrittenBy"             =>      "Ecrit par",
        "ErrWrongMailcode"      =>      "Vous avez saisi un code de confirmation erroné. Recommencez !",
        "Wrote"                 =>      "&Eacute;crivait",

        "Year"                  =>      "Année",
        "Yes"                   =>      "Oui",
        "YourEmail"             =>      "Votre adresse électronique",
        "YourName"              =>      "Votre nom",
        "YouWantToFollow"       =>      "Vous avez souhaité suivre cette discussion.",
);
    // timezone-variables
    $PHORUM["DATA"]["LANG"]["TIME"]=array(
        "-12" => "(GMT - 12:00 hours) Enitwetok, Kwajalien",
        "-11" => "(GMT - 11:00 hours) Midway Island, Samoa",
        "-10" => "(GMT - 10:00 hours) Hawaii",
        "-9"  => "(GMT - 9:00 hours) Alaska",
        "-8"  => "(GMT - 8:00 hours) Pacific Time (US &amp; Canada)",
        "-7"  => "(GMT - 7:00 hours) Mountain Time (US &amp; Canada)",
        "-6"  => "(GMT - 6:00 hours) Central Time (US &amp; Canada), Mexico City",
        "-5"  => "(GMT - 5:00 hours) Eastern Time (US &amp; Canada), Bogota, Lima, Quito",
        "-4"  => "(GMT - 4:00 hours) Atlantic Time (Canada), Caracas, La Paz",
        "-3.5" => "(GMT - 3:30 hours) Newfoundland",
        "-3"   => "(GMT - 3:00 hours) Brazil, Buenos Aires, Georgetown, Falkland Is.",
        "-2"   => "(GMT - 2:00 hours) Mid-Atlantic, Ascention Is., St Helena",
        "-1"   => "(GMT - 1:00 hours) Azores, Cape Verde Islands",
        "0"    => "(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia",
        "1"    => "(GMT + 1:00 hours) Berlin, Brussels, Copenhagen, Madrid, Paris, Rome, Warsaw",
        "2"    => "(GMT + 2:00 hours) Kaliningrad, South Africa",
        "3"    => "(GMT + 3:00 hours) Baghdad, Riyadh, Moscow, Nairobi",
        "3.5"  => "(GMT + 3:30 hours) Tehran",
        "4"    => "(GMT + 4:00 hours) Abu Dhabi, Baku, Muscat, Tbilisi",
        "4.5"  => "(GMT + 4:30 hours) Kabul",
        "5"    => "(GMT + 5:00 hours) Ekaterinburg, Islamabad, Karachi, Tashkent",
        "5.5"  => "(GMT + 5:30 hours) Bombay, Calcutta, Madras, New Delhi",
        "6"    => "(GMT + 6:00 hours) Almaty, Colomba, Dhakra",
        "7"    => "(GMT + 7:00 hours) Bangkok, Hanoi, Jakarta",
        "8"    => "(GMT + 8:00 hours) Beijing, Hong Kong, Perth, Singapore, Taipei",
        "9"    => "(GMT + 9:00 hours) Osaka, Sapporo, Seoul, Tokyo, Yakutsk",
        "9.5"  => "(GMT + 9:30 hours) Adelaide, Darwin",
        "10"   => "(GMT + 10:00 hours) Melbourne, Papua New Guinea, Sydney, Vladivostok",
        "11"   => "(GMT + 11:00 hours) Magadan, New Caledonia, Solomon Islands",
        "12"   => "(GMT + 12:00 hours) Auckland, Wellington, Fiji, Marshall Island",    
    );

?>
