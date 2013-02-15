<?php
    switch($table){
        case'action':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_action`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_action` (
                          `id` int(11) NOT NULL auto_increment,
                          `created` varchar(30) NOT NULL default '0',
                          `pseudo`  text NOT NULL,
                          `action`  text NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'banned':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_banned`";
                        $req = mysql_query($sql) or die (mysql_error());
                        $sql = "CREATE TABLE `" . $db_prefix . "_banned` (
                            `id` int(11) NOT NULL auto_increment,
                            `ip` varchar(50) NOT NULL default '',
                            `pseudo` varchar(50) NOT NULL default '',
                            `email` varchar(80) NOT NULL default '',
                            `created` VARCHAR(20)  NULL,
                            `period` VARCHAR(20)  NULL,
                            `content` text NOT NULL,
                            PRIMARY KEY  (`id`)
                          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                          $req = mysql_query($sql) or die (mysql_error());
                          echo 'OK';
        break;
        case'block':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_block`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_block` (
                          `id` int(10) NOT NULL auto_increment,
                          `side` int(1) NOT NULL default '0',
                          `placing` int(2) NOT NULL default '0',
                          `module` varchar(100) NOT NULL default '',
                          `title` text NOT NULL,
                          `content` text NOT NULL,
                          `type` varchar(30) NOT NULL default '0',
                          `level` int(1) NOT NULL default '0',
                          `page` text NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_block` VALUES
                            (1, 2, 1, '', '" . mysql_real_escape_string(BLOKLOGIN) . "', 'on|on|on|on|on', 'login', 0, 'Tous'),
                            (2, 1, 1, '', '" . mysql_real_escape_string(NAV) . "', '[News]|" . mysql_real_escape_string(NAVNEWS) . "||0|NEWLINE[Archives]|" . mysql_real_escape_string(NAVARCHIV) . "||0|NEWLINE[Forum]|" . mysql_real_escape_string(NAVFORUM) . "||0|NEWLINE[Downloads]|" . mysql_real_escape_string(NAVDOWNLOADS) . "||0|NEWLINE[Members]|" . mysql_real_escape_string(NAVMEMBERS) . "||0|NEWLINE[Team]|" . mysql_real_escape_string(NAVTEAM) . "||0|NEWLINE[Defy]|" . mysql_real_escape_string(NAVDEFY) . "||0|NEWLINE[Recruit]|" . mysql_real_escape_string(NAVRECRUIT) . "||0|NEWLINE[Sections]|" . mysql_real_escape_string(NAVART) . "||0|NEWLINE[Server]|" . mysql_real_escape_string(NAVSERVER) . "||0|NEWLINE[Links]|" . mysql_real_escape_string(NAVLINKS) . "||0|NEWLINE[Calendar]|" . mysql_real_escape_string(NAVCALENDAR) . "||0|NEWLINE[Gallery]|" . mysql_real_escape_string(NAVGALLERY) . "||0|NEWLINE[Wars]|" . mysql_real_escape_string(NAVMATCHS) . "||0|NEWLINE[Irc]|" . mysql_real_escape_string(NAVIRC) . "||0|NEWLINE[Guestbook]|" . mysql_real_escape_string(NAVGUESTBOOK) . "||0|NEWLINE[Search]|" . mysql_real_escape_string(NAVSEARCH) . "||0|NEWLINE|<b>" . mysql_real_escape_string(MEMBER) . "</b>||1|NEWLINE[User]|" . mysql_real_escape_string(NAVACCOUNT) . "||1|NEWLINE|<b>" . mysql_real_escape_string(ADMIN) . "</b>||2|NEWLINE[Admin]|" . mysql_real_escape_string(NAVADMIN) . "||2|', 'menu', 0, 'Tous'),
                            (3, 1, 2, 'Search', '" . mysql_real_escape_string(BLOKSEARCH) . "', '', 'module', 0, 'Tous'),
                            (4, 2, 2, '', '" . mysql_real_escape_string(POLL) . "', '', 'survey', 0, 'Tous'),
                            (5, 2, 3, 'Wars', '" . mysql_real_escape_string(NAVMATCHS) . "', '', 'module', 0, 'Tous'),
                            (6, 1, 3, 'Stats', '" . mysql_real_escape_string(BLOKSTATS) . "', '', 'module', 0, 'Tous'),
                            (7, 0, 0, 'Irc', '" . mysql_real_escape_string(IRCAWARD) . "', '', 'module', 0, 'Tous'),
                            (8, 0, 0, 'Server', '" . mysql_real_escape_string(SERVERMONITOR) . "', '', 'module', 0, 'Tous'),
                            (9, 0, 0, '', '" . mysql_real_escape_string(SUGGEST) . "', '', 'suggest', 1, 'Tous'),
                            (10, 0, 0, 'Textbox', '" . mysql_real_escape_string(BLOKSHOUT) . "', '', 'module', 0, 'Tous'),
                            (11, 1, 4, '', '" . mysql_real_escape_string(BLOKPARTNERS) . "', '<div style=\"text-align: center;padding: 10px;\"><a href=\"http://www.nuked-klan.org\" onclick=\"window.open(this.href); return false;\"><img style=\"border: 0;\" src=\"images/ban.png\" alt=\"\" title=\"Nuked-klaN CMS\" /></a></div><div style=\"text-align: center;padding: 10px;\"><a href=\"http://www.nitroserv.fr\" onclick=\"window.open(this.href); return false;\"><img style=\"border: 0;\" src=\"images/nitroserv.png\" alt=\"\" title=\"Location de serveurs de jeux\" /></a></div>', 'html', 0, 'Tous');";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'calendar':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_calendar`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_calendar` (
                          `id` int(11) NOT NULL auto_increment,
                          `title` text NOT NULL,
                          `content` text NOT NULL,
                          `created_jour` int(2) default NULL,
                          `created_mois` int(2) default NULL,
                          `created_an` int(4) default NULL,
                          `hour` varchar(5) NOT NULL,
                          `autor` text NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'comment':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_comment`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_comment` (
                          `id` int(10) NOT NULL auto_increment,
                          `module` varchar(30) NOT NULL default '0',
                          `itemId` int(100) default NULL,
                          `autor` text,
                          `autorId` varchar(20) NOT NULL,
                          `title` text NOT NULL,
                          `content` text,
                          `created` varchar(12) default NULL,
                          `autorIp` varchar(20) default NULL,
                          PRIMARY KEY  (`id`),
                          KEY `im_id` (`itemId`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'comment_mod':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_comment_mod`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_comment_mod` (
                          `id` int(11) NOT NULL auto_increment,
                          `module` text NOT NULL,
                          `active` int(1) NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_comment_mod` VALUES
                            (1, 'News', 1),
                            (2, 'Downloads', 1),
                            (3, 'Links', 1),
                            (4, 'Survey', 1),
                            (5, 'Wars', 1),
                            (6, 'Gallery', 1),
                            (7, 'Sections', 1);";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'config':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_config`";
                        $req = mysql_query($sql) or die (mysql_error());
                        $sql = "CREATE TABLE `" . $db_prefix . "_config` (
                          `name` varchar(255) NOT NULL default '',
                          `value` text NOT NULL,
                          PRIMARY KEY  (`name`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $date = time();
                        $siteurl = "http://" . $_SERVER['SERVER_NAME'] . str_replace("INSTALL/index.php", "", $_SERVER['SCRIPT_NAME']);
                        if (substr($siteurl, -1) == "/") $siteurl = substr($siteurl, 0, -1);                        
                        if ($this->data['lang_install'] == 'french'){
                            $dateFormat = '%d/%m/%Y';
                            $dateZone = '+0100';
                        }
                        else{
                            $dateFormat = '%m/%d/%Y';
                            $dateZone = '+0000';
                        }
                        $stats_share = $this->data['stats'] == 'no' ? 0 : 1;
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_config` VALUES
                            ('time_generate', 'on'),
                            ('dateformat', '" . $dateFormat. "'),
                            ('datezone', '" . $dateZone . "'),
                            ('version', '1.7.9'),
                            ('date_install', '".$date."'),
                            ('langue', '".$this->data['lang_install']."'),
                            ('stats_share', '".$stats_share."'),
                            ('stats_timestamp', '0'),
                            ('name', 'Nuked-klaN 1.7.9'),
                            ('slogan', 'PHP 4 Gamers'),
                            ('tag_pre', ''),
                            ('tag_suf', ''),
                            ('url', '".$siteurl."'),
                            ('mail', 'mail@hotmail.com'),
                            ('footmessage', ''),
                            ('nk_status', 'open'),
                            ('index_site', 'News'),
                            ('theme', 'Impact_Nk'),
                            ('keyword', ''),
                            ('description', ''),
                            ('inscription', 'on'),
                            ('inscription_mail', ''),
                            ('inscription_avert', ''),
                            ('inscription_charte', ''),
                            ('validation', 'auto'),
                            ('user_delete', 'on'),
                            ('video_editeur', 'on'),
                            ('scayt_editeur', 'on'),
                            ('suggest_avert', ''),
                            ('irc_chan', 'nuked-klan'),
                            ('irc_serv', 'quakenet.org'),
                            ('server_ip', ''),
                            ('server_port', ''),
                            ('server_pass', ''),
                            ('server_game', ''),
                            ('forum_title', ''),
                            ('forum_desc', ''),
                            ('forum_rank_team', 'off'),
                            ('forum_field_max', '10'),
                            ('forum_file', 'on'),
                            ('forum_file_level', '1'),
                            ('forum_file_maxsize', '1000'),
                            ('thread_forum_page', '20'),
                            ('mess_forum_page', '10'),
                            ('hot_topic', '20'),
                            ('post_flood', '10'),
                            ('gallery_title', ''),
                            ('max_img_line', '2'),
                            ('max_img', '6'),
                            ('max_news', '5'),
                            ('max_liens', '10'),
                            ('max_sections', '10'),
                            ('max_wars', '30'),
                            ('max_archives', '30'),
                            ('max_members', '30'),
                            ('max_shout', '20'),
                            ('mess_guest_page', '10'),
                            ('sond_delay', '24'),
                            ('level_analys', '-1'),
                            ('visit_delay', '10'),
                            ('recrute', '1'),
                            ('recrute_charte', ''),
                            ('recrute_mail', ''),
                            ('recrute_inbox', ''),
                            ('defie_charte', ''),
                            ('defie_mail', ''),
                            ('defie_inbox', ''),
                            ('birthday', 'all'),
                            ('avatar_upload', 'on'),
                            ('avatar_url', 'on'),
                            ('cookiename', 'nuked'),
                            ('sess_inactivemins', '5'),
                            ('sess_days_limit', '365'),
                            ('nbc_timeout', '300'),
                            ('screen', 'on'),
                            ('contact_mail', ''),
                            ('nkToTopTheme', 'nkToTopCube'),
                            ('contact_flood', '60');";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'contact':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_contact`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_contact` (
                          `id` int(11) NOT NULL auto_increment,
                          `title` varchar(200) NOT NULL,
                          `message` text NOT NULL,
                          `email` varchar(80) NOT NULL,
                          `name` varchar(200) NOT NULL,
                          `ip` varchar(50) NOT NULL,
                          `created` varchar(30) NOT NULL,
                          PRIMARY KEY  (`id`),
                          KEY `title` (`title`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'defie':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_defy`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_defy` (
                          `id` int(11) NOT NULL auto_increment,
                          `send` varchar(12) NOT NULL,
                          `pseudo` text NOT NULL,
                          `clan` text NOT NULL,
                          `mail` varchar(80) NOT NULL,
                          `icq` varchar(50) NOT NULL,
                          `irc` varchar(50) NOT NULL,
                          `url` varchar(200) NOT NULL,
                          `country` text NOT NULL,
                          `created` varchar(20) NOT NULL,
                          `hour` varchar(10) NOT NULL,
                          `server` text NOT NULL,
                          `game` int(11) NOT NULL default '0',
                          `type` text NOT NULL,
                          `map` text NOT NULL,
                          `content` text NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'discussion':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_discussion`";
                        $req= mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_discussion` (
                          `id` int(11) NOT NULL auto_increment,
                          `date` varchar(30) NOT NULL default '0',
                          `pseudo`  text NOT NULL,
                          `texte`  text NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'downloads':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_downloads`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_downloads` (
                          `id` int(11) NOT NULL auto_increment,
                          `size` varchar(6) NOT NULL default '0',
                          `title` text NOT NULL,
                          `content` text NOT NULL,
                          `category` int(11) NOT NULL default '0',
                          `count` int(10) NOT NULL default '0',
                          `url` varchar(200) NOT NULL default '',
                          `url2` varchar(200) NOT NULL default '',
                          `url3` varchar(200) NOT NULL default '',
                          `broke` int(11) NOT NULL default '0',
                          `level` int(1) NOT NULL default '0',
                          `created` varchar(12) NOT NULL default '',
                          `edited` varchar(12) NOT NULL default '',
                          `urlScreen` varchar(200) NOT NULL default '',
                          `autor` text NOT NULL,
                          `urlAutor` varchar(200) NOT NULL default '',
                          `compatibility` text NOT NULL,
                          PRIMARY KEY  (`id`),
                          KEY `type` (`category`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'downloads_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_downloads_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_downloads_cat` (
                          `id` int(11) NOT NULL auto_increment,
                          `parentid` int(11) NOT NULL default '0',
                          `title` varchar(50) NOT NULL default '',
                          `shortContent` varchar(255) NOT NULL,
                          `content` text NOT NULL,
                          `level` int(1) NOT NULL default '0',
                          `placing` int(2) unsigned NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `parentid` (`parentid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'downloads_config':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_downloads_config`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_downloads_config` (
                            `name` varchar(255) NOT NULL,
                            `value` text NOT NULL,
                          PRIMARY KEY  (`name`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());

                         $sql = "INSERT INTO `" . $db_prefix . "_downloads_config` VALUES
                            ('breadCrumbTheme', 'crumbs'),
                            ('hideDescription', 'off'),
                            ('fileHotTime', '9'),
                            ('fileMaxDownload', '5'),
                            ('fileNbComment', '2'),
                            ('fileNbCommentCut', '130'),
                            ('fileNbSubcat', '2'),
                            ('fileNewTime', '604800'),
                            ('nbFileHot', '10'),
                            ('nbFileNew', '10'),
                            ('tooltipTheme', 'tooltipster-nk'),
                            ('tooltipPosition', 'left'),
                            ('tooltipAnimation', 'grow'),
                            ('tooltipArrowColor', ''),
                            ('tooltipMaxWidth', 'null'),
                            ('tooltipCutText', '150');";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums` (
                          `id` int(5) NOT NULL auto_increment,
                          `cat` int(11) NOT NULL default '0',
                          `nom` text NOT NULL,
                          `comment` text NOT NULL,
                          `moderateurs` text NOT NULL,
                          `niveau` int(1) NOT NULL default '0',
                          `level` int(1) NOT NULL default '0',
                          `ordre` int(5) NOT NULL default '0',
                          `level_poll` int(1) NOT NULL default '0',
                          `level_vote` int(1) NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `cat` (`cat`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_forums` VALUES (1, 1, 'Forum', 'Test Forum', '', 0, 0, 0, 1 ,1);";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                    
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_cat` (
                          `id` int(11) NOT NULL auto_increment,
                          `nom` varchar(100) default NULL,
                          `ordre` int(5) NOT NULL default '0',
                          `niveau` int(1) NOT NULL default '0',
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                    
                        $sql="INSERT INTO `" . $db_prefix . "_forums_cat` VALUES (1, 'Categorie 1', 0, 0);";
                        $req=mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_messages':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_messages`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_messages` (
                          `id` int(5) NOT NULL auto_increment,
                          `titre` text NOT NULL,
                          `txt` text NOT NULL,
                          `date` varchar(12) NOT NULL default '',
                          `edition` text NOT NULL,
                          `auteur` text NOT NULL,
                          `auteur_id` varchar(20) NOT NULL default '',
                          `auteur_ip` varchar(20) NOT NULL default '',
                          `bbcodeoff` int(1) NOT NULL default '0',
                          `smileyoff` int(1) NOT NULL default '0',
                          `cssoff` int(1) NOT NULL default '0',
                          `usersig` int(1) NOT NULL default '0',
                          `emailnotify` int(1) NOT NULL default '0',
                          `thread_id` int(5) NOT NULL default '0',
                          `forum_id` mediumint(10) NOT NULL default '0',
                          `file` varchar(200) NOT NULL default '',
                          PRIMARY KEY  (`id`),
                          KEY `auteur_id` (`auteur_id`),
                          KEY `thread_id` (`thread_id`),
                          KEY `forum_id` (`forum_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_threads':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_threads`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_threads` (
                          `id` int(5) NOT NULL auto_increment,
                          `titre` text NOT NULL,
                          `date` varchar(10) default NULL,
                          `closed` int(1) NOT NULL default '0',
                          `auteur` text NOT NULL,
                          `auteur_id` varchar(20) NOT NULL default '',
                          `forum_id` int(5) NOT NULL default '0',
                          `last_post` varchar(20) NOT NULL default '',
                          `view` int(10) NOT NULL default '0',
                          `annonce` int(1) NOT NULL default '0',
                          `sondage` int(1) NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `auteur_id` (`auteur_id`),
                          KEY `forum_id` (`forum_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_rank':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_rank`";
                        $req = mysql_query($sql) or die(mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_rank` (
                          `id` int(10) NOT NULL auto_increment,
                          `nom` varchar(100) NOT NULL default '',
                          `type` int(1) NOT NULL default '0',
                          `post` int(4) NOT NULL default '0',
                          `image` varchar(200) NOT NULL default '',
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_forums_rank` VALUES
                            (1, '".mysql_real_escape_string(NEWBIE)."', 0, 0, 'modules/Forum/images/rank/star1.gif'),
                            (2, '".mysql_real_escape_string(JUNIORMEMBER)."', 0, 10, 'modules/Forum/images/rank/star2.gif'),
                            (3, '".mysql_real_escape_string(MEMBER)."', 0, 100, 'modules/Forum/images/rank/star3.gif'),
                            (4, '".mysql_real_escape_string(SENIORMEMBER)."', 0, 500, 'modules/Forum/images/rank/star4.gif'),
                            (5, '".mysql_real_escape_string(POSTINGFREAK)."', 0, 1000, 'modules/Forum/images/rank/star5.gif'),
                            (6, '".mysql_real_escape_string(MODERATOR)."', 1, 0, 'modules/Forum/images/rank/mod.gif'),
                            (7, '".mysql_real_escape_string(ADMINISTRATOR)."', 2, 0, 'modules/Forum/images/rank/mod.gif');";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_reads':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_read`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_read` (
                          `user_id` varchar(20) NOT NULL default '',
                          `thread_id` text NOT NULL,
                          `forum_id` text NOT NULL,
                          PRIMARY KEY  (`user_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_poll':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_poll`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_poll` (
                          `id` int(11) NOT NULL auto_increment,
                          `thread_id` int(11) NOT NULL default '0',
                          `titre` varchar(255) NOT NULL default '',
                          PRIMARY KEY  (`id`),
                          KEY `thread_id` (`thread_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_options':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_options`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_options` (
                          `id` int(11) NOT NULL default '0',
                          `poll_id` int(11) NOT NULL default '0',
                          `option_text` varchar(255) NOT NULL default '',
                          `option_vote` int(11) NOT NULL default '0',
                          KEY `poll_id` (`poll_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_vote':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_vote`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_vote` (
                          `poll_id` int(11) NOT NULL default '0',
                          `auteur_id` varchar(20) NOT NULL default '',
                          `auteur_ip` varchar(20) NOT NULL default '',
                          KEY `poll_id` (`poll_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'gallery':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_gallery`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_gallery` (
                          `sid` int(11) NOT NULL auto_increment,
                          `titre` text NOT NULL,
                          `description` text NOT NULL,
                          `url` varchar(200) NOT NULL default '',
                          `url2` varchar(200) NOT NULL default '',
                          `url_file` varchar(200) NOT NULL default '',
                          `cat` int(11) NOT NULL default '0',
                          `date` varchar(12) NOT NULL default '',
                          `count` int(10) NOT NULL default '0',
                          `autor` text NOT NULL,
                          PRIMARY KEY  (`sid`),
                          KEY `cat` (`cat`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'gallery_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_gallery_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_gallery_cat` (
                          `cid` int(11) NOT NULL auto_increment,
                          `parentid` int(11) NOT NULL default '0',
                          `titre` varchar(50) NOT NULL default '',
                          `description` text NOT NULL,
                          `position` int(2) unsigned NOT NULL default '0',
                          PRIMARY KEY  (`cid`),
                          KEY `parentid` (`parentid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'games':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_games`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_games` (
                          `id` int(11) NOT NULL auto_increment,
                          `name` varchar(50) NOT NULL default '',
                          `titre` varchar(50) NOT NULL default '',
                          `icon` varchar(150) NOT NULL default '',
                          `pref_1` varchar(50) NOT NULL default '',
                          `pref_2` varchar(50) NOT NULL default '',
                          `pref_3` varchar(50) NOT NULL default '',
                          `pref_4` varchar(50) NOT NULL default '',
                          `pref_5` varchar(50) NOT NULL default '',
                          `map` TEXT NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_games` VALUES
                            (1, 'Counter Strike Source', '" . mysql_real_escape_string(PREFCS) . "', 'images/games/cs.gif', '" . mysql_real_escape_string(OTHERNICK) . "', '" . mysql_real_escape_string(FAVMAP) . "', '" . mysql_real_escape_string(FAVWEAPON) . "', '" . mysql_real_escape_string(SKINT) . "', '" . mysql_real_escape_string(SKINCT) . "', 'de_dust2|de_inferno');";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'games_prefs':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_games_prefs`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_games_prefs` (
                          `id` int(11) NOT NULL auto_increment,
                          `game` int(11) NOT NULL default '0',
                          `user_id` varchar(20) NOT NULL default '',
                          `pref_1` text NOT NULL,
                          `pref_2` text NOT NULL,
                          `pref_3` text NOT NULL,
                          `pref_4` text NOT NULL,
                          `pref_5` text NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'guestbook':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_guestbook`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_guestbook` (
                          `id` int(9) NOT NULL auto_increment,
                          `name` varchar(50) NOT NULL default '',
                          `email` varchar(60) NOT NULL default '',
                          `url` varchar(70) NOT NULL default '',
                          `date` int(11) NOT NULL default '0',
                          `host` varchar(60) NOT NULL default '',
                          `comment` text NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'irc_awards':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_irc_awards`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_irc_awards` (
                          `id` int(20) NOT NULL auto_increment,
                          `text` text NOT NULL,
                          `date` varchar(30) NOT NULL default '',
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'liens':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_liens`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_liens` (
                          `id` int(10) NOT NULL auto_increment,
                          `date` varchar(12) NOT NULL default '',
                          `titre` text NOT NULL,
                          `description` text NOT NULL,
                          `url` varchar(200) NOT NULL default '',
                          `cat` int(11) NOT NULL default '0',
                          `webmaster` text NOT NULL,
                          `country` varchar(50) NOT NULL default '',
                          `count` int(11) NOT NULL default '0',
                          `broke` int(11) NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `cat` (`cat`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'liens_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_liens_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_liens_cat` (
                          `cid` int(11) NOT NULL auto_increment,
                          `parentid` int(11) NOT NULL default '0',
                          `titre` varchar(50) NOT NULL default '',
                          `description` text NOT NULL,
                          `position` int(2) unsigned NOT NULL default '0',
                          PRIMARY KEY  (`cid`),
                          KEY `parentid` (`parentid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'match':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_match`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_match` (
                          `warid` int(10) NOT NULL auto_increment,
                          `etat` int(1) NOT NULL default '0',
                          `team` int(11) NOT NULL default '0',
                          `game` int(11) NOT NULL default '0',
                          `adversaire` text,
                          `url_adv` varchar(60) default NULL,
                          `pays_adv` varchar(50) NOT NULL default '',
                          `type` varchar(100) default NULL,
                          `style` varchar(100) NOT NULL default '',
                          `date_jour` int(2) default NULL,
                          `date_mois` int(2) default NULL,
                          `date_an` int(4) default NULL,
                          `heure` varchar(10) NOT NULL default '',
                          `map` text,
                          `tscore_team` float default NULL,
                          `tscore_adv` float default NULL,
                          `score_team` text NOT NULL,
                          `score_adv` text NOT NULL,
                          `report` text,
                          `auteur` varchar(50) default NULL,
                          `url_league` varchar(100) default NULL,
                          `dispo` text,
                          `pas_dispo` text,
                          PRIMARY KEY  (`warid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req  =mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'match_files':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_match_files`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_match_files` (
                          `id` int(10) NOT NULL auto_increment,
                          `module` varchar(30) NOT NULL default '',
                          `im_id` int(10) NOT NULL default '0',
                          `type` varchar(30) NOT NULL default '',
                          `url` varchar(200) NOT NULL default '',
                          PRIMARY KEY  (`id`),
                          KEY `im_id` (`im_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'modules':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_modules`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_modules` (
                          `id` int(2) NOT NULL auto_increment,
                          `name` varchar(50) NOT NULL,
                          `newName` varchar(50) NOT NULL,
                          `level` int(1) NOT NULL default '0',
                          `admin` int(1) NOT NULL default '2',
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_modules` VALUES 
                            (1, 'News', '', 0, 2),
                            (2, 'Forum', '', 0, 2),
                            (3, 'Wars', '', 0, 2),
                            (4, 'Irc', '', 0, 2),
                            (5, 'Survey', '', 0, 3),
                            (6, 'Links', '', 0, 3),
                            (7, 'Sections', '', 0, 3),
                            (8, 'Server', '', 0, 3),
                            (9, 'Downloads', '', 0, 3),
                            (10, 'Gallery', '', 0, 3),
                            (11, 'Guestbook', '', 0, 3),
                            (12, 'Suggest', '', 0, 3),
                            (13, 'Textbox', '', 0, 9),
                            (14, 'Calendar', '', 0, 2),
                            (15, 'Members', '', 0, 9),
                            (16, 'Team', '', 0, 9),
                            (17, 'Defy', '', 0, 3),
                            (18, 'Recruit', '', 0, 3),
                            (19, 'Comment', '', 0, 9),
                            (20, 'Vote', '', 0, 9),
                            (21, 'Stats', '', 0, 2),
                            (22, 'Contact', '', 0, 3);";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'nbconnecte':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_nbconnecte`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_nbconnecte` (
                          `IP` varchar(30) NOT NULL default '',
                          `type` int(10) NOT NULL default '0',
                          `date` int(14) NOT NULL default '0',
                          `user_id` varchar(20) NOT NULL default '',
                          `username` varchar(40) NOT NULL default '',
                          PRIMARY KEY  ( `IP` , `user_id` )
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'news':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_news`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_news` (
                          `id` int(11) NOT NULL auto_increment,
                          `cat` varchar(30) NOT NULL default '',
                          `titre` text,
                          `auteur` text,
                          `auteur_id` varchar(20) NOT NULL default '',
                          `texte` text,
                          `suite` text,
                          `date` varchar(30) NOT NULL default '',
                          `bbcodeoff` int(1) NOT NULL default '0',
                          `smileyoff` int(1) NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `cat` (`cat`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die(mysql_error());
                        echo 'OK';
        break;
        case'news_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_news_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_news_cat` (
                          `nid` int(11) NOT NULL auto_increment,
                          `titre` text,
                          `description` text,
                          `image` text,
                          PRIMARY KEY  (`nid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_news_cat` VALUES
                            ('1', 'Counter Strike Source', '" . mysql_real_escape_string(BESTMOD) . "', 'modules/News/images/cs.gif');";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'notification':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_notification`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_notification` (
                          `id` int(11) NOT NULL auto_increment,
                          `created` varchar(30) NOT NULL default '0',
                          `type` text NOT NULL,
                          `content` text NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());

                        if(ini_get('suhosin.session.encrypt') == 1){
                          $sql = "INSERT INTO `" . $db_prefix . "_notification` VALUES
                              ('', '', '4', '".mysql_real_escape_string(SUHOSIN)."');";
                          $req = mysql_query($sql) or die (mysql_error());
                        }
                        echo 'OK';
        break;
        case'recrute':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_recrute`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_recrute` (
                          `id` int(11) NOT NULL auto_increment,
                          `date` varchar(12) NOT NULL default '',
                          `pseudo` text NOT NULL,
                          `prenom` text NOT NULL,
                          `age` int(3) NOT NULL default '0',
                          `mail` varchar(80) NOT NULL default '',
                          `icq` varchar(50) NOT NULL default '',
                          `country` text NOT NULL,
                          `game` int(11) NOT NULL default '0',
                          `connection` text NOT NULL,
                          `experience` text NOT NULL,
                          `dispo` text NOT NULL,
                          `comment` text NOT NULL,
                          PRIMARY KEY  (`id`),
                          KEY `game` (`game`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'sections':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_sections`";
                        $req = mysql_query($sql) or die (mysql_error());  
                        $sql = "CREATE TABLE `" . $db_prefix . "_sections` (
                        `artid` int(11) NOT NULL auto_increment,
                        `secid` int(11) NOT NULL default '0',
                        `title` text NOT NULL,
                        `content` text NOT NULL,
                        `autor` text NOT NULL,
                        `autor_id` varchar(20) NOT NULL default '',
                        `counter` int(11) NOT NULL default '0',
                        `bbcodeoff` int(1) NOT NULL default '0',
                        `smileyoff` int(1) NOT NULL default '0',
                        `date` varchar(12) NOT NULL default '',
                        PRIMARY KEY  (`artid`),
                        KEY `secid` (`secid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'sections_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_sections_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_sections_cat` (
                          `secid` int(11) NOT NULL auto_increment,
                          `parentid` int(11) NOT NULL default '0',
                          `secname` varchar(40) NOT NULL default '',
                          `description` text NOT NULL,
                          `position` int(2) unsigned NOT NULL default '0',
                          PRIMARY KEY  (`secid`),
                          KEY `parentid` (`parentid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'serveur':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_serveur`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_serveur` (
                          `sid` int(30) NOT NULL auto_increment,
                          `game` varchar(30) NOT NULL default '',
                          `ip` varchar(30) NOT NULL default '',
                          `port` varchar(10) NOT NULL default '',
                          `pass` varchar(10) NOT NULL default '',
                          `cat` varchar(30) NOT NULL default '',
                          PRIMARY KEY  (`sid`),
                          KEY `game` (`game`),
                          KEY `cat` (`cat`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'serveur_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_serveur_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_serveur_cat` (
                          `cid` int(30) NOT NULL auto_increment,
                          `titre` varchar(30) NOT NULL default '',
                          `description` text NOT NULL,
                          PRIMARY KEY  (`cid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'sessions':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_sessions`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_sessions` (
                          `id` varchar(50) NOT NULL default '0',
                          `user_id` varchar(20) NOT NULL default '0',
                          `date` varchar(30) NOT NULL default '',
                          `last_used` varchar(30) NOT NULL default '',
                          `ip` varchar(50) NOT NULL default '',
                          `vars` blob NOT NULL,
                          PRIMARY KEY  (`id`),
                          KEY `user_id` (`user_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'smilies':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_smilies`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_smilies` (
                          `id` int(5) NOT NULL auto_increment,
                          `code` varchar(50) NOT NULL default '',
                          `url` varchar(100) NOT NULL default '',
                          `name` varchar(100) NOT NULL default '',
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_smilies` VALUES
                            (1, ':D', 'biggrin.gif', 'Very Happy'),
                            (2, ':)', 'smile.gif', 'Smile'),
                            (3, ':(', 'frown.gif', 'Sad'),
                            (4, ':o', 'eek.gif', 'Surprised'),
                            (5, ':?', 'confused.gif', 'Confused'),
                            (6, '8)', 'cool.gif', 'Cool'),
                            (7, ':P', 'tongue.gif', 'Razz'),
                            (8, ':x', 'mad.gif', 'Mad'),
                            (9, ';)', 'wink.gif', 'Wink'),
                            (10, ':red:', 'redface.gif', 'Embarassed'),
                            (11, ':roll:', 'rolleyes.gif', 'Rolling Eyes');";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'sondage':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_sondage`";
                        $req = mysql_query($sql) or die (mysql_error());
                        $sql = "CREATE TABLE `" . $db_prefix . "_sondage` (
                            `sid` int(11) NOT NULL auto_increment,
                            `titre` varchar(100) NOT NULL default '',
                            `date` varchar(15) NOT NULL default '0',
                            `niveau` int(1) NOT NULL default '0',
                            PRIMARY KEY  (`sid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_sondage` VALUES
                            (1, '" . mysql_real_escape_string(LIKENK) . "', '" . time() . "', 0);";
                        $req = mysql_query($sql);
                        echo 'OK';
        break;
        case'sondage_check':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_sondage_check`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_sondage_check` (
                          `ip` varchar(20) NOT NULL default '',
                          `pseudo` varchar(50) NOT NULL default '',
                          `heurelimite` int(14) NOT NULL default '0',
                          `sid` varchar(30) NOT NULL default '',
                          KEY `sid` (`sid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'sondage_data':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_sondage_data`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_sondage_data` (
                          `sid` int(11) NOT NULL default '0',
                          `optionText` char(50) NOT NULL default '',
                          `optionCount` int(11) NOT NULL default '0',
                          `voteID` int(11) NOT NULL default '0',
                          KEY `sid` (`sid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_sondage_data` VALUES
                            (1, '" . mysql_real_escape_string(ROXX) . "', 0, 1),
                            (1, '" . mysql_real_escape_string(NOTBAD) . "', 0, 2),
                            (1, '" . mysql_real_escape_string(SHIET) . "', 0, 3),
                            (1, '" . mysql_real_escape_string(WHATSNK) . "', 0, 4);";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'stats':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_stats`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql="CREATE TABLE `" . $db_prefix . "_stats` (
                          `nom` varchar(50) NOT NULL default '',
                          `type` varchar(50) NOT NULL default '',
                          `count` int(11) NOT NULL default '0',
                          PRIMARY KEY  (`nom`,`type`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_stats` VALUES
                            ('Gallery', 'pages', 0),
                            ('Archives', 'pages', 0),
                            ('Calendar', 'pages', 0),
                            ('Defy', 'pages', 0),
                            ('Downloads', 'pages', 0),
                            ('Guestbook', 'pages', 0),
                            ('Irc', 'pages', 0),
                            ('Links', 'pages', 0),
                            ('Wars', 'pages', 0),
                            ('News', 'pages', 0),
                            ('Search', 'pages', 0),
                            ('Recruit', 'pages', 0),
                            ('Sections', 'pages', 0),
                            ('Server', 'pages', 0),
                            ('Members', 'pages', 0),
                            ('Team', 'pages', 0),
                            ('Forum', 'pages', 0);";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'stats_visitor':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_stats_visitor`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_stats_visitor` (
                            `id` int(11) NOT NULL auto_increment,
                            `user_id` varchar(20) NOT NULL default '',
                            `ip` varchar(15) NOT NULL default '',
                            `host` varchar(100) NOT NULL default '',
                            `browser` varchar(50) NOT NULL default '',
                            `os` varchar(50) NOT NULL default '',
                            `referer` varchar(200) NOT NULL default '',
                            `day` int(2) NOT NULL default '0',
                            `month` int(2) NOT NULL default '0',
                            `year` int(4) NOT NULL default '0',
                            `hour` int(2) NOT NULL default '0',
                            `date` varchar(30) NOT NULL default '',
                            PRIMARY KEY  (`id`),
                            KEY `user_id` (`user_id`),
                            KEY `host` (`host`),
                            KEY `browser` (`browser`),
                            KEY `os` (`os`),
                            KEY `referer` (`referer`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'suggest':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_suggest`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_suggest` (
                          `id` int(11) NOT NULL auto_increment,
                          `module` mediumtext NOT NULL,
                          `user_id` varchar(20) NOT NULL default '',
                          `proposition` longtext NOT NULL,
                          `date` varchar(14) NOT NULL default '',
                          PRIMARY KEY  (`id`),
                          KEY `user_id` (`user_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'shoutbox':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_shoutbox`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_shoutbox` (
                          `id` int(11) NOT NULL auto_increment,
                          `auteur` text,
                          `ip` varchar(20) NOT NULL default '',
                          `texte` text,
                          `date` varchar(30) NOT NULL default '',
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'team':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_team`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_team` (
                          `cid` int(11) NOT NULL auto_increment,
                          `titre` varchar(50) NOT NULL default '',
                          `tag` text NOT NULL,
                          `tag2` text NOT NULL,
                          `ordre` int(5) NOT NULL default '0',
                          `game` int(11) NOT NULL default '0',
                          PRIMARY KEY  (`cid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'team_rank':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_team_rank`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_team_rank` (
                          `id` int(11) NOT NULL auto_increment,
                          `titre` varchar(80) NOT NULL default '',
                          `ordre` int(5) NOT NULL default '0',
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'tmpses':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_tmpses`";
                        $req = mysql_query($sql) or die (mysql_error());  
                        $sql = "CREATE TABLE IF NOT EXISTS `" . $db_prefix . "_tmpses` (
                            `session_id` varchar(64) NOT NULL,
                            `session_vars` text NOT NULL,
                            `session_start` bigint(20) NOT NULL,
                            PRIMARY KEY (`session_id`)
                            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'userbox':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_userbox`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_userbox` (
                          `mid` int(50) NOT NULL auto_increment,
                          `user_from` varchar(30) NOT NULL default '',
                          `user_for` varchar(30) NOT NULL default '',
                          `titre` varchar(50) NOT NULL default '',
                          `message` text NOT NULL,
                          `date` varchar(30) NOT NULL default '',
                          `status` int(1) NOT NULL default '0',
                          PRIMARY KEY  (`mid`),
                          KEY `user_from` (`user_from`),
                          KEY `user_for` (`user_for`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'users':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_users`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_users` (
                          `id` varchar(20) NOT NULL default '',
                          `team` varchar(80) NOT NULL default '',
                          `team2` varchar(80) NOT NULL default '',
                          `team3` varchar(80) NOT NULL default '',
                          `rang` int(11) NOT NULL default '0',
                          `ordre` int(5) NOT NULL default '0',
                          `pseudo` text NOT NULL,
                          `mail` varchar(80) NOT NULL default '',
                          `email` varchar(80) NOT NULL default '',
                          `icq` varchar(50) NOT NULL default '',
                          `msn` varchar(80) NOT NULL default '',
                          `aim` varchar(50) NOT NULL default '',
                          `yim` varchar(50) NOT NULL default '',
                          `url` varchar(150) NOT NULL default '',
                          `pass` varchar(80) NOT NULL default '',
                          `niveau` int(1) NOT NULL default '0',
                          `date` varchar(30) NOT NULL default '',
                          `avatar` varchar(100) NOT NULL default '',
                          `signature` text NOT NULL,
                          `user_theme` varchar(30) NOT NULL default '',
                          `user_langue` varchar(30) NOT NULL default '',
                          `game` int(11) NOT NULL default '0',
                          `country` varchar(50) NOT NULL default '',
                          `count` int(10) NOT NULL default '0',
                          `erreur` INT(10) NOT NULL default '0',
                          `token` varchar(13)  DEFAULT NULL,
                          `token_time` varchar(10) NOT NULL DEFAULT '0',
                          PRIMARY KEY  (`id`),
                          KEY `team` (`team`),
                          KEY `team2` (`team2`),
                          KEY `team3` (`team3`),
                          KEY `rang` (`rang`),
                          KEY `game` (`game`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'users_detail':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_users_detail`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_users_detail` (
                          `user_id` varchar(20) NOT NULL default '0',
                          `prenom` text,
                          `age` varchar(10) NOT NULL default '',
                          `sexe` varchar(20) NOT NULL default '',
                          `ville` text,
                          `photo` varchar(150) NOT NULL default '',
                          `motherboard` text,
                          `cpu` varchar(50) default NULL,
                          `ram` varchar(10) NOT NULL default '',
                          `video` text,
                          `resolution` text,
                          `son` text,
                          `ecran` text,
                          `souris` text,
                          `clavier` text,
                          `connexion` text,
                          `system` text,
                          `pref_1` text NOT NULL,
                          `pref_2` text NOT NULL,
                          `pref_3` text NOT NULL,
                          `pref_4` text NOT NULL,
                          `pref_5` text NOT NULL,
                          PRIMARY KEY  (`user_id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'vote':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_vote`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql="CREATE TABLE `" . $db_prefix . "_vote` (
                          `id` int(11) NOT NULL auto_increment,
                          `module` varchar(30) NOT NULL default '0',
                          `vid` int(100) default NULL,
                          `ip` varchar(20) NOT NULL default '',
                          `vote` int(2) default NULL,
                          PRIMARY KEY  (`id`),
                          KEY `vid` (`vid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'vote_mod':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_vote_mod`";
                          $req = mysql_query($sql) or die (mysql_error());                        
                          $sql="CREATE TABLE `" . $db_prefix . "_vote_mod` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `module` text COLLATE latin1_general_ci NOT NULL,
                            `active` int(1) NOT NULL,
                            PRIMARY KEY (`id`)
                          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                          $req = mysql_query($sql) or die (mysql_error());

                          $sql = "INSERT INTO `" . $db_prefix . "_vote_mod` VALUES
                                (1, 'news', 1),
                                (2, 'downloads', 1),
                                (3, 'links', 1),
                                (4, 'survey', 1),
                                (5, 'wars', 1),
                                (6, 'gallery', 1),
                                (7, 'sections', 1);";
                          $req = mysql_query($sql) or die (mysql_error());
                          echo 'OK';
        break;
        default:
            echo WRONGTABLENAME;
        break;
    }
?>