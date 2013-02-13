<?php
defined('INDEX_CHECK') or die ('<div class="align-center">You cannot open this page directly</div>');

// Test si le fichier langue est chargé
define('TESTLANGUEFILECONTACT', true);

define('_CONTACT','Formulaire de contact');
define('_CONTACTFORM','Veuillez remplir le formulaire ci-dessous puis cliquer sur Envoyer');
define('_YNICK','Votre Nom');
define('_YMAIL','Votre Email');
define('_YSUBJECT','Objet');
define('_YCOMMENT','Votre message');
define('_SEND','Envoyer');
define('_NOCONTENT','Vous avez oubli? de remplir des champs obligatoires');
define('_NONICK','Vous n\'avez pas entr? votre nom !');
define('_NOSUBJECT','Vous n\'avez pas entr? de sujet !');
define('_BADMAIL','Adresse email non valide !');
define('_SENDCMAIL','Votre email a bien ?t? envoy?, nous vous r?pondrons dans les plus brefs d?lais.');
define('_FLOODCMAIL','Vous avez d?ja post? un mail il y\'a moins de ' . $nuked['contact_flood'] . ' minutes,<br />veuillez patienter avant de renvoyer un autre email...');

define('_NOENTRANCE','D?sol? mais vous n\'avez pas les droits pour acc?der ? cette page');
define('_ZONEADMIN','Cette zone est r?serv?e a l\'Admin, D?sol?...');
define('_NOEXIST','D?sol? cette page n\'existe pas ou l\'adresse que vous avez tap? est incorrecte');
define('_ADMINCONTACT','Administration Contact');
define('_HELP','Aides');
define('_DELETEMESSAGEFROM','Vous ?tes sur le point de supprimer le message de');
define('_LISTMAIL','Liste des messages');
define('_PREFS','Pr?f?rences');
define('_TITLE','Titre');
define('_NAME','Nom');
define('_DATE','Date');
define('_READMESS','Lire');
define('_DEL','Supprimer');
define('_BACK','Retour');
define('_FROM','De');
define('_THE','le');
define('_NOMESSINDB','Aucun message dans la base de donn?es');
define('_READTHISMESS','Lire ce message');
define('_DELTHISMESS','Supprimer ce message');
define('_MESSDELETE','Message supprim? avec succ?s');
define('_PREFUPDATED','Pr?f?rences modifi?es avec succ?s.');
define('_EMAILCONTACT','Email de reception');
define('_FLOODCONTACT','Dur?e en minutes entre 2 messages (flood)');
define('_NOTCON','Vous avez re?u un mail contact');
define('_ACTIONDELCONTACT','a supprim? un mail contact re?u');
define('_ACTIONPREFCONT','a modifi? les pr?f?rences du module contact');
?>