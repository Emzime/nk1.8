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


define('LINK','Lien');
define('PAGE','Page');
define('FIRSTPAGE','Première page');
define('LASTPAGE','Dernière page');
define('PREVIOUSPAGE','Page précédente');
define('NEXTPAGE','Page suivante');
define('BANFINISHED','n\'est plus banni, sa période est arrivée à expiration');
define('UNKNOW', 'Non renseigné');
define('CANCEL', 'Annuler');

// update librairie
define('NOUPLOAD', 'Vous devez sélectionner un fichier a envoyer');
define('NOUPLOADVALID', 'L\'extention de ce fichier n\'est pas autorisé');
define('NOUPLOADAVALABLE', 'Erreur: impossible de copier le fichier');
define("NOUPLOADED","Avatar non envoyé");

/*********  AJOUT PAR MAXXI **********/
// Nom des modules
define('CALENDAR','Calendrier');
define('COMMENT','Commentaires');
define('CONTACT','Contact');
define('DEFY','Défie');
define('DOWNLOADS','Téléchargements');
define('FORUM','Forum');
define('GALLERY','Galerie');
define('GUESTBOOK','Livre d\'or');
define('IRC','Irc');
define('LINKS','Liens Web');
define('MEMBERS','Membres');
define('NEWS','News');
define('RECRUIT','Recrutement');
define('SEARCH','Recherche');
define('SECTIONS','Articles');
define('SERVER','Serveurs');
define('STATS','Statistiques');
define('SURVEY','Sondage');
define('SUGGEST','Suggestion');
define('TEAM','Team');
define('TEXTBOX','Tribune libre');
define('VOTE','Vote');
define('WARS','Matches');

/**** Index.php */
define('SITECLOSED','Ce site est actuellement fermé et accessible uniquement aux administrateurs.<br />En cas de déconnexion, veuillez vous identifiez.');
define('TOLOG', 'S\'identifier');
define('REGISTERUSER','Enregistrement');
define('NOENTRANCE','Désolé mais vous n\'avez pas les droits pour accéder à cette page');
define('USERENTRANCE','Désolé cette zone est réservée aux utilisateurs enregistrés.');
define('MODULEOFF','Désolé, ce module n\'est pas activé !');
define('PSEUDO', 'Pseudo');
define('PASSWORD', 'Mot de passe');
define('REMOVEDIRINST', 'Supprimer le dossier /INSTALL');
define('REMOVEINST', 'Supprimer le fichier install.php');
define('REMOVEUPDATE', 'Supprimer le fichier update.php');
define('GENERATE', 'Généré en');
define('POWERED', 'Propulsé par');
define('SECONDE', 'secondes');

/**** Partagé dans tout les modules ****/
define('BACK', 'Retour');
define('BROKENLINKREPORT','Une notification de lien mort a été envoyé à l\'administrateur');
define('SEND', 'Envoyer');
define('NEEDLOGIN','Vous devez être connecté');
define('WHATAREYOUTRYTODO', 'Que tentez vous de faire ?');
define('HOME', 'Accueil');

/**** Commentaires ****/
define('NOCOMMENTDB', 'Aucun commentaire');
define('COMMENTBY','Posté par');
define('COMMENTTHE','le');
define('FILECOMMENT','Commentaires');
define('LASTFILECOMMENT','Dernier avis');
define('SEEALLCOMMENT','Plus d\'avis');
define('NEWCOMMENT','Donner votre avis');
define('NONICK','Vous devez entrer un pseudo');
define('NOTITLE','Vous n\'avez pas entré de titre !');
define('NOTEXT','Vous n\'avez pas entré votre message !');
define('RESERVNICK','Ce pseudo est déjà réservé');
define('BANNEDNICK', 'Ce pseudo est banni');
define('COMMENTADD','Votre commentaire a bien été enregistré');
define('COMMENTNOTADD', 'Une erreur est survenue, votre commentaire n\'a pas été enregistré');
define('MESSAGE', 'Votre message');
define('ADDCOMMENT', 'Ajouter un commentaire');

/**** NKCAPTCHA ****/
define('SECURITYCODE', 'Code de sécurité');
define('TYPESECCODE', 'Entrer le code de sécurité');
define('BADCODECONFIRM', 'Le code saisie est incorrect !');

/**** VOTE ****/
define('VOTEADD', 'Vote ajouté avec succès.');
define('RESULTVOTE', 'Résultat du vote');
define('ALREADYVOTED', 'Vous avez déjà voté');
define('NBVOTE', 'Nombre de votants');
/**** Vote Sam ****/
define('VOTESLANG', 'votes');
define('NOTESLANG', 'Notes :');
define('ERRORVOTE', 'Une erreur est survenue !');
define('TXTUNNOTABLE', 'Impossible de voter');
define('ADDNOTE', 'Vote ajouté avec succès.');
define('UPDATENOTE', 'Note mis à jour avec succès.');

/**** LOGIN ****/
define('LISTING','Liste');
define('WHOISONLINE','Qui est en ligne ?');
define('MEMBER','Membre');
define('ADMIN','Administrateur');
define('ACCOUNT','Compte');
define('ADMINS','Admins');
define('LASTMEMBER','Dernier');
define('MESSPV','Messages privés');
define('NOTREAD','Nouveau(x)');
define('READ','Archivé(s)');
define('LOGOUT','Se déconnecter');
define('WELCOME','Bienvenue');
define('REMEMBERME','Se Rappeler de moi');
define('REGISTER','Inscription');
define('FORGETPASS','Mot de passe oublié');
define('PASSFORGET','Passe oublié');
define('YES', 'Oui');
define('NO', 'Non');
define('ON', 'on');
define('OFF', 'off');
define('ORDERBY','Classer par');
define('NAME','Nom');
define('DATE', 'Date');
define('TITLE', 'Titre');
define('CAT', 'Catégorie');
define('EDIT', 'Editer');
define('DEL', 'Supprimer');
define('NONE', 'Aucun enregistrement');
define('NONECAT', 'Aucune catégorie');
define('CANTOPENPAGE','Vous ne pouvez pas ouvrir cette page directement');
define('CANTOPENBLOCK','Le block est introuvable');
define('BY','Par');
define('TFOR', 'Pour');
define('THE','le');
define('AT','à');
define('AUTHOR','Auteur');
define('TOVOTE','Voter');
define('RESULT','Résultat');
define('OTHERPOLL','Autres sondages');
define('BTHEMESELECT', 'Choix du thème');
define('ERROROPENRSS', 'Echec lors de l\'ouverture du fichier');
define('MEMBERREG','enregistré le');
define('ADDED','ajouté le');
define('VISITNK', 'Visiter le site de Nuked-Klan');
define('ADMINISTRATION', 'Administration');
define('VISITOR','Visiteur');

/*******News***********/
define('UNKNOWAUTHOR', 'Auteur inconnu');


/*******Error Init Request******/
define('ERRORARGUMENT', 'Erreur pour l\'argument :');
define('NOTINITARGUMENT', 'Cet argument n\'est pas présent dans le tableau d\'initialisation !');
define('NOTINTEGERARGUMENT', 'Cet argument est initialisé en tant qu\'<a target="_blank" href="http://www.php.net/manual/fr/language.types.integer.php">entier</a> !');
define('NOTBOOLEENARGUMENT', 'Cet argument est initialisé en tant que <a target="_blank" href="http://www.php.net/manual/fr/language.types.boolean.php">booléen</a> !');
define('NOTSTRINGARGUMENT', 'Cet argument est initialisé en tant que <a target="_blank" href="http://www.php.net/manual/fr/language.types.string.php">chaînes de caractères</a> !');
define('BLACKLISTARGUMENT', 'La valeur de cet argument a été mis sur liste noire !');
define('NOTUNIQIDARGUMENT', 'La valeur de cet argument doit contenir 20 caractères alphanumérique !');

/* USER */
define('POSTEDTHE','Posté le');
define('COUNTRY','Pays');
define('GAME','Jeu');
define('AVATAR','Avatar');
define('AVATARUPLOAD','Upload Avatar');
define("FIRSTNAME","Prénom");
define("SEX","Sexe");
define("MAN","Homme");
define("WOMEN","Femme");
define("BIRTHDAY","Date de naissance");
define("CITY","Ville");
define("SIGNING","Signature");
define('LOSTPASS','Perdu votre Password ?');
define('CHOOSE','Choisir');
define('TIMES','fois');
define('COMMENTED','commentaire');
define('SUGGESTED','suggestion');


?>