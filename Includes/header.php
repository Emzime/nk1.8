<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
    <head>
        <meta name="keywords" content="<?php echo $nuked['keyword'] ?>" />
        <meta name="Description" content="<?php echo $nuked['description'] ?>" />
        <meta charset="UTF-8" />
        <title><?php echo $nuked['name'] ?> - <?php echo $nuked['slogan'] ?></title>                        
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />

        <!-- Chargement des Css -->
        <link rel="stylesheet" type="text/css" href="media/css/nkResetCss.css" />
        <link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" media="screen" />
        <link type="text/css" rel="stylesheet" href="media/css/nkTooltipSter.css" media="screen" />
        <link type="text/css" rel="stylesheet" href="media/css/nkCss.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="media/css/shadowbox.css">

        <?php
        // on inclu le css du theme
        if (is_file('themes/'.$theme.'/css/'.$theme.'.css')) {
        ?>
        <link type="text/css" rel="stylesheet" href="themes/<?php echo $theme; ?>/css/<?php echo $theme; ?>.css" media="screen" />
        <?php
        } else {
        // si le theme n'existe pas on inclu le template d'origine
        ?>
            <link type="text/css" rel="stylesheet" href="media/template/<?php echo $theme; ?>/css/<?php echo $theme; ?>.css" media="screen" />
        <?php
        }
        ?>
        <!-- Chargement des Js -->    
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="media/js/nkPopupBox.js"></script>
        <script type="text/javascript" src="media/js/nkTotop.js"></script>
        <script type="text/javascript" src="media/js/menuUser.js"></script>
        
        <script type="text/javascript" src="media/js/nkTooltipPlugin.js"></script>
        <script type="text/javascript" src="media/js/nkTooltipConfig.js"></script>

        <!-- A VOIR POUR L INTEGRATION AUTOMATIQUE -->
        <script type="text/javascript" src="media/template/<?php echo $theme; ?>/js/menu.js"></script>
        <script type="text/javascript" src="media/template/<?php echo $theme; ?>/js/sliderConfig.js"></script>
        <script type="text/javascript" src="media/template/<?php echo $theme; ?>/js/slider.js"></script>
        
        <script type="text/javascript" src="media/js/shadowbox.js"></script>
        <script type="text/javascript">
            Shadowbox.init();
        </script>
        <?php

        echo includeJsTheme();

        // Chargement des css pour module et block de modules
        echo $loadCss;
        ?>
    </head>