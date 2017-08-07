<?php

    $language="English (American)";
    // uncomment this to hide this language from the user-select-box
    //$language_hide=1;

    // check the php-docs for the syntax of these entries (http://www.php.net/manual/en/function.strftime.php)
    // One tip, don't use T for showing the time zone as users can change their time zone.
    $PHORUM['long_date']="%B %d, %Y %I:%M%p";
    $PHORUM['short_date']="%m/%d/%Y %I:%M%p";

    // locale setting for localized times/dates
    // see that page: http://www.w3.org/WAI/ER/IG/ert/iso639.htm
    // for the needed string
    $PHORUM['locale']="EN";

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

        "AccountSummaryTitle"   =>      "My Settings",
        "Action"                =>      "Action",
        "Activity"              =>      "Only Show Post With Activity In The Last",
        "Add"                   =>      "Add",
        "AddSig"                =>      "Add my signature to this post.",
        "AddSigDefault"         =>      "Enable &quot;Add my signature&quot; as default",
        "AddToGroup"            =>      "Add New Member To Group:",
        "AdminOnlyMessage"      =>      "This forum is currently disabled.  This is a temporary situation.  Please check back later.",
        "again"                 =>      "again",
        "AllDates"              =>      "All Dates",
        "AllNotShown"           =>      "all hidden messages",
        "AllowReplies"          =>      "Replies are allowed",
        "AllWords"              =>      "All Words",
        "AllowSeeActivity"      =>      "Allow other users to see when I am logged in",
        "AllowSeeEmail"         =>      "Allow other users to see my email address",
        "Announcement"          =>      "Announcement",
        "AnonymousUser"         =>      "Anonymous User",
        "AnyWord"               =>      "Any Word",
        "Approved"              =>      "Approved",
        "ApproveUser"           =>      "Approve",
        "ApproveMessageShort"   =>      "Approve",
        "ApproveMessage"        =>      "Approve Message",
        "ApproveMessageReplies" =>      "Approve +Replies",
        "AreYouSure"            =>      "Are you sure?",
        "Attach"                =>      "Attach",
        "AttachAFile"           =>      "Attach a file",
        "AttachAnotherFile"     =>      "Attach another file",
        "AttachCancel"          =>      "You post has been canceled.",
        "AttachFiles"           =>      "Attach Files",
        "AttachFileTypes"       =>      "Valid attachments: %types%",
        "AttachFileSize"        =>      "No file can be larger than %size%",
        "AttachMaxAttachments"  =>      "%count% more file(s) can be attached to this message",
        "AttachTotalFileSize"   =>      "All files together cannot be larger than %size%",
        "AttachInstructions"    =>      "When you are done attaching files, click Post",
        "AttachInvalidType"     =>      "That file is not a valid attachment.",
        "AttachFull"            =>      "You have reached the maximum allowed number of attachments.",
        "AttachInfo"            =>      "Your post will be saved on the server now.  You will have the option to edit it again before it appears on the forum.",
        "AttachmentAdded"       =>      "Your file was successfully attached to your message",
        "Attachments"           =>      "Attachments",
        "AttachmentsMissing"    =>      "You failed to attach any files, please try again.",
        "AttachNotAllowed"      =>      "Sorry, you cannot attach files to this message.",
        "Author"                =>      "Author",

        "BacktoForum"           =>      "Back to Forum",
        "BackToForumList"       =>      "Back to Forum List",
        "BackToList"            =>      "Click here to return to the message list.",
        "BackToThread"          =>      "Click here to return to the thread.",
        "BackToSearch"          =>      "Click here to return to the search screen.",
        "BookmarkedThread"      =>      "You are now following this thread in your Control Center.",
        "Buddies"               =>      "Buddies",
        "Buddy"                 =>      "Buddy",
        "BuddyAdd"              =>      "Add user to my buddy list",
        "BuddyAddFail"          =>      "The user could not be added to your buddy list",
        "BuddyAddSuccess"       =>      "The user has been added to your buddy list successfully",
        "BuddyListIsEmpty"      =>      "Your buddy list is empty.<br/>To add users, view their profile and click \"Add user to my buddy list\".",
        "by"                    =>      "by",

        "Cancel"                =>      "Cancel",
        "CancelConfirm"         =>      "Are you sure you want to cancel?",
        "CannotBeRunFromBrowser" =>     "This script cannot be run from a web browser.",
        "ChangeEMail"           =>      "Change Email",
        "ChangePassword"        =>      "Change Password",
        "ChangesSaved"          =>      "The changes have been saved.",
        "CheckToDelete"         =>      "Check To Delete",
        "ClickHereToLogin"      =>      "Click here to login",
        "CloseThread"           =>      "Close this Thread",
        "ConfirmDeleteMessage"  =>      "Are you sure you want to delete this message?",
        "ConfirmDeleteThread"   =>      "Are you sure you want to delete this thread?",
        "ConfirmReportMessage"  =>      "Are you sure you want to report this post?",
        "CurrentPage"           =>      "Current Page",

        "Date"                  =>      "Date",
        "DateActive"            =>      "Last Activity",
        "DateAdded"             =>      "Date Added",
        "DatePosted"            =>      ", posted in the last",
        "DateReg"               =>      "Date Registered",
        "Day"                   =>      "Day",
        "Days"                  =>      "Days",
        "Default"               =>      "Default",
        "DeleteAnnouncementForbidden"   =>  "Sorry, only an Administrator may delete an announcement.",
        "DeleteMessage"         =>      "Delete Message",
        "DeleteMessageShort"    =>      "Del",
        "DelMessReplies"        =>      "Delete Message And Replies",
        "DelMessRepliesShort"   =>      "Del+",
        "Delete"                =>      "Delete",
        "DeletePost"            =>      "Delete Post",
        "DeleteThread"          =>      "Delete Thread",
        "DenyUser"              =>      "Deny",
        "Detach"                =>      "Delete",

        "EditBoardsettings"     =>      "Forum Settings",
        "EditFolders"           =>      "Edit Folders",
        "EditPost"              =>      "Edit Post",
        "EditPostForbidden"     =>      "You do not have permission to edit this post. If the administrator has set a time limit on editing, it may have expired.",
        "EditedMessage"         =>      "Edited %count% time(s). Last edit at %lastedit% by %lastuser%.",
        "EditMailsettings"      =>      "Edit Email Settings",
        "EditMyFiles"           =>      "Edit My Files",
        "EditPrivacy"           =>      "Edit My Privacy Options",
        "EditSignature"         =>      "Edit Signature",
        "EditUserinfo"          =>      "Edit My Profile",
        "EmailReplies"          =>      "Send replies to this thread to me via email",
        "Email"                 =>      "Email",
        "EmailConfirmRequired"  =>      "Email confirmation required.",
        "EmailVerify"           =>      "Email Verification",
        "EmailVerifyDesc"       =>      "Verification of the new email-address",
        "EmailVerifyEnterCode"  =>      "Please enter the verification code you got",
        "EmailVerifySubject"    =>      "Verification of your new email-address",
        "EmailVerifyBody"       =>      "Hello %uname%,\n\nThis email is sent to you because you requested to change your email-address in your profile. To confirm that this is a valid email-address you are receiving this mail with your confirmation-code. You can simply ignore this mail if you are not %uname%.\n\nThe new email-address is: %newmail%\nThe confirmation code is: %mailcode%\n\nPlease enter the code in your profile to confirm the change:\n\n<%cc_url%>\n\nThanks, $PHORUM[title]",
        "EnableNotifyDefault"   =>      "Enable email-notification as default",
        "EnterToChange"         =>      "Enter To Change",
        "Error"                 =>      "Error",
        "ErrInvalid"            =>      "Invalid data submitted.",
        "ErrAuthor"             =>      "Please fill in the author field.",
        "ErrSubject"            =>      "Please fill in the subject.",
        "ErrBody"               =>      "Please fill in the message body.",
        "ErrBodyTooLarge"       =>      "Please shorten your messages, the body is too large.",
        "ErrEmail"              =>      "The email address you entered does not appear to be a valid email address.  Please try again.",
        "ErrEmailExists"        =>      "The email address you entered is already listed with another user.",
        "ErrUsername"           =>      "Please fill in the username field.",
        "ErrPassword"           =>      "Either the password field is empty or the passwords do not match.  Please try again.",
        "ErrUserAddUpdate"      =>      "User not added/updated.  Unknown error.",
        "ErrRequired"           =>      "Please fill in all required fields.",
        "ErrBannedContent"      =>      'A word you have used in your post has been banned from use. Please use a different word or contact the forum administrators.',
        "ErrBannedIP"           =>      "Your IP address, domain or ISP has been blocked. Please contact the forum administrators.",
        "ErrBannedName"         =>      'The (user)name "%name%" has been banned from use. Please use a different name or contact the forum administrators.',
        "ErrBannedEmail"        =>      'The e-mail address "%name%" has been banned from use. Please use a different email address or contact the forum administrators.',
        "ErrBannedUser"         =>      'The user "%name%" has been banned from use.',

        "ErrRegisterdEmail"     =>      "The email address you entered is listed with a currently registered user. If you are that user, please login.  Otherwise, please use another email address.",
        "ErrRegisterdName"      =>      "The name you entered is already registered by another user. If you are that user, please login.  Otherwise, please use another name.",
        "ExactPhrase"           =>      "Exact Phrase",

        "FileForbidden"         =>      "Linking to files in this forum is not allowed from outside the forum.",
        "FileSizeLimits"        =>      "Please do not upload files larger than",
        "FileQuotaLimits"       =>      "The maximum amount of diskspace you may use for storing files is",
        "FileTypeLimits"        =>      "Only the following file types may be uploaded: " . str_replace(";", ", ", $PHORUM['file_types']) . ".",
        "Filename"              =>      "File Name",
        "FileOverQuota"         =>      "Your file could not be uploaded.  The size of this file would put you over your quota.  You may not store more than {$PHORUM['file_space_quota']}k on the server.",
        "Files"                 =>      "My Files",
        "Filesize"              =>      "File Size",
        "FileTooLarge"          =>      "The file you attempted to upload exceeds the maximum upload size.  Please do not upload files larger than {$PHORUM['max_file_size']}k",
        "FileWrongType"         =>      "This server does not allow uploading of files of this type.  Files types that are accepted: " . str_replace(";", ", ", $PHORUM['file_types']) . ".",
        "Filter"                =>      "Filter",
        "FirstPage"             =>      "First",
        "Folders"               =>      "Folder List",
        "FollowExplanation"     =>      "Followed threads are listed in your Control Center.<br />You can select to receive an email when the thread is updated.",
        "FollowThread"          =>      "Follow This Thread",
        "FollowWithEmail"       =>      "Email me when this thread is updated",
        "Forum"                 =>      "Forum",
        "ForumFolder"           =>      "Forum Folder",
        "Forums"                =>      "Forums",
        "ForumList"             =>      "Forum List",
        "From"                  =>      "From",

        "Go"                    =>      "Go",
        "GoToTop"               =>      "Newest Messages",
        "Goto"                  =>      "Goto",
        "GoToNew"               =>      "Go to new",
        "GotoThread"            =>      "Goto Thread",
        "Group"                 =>      "Group",
        "GroupJoinFail"         =>      "Group could not be joined.",
        "GroupJoinSuccess"      =>      "Group joined successfully.",
        "GroupJoinSuccessModerated" =>  "Group joined successfully. As this is a moderated group, your membership will need to be approved before taking effect.",
        "GroupMembership"       =>      "Group Membership",
        "GroupMemberList"       =>      "Group Member List: ",

        "Hidden"                =>      "Hidden",
        "HideEmail"             =>      "Hide my email address from other users",
        "HideMessage"           =>      "Hide Message and Replies",
        "HowToFollowThreads"    =>      "You can follow a thread by clicking \"Follow This Thread\" when reading a message.  Also, if you select \"Send replies to this thread to me via email\" when creating a post, the message will be added to your followed thread list.",

        "INBOX"                 =>      "Inbox",
        "InReplyTo"             =>      "In reply to",
        "InvalidLogin"          =>      "That username/password was not found or is inactive.  Please try again.",
        "IPLogged"              =>      "IP Logged",
        "IsDST"                 =>      "DST currently active",

        "Join"                  =>      "Join",
        "JoinAGroup"            =>      "Join a Group",
        "JoinGroupDescription"  =>      "To join a group, select it from this list. Groups marked with an * are moderated, your membership request will require the approval of a Group Moderator to take effect.",

        "KeepCopy"              =>      "Keep A Copy In My Sent Items",

        "Language"              =>      "Language",
        "Last30Days"            =>      "Last 30 Days",
        "Last90Days"            =>      "Last 90 Days",
        "Last365Days"           =>      "Last Year",

        "LastPost"              =>      "Last Post",
        "LastPostLink"          =>      "Last Post",
        "LastPage"              =>      "Last",
        "ListForums"            =>      "List Forums",
        "ListThreads"           =>      "Show Followed Threads",
        "LogIn"                 =>      "Log In",
        "LogOut"                =>      "Log Out",
        "LoginTitle"            =>      "Enter your username and password to log in.",
        "LostPassword"          =>      "Did you forget your password?",
        "LostPassError"         =>      "The email address you entered could not be found.",
        "LostPassInfo"          =>      "Enter your email address below and a new password will be sent to you.",
        "LostPassEmailSubject"  =>      "Your login information for the $PHORUM[title]",
        "LostPassEmailBody1"    =>      "Someone (hopefully you) has requested a new password for your account at $PHORUM[title].  If it was not you, you can ignore this email and continue using your old password.\n\nIf it was you, here is your new login for the forums.",
        "LostPassEmailBody2"    =>      "You can login to $PHORUM[title] at ".phorum_get_url(PHORUM_LOGIN_URL)."\n\nThanks, $PHORUM[title]",
        "LostPassSent"          =>      "A new password has been sent to the email address you provided.",

        "MakeSticky"            =>      "Make Sticky",
        "MakeAnnouncement"      =>      "Make Announcement",
        "MarkForumRead"         =>      "Mark Forum Read",
        "MarkRead"              =>      "Mark All Messages Read",
        "MarkThreadRead"        =>      "Mark Thread Read",
        "MatchAllForums"        =>      "Search All Forums",
        "MatchThisForum"        =>      "Search Only This Forum",
        "MatchAll"              =>      "All Words",
        "MatchAny"              =>      "Any Words",
        "MatchPhrase"           =>      "Exact Phrase",
        "MembershipType"        =>      "Membership Type",
        "MergeThread"           =>      "Merge Thread",
        "MergeThreadCancel"     =>      "Cancel Merge Thread",
        "MergeThreads"          =>      "Merge Threads",
        "MergeThreadAction"     =>      "The following threads can be merged into one thread",
        "MergeThreadInfo"       =>      "Now go to the thread which should be merged with the selected thread and select 'Merge Thread' again.",
        "MergeThreadWith"       =>      "Merge Thread with",
        "MessageList"           =>      "Message List",
        "MessageNotFound"       =>      "Sorry, the message you have requested could not be found.",
        "Message"               =>      "Message",
        "Moderate"              =>      "Moderate",
        "Moderator"             =>      "Moderator",
        "ModeratedForum"        =>      "This is a moderated forum. Your message will remain hidden until it has been approved by a moderator or administrator",
        "ModFuncs"              =>      "Moderator Functions",
        "ModerationMessage"     =>      "Moderation",
        "Month"                 =>      "Month",
        "Months"                =>      "Months",
        "MoreMatches"           =>      "More Matches",
        "MoveAnnouncementForbidden" => "Announcement threads cannot be moved.",
        "MovedSubject"          =>      "Moved",
        "MovedMessage"          =>      "This thread has been moved. You will be redirected to its current location.",
        "MovedMessageTo"        =>      "To the current location of this thread.",
        "MoveNotification"      =>      "Leave behind a move notification",
        "MoveThread"            =>      "Move Thread",
        "MoveThreadTo"          =>      "Move Thread to Forum",
        "MsgApprovedOk"         =>      "Message(s) approved",
        "MsgDeletedOk"          =>      "Message(s) deleted",
        "MsgHiddenOk"           =>      "Message(s) hidden.",
        "MsgMergeCancel"        =>      "'Merge Threads' has been cancelled.",
        "MsgMergeOk"            =>      "The threads have been merged into one thread.",
        "MsgMoveOk"             =>      "The Thread was moved to the given Forum.",
        "MsgRedirect"           =>      "You are being redirected to continue, click here if you are not automatically redirected",
        "MsgModEdited"          =>      "The changed message has been saved.",
        "MsgSplitOk"            =>      "The Thread has been successfully split into two threads.",
        "Mutual"                =>      "Mutual",
        "MyProfile"             =>      "My Control Center",

        "Navigate"              =>      "Navigate",
        "NewMessage"            =>      "New Message",
        "NewModeratedMessage"   =>      "There has been a new message sent to a forum which you are moderating.\nThe message has the subject %subject%\nand it can be reviewed and approved through the following URL\n%approve_url%\n\n",
        "NewModeratedSubject"   =>      "New message in moderated forum",
        "NewUnModeratedMessage" =>      "There has been a new message sent to a forum which you are moderating.\nThe message has been posted by %author% with the subject %subject%\nand it can be read through the following URL\n%read_url%\n\n",
        "NewPrivateMessages"    =>      "You have new private messages",
        "NewReplyMessage"       =>      "Hello,\n\nYou are receiving this email because you are following the thread:\n\n  %subject%\n  <%read_url%>\n\nTo stop following this thread click here:\n<%remove_url%>\n\nTo stop receiving emails, but leave this thread on your follow list, click here:\n<%noemail_url%>\n\nTo view your followed threads, click here:\n<%followed_threads_url%>",
        "NewReplySubject"       =>      "[%forumname%] New reply: %subject%",
        "NewTopic"              =>      "New Topic",
        "NewerMessages"         =>      "Newer Messages",
        "NewerThread"           =>      "Newer Thread",
        "newflag"               =>      "new",
        "NextMessage"           =>      "Next Message",
        "NextPage"              =>      "Next",
        "No"                    =>      "No",
        "NoForums"              =>      "Sorry, no forums to show here.",
        "NoMoreEmails"          =>      "You will no longer receive emails when this thread is updated.",
        "None"                  =>      "None",
        "NoPost"                =>      "Sorry, you do not have permission to post/reply in this forum.",
        "NoPrivateMessages"     =>      "You have no new private messages",
        "NoRead"                =>      "Sorry, you do not have permission to read this forum.",
        "NotRegistered"         =>      "Not Registered?  Click here to register now.",
        "NoResults"             =>      "No results were found.",
        "NoResultsHelp"         =>      "Your search did not match any messages.<br /><br />Suggestions:<ul><li>Make sure all words are spelled correctly.</li><li>Try different keywords.</li><li>Try more general keywords.</li><li>Try fewer keywords.</li></ul>",
        "NoUnapprovedMessages"  =>      "There are currently no unapproved mesages",
        "NoUnapprovedUsers"     =>      "There are currently no unapproved users",

        "OlderMessages"         =>      "Older Messages",
        "OlderThread"           =>      "Older Thread",
        "on"                    =>      "on",  // as in: Posted by user on 01-01-01 01:01pm
        "of"                    =>      "of",  // as in: 1 - 5 of 458
        "Options"               =>      "Options",

        "Pages"                 =>      "Goto Page",
        "Password"              =>      "Password",
        "Past180Days"           =>      "Past 180 Days",
        "Past30Days"            =>      "Past 30 Days",
        "Past60Days"            =>      "Past 60 Days",
        "Past90Days"            =>      "Past 90 Days",
        "PastYear"              =>      "Past Year",
        "PeriodicLogin"         =>      "For your protection, you are required to confirm your login information when you have been away from the site.",
        "PermAdministrator"     =>      "You are an Administrator.",
        "PermAllowPost"         =>      "post-permission",
        "PermAllowRead"         =>      "read-permission",
        "PermAllowReply"        =>      "reply-permission",
        "PermGroupModerator"    =>      "Group Membership Moderator",
        "Permission"            =>      "Permission",
        "PermModerator"         =>      "Moderator",
        "PersProfile"           =>      "Personal Profile",
        "PleaseLoginPost"       =>      "Sorry, only registered users may post in this forum.",
        "PleaseLoginRead"       =>      "Sorry, only registered users may read this forum.",
        "PMAddRecipient"        =>      "Add recipient",
        "PMCloseMessage"        =>      "Close",
        "PMDeleteMessage"       =>      "Delete This Message",
        "PMDisabled"            =>      "Private Messaging is disabled.",
        "PMFolderCreate"        =>      "Create new folder",
        "PMFolderExistsError"   =>      "Can't create folder. The folder already exists.",
        "PMFolderCreateSuccess" =>      "The folder has been created successfully.",
        "PMFolderIsEmpty"       =>      "There are no messages in this folder.",
        "PMFolderDelete"        =>      "Delete folder",
        "PMFolderDeleteExplain" =>      "<b>Warning:</b> if you delete a folder, all messages in the folder will be deleted as well! Once deleted, you will not be able to restore those messages. If you want to keep the messages, then you must move them to another folder.",
        "PMFolderDeleteConfirm" =>      "Are you sure you want to delete the selected folder, including all messages in it?",
        "PMFolderDeleteSuccess" =>      "The folder has been deleted successfully",
        "PMFolderNotAvailable"  =>      "The folder you requested is not available",
        "PMFolderRename"        =>      "Rename folder",
        "PMFolderRenameTo"      =>      "to",
        "PMFolderRenameSuccess" =>      "The folder has been renamed successfully",
        "PMNoRecipients"        =>      "You have not specified any recipients for your message",
        "PMNotAvailable"        =>      "The private message you requested is not available.",
        "PMNotifyEnableSetting" =>      "Enable e-mail notification for private messages",
        "PMNotifyMessage"       =>      "You have received a new private message.\n\nSent by : %author%\nSubject : %subject%\n\nYou can read the message at the following page:\n\n%read_url%\n\nThanks, $PHORUM[title]",
        "PMNotifySubject"       =>      "New private message on $PHORUM[title]",
        "PMRead"                =>      "Read",
        "PMUnread"              =>      "Unread",
        "PMReply"               =>      "Reply",
        "PMReplyToAll"          =>      "Reply to All",
        "PMRequiredFields"      =>      "Please provide a subject and a message.",
        "PMSelectAFolder"       =>      "Select folder ...",
        "PMSelectARecipient"    =>      "Select recipient ...",
        "PMFromMailboxFull"     =>      "You cannot keep a copy of this message.<br/>Your mail storage space is full.",
        "PMMoveToFolder"        =>      "Move",
        "PMNotSent"             =>      "Your private message was not sent. There was an unknown error.",
        "PMSent"                =>      "Your private message was sent successfully",
        "PMReadMessage"         =>      "Read message",
        "PMSpaceLeft"           =>      "You can store %pm_space_left% more private message(s).",
        "PMSpaceFull"           =>      "The storage space for your private messages is full.",
        "PMToMailboxFull"       =>      "The message could not be sent.<br/>The mail storage space for user '%recipient%' is full.",
        "Post"                  =>      "Post message",
        "Posted"                =>      "Posted",
        "Postedby"              =>      "Posted by",   // as in: Posted by user on 01-01-01 01:01pm
        "PostErrorOccured"      =>      "An error occured while trying to post this message.",
        "Posts"                 =>      "Posts",
        "Preview"               =>      "Preview",
        "PreviewExplain"        =>      "This is how your message will appear in the forum.",
        "PreviewNoClickAttach"  =>      "Attachments can not be opened from the preview",
        "PreviousMatches"       =>      "Previous Matches",
        "PreviousMessage"       =>      "Previous Message",
        "PrevPage"              =>      "Previous",
        "PrivateMessages"       =>      "Private Messages",
        "PrivateReply"          =>      "Reply via PM",
        "ProfileUpdatedOk"      =>      "Profile successfully updated.",
        "OnlyUnapproved"        =>      "only unapproved messages",
        "Quote"                 =>      "Quote",
        "QuoteMessage"          =>      "Quote This Message",

        "read"                  =>      "read",
        "ReadOnlyMessage"       =>      "This forum is currently read only.  This is a temporary situation.  Please check back later.",
        "ReadPrivateMessages"   =>      "Read Private Messages",
        "RealName"              =>      "Real Name",
        "Received"              =>      "Received",
        "ReceiveModerationMails"=>      "I want to receive moderation emails",
        "Recipients"            =>      "recipients",
        "RegApprovedSubject"    =>      "Your account has been approved.",
        "RegApprovedEmailBody"  =>      "Your $PHORUM[title] account has been approved.  You can login to $PHORUM[title] at ".phorum_get_url(PHORUM_LOGIN_URL)."\n\nThanks, $PHORUM[title]",
        "RegAcctActive"         =>      "Your account is now active.",
        "RegBack"               =>      "Click here to login.",
        "Register"              =>      "Create A New Profile",
        "RegThanks"             =>      "Thank you for registering.",
        "RegVerifyEmail"        =>      "Thank you for registering.  You will receive an email shortly with instruction for activating your account.",
        "RegVerifyFailed"       =>      "Sorry, there was an error verifying your account.  Please make sure you used the entire URL included in the email you received.",
        "RegVerifyMod"          =>      "Thank you for registering.  Approval from a moderator is required to activate your account.  You will receive an email after a moderator has reviewed your information.",
        "RemoveFollowed"        =>      "You are no longer following this thread.",
        "RemoveFromGroup"       =>      "Remove From Group",
        "ReopenThread"          =>      "Reopen this Thread",
        "Reply"                 =>      "Reply To This Message",
        "ReportPostEmailBody"   =>      "%reportedby% has reported a message. The reason given was: \n------------------------------------------------------------------------\n%explanation%\n\n<%url%>\n------------------------------------------------------------------------\nForum:   %forumname%\nSubject: %subject%\nAuthor:  %author%\nIP:      %ip%\nDate:    %date%\n\n%body%\n\n------------------------------------------------------------------------\nTo delete this message click here:\n<%delete_url%>\n\nTo hide this message click here:\n<%hide_url%>\n\nTo edit this message click here:\n<%edit_url%>\n\nThe profile for %reportedby% is here:\n<%reporter_url%>",
        "ReportPostEmailSubject"=>      "[%forumname%] Post reported to the moderators",
        "ReportPostExplanation" =>      "You may optionally give an explanation for why this post was reported, which will be sent to the moderators along with the report. This can help the moderator to understand why you reported the post.",
        "ReportPostNotAllowed"  =>      "You must be logged in to report a post.",
        "ReportPostSuccess"     =>      "This post has been reported to the forum moderators.",
        "Required"              =>      "Required Items",
        "Results"               =>      "Results",
        "Report"                =>      "Report This Message",
        "RSS"                   =>      "RSS",

        "SaveChanges"           =>      "Save Changes",
        "ScriptUsage"           =>      "\nUsage: php script.php [--module=<module_name> | --scheduled] [options]

   --module=<module_name>  Run the 'external' hook in the specified module.
   --scheduled             Run the 'scheduled' hooks in all available modules.
   [options]               When running a specific module, these options
                           are passed to the module. Consult the module
                           documentation for information on what options
                           it has. When using --scheduled, these are ignored.

Read docs/creating_mods.txt in your distribution for information on how
to write Phorum modules and on how to use the external and scheduled hooks.\n\n",
        "SearchAuthors"         =>      "Search Authors",
        "SearchResults"         =>      "Search Results",
        "Search"                =>      "Search",
        "SearchMessages"        =>      "Search Messages",
        "SearchRunning"         =>      "Your search is running, please be patient.",
        "SelectGroupMod"        =>      "Select a group to moderate",
        "SelectForum"           =>      "Select the Forum ...",
        "SendPM"                =>      "Send A Private Message",
        "SentItems"             =>      "Sent Items",
        "Showing"               =>      "Showing",
        "ShowOnlyMessages"      =>      "Show",
        "Signature"             =>      "Signature",
        "Special"               =>      "Special",
        "SplitThread"           =>      "Split Thread",
        "SplitThreadInfo"       =>      "Move this message and its replies to be its own thread",
        "SrchMsgBodies"         =>      "Message Bodies (slower)",
        "StartedBy"             =>      "Started By",
        "Sticky"                =>      "Sticky",
        "Subject"               =>      "Subject",
        "Submit"                =>      "Submit",
        "Subscribe"             =>      "Subscribe To This Forum",
        "Subscriptions"         =>      "Followed Threads",
        "Suspended"             =>      "Suspended",

        "Template"              =>      "Template",
        "ThankYou"              =>      "Thank You",
        "ThreadAnnouncement"    =>      "You can't reply to announcements.",
        "ThreadClosed"          =>      "This Thread has been closed",
        "ThreadClosedOk"        =>      "The Thread has been closed.",
        "Thread"                =>      "Thread",
        "Threads"               =>      "Threads",
        "ThreadReopenedOk"      =>      "The Thread has been reopened.",
        "ThreadViewList"        =>      "Thread Override - List",
        "ThreadViewRead"        =>      "Thread Override - Read",
        "Timezone"              =>      "User-Timezone",
        "To"                    =>      "To",
        "Today"                 =>      "Today",
        "Total"                 =>      "Total",
        "TotalFiles"            =>      "Total Files",
        "TotalFileSize"         =>      "Space Used",

        "Unapproved"            =>      "Unapproved",
        "UnapprovedGroupMembers" =>     "There are unapproved group memberships",
        "UnapprovedMessage"     =>      "Unapproved Message",
        "UnapprovedMessages"    =>      "Unapproved Messages",
        "UnapprovedMessagesLong" =>     "There are unapproved messages",
        "UnapprovedUsers"       =>      "Unapproved Users",
        "UnapprovedUsersLong"   =>      "There are unapproved users",
        "Unbookmark"            =>      "Unbookmark",
        "UnknownUser"           =>      "This user doesn't exist or has been deactivated.",
        "Unsubscribe"           =>      "Unsubscribe",
        "UnsubscribeError"      =>      "You couldn't get unsubscribed from that thread.",
        "UnsubscribeOk"         =>      "You were unsubscribed from the given thread.",
        "Update"                =>      "Save changes",
        "UploadFile"            =>      "Upload A New File",
        "UploadNotAllowed"      =>      "You are not allowed to upload files to this server.",
        "UserAddedToGroup"      =>      "The user has been added to the group.",
        "Username"              =>      "Username",
        "UserNotFound"          =>      "The user you want to send a message to could not be found.  Please check the name and try again.",
        "UserPermissions"       =>      "User Permissions",
        "UserProfile"           =>      "User Profile",
        "UserSummary"           =>      "My Control Panel",

        "VerifyRegEmailSubject" =>      "Please verify your account",
        "VerifyRegEmailBody1"   =>      "To validate your $PHORUM[title] account, please click on the URL below.",
        "VerifyRegEmailBody2"   =>      "Once verified, you can login to $PHORUM[title] at ".phorum_get_url(PHORUM_LOGIN_URL)."\n\nThanks, $PHORUM[title]",
        "ViewFlat"              =>      "View Flat",
        "ViewJoinGroups"        =>      "View and Join Groups",
        "ViewProfile"           =>      "View My Profile",
        "ViewThreaded"          =>      "View Threaded",
        "Views"                 =>      "Views",

        "WrittenBy"             =>      "Written By",
        "ErrWrongMailcode"      =>      "You've entered a wrong email-confirmation-code. Try again!",
        "Wrote"                 =>      "Wrote",

        "Year"                  =>      "Year",
        "Yes"                   =>      "Yes",
        "YourEmail"             =>      "Your Email",
        "YourName"              =>      "Your Name",
        "YouWantToFollow"       =>      "You have indicated you want to follow the thread",
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