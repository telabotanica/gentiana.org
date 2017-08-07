<?php
 ##     Traduction fran�aise pour Phorum 5.1.6a
 ##    -----------------------------------------------------------------
 ##     Version : 5.1.6a-FR-1.1.0
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 18/01/2006 
 ##     Modifications :
 ##     * Modifications pour la version 5.1.6a
 ##	* Les entr�es donn�es comme 'Deprecated' ont �t� maintenues
 ##	* car elles sont dans english.php livr� avec la 5.1.6a
 ##	* et certaines sont nouvelles !?!
 ##    	* Quelques corrections d'orthographe et de sens
 ##    -----------------------------------------------------------------
 ##     Version : 5.0.20-FR-1.0.11
 ##     Auteur : Renaud Flavigny
 ##     Contact : renaud dot flavigny at free dot fr
 ##     Date : 01/12/2005 
 ##     Modifications :
 ##      * Remplacement de m�l par adresse �lectronique ou courriel selon le contexte
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
 ##      * Remplacement de pr�visualisation par aper�u
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
 ##    	* Remplacement de "pr�sider" par "mod�rer" (moins pompeux 8))
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
 ##    	* Remplacement de encore par Ressaisir pour le mot clef again utilis� pour la saisie du mot de passe
    $language="Fran�ais";
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

        "AccountSummaryTitle"   =>      "Mes pr�f�rences",
        "Action"                =>      "Action",
        "Activity"              =>      "Montrer seulement les envois de moins de",
        "Add"                   =>      "Ajouter",
        "AddSig"                =>      "Ajouter ma signature � cet envoi.",
        "AddSigDefault"         =>      "Choisir &quot;Ajouter ma signature&quot; par d�faut",
        "AddToGroup"            =>      "Ajouter un nouveau membre au groupe :",
        "AdminOnlyMessage"      =>      "Ce forum est actuellement indisponible. Cette situation est temporaire. R�essayez plus tard.",
        "again"                 =>      "Ressaisir",
        "AllDates"              =>      "Toutes les dates",
        "AllNotShown"           =>      "Tous les messages cach�s",
        "AllowReplies"          =>      "Les r�ponses sont autoris�es",
        "AllWords"              =>      "Tous les mots",
        "AllowSeeActivity"      =>      "Permettre que les autres voient lorsque je suis connect�",
        "AllowSeeEmail"         =>      "Permettre que les autres voient mon adresse �lectronique",
        "Announcement"          =>      "Avis ",
        "AnonymousUser"         =>      "Utilisateur anonyme",
        "AnyWord"               =>      "Mot quelconque",
        "Approved"              =>      "Valid�",
        "ApproveUser"           =>      "Valider",
        "ApproveMessageShort"   =>      "Valider",
        "ApproveMessage"        =>      "Valider le message",
        "ApproveMessageReplies" =>      "Valider le message et les r�ponses",
        "AreYouSure"            =>      "&Ecirc;tes-vous s�r ?",
        "Attach"                =>      "Joindre",
        "AttachAFile"           =>      "Joindre un fichier",
        "AttachAnotherFile"     =>      "Joindre un autre fichier",
        "AttachCancel"          =>      "Votre envoi a �t� refus�.",
	"AttachDone"		=>	"Les fichiers ont �t� joints",
        "AttachFiles"           =>      "Joindre des fichiers",
        "AttachFileTypes"       =>      "Types de fichier autoris�s :",
        "AttachFileSize"        =>      "La taille d'un fichier ne peut pas exc�der",
        "AttachMaxAttachments"  =>      "%count% fichiers suppl�mentaires peuvent �tre joints � ce message",
	"AttachTotalFileSize"   =>      "L'ensemble des fichiers ne peut exc�der %size%",
        "AttachInstructions"    =>      "Apr�s avoir joint les fichiers, cliquez sur Envoyer",
        "AttachInvalidType"     =>      "Ce fichier n'est pas autoris�",
        "AttachFull"            =>      "Vous avez atteint le nombre maximum de pi�ces jointes.",
        "AttachInfo"            =>      "Votre envoi sera sauvegard� sur le serveur. Vous avez la possibilit� de le modifier � nouveau avant qu'il ne soit publi�.",
        "AttachmentAdded"       =>      "Votre fichier a �t� joint au message",
        "Attachments"           =>      "Pi�ces jointes",
        "AttachmentsMissing"    =>      "L'adjonction de fichiers a �chou�, recommencez.",
        "AttachNotAllowed"      =>      "D�sol�, vous ne pouvez pas joindre de fichiers � ce message.",
        "Author"                =>      "Auteur",

        "BacktoForum"           =>      "Retourner au Forum",
        "BackToForumList"       =>      "Retourner � la liste des forums",
        "BackToList"            =>      "Cliquer pour retourner � la liste des messages.",
        "BackToThread"          =>      "Cliquer pour retourner � la discussion.",
        "BackToSearch"          =>      "Cliquer pour retourner � la recherche.",
        "BookmarkedThread"      =>      "Vous suivez la discussion dans votre centre de commande.",
        "Buddies"               =>      "Contacts",
        "Buddy"                 =>      "Contact",
        "BuddyAdd"              =>      "Ajouter l'utilisateur � mes contacts",
        "BuddyAddFail"          =>      "L'utilisateur ne peut �tre ajout� � vos contacts",
        "BuddyAddSuccess"       =>      "L'utilisateur a �t� ajout� � vos contacts",
        "BuddyListIsEmpty"      =>      "Votre liste de contacts est vide.<br/>Pour ajouter un utilisateur, allez dans son profil et cliquez sur \"Ajouter l'utilisateur � mes contacts\".",
        "by"                    =>      "par",
                 
        "Cancel"                =>      "Annuler",
        "CancelConfirm"         =>      "&Ecirc;tes-vous s�r de vouloir annuler ?",
        "CannotBeRunFromBrowser" =>     "Cette proc�dure ne peut �tre ex�cut�e depuis un butineur.",
        "ChangeEMail"           =>      "Changer d'adresse �lectronique",
        "ChangePassword"        =>      "Changer de mot de passe",  
        "ChangesSaved"          =>      "Les modifications n'ont pas �t� enregistr�es.",
        "CheckToDelete"         =>      "Cocher pour supprimer",
        "ClickHereToLogin"      =>      "Cliquer ici pour s'identifier",
        "CloseThread"           =>      "Fermer cette discussion",
        "ConfirmDeleteMessage"  =>      "&Ecirc;tes vous s�r de vouloir supprimer ce message ?",
        "ConfirmDeleteThread"   =>      "&Ecirc;tes vous s�r de vouloir supprimer cette discussion ?",
        "ConfirmReportMessage"  =>      "&Ecirc;tes vous s�r de vouloir signaler cet envoi ?",
        "CurrentPage"           =>      "Page courante",

        "Date"                  =>      "Date",
        "DateActive"            =>      "Derni�re connexion",
        "DateAdded"             =>      "Date ajout�e",
        "DatePosted"            =>      ", envoy� derni�rement",
        "DateReg"               =>      "Date d'enregistrement",        
        "Day"                   =>      "Jour",
        "Days"                  =>      "Jours",
        "Default"               =>      "D�faut",
        "DeleteAnnouncementForbidden"   =>  "D�sol�, seul un administrateur peut supprimer un avis.",
        "MoveAnnouncementForbidden" => "Les avis ne peuvent �tre d�plac�s.",
        "DeleteMessage"         =>      "Supprimer le message",
        "DeleteMessageShort"    =>      "Suppr",
        "DelMessReplies"        =>      "Supprimer le message et les r�ponses",
        "DelMessRepliesShort"   =>      "Suppr+",
        "Delete"                =>      "Supprimer",
        "DeletePost"            =>      "Supprimer l'envoi",
        "DeleteThread"          =>      "Supprimer la discussion",
        "DenyUser"              =>      "Refuser",
        "Detach"                =>      "Supprimer",
        
        "EditBoardsettings"     =>      "Options de Forum",
        "EditFolders"           =>      "Modifier les dossiers",
        "EditPost"              =>      "Modifier l'envoi",
        "EditPostForbidden"     =>      "Vous n'avez pas la permission de modifier cet envoi. Si l'administrateur a limit� la p�riode de modification, elle est peut-�tre expir�e.",
        "EditedMessage"         =>      "Modifi� %count% fois. Derni�re modification le %lastedit% par %lastuser%.",
        "EditMailsettings"      =>      "Modifier mon adresse �lectronique",
        "EditMyFiles"           =>      "Modifier mes fichiers",
        "EditPrivacy"           =>      "Modifier mes options priv�es",
        "EditSignature"         =>      "Modifier ma signature",
        "EditUserinfo"          =>      "Modifier mon profil",
        "EmailReplies"          =>      "Envoyer les r�ponses � cette discussion via ma messagerie �lectronique",
        "Email"                 =>      "Adresse �lectroniques",
        "EmailConfirmRequired"  =>      "Confirmation par courriel obligatoire.",
        "EmailVerify"           =>      "Contr�le de courriel",
        "EmailVerifyDesc"       =>      "Contr�le des nouvelles adresses �lectroniques",
        "EmailVerifyEnterCode"  =>      "Entrez le code de contr�le qui vous a �t� fourni.",
        "EmailVerifySubject"    =>      "Contr�le de votre nouvelle adresse �lectronique",
        "EmailVerifyBody"       =>      "Bonjour %uname%,\n\nCe message vous parvient car vous avez demand� une modification de votre adresse �lectronique dans votre profil. Pour confirmer que cette adresse est valide, ce message contient un code de confirmation.\nN'en tenez pas compte si vous n'�tes pas %uname%.\n\nLa nouvelle adresse �lectronique est : %newmail%\nLe code de confirmation est : %mailcode%\n\nSaisissez ce code dans votre profil pour confirmer cette adresse �lectronique :\n\t\t<%cc_url%>",
        "EnableNotifyDefault"   =>      "Activer la notification par courriel par d�faut",
        "EnterToChange"         =>      "Entrer pour changer",
        "Error"                 =>      "Erreur",
        "ErrInvalid"            =>      "Les donn�es sont invalides.",
        "ErrAuthor"             =>      "Renseignez le champ Auteur.",
        "ErrSubject"            =>      "Renseignez le champ Sujet.",
        "ErrBody"               =>      "Renseignez le corps du message.",
        "ErrBodyTooLarge"       =>      "R�duisez vos messages, le corps est trop grand.",
        "ErrEmail"              =>      "L'adresse �lectronique saisie semble incorrecte. Essayez � nouveau.",
        "ErrEmailExists"        =>      "L'adresse �lectronique saisie est enregistr�e avec un autre utilisateur.",
        "ErrUsername"           =>      "Renseignez le champ Utilisateur.",
        "ErrPassword"           =>      "Soit le champ Mot de passe est vide soit il est incorrect. Recommencez.",
        "ErrUserAddUpdate"      =>      "Utilisateur non ajout� ou modifi�. Erreur inconnue.",
        "ErrRequired"           =>      "Renseignez tous les champs obligatoires.",
        "ErrBannedContent"      =>      'Un mot utilis� dans votre envoi est interdit. Utilisez un mot diff�rent ou contactez les administrateurs.',
        "ErrBannedIP"           =>      "Vous ne pouvez pas faire d'envois car votre adresse IP ou votre FAI a �t� bloqu�. Contactez les administrateurs du forum.",
        "ErrBannedName"         =>      "Vous ne pouvez pas faire d'envois car le nom utilis� est banni. Utilisez un nom diff�rent ou contactez les administrateurs.",
        "ErrBannedEmail"        =>      "Vous ne pouvez pas faire d'envois car l'adresse �lectronique utilis�e est bannie. Utilisez une autre adresse �lectronique ou contactez les administrateurs.",
	"ErrBannedUser"         =>      'L\'utilisateur "%name%" a �t� interdit.',

	"ErrRegisterdEmail"     =>      "L'adresse �lectronique saisie est utilis�e par un utilisateur enregistr�. Si vous �tes cet utilisateur, identifiez vous, sinon utilisez une autre adresse �lectronique.",
        "ErrRegisterdName"      =>      "Le nom saisi est utilis� par un autre utilisateur enregistr�. Si vous �tes cet utilisateur, identifiez vous, sinon utilisez un autre nom.",
        "ExactPhrase"           =>      "Phrase exacte",

        "FileForbidden"         =>      "Les liens vers les fichiers de ce forum ne sont pas autoris�s depuis l'ext�rieur du forum.",
        "FileSizeLimits"        =>      "Merci de ne pas transf�rer de fichiers sup�rieurs � {$PHORUM['max_file_size']}k.",
        "FileQuotaLimits"       =>      "Vous ne pouvez pas stocker plus de {$PHORUM['file_space_quota']}k sur le serveur.",
        "FileTypeLimits"        =>      "Seuls les types de fichiers suivants peuvent �tre transf�r�s : " . str_replace(";", ", ", $PHORUM['file_types']) . ".",
        "Filename"              =>      "Nom du fichier",
        "FileOverQuota"         =>      "Votre fichier ne peut �tre transf�r�. La taille de ce fichier vous fait d�passer votre quota. Vous ne pouvez stocker plus de {$PHORUM['file_space_quota']}k sur le serveur.",
        "Files"                 =>      "Mes fichiers",
        "Filesize"              =>      "Taille du fichier",
        "FileTooLarge"          =>      "le fichier est trop grand pour �tre transf�r�. Ne tranf�rez pas de fichiers plus grands que {$PHORUM['max_file_size']}k",
        "FileWrongType"         =>      "Le serveur ne permet pas le transfert de fichiers de ce type. Les types permis sont : " . str_replace(";", ", ", $PHORUM['file_types']) . ".",
        "Filter"                =>      "Filtre",
        "FirstPage"             =>      "Premi�re page",
        "Folders"               =>      "Dossiers",
        "FollowExplanation"     =>      "Les discussions suivies sont dans votre centre de commande.<br />Vous pouvez choisir de recevoir un courriel lorsque la discussion est mise � jour.",
        "FollowExplination"     =>      "Les discussions suivies sont dans votre centre de commande.<br />Vous pouvez choisir de recevoir un courriel lorsque la discussion est mise � jour.",
        "FollowThread"          =>      "Suivre cette discussion",            
        "FollowWithEmail"       =>      "Voulez vous recevoir un courriel lorsque cette discussion sera mise � jour ?",
        "Forum"                 =>      "Forum",
        "ForumFolder"           =>      "R�pertoire de forum",
        "Forums"                =>      "Forums",
        "ForumList"             =>      "Liste des Forums",
        "From"                  =>      "De",

        "Go"                    =>      "Aller",
        "GoToTop"               =>      "Messages r�cents",
        "Goto"                  =>      "Aller �",
        "GoToNew"               =>      "Voir les nouveaut�s",
        "GotoThread"            =>      "Aller � une discussion",
        "Group"                 =>      "Groupe",
        "GroupJoinFail"         =>      "Votre inscription au groupe a �chou�.",
        "GroupJoinSuccess"      =>      "Vous avez rejoint le groupe.",
        "GroupJoinSuccessModerated" =>  "Vous avez rejoint le groupe. Comme c'est un groupe mod�r�, votre participation doit �tre approuv�e avant de prendre effet.",
        "GroupMembership"       =>      "Mes groupes",
        "GroupMemberList"       =>      "Liste des membres du groupe : ",

        "Hidden"                =>      "Cach�",
        "HideEmail"             =>      "Cacher mon adresse �lectronique aux autres utilisateurs",
        "HideMessage"           =>      "Cacher le message et les r�ponses",
        "HowToFollowThreads"    =>      "Vous pouvez suivre la discussion en cliquant \"Suivre cette discussion\" lorsque vous lisez un message. De plus, si vous s�lectionnez \"Envoyer les r�ponses � cette discussion via un courriel \" lorsque vous cr�ez un envoi, le message sera ajout� � la liste des discussion que vous suivez.",

        "INBOX"                 =>      "Bo�te de r�ception",
        "InReplyTo"             =>      "En r�ponse �",
        "InvalidLogin"          =>      "Cet identifiant / mot de passe est introuvable ou inactif. Recommencez.",
        "IPLogged"              =>      "Adresse IP journalis�e",
        "IsDST"                 =>      "DST actif",

        "Join"                  =>      "Rejoindre",
        "JoinAGroup"            =>      "Rejoindre un groupe",
        "JoinGroupDescription"  =>      "Pour rejoindre un groupe, s�lectionner le dans la liste. Les groupes marqu�s d'un * sont mod�r�s, votre adh�sion devra �tre approuv�e par un mod�rateur du groupe pour prendre effet.",

        "KeepCopy"              =>      "Garder une copie de mes �l�ments envoy�s",
        
        "Language"              =>      "Langage",
        "Last30Days"            =>      "30 derniers jours",
        "Last90Days"            =>      "90 derniers jours",
        "Last365Days"           =>      "ann�e derni�re",

        "LastPost"              =>      "Dernier envoi",
        "LastPostLink"          =>      "Dernier envoi",
        "LastPage"              =>      "Derni�re page",
        "ListForums"            =>      "Voir les forums",
        "ListThreads"           =>      "Voir les discussions suivies",
        "LogIn"                 =>      "Identification",
        "LogOut"                =>      "D�sidentification",
        "LoginTitle"            =>      "Saisissez votre nom d'utilisateur et votre mot de passe pour vous identifier.",
        "LostPassword"          =>      "Avez vous oubli� votre mot de passe ?",
        "LostPassError"         =>      "L'adresse �lectronique saisie est introuvable.",
        "LostPassInfo"          =>      "Saisissez votre adresse �lectronique ci-dessous et un nouveau mot de passe vous sera transmis.",
        "LostPassEmailSubject"  =>      "Votre identification sur $PHORUM[title]",
        "LostPassEmailBody1"    =>      "Quelqu'un (nous esp�rons vous) a demand� un nouveau mot de passe pour votre compte sur $PHORUM[title]. Si ce n'est pas vous, ignorez ce courriel et continuez d'utiliser votre ancien mot de passe.\n\nSi c'est vous, voici votre nouvelle identification sur le forum.",
        "LostPassEmailBody2"    =>      "Vous pouvez vous identifier sur $PHORUM[title] � ".phorum_get_url(PHORUM_LOGIN_URL)."\n\nMerci, $PHORUM[title]",
        "LostPassSent"          =>      "Un nouveau mot de passe a �t� envoy� � l'adresse fournie.",

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
        "MembershipType"        =>      "Type d'adh�sion",
        "MergeThread"           =>      "Fusionner la discussion",
        "MergeThreadCancel"     =>      "Annuler la fusion",
        "MergeThreads"          =>      "Fusionner les discussions",
        "MergeThreadAction"     =>      "Les discussions suivantes peuvent �tre fusionn�es en une seule",
        "MergeThreadInfo"       =>      "Maintenant, allez sur la discussion qui doit �tre fusionn�e avec la discussion s�lectionn�e et faites 'Fusionner la discussion' � nouveau.",
        "MergeThreadWith"       =>      "Fusionner la discussion avec",
        "MessageList"           =>      "Liste des messages",
        "MessageNotFound"       =>      "D�sol�, le message demand� est introuvable.",
        "Message"               =>      "Message",
        "Moderate"              =>      "Mod�rer",
        "Moderator"             =>      "Mod�rateur",
        "ModeratedForum"        =>      "C'est un forum mod�r�. Votre message restera cach� jusqu'� ce qu'il soit approuv� par un mod�rateur ou un administrateur.",
        "ModFuncs"              =>      "Fonctions du mod�rateur",
        "ModerationMessage"     =>      "Mod�ration",
        "Month"                 =>      "Mois",
        "Months"                =>      "Mois",
        "MoreMatches"           =>      "Plus de correspondances",
        "MovedSubject"          =>      "D�plac�",
        "MovedMessage"          =>      "Cette discussion a �t� d�plac�e. Vous allez �tre redirig� vers son nouvel emplacement.",
        "MovedMessageTo"        =>      "Vers l'emplacement actuel de cette discussion.",
        "MoveNotification"      =>      "Laisser un avis de d�placement",
        "MoveThread"            =>      "D�placer la discussion",
        "MoveThreadTo"          =>      "D�placer la discussion vers le forum",
        "MsgApprovedOk"         =>      "Message(s) approuv�(s)",
        "MsgDeletedOk"          =>      "Message(s) supprim�(s)",
        "MsgHiddenOk"           =>      "Message(s) cach�(s)",
        "MsgMergeCancel"        =>      "'Fusionner les discussions' a �t� annul�.",
        "MsgMergeOk"            =>      "Les discussions ont �t� fusionn�es en une seule.",
        "MsgMoveOk"             =>      "La discussion a �t� d�plac�e vers le forum indiqu�.",
        "MsgRedirect"           =>      "Vous allez �tre redirig� pour continuer. Cliquez ici si vous n'�tes pas redirig� automatiquement.",
        "MsgModEdited"          =>      "Le message modifi� a �t� enregistr�.",
        "MsgSplitOk"            =>      "La discussion a �t� scind�e en deux.",
        "Mutual"                =>      "Mutuel",
        "MyProfile"             =>      "Mon Centre de Commande",

        "Navigate"              =>      "Navigation",
        "NewMessage"            =>      "Nouveau Message",
        "NewModeratedMessage"   =>      "Un nouveau message a �t� envoy� sur un forum que vous mod�rez.\nLe sujet est %subject%\nIl peut �tre relu et approuv� sur l'URL suivant\n%approve_url%\n\n",
        "NewModeratedSubject"   =>      "Nouveau message dans un forum mod�r�",
        "NewUnModeratedMessage" =>      "Un nouveau message a �t� envoy� sur un forum que vous mod�rez.\nLe message a �t� envoy� par %author% Le sujet est %subject%\n. Il peut �tre lu sur l'URL suivant\n%read_url%\n\n",        
        "NewPrivateMessages"    =>      "Vous avez de nouveaux messages priv�s",
        "NewReplyMessage"       =>      "Bonjour,\n\nVous recevez ce courriel car vous suivez la discussion :\n\n  %subject%\n  <%read_url%>\n\nPour arr�ter de recevoir cette discussion, cliquez ici :\n<%remove_url%>\n\nPour arr�ter de recevoir des courriels mais laisser cette discussion dans votre liste de suivi, cliquez ici :\n<%noemail_url%>\n\nPour voir les discussions que vous suivez, cliquez ici :\n<%followed_threads_url%>",
        "NewReplySubject"       =>      "[%forumname%] Nouvelle r�ponse: %subject%",
        "NewTopic"              =>      "Nouveau sujet",
        "NewerMessages"         =>      "Messages plus r�cents",
        "NewerThread"           =>      "Discussion plus r�cente",
        "newflag"               =>      "Nouveau",
        "NextMessage"           =>      "Message suivant",
        "NextPage"              =>      "Suivant",
        "No"                    =>      "Non",
        "NoForums"              =>      "D�sol�, aucun forum n'est visible ici.",
        "NoMoreEmails"          =>      "Vous ne recevrez plus de courriels quand cette discussion sera mise � jour.",
        "None"                  =>      "Tout",
        "NoPost"                =>      "D�sol�, vous n'avez pas la permission d'envoyer ou de r�pondre dans ce forum.",
        "NoPrivateMessages"     =>      "Vous n'avez pas de nouveau message priv�",
        "NoRead"                =>      "D�sol�, vous n'avez pas la permission de lire ce forum",
        "NotRegistered"         =>      "Pas encore enregistr� ? Cliquez ici pour vous enregistrer maintenant.",
        "NoResults"             =>      "Aucun r�sultat trouv�.",
        "NoResultsHelp"         =>      "Votre recherche ne correspond � aucun message.<br /><br />Suggestions:<ul><li>V�rifiez que tous les mots sont correctement orthographi�s.</li><li>Essayez des mots clefs diff�rents.</li><li>Essayez des mots clefs plus g�n�raux.</li><li>Essayez moins de mots clefs.</li></ul>",
        "NoUnapprovedMessages"  =>      "Il n'y a pas de messages non approuv�s",
        "NoUnapprovedUsers"     =>      "Il n'y a pas d'utilisateurs non approuv�s",
        
        "OlderMessages"         =>      "Messages plus anciens",
        "OlderThread"           =>      "Discussion plus ancienne",
        "on"                    =>      "le",  // as in: Posted by user on 01-01-01 01:01pm
        "of"                    =>      "parmi",  // as in: 1 - 5 of 458
        "Options"               =>      "Options",

        "Pages"                 =>      "Aller � la Page",
        "Password"              =>      "Mot de passe",
        "Past180Days"           =>      "Depuis 180 jours",
        "Past30Days"            =>      "Depuis 30 jours",
        "Past60Days"            =>      "Depuis 60 jours",
        "Past90Days"            =>      "Depuis 90 jours",
        "PastYear"              =>      "Depuis un an",
        "PeriodicLogin"         =>      "Pour votre protection, vous devez confirmer votre identification lorsque vous avez quitter le site.",
        "PermAdministrator"     =>      "Vous �tes administrateur.",
        "PermAllowPost"         =>      "Permission d'envoyer",
        "PermAllowRead"         =>      "Permission de lire",        
        "PermAllowReply"        =>      "Permission de r�pondre",
        "PermGroupModerator"    =>      "Mod�rateur pour l'adh�sion au Groupe",
        "Permission"            =>      "Permission",
        "PermModerator"         =>      "Mod�rateur",
        "PersProfile"           =>      "Profil personnel",
        "PleaseLoginPost"       =>      "D�sol�, seuls les utilisateurs enregistr�s peuvent envoyer dans ce forum.",
        "PleaseLoginRead"       =>      "D�sol�, seuls les utilisateurs enregistr�s peuvent lire dans ce forum.",
        "PMAddRecipient"        =>      "Ajouter un destinataire",
        "PMCloseMessage"        =>      "Fermer",
        "PMDeleteMessage"       =>      "Supprimer ce message",
        "PMDisabled"            =>      "La messagerie priv�e est inactive.",
        "PMFolderCreate"        =>      "Cr�er un nouveau dossier",
        "PMFolderExistsError"   =>      "Impossible de cr�er le dossier, il existe d�j�.",
        "PMFolderCreateSuccess" =>      "Le dossier a �t� cr��.",
        "PMFolderIsEmpty"       =>      "Il n'y a pas de message dans ce dossier.",
        "PMFolderDelete"        =>      "Supprimer le dossier",
        "PMFolderDeleteExplain" =>      "<b>Attention :</b> Si vous supprimez un dossier, tous les messages contenus seront aussi supprim�s ! Une fois supprim�s, il ne sera pas possible de les r�cup�rer. Si vous d�sirez conserver les messages, vous devez les d�placer dans un autre dossier.",
        "PMFolderDeleteConfirm" =>      "&Ecirc;tes vous s�r de supprimer le dossier et tous les messages qu'il contient ?",
        "PMFolderDeleteSuccess" =>      "Le dossier a �t� supprim�",
        "PMFolderNotAvailable"  =>      "Le dossier demand� n'est pas disponible",
        "PMFolderRename"        =>      "Renommer le dossier",
        "PMFolderRenameTo"      =>      "en",
        "PMFolderRenameSuccess" =>      "Le dossier a �t� renomm�",
        "PMNoRecipients"        =>      "Votre message n'a pas de destinataire",
        "PMNotAvailable"        =>      "Le message priv� demand� n'est pas disponible.",
        "PMNotifyEnableSetting" =>      "Pr�venir par couriel des messages priv�s",
        "PMNotifyMessage"       =>      "Vous avez re�u un nouveau message priv�.\n\n&Eacute;metteur : %author%\nSujet : %subject%\n\nVous pouvez lire ce message sur la page suivante :\n\n%read_url%\n\nThanks, $PHORUM[title]",
        "PMNotifySubject"       =>      "Nouveau message priv� sur $PHORUM[title]",
        "PMRead"                =>      "Lu",
        "PMUnread"              =>      "Non lu",
        "PMReply"               =>      "R�pondre",
        "PMReplyToAll"          =>      "R�pondre � tous",
        "PMRequiredFields"      =>      "Vous devez fournir le sujet et le message.",
        "PMSelectAFolder"       =>      "Choisir un dossier ...",
        "PMSelectARecipient"    =>      "Choisir un destinataire ...",
        "PMFromMailboxFull"     =>      "Vous ne pouvez pas garder une copie de ce message.<br/>Votre bo�te aux lettres est pleine.",
        "PMMoveToFolder"        =>      "D�placer",
        "PMNotSent"             =>      "Votre message priv� n'a pas �t� �mis. Erreur inconnue.",
        "PMSent"                =>      "Votre message priv� a �t� �mis.",
        "PMReadMessage"         =>      "Lire le message",
        "PMSpaceLeft"           =>      "Vous pouvez encore enregistrer %pm_space_left% message(s) priv�(s).",
        "PMSpaceFull"           =>      "Votre bo�te aux lettres est pleine.",
        "PMToMailboxFull"       =>      "Le message ne peut �tre �mis.<br/>La bo�te aux lettres du destinataire '%recipient%' est pleine.",
        "Post"                  =>      "Envoyer",
        "Posted"                =>      "Envoy�",
        "Postedby"              =>      "Envoy� par",   // as in: Posted by user on 01-01-01 01:01pm
        "PostErrorOccured"      =>      "Une erreur est survenue durant l'envoi de ce message.",
        "Posts"                 =>      "Envois",
        "Preview"               =>      "Aper�u",
        "PreviewExplain"        =>      "Aper�u avant publication.",
        "PreviewNoClickAttach"  =>      "Les pi�ces jointes ne peuvent pas �tre ouvertes depuis l'aper�u",
        "PreviousMatches"       =>      "Correspondances pr�c�dentes",
        "PreviousMessage"       =>      "Message pr�c�dent",
        "PrevPage"              =>      "Page pr�c�dente",
        "PrivateMessages"       =>      "Messages priv�s",
        "PrivateReply"          =>      "R�pondre par message priv�",
        "ProfileUpdatedOk"      =>      "Profil correctement mis � jour.",

	"OnlyUnapproved"        =>      "seulement les messages non approuv�s",

        "Quote"                 =>      "Citation",
        "QuoteMessage"          =>      "Citer ce Message",

        "read"                  =>      "lu",
        "ReadOnlyMessage"       =>      "Ce forum est en lecture seule. C'est une situation temporaire. R�essayez plus tard.",
        "ReadPrivateMessages"   =>      "Lire les messages priv�s",
        "RealName"              =>      "Vrai nom",
        "Received"              =>      "Re�u",
        "ReceiveModerationMails"=>      "Je veux recevoir les couriels de mod�ration",
        "Recipients"            =>      "destinataires",
        "RegApprovedSubject"    =>      "Votre compte a �t� approuv�.",
        "RegApprovedEmailBody"  =>      "Votre compte sur $PHORUM[title] a �t� approuv�. Vous pouvez vous identifier sur $PHORUM[title] � ".phorum_get_url(PHORUM_LOGIN_URL)."\n\nMerci, $PHORUM[title]",
        "RegAcctActive"         =>      "Votre compte est maintenant actif.",
        "RegBack"               =>      "Cliquez ici pour vous identifier.",
        "Register"              =>      "Cr�er un nouveau profil",
        "RegThanks"             =>      "Merci de vous �tre enregistr�.",
        "RegVerifyEmail"        =>      "Merci de vous �tre enregistr�. Vous aller recevoir un courriel avec des instructions pour activer votre compte.",
        "RegVerifyFailed"       =>      "D�sol�, il y a une erreur de v�rification de votre compte. Assurez vous d'avoir bien utiliser la totalit� de l'URL que vous avez re�u par courriel.",
        "RegVerifyMod"          =>      "Merci de vous �tre enregistr�. L'approbation d'un mod�rateur est n�cessaire � l'activation de votre compte. Vous recevrez un courriel apr�s qu'un mod�rateur ait valid� vos informations.",
        "RemoveFollowed"        =>      "Vous ne suivez plus cette discussion.",
        "RemoveFromGroup"       =>      "Retirer du groupe",
        "ReopenThread"          =>      "R�ouvrir cette discussion",
        "Reply"                 =>      "Repondre � ce message",
        "ReportPostEmailBody"   =>      "%reportedby% a signal� le message suivant..\n\n<%url%>\n------------------------------------------------------------------------\nForum:   %forumname%\nSujet: %subject%\nAuteur:  %author%\nIP:      %ip%\nDate:    %date%\n\n%body%\n\n------------------------------------------------------------------------\nPour supprimer ce message cliquer ici :\n<%delete_url%>\n\nPour cacher ce message cliquer ici :\n<%hide_url%>\n\nPour modifier ce message cliquer ici :\n<%edit_url%>\n\nLe profil personnel de %reportedby% est ici :\n<%reporter_url%>",
        "ReportPostEmailSubject"=>      "[%forumname%] Envoi signal� aux mod�rateurs",
        "ReportPostExplanation" =>      "Vous pouvez joindre une explication au signalement de cet envoi. Elle sera transmise aux mod�rateurs avec l'alerte. Elle peut aider le mod�rateur a comprendre pourqoi vous signalez cet envoi.",
        "ReportPostNotAllowed"  =>      "Vous devez �tre identifi� pour signaler un envoi.",
        "ReportPostSuccess"     =>      "Cet envoi a �t� signal� aux mod�rateurs du forum.",
        "Required"              =>      "�l�ments obligatoires",
        "Results"               =>      "R�sultats",
        "Report"                =>      "Signaler ce message",
        "RSS"                   =>      "RSS",

        "SaveChanges"           =>      "Enregistrer les modifications",
        "ScriptUsage"           =>      "Utilisation : php script.php [--module=<module_name> | --scheduled] [options]
        --module=<module_name>   Ex�cute le module sp�cifi�.
        --scheduled              Ex�cute tous les modules qui ne n�cessitent pas d'entr�es (modules planifi�s).
        [options]                Lors de l'ex�cution, ces options sont pass�es au module.
                                 Consultez la documentation du module pour connaitre ses options.
                                 Avec --scheduled, elles sont ignor�es.\n",
        "Search"                =>      "Chercher",
        "SearchAuthor"		=>      "Auteur",
        "SearchAuthors"		=>      "Auteurs",
        "SearchBody" 	        =>      "Texte",
        "SearchMessages"        =>      "Chercher dans les messages",
        "SearchResults"         =>      "R�sultats de recherche",
        "SearchRunning"         =>      "Recherche en cours, patientez.",
	"SearchSubject"		=>	"Sujet",
	"SearchTip"		=>	"AND est l'op�rateur par d�faut. Ainsi, une recherche pour chien et chat trouvera tous les messages qui contiennent ces mots n'importe o�.<br /><br />Les guillemets (\") permettent la recherche de phrases. De cette fa�on, une recherche avec \"chien chat\" trouvera les messages qui contiennent la phrase exacte avec l'espace.<br /><br />Le moins (-) �limine des mots. Une recherche avec chien et -chat trouvera tous les messages qui contiennent chien mais pas chat. On peut utiliser le moins avec une phrase entre guillemets. Par exemple : chien -\"chat siamois\".<br /><br />Le moteur est insensible � la casse et recherche sur le titre, le corps et l'auteur.",
	"SearchTips"		=>	"Astuces de recherche",
        "SelectGroupMod"        =>      "S�lectionner un groupe � mod�rer",
        "SelectForum"           =>      "S�lectionner le Forum ...",
        "SendPM"                =>      "Envoyer un message priv�",
        "SentItems"             =>      "El�ments envoy�s",
        "Showing"               =>      "Montrer",
        "ShowOnlyMessages"      =>      "Montrer les messages",
        "Signature"             =>      "Signature",
        "Special"               =>      "Sp�cial",
        "SplitThread"           =>      "Scinder la discussion",
        "SplitThreadInfo"       =>      "Faire de ce message et de ses r�ponses une discussion.",
        "SrchMsgBodies"         =>      "Corps des messages (plus lent)",
        "StartedBy"             =>      "Commenc� par",
        "Sticky"                =>      "Note ",
        "Subject"               =>      "Sujet",
        "Submit"                =>      "Appliquer",
        "Subscribe"             =>      "S'inscrire � ce Forum",
        "Subscriptions"         =>      "Discussions suivies",
        "Suspended"             =>      "Suspendu",

        "Template"              =>      "Mod�le",
        "ThankYou"              =>      "Merci",
        "ThreadAnnouncement"    =>      "Vous ne pouvez pas r�pondre aux avis.",
        "ThreadClosed"          =>      "Cette discussion a �t� ferm�e",
        "ThreadClosedOk"        =>      "La discussion a �t� ferm�e.",
        "Thread"                =>      "Discussion",
        "Threads"               =>      "Discussions",
        "ThreadReopenedOk"      =>      "La discussion a �t� r�ouverte.",
        "ThreadViewList"        =>      "Survol des discussions - Liste",
        "ThreadViewRead"        =>      "Survol des discussions - Lues",		
        "Timezone"              =>      "Fuseau horaire de l'utilisateur",
        "To"                    =>      "�",
        "Today"                 =>      "Aujourd'hui",
        "Total"                 =>      "Total",
        "TotalFiles"            =>      "Total des fichiers",
        "TotalFileSize"         =>      "Espace utilis�",
        
        "Unapproved"            =>      "Non approuv�",
        "UnapprovedGroupMembers" =>     "Il y a des adh�sions non approuv�es",
        "UnapprovedMessage"     =>      "Message non approuv�",        
        "UnapprovedMessages"    =>      "Messages non approuv�s",
        "UnapprovedMessagesLong" =>     "Il y a des messages non approuv�s",
        "UnapprovedUsers"       =>      "Utilisateurs non approuv�s",
        "UnapprovedUsersLong"   =>      "Il y a des utilisateurs non approuv�s",
        "Unbookmark"            =>      "Enlever le signet",
        "UnknownUser"           =>      "Cet utilisateur n'existe pas",
        "Unsubscribe"           =>      "D�sabonner",
        "UnsubscribeError"      =>      "Vous ne pouvez pas vous d�sabonner de cette discussion.",
        "UnsubscribeOk"         =>      "Vous avez �t� d�sabonn� de la discussion.",
        "Update"                =>      "Mettre � jour",
        "UploadFile"            =>      "Transf�rer un nouveau fichier",
        "UploadNotAllowed"      =>      "Vous n'�tes pas autoris� � transf�rer des fichiers sur ce serveur.",        
        "UserAddedToGroup"      =>      "L'utilisateur a �t� ajout� au groupe.",
        "Username"              =>      "Nom d'utilisateur",
        "UserNotFound"          =>      "Le destinataire de votre message est introuvable. V�rifiez le nom et recommencez.",
        "UserPermissions"       =>      "Permissions de l'utilisateur",
        "UserProfile"           =>      "Informations personnelles",
        "UserSummary"           =>      "Mon panneau de commande",

        "VerifyRegEmailSubject" =>      "Validez votre inscription",
        "VerifyRegEmailBody1"   =>      "Pour valider votre compte sur $PHORUM[title], cliquer sur l'URL ci-dessous.",
        "VerifyRegEmailBody2"   =>      "Une fois control�, vous pourrez vous identifier sur $PHORUM[title] � ".phorum_get_url(PHORUM_LOGIN_URL)."\n\nMerci, $PHORUM[title]",
        "ViewFlat"              =>      "Vue � plat",
        "ViewJoinGroups"        =>      "Rejoindre un groupe",
        "ViewProfile"           =>      "Voir mon profil",
        "ViewThreaded"          =>      "Voir par discussion",
        "Views"                 =>      "Vues",

        "WrittenBy"             =>      "Ecrit par",
        "ErrWrongMailcode"      =>      "Vous avez saisi un code de confirmation erron�. Recommencez !",
        "Wrote"                 =>      "&Eacute;crivait",

        "Year"                  =>      "Ann�e",
        "Yes"                   =>      "Oui",
        "YourEmail"             =>      "Votre adresse �lectronique",
        "YourName"              =>      "Votre nom",
        "YouWantToFollow"       =>      "Vous avez souhait� suivre cette discussion.",
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
