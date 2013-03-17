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
                          `module` varchar(100) NOT NULL,
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
                          `createdDay` int(2) default NULL,
                          `createdMonth` int(2) default NULL,
                          `createdYear` int(4) default NULL,
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
                          KEY `itemId` (`itemId`)
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
                            ('contactMail', 'mail@hotmail.com'),
                            ('cookiename', 'nuked'),
                            ('date_install', '".$date."'),
                            ('dateformat', '" . $dateFormat. "'),
                            ('datezone', '" . $dateZone . "'),
                            ('description', ''),
                            ('footmessage', ''),
                            ('index_site', 'News'),
                            ('keyword', ''),
                            ('langue', '".$this->data['lang_install']."'),
                            ('level_analys', '-1'),
                            ('mail', 'mail@hotmail.com'),
                            ('name', 'Nuked-klaN 1.8'),
                            ('nk_status', 'open'),
                            ('nkToTopTheme', 'nkToTopCube'),
                            ('scayt_editeur', 'on'),
                            ('screen', 'on'),
                            ('sess_inactivemins', '5'),
                            ('sess_days_limit', '365'),
                            ('slogan', 'PHP 4 Gamers'),
                            ('stats_share', '".$stats_share."'),
                            ('stats_timestamp', '0'),
                            ('tag_pre', ''),
                            ('tag_suf', ''),
                            ('theme', ''),
                            ('themeDefault', 'nk18Gamers'),
                            ('time_generate', 'on'),
                            ('url', '".$siteurl."'),
                            ('version', '1.8'),
                            ('video_editeur', 'on'),
                            ('visit_delay', '10'),
                            
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
                            ('max_shout', '20'),
                            ('mess_guest_page', '10'),
                            ('sond_delay', '24'),
                            ('recrute', '1'),
                            ('recrute_charte', ''),
                            ('recrute_mail', ''),
                            ('recrute_inbox', ''),
                            ('defie_charte', ''),
                            ('defie_mail', ''),
                            ('defie_inbox', ''),
                            ('birthday', 'all'),
                            ('nbc_timeout', '300'),
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
        case'defy':
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
                          `created` varchar(30) NOT NULL,
                          `pseudo`  text NOT NULL,
                          `content`  text NOT NULL,
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
                            ('nbComment', '2'),
                            ('commentCut', '130'),
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
                          `category` int(11) NOT NULL default '0',
                          `name` text NOT NULL,
                          `content` text NOT NULL,
                          `moderators` text NOT NULL,
                          `access` int(1) NOT NULL default '0',
                          `level` int(1) NOT NULL default '0',
                          `placing` int(5) NOT NULL default '0',
                          `levelPoll` int(1) NOT NULL default '0',
                          `levelVote` int(1) NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `category` (`category`)
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
                          `name` varchar(100) default NULL,
                          `placing` int(5) NOT NULL default '0',
                          `access` int(1) NOT NULL default '0',
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
                          `title` text NOT NULL,
                          `content` text NOT NULL,
                          `created` varchar(12) NOT NULL,
                          `edited` text NOT NULL,
                          `autor` text NOT NULL,
                          `autorId` varchar(20) NOT NULL,
                          `autorIp` varchar(20) NOT NULL,
                          `bbcodeoff` int(1) NOT NULL default '0',
                          `smileyoff` int(1) NOT NULL default '0',
                          `cssoff` int(1) NOT NULL default '0',
                          `userSigning` int(1) NOT NULL default '0',
                          `emailNotify` int(1) NOT NULL default '0',
                          `threadId` int(5) NOT NULL default '0',
                          `forumId` mediumint(10) NOT NULL default '0',
                          `attachment` varchar(200) NOT NULL,
                          PRIMARY KEY  (`id`),
                          KEY `autorId` (`autorId`),
                          KEY `threadId` (`threadId`),
                          KEY `forumId` (`forumId`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_threads':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_threads`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_threads` (
                          `id` int(5) NOT NULL auto_increment,
                          `title` text NOT NULL,
                          `created` varchar(10) default NULL,
                          `closed` int(1) NOT NULL default '0',
                          `autor` text NOT NULL,
                          `autorId` varchar(20) NOT NULL,
                          `forumId` int(5) NOT NULL default '0',
                          `lastPost` varchar(20) NOT NULL,
                          `view` int(10) NOT NULL default '0',
                          `annonce` int(1) NOT NULL default '0',
                          `survey` int(1) NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `autorId` (`autorId`),
                          KEY `forumId` (`forumId`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_rank':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_rank`";
                        $req = mysql_query($sql) or die(mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_rank` (
                          `id` int(10) NOT NULL auto_increment,
                          `name` varchar(100) NOT NULL,
                          `type` int(1) NOT NULL default '0',
                          `nbPost` int(4) NOT NULL default '0',
                          `image` varchar(200) NOT NULL,
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
                          `userId` varchar(20) NOT NULL,
                          `threadId` text NOT NULL,
                          `forumId` text NOT NULL,
                          PRIMARY KEY  (`userId`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_poll':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_poll`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_poll` (
                          `id` int(11) NOT NULL auto_increment,
                          `threadId` int(11) NOT NULL default '0',
                          `title` varchar(255) NOT NULL,
                          PRIMARY KEY  (`id`),
                          KEY `threadId` (`threadId`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_options':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_options`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_options` (
                          `id` int(11) NOT NULL default '0',
                          `pollId` int(11) NOT NULL default '0',
                          `optionText` varchar(255) NOT NULL,
                          `optionVote` int(11) NOT NULL default '0',
                          KEY `pollId` (`pollId`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'forums_vote':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_forums_vote`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_forums_vote` (
                          `pollId` int(11) NOT NULL default '0',
                          `autorId` varchar(20) NOT NULL default '',
                          `autorIp` varchar(20) NOT NULL default '',
                          KEY `pollId` (`pollId`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'gallery':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_gallery`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_gallery` (
                          `id` int(11) NOT NULL auto_increment,
                          `title` text NOT NULL,
                          `content` text NOT NULL,
                          `url` varchar(200) NOT NULL,
                          `url2` varchar(200) NOT NULL,
                          `urlFile` varchar(200) NOT NULL,
                          `category` int(11) NOT NULL default '0',
                          `created` varchar(12) NOT NULL,
                          `count` int(10) NOT NULL default '0',
                          `autor` text NOT NULL,
                          PRIMARY KEY  (`id`),
                          KEY `category` (`category`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'gallery_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_gallery_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_gallery_cat` (
                          `id` int(11) NOT NULL auto_increment,
                          `parentid` int(11) NOT NULL default '0',
                          `title` varchar(50) NOT NULL,
                          `content` text NOT NULL,
                          `placing` int(2) unsigned NOT NULL default '0',
                          PRIMARY KEY  (`id`),
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
                          `name` varchar(50) NOT NULL,
                          `title` varchar(50) NOT NULL,
                          `icon` varchar(150) NOT NULL,
                          `prefOne` varchar(50) NOT NULL,
                          `prefTwo` varchar(50) NOT NULL,
                          `prefThree` varchar(50) NOT NULL,
                          `prefFour` varchar(50) NOT NULL,
                          `prefFive` varchar(50) NOT NULL,
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
                          `userId` varchar(20) NOT NULL,
                          `prefOne` varchar(50) NOT NULL,
                          `prefTwo` varchar(50) NOT NULL,
                          `prefThree` varchar(50) NOT NULL,
                          `prefFour` varchar(50) NOT NULL,
                          `prefFive` varchar(50) NOT NULL,
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
                          `name` varchar(50) NOT NULL,
                          `email` varchar(60) NOT NULL,
                          `url` varchar(70) NOT NULL,
                          `created` int(11) NOT NULL default '0',
                          `host` varchar(60) NOT NULL,
                          `content` text NOT NULL,
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
                          `content` text NOT NULL,
                          `created` varchar(30) NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'links':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_links`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_links` (
                          `id` int(10) NOT NULL auto_increment,
                          `created` varchar(12) NOT NULL,
                          `title` text NOT NULL,
                          `content` text NOT NULL,
                          `url` varchar(200) NOT NULL,
                          `category` int(11) NOT NULL default '0',
                          `webmaster` text NOT NULL,
                          `country` varchar(50) NOT NULL,
                          `count` int(11) NOT NULL default '0',
                          `broke` int(11) NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `category` (`category`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'links_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_links_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_links_cat` (
                          `id` int(11) NOT NULL auto_increment,
                          `parentid` int(11) NOT NULL default '0',
                          `title` varchar(50) NOT NULL,
                          `content` text NOT NULL,
                          `placing` int(2) unsigned NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `parentid` (`parentid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'match':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_match`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_match` (
                          `id` int(10) NOT NULL auto_increment,
                          `status` int(1) NOT NULL default '0',
                          `team` int(11) NOT NULL default '0',
                          `paysTeam` varchar(50) NOT NULL,
                          `game` int(11) NOT NULL default '0',
                          `adversary` text,
                          `urlAdversary` varchar(60) default NULL,
                          `paysAdversary` varchar(50) NOT NULL,
                          `type` varchar(100) default NULL,
                          `style` varchar(100) NOT NULL,
                          `createdDay` int(2) default NULL,
                          `createdMonth` int(2) default NULL,
                          `createdYear` int(4) default NULL,
                          `hour` varchar(10) NOT NULL,
                          `map` text,
                          `tscoreTeam` float default NULL,
                          `tscoreAdversary` float default NULL,
                          `scoreTeam` text NOT NULL,
                          `scoreAdversary` text NOT NULL,
                          `report` text,
                          `autor` varchar(50) default NULL,
                          `urlLeague` varchar(100) default NULL,
                          `available` text,
                          `unavailable` text,
                          PRIMARY KEY  (`id`)
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
                          `itemId` int(10) NOT NULL default '0',
                          `type` varchar(30) NOT NULL default '',
                          `url` varchar(200) NOT NULL default '',
                          PRIMARY KEY  (`id`),
                          KEY `itemId` (`itemId`)
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
                            (21, 'Stats', '', 0, 2),
                            (22, 'Contact', '', 0, 3);";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'nbconnecte':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_nbconnecte`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_nbconnecte` (
                          `IP` varchar(30) NOT NULL,
                          `type` int(10) NOT NULL default '0',
                          `created` int(14) NOT NULL,
                          `userId` varchar(20) NOT NULL,
                          `userName` varchar(40) NOT NULL,
                          PRIMARY KEY  ( `IP` , `userId` )
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'news':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_news`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_news` (
                          `id` int(11) NOT NULL auto_increment,
                          `category` varchar(30) NOT NULL,
                          `title` text,
                          `autor` text,
                          `autorId` varchar(20) NOT NULL,
                          `content` text,
                          `continuation` text,
                          `created` varchar(30) NOT NULL,
                          `bbcodeoff` int(1) NOT NULL default '0',
                          `smileyoff` int(1) NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `category` (`category`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die(mysql_error());
                        echo 'OK';
        break;
        case'news_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_news_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_news_cat` (
                          `id` int(11) NOT NULL auto_increment,
                          `title` text,
                          `content` text,
                          `image` text,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_news_cat` VALUES
                            ('1', 'Counter Strike Source', '" . mysql_real_escape_string(BESTMOD) . "', 'modules/News/images/cs.gif');";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'news_config':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_news_config`";
                        $req = mysql_query($sql) or die (mysql_error());
                        $sql = "CREATE TABLE `" . $db_prefix . "_news_config` (
                          `name` varchar(255) NOT NULL,
                          `value` text NOT NULL,
                          PRIMARY KEY (`name`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_news_config` VALUES
                            ('txtReadMore', 'on'),
                            ('nbMaxNews', '1'),
                            ('nbComment', '5'),
                            ('commentCut', '150'),
                            ('pdfFont', 'courier'),
                            ('pdfFontStyle', ''),
                            ('pdfFontSize', '10'),
                            ('pdfGeneratedType', 'I'),
                            ('pdfDirection', 'P'),
                            ('pdfFormat', 'A4');";
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
        case'recruit':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_recruit`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_recruit` (
                          `id` int(11) NOT NULL auto_increment,
                          `created` varchar(12) NOT NULL,
                          `pseudo` text NOT NULL,
                          `firstName` text NOT NULL,
                          `age` int(3) NOT NULL default '0',
                          `mail` varchar(80) NOT NULL,
                          `icq` varchar(50) NOT NULL,
                          `country` text NOT NULL,
                          `game` int(11) NOT NULL default '0',
                          `connection` text NOT NULL,
                          `experience` text NOT NULL,
                          `available` text NOT NULL,
                          `content` text NOT NULL,
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
                        `id` int(11) NOT NULL auto_increment,
                        `categoryId` int(11) NOT NULL default '0',
                        `title` text NOT NULL,
                        `content` text NOT NULL,
                        `autor` text NOT NULL,
                        `autorId` varchar(20) NOT NULL,
                        `counter` int(11) NOT NULL default '0',
                        `bbcodeoff` int(1) NOT NULL default '0',
                        `smileyoff` int(1) NOT NULL default '0',
                        `created` varchar(12) NOT NULL,
                        PRIMARY KEY  (`id`),
                        KEY `categoryId` (`categoryId`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'sections_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_sections_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_sections_cat` (
                          `id` int(11) NOT NULL auto_increment,
                          `parentid` int(11) NOT NULL default '0',
                          `categoryName` varchar(40) NOT NULL,
                          `content` text NOT NULL,
                          `placing` int(2) unsigned NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `parentid` (`parentid`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'server':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_server`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_server` (
                          `id` int(30) NOT NULL auto_increment,
                          `game` varchar(30) NOT NULL,
                          `ip` varchar(30) NOT NULL,
                          `port` varchar(10) NOT NULL,
                          `pass` varchar(10) NOT NULL,
                          `category` varchar(30) NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `game` (`game`),
                          KEY `category` (`category`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'server_cat':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_server_cat`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_server_cat` (
                          `id` int(30) NOT NULL auto_increment,
                          `title` varchar(30) NOT NULL,
                          `content` text NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'sessions':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_sessions`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_sessions` (
                          `id` varchar(50) NOT NULL default '0',
                          `userId` varchar(20) NOT NULL default '0',
                          `created` varchar(30) NOT NULL,
                          `lastUsed` varchar(30) NOT NULL,
                          `ip` varchar(50) NOT NULL,
                          `vars` blob NOT NULL,
                          PRIMARY KEY  (`id`),
                          KEY `userId` (`userId`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'smilies':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_smilies`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_smilies` (
                          `id` int(5) NOT NULL auto_increment,
                          `code` varchar(50) NOT NULL,
                          `url` varchar(100) NOT NULL,
                          `name` varchar(100) NOT NULL,
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
        case'survey':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_survey`";
                        $req = mysql_query($sql) or die (mysql_error());
                        $sql = "CREATE TABLE `" . $db_prefix . "_survey` (
                            `id` int(11) NOT NULL auto_increment,
                            `title` varchar(100) NOT NULL,
                            `created` varchar(15) NOT NULL default '0',
                            `level` int(1) NOT NULL default '0',
                            PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_survey` VALUES
                            (1, '" . mysql_real_escape_string(LIKENK) . "', '" . time() . "', 0);";
                        $req = mysql_query($sql);
                        echo 'OK';
        break;
        case'survey_check':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_survey_check`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_survey_check` (
                          `ip` varchar(20) NOT NULL,
                          `pseudo` varchar(50) NOT NULL,
                          `deadline` int(14) NOT NULL,
                          `id` varchar(30) NOT NULL,
                          KEY `id` (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'survey_data':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_survey_data`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_survey_data` (
                          `id` int(11) NOT NULL default '0',
                          `optionText` char(50) NOT NULL,
                          `optionCount` int(11) NOT NULL default '0',
                          `voteID` int(11) NOT NULL default '0',
                          KEY `id` (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        
                        $sql = "INSERT INTO `" . $db_prefix . "_survey_data` VALUES
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
                          `name` varchar(50) NOT NULL,
                          `type` varchar(50) NOT NULL,
                          `count` int(11) NOT NULL default '0',
                          PRIMARY KEY  (`name`,`type`)
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
                            `userId` varchar(20) NOT NULL,
                            `ip` varchar(15) NOT NULL,
                            `host` varchar(100) NOT NULL,
                            `browser` varchar(50) NOT NULL,
                            `os` varchar(50) NOT NULL,
                            `referer` varchar(200) NOT NULL,
                            `day` int(2) NOT NULL default '0',
                            `month` int(2) NOT NULL default '0',
                            `year` int(4) NOT NULL default '0',
                            `hour` int(2) NOT NULL default '0',
                            `created` varchar(30) NOT NULL,
                            PRIMARY KEY  (`id`),
                            KEY `userId` (`userId`),
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
                          `userId` varchar(20) NOT NULL,
                          `proposition` longtext NOT NULL,
                          `created` varchar(14) NOT NULL,
                          PRIMARY KEY  (`id`),
                          KEY `userId` (`userId`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'shoutbox':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_shoutbox`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_shoutbox` (
                          `id` int(11) NOT NULL auto_increment,
                          `autor` text,
                          `ip` varchar(20) NOT NULL,
                          `content` text,
                          `created` varchar(30) NOT NULL,
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'team':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_team`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_team` (
                          `id` int(11) NOT NULL auto_increment,
                          `title` varchar(50) NOT NULL,
                          `firstTag` text NOT NULL,
                          `secondTag` text NOT NULL,
                          `placing` int(5) NOT NULL default '0',
                          `game` int(11) NOT NULL default '0',
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'team_rank':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_team_rank`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_team_rank` (
                          `id` int(11) NOT NULL auto_increment,
                          `title` varchar(80) NOT NULL,
                          `placing` int(5) NOT NULL default '0',
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
                          `id` int(50) NOT NULL auto_increment,
                          `userFrom` varchar(30) NOT NULL,
                          `userFor` varchar(30) NOT NULL,
                          `title` varchar(50) NOT NULL,
                          `content` text NOT NULL,
                          `created` varchar(30) NOT NULL,
                          `status` int(1) NOT NULL default '0',
                          PRIMARY KEY  (`id`),
                          KEY `userFrom` (`userFrom`),
                          KEY `userFor` (`userFor`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'users':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_users`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_users` (
                          `id` varchar(20) NOT NULL,
                          `pseudo` text NOT NULL,
                          `firstName` text NOT NULL,
                          `age` varchar(10) NOT NULL,
                          `sex` varchar(20) NOT NULL,
                          `city` text NOT NULL,
                          `privateMail` varchar(80) NOT NULL,
                          `publicMail` varchar(80) NOT NULL,
                          `website` varchar(150) NOT NULL,
                          `pass` varchar(80) NOT NULL,
                          `level` int(1) NOT NULL DEFAULT '0',
                          `created` varchar(30) NOT NULL,
                          `avatar` varchar(100) NOT NULL,
                          `signing` text NOT NULL,
                          `userTheme` varchar(30) NOT NULL,
                          `userLanguage` varchar(30) NOT NULL,
                          `country` varchar(50) NOT NULL,
                          `countForum` int(10) NOT NULL DEFAULT '0',
                          `countComment` int(10) NOT NULL DEFAULT '0',
                          `countSuggest` int(10) NOT NULL DEFAULT '0',
                          `countVisitor` int(10) NOT NULL DEFAULT '0',
                          `lastVisitor` varchar(20) NOT NULL,
                          `error` int(10) NOT NULL DEFAULT '0',
                          `token` varchar(13) DEFAULT NULL,
                          `tokenTime` varchar(10) NOT NULL DEFAULT '0',
                          PRIMARY KEY  (`id`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'users_config':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_users_config`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_users_config` (
                            `name` varchar(255) NOT NULL,
                            `value` text NOT NULL,
                          PRIMARY KEY  (`name`)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $req = mysql_query($sql) or die (mysql_error());

                         $sql = "INSERT INTO `" . $db_prefix . "_users_config` VALUES
                            ('inscription', 'on'),
                            ('inscriptionAvert', ''),
                            ('inscriptionCharte', ''),
                            ('inscriptionMail', ''),
                            ('avatarUpload', 'on'),
                            ('avatarUrl', 'on'),
                            ('maxMembers', '30'),
                            ('userAccountDelete', 'on'),
                            ('nbForumMessage', '5'),
                            ('nbComment', '5'),
                            ('nbSuggest', '5'),
                            ('activeTheme', 'on'),
                            ('validation', 'auto'),
                            ('activeCountry', 'on');";
                        $req = mysql_query($sql) or die (mysql_error());
                        echo 'OK';
        break;
        case'users_detail':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_users_detail`";
                        $req = mysql_query($sql) or die (mysql_error());                        
                        $sql = "CREATE TABLE `" . $db_prefix . "_users_detail` (
                          `userId` varchar(20) NOT NULL default '0',
                          `firstName` text,
                          `age` varchar(10) default NULL,
                          `sex` varchar(20) default NULL,
                          `city` text default NULL,
                          `picture` varchar(150) default NULL,
                          `motherboard` text default NULL,
                          `cpu` varchar(50) default NULL,
                          `ram` varchar(10) default NULL,
                          `video` text default NULL,
                          `resolution` text default NULL,
                          `sound` text default NULL,
                          `screen` text default NULL,
                          `mouse` text default NULL,
                          `keyboard` text default NULL,
                          `connection` text default NULL,
                          `system` text default NULL,
                          `prefOne` text default NULL,
                          `prefTwo` text default NULL,
                          `prefThree` text default NULL,
                          `prefFour` text default NULL,
                          `prefFive` text default NULL,
                          PRIMARY KEY  (`userId`)
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
                          `itemId` int(100) default NULL,
                          `ip` varchar(20) NOT NULL default '',
                          `vote` int(2) default NULL,
                          PRIMARY KEY  (`id`),
                          KEY `id` (`id`)
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
        case'world_continents':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_world_continents`";
                          $req = mysql_query($sql) or die (mysql_error());                        
                          $sql="CREATE TABLE `" . $db_prefix . "_world_continents` (
                              `id` int(11) NOT NULL DEFAULT '0',
                              `code` char(2) NOT NULL COMMENT 'Continent code',
                              `name` varchar(255) DEFAULT NULL,
                              `active` int(1) NOT NULL DEFAULT '0',
                              PRIMARY KEY (`id`)
                          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                          $req = mysql_query($sql) or die (mysql_error());

                          $sql = "INSERT INTO `" . $db_prefix . "_world_continents` VALUES
                            (1, 'AF', 'Africa', 0),
                            (2, 'AN', 'Antarctica', 0),
                            (3, 'AS', 'Asia', 0),
                            (4, 'EU', 'Europe', 0),
                            (5, 'NA', 'North America', 0),
                            (6, 'OC', 'Oceania', 0),
                            (7, 'SA', 'South America', 0);";
                          $req = mysql_query($sql) or die (mysql_error());
                          echo 'OK';
        break;
        case'world_lang':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_world_lang`";
                          $req = mysql_query($sql) or die (mysql_error());                        
                          $sql="CREATE TABLE `" . $db_prefix . "_world_lang` (
                              `lang` nvarchar(255) NOT NULL,
                              `fileLang` varchar(255) NOT NULL,
                              UNIQUE KEY `lang` (`lang`)
                          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                          $req = mysql_query($sql) or die (mysql_error());

                          $sql = "INSERT INTO `" . $db_prefix . "_world_lang` VALUES
                            ('Francais', 'French'),
                            ('Nederlands', 'Dutch'),
                            ('Deutsch', 'German'),
                            (n'العربية', 'Arabic'),
                            (n'Català', 'Catalan'),
                            ('Italiano', 'Italian'),
                            (n'پښتو', 'Pashto'),
                            (n'دری', 'Dari'),
                            (n'Português', 'Portuguese'),
                            ('Samoan', 'Samoan'),
                            ('Svenska', 'Swedish'),
                            (n'فارسی', 'Persian'),
                            ('Bosanski', 'Bosnian'),
                            (n'Српски', 'Serbian'),
                            ('Hrvatski', 'Croatian'),
                            (n'বাংলা', 'Bengali'),
                            (n'Moré', 'More'),
                            ('Jula', 'Dioula'),
                            ('Fulfulde', 'Fulfulde'),
                            (n'български', 'Bulgarian'),
                            ('Kirundi', 'Kirundi'),
                            (n'Kreyòl', 'Creole'),
                            ('Melayu Brunei', 'MelayuBrunei'),
                            (n'Español', 'Spanish'),
                            ('Aymara', 'Aymara'),
                            (n'avañe''ẽ', 'Guarani'),
                            ('Runasimi', 'Quesha'),
                            ('Papiamento', 'Papiamento'),
                            (n'རྫོང་ཁ་', 'Dzongkha'),
                            ('Norsk', 'Norwegian'),
                            ('Setswana', 'Tswana'),
                            (n'Беларуская мова', 'Belarusian'),
                            (n'русский язык', 'Russian'),
                            (n'Sängö', 'Sango'),
                            (n'Māori', 'Maori'),
                            (n'中国的', 'Chinese'),
                            (n'ελληνικά', 'Greek'),
                            (n'Čeština', 'Czech'),
                            ('Niederdeutsch', 'German'),
                            ('Plattdeutsch', 'German'),
                            ('Dansk', 'Danish'),
                            ('Runa shimi', 'RunaShimi'),
                            ('Shuar', 'Shuar'),
                            ('Eesti keel', 'Estonian'),
                            (n'ⵜⴰⵎⴰⵣⵉⵖⵜ', 'Tamazight'),
                            (n'ትግርኛ', 'Tigrigna'),
                            (n'አማርኛ', 'Amharic'),
                            ('Suomi', 'Finnish'),
                            (n'हिन्दी', 'Hindi'),
                            ('Na Vosa Vakaviti', 'Fidjien'),
                            (n'Føroyskt mál', 'Faroese'),
                            ('Cymraeg', 'Welsh'),
                            (n'gàidhlig', 'Scottish'),
                            ('Gaeilge', 'Irish'),
                            ('Guernesiais', 'Guernsey'),
                            ('Kalaallisut', 'Greenlandic'),
                            (n'Eλληνικά', 'Greece'),
                            ('Chamoru', 'Chamoru'),
                            (n'粵語', 'Cantonese'),
                            ('Ayisyen', 'Haitian'),
                            ('Magyar', 'Hungarian'),
                            ('Bahasa Indonesia', 'Indonesian'),
                            (n'[iv.''ʀit]', 'Hebrew'),
                            ('Gailck', 'Manx'),
                            ('Gaelg', 'Manx'),
                            (n'íslenska', 'Icelandic'),
                            ('Ladin', 'Ladin'),
                            (n'Slovenščina', 'Slovenian'),
                            ('Nourmaund', 'Norman'),
                            (n'日本語', 'Japanese'),
                            ('Kiswahili', 'Swahili'),
                            (n'Кыргыз тили', 'Kirghiz'),
                            (n'ភាសាខ្មែរ', 'Khmer'),
                            ('te tatae ni Kiribati', 'Gilbertese'),
                            ('shikomori', 'Comoros'),
                            (n'조선말', 'Korea'),
                            (n'한국말', 'Korea'),
                            (n'Қазақ тілі', 'Kazakhstan'),
                            (n'ພາສາລາວ', 'Lao'),
                            (n'தமிழ்', 'Tamil'),
                            (n'සිංහල', 'Singhalese'),
                            ('Sesotho', 'Sesotho'),
                            (n'Lietuvių kalba', 'Lithuanian'),
                            (n'Lëtzebuergesch', 'Luxembourg'),
                            (n'Latviešu valoda', 'Latvian'),
                            ('Tamazight', 'Tamazight'),
                            (n'Română', 'Romanian'),
                            (n'црногорски', 'Montenegrin'),
                            ('Malagasy', 'Malagasy'),
                            (n'Kajin M̧ajeļ', 'Marshallese'),
                            (n'македонски', 'Macedonian'),
                            (n'[mjàNmàzəgà]', 'Burmese'),
                            (n'Монгол хэл', 'Mongol'),
                            ('Refalawasch', 'Carolinian'),
                            ('Malti', 'Maltese'),
                            ('Divehi', 'Dhivehi'),
                            ('Chichewa', 'Chichewa'),
                            ('Bahasa Melayu', 'Malay'),
                            ('Hausa', 'Haousa'),
                            ('Igbo', 'Igbo'),
                            (n'yorùbá', 'Yoruba'),
                            ('Frison', 'Frison'),
                            (n'नेपाली', 'Nepalese'),
                            (n'Ko e vagahau Niuē', 'Niuéen'),
                            (n'Te Reo Māori', 'Maori'),
                            ('Tok pisin', 'TokPisin'),
                            ('Hiri motu', 'HiriMotu'),
                            ('Filipino', 'Filipino'),
                            (n'اردو', 'Ourdou'),
                            (n'Język polski', 'Polish'),
                            ('belau', 'Paluan'),
                            ('Srpski', 'Serbian'),
                            ('Kinyarwanda', 'Kinyarwanda'),
                            (n'Créole seychellois', 'CreoleSeychellois'),
                            (n'官話', 'Mandarin'),
                            (n'官话', 'Mandarin'),
                            (n'Slovenčina', 'Slovak'),
                            ('Jola', 'Diola'),
                            (n'Malinké', 'Malinke'),
                            ('Pular', 'Fulani'),
                            (n'Sérère', 'Serere'),
                            (n'Soninké', 'Soninke'),
                            ('Wolof', 'Wolof'),
                            (n'الصوماليه', 'Somali'),
                            ('Creole', 'Creole'),
                            ('siSwati', 'Swati'),
                            (n'ภาษาไทย', 'Thai'),
                            (n'Тоҷикӣ', 'Tajik'),
                            ('Tokelau', 'Tokelau'),
                            ('Tetum', 'Tetoum'),
                            (n'Türkmen dili', 'Turkeme'),
                            ('Tonguien', 'Tonguien'),
                            (n'Türkçe', 'Turkish'),
                            ('Te Nganana Tuvalu', 'Tuvaluan'),
                            (n'客家话', 'Hakka'),
                            (n'українська мова', 'Ukrainian'),
                            (n'Oʻzbek tili', 'Uzbek'),
                            (n'Lingua Latīna', 'Latin'),
                            (n'Tiếng Việt', 'Vietnamese'),
                            ('Bislama', 'Bislama'),
                            (n'Fakaʻuvea', 'Wallisian'),
                            ('Fakafutuna', 'Futunan'),
                            (n'Gagana Sāmoa', 'Samoan'),
                            ('Afrikaans', 'Afrikaans'),
                            ('Nrebele', 'Nrebele'),
                            ('isiXhosa', 'Xhosa'),
                            ('isiZulu', 'Zulu'),
                            ('Tsonga', 'Tsonga'),
                            ('Venda', 'Venda'),
                            ('ChiShona', 'Shona'),
                            ('isiNdebele', 'Sindebele');";
                          $req = mysql_query($sql) or die (mysql_error());
                          echo 'OK';
        break;
        case'world_countries':
                        $sql = "DROP TABLE IF EXISTS `" . $db_prefix . "_world_countries`";
                          $req = mysql_query($sql) or die (mysql_error());                        
                          $sql="CREATE TABLE `" . $db_prefix . "_world_countries` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `code` char(2) NOT NULL COMMENT 'Two-letter country code (ISO 3166-1 alpha-2)',
                              `name` varchar(255) NOT NULL COMMENT 'English country name',
                              `continentId` int(11) NOT NULL,
                              `language` nvarchar(255) NOT NULL,
                              `active` int(1) NOT NULL DEFAULT '0',
                              PRIMARY KEY (`id`),
                              KEY `continent_code` (`continentId`)
                          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                          $req = mysql_query($sql) or die (mysql_error());

                          $sql = "INSERT INTO `" . $db_prefix . "_world_countries` VALUES
                            (1, 'AD', 'Andorra', 4, n'Català', 0),
                            (2, 'AE', 'United Arab Emirates', 3, n'العربية', 0),
                            (3, 'AF', 'Afghanistan', 3, n'دری|پښتو', 0),
                            (4, 'AG', 'Antigua and Barbuda', 5, 'English', 0),
                            (5, 'AI', 'Anguilla', 5, 'English', 0),
                            (6, 'AL', 'Albania', 4, 'Shqiptar', 0),
                            (7, 'AM', 'Armenia', 3, n'Hայերեն', 0),
                            (8, 'AO', 'Angola', 1, n'Português', 0),
                            (9, 'AQ', 'Antarctica', 2, 'English', 0),
                            (10, 'AR', 'Argentina', 7, 'Spanish', 0),
                            (11, 'AS', 'American Samoa', 6, 'English|Samoan', 0),
                            (12, 'AT', 'Austria', 4, 'German', 0),
                            (13, 'AU', 'Australia', 6, 'English', 0),
                            (14, 'AW', 'Aruba', 5, 'NederLands|Papiamento', 0),
                            (15, 'AX', 'Åland Islands', 4, 'Svenska', 0),
                            (16, 'AZ', 'Azerbaijan', 3, n'فارسی', 0),
                            (17, 'BA', 'Bosnia and Herzegovina', 4, n'Bosanski|Српски|Hrvatski', 0),
                            (18, 'BB', 'Barbados', 5, 'English', 0),
                            (19, 'BD', 'Bangladesh', 3, n'বাংলা', 0),
                            (20, 'BE', 'Belgium', 4, 'Nederlands|Francais|Deutsch', 1),
                            (21, 'BF', 'Burkina Faso', 1, n'Moré|Jula|Fulfulde', 0),
                            (22, 'BG', 'Bulgaria', 4, n'български', 0),
                            (23, 'BH', 'Bahrain', 3, n'العربية', 0),
                            (24, 'BI', 'Burundi', 1, 'Francais|Kirundi', 0),
                            (25, 'BJ', 'Benin', 1, 'Francais', 0),
                            (26, 'BL', 'Saint Barthélemy', 5, n'Francais|English|Kreyòl', 0),
                            (27, 'BM', 'Bermuda', 5, n'English|Português', 0),
                            (28, 'BN', 'Brunei Darussalam', 3, 'Melayu Brunei', 0),
                            (29, 'BO', 'Bolivia', 7, n'Aymara|Español|avañe''ẽ|Runasimi', 0),
                            (30, 'BQ', 'Bonaire, Sint Eustatius and Saba', 5, 'Nederlands|English|Papiamento', 0),
                            (31, 'BR', 'Brazil', 7, n'Português', 0),
                            (32, 'BS', 'Bahamas', 5, 'English', 0),
                            (33, 'BT', 'Bhutan', 3, n'རྫོང་ཁ་', 0),
                            (34, 'BV', 'Bouvet Island (Bouvetoya)', 2, 'Norsk', 0),
                            (35, 'BW', 'Botswana', 1, 'Setswana|English', 0),
                            (36, 'BY', 'Belarus', 4, n'Беларуская мова|русский язык', 0),
                            (37, 'BZ', 'Belize', 5, 'English', 0),
                            (38, 'CA', 'Canada', 5, 'Francais|English', 0),
                            (39, 'CC', 'Cocos (Keeling) Islands', 3, 'English', 0),
                            (40, 'CD', 'Democratic Republic of Congo', 1, 'Francais', 0),
                            (41, 'CF', 'Central African Republic', 1, n'Francais|Sängö', 0),
                            (42, 'CG', 'Republic of Congo', 1, 'Francais', 0),
                            (43, 'CH', 'Switzerland', 4, 'Francais|Deutsch|Italiano', 0),
                            (44, 'CI', 'Ivory Coast', 1, 'Francais', 0),
                            (45, 'CK', 'Cook Islands', 6, n'English|Māori', 0),
                            (46, 'CL', 'Chile', 7, n'Español', 0),
                            (47, 'CM', 'Cameroon', 1, 'Francais|English', 0),
                            (48, 'CN', 'China', 3, n'中国的', 0),
                            (49, 'CO', 'Colombia', 7, n'Español', 0),
                            (50, 'CR', 'Costa Rica', 5, n'Español', 0),
                            (51, 'CU', 'Cuba', 5, n'Español', 0),
                            (52, 'CV', 'Cape Verde', 1, n'Português', 0),
                            (53, 'CW', 'Curaçao', 5, n'Nederlands|English|Papiamento|Español', 0),
                            (54, 'CX', 'Christmas Island', 3, 'English', 0),
                            (55, 'CY', 'Cyprus', 3, n'ελληνικά|English|Francais', 0),
                            (56, 'CZ', 'Czech Republic', 4, n'Čeština', 0),
                            (57, 'DE', 'Germany', 4, 'Deutsch|Niederdeutsch|Plattdeutsch', 0),
                            (58, 'DJ', 'Djibouti', 1, n'Francais|العربية', 0),
                            (59, 'DK', 'Denmark', 4, 'Dansk', 0),
                            (60, 'DM', 'Dominica', 5, 'English|Francais', 0),
                            (61, 'DO', 'Dominican Republic', 5, n'Español', 0),
                            (62, 'DZ', 'Algeria', 1, n'العربية', 0),
                            (63, 'EC', 'Ecuador', 7, n'Español|Runa shimi|Shuar', 0),
                            (64, 'EE', 'Estonia', 4, 'Eesti keel', 0),
                            (65, 'EG', 'Egypt', 1, n'العربية', 0),
                            (66, 'EH', 'Western Sahara', 1, n'ⵜⴰⵎⴰⵣⵉⵖⵜ|العربية', 0),
                            (67, 'ER', 'Eritrea', 1, n'ትግርኛ|العربية|English', 0),
                            (68, 'ES', 'Spain', 4, n'Español', 0),
                            (69, 'ET', 'Ethiopia', 1, n'አማርኛ', 0),
                            (70, 'FI', 'Finland', 4, 'Suomi|svenska', 0),
                            (71, 'FJ', 'Fiji', 6, n'English|Na Vosa Vakaviti|हिन्दी', 0),
                            (72, 'FK', 'Falkland Islands (Malvinas)', 7, 'English', 0),
                            (73, 'FM', 'Micronesia', 6, 'English', 0),
                            (74, 'FO', 'Faroe Islands', 4, n'Føroyskt mál|Dansk', 0),
                            (75, 'FR', 'France', 4, 'Francais', 1),
                            (76, 'GA', 'Gabon', 1, 'Francais', 0),
                            (77, 'GB', 'United Kingdom & Northern Ireland', 4, n'English|Cymraeg|gàidhlig|Gaeilge', 0),
                            (78, 'GD', 'Grenada', 5, 'English', 0),
                            (79, 'GE', 'Georgia', 3, 'English', 0),
                            (80, 'GF', 'French Guiana', 7, 'Francais', 0),
                            (81, 'GG', 'Guernsey', 4, 'English|Francais|Guernesiais', 0),
                            (82, 'GH', 'Ghana', 1, 'English', 0),
                            (83, 'GI', 'Gibraltar', 4, n'English|Español', 0),
                            (84, 'GL', 'Greenland', 5, 'Kalaallisut', 0),
                            (85, 'GM', 'Gambia', 1, 'English', 0),
                            (86, 'GN', 'Guinea', 1, 'Francais', 0),
                            (87, 'GP', 'Guadeloupe', 5, 'Francais', 0),
                            (88, 'GQ', 'Equatorial Guinea', 1, n'Francais|Español|Português', 0),
                            (89, 'GR', 'Greece', 4, n'Eλληνικά', 0),
                            (90, 'GS', 'South Georgia and the South Sandwich Islands', 2, 'English', 0),
                            (91, 'GT', 'Guatemala', 5, n'Español', 0),
                            (92, 'GU', 'Guam', 6, 'English|Chamoru', 0),
                            (93, 'GW', 'Guinea-Bissau', 1, n'Português', 0),
                            (94, 'GY', 'Guyana', 7, 'English', 0),
                            (95, 'HK', 'Hong Kong', 3, n'English|粵語', 0),
                            (96, 'HM', 'Heard Island and McDonald Islands', 2, 'English', 0),
                            (97, 'HN', 'Honduras', 5, n'Español', 0),
                            (98, 'HR', 'Croatia', 4, 'Hrvatski', 0),
                            (99, 'HT', 'Haiti', 5, 'Francais|Ayisyen', 0),
                            (100, 'HU', 'Hungary', 4, 'Magyar', 0),
                            (101, 'ID', 'Indonesia', 3, 'Bahasa Indonesia', 0),
                            (102, 'IE', 'Ireland', 4, 'English|Gaeilge', 0),
                            (103, 'IL', 'Israel', 3, n'[iv.''ʀit]|العربية', 0),
                            (104, 'IM', 'Isle of Man', 4, 'Gaelg|Gailck|English', 0),
                            (105, 'IN', 'India', 3, n'हिन्दी|English', 0),
                            (106, 'IO', 'British Indian Ocean Territory', 3, 'English', 0),
                            (107, 'IQ', 'Iraq', 3, n'العربية', 0),
                            (108, 'IR', 'Iran', 3, n'فارسی', 0),
                            (109, 'IS', 'Iceland', 4, n'íslenska', 0),
                            (110, 'IT', 'Italy', 4, n'Italiano|Francais|Deutsch|Ladin|Slovenščina', 0),
                            (111, 'JE', 'Jersey', 4, 'Francais|English|Nourmaund', 0),
                            (112, 'JM', 'Jamaica', 5, 'English', 0),
                            (113, 'JO', 'Jordan', 3, n'العربية', 0),
                            (114, 'JP', 'Japan', 3, n'日本語', 0),
                            (115, 'KE', 'Kenya', 1, 'Kiswahili|English', 0),
                            (116, 'KG', 'Kyrgyz Republic', 3, n'Кыргыз тили|русский язык', 0),
                            (117, 'KH', 'Cambodia', 3, n'ភាសាខ្មែរ', 0),
                            (118, 'KI', 'Kiribati', 6, 'te tatae ni Kiribati|English', 0),
                            (119, 'KM', 'Comoros', 1, n'العربية|shikomori', 0),
                            (120, 'KN', 'Saint Kitts and Nevis', 5, 'English', 0),
                            (121, 'KP', 'North Korea', 3, n'한국말', 0),
                            (122, 'KR', 'South Korea', 3, n'조선말', 0),
                            (123, 'KW', 'Kuwait', 3, n'العربية', 0),
                            (124, 'KY', 'Cayman Islands', 5, 'English', 0),
                            (125, 'KZ', 'Kazakhstan', 3, n'Қазақ тілі', 0),
                            (126, 'LA', 'Lao People''s Democratic Republic', 3, n'ພາສາລາວ', 0),
                            (127, 'LB', 'Lebanon', 3, n'العربية', 0),
                            (128, 'LC', 'Saint Lucia', 5, 'English', 0),
                            (129, 'LI', 'Liechtenstein', 4, 'Deutsch', 0),
                            (130, 'LK', 'Sri Lanka', 3, n'සිංහල|தமிழ்', 0),
                            (131, 'LR', 'Liberia', 1, 'English', 0),
                            (132, 'LS', 'Lesotho', 1, 'English|Sesotho', 0),
                            (133, 'LT', 'Lithuania', 4, n'Lietuvių kalba', 0),
                            (134, 'LU', 'Luxembourg', 4, n'Lëtzebuergesch|Francais|Deutsch', 0),
                            (135, 'LV', 'Latvia', 4, n'Latviešu valoda', 0),
                            (136, 'LY', 'Libya', 1, n'العربية', 0),
                            (137, 'MA', 'Morocco', 1, n'العربية|Tamazight|Francais', 0),
                            (138, 'MC', 'Monaco', 4, 'Francais', 0),
                            (139, 'MD', 'Moldova', 4, n'Română', 0),
                            (140, 'ME', 'Montenegro', 4, n'црногорски', 0),
                            (141, 'MF', 'Saint Martin', 5, 'Francais|English|Ayisyen', 0),
                            (142, 'MG', 'Madagascar', 1, 'Malagasy|Francais', 0),
                            (143, 'MH', 'Marshall Islands', 6, n'English|Kajin M̧ajeļ', 0),
                            (144, 'MK', 'Macedonia', 4, n'македонски', 0),
                            (145, 'ML', 'Mali', 1, 'Francais', 0),
                            (146, 'MM', 'Myanmar', 3, n'[mjàNmàzəgà]', 0),
                            (147, 'MN', 'Mongolia', 3, n'Монгол хэл', 0),
                            (148, 'MO', 'Macao', 3, n'粵語|Português', 0),
                            (149, 'MP', 'Northern Mariana Islands', 6, 'English|chamoru|Refalawasch', 0),
                            (150, 'MQ', 'Martinique', 5, 'Francais', 0),
                            (151, 'MR', 'Mauritania', 1, n'Francais|العربية', 0),
                            (152, 'MS', 'Montserrat', 5, 'English', 0),
                            (153, 'MT', 'Malta', 4, 'Malti|English', 0),
                            (154, 'MU', 'Mauritius', 1, 'English|Francais', 0),
                            (155, 'MV', 'Maldives', 3, 'Divehi', 0),
                            (156, 'MW', 'Malawi', 1, 'English|Chichewa', 0),
                            (157, 'MX', 'Mexico', 5, n'Español', 0),
                            (158, 'MY', 'Malaysia', 3, 'Bahasa Melayu', 0),
                            (159, 'MZ', 'Mozambique', 1, n'Português', 0),
                            (160, 'NA', 'Namibia', 1, 'English', 0),
                            (161, 'NC', 'New Caledonia', 6, 'Francais', 0),
                            (162, 'NE', 'Niger', 1, 'Francais', 0),
                            (163, 'NF', 'Norfolk Island', 6, 'English', 0),
                            (164, 'NG', 'Nigeria', 1, n'English|Hausa|Igbo|yorùbá', 0),
                            (165, 'NI', 'Nicaragua', 5, n'Español', 0),
                            (166, 'NL', 'Netherlands', 4, 'NederLands|Frison|Papiamento|English', 0),
                            (167, 'NO', 'Norway', 4, 'Norsk', 0),
                            (168, 'NP', 'Nepal', 3, n'नेपाली', 0),
                            (169, 'NR', 'Nauru', 6, 'English', 0),
                            (170, 'NU', 'Niue', 6, n'Ko e vagahau Niuē|English', 0),
                            (171, 'NZ', 'New Zealand', 6, n'English|Te Reo Māori', 0),
                            (172, 'OM', 'Oman', 3, n'العربية', 0),
                            (173, 'PA', 'Panama', 5, n'Español', 0),
                            (174, 'PE', 'Peru', 7, n'Runasimi|Español|Aymara', 0),
                            (175, 'PF', 'French Polynesia', 6, 'Francais', 0),
                            (176, 'PG', 'Papua New Guinea', 6, 'English|Tok pisin|Hiri motu', 0),
                            (177, 'PH', 'Philippines', 3, 'English|Filipino', 0),
                            (178, 'PK', 'Pakistan', 3, n'English|اردو', 0),
                            (179, 'PL', 'Poland', 4, n'Język polski', 0),
                            (180, 'PM', 'Saint Pierre and Miquelon', 5, 'Francais', 0),
                            (181, 'PN', 'Pitcairn Islands', 6, 'English', 0),
                            (182, 'PR', 'Puerto Rico', 5, n'English|Español', 0),
                            (183, 'PS', 'Palestine', 3, n'العربية', 0),
                            (184, 'PT', 'Portugal', 4, n'Português', 0),
                            (185, 'PW', 'Palau', 6, 'English|belau', 0),
                            (186, 'PY', 'Paraguay', 7, n'avañe''ẽ|Português', 0),
                            (187, 'QA', 'Qatar', 3, n'العربية', 0),
                            (188, 'RE', 'Réunion', 1, 'Francais', 0),
                            (189, 'RO', 'Romania', 4, n'Română', 0),
                            (190, 'RS', 'Serbia', 4, n'Српски|Srpski', 0),
                            (191, 'RU', 'Russian Federation', 4, n'русский язык', 0),
                            (192, 'RW', 'Rwanda', 1, 'English|Francais|Kinyarwanda', 0),
                            (193, 'SA', 'Saudi Arabia', 3, n'العربية', 0),
                            (194, 'SB', 'Solomon Islands', 6, 'English', 0),
                            (195, 'SC', 'Seychelles', 1, n'English|Francais|Créole seychellois', 0),
                            (196, 'SD', 'Sudan', 1, n'English|العربية', 0),
                            (197, 'SE', 'Sweden', 4, 'Svenska', 0),
                            (198, 'SG', 'Singapore', 3, n'English|官話|官话|Bahasa Melayu|தமிழ்', 0),
                            (199, 'SH', 'Saint Helena, Ascension and Tristan da Cunha', 1, 'English', 0),
                            (200, 'SI', 'Slovenia', 4, n'Slovenščina|Italiano|Magyar', 0),
                            (201, 'SJ', 'Svalbard & Jan Mayen Islands', 4, 'Norsk', 0),
                            (202, 'SK', 'Slovakia (Slovak Republic)', 4, n'Slovenčina', 0),
                            (203, 'SL', 'Sierra Leone', 1, 'English', 0),
                            (204, 'SM', 'San Marino', 4, 'Italiano', 0),
                            (205, 'SN', 'Senegal', 1, n'Francais|Jola|Malinké|Pular|Fulfude|Sérère|Soninké|Wolof', 0),
                            (206, 'SO', 'Somalia', 1, n'الصوماليه|العربية', 0),
                            (207, 'SR', 'Suriname', 7, 'Nederlands', 0),
                            (208, 'SS', 'South Sudan', 1, 'English', 0),
                            (209, 'ST', 'Sao Tome and Principe', 1, n'Português|Creole', 0),
                            (210, 'SV', 'El Salvador', 5, n'Español', 0),
                            (211, 'SX', 'Sint Maarten (Dutch part)', 5, 'Nederlands|English|Francais', 0),
                            (212, 'SY', 'Syrian Arab Republic', 3, n'العربية', 0),
                            (213, 'SZ', 'Swaziland', 1, 'siSwati|English', 0),
                            (214, 'TC', 'Turks and Caicos Islands', 5, 'English', 0),
                            (215, 'TD', 'Chad', 1, n'Francais|العربية', 0),
                            (216, 'TF', 'French Southern Territories', 2, 'Francais', 0),
                            (217, 'TG', 'Togo', 1, 'Francais', 0),
                            (218, 'TH', 'Thailand', 3, n'ภาษาไทย', 0),
                            (219, 'TJ', 'Tajikistan', 3, n'Тоҷикӣ|русский язык', 0),
                            (220, 'TK', 'Tokelau', 6, 'English|Tokelau', 0),
                            (221, 'TL', 'Timor-Leste', 3, n'Tetum|Português', 0),
                            (222, 'TM', 'Turkmenistan', 3, n'Türkmen dili|русский язык', 0),
                            (223, 'TN', 'Tunisia', 1, n'العربية', 0),
                            (224, 'TO', 'Tonga', 6, 'Tonguien|English', 0),
                            (225, 'TR', 'Turkey', 3, n'Türkçe', 0),
                            (226, 'TT', 'Trinidad and Tobago', 5, 'English', 0),
                            (227, 'TV', 'Tuvalu', 6, 'English|Te Nganana Tuvalu', 0),
                            (228, 'TW', 'Taiwan', 3, n'官話|官话|客家话', 0),
                            (229, 'TZ', 'Tanzania', 1, 'English|Kiswahili', 0),
                            (230, 'UA', 'Ukraine', 4, n'українська мова', 0),
                            (231, 'UG', 'Uganda', 1, 'English|Kiswahili', 0),
                            (232, 'UM', 'United States Minor Outlying Islands', 6, 'English', 0),
                            (233, 'US', 'United States of America', 5, 'English', 0),
                            (234, 'UY', 'Uruguay', 7, n'Español', 0),
                            (235, 'UZ', 'Uzbekistan', 3, n'Oʻzbek tili|русский язык', 0),
                            (236, 'VA', 'Holy See (Vatican City State)', 4, n'Italian|Deutsch|Francais|Lingua Latīna', 0),
                            (237, 'VC', 'Saint Vincent and the Grenadines', 5, 'English', 0),
                            (238, 'VE', 'Venezuela', 7, n'Español', 0),
                            (239, 'VG', 'British Virgin Islands', 5, 'English', 0),
                            (240, 'VI', 'United States Virgin Islands', 5, 'English', 0),
                            (241, 'VN', 'Vietnam', 3, n'Tiếng Việt', 0),
                            (242, 'VU', 'Vanuatu', 6, 'English|Francais|Bislama', 0),
                            (243, 'WF', 'Wallis and Futuna', 6, n'Fakaʻuvea|Fakafutuna|Francais', 0),
                            (244, 'WS', 'Samoa', 6, n'Gagana Sāmoa|English', 0),
                            (245, 'YE', 'Yemen', 3, n'العربية', 0),
                            (246, 'YT', 'Mayotte', 1, 'Francais', 0),
                            (247, 'ZA', 'South Africa', 1, 'English|Afrikaans|Nrebele|isiXhosa|isiZulu|Sesotho|Setswana|siSwati|Tsonga|Venda', 0),
                            (248, 'ZM', 'Zambia', 1, 'English', 0),
                            (249, 'ZW', 'Zimbabwe', 1, 'ChiShona|isiNdebele|English', 0),
                            (250, 'EN', 'England', 4, 'English', 1);";
                          $req = mysql_query($sql) or die (mysql_error());
                          echo 'OK';
        break;
        default:
            echo WRONGTABLENAME;
        break;
    }
?>