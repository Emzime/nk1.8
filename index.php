<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//

// define error load global lang
define('LANGNOTFOUND', '<div class="nkMarginBottom15">Fichier de langue non chargé<br />Language file not loaded</div>');
define('UNKNOWNBLOCK', 'Bloc non trouvé<br />Block not found');
define('UNKNOWNFUNCTIONBLOCK', 'La fonction suivante n\'a pas été trouvée<br />The following function has not been found');
// Define the text for error on loading lang file
define('UNKNOWLANGFILEEN', 'Error load lang file for');
define('UNKNOWLANGFILEFR', 'Erreur de chargement du fichier lang');
define('GLOBALLANGEN', 'main');
define('GLOBALLANGFR', 'principal');
define('THEMELANGEN', 'in the theme');
define('THEMELANGFR', 'dans le thème');
define('MODULELANGEN', 'in the module');
define('MODULELANGFR', 'dans le module');
define('CSSTHEMENOTFOUND', 'Le fichier css du thème');
define('CSSTHEMEMODULENOTFOUND', 'Le fichier css du module');
define('CSSTHEMEMODULENOTFOUNDS', 'dans le thème');
define('NOTFOUND', 'n\'existe pas');
define('COMPATIBILITYMODULEMODE', '<br />Le fichier css du template par defaut est utilisé');
define('DEFAUTTEMPLATEDELETED', 'n\'a pas été trouvé dans le template par defaut');
define('ANDS', 'et');

/* ---------------------------------- */
/* Start version fusion 1.8 */
/* ---------------------------------- */
define('NK_START_TIME', microtime(true));
define('INDEX_CHECK', true);
define('ROOT_PATH', dirname( __FILE__ ) .'/');

// Include configuration constants
if (file_exists('conf.inc.php')) {
    require ROOT_PATH.'conf.inc.php';
} elseif (!defined('NK_INSTALLED')) {
    if (file_exists('INSTALL/index.php')) {
        header('location: INSTALL/index.php');
        exit();
    }
}

// Kernel
require_once 'nuked.php';


/* ---------------------------------- */
/* End version fusion 1.8 */
/* ---------------------------------- */

include_once 'Includes/php51compatibility.php';
include_once 'globals.php' ;


// INCLUDE FATAL ERROR LANG
//include('Includes/fatal_errors.php');


// POUR LA COMPATIBILITE DES ANCIENS THEMES ET MODULES - FOR COMPATIBITY WITH ALL OLD MODULE AND THEME
if (defined('COMPATIBILITY_MODE') && COMPATIBILITY_MODE == TRUE) {
    extract($_REQUEST);
}

include_once 'Includes/hash.php';

if ($nuked['time_generate'] == 'on') {
    $mtime = microtime();
}

// Initialisation des variables pour le chargement des fichiers de lang
$langUpper = strtoupper($lang);
$errorLangMessage = constant('UNKNOWLANGFILE'.$langUpper);
$errorGlobalLangMessage = constant('GLOBALLANG'.$langUpper);
$errorThemeLangMessage = constant('THEMELANG'.$langUpper);
$errorModuleLangMessage = constant('MODULELANG'.$langUpper);
$loadLangGlobalFileError = '';
$loadLangModuleFileError = '';
$loadLangThemeFileError = '';
$loadCssThemeFileError = '';
$loadCssThemeFileModuleError = '';

// Chargement du fichier de lang global
if (is_file(ROOT_PATH .'lang/'.$language.'.lang.php')) {
    include_once ROOT_PATH .'lang/'.$language.'.lang.php';
} else {
    $loadLangGlobalFileError = $GLOBALS['nkTpl']->nkDisplayError($errorLangMessage.'&nbsp;'.$errorGlobalLangMessage, 'nkAlert nkAlertError');
}
// inclusion du fichier lang de nom de module personnalisé
if (is_file(ROOT_PATH .'lang/modules/'.$language.'.lang.php')) {
    include_once ROOT_PATH .'lang/modules/'.$language.'.lang.php';
} else {
    $loadLangGlobalFileError = $GLOBALS['nkTpl']->nkDisplayError($errorLangMessage.'&nbsp;'.$errorGlobalLangMessage, 'nkAlert nkAlertError');
}

// GESTION DES ERREURS SQL - SQL ERROR MANAGEMENT
//if(ini_get('set_error_handler')) set_error_handler('erreursql');
/*
$session = session_check();
$user = ($session == 1) ? secure() : array();
$session_admin = admin_check();*/


if (isset($_REQUEST['nuked_nude']) && $_REQUEST['nuked_nude'] == 'ajax') {
    if ($nuked['stats_share'] == 1) {
        $timediff = (time() - $nuked['stats_timestamp'])/60/60/24/60; // 60 Days
        if ($timediff >= 60) {
            include 'Includes/nkStats.php';
            $data = getStats($nuked);

            $string = serialize($data);

            $opts = array(
                'http' => array(
                    'method'  => "POST",
                    'content' => 'data='.$string
                )
            );

            $context     = stream_context_create($opts);
            $daurl       = 'http://stats.nuked-klan.org/';
            $retour      = file_get_contents($daurl, false, $context);
            $value_sql   = ($retour == 'YES') ? mysql_real_escape_string(time()) : 'value + 86400';

            $dbsStats    = '    UPDATE '.CONFIG_TABLE.' 
                                SET value = '.mysql_real_escape_string($value_sql).' 
                                WHERE name = "stats_timestamp"';
            $dbeStats    = mysql_query($dbsStats);
            }
    }
    die();
}

if (isset($_REQUEST['nuked_nude']) && !empty($_REQUEST['nuked_nude'])) {
    $_REQUEST['im_file'] = $_REQUEST['nuked_nude'];
} elseif (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) {
    $_REQUEST['im_file'] = $_REQUEST['page'];
} else {
    $_REQUEST['im_file'] = 'index';
}

/*if (preg_match('`\.\.`', $theme) || 
    preg_match('`\.\.`', $language) || 
    preg_match('`\.\.`', $_REQUEST['file']) || 
    preg_match('`\.\.`', $_REQUEST['im_file']) || 
    preg_match('`http\:\/\/`i', $_REQUEST['file']) || 
    preg_match('`http\:\/\/`i', $_REQUEST['im_file']) || 
    is_int(strpos( $_SERVER['QUERY_STRING'], '..' )) || 
    is_int(strpos( $_SERVER['QUERY_STRING'], 'http://' )) || 
    is_int(strpos( $_SERVER['QUERY_STRING'], '%3C%3F' ))) {
        die(WHATAREYOUTRYTODO);
}*/

// Initialisation des variables et verifications de leur type
$GLOBALS['indexRequestArray'] = array(
        'string' => array('op', 'file', 'im_file', 'nuked_nude', 'page')
    );
$GLOBALS['nkFunctions']->nkInitRequest($GLOBALS['indexRequestArray']);

$_REQUEST['file']       = basename(trim($_REQUEST['file']));
$_REQUEST['im_file']    = basename(trim($_REQUEST['im_file']));
$_REQUEST['page']       = basename(trim($_REQUEST['im_file']));

// Check Ban
//$check_ip = banip();

if (!$user) {
    $visiteur = 0;
    $_SESSION['admin'] = false;
} else {
    $visiteur = $user[1];
}

// on initialise le chargement des css
$loadCss = '';
$arrayCss = array();
if (!empty($activeCssBlock)) {
    foreach ($activeCssBlock as $indexSide => $arraySide) {
        foreach($arraySide as $keyActivedBlock){
            if (!empty($keyActivedBlock['module'])) {
                // Récupération du coté du block
                $blockSide[$keyActivedBlock['module']] = $keyActivedBlock['side'];
                // on inclu la langue du module
                if (is_file(ROOT_PATH .'modules/'.$keyActivedBlock['module'].'/lang/'.$language.'.lang.php')) {
                    include_once ROOT_PATH .'modules/'.$keyActivedBlock['module'].'/lang/'.$language.'.lang.php';
                }
                // Inclusion du Css personalisé du module depuis le theme            
                if (is_file(ROOT_PATH .'themes/'.$theme.'/css/modules/'.$keyActivedBlock['module'].'.css')) {
                    $loadCss .= '<link type="text/css" rel="stylesheet" href="themes/'.$theme.'/css/modules/'.$keyActivedBlock['module'].'.css" media="screen" />';
                } else {
                    $loadCss .= '<link type="text/css" rel="stylesheet" href="media/template/'.$nuked['defaultTemplate'].'/css/modules/'.$keyActivedBlock['module'].'.css" media="screen" />';
                }  
                $arrayCss[$keyActivedBlock['module']] = $keyActivedBlock['type']; 
            }
        }
    } 
}


// Inlusion des fichiers lang du module visualisé
if (is_file(ROOT_PATH .'modules/'.$_REQUEST['file'].'/lang/'.$language.'.lang.php')) {
    include_once ROOT_PATH .'modules/'.$_REQUEST['file'].'/lang/'.$language.'.lang.php';
} else {
    $loadLangModuleFileError = $GLOBALS['nkTpl']->nkDisplayError($errorLangMessage.'&nbsp;'.$errorModuleLangMessage.'&nbsp;'.$_REQUEST['file'] , 'nkAlert nkAlertError');
}
// Inclusion des fichiers lang pour le theme defini par l'admin
if (is_file(ROOT_PATH .'themes/'.$theme.'/lang/'.$language.'.lang.php')) {

    include_once ROOT_PATH .'themes/'.$theme.'/lang/'.$language.'.lang.php';

// si le theme n'existe pas on inclu le template par defaut
} elseif (is_file(ROOT_PATH .'media/template/'.$nuked['defaultTemplate'].'/lang/'.$language.'.lang.php')) {

    include_once ROOT_PATH .'media/template/'.$nuked['defaultTemplate'].'/lang/'.$language.'.lang.php';
// sinon on met une erreur
} else {
    $loadLangThemeFileError = $GLOBALS['nkTpl']->nkDisplayError($errorLangMessage.'&nbsp;'.$errorThemeLangMessage.'&nbsp;'.$theme, 'nkAlert nkAlertError');
}
// Regroupement des mesaage d'erreur de langue
$loadLangFileError = $loadLangGlobalFileError.$loadLangModuleFileError.$loadLangThemeFileError;


// on inclu le css du theme
if (is_file('themes/'.$theme.'/css/'.$theme.'.css')) {
    $loadCss .= '<link type="text/css" rel="stylesheet" href="themes/'.$theme.'/css/'.$theme.'.css" media="screen" />';
} elseif ($theme === $nuked['defaultTemplate']) {
    $loadCss .= '<link type="text/css" rel="stylesheet" href="media/template/'.$nuked['defaultTemplate'].'/css/'.$nuked['defaultTemplate'].'.css" media="screen" />';
} else {
    $loadCssThemeFileError = $GLOBALS['nkTpl']->nkDisplayError(CSSTHEMENOTFOUND.'&nbsp;'.$theme.'&nbsp;'.NOTFOUND, 'nkAlert nkAlertError');
}


// Inclusion du Css personalisé pour le module actif
if (is_file(ROOT_PATH .'themes/'.$theme.'/css/modules/'.$_REQUEST['file'].'.css') && !array_key_exists($_REQUEST['file'], $arrayCss)) {
    $loadCss .= '<link type="text/css" rel="stylesheet" href="themes/'.$theme.'/css/modules/'.$_REQUEST['file'].'.css" media="screen" />';
} elseif (is_file(ROOT_PATH .'media/template/'.$nuked['defaultTemplate'].'/css/modules/'.$_REQUEST['file'].'.css') && !array_key_exists($_REQUEST['file'], $arrayCss)) {
    if ($theme != $nuked['defaultTemplate']) {
        // A CHANGER POUR NOTIFICATION ADMIN
        $loadCssThemeFileModuleError .= $GLOBALS['nkTpl']->nkDisplayError(CSSTHEMEMODULENOTFOUND.'&nbsp;'.$_REQUEST['file'].'&nbsp;'.CSSTHEMEMODULENOTFOUNDS.'&nbsp;'.$theme.'&nbsp;'.NOTFOUND.COMPATIBILITYMODULEMODE, 'nkAlert nkAlertError');
    }
    $loadCss .= '<link type="text/css" rel="stylesheet" href="media/template/'.$nuked['defaultTemplate'].'/css/modules/'.$_REQUEST['file'].'.css" media="screen" />';
} else {
    // A CHANGER POUR NOTIFICATION ADMIN
    if ($theme != $nuked['defaultTemplate']) {
        $loadCssThemeFileModuleError .= $GLOBALS['nkTpl']->nkDisplayError(CSSTHEMEMODULENOTFOUND.'&nbsp;'.$_REQUEST['file'].'&nbsp;'.CSSTHEMEMODULENOTFOUNDS.'&nbsp;'.$theme.'&nbsp;'.NOTFOUND.'&nbsp;'.ANDS.'&nbsp;'.DEFAUTTEMPLATEDELETED, 'nkAlert nkAlertError');
    } else {
        $loadCssThemeFileModuleError .= $GLOBALS['nkTpl']->nkDisplayError(CSSTHEMEMODULENOTFOUND.'&nbsp;'.$_REQUEST['file'].'&nbsp;'.DEFAUTTEMPLATEDELETED, 'nkAlert nkAlertError');
    }
}


// Si le site est fermé
if ($nuked['nk_status'] == 'closed' && $user[1] < 9 && $_REQUEST['op'] != 'login_screen' && $_REQUEST['op'] != 'login_message' && $_REQUEST['op'] != 'login') {
    // on inclu le html du site fermé
    include_once ROOT_PATH .'Includes/nkSiteClosed.php';
// Sinon si on ouvre l'administration
} elseif (($_REQUEST['file'] == 'Admin' || $_REQUEST['page'] == 'admin' || (isset($_REQUEST['nuked_nude']) && $_REQUEST['nuked_nude'] == 'admin'))) {
    // on affiche la page de login administration
    if ($_SESSION['admin'] == 0) {
        include_once ROOT_PATH .'modules/Admin/login.php';
    } elseif ($_SESSION['admin'] == 1) {
        // si le module existe on l'inclu
        if (is_file( ROOT_PATH .'modules/'.$_REQUEST['file'].'/'.$_REQUEST['im_file'].'.php')) {
            include_once ROOT_PATH .'modules/'.$_REQUEST['file'].'/'.$_REQUEST['im_file'].'.php';
        // sinon on affiche le 404
        } else {
            include_once ROOT_PATH .'modules/404/index.php'; 
        }  
    }
// sinon si nous ne sommes pas en administration, que les modules ne sont pas désactivé ou que les modules ont le niveau du membre
} elseif ($levelMod > -1 && $levelMod <= $visiteur) {
    if (isset($_REQUEST['nuked_nude'])) {
        header('Content-Type: text/html;charset=utf-8');
        // si le module existe on l'inclu
        if (is_file( ROOT_PATH .'modules/'.$_REQUEST['file'].'/'.$_REQUEST['im_file'].'.php')) {
            include ROOT_PATH .'modules/'.$_REQUEST['file'].'/'.$_REQUEST['im_file'].'.php';
        // sinon on affiche le 404
        } else {
            include_once ROOT_PATH .'modules/404/index.php'; 
        }
    } else {
        // on inclu le theme     
        if ($loadLangThemeFileError == '' && $loadCssThemeFileError == '') {
/*            if (isset($_COOKIE[$GLOBALS['cookieTheme']])) {
                $theme = $_COOKIE[$GLOBALS['cookieTheme']];
            } else {
                $theme = $theme;
            }
*/
            // récupération du theme utilisateur et vérification de l'existance de celui-ci
            if (is_file(ROOT_PATH .'themes/'.$theme.'/theme.php')) { 
                // affichage du theme utilisateur si existant sinon affichage du theme admin si existant               
                include_once ROOT_PATH .'themes/'.$theme.'/theme.php';
            // sinon affichage du template par defaut
            } else {
                include_once ROOT_PATH .'/media/template/'.$nuked['defaultTemplate'].'/theme.php';
            }

        }
         // on inclu les stats de visite si elles sont actives
        if ($nuked['level_analys'] != -1) {
            visits();
        }
        // on initialise la fonction zip
        if (defined('NK_GZIP') && ini_get('zlib_output')) {
            ob_start('ob_gzhandler');
        }
        // on inclu le header
        include_once ROOT_PATH .'Includes/header.php';
        // on inclu le top du theme
        if ($loadLangThemeFileError == '' && $loadCssThemeFileError == '') {
            top();

            echo'<div id="nkGlobalModules">';
        }
        // on affiche les messages de suppression des INSTALL / UPDATE si level admin et en dehors de l'administration
        if ($visiteur == 9 && defined('TESTLANGUE')) { 
            if (is_dir(ROOT_PATH .'INSTALL/')) {
                echo $nkTpl->nkContentTag('div', REMOVEDIRINST, 'nkAlert nkAlertError nkAlignCenter');                
            }
            if (file_exists(ROOT_PATH .'install.php')) {
                echo $nkTpl->nkContentTag('div', REMOVEINST, 'nkAlert nkAlertError nkAlignCenter');                 
            }
            if (file_exists(ROOT_PATH .'update.php')) {   
                echo $nkTpl->nkContentTag('div', REMOVEUPDATE, 'nkAlert nkAlertError nkAlignCenter');      
            }
            if (isset($loadCssThemeFileModuleError)) {
                echo $loadCssThemeFileModuleError;
            }
        }
        if (!isset($GLOBALS['nkInitError'])) {
            if ($loadLangFileError == '' && $loadCssThemeFileError == '') {
                // si le module existe on l'inclu
                if (is_file( ROOT_PATH .'modules/'.$_REQUEST['file'].'/'.$_REQUEST['im_file'].'.php')) {
                    include ROOT_PATH .'modules/'.$_REQUEST['file'].'/'.$_REQUEST['im_file'].'.php';
                // sinon on affiche le 404
                } else {
                    include_once ROOT_PATH .'modules/404/lang/'.$language.'.lang.php';
                    include_once ROOT_PATH .'modules/404/index.php'; 
                }        
            } else {
                echo $loadLangFileError;
                echo $loadCssThemeFileError;
            }   
        } else { 
            echo $GLOBALS['nkInitError'];
        }
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                // on inclu le copyleft par Jquery
                $('body').append('<div id="copyleft"><a href="http://www.nuked-klan.org" target="_blank" class="nkPowered" title="<?php echo POWERED ?> Nuked-KlaN <?php echo $nuked['version']; ?> &copy; 2001, <?php echo date('Y'); ?>"></a></div>');
                // on ajout le lien pour le backToTop par Jquery
                $('body').append('<div><a id="nkToTop" class="<?php echo $nuked['nkToTopTheme']; ?>" href="#"></a></div>');
            });
        </script>
        <?php
        // on affichage le temps de génération des pages par Jquery
        if ($nuked['time_generate'] == 'on' && defined('TESTLANGUE')) {
            $mtime = microtime() - $mtime;
        ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('body').append('<p class="nkAlignCenter"><?php echo GENERATE.'&nbsp;'.$mtime.'&nbsp;'.SECONDE; ?></p>');
                });
            </script>
        <?php
        }
        
        if ($loadLangThemeFileError == '' && $loadCssThemeFileError == '') {
            echo'</div>';
            footer();
            //@todo reactive and test it when head inclusion is done
            //sendStatsNk();
        }
    }
} else {
    // récupération du theme utilisateur et vérification de l'existance de celui-ci
    if ($GLOBALS['cookieTheme'] && is_file(ROOT_PATH .'themes/'.$_COOKIE[$GLOBALS['cookieTheme']].'/theme.php')) {
        // définition du theme utilisateur si existant
        $theme = $_COOKIE[$GLOBALS['cookieTheme']];
    } else {
        // sinon définition du theme défini par l'admin
        $theme = $theme;
    }
    // vérification que le theme défini par l'admin existe
    if (is_file(ROOT_PATH .'themes/'.$theme.'/theme.php')) { 
        // affichage du theme utilisateur si existant sinon affichage du theme admin si existant               
        include_once ROOT_PATH .'themes/'.$theme.'/theme.php';                
    } else {
        // sinon affichage du template par defaut
        include_once ROOT_PATH .'/media/template/'.$nuked['defaultTemplate'].'/theme.php';
    }

    // on inclu le header
    include_once ROOT_PATH .'Includes/header.php';
    // fonction top du theme
    top();

    // affichage du message selon le niveau du visiteur
    if ($levelMod == -1) {
        echo $GLOBALS['nkTpl']->nkModuleOff();
    } elseif ($levelMod >= 1 && $visiteur == 0) {
        echo $GLOBALS['nkTpl']->nkNoLogged('|');
    } else {
        echo $GLOBALS['nkTpl']->nkBadLevel();
    }

    // fonction footer du theme
    footer();
} 

nkDB_disconnect();

/**
 * Error display
 */
if ( defined( 'NK_ERROR_DEBUG' ) && NK_ERROR_DEBUG && isset( $GLOBALS['nk_error'] ) )
{
    include ROOT_PATH .'Includes/nkDebug.php';
}

/*********************
 * TODO
 *********************/
/*
 * Rename class case NK_ (see Architecture_1.8)
 * 
/*********************
 * Informations
 *********************
 * 
 * $GLOBALS['nuked'] : array contains globals informations (date, theme,...)
            'prefix' => string : prefix of database
            'time_generate' => string : 'on' or 'off' for time generation
            'dateformat' => string : dateformat with PHP pattern (see PHP doc
            'datezone' => string : time zone
            'version' => string : version of NK.
            'date_install' => string : timestamp of installation date
            'langue' => string : used language (french, english)
            'stats_share' => string : activation of statistics ('0' if off, else 1 if is 'on')
            'stats_timestamp' => string '0' (length=1)
            'name' => string : website name
            'slogan' => string : slogan of website
         * 
            @todo : will be delete
            'tag_pre' => string 
            'tag_suf' => string 
            @todo : will be delete
         * 
            'url' => string : url of website
            'mail' => string administrator mail
            'footmessage' => string : message on footer website
            'nk_status' => string : 'open' if website is open, else 'closed'
            'index_site' => string : name of main module on website
            'theme' => string : name of default theme activated for all users
            'keyword' => string : keywords used for SEO (tag HTML)
            'description' => string : description used for SEO (tag HTML)
            'inscription' => string : if 'on', inscription is activated, else 'off'
            'inscription_mail' => string : mail send after inscription
            'inscription_avert' => string : text display before inscription
            'inscription_charte' => string : text (charte) display before inscription
            'validation' => string : status of inscription validation : 'auto', of manual
            'user_delete' => string : authorization for an user to delete or not his account ('on' or 'off')
            'video_editeur' => string : activation or no to use video editor ('on' or 'off')
            'scayt_editeur' => string 'on' (length=2)
            'suggest_avert' => string '' (length=0)
            'irc_chan' => string 'nuked-klan' (length=10)
            'irc_serv' => string 'quakenet.org' (length=12)
            'server_ip' => string '' (length=0)
            'server_port' => string '' (length=0)
            'server_pass' => string '' (length=0)
            'server_game' => string '' (length=0)
            'forum_title' => string '' (length=0)
            'forum_desc' => string '' (length=0)
            'forum_rank_team' => string 'off' (length=3)
            'forum_field_max' => string '10' (length=2)
            'forum_file' => string 'on' (length=2)
            'forum_file_level' => string '1' (length=1)
            'forum_file_maxsize' => string '1000' (length=4)
            'thread_forum_page' => string '20' (length=2)
            'mess_forum_page' => string '2' (length=1)
            'hot_topic' => string '20' (length=2)
            'post_flood' => string '10' (length=2)
            'gallery_title' => string '' (length=0)
            'max_img_line' => string '2' (length=1)
            'max_img' => string '6' (length=1)
            'max_news' => string '5' (length=1)
            'max_download' => string '10' (length=2)
            'hide_download' => string 'on' (length=2)
            'max_liens' => string '10' (length=2)
            'max_sections' => string '10' (length=2)
            'max_wars' => string '30' (length=2)
            'max_archives' => string '30' (length=2)
            'max_members' => string '30' (length=2)
            'max_shout' => string '20' (length=2)
            'mess_guest_page' => string '10' (length=2)
            'sond_delay' => string '24' (length=2)
            'level_analys' => string '-1' (length=2)
            'visit_delay' => string '10' (length=2)
            'recrute' => string '1' (length=1)
            'recrute_charte' => string '' (length=0)
            'recrute_mail' => string '' (length=0)
            'recrute_inbox' => string '' (length=0)
            'defie_charte' => string '' (length=0)
            'defie_mail' => string '' (length=0)
            'defie_inbox' => string '' (length=0)
            'birthday' => string 'all' (length=3)
            'avatar_upload' => string 'on' (length=2)
            'avatar_url' => string 'on' (length=2)
            'cookiename' => string 'nuked' (length=5)
            'sess_inactivemins' => string '5' (length=1)
            'sess_days_limit' => string '365' (length=3)
            'nbc_timeout' => string '300' (length=3)
            'screen' => string 'on' (length=2)
            'contact_mail' => string 'admin@admin.com' (length=15)
            'contact_flood' => string '60' (length=2)
 * 
 * $GLOBALS['language'] : user language defined
 * 
 * $GLOBALS['user'] : user informations
        [0] = ID visitor
        [1] = user level
        [2] = pseudo
        [3] = IP address
        [4] = number of new messages unread
 
 * $GLOBALS['user_ip'] : IP address user
 * $GLOBALS['nkTpl'] : light template library
 * $GLOBALS['nuked']['stats_share']
 */
?>
