<?php
/**
 * Template nk18Gamers
 * Design by Gigoss
 * Coded by Maxxi
 * For Nuked-Klan http://www.nuked-klan.org
 */
    defined("INDEX_CHECK") or die ("<div style=\"text-align: center;\">Accès interdit</div>");

    require_once 'media/template/'.$theme.'/admin/moduleComplet.php';
    $moduleComplet = explode('|', $config['complet']);
    foreach ($moduleComplet as $moduleComplet){
            $complet[$moduleComplet] = $moduleComplet;
    }
    if (!isset($complet[$_REQUEST['file']])) {
        $complet[$_REQUEST['file']] = null;
    }

    if ($_REQUEST['file'] != $complet[$_REQUEST['file']] && $_REQUEST['page'] != "admin") {  
        $bgComplet = "RL_content";
        $mainCenter = "RL_mainCenter";
    } else {
        $bgComplet = "RL_contentComplet";
        $mainCenter = "RL_mainCenterComplet";
    }

    include dirname(__FILE__) . '/admin/config.php';
    include_once dirname(__FILE__) . '/blocks/menu.php';
    include_once dirname(__FILE__) . '/blocks/wars.php';
    include_once dirname(__FILE__) . '/blocks/partners.php';

function top() {
    global $nuked, $user, $language, $theme, $cookie_langue, $complet, $bgComplet, $mainCenter, $linkSubMenu, $rssLink, $facebookLink, $twitterLink, $googleLink, $steamLink, $tsLink, $activeSlider, $linkMenu, $activeWars, $activePartners;

    // Vérifie si les liens existe sur les reseaux sociaux
    if ($rssLink      == '') { $visibilityRss = 'nkNone'; } else { $visibilityRss = '';}
    if ($facebookLink == '') { $visibilityFac = 'nkNone'; } else { $visibilityFac = '';}
    if ($twitterLink  == '') { $visibilityTwi = 'nkNone'; } else { $visibilityTwi = '';}
    if ($googleLink   == '') { $visibilityGoo = 'nkNone'; } else { $visibilityGoo = '';}
    if ($steamLink    == '') { $visibilitySte = 'nkNone'; } else { $visibilitySte = '';}
    if ($tsLink       == '') { $visibilityTs3 = 'nkNone'; } else { $visibilityTs3 = '';}

    // Vérifie si le visiteur est enregistré
    if ($user) {
        $htmlLang = '<span id="changeLanguage" class="nkAlignRight">                            
                        <form method="post" action="index.php?file=User&amp;nuked_nude=index&amp;op=modifLang">
                            <select class="nkInput" name="userLang" onchange="submit();">
                                <option value="">'.LANGUAGE.'</option>';
                                if ($rep = @opendir('lang/')) {
                                    while (false !== ($f = readdir($rep))) {
                                        if ($f != '..' && $f != '.' && $f != 'index.html' && $f != 'modules') {
                                            list($langfile, ,) = explode ('.', $f);
                                            
                                            if ($cookie_langue == $langfile) {
                                                $checked = 'selected="selected"';
                                            } else {
                                                $checked = '';
                                            }

                                            $htmlLang .= '<option value="'.$langfile.'" '.$checked.'>'.$langfile.'</option>';
                                        }
                                    }
                                    closedir($rep);
                                    clearstatcache();
                                }
                            $htmlLang .= '</select>
                        </form>
                    </span>';
    } else {
        $htmlLang = '';
    }

    // Vérifie si le slider est actif
    if ($activeSlider == 1) {  

        $slideFile = 'media/template/'.$theme.'/images/slide';         
        $htmlSlider = ' <figure id="coin-slider" class="coin-slider">';
                            if ($handle = opendir($slideFile)) {
                                while (false !== ($slider = readdir($handle))) {
                                    if ($slider != "." && $slider != ".." && $slider != "index.html" && $slider != "index.htm" && $slider != "index.php") {
                                        $htmlSlider .= '<img src="'.$slideFile.'/'.$slider.'" alt="" />';
                                    }
                                }
                                closedir($handle); 
                            }              
        $htmlSlider .= '</figure>';

    } else {                    
        $htmlSlider = '<figure id="coin-slider">
                            <div><img id="logo" class="nkBlock" src="media/template/'.$theme.'/images/logo.png" alt="" /></div>
                        </figure>';    
    }
?>
    <body>
        <div id="RL_mainWrapper" class="nkTextCollapse nkBlock">
            <header id="RL_header"></header>
            <nav id="RL_mainNav" class="nkValignTop">
                <div id="RL_mainMenu" class="nkInlineBlock nkValignTop">
                    <span id="RL_mainMenuLeft" class="nkInlineBlock"></span>
                    <ul id="RL_mainMenuCenter" class="nkInlineBlock nkValignTop">
                        <?php echo $linkMenu; ?>
                    </ul>
                </div>
                <span id="menuRight" class="nkInlineBlock"></span>
                <?php include 'blocks/login.php'; ?>
                <span id="loginRight" class="nkInlineBlock"></span>
                <span id="loginExtraPx" class="nkInlineBlock"></span>
                <div id="loginExtra" class="nkInlineBlock">
                    <div id="social">
                        <div id="social_cache"></div>
                        <div class="social_container <?php echo $visibilityRss; ?>">
                            <a class="nkBlock" id="rss" title="<?php echo FLUXRSS; ?>" href="<?php echo $rssLink; ?>"></a>
                        </div>
                        <div class="social_container <?php echo $visibilityFac; ?>">
                            <a class="nkBlock" id="facebook" title="<?php echo FACEBOOK; ?>" href="<?php echo $facebookLink; ?>" target="_blank"></a>
                        </div>
                        <div class="social_container <?php echo $visibilityTwi; ?>">
                            <a class="nkBlock" id="twitter" title="<?php echo TWITTER; ?>" href="<?php echo $twitterLink; ?>" target="_blank"></a>
                        </div>
                        <div class="social_container <?php echo $visibilityGoo; ?>">
                            <a class="nkBlock" id="google" title="<?php echo GOOGLE; ?>" href="<?php echo $googleLink; ?>" target="_blank"></a>
                        </div>
                        <div class="social_container <?php echo $visibilitySte; ?>">
                            <a class="nkBlock" id="steam" title="<?php echo STEAM; ?>" href="<?php echo $steamLink; ?>" target="_blank"></a>
                        </div>
                        <div class="social_container <?php echo $visibilityTs3; ?>">
                            <a class="nkBlock" id="ts3" title="<?php echo TEAMSPEAK; ?>" href="<?php echo $tsLink; ?>" target="_blank"></a>
                        </div>
                    </div>
                </div>
            </nav>
            <div id="RL_global" class="nkTextCollapse">
                <section id="<?php echo $bgComplet; ?>" class="nkTextCollapse td">
                    <nav id="RL_subNav" class="nkInlineBlock">
                        <?php 
                            // affichage sous menu
                            echo $linkSubMenu; 
                            // affichage option langue
                            echo $htmlLang;
                        ?>
                    </nav>  
                    <?php
                        // affichage du slider ou de la banniere
                        echo $htmlSlider;

                        // Verifie si le page demandée affiche les blocks droite
                        if ($_REQUEST['file'] != $complet[$_REQUEST['file']] && $_REQUEST['page'] != "admin") {                            
                        ?>
                            <aside id="RL_blockLeft" class="nkInlineBlock nkValignTop">
                                <?php echo getBlok('Left'); ?>
                            </aside>
                        <?php
                        }
                    ?>
                    <section id="<?php echo $mainCenter; ?>" class="nkInlineBlock nkValignTop">

                        <?php 
                        // Verifie si le page demander affiche les blocks centre
                        if ($_REQUEST['file'] != $complet[$_REQUEST['file']] && $_REQUEST['page'] != "admin") {
                            if (!is_null(getBlok('Center'))) {
                                echo getBlok('Center');
                            }
                        }
}

function footer() {
    global $nuked, $theme, $language, $complet, $footerMenu, $activeWars, $activePartners, $htmlPartners, $htmlWars, $htmlUnikWars;

    // Vérifie si le bock match est actif
    if ($activeWars == 0 && $activePartners == 0) {
        $htmlUnikWars = '<header id="headerUnikWars"></header>';
    }
?>
                        <?php 
                        // Verifie si le page demander affiche les blocks bas
                        if ($_REQUEST['file'] != $complet[$_REQUEST['file']] && $_REQUEST['page'] != "admin") {
                            if (!is_null(getBlok('Bottom'))) {
                                echo getBlok('Bottom'); 
                            }
                        }
                        ?>
                    </section>
                </section>
                <aside id="RL_mainBlockRight" class="nkValignTop">                        
                    <?php
                    // block Last Wars 
                    if ($activeWars == 1) {
                        echo $htmlWars;
                    }
                    // block Partners
                    if($activePartners == 1) {
                        echo $htmlPartners;
                    }
                    ?>
                    <section class="RL_blockRight">
                        <?php 
                        // changement de header si block War désactivé
                        echo $htmlUnikWars;

                        echo getBlok('Right'); 
                        ?>
                    </section>
                </aside>
                <footer id="RL_footer" class="nkInlineBlock nkTextCollapse">
                    <a href="http://www.nuked-klan.org" target="_blank" title="<?php echo VISITNK; ?>">
                        <span id="footerLeft" class="nkInlineBlock"></span>
                    </a>
                    <div id="footerCenter" class="nkInlineBlock nkValignTop">
                        <div id="footerCenterTop">
                            <div class="footerFiltre">
                                <h3>Navigation</h3>
                                <nav>
                                    <ul>
                                        <?php echo $footerMenu; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div id="footerCenterBottom">
                            <div class="footerFiltre">
                                <div id="footerCenterBottomLeft" class="nkInlineBlock nkValignTop nkAlignCenter">&copy; copyright <?php echo date('Y'); ?> - <?php echo ALLRIGHT; ?> - <?php echo $nuked['name']; ?></div>
                                <div id="footerCenterBottomCenter" class="nkInlineBlock"></div>
                                <div id="footerCenterBottomRight" class="nkInlineBlock nkValignTop nkAlignCenter"><?php echo POWERED; ?>&nbsp;<a href="http://www.nuked-klan.org/" target="_blank" title="<?php echo VISITNK; ?>">Nuked-Klan</a></div>
                            </div>
                        </div>
                    </div>
                    <span id="footerRight" class="nkInlineBlock"></span>
                </footer> 
                <aside id="deathZone" class="nkInlineBlock"></aside>       
            </div>
            <div id="footerHalo" class="nkInlineBlock nkAlignCenter nkValignTop"></div>
        </div>
    </body>
</html>
<?php
}   

function news($data) {
    global $complet;

    if ($data['nbComment'] == 0) {
        $s = '';
        $titleCom = POSTCOMMENT;
    } elseif ($data['nbComment'] > 1) {
        $s = 's';
        $titleCom = SEECOMMENT;
    } else {
        $s = '';
        $titleCom = SEECOMMENT;
    }

    $authorAvatar = '<a href="'.$data['authorUrl'].'"><img src="'.$data['authorAvatar'].'" alt="" title="'.$data['author'].'" /></a>'; 

    if ($data['authorAvatar'] == "") {
        $authorAvatar = '<img src="images/noavatar.png" alt="" title="" />';
    }  
    $comment      = '<a href="'.$data['linkComment'].'" title="'.$titleCom.'">'.$data['nbComment'].'&nbsp;'.COMMENTS.$s.'</a>&nbsp;'.$data['readMore'];
    $posted       = POSTEDBY.'&nbsp;'.$data['date'];
    $print        = $data['printPage'];
    $sendFriend   = $data['friend'];

    if ($_REQUEST['file'] != $complet[$_REQUEST['file']]) {
        $headerCenter     = 'headerCenter';
        $newsComplet      = 'news';
        $headerBlockNews  = 'headerBlockNews';
        $contentBlockNews = 'contentBlockNews';
        $authorContent    = '';
        $content          = 'content';
        $newsTitle        = 'newsTitle';
        $postedNews       = 'postedNews';
    } else {
        $headerCenter     = 'headerCenterComplet';
        $newsComplet      = 'newsComplet';
        $headerBlockNews  = 'headerBlockNewsComplet';
        $contentBlockNews = 'contentBlockNewsComplet';
        $authorContent    = 'authorContent';
        $content          = 'contentComplet';
        $newsTitle        = 'newsTitleComplet';
        $postedNews       = 'postedNewsComplet';
    }

?> 

    <div id="<?php echo $headerCenter; ?>"><?php echo ACTUALITY; ?></div>
    <section class="<?php echo $content; ?> nkTextCollapse">
        <article class="<?php echo $newsComplet; ?> table">
            <figure class="imgCategory nkInlineBlock nkTextCollapse"><?php echo $data['catImage']; ?>
                <figcaption class="imgCategoryCaption"></figcaption>
            </figure>
            <header class="<?php echo $headerBlockNews; ?> nkInlineBlock nkValignTop">
                <h3 class="<?php echo $newsTitle; ?> nkInlineBlock nkValignTop nkNoMargin">
                    <?php echo $data['title']; ?>
                </h3>
                <div class="nkInlineBlock nkAlignRight <?php echo $authorContent; ?>">
                    <figure class="nkInlineBlock nkNoMargin nkNoPadding authorAvatar">
                        <?php echo $authorAvatar; ?>
                    </figure>
                </div>
                <div class="<?php echo $postedNews; ?>">
                    <?php echo $posted; ?>
                </div>
            </header>
            <article class="<?php echo $contentBlockNews; ?> nkPadding">
                <?php echo $data['content']; ?>
            </article>
            <footer class="footerBlockNews nkPadding nkAlignRight">
                <?php echo $comment; ?>
            </footer>
        </article>
        <!-- <div class="newsR"></div> -->
    </section>
<?php
}

function blockLeft($block) {
?>
    <header class="headerBlockLeft">
        <?php echo $block['title']; ?>
    </header>
    <article class="centerBlockLeft nkPadding">
        <?php echo $block['content']; ?>
    </article>
    <footer class="footerBlockLeft"></footer>
<?php
}

function blockRight($block) {
    global $activeWars, $activePartners;

?>
    <header class="headerBlockRight">
        <?php echo $block['title']; ?>
    </header>
    <article class="contentBlockRight nkPadding">
        <?php echo $block['content']; ?>
    </article>
<?php
    
}

function blockCenter($block) {
?>
    <section id="RL_blockCenter" class="nkValignTop">
        <header class="headerBlockCenter nkInlineBock nkValignCenter">
            <?php echo $block['title']; ?>
        </header>
        <article class="contentBlockCenter nkPadding">
            <?php echo $block['content']; ?>
        </article>
    </section>
<?php
}

function blockBottom($block) {
?>
    <section id="RL_blockCenter" class="nkValignTop">
        <header class="headerBlockCenter nkInlineBock nkValignCenter">
            <?php echo $block['title']; ?>
        </header>
        <article class="contentBlockCenter nkPadding">
            <?php echo $block['content']; ?>
        </article>
    </section><?php
}


?>