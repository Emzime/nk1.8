<?php

    defined('INDEX_CHECK') or die ('<div style="text-align: center;">Access deny</div>');  
    // nombre de match a accficher dans le block unique
    $nbResultWars = 5;
    
    // activation blocks uniques
    $activeWars      = 1;
    $activePartners  = 1;
    $activeSlider    = 1;

    // menu en upperCase
    $activeUpperCase = 0;

    // Menu
    $menuName[0] = 'Acceuil';
    $menuLink[0] = 'index.php';
    
    $menuName[1] = 'Membres';
    $menuLink[1] = 'index.php?file=Members';
    
    $menuName[2] = 'Team';
    $menuLink[2] = 'index.php?file=Team';
    
    $menuName[3] = 'Forums';
    $menuLink[3] = 'index.php?file=Forum';

    // Sous menu
    $menuSubName[0][0] = 'index';
    $menuSubName[0][1] = 'Compte';
    $menuSubName[0][2] = 'Textbox';
    $menuSubLink[0][0] = 'index.php';
    $menuSubLink[0][1] = 'index.php?file=User';
    $menuSubLink[0][2] = 'index.php?file=Textbox';

    $menuSubName[1][0] = 'Tout les membres';
    $menuSubLink[1][0] = 'index.php?file=Members';

    // Partenaires
    $partnersName[0] = 'nitroServ.png';
    $partnersLink[0] = 'http://www.nitroserv.com/fr/';
    $partnersName[1] = 'redHeberg.png';
    $partnersLink[1] = 'http://www.redheberg.com';
    $partnersName[2] = 'gamingStore.png';
    $partnersLink[2] = 'http://www.gaming-store.net';

    // Reseau solcial
    $tsLink       = 'ts3server://ts3.nuked-klan.org';
    $rssLink      = 'index.php?file=Rss';
    $twitterLink  = 'http://www.twitter.com/nuked_klan';
    $googleLink   = 'http://gplus.to/nukedklan';
    $steamLink    = 'http://steamcommunity.com/groups/nuked_klan';
    $facebookLink = 'http://www.facebook.com/pages/Nuked-Klan/184377914930941';

?>