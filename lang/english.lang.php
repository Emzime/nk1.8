<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//

// Test si le fichier langue est chargé
define('TESTLANGUE', true);

define('LINK','Link');
define('PAGE','Page');
define('FIRSTPAGE','Front page');
define('LASTPAGE','Last page');
define('PREVIOUSPAGE','Previous page');
define('NEXTPAGE','Next page');
define('BANFINISHED','is no longer banned, its period has expired');
define('UNKNOW', 'Not specified');
define('CANCEL', 'Cancel');

// upload librairie
define('NOUPLOAD', 'You must select a file to send');
define('NOUPLOADVALID', 'The extension of this file is not allowed');
define('NOUPLOADAVALABLE', 'Error: Unable to copy file');
define("NOUPLOADED","Avatar unsent");

/*********  AJOUT PAR MAXXI **********/
// Nom des modules
define('CALENDAR','Calendar');
define('COMMENT','Comments');
define('CONTACT','Contact');
define('DEFY','Defy');
define('DOWNLOADS','Downloads');
define('FORUM','Forum');
define('GALLERY','Gallery');
define('GUESTBOOK','Guestbook');
define('IRC','Irc');
define('LINKS','Web Links');
define('MEMBERS','Members');
define('NEWS','News');
define('RECRUIT','Recruit');
define('SEARCH','Search');
define('SECTIONS','Articles');
define('SERVER','Servers');
define('STATS','Statistics');
define('SURVEY','Survey');
define('SUGGEST','Suggest');
define('TEAM','Team');
define('TEXTBOX','Shoutbox');
define('VOTE','Vote');
define('WARS','Matches');

/**** Index.php */
define('SITECLOSED','This site is currently closed and accessible only to administrators. <br /> In case of disconnection, please identify.');
define('TOLOG', 'Login');
define('REGISTERUSER','Registry');
define('NOENTRANCE','Sorry but you do not have permission to access this page');
define('USERENTRANCE','Sorry this area is reserved for registered users.');
define('MODULEOFF','Sorry, this Module is not active !');
define('PSEUDO', 'Pseudo');
define('PASSWORD', 'Password');
define('REMOVEDIRINST', 'Delete the folder / INSTALL');
define('REMOVEINST', 'Delete the file install.php');
define('REMOVEUPDATE', 'Delete the file update.php');
define('GENERATE', 'Generated');
define('POWERED', 'Powered by');
define('SECONDE', 'second');

/**** Partagé dans tout les modules ****/
define('BACK', 'Back');
define('BROKENLINKREPORT','Notification of dead link was sent to administrator');
define('SEND', 'Send');
define('NEEDLOGIN','You must be logged');
define('WHATAREYOUTRYTODO', 'What you try to do?');
define('HOME', 'Index');

/**** Commentaires ****/
define('NOCOMMENTDB', 'No comments');
define('COMMENTBY','Posted by');
define('COMMENTTHE','the');
define('FILECOMMENT','Comments');
define('LASTFILECOMMENT','Last review');
define('SEEALLCOMMENT','More reviews');
define('NEWCOMMENT','Write a review');
define('NONICK','You must enter a nickname');
define('NOTITLE','You have not entered a title !');
define('NOTEXT','You have not entered your message !');
define('RESERVNICK','This username is already use');
define('BANNEDNICK', 'This username is banned');
define('COMMENTADD','Your comment has been saved');
define('COMMENTNOTADD', 'An error has occurred, your comment has not been registered');
define('MESSAGE', 'Your message');
define('ADDCOMMENT', 'Add a comment');

/**** NKCAPTCHA ****/
define('SECURITYCODE', 'Security code');
define('TYPESECCODE', 'Enter the security code');
define('BADCODECONFIRM', 'The code entered is incorrect !');

/**** VOTE ****/
define('VOTEADD', 'Vote successfully added.');
define('RESULTVOTE', 'Result of the vote');
define('ALREADYVOTED', 'You have already voted');
define('NBVOTE', 'Number of Voters');
/**** Vote Sam ****/
define('VOTESLANG', 'votes');
define('NOTESLANG', 'Notes :');
define('ERRORVOTE', 'An error has occurred !');
define('TXTUNNOTABLE', 'Do not vote');
define('ADDNOTE', 'Vote successfully added.');
define('UPDATENOTE', 'Note updated successfully.');

/**** LOGIN ****/
define('LISTING','List');
define('WHOISONLINE','Who is online ?');
define('MEMBER','Member');
define('ADMIN','Administrator');
define('ACCOUNT','Account');
define('ADMINS','Admins');
define('LASTMEMBER','Last');
define('MESSPV','Private messages');
define('NOTREAD','New');
define('READ','Archive');
define('LOGOUT','Sign out');
define('WELCOME','Welcome');
define('REMEMBERME','Remind me');
define('REGISTER','Registration');
define('FORGETPASS','Forgot Password');
define('YES', 'Yes');
define('NO', 'No');
define('ON', 'on');
define('OFF', 'off');
define('ORDERBY','Sort by');
define('NAME','Name');
define('DATE', 'Date');
define('TITLE', 'Title');
define('CAT', 'Category');
define('EDIT', 'Edit');
define('DEL', 'Remove');
define('NONE', 'No record');
define('NONECAT', 'No category');
define('CANTOPENPAGE','You can not open the page directly');
define('CANTOPENBLOCK','The block was not found');
define('BY','by');
define('TFOR', 'for');
define('THE','the');
define('AT','at');
define('AUTHOR','Author');
define('TOVOTE','Vote');
define('RESULT','Result');
define('OTHERPOLL','Other polls');
define('ERROROPENRSS', 'Failed to open the file');
define('MEMBERREG','Recorded');
define('ADDED','Added');
define('VISITNK', 'Visit the Nuked-Klan');
define('ADMINISTRATION', 'Administration');
define('VISITOR','Visitor');

/*******News***********/
define('UNKNOWAUTHOR', 'Unknown Author');


/*******Error Init Request******/
define('ERRORARGUMENT', 'Error for the argument :');
define('NOTINITARGUMENT', 'This argument is not present in the array initialization !');
define('NOTINTEGERARGUMENT', 'This argument is set as an <a target="_blank" href="http://www.php.net/manual/fr/language.types.integer.php">integer</a> !');
define('NOTBOOLEENARGUMENT', 'This argument is initialized as <a target="_blank" href="http://www.php.net/manual/fr/language.types.boolean.php">boolean</a> !');
define('NOTSTRINGARGUMENT', 'This argument is initialized as <a target="_blank" href="http://www.php.net/manual/fr/language.types.string.php">strings</a> !');
define('BLACKLISTARGUMENT', 'The value of this argument has been blacklisted !');
define('NOTUNIQIDARGUMENT', 'The value of this argument should contain 20 alphanumeric characters !');

/* USER */
define('POSTEDTHE','Posted');
define('COUNTRY','Country');
define('GAME','Game');
define('AVATAR','Avatar');
define('AVATARUPLOAD','Upload Avatar');
define("FIRSTNAME","First name");
define("SEX","Sex");
define("MAN","Man");
define("WOMEN","Woman");
define("BIRTHDAY","Birthday");
define("CITY","City");
define("SIGNING","Signature");
define('LOSTPASS','Lost Password');
define('CHOOSE','Choose');
define('TIMES','time');
define('COMMENTED','comment');
define('SUGGESTED','suggest');
define("BYDEFAULT","by default");
define("SELECTTHEME","Choice of theme");


?>