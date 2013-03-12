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
        <!-- Chargement des Js -->    
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="media/js/nkPopupBox.js"></script>
        <script type="text/javascript" src="media/js/nkTotop.js"></script>
        <script type="text/javascript" src="media/js/nkTooltipPlugin.js"></script>
        <script type="text/javascript" src="media/js/nkTooltipConfig.js"></script>
        <script type="text/javascript" src="media/js/menuUser.js"></script>
        <script type="text/javascript" src="media/js/shadowbox.js"></script>
        <script type="text/javascript">
            Shadowbox.init();
        </script>        
        <?php
        if ($theme === $nuked['defaultTemplate']) {
        ?>
            <link type="text/css" rel="stylesheet" href="media/template/<?php echo $nuked['defaultTemplate']; ?>/css/<?php echo $nuked['defaultTemplate']; ?>.css" media="screen" />
            <script type="text/javascript" src="media/template/<?php echo $nuked['defaultTemplate']; ?>/js/menu.js"></script>
            <script type="text/javascript" src="media/template/<?php echo $nuked['defaultTemplate']; ?>/js/sliderConfig.js"></script>
            <script type="text/javascript" src="media/template/<?php echo $nuked['defaultTemplate']; ?>/js/slider.js"></script>
        <?php
        } else {
            echo includeJsTheme();
        }
        // Chargement des css pour module et block de modules
        echo $loadCss;
        ?>
    </head>