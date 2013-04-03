<?php
/**
*   Users module
*   Display / Create account
*
*   @version 1.8
*   @link http://www.nuked-klan.org Clan Management System 4 Gamers NK CMS
*   @license http://opensource.org/licenses/gpl-license.php GNU Public License
*   @copyright 2001-2013 Nuked Klan 
*/
defined('INDEX_CHECK') or die ('<div class="nkAlignCenter">'.CANTOPENPAGE.'</div>');
global $user, $visiteur, $levelMod, $cookieCaptcha;
$modName = basename(dirname(__FILE__));

// Vérification des variables
$requestArray = array(
    'integer' => array('error', 'codeConfirm', 'p'),
    'uniqid'  => array('userId'),
    'boolean' => array('captcha', 'refere', 'userReg'),
    'string'  => array('rememberMe', 'pseudo', 'letter', 'op')
);
$GLOBALS['nkFunctions']->nkInitRequest($requestArray, $GLOBALS['indexRequestArray']);
if (!isset($GLOBALS['nkInitError'])) {
    $langTest = strtoupper($modName);
    $langTest = constant('TESTLANGUEFILE'.$langTest);
    if($langTest == true) {
        include_once('Includes/nkCaptcha.php');
        include_once('Includes/hash.php');
        if (NKCAPTCHA == 'off') {
            $captcha = 0;
        } elseif ((NKCAPTCHA == 'auto' OR NKCAPTCHA == 'on') && $visiteur > 0)  {
            $captcha = 0;
        } else {
            $captcha = 1;
        }

        $modulePref = $GLOBALS['nkFunctions']->nkModsPrefs($modName);
        // $forumPref = $GLOBALS['nkFunctions']->nkModsPrefs('Forum');

        function index() {
            global $user, $nuked, $modName, $modulePref;

            // orderSelect a faire
            $orderSelect = MYINFO;

            if ($user) {
                $dbsUserInfo = 'SELECT U.pseudo, U.website, U.privateMail, U.publicMail, U.created, U.avatar, U.countForum, U.countComment, U.countSuggest, S.lastUsed, U.countVisitor, U.lastVisitor,
                                    ( 
                                        SELECT count( id )
                                        FROM '.USERBOX_TABLE.'
                                        WHERE userFor = "'.$user[0].'" AND status = 1 
                                    )  AS nbMessRead,
                                    (
                                        SELECT uct.name
                                        FROM '.CONTINENTS_TABLE.' AS uct
                                        LEFT JOIN '.COUNTRY_TABLE.' AS ct ON ct.name = "'.$user[8].'"
                                        WHERE uct.id = ct.continentId
                                    ) AS userContinent
                                FROM '.USER_TABLE.' AS U 
                                LEFT JOIN '.SESSIONS_TABLE.' AS S ON U.id = S.userId 
                                WHERE U.id = "'.$user[0].'"';
                $dbeUserInfo = mysql_query($dbsUserInfo);
                $userData    = mysql_fetch_array($dbeUserInfo);

                $nbMessRead     = $userData['nbMessRead'];
                $nbComment      = $userData['countComment'];
                $nbSuggest      = $userData['countSuggest'];  
                $nbForumMessage = $userData['countForum']; 
                $nbVisitor      = $userData['countVisitor']; 
                $continent      = $userData['userContinent']; 

                // initialisation
                $msgForum    = '';
                $commentUser = '';
                $suggestUser = '';
                $myFriends   = '';

                if ($myFriends == '') {
                    $myFriends = '<div class="nkAlignCenter">'.NOFRIENDS.'</div>';
                }

                // affichage des messages forums
                if ($nbForumMessage == 0) {
                    $msgForum = '<div class="nkAlignCenter">'.NOUSERMESS.'</div>';
                } else {
                    $dbsMessageInfo = ' SELECT F.id AS messId , F.title AS messTitle, F.content , F.created AS messCreated, F.threadId, F.forumId
                                        FROM '.FORUM_MESSAGES_TABLE.' AS F 
                                        WHERE autorId = "'.$user['0'].'"
                                        ORDER BY created DESC LIMIT '.$modulePref['nbForumMessage'];
                    // echo $dbsMessageInfo;
                    $dbeMessageInfo = mysql_query($dbsMessageInfo);
                    while (list($messId, $messTitle, $content, $messCreated, $threadId, $forumId) = mysql_fetch_array($dbeMessageInfo)) {

                        $subject = printSecuTags($messTitle);
                        $subject = nk_CSS($subject);
                        $date = nkDate($messCreated);

                        //////////// A VOIR (mess_forum_page) CE SONT DES PREFERENCE DU MODULE FORUM ///////////
                        if ($nbForumMessage > $nuked['mess_forum_page']) { // $forumPref[''];
                            $topicpages = $nbForumMessage / $nuked['mess_forum_page'];
                            $topicpages = ceil($topicpages);
                            $linkMessage = 'index.php?file=Forum&amp;page=viewtopic&amp;forumId='.$forumId.'&amp;threadId='.$threadId.'&amp;p='.$topicpages.'#'.$messId;
                        } else {
                            $linkMessage = 'index.php?file=Forum&amp;page=viewtopic&amp;forumId='.$forumId.'&amp;threadId='.$threadId.'#'.$messId;
                        }
                        $msgForum .= '  <article class="profilMessageForum">
                                            <span class="profilMessageTitle nkBlock">'.INSUBJECT.'&nbsp;:&nbsp;<a href="'.$linkMessage.'"">'.$subject.'</a></span>
                                            <span class="profilMessageDate nkBlock">'.POSTEDTHE.'&nbsp;:&nbsp;'.$date.'</span>
                                            <p class="profilMessageContent nkBlock">'.$content.'</p>
                                        </article>';
                    }
                }

                if ($userData['lastUsed'] > 0) {
                    $lastUsed = nkDate($userData['lastUsed'], TRUE);
                } else {
                    $lastUsed = UNKNOW;
                }
                if ($userData['website']) {
                    $website = $userData['website'];
                } else {
                    $website = UNKNOW;
                }
                if ($userData['avatar']) {
                    $avatar = checkimg($userData['avatar']);
                } else {
                    $avatar = 'images/noavatar.png';
                }
                if ($userData['privateMail']) {
                    $privateMail = $userData['privateMail'];
                } else {
                    $privateMail = UNKNOW;
                }
                if ($userData['publicMail']) {
                    $publicMail = $userData['publicMail'];
                } else {
                    $publicMail = UNKNOW;
                }
                if ($user[5] > 0) {
                    $S = '';
                    if ($user[5] > 1) { 
                        $S = 's';
                    }
                    $msgNotRead = '<a class="link" href="profilUserBox">'.$user[5].'&nbsp;'.MESSAGES.$S.'</a>';
                } else {
                    $msgNotRead = $user[5].'&nbsp;'.MESSAGES;
                }
                if ($nbMessRead > 0) {
                    $S = '';
                    if ($nbMessRead > 1) { 
                        $S = 's';
                    }
                    $nbMessRead = '<a class="link" href="profilUserBox">'.$nbMessRead.'&nbsp;'.MESSAGES.$S.'</a>';
                } else {
                    $nbMessRead = $nbMessRead.'&nbsp;'.MESSAGES;
                }
                if ($nbVisitor > 0) {
                    $nbVisitor = '<a class="link" href="profilVisitor">'.$nbVisitor.'&nbsp;'.TIMES.'</a>';
                } else {
                    $nbVisitor = $nbVisitor.'&nbsp;'.TIMES;
                }
                if ($nbForumMessage > 0) {
                    $S = '';
                    if ($nbForumMessage > 1) { 
                        $S = 's';
                    }
                    $nbForumMessage = '<a class="link" href="profilForum">'.$nbForumMessage.'&nbsp;'.MESSAGES.$S.'</a>';
                } else {
                    $nbForumMessage = $nbForumMessage.'&nbsp;'.MESSAGES;
                }
                if ($nbComment > 0) {
                    $S = '';
                    if ($nbComment > 1) { 
                        $S = 's';
                    }
                    $nbComment = '<a class="link" href="profilComment">'.$nbComment.'&nbsp;'.COMMENTED.$S.'</a>';

                    $dbsCommentInfo = ' SELECT id, title, content, module, created
                                        FROM '.COMMENT_TABLE.'
                                        WHERE autorId = "'.$user['0'].'"
                                        ORDER BY created DESC LIMIT '.$modulePref['nbComment'];
                    $dbeCommentInfo = mysql_query($dbsCommentInfo);
                    while (list($commentId, $commentTitle, $commentContent, $module, $created) = mysql_fetch_array($dbeCommentInfo)) {
                        $commentTitle = printSecuTags($commentTitle);
                        $commentTitle = nk_CSS($commentTitle);
                        $date = nkDate($created, TRUE);

                        if ($commentTitle != "") {
                            $title = $commentTitle;
                        } else {
                            $title = $module;
                        }

                        // A FAIRE
                        if ($module == "News") {
                            $linkTitle = '<a href="index.php?file=News&amp;op=index_comment&amp;id='.$commentId.'">'.$title.'</a>';
                        } elseif ($module == "Gallery") {
                            $linkTitle = '<a href="index.php?file=Gallery&amp;op=description&amp;id='.$commentId.'">'.$title.'</a>';
                        } elseif ($module == "Wars") {
                            $linkTitle = '<a href="index.php?file=Wars&amp;op=detail&amp;id='.$commentId.'">'.$title.'</a>';
                        } elseif ($module == "Links") {
                            $linkTitle = '<a href="index.php?file=Links&amp;op=description&amp;id='.$commentId.'">'.$title.'</a>';
                        } elseif ($module == "Downloads") {
                            $linkTitle = '<a href="index.php?file=Download&amp;op=description&amp;idItem='.$commentId.'">'.$title.'</a>';
                        } elseif ($module == "Survey") {
                            $linkTitle = '<a href="index.php?file=Survey&amp;op=affich_res&amp;id='.$commentId.'">'.$title.'</a>';
                        } elseif ($module == "Sections") {
                            $linkTitle = '<a href="index.php?file=Sections&amp;op=article&amp;id='.$commentId.'">'.$title.'</a>';
                        } else {
                            $linkTitle = '';
                        }

                        $commentUser .='<article class="profilMessageComment">
                                            <span class="profilMessageTitle nkBlock">'.INSUBJECT.'&nbsp;:&nbsp;'.$linkTitle.'</span>
                                            <span class="profilMessageDate nkBlock">'.POSTEDTHE.'&nbsp;:&nbsp;'.$date.'</span>
                                            <p class="profilMessageContent nkBlock">'.$commentContent.'</p>
                                        </article>';
                    }
                } else {
                    $nbComment   = $nbComment.'&nbsp;'.COMMENTED;
                    $commentUser = '<div class="nkAlignCenter">'.NOUSERCOMMENT.'</div>';
                }

                // A FAIRE
                if ($nbSuggest > 0) {
                    $S = '';
                    if ($nbSuggest > 1) { 
                        $S = 's';
                    }
                    $nbSuggest = '<a class="link" href="profilSuggest">'.$nbSuggest.'&nbsp;'.SUGGESTED.$S.'</a>';
                    $suggestUser .='<article class="profilMessageSuggest">
                                        <span class="profilMessageTitle nkBlock">'.INSUBJECT.'&nbsp;:&nbsp;'.$linkTitle.'</span>
                                        <span class="profilMessageDate nkBlock">'.POSTEDTHE.'&nbsp;:&nbsp;'.$date.'</span>
                                        <p class="profilMessageContent nkBlock">'.$suggestContent.'</p>
                                    </article>';
                } else {
                    $nbSuggest = $nbSuggest.'&nbsp;'.SUGGESTED;
                    $suggestUser = '<div class="nkAlignCenter">'.NOUSERSUGGEST.'</div>';
                }

                if ($modulePref['activeTheme'] == 'on') {
                    $activeThemeLink = '<li><a href="profilThemes">'.THEMESELECT.'</a></li>';
                    $activeThemeHtml = '<div id="profilThemes" class="profilContent nkNone">
                                            <header>
                                                <h3>'.THEMESELECT.'</h3>
                                            </header>';
                    $activeThemeHtml .=     changeTheme();
                    $activeThemeHtml .= '</div>';
                } else {
                    $activeThemeLink = '';
                    $activeThemeHtml = '';
                }

                if ($user[6] != '') {
                    $themeUse = $user[6];
                } else {
                    $themeUse = BYDEFAULT;
                }

                $langUse = '';
                if ($user[7] != '' && $modulePref['activeCountry'] == 'on') {
                    $langUse = '  <span class="nkBlock nkBold nkSize11">'.LANGUSE.'&nbsp;:&nbsp;
                                            <span id="themeUse" class="nkNoFont">'.$user[7].'</span>
                                        </span>';
                }

                ?>

                <div id="globalContentProfil">
                    <header class="nkAlignCenter nkMarginBottom15">
                        <h3><?php echo ACCOUNT; ?></h3>
                    </header>
                    <div id="backgroundProfil">
                        <div id="contentProfilLeft" class="nkAlignCenter">
                            <figure>
                                <img style="border: 0; overflow: auto; max-width: 100px; width: expression(this.scrollWidth >= 100? \'100px\' : \'auto\');" src="<?php echo $avatar; ?>" alt="" />
                            </figure> 
                            <nav id="menuProfil">
                                <ul class="nkAlignLeft">
                                    <li class="active"><a href="profilPrefs"><?php echo MYACCOUNT; ?></a></li>
                                    <li><a href="profilStats"><?php echo MYSTATS; ?></a></li>
                                    <li><a href="profilFriends"><?php echo MYFRIENDS; ?></a></li>
                                    <li><a href="profilUserBox"><?php echo MYUSERBOX; ?></a></li>
                                    <?php
                                        echo $activeThemeLink;
                                    ?>
                                    <li><a href="profilForum"><?php echo MYFORUM; ?></a></li>
                                    <li><a href="profilComment"><?php echo MYCOMMENT; ?></a></li>
                                    <li><a href="profilSuggest"><?php echo MYSUGGEST; ?></a></li>
                                    <li><a href="profilInfos"><?php echo MYPROFIL; ?></a></li>
                                    <li><a href="profilVisitor"><?php echo MYVISITOR; ?></a></li>
                                </ul>
                            </nav>
                        </div>
                        <div id="contentProfilRight" class="nkValignTop">
                            <article class="nkInlineBlock">
                                <span id="pseudo" class="nkBlock nkSize16 nkBold"><?php echo $userData['pseudo']; ?></span>
                                <span class="nkBlock nkBold nkSize11"><?php echo DATEUSER; ?>&nbsp;:&nbsp;
                                    <span class="nkNoFont"><?php echo nkDate($userData['created'], TRUE); ?></span>
                                </span>
                                <span class="nkBlock nkBold nkSize11"><?php echo LASTVISIT; ?>&nbsp;:&nbsp;
                                    <span class="nkNoFont"><?php echo $lastUsed; ?></span>
                                </span>
                                <span class="nkBlock nkBold nkSize11"><?php echo WEBSITE; ?>&nbsp;:&nbsp;
                                    <span id="website" class="nkNoFont"><?php echo $website; ?></span>
                                </span>
                                <span class="nkBlock nkBold nkSize11"><?php echo PRIVATEMAIL; ?>&nbsp;:&nbsp;
                                    <span id="privateMail" class="nkNoFont"><?php echo $privateMail; ?></span>
                                </span>
                                <span class="nkBlock nkBold nkSize11"><?php echo PUBLICMAIL; ?>&nbsp;:&nbsp;
                                    <span id="publicMail" class="nkNoFont"><?php echo $publicMail; ?></span>
                                </span>
                                <span class="nkBlock nkBold nkSize11"><?php echo THEMEUSE; ?>&nbsp;:&nbsp;
                                    <span id="themeUse" class="nkNoFont"><?php echo $themeUse; ?></span>
                                </span>
                                <?php
                                echo $langUse;
                                ?>
                            </article>
                            <aside id="profilLogOut" class="nkInlineBlock nkValignTop nkFloatRight">
                                <a href="index.php?file=User&amp;op=logout&amp;nuked_nude=index" title="<?php echo LOGOUT; ?>"><span class="nkIcon24LogOut"></span></a>
                            </aside>

                            <div id="contentProfil" class="nkBlock">
                                <div id="profilStats" class="profilContent nkNone nkWidthFull nkMarginLRAuto">
                                    <header>
                                        <h3><?php echo MYSTATS; ?></h3>
                                    </header>
                                    <ul>
                                        <li><?php echo NOTREAD; ?>&nbsp;:&nbsp;<?php echo $msgNotRead; ?></li>
                                        <li><?php echo READ; ?>&nbsp;:&nbsp;<?php echo $nbMessRead; ?></li>
                                        <li><?php echo MESSINFORUM; ?>&nbsp;:&nbsp;<?php echo $nbForumMessage; ?></li>
                                        <li><?php echo USERCOMMENT; ?>&nbsp;:&nbsp;<?php echo $nbComment; ?></li>
                                        <li><?php echo USERSUGGEST; ?>&nbsp;:&nbsp;<?php echo $nbSuggest; ?></li>
                                        <li><?php echo USERVISITOR; ?>&nbsp;:&nbsp;<?php echo $nbVisitor; ?></li>
                                    </ul>
                                </div>

                                <div id="profilUserBox" class="profilContent nkNone nkWidthFull nkMarginLRAuto">
                                    <header>
                                        <h3><?php echo MYUSERBOX; ?></h3>
                                    </header>
                                    <nav>
                                        <input class="nkButton" type="button" value="<?php echo READPV; ?>" onclick="document.location='index.php?file=Userbox'" />&nbsp;
                                        <input class="nkButton" type="button" value="<?php echo REQUESTPV; ?>" onclick="document.location='index.php?file=Userbox&amp;op=postMessage'" />
                                    </nav>
                                </div>

                                <div id="profilPrefs" class="profilContent nkBlock nkWidthFull nkMarginLRAuto">
                                    <header>
                                        <h3><?php echo MYACCOUNT; ?></h3>
                                    </header>
                                        <?php 
                                            editAccount();
                                        ?>
                                </div>
                                <?php
                                    echo $activeThemeHtml;
                                ?>
                                <div id="profilForum" class="profilContent nkNone nkWidthFull nkMarginLRAuto">
                                    <header>
                                        <h3><?php echo YOUR.'&nbsp;'.$modulePref['nbForumMessage'].'&nbsp;'.LASTUSERMESS; ?></h3>
                                    </header>
                                    <?php
                                        echo $msgForum;
                                    ?>
                                </div>

                                <div id="profilComment" class="profilContent nkNone nkWidthFull nkMarginLRAuto">
                                    <header>
                                        <h3><?php echo YOUR.'&nbsp;'.$modulePref['nbComment'].'&nbsp;'.LASTUSERCOMMENT; ?></h3>
                                    </header>
                                    <?php
                                        echo $commentUser;
                                    ?>
                                </div>

                                <div id="profilSuggest" class="profilContent nkNone nkWidthFull nkMarginLRAuto">
                                    <header>
                                        <h3><?php echo YOUR.'&nbsp;'.$modulePref['nbSuggest'].'&nbsp;'.LASTUSERSUGGEST; ?></h3>
                                    </header>
                                    <?php
                                        echo $suggestUser;
                                    ?>
                                </div>

                                <div id="profilFriends" class="profilContent nkNone nkWidthFull nkMarginLRAuto">
                                    <header>
                                        <h3><?php echo MYFRIENDSLIST; ?></h3>
                                    </header>
                                    <?php
                                        echo $myFriends;
                                    ?>
                                </div>

                                <div id="profilVisitor" class="profilContent nkNone nkWidthFull nkMarginLRAuto">
                                    <header>
                                        <h3><?php echo MYVISITOR; ?></h3>
                                    </header>
                                    <?php
                                        infoVisitor($user[0]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                redirect("index.php?file=User&op=loginScreen", 0);
            }
        }

        // A FAIRE  adaptation avec la nouvelle fonction pays / langue
        function modifLang() {
            global $user, $nuked, $cookieLangue, $cookieCountry, $timelimit, $cookieTimeLimit;

            if ($_REQUEST['userLang'] != "") {
                if ($user) {
                    $dbuLang = '    UPDATE '.USER_TABLE.' 
                                    SET userLanguage = "'.$_REQUEST['userLang'].'", 
                                        country = "'.$_REQUEST['country'].'"
                                    WHERE id = "'.$user[0].'"';
                    $dbeLang = mysql_query($dbuLang);
                } else {
                    setcookie($cookieCountry, $_REQUEST['country'], $cookieTimeLimit);
                    setcookie($cookieLangue, $_REQUEST['userLang'], $cookieTimeLimit);
                }
            }
            redirect('index.php', 0);
        }

        function modifTheme() {
            global $user, $nuked, $cookieTheme, $timelimit, $cookieTimeLimit;

            // chemin contenant les themes
            if ($_REQUEST['userTheme'] === $nuked['themeDefault']) {
                $repertory = 'media/template/'.$_REQUEST['userTheme'];
            } else {
                $repertory = 'themes/'.$_REQUEST['userTheme'];
            }
            // verification si le theme existe
            if (is_dir($repertory)) {
                // si le visiteur est enregistré
                if (isset($user[0])) {
                    // mise a jour de son compte
                    $dbuTheme = '   UPDATE '.USER_TABLE.' 
                                    SET userTheme = "'.$_REQUEST['userTheme'].'"
                                    WHERE id = "'.$user[0].'"';
                    $dbeTheme = mysql_query($dbuTheme);
                } else {
                    // si le membre est un visiteur, création d'un cookie
                   setcookie($cookieTheme, $_REQUEST['userTheme'], $cookieTimeLimit);
                }
            }

            // récupération du lien so l'utilisateur etait dans son compte
            $userReg = '';
            if (isset($_REQUEST['userReg']) && $_REQUEST['userReg'] == true) {
                $userReg = '&userReg='.$_REQUEST['userReg'];
            }
            // stockage de la variable pour la passer a applytheme()
            $_SESSION['userTheme'] = $_REQUEST['userTheme'];           
            redirect('index.php?file=User&op=applyTheme'.$userReg, 0);
        }

        function applyTheme() {
            global $user, $nuked, $cookieTheme, $modulePref;

            // définition du message a afficher
            if ($_SESSION['userTheme'] === $nuked['themeDefault']) {
                $themeApply = BYDEFAULT;
            } elseif ($_SESSION['userTheme'] === $nuked['theme']) {
                $themeApply = BYDEFAULTADMIN;
            }else {
                $themeApply = $_SESSION['userTheme'];
            }
            // si l'admin autorise le changement de theme
            if ($modulePref['activeTheme'] === 'on') {
                // affichage d'un message de confirmation
                echo $GLOBALS['nkTpl']->nkDisplaySuccess(UPDATEDTHEME.'&nbsp;'.$themeApply.'&nbsp;'.UPDATEDTHEMES, 'nkAlert nkAlertSuccess');
                // redirection si ^l'utilisateur etait dans son compte
                if (isset($_REQUEST['userReg']) && $_REQUEST['userReg'] == true) {
                    $url = 'index.php?file=User';
                } else {
                    $url = 'index.php';
                }
                redirect($url, 2);
            } else {
                // affichage d'un message d'erreur
                echo $GLOBALS['nkTpl']->nkDisplayError(FUNCTIONOFF, 'nkAlert nkAlertError');
                redirect('index.php', 2);
            }
        }


        function changeTheme() {
            global $nuked, $user, $cookieTheme;

            if (isset($_COOKIE[$GLOBALS['cookieTheme']]) && $cookieTheme != '') {
                $personalTheme = $_COOKIE[$GLOBALS['cookieTheme']];
            } elseif (isset($user) && $user[6] != '') {
                $personalTheme = $user[6];
            } elseif ($nuked['theme'] != '') {
                $personalTheme = $nuked['theme'];
            } else {
                $personalTheme = $nuked['themeDefault'];
            }

            $themeView = '';
            // ouverture du repertoire des themes
            $repertory = opendir('themes');
            // lecture du contenu
            while (false !== ($themeList = readdir($repertory))) {
                if ($themeList != "." && $themeList != ".." && $themeList != "CVS" && $themeList != "index.html" && !preg_match("`[.]`", $themeList)) {
                    if ($personalTheme == $themeList) {
                        $themeChecked = 'selected="selected"';
                    } else {
                        $themeChecked = '';
                    }
                    $themeView .= '<option value="'.$nuked['themeDefault'].'" '.$themeChecked.'>'.$nuked['themeDefault'].'</option>';
                    $themeView .= '<option value="'.$themeList.'" '.$themeChecked.'>'.$themeList.'</option>';
                }
            }            
            closedir($repertory);
            $activeThemeForm = '<div class="nkAlignCenter">'.SELECTTHEME.'&nbsp;:&nbsp;
                                <form class="nkInline" action="index.php?file=User&amp;nuked_nude=index&amp;op=modifTheme" method="post">
                                    <span class="nkNoFont">
                                        <select id="userTheme" class="nkInput" name="userTheme" onChange="javascript:submit();">
                                            '.$themeView.'
                                        </select>
                                    </span>
                                <input type="hidden" name="userReg" value="true" />
                                </form>
                                </div>';
            return $activeThemeForm;
        }

        function oubliPass() {
        ?>
            <form action="index.php?file=User&amp;op=envoiMail" method="post">
                <header class="nkMarginLRAuto nkWidth3Quarter nkMarginBottom15">
                    <h3 class="nkAlignCenter nkSize16 nkBold nkMarginTop15 nkMarginBottom15">
                        <?php echo LOSTPASS; ?>
                    </h3>
                    <span>
                        <?php echo LOSTPASSTXT; ?>
                    </span>
                </header>
                <article class="nkWidthHalf nkMarginLRAuto nkAlignCenter">
                    <label for="sendEmail"><?php echo PRIVATEMAIL; ?></label>&nbsp;:&nbsp;
                        <input class="nkInput" type="text" id="sendEmail" name="email" size="30" maxlength="80" />
                        <input class="nkButton nkAlignCenter nkMarginTop15" type="submit" value="<?php echo SEND; ?>" />
                </article>
            </form>
        <?php
        }

        function login($pseudo, $pass, $rememberMe) {
            global $captcha, $nuked, $theme, $cookieTheme, $cookieLangue, $cookieCountry, $timelimit, $cookieSession, $sessionlimit, $userIp, $userlang;

            if ($pseudo == '' || $pass == '') {
                $error = 3;
                $url = 'index.php?file=User&op=loginScreen&error='.$error;
                redirect($url, 0);
            } else {

                $dbsUserInfo = 'SELECT id, pass, userTheme, userLanguage, level, error 
                                FROM '.USER_TABLE.' 
                                WHERE pseudo = \'' . htmlentities($pseudo, ENT_QUOTES) . '\'';
                $dbeUserInfo = mysql_query($dbsUserInfo);
                $dbcUserInfo = mysql_num_rows($dbeUserInfo);

                if($dbcUserInfo == 0) {
                    $error = 6;
                    $url = 'index.php?file=User&op=loginScreen&error='.$error;
                    redirect($url, 0);
                } else {

                    list($userId, $dbpass, $userTheme, $userLang, $level, $countError) = mysql_fetch_array($dbeUserInfo);

                    // Verification code captcha
                    if (!ValidCaptchaCode($_REQUEST['codeConfirm']) && $countError >= 3) {
                        if (empty($_REQUEST['codeConfirm'])) {
                            $error = 1;
                            $url = 'index.php?file=User&op=loginScreen&error='.$error;
                            redirect($url, 0);
                        } else {
                            $error = 2;
                            $url = 'index.php?file=User&op=loginScreen&error='.$error;
                            redirect($url, 0);
                        }

                        $url = "index.php?file=User&op=loginScreen&captcha=true";
                        $captcha = '&captcha=true';
                        redirect($url, 2);
                    } else {
                        $captcha = '';
                    }

                    if ($level == 0) {
                        $error = 5;
                        $url = 'index.php?file=User&op=loginScreen&error='.$error.$captcha;
                        redirect($url, 0);
                    } else {

                        if (!Check_Hash($pass, $dbpass)) {
                            $error = 4;
                            $dbuError = '   UPDATE '.USER_TABLE.' 
                                            SET error = '.($countError + 1).' 
                                            WHERE pseudo = \'' . htmlentities($pseudo, ENT_QUOTES) . '\'';
                            $dbeError = mysql_query($dbuError);

                            $url = "index.php?file=User&op=loginScreen&error=" . $error . $captcha;
                            redirect($url, 0);
                        } else {
                            $dbuError = '   UPDATE ' . USER_TABLE . ' 
                                            SET error = 0 
                                            WHERE pseudo = \'' . htmlentities($pseudo, ENT_QUOTES) . '\'';
                            $dbeError = mysql_query($dbuError);

                            //reinitialisation
                            session_new($userId, $rememberMe);

                            // si l'utilisateur enregistré a un cookie de theme, on le supprime
                            if (isset($_COOKIE[$cookieTheme])) {
                                // on ajoute a son le contenu du cookie supprimé
                                $dbuCountry = '   UPDATE ' . USER_TABLE . ' 
                                                SET userTheme = "'.$_COOKIE[$cookieTheme].'" 
                                                WHERE pseudo = \'' . htmlentities($pseudo, ENT_QUOTES) . '\'';
                                $dbeCountry = mysql_query($dbuCountry);
                                setcookie($cookieTheme, '', time() - 3600);
                            }
                            // si l'utilisateur enregistré a un cookie de pays, on le supprime
                            if (isset($_COOKIE[$cookieCountry])) {
                                // on ajoute a son le contenu du cookie supprimé
                                $dbuCountry = '   UPDATE ' . USER_TABLE . ' 
                                                SET country = "'.$_COOKIE[$cookieCountry].'" 
                                                WHERE pseudo = \'' . htmlentities($pseudo, ENT_QUOTES) . '\'';
                                $dbeCountry = mysql_query($dbuCountry);
                                setcookie($cookieCountry, '', time() - 3600);
                            }
                            // si l'utilisateur enregistré a un cookie de langue, on le supprime
                            if (isset($_COOKIE[$cookieLangue])) {
                                // on ajoute a son le contenu du cookie supprimé
                                $dbuCountry = '   UPDATE ' . USER_TABLE . ' 
                                                SET userLanguage = "'.$_COOKIE[$cookieLangue].'" 
                                                WHERE pseudo = \'' . htmlentities($pseudo, ENT_QUOTES) . '\'';
                                $dbeCountry = mysql_query($dbuCountry);
                                setcookie($cookieLangue, '', time() - 3600);
                            }

                            $referer = $_SERVER['HTTP_REFERER'];
                            $_SESSION['admin'] = false;  

                            if (!empty($referer) && stripos($referer, 'User&op=reg')) {
                                $refere = '&refere=true';
                            } else {
                                $refere = '';
                            }
                            redirect('index.php?file=User&op=loginMessage'.$refere, 0);
                        }
                    }
                }
            }
        }

        function loginMessage() {
            global $nuked, $theme, $cookieSession, $sessionlimit, $userIp;

            if (isset($_COOKIE[$cookieSession]) && $_COOKIE[$cookieSession] != '') {
                $testCookie = $_COOKIE[$cookieSession];
            } else {
                $testCookie = null;
            }

            $refere = $_REQUEST['refere'];

            if ($refere == true) {
                $msgLog = $GLOBALS['nkTpl']->nkDisplaySuccess(REGISTERSUCCES, 'nkAlert nkAlertSuccess');
            } else {
                $msgLog = $GLOBALS['nkTpl']->nkDisplaySuccess(LOGINPROGRESS, 'nkAlert nkAlertSuccess');
            }

            if (!is_null($testCookie)) {
                echo $msgLog;
            } else {

                if ($nuked['sess_inactivemins'] > 0 && $userIp != '' && $userIp != '127.0.0.1') {
                    $loginText =    $msgLog.'
                                    <span class="nkBlock">'.SESSIONIPOPEN.'</span>
                                    <span class="nkBlock">'.ERRORCOOKIE.'</span>';
                } else {
                    $loginText = ERRORCOOKIE;
                }
            }
            redirect('index.php?file=User', 2);
        }

        function loginScreen() {
            global $nuked, $user;

            if ($user) {
                redirect("index.php?file=User", 0);
            } else {

                if ($_REQUEST['error'] == 1) {
                    $error = $GLOBALS['nkTpl']->nkDisplayError(MSGCAPTCHA, 'nkAlert nkAlertError');
                } elseif ($_REQUEST['error'] == 2) {
                    $error = $GLOBALS['nkTpl']->nkDisplayError(BADCODECONFIRM, 'nkAlert nkAlertError');
                } elseif ($_REQUEST['error'] == 3) {
                    $error = $GLOBALS['nkTpl']->nkDisplayError(NOFIELD, 'nkAlert nkAlertError');
                } elseif ($_REQUEST['error'] == 4) {
                    $error = $GLOBALS['nkTpl']->nkDisplayError(BADPASSWORD, 'nkAlert nkAlertError');
                } elseif ($_REQUEST['error'] == 5) {
                    $error = $GLOBALS['nkTpl']->nkDisplayError(NOVALuserId, 'nkAlert nkAlertError');
                } elseif ($_REQUEST['error'] == 6) {
                    $error = $GLOBALS['nkTpl']->nkDisplayError(UNKNOWNUSER, 'nkAlert nkAlertError');
                } else {
                    $error = '';
                }

                echo $error;
                ?>

                <div class="nkAlignCenter nkMarginTop15 nkMarginBottom15"><?php echo LOGINUSER; ?></div>
                <form class="nkAjaxForm" action="index.php?file=User&amp;nuked_nude=index&amp;op=login" method="post">
                <table class="nkMarginLRAuto nkMarginTop15 nkMarginBottom15">
                    <tr>
                        <td class="nkPaddingTB5"><?php echo PSEUDO; ?>&nbsp;:&nbsp;</td>
                        <td class="nkPaddingTB5"><input class="nkInput" type="text" name="pseudo" size="15" maxlength="180" /></td>
                    </tr>
                    <tr>
                        <td class="nkPaddingTB5"><?php echo PASSWORD; ?>&nbsp;:&nbsp;</td>
                        <td class="nkPaddingTB5"><input class="nkInput" type="password" name="pass" size="15" maxlength="15" /></td>
                    </tr>                       
                    <?php
                    if ($_REQUEST['captcha'] == 'true') {
                        create_captcha(1);
                    }
                    ?>
                </table>
                <table class="nkMarginLRAuto nkMarginTop15 nkMarginBottom15 nkAlignCenter"> 
                    <tr>
                        <td class="nkPaddingTB5">
                            <div class="nkCheckBoxRounded">
                                <input id="RememberMe" class="Remember" type="checkbox" checked="checked" name="rememberMe" value="ok">
                                <label for="RememberMe"></label>
                            </div>
                            <small>&nbsp;<?php echo REMEMBERME; ?></small>
                        </td>
                    </tr>
                    <tr>
                        <input type="hidden" name="error" value="<?php echo $_REQUEST['error']; ?>" size="15" maxlength="15" />
                        <td class="nkPaddingTB5"><input class="nkButton" type="submit" value="<?php echo TOLOG; ?>" /></td>
                    </tr>
                    <tr>
                        <td class="nkPaddingTB5">
                            <a href="index.php?file=User&amp;op=regScreen"><?php echo REGISTER; ?></a>
                            &nbsp;|&nbsp;
                            <a href="index.php?file=User&amp;op=oubliPass"><?php echo LOSTPASS; ?></a>
                        </td>
                    </tr>
                </table>
                </form>

            <?php   
            }
        }

        function htmlDisconnect($content) {
            global $nuked;
        ?>
            <!DOCTYPE html>
            <html lang="<?php echo $lang; ?>">
                <head>
                    <title><?php echo $nuked['name']; ?>&nbsp;-&nbsp;<?php echo $nuked['slogan']; ?></title>
                    <meta charset="utf-8" />
                    <link title="style" type="text/css" rel="stylesheet" href="media/css/nkCss.css" />
                </head>
                <body id="nkSiteClose">
                    <section>
                        <header>
                            <hgroup>
                                <img src="images/logo.png" />
                                <h1><?php echo $nuked['name']; ?></h1>
                                <h2><?php echo $nuked['slogan']; ?></h2>
                            </hgroup>
                        </header>
                        <article>
                            <p class="nkAlignCenter"><?php echo $content; ?></p>        
                        </article>
                        <footer>
                            <p>
                                <a href="/"><?php echo $nuked['name']; ?></a> &copy; 2001, <?php echo date('Y'); ?>&nbsp;|&nbsp;<?php echo POWERED; ?> <a href="http://www.nuked-klan.org">Nuked-Klan</a>
                            </p>
                        </footer>
                    </section>
                </body>
            </html>
        <?php
        }

        function logout() {
            global $nuked, $user, $cookieTheme, $cookieCaptcha, $cookieLangue, $cookieSession, $cookieUserId, $cookieForum;

            $dbuLogOut = '  UPDATE '.SESSIONS_TABLE.' 
                            SET ip = "" 
                            WHERE userId = "'.$user[0].'"';
            $dbeLogOut = mysql_query($dbuLogOut);
            setcookie($cookieSession, '', time() - 3600);
            setcookie($cookieCaptcha, '', time() - 3600);
            setcookie($cookieUserId, '', time() - 3600);
            setcookie($cookieTheme, '', time() - 3600);
            setcookie($cookieForum, '', time() - 3600);
            $_SESSION['admin'] = false;
            htmlDisconnect(USERLOGOUTINPROGRESS);
            redirect('index.php', 2);
        }

        function showAvatar() {
            global $nuked, $theme, $lang, $language;
        ?>
            <!DOCTYPE html>
            <html lang="<?php echo $lang; ?>">
            <head>        
                <meta name="keywords" content="<?php echo $nuked['keyword'] ?>" />
                <meta name="Description" content="<?php echo $nuked['description'] ?>" />
                <meta charset="UTF-8" />
                <title><?php echo $nuked['name'] ?> - <?php echo $nuked['slogan'] ?></title>                        
                <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
                <link type="text/css" rel="stylesheet" href="media/css/nkCss.css" media="screen" />
                <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                <script type="text/javascript" src="media/js/avatar.js"></script>
            </head>
            <body>
                <table class="siteAvatar">
                    <tr>
                        <td>
                            <?php 
                            if ($dir = opendir('images/avatar/')) {
                                while (false !== ($avatar = readdir($dir))) {
                                    if ($avatar != "." && $avatar != ".." && $avatar != "index.html" && $avatar != "Thumbs.db" && $avatar != "thumbs.db") {
                                        $avatar = 'images/avatar/'.$avatar;
                                        echo '<a href="#"><img class="avatarCheck" src="'.$avatar.'" alt="" title="'.$avatar.'" /></a>';
                                    }
                                }
                                closedir($dir);
                            } 
                            ?>
                        </td>
                    </tr>
                </table>
                <div class="nkAlignCenter"><a href="#" onclick="self.close()"><?php echo CLOSEWINDOWS; ?></a></div>
            </body>
            </html>

        <?php
        }

        function editAccount() {
            global $nuked, $user, $modulePref, $modName;

            define('EDITOR_CHECK', 1);
            if ($user) {
                $dbsUserInfo = 'SELECT pseudo, firstName, age, sex, city, privateMail, publicMail, website, avatar, userTheme, signing 
                                FROM '.USER_TABLE.' 
                                WHERE id = "'.$user[0].'"';
                $dbeUserInfo = mysql_query($dbsUserInfo);
                list($pseudo, $firstName, $age, $sex, $city, $privateMail, $publicMail, $website, $avatar, $userTheme, $signing) = mysql_fetch_array($dbeUserInfo);

                // Check du jour
                if ($age == '') {
                    $age = '1/1/1900';
                }
                
                $dateExtract = explode('/', $age);
                if ($user[8] != '') {
                    $flag = substr($user[8], 0, 2);
                } else {
                    $flag = substr($nuked['country'], 0, 2);
                }
                $flag = strtoupper($flag);
                $dayView   = '';
                $monthView = '';
                $yearView  = '';
                $countryView = '';

                // affichage sex
                $sexArray = array(
                    'man'   => MAN, 
                    'woman' => WOMAN
                );
                $sexView = $GLOBALS['nkFunctions']->nkRadioBox('label', SEX, 2, 'sex', $sexArray, '&nbsp;:&nbsp;','sex', 'nkLabelSpacing nkNoPadding nkMarginTop', '', '', $sex);

                for ($d=1; $d <= 31; $d++) {
                    if ($dateExtract[0] == $d) {
                        $selectDay   = 'selected="selected"';
                        $selectMonth = 'selected="selected"';
                        $selectYear  = 'selected="selected"';
                    } else {
                        $selectDay   = '';
                        $selectMonth = '';
                        $selectYear  = '';
                    }
                    $dayView   .= '<option value="'.$d.'" '.$selectDay.'>'.$d.'</option>';
                }
                for ($m=1; $m <= 12; $m++) {
                    if ($dateExtract[1] == $m) {
                        $selectMonth = 'selected="selected"';
                    } else {
                        $selectMonth = '';
                    }
                    $monthView .= '<option value="'.$m.'" '.$selectMonth.'>'.$m.'</option>';
                }
                $lastyear = date("Y") + 1;
                for ($y=1900; $y <= $lastyear; $y++) {
                    if ($dateExtract[2] == $y) {
                        $selectYear  = 'selected="selected"';
                    } else {
                        $selectYear  = '';
                    }
                    $yearView  .= '<option value="'.$y.'" '.$selectYear.'>'.$y.'</option>';
                }

                // affichage avatar upload et url
                if ($modulePref['avatarUpload'] == "on" || $modulePref['avatarUrl'] == "on") {
                   
                    $siteAvatar = "<a  href=\"#\" onclick=\"javascript:window.open('index.php?file=User&amp;nuked_nude=index&amp;op=showAvatar','Avatar','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=420,height=450,top=30,left=0');return(false)\">tout les avatars</a>";

                    $avatarView = '<label class="nkLabelSpacing" for="editPhoto">'.AVATAR.'&nbsp;&nbsp;('.$siteAvatar.')</label>&nbsp;:&nbsp;
                                        <input class="nkInput" type="text" id="editPhoto" name="avatarUrl" size="35" maxlength="150" value="'.$avatar.'" />';

                    if ($modulePref['avatarUpload'] == "on") {
                        $avatarUploadLink = '<label class="nkLabelSpacing" for="editAvatar">'.AVATARUPLOAD.'</label>&nbsp;:&nbsp;
                                                <input class="nkInput" type="file" id="editAvatar" name="avatarUpload" size="23" />';
                    }

                }

                if ($modulePref['userAccountDelete'] == "on") {
                    $removeArray = array(
                        YES,
                        NO
                    );
                    $delMyAccount = $GLOBALS['nkFunctions']->nkRadioBox('span', DELMYACCOUNT, 2, 'remove', $removeArray, '', 'editRemove', null, 'removeMyAccount', '', 1);
                }

                if ($modulePref['activeCountry'] == "on") {
                    if ($user[7] != '') {
                        $useLanguage = $user[7];
                    } else {
                        $useLanguage = null;
                    }

                    if ($user[8] != '') {
                        $country = $user[8];
                    } else {
                        $country = $nuked['country'];
                    }

                    $countryView =  '<div>
                                        <label class="nkLabelSpacing" for="editCountry">'.COUNTRY.'</label>&nbsp;:&nbsp;&nbsp;';                                            
                    $countryView .=         $GLOBALS['nkFunctions']->nkSelectCountry($country, $useLanguage);
                    $countryView .= '</div>';
                }

                ?>

                <form method="post" action="index.php?file=User&amp;op=updateAccount" enctype="multipart/form-data">
                <article id="nkPersonalUser">
                    <div class="nkAlignCenter"><?php echo PASSFIELD; ?></div>
                    <div>
                        <label class="nkLabelSpacing" for="editPseudo"><?php echo PSEUDO; ?> *</label>&nbsp;:&nbsp;
                            <input class="nkInput" id="editPseudo" type="text" name="pseudo" size="35" maxlength="30" value="<?php echo $pseudo; ?>" />
                    </div>
                    <div>
                        <label class="nkLabelSpacing" for="editPass"><?php echo USERPASSWORD; ?></label>&nbsp;:&nbsp;
                            <input class="nkInput" id="editPass" type="password" name="passReg" size="15" maxlength="15" autocomplete="off" />
                    </div>
                    <div>
                        <label class="nkLabelSpacing" for="editPassConf"><?php echo PASSCONFIRM; ?></label>&nbsp;:&nbsp;
                            <input class="nkInput" id="editPassConf" type="password" name="passConf" size="15" maxlength="15" autocomplete="off" />
                    </div>
                    <div>
                        <label class="nkLabelSpacing" for="passOld"><?php echo OLDPASSWORD; ?> *</label>&nbsp;:&nbsp;
                            <input class="nkInput" type="password" id="passOld" name="passOld" size="15" maxlength="15" />
                    </div>
                    <div>
                        <label class="nkLabelSpacing" for="editPrivateMail"><?php echo PRIVATEMAIL; ?> *</label>&nbsp;:&nbsp;
                            <input class="nkInput" id="editPrivateMail" type="text" name="privateMail" size="35" maxlength="80" value="<?php echo $privateMail; ?>" />
                    </div>
                    <div>
                        <label class="nkLabelSpacing" for="editPublicMail"><?php echo PUBLICMAIL; ?></label>&nbsp;:&nbsp;
                            <input class="nkInput" type="text" id="editPublicMail" name="publicMail" size="35" maxlength="80" value="<?php echo $publicMail; ?>" />
                    </div>
                    <div>
                        <label class="nkLabelSpacing" for="editFirstName"><?php echo FIRSTNAME; ?></label>&nbsp;:&nbsp;
                            <input class="nkInput" id="editFirstName" type="text" name="firstName" size="35" maxlength="30" value="<?php echo $firstName; ?>" />
                    </div>
                    <div>
                        <label class="nkLabelSpacing" for="editAge"><?php echo BIRTHDAY; ?></label>&nbsp;:&nbsp;
                            <select class="nkInput" id="editAge" name="day">
                                <?php
                                    echo $dayView;
                                ?>
                            </select>&nbsp;
                            <select class="nkInput" name="month">
                                <?php
                                    echo $monthView;
                                ?>
                            </select>&nbsp;
                            <select class="nkInput" name="year">
                                <?php
                                    echo $yearView;
                                ?>
                            </select>
                    </div>
                    <div>
                        <?php 
                        echo $sexView; 
                        ?>
                    </div>
                    <div>
                        <label class="nkLabelSpacing" for="editCity"><?php echo CITY; ?></label>&nbsp;:&nbsp;
                            <input class="nkInput" type="text" id="editCity" name="city" size="35" maxlength="80" value="<?php echo $city; ?>" />
                    </div>
                    <!-- Affichage du pays et de la langue -->
                    <?php
                    echo $countryView;
                    ?>
                    <div>
                        <label class="nkLabelSpacing" for="editWebsite"><?php echo WEBSITE; ?></label>&nbsp;:&nbsp;
                            <input class="nkInput" type="text" id="editWebsite" name="website" size="35" maxlength="80" value="<?php echo $website; ?>" />
                    </div>
                    <div>
                    <?php
                        echo $avatarView;
                    ?>
                    </div>
                    <div>
                    <?php
                        echo $avatarUploadLink;
                    ?>
                    </div>
                    <div>
                        <label class="nkLabelSpacing" for="e_basic"><?php echo SIGN; ?></label>&nbsp;:&nbsp;
                            <textarea class="nkTextArea" id="e_basic" name="signing" rows="5" cols="33"><?php echo $signing; ?></textarea>
                    </div>
                    <?php
                        echo '<div class="nkAlignCenter nkMarginTop15">'.$delMyAccount.'</div>';
                    ?>
                    <div class="nkPadding nkAlignCenter nkMarginTop15">
                        <input class="nkButton" type="submit" name="Submit" value="<?php echo SEND; ?>" />
                    </div>
                </article>
                </form>
            <?php
            } else {
                echo "<br /><br /><div style=\"text-align: center;\">" . USERENTRANCE . "</div><br /><br />";
                redirect("index.php?file=User&op=loginScreen", 2);
            }
        }

        function regScreen() {
            global $nuked, $user, $language, $captcha, $modulePref;

            if ($user) {
                redirect("index.php?file=User&op=editAccount", 0);
            }

            if ($modulePref['inscription'] != "off") {
                if ($modulePref['inscriptionCharte'] != "" && !isset($_REQUEST['charteAgree'])) {
                    $disclaimer = html_entity_decode($modulePref['inscriptionCharte']);
                    ?>

                    <header class="nkMarginLRAuto nkAlignCenter"><?php echo NEWUSERREGISTRATION; ?></header>
                    <div class="nkMarginLRAuto nkAlignCenter"><?php echo $disclaimer; ?></div>
                    <form method="post" action="index.php?file=User&amp;op=regScreen">
                        <div class="nkAlignCenter">
                            <input type="hidden" name="charteAgree" value="1" />
                            <input class="nkButton" type="submit" value="<?php echo IAGREE; ?>" />
                            <input class="nkButton" type="button" value="<?php echo IDESAGREE; ?>" onclick="javascript:history.back()" />
                        </div>
                    </form>
                <?php
                } else {

                    // affichage des jeux
                    $gameView = '';
                    $sql = mysql_query("SELECT id, name FROM " . GAMES_TABLE . " ORDER BY name");
                    while (list($gameId, $nom) = mysql_fetch_array($sql)){
                        $nom = htmlentities($nom);
                        $gameView .= '<option value="'.$gameId.'">'.$nom.'</option>';
                    }

                    // Check du jour
                    $dayView = '';
                    $day = 1;
                    while ($day < 32) {
                        if ($day == date("d")) {
                            $dayView .= '<option value="'.$day.'" selected="selected">'.$day.'</option>';
                        } else {
                            $dayView .= '<option value="'.$day.'">'.$day.'</option>';
                        }            
                        $day++;
                    }

                    // Check du mois
                    $monthView = '';
                    $month = 1;
                    while ($month < 13) {
                        if ($month == date("m")) {
                            $monthView .= '<option value="'.$month.'" selected="selected">'.$month.'</option>';
                        }
                        else{
                            $monthView .= '<option value="'.$month.'">'.$month.'</option>';
                        }
                        $month++;
                    }

                    // Check de l'année
                    $yearView = '';
                    $year = 1900;
                    $lastyear = date("Y") + 1;
                    while ($year < $lastyear) {
                        if ($year == date("Y")) {
                            $yearView .= '<option value="'.$year.'" selected="selected">'.$year.'</option>';
                        } else {
                            $yearView .= '<option value="'.$year.'">'.$year.'</option>';
                        }
                        $year++;
                    }

                    // affichage sex
                    $sexArray = array(
                        'man'   => MAN, 
                        'woman' => WOMAN
                    );
                    $sexView = $GLOBALS['nkFunctions']->nkRadioBox('label', SEX, 2, 'sex', $sexArray, '&nbsp;:&nbsp;','sex', 'nkLabelSpacing nkNoPadding', ' nkMargin', '', 'man');

                    // affichage avatar upload et url
                    if ($modulePref['avatarUpload'] == "on" || $modulePref['avatarUrl'] == "on") {
                       
                        $avatarView = '<label class="nkLabelSpacing" for="editPhoto">'.AVATAR.'</label>&nbsp;:&nbsp;
                                            <input class="nkInput" type="text" id="editPhoto" name="avatarUrl" size="35" maxlength="150" />';

                        if ($modulePref['avatarUpload'] == "on") {
                            $avatarUploadLink = '<label class="nkLabelSpacing" for="editAvatar">'.AVATARUPLOAD.'</label>&nbsp;:&nbsp;
                                                    <input class="nkInput" type="file" id="editAvatar" name="avatarUpload" size="23" />';
                        }
                    }

                    $countryView = '';
                    if ($modulePref['activeCountry'] == "on") {
                        $countryView = '<div>
                                            <label class="nkLabelSpacing" for="editCountry">'.COUNTRY.'</label>&nbsp;:&nbsp;&nbsp;';                                            
                        $countryView .=         $GLOBALS['nkFunctions']->nkSelectCountry();                                            
                        $countryView .= '</div>';
                    }

                ?>
                    <link rel="stylesheet" href="media/css/checkSecurityPass.css" type="text/css" media="screen" />
                    <script type="text/javascript" src="media/js/checkSecurityPass.js"></script>
                    <header class="nkAlignCenter nkMarginBottom15 nkMarginTop15 nkSize14 nkBold"><?php echo NEWUSERREGISTRATION; ?></header>
                    <form method="post" action="index.php?file=User&amp;op=reg">
                    <article id="nkPersonalUser" class="nkWidthFull nkMargin">
                        <div>
                            <label class="nkLabelSpacing" for="regPseudo"><?php echo PSEUDO; ?> (<?php echo REQUIRED; ?>) *</label>&nbsp;:&nbsp;
                                <input class="nkInput" id="regPseudo" type="text" name="pseudo" size="35" maxlength="30" />
                        </div>
                    <?php
                    if ($modulePref['inscription'] != "mail") {
                    ?>                        
                        <div>
                            <label class="nkLabelSpacing" for="regPass"><?php echo USERPASSWORD; ?> (<?php echo REQUIRED; ?>) *</label>&nbsp;:&nbsp;
                                <input class="nkInput" id="regPass" type="password" onkeyup="evalPwd(this.value);" name="passReg" size="15" maxlength="15" /> 
                        </div>
                        <div id="securityPass" class="nkMarginBottom15">
                            <label class="nkLabelSpacing nkInlineBlock"></label>&nbsp;&nbsp;&nbsp;
                            <div id="sm" class="nkInlineBlock">
                                <?php echo PASSCHECK; ?>
                                <ul>
                                    <li id="weak" class="nrm"><?php echo PASSWEAK; ?></li>
                                    <li id="medium" class="nrm"><?php echo PASSMEDIUM; ?></li>
                                    <li id="strong" class="nrm"><?php echo PASSHIGH; ?></li>
                                </ul>
                            </div>
                        </div>                        
                        <div>
                            <label class="nkLabelSpacing" for="confPass"><?php echo PASSCONFIRM; ?> (<?php echo REQUIRED; ?>) *</label>&nbsp;:&nbsp;
                                <input class="nkInput" id="confPass" type="password" name="passConf" size="15" maxlength="15" />
                        </div>
                    <?php
                    }
                    ?>
                        <div>
                            <label class="nkLabelSpacing" for="privateMail"><?php echo PRIVATEMAIL; ?> (<?php echo REQUIRED; ?>) *</label>&nbsp;:&nbsp;
                                <input class="nkInput" id="privateMail" type="text" name="privateMail" size="35" maxlength="80" />
                        </div>
                        <div>
                            <label class="nkLabelSpacing" for="publicMail"><?php echo PUBLICMAIL; ?> (<?php echo OPTIONAL; ?>)</label>&nbsp;:&nbsp;
                                <input class="nkInput" type="text" id="publicMail" name="publicMail" size="35" maxlength="80" />
                        </div>                        
                        <div>
                            <label class="nkLabelSpacing" for="regFirstName"><?php echo FIRSTNAME; ?></label>&nbsp;:&nbsp;
                                <input class="nkInput" id="regFirstName" type="text" name="firstName" size="35" maxlength="30" />
                        </div>
                        <div>
                            <label class="nkLabelSpacing" for="regAge"><?php echo BIRTHDAY; ?></label>&nbsp;:&nbsp;
                                <select class="nkInput" id="regAge" name="day">
                                    <?php
                                        echo $dayView;
                                    ?>
                                </select>&nbsp;
                                <select class="nkInput" name="month">
                                    <?php
                                        echo $monthView;
                                    ?>
                                </select>&nbsp;
                                <select class="nkInput" name="year">
                                    <?php
                                        echo $yearView;
                                    ?>
                                </select>
                        </div>
                        <div>
                            <?php 
                                echo $sexView;
                            ?>
                        </div>                        
                        <!-- A FAIRE COMPLETTION JS POUR LES VILLES ??? -->
                        <div>
                            <label class="nkLabelSpacing" for="regCity"><?php echo CITY; ?></label>&nbsp;:&nbsp;
                                <input class="nkInput" id="regCity" type="text" name="city" size="35" maxlength="30" />
                        </div>
                        <?php
                        echo $countryView;
                        ?>                      
                        <div>
                            <label class="nkLabelSpacing" for="regWebSite"><?php echo WEBSITE; ?></label>&nbsp;:&nbsp;
                                <input class="nkInput" id="regWebSite" type="text" name="website" size="35" maxlength="30" />
                        </div>                        
                        <div>                            
                            <?php
                                echo $avatarView;
                                echo $avatarUploadLink;
                            ?>
                        </div>                        
                        <div>
                            <label class="nkLabelSpacing" for="e_basic"><?php echo SIGNING; ?></label>&nbsp;:&nbsp;
                                <textarea class="nkTextArea" id="e_basic" name="signing" rows="5" cols="33"></textarea>
                        </div>
                        <?php
                        if ($captcha == 1) {
                            create_captcha();
                        }
                        ?>
                        <div class="nkAlignCenter nkMarginTop15">
                            <input class="nkButton" type="submit" value="<?php echo REGISTER; ?>" />
                        </div>
                    </article>
                </form>
                <?php
                }
            } else {
            ?>
                <div class="nkAlignCenter"><?php echo REGISTRATIONCLOSE; ?></div>
                echo $GLOBALS['nkFunctions']->nkHistoryBack();
            <?php
            }
        }

        function reg($pseudo, $privateMail, $publicMail, $passReg, $passConf, $userLang, $country, $firstName, $day, $month, $year, $sex, $city, $website, $avatarUrl, $signing) {
            global $nuked, $captcha, $cookieForum, $userIp, $modulePref, $modName;

            // Verification code captcha
            if (!ValidCaptchaCode($_REQUEST['codeConfirm'])) {                
                echo $GLOBALS['nkTpl']->nkDisplayError(BADCODECONFIRM, 'nkAlert nkAlertError');
                echo '<div class="nkAlignCenter">';
                echo $GLOBALS['nkFunctions']->nkHistoryBack(null, 'nkAlignCenter');
                echo '</div>';
            } else {

                $privateMail = mysql_real_escape_string(stripslashes($privateMail));
                $publicMail  = mysql_real_escape_string(stripslashes($publicMail));
                $country     = mysql_real_escape_string(stripslashes($country));
                $sex         = mysql_real_escape_string(stripslashes($sex));
                $city        = mysql_real_escape_string(stripslashes($city));
                $website     = mysql_real_escape_string(stripslashes($website));
                $signing     = mysql_real_escape_string(stripslashes($signing));
                $avatarUrl   = mysql_real_escape_string(stripslashes($avatarUrl));
                $pseudo      = htmlentities($pseudo, ENT_QUOTES);    
                $firstName   = htmlentities($firstName, ENT_QUOTES); 
                $privateMail = htmlentities($privateMail); 
                $publicMail  = htmlentities($publicMail);
                $country     = htmlentities($country);
                $sex         = htmlentities($sex);
                $city        = htmlentities($city);
                $website     = htmlentities($website);
                $avatarUrl   = htmlentities($avatarUrl);      
                $pseudo      = htmlentities($pseudo);
                $firstName   = htmlentities($firstName); 
                $signing     = secu_html(html_entity_decode($signing));
                $date        = time();

                if ($year >= date('Y')) {
                    $GLOBALS['nkTpl']->nkExitAfterError(BADAGE, 'nkAlert nkAlertError');
                    echo $redir;
                } else {
                    $age = $day.'/'.$month.'/'.$year;
                }

                $redir = redirect("index.php?file=User&op=regScreen", 2);

                $dbsMail = 'SELECT COUNT(ut.privateMail) AS reservedMail,
                            (
                                SELECT COUNT(bt.email) 
                                FROM '.BANNED_TABLE.' AS bt
                                WHERE bt.email = "'.$privateMail.'"
                            ) AS bannedMail
                            FROM '.USER_TABLE.' AS ut
                            WHERE ut.privateMail = "'.$privateMail.'"';
                $dbeMail  = mysql_query($dbsMail);
                $testMail = mysql_fetch_array($dbeMail);

                if ($modulePref['inscription'] == "mail") {
                    $lettres = "abCdefGhijklmNopqrstUvwXyz0123456789";
                    srand(time());
                    for ($i = 0;$i < 5;$i++) {
                        $rand_pass .= substr($lettres, (rand() % (strlen($lettres))), 1);
                    }
                    $passReg  = $rand_pass;
                    $passConf = $rand_pass;
                }
                $cryptpass = nk_hash($passReg);

                if ($passReg != $passConf) {
                    $GLOBALS['nkTpl']->nkExitAfterError(PASSFAILED, 'nkAlert nkAlertError');
                    echo $redir;
                }
                if ($pseudo == "error1") {
                    $GLOBALS['nkTpl']->nkExitAfterError(BADUSERNAME, 'nkAlert nkAlertError');
                    echo $redir;
                }
                if ($pseudo == "error2") {
                    $GLOBALS['nkTpl']->nkExitAfterError(NICKINUSE, 'nkAlert nkAlertError');
                    echo $redir;
                }
                if ($pseudo == "error3") {
                    $GLOBALS['nkTpl']->nkExitAfterError(NICKBANNED, 'nkAlert nkAlertError');
                    echo $redir;
                }
                if (strlen($pseudo) > 30) {
                    $GLOBALS['nkTpl']->nkExitAfterError(NICKTOLONG, 'nkAlert nkAlertError');
                    echo $redir;
                }
                if ($testMail['reservedMail'] > 0) {
                    $GLOBALS['nkTpl']->nkExitAfterError(MAILINUSE, 'nkAlert nkAlertError');
                    echo $redir;
                }
                if ($testMail['bannedMail'] > 0) {
                    $GLOBALS['nkTpl']->nkExitAfterError(MAILBANNED, 'nkAlert nkAlertError');
                    echo $redir;
                }
                if ($modulePref['validation'] == "auto") {
                    $level = 1;
                } else {
                    $level = 0;
                }

                if ($sex == '') {
                    $GLOBALS['nkTpl']->nkExitAfterError(NOSEXENTRY, 'nkAlert nkAlertError');
                    echo $redir;
                }

                // verification si avatar Url est rempli
                if ($avatarUrl == '') {
                    $avatarUrl = null;
                }

                //Upload du fichier et choix du répertoire de destination
                $avatar = $GLOBALS['nkFunctions']->UploadFiles($modName, 'avatarUpload', $avatarUrl);

                do {
                    $userId = substr(sha1(uniqid()), 0, 20);
                    $dbsuserId = '  SELECT * 
                                    FROM '.USER_TABLE.' 
                                    WHERE id = \''.$userId.'\'';
                    $dbeuserId = mysql_query($dbsuserId);
                } 
                while (mysql_num_rows($dbeuserId) != 0);


                // CREER LA FONCTION D UPLOAD POUR L AVATAR
                $dbiUser = 'INSERT INTO '.USER_TABLE.' ( `id` , `pseudo` , `firstName` , `age` , `sex` , `city` , `privateMail` , `publicMail`, `website` , `pass` , `level` , `created` , `avatar` , `signing` , `userTheme` , `userLanguage` , `country` ) VALUES ( "'.$userId.'" , "'.$pseudo.'" , "'.$firstName.'" , "'.$age.'" , "'.$sex.'" , "'.$city.'" , "'.$privateMail.'" , "'.$publicMail.'" , "'.$website.'" , "'.$cryptpass.'" , "'.$level.'" , "'.$date.'" , "'.$avatar.'" , "'.$signing.'" , "" , "" , "'.$country.'" )';
                $dbeUser = mysql_query($dbiUser);


                // Mark read all topics in the forum A FAIRE
                $_COOKIE['cookieForum'] = '';
                $dbuSession = ' UPDATE '.SESSIONS_TABLE.' 
                                SET lastUsed = date 
                                WHERE userId = "'.$userId.'"';
                $dbeSession = mysql_query($dbuSession);

                $dbdForumRead = '   DELETE FROM '.FORUM_READ_TABLE.' 
                                    WHERE userId = "' . $userId . '"';
                $dbeForumRead = mysql_query($dbdForumRead);

                $dbsResult = '  SELECT id, forumId 
                                FROM ' . FORUM_THREADS_TABLE;
                $dbeResult = mysql_query($dbsResult);
                $nbTopics  = mysql_num_rows($dbeResult);

                if ($nbTopics > 0) {
                    while (list($threadId, $forumId) = mysql_fetch_row($dbeResult)) {
                        $dbiForumRead = '   INSERT INTO '.FORUM_READ_TABLE.' (`userId` , `threadId` , `forumId` ) 
                                            VALUES ( "'.$userId.'" , "'.$threadId.'" , "'.$forumId.'" )';
                        $dbeForumRead = mysql_query($dbiForumRead);
                    }
                }

                if ($modulePref['validation'] == "mail" && $modulePref['inscription'] == "on") {
                    $subject = USERREGISTER.',&nbsp;'.$date2;
                    $corps   = USERVALID.'\r\n'.$nuked['url'].'/index.php?file=User&op=validation&userId='.$userId.'\r\n\r\n'.USERMAIL.'\r\n'.PSEUDO.'&nbsp;:&nbsp;'.$pseudo.'\r\n'.PASSWORD.'&nbsp;:&nbsp;'.$passReg.'\r\n\r\n\r\n'.$nuked['name'].'&nbsp;-&nbsp;'.$nuked['slogan'];
                    $from    = 'From:&nbsp;'.$nuked['name'].'&nbsp;<'.$nuked['contactMail'].'>\r\nReply-To:&nbsp;'.$nuked['contactMail'];
                    $subject = @html_entity_decode($subject);
                    $corps   = @html_entity_decode($corps);
                    $from    = @html_entity_decode($from);
                    $s_mail  = @html_entity_decode($mail);

                    mail($s_mail, $subject, $corps, $from);
                } else {
                    if ($modulePref['inscription'] == "mail" || ($modulePref['inscriptionMail'] != "" && $modulePref['validation'] == "auto")) {
                        if ($modulePref['inscriptionMail'] != "") {
                            $inscriptionMail = $modulePref['inscriptionMail'];
                        } else {
                            $inscriptionMail = USERMAIL;
                        }

                        $subject = USERREGISTER.',&nbsp;'.$date2;
                        $corps   = $inscriptionMail.'<br /><br />'.PSEUDO.'&nbsp;:&nbsp;'.$pseudo.'<br /><br />'.PASSWORD.'&nbsp;:&nbsp;'.$passReg.'<br /><br /><br /><br />'.$nuked['name'].'&nbsp;-&nbsp;'.$nuked['slogan'];
                        $from    = 'From:&nbsp;'.$nuked['name'].'&nbsp;<'.$nuked['contactMail'].'>\r\nReply-To:&nbsp;'.$nuked['contactMail'];
                        $from   .= '\r\n'."MIME-Version: 1.0".'\r\n';
                        $from   .= "Content-type: text/html; charset=utf-8" . "\r\n";
                        $subject = @html_entity_decode($subject);
                        $corps   = @html_entity_decode($corps);
                        $from    = @html_entity_decode($from);
                        $s_mail  = @html_entity_decode($mail);

                        mail($s_mail, $subject, $corps, $from);
                    }
                }

                if ($modulePref['inscriptionAvert'] == "on" || $modulePref['validation'] == "admin") {
                    $subject = NEWUSER.'&nbsp;:&nbsp;'.$pseudo.',&nbsp;'.$date2;
                    $corps   =  $pseudo.'&nbsp;(IP&nbsp;:&nbsp;'.$userIp.')&nbsp;'.NEWREGISTRATION.'&nbsp;'.$nuked['name'].'&nbsp;'.NEWREGSUITE.'\r\n\r\n\r\n'.$nuked['name'].'&nbsp;-&nbsp;'.$nuked['slogan'];
                    $from    = 'From:&nbsp;'.$nuked['name'].'&nbsp;<'.$nuked['contactMail'].'>\r\nReply-To:&nbsp;'.$nuked['contactMail'];
                    $subject = @html_entity_decode($subject);
                    $corps   = @html_entity_decode($corps);
                    $from    = @html_entity_decode($from);

                    mail($nuked['contactMail'], $subject, $corps, $from);
                }

                if ($modulePref['validation'] == "mail" && $modulePref['inscription'] == "on") {
                    echo $GLOBALS['nkTpl']->nkDisplaySuccess(VALIDMAILSUCCES.'&nbsp;'.$mail, 'nkAlert nkAlertSuccess');
                    redirect('index.php?file=User&op=loginScreen', 5);
                } elseif ($modulePref['validation'] == "admin" && $modulePref['inscription'] == "on") {
                    echo $GLOBALS['nkTpl']->nkDisplaySuccess(VALIDADMIN, 'nkAlert nkAlertSuccess');
                    redirect('index.php', 5);
                } elseif ($modulePref['inscription'] == "mail") {
                    echo $GLOBALS['nkTpl']->nkDisplaySuccess(USERMAILSUCCES.'&nbsp;'.$mail, 'nkAlert nkAlertSuccess');
                    redirect('index.php?file=User&op=loginScreen', 5);
                } else {

                    login($pseudo, $passReg, 'ok');
                }
            }
        }

        // Fonction montrant les infos d'un utilisteur
        function infoUser($userId) {
            global $nuked, $modName;

                $dbsUserInfo = 'SELECT U.pseudo, U.firstName, U.age, U.sex, U.website, U.publicMail, U.created, U.avatar, U.userTheme, U.userLanguage, U.country, S.lastUsed,
                                    (
                                        SELECT uct.name
                                        FROM '.CONTINENTS_TABLE.' AS uct
                                        LEFT JOIN '.COUNTRY_TABLE.' AS ct ON ct.name = "'.$userId.'"
                                        WHERE uct.id = ct.continentId
                                    ) AS userContinent
                                FROM '.USER_TABLE.' AS U 
                                LEFT JOIN '.SESSIONS_TABLE.' AS S ON U.id = S.userId 
                                WHERE U.id = "'.$userId.'"';
                $dbeUserInfo = mysql_query($dbsUserInfo);
                $userData    = mysql_fetch_array($dbeUserInfo);
                $continent      = $userData['userContinent']; 

                if ($userData['lastUsed'] > 0) {
                    $lastUsed = nkDate($userData['lastUsed'], TRUE);
                } else {
                    $lastUsed = nkDate($userData['created'], TRUE);
                }
                if ($userData['website']) {
                    $website = '<a href="'.$userData['website'].'" target="_blank">'.VISITWEBSITE.'</a>';
                } else {
                    $website = UNKNOW;
                }
                if ($userData['age']) {
                    $age = $userData['age'];
                } else {
                    $age = UNKNOW;
                }
                if ($userData['sex']) {
                    $sex = constant(strtoupper($userData['sex']));
                } else {
                    $sex = UNKNOW;
                }
                if ($userData['avatar']) {
                    $avatar = checkimg($userData['avatar']);
                } else {
                    $avatar = 'images/noavatar.png';
                }
                if ($userData['firstName']) {
                    $firstName = $userData['firstName'];
                } else {
                    $firstName = UNKNOW;
                }
                if ($userData['publicMail']) {
                    $publicMail = '<a href="mailto:'.$userData['publicMail'].'">'.MAILHIM.'</a>';
                } else {
                    $publicMail = UNKNOW;
                }
                if ($userData['userTheme'] != '') {
                    $themeUse = $userData['userTheme'];
                } else {
                    $themeUse = BYDEFAULT;
                }
                if ($userData['userLanguage'] != '') {
                    $langUse = $userData['userLanguage'];
                } else {
                    $langUse = $nuked['language'];
                }
                if ($userData['country'] != '') {
                    $country = $userData['country'];
                } else {
                    $country = $nuked['country'];
                }
            ?>
            <article class="nkInlineBlock nkValignTop nkAlignLeft">
                <span class="nkBlock nkBold nkSize11"><?php echo FIRSTNAME; ?>&nbsp;:&nbsp;
                    <span class="nkNoFont"><?php echo $firstName; ?></span>
                </span>
                <span class="nkBlock nkBold nkSize11"><?php echo SEX; ?>&nbsp;:&nbsp;
                    <span class="nkNoFont nkImgProfile"><?php echo $sex; ?></span>
                </span>
                <span class="nkBlock nkBold nkSize11"><?php echo BIRTHDAY; ?>&nbsp;:&nbsp;
                    <span class="nkNoFont"><?php echo $age; ?></span>
                </span>
                <span class="nkBlock nkBold nkSize11"><?php echo PUBLICMAIL; ?>&nbsp;:&nbsp;
                    <span id="publicMail" class="nkNoFont"><?php echo $publicMail; ?></span>
                </span>
            </article>
            <article class="nkInlineBlock nkValignTop nkAlignLeft">
                <span class="nkBlock nkBold nkSize11"><?php echo WEBSITE; ?>&nbsp;:&nbsp;
                    <span id="website" class="nkNoFont"><?php echo $website; ?></span>
                </span>
                <span class="nkBlock nkBold nkSize11"><?php echo COUNTRY; ?>&nbsp;:&nbsp;
                    <span id="website" class="nkNoFont"><?php echo $country; ?></span>
                </span>
                <span class="nkBlock nkBold nkSize11"><?php echo LANGUSE; ?>&nbsp;:&nbsp;
                    <span id="langUse" class="nkNoFont"><?php echo $langUse; ?></span>
                </span>
            </article>
            <article class="nkInlineBlock nkValignTop nkAlignLeft">
                <span class="nkBlock nkBold nkSize11"><?php echo DATEUSER; ?>&nbsp;:&nbsp;
                    <span class="nkNoFont"><?php echo nkDate($userData['created'], TRUE); ?></span>
                </span>
                <span class="nkBlock nkBold nkSize11"><?php echo LASTVISIT; ?>&nbsp;:&nbsp;
                    <span class="nkNoFont"><?php echo $lastUsed; ?></span>
                </span>
                <span class="nkBlock nkBold nkSize11"><?php echo THEMEUSE; ?>&nbsp;:&nbsp;
                    <span id="themeUse" class="nkNoFont"><?php echo $themeUse; ?></span>
                </span>
            </article>

        <?php
        }

        // Fonction montrant les infos d'un utilisteur
        function infoVisitor($userId) {
            global $nuked, $modName;

            $dbsUserInfos = '   SELECT lastVisitor
                                FROM '.USER_TABLE.'
                                WHERE id = "'.$userId.'"';
            $dbeUserInfos = mysql_query($dbsUserInfos);
            while(list($visitor) = mysql_fetch_array($dbeUserInfos)) {
                $visitor = explode('|', $visitor);
                for ($i = 0;$i < count($visitor);$i++) {
                    $dbsVisitorInfos = 'SELECT pseudo, avatar
                                        FROM '.USER_TABLE.'
                                        WHERE id = "'.$visitor[$i].'"';
                    $dbeVisitorInfos = mysql_query($dbsVisitorInfos);
                    list($visitorPseudo, $visitorAvatar) = mysql_fetch_array($dbeVisitorInfos);

                    $visitorCut = $GLOBALS['nkFunctions']->nkCutText($visitorPseudo, 15, true);

                    if ($visitorAvatar == '') {
                        $visitorAvatarImg = '<img src="modules/'.$modName.'/images/noavatar.png" alt="" />';
                    } else {                        
                        $visitorAvatarImg = '<img src="'.$visitorAvatar.'" alt="" />';
                    }

                    if ($visitor[$i] != '') {
                    ?>
                        <figure class="nkVisitor nkInlineBlock nkValignTop">
                            <a href="index.php?file=User&amp;op=userDetail&amp;userId=<?php echo $visitor[$i]; ?>" title="<?php echo SEEPROFILOF.'&nbsp;'.$visitorPseudo; ?>"><?php echo $visitorAvatarImg; ?></a>
                            <figcaption>
                                <a href="index.php?file=User&amp;op=userDetail&amp;userId=<?php echo $visitor[$i]; ?>" title="<?php echo SEEPROFILOF.'&nbsp;'.$visitorPseudo; ?>"><?php echo $visitorCut; ?></a>
                            </figcaption>
                        </figure>
                    <?php
                    } else {
                    ?>
                        <div class="nkAlignCenter"><?php echo NOUSERVISITOR; ?></div>
                    <?php
                    }
                }              
            }
        }

        // Fonction montrant les infos d'un utilisteur
        function statsUser($userId) {
            global $nuked;

            $dbsCommentInfo = ' SELECT pseudo, countForum, countComment, countSuggest, countVisitor
                                FROM '.USER_TABLE.'
                                WHERE id = "'.$userId.'"';
            $dbeCommentInfo = mysql_query($dbsCommentInfo);
            list($pseudo, $countForum, $countComment, $countSuggest, $countVisitor) = mysql_fetch_array($dbeCommentInfo);

            if ($countForum > 0) {
                $CF = '';
                if ($countForum > 1) { 
                    $CF = 's';
                }
                $countForum = '<a href="index.php?file=Search&amp;autor='.$pseudo.'&amp;module=Forum">'.$countForum.'&nbsp;'.MESSAGES.$CF.'</a>';
            } else {
                $countForum = $countForum;
            }
            if ($countComment > 0) {
                $CC = '';
                if ($countComment > 1) { 
                    $CC = 's';
                }
                $countComment = '<a href="index.php?file=Search&amp;autor='.$pseudo.'&amp;module=Comment">'.$countComment.'&nbsp;'.MESSAGES.$CC.'</a>';
            } else {
                $countComment = $countComment;
            }
            if ($countSuggest > 0) {
                $CS = '';
                if ($countSuggest > 1) { 
                    $CS = 's';
                }
                $countSuggest = '<a href="index.php?file=Search&amp;autor='.$pseudo.'&amp;module=Suggest">'.$countSuggest.'&nbsp;'.MESSAGES.$CS.'</a>';
            } else {
                $countSuggest = $countSuggest;
            }
          

            ?>
            <ul>
                <li><?php echo MESSINFORUM; ?>&nbsp;:&nbsp;<?php echo $countForum; ?></li>
                <li><?php echo USERCOMMENT; ?>&nbsp;:&nbsp;<?php echo $countComment; ?></li>
                <li><?php echo USERSUGGEST; ?>&nbsp;:&nbsp;<?php echo $countSuggest; ?></li>
                <li><?php echo USERVISITOR; ?>&nbsp;:&nbsp;<?php echo $countVisitor.'&nbsp;'.TIMES; ?></li>
            </ul>
        <?php
        }

        function updateAccount($pseudo, $privateMail, $publicMail, $passReg, $passConf, $passOld, $userLang, $country, $firstName, $day, $month, $year, $sex, $city, $website, $avatarUrl, $signing, $remove) {
            global $nuked, $user, $modulePref, $modName;

            if ($remove == 0 && $modulePref['userAccountDelete'] == "on") {
            ?>

                <form action="index.php?file=User&amp;op=delAccount" method="post">
                    <article>
                        <header class="nkAlignCenter">
                            <h3><?php echo DELMYACCOUNT; ?></h3>
                        </header>
                        <div class="nkAlignCenter">
                            <span class="nkBlock"><?php echo REMOVECONFIRM; ?></span>
                            <label><?php echo USERPASSWORD; ?></label>&nbsp;:&nbsp;
                                <input class="nkInput nkMarginTop15" type="password" name="pass" size="15" maxlength="15" />
                        </div>
                        <div class="nkAlignCenter nkMarginTop15">
                            <input class="nkButton" type="submit" value="<?php echo SEND; ?>" />
                            &nbsp;
                            <input class="nkButton" type="button" value="<?php echo CANCEL; ?>" onclick="document.location='index.php?file=User&amp;op=editAccount'" />
                        </div>
                    </article>
                </form>
            <?php
            } else {
                $privateMail = mysql_real_escape_string(stripslashes($privateMail));
                $publicMail  = mysql_real_escape_string(stripslashes($publicMail));
                $pseudo      = htmlentities($pseudo, ENT_QUOTES);
                $privateMail = htmlentities($privateMail);
                $publicMail  = htmlentities($publicMail);
                $age         = $day.'/'.$month.'/'.$year;

                $dbsUserInfo = 'SELECT ut.pseudo, ut.privateMail, ut.pass, ut.avatar,
                                  (
                                      SELECT COUNT(bt.pseudo) 
                                      FROM '.BANNED_TABLE.' AS bt 
                                      WHERE bt.pseudo = "'.$pseudo.'" 
                                  ) AS bannedPseudo, 
                                  ( 
                                      SELECT COUNT(u.pseudo) 
                                      FROM '.USER_TABLE.' AS u 
                                      WHERE pseudo = "'.$pseudo.'" 
                                      AND id != "'.$user[0].'" 
                                  ) AS reservedPseudo, 
                                  ( 
                                      SELECT COUNT(bte.email) 
                                      FROM '.BANNED_TABLE.' AS bte 
                                      WHERE bte.email = "'.$pseudo.'" 
                                  ) AS bannedMail, 
                                  ( 
                                      SELECT COUNT(u.privateMail) 
                                      FROM '.USER_TABLE.' AS u 
                                      WHERE privateMail = "'.$privateMail.'" 
                                      AND id != "'.$user[0].'"
                                  ) AS reservedMail 
                                FROM '.USER_TABLE.' AS ut 
                                WHERE ut.id = "'.$user[0].'"';
                $dbeUserInfo = mysql_query($dbsUserInfo);
                list($oldPseudo, $oldMail, $oldPass, $oldAvatar, $bannedPseudo, $reservedPseudo, $bannedMail, $reservedMail) = mysql_fetch_array($dbeUserInfo);

                if ($pseudo != $oldPseudo) {
                    if (!$pseudo || ($pseudo == "") || (preg_match("`[\$\^\(\)'\"?%#<>,;:]`", $pseudo))) {
                        $GLOBALS['nkTpl']->nkExitAfterError(BADUSERNAME, 'nkAlert nkAlertError');
                        redirect('index.php?file=User&op=editAccount', 2);
                    } elseif (strlen($pseudo) > 30) {
                        $GLOBALS['nkTpl']->nkExitAfterError(NICKTOLONG, 'nkAlert nkAlertError');
                        redirect('index.php?file=User&op=regScreen', 2);
                    } elseif ($reservedPseudo > 0) {
                        $GLOBALS['nkTpl']->nkExitAfterError(NICKINUSE, 'nkAlert nkAlertError');
                        redirect('index.php?file=User&op=editAccount', 2);
                    } elseif ($bannedPseudo > 0) {
                        $GLOBALS['nkTpl']->nkExitAfterError(NICKBANNED, 'nkAlert nkAlertError');
                        redirect('index.php?file=User&op=editAccount', 2);
                    } elseif (!Check_Hash($passOld, $oldPass) || !$passOld) {
                        $GLOBALS['nkTpl']->nkExitAfterError(BADOLDPASS, 'nkAlert nkAlertError');
                        redirect('index.php?file=User&op=editAccount', 2);
                    } else {
                        $dbuUserInfo = 'UPDATE '.USER_TABLE.' 
                                        SET pseudo    = "'.$pseudo.'", 
                                            oldPseudo = "'.$oldPseudo.'"
                                        WHERE id = "'.$user[0].'"';
                        $dbeUserInfo = mysql_query($dbuUserInfo);
                    }
                }
                if ($privateMail != $oldMail) {
                    if ($reservedMail > 0) {
                        $GLOBALS['nkTpl']->nkExitAfterError(MAILINUSE, 'nkAlert nkAlertError');
                        redirect('index.php?file=User&op=editAccount', 2);
                    }
                    if ($bannedMail > 0) {
                        $GLOBALS['nkTpl']->nkExitAfterError(MAILBANNED, 'nkAlert nkAlertError');
                        redirect('index.php?file=User&op=editAccount', 2);
                    } elseif (!Check_Hash($passOld, $oldPass) || !$passOld) {
                        $GLOBALS['nkTpl']->nkExitAfterError(BADOLDPASS, 'nkAlert nkAlertError');
                        redirect('index.php?file=User&op=editAccount', 2);
                    } else {
                        $dbuUserInfo = 'UPDATE '.USER_TABLE.' 
                                        SET privateMail = "'.$privateMail.'" 
                                        WHERE id = "'.$user[0].'"';
                        $dbeUserInfo = mysql_query($dbuUserInfo);
                    }
                }
                if ($passReg != '' || $passConf != '') {
                    if ($passReg != $passConf) {
                        $GLOBALS['nkTpl']->nkExitAfterError(PASSFAILED, 'nkAlert nkAlertError');
                        redirect('index.php?file=User&op=editAccount', 2);
                    } elseif (!Check_Hash($passOld, $oldPass) || !$passOld) {
                        $GLOBALS['nkTpl']->nkExitAfterError(BADOLDPASS, 'nkAlert nkAlertError');
                        redirect('index.php?file=User&op=editAccount', 2);
                    } else {
                        $cryptpass = nk_hash($passReg);
                        $dbuUserInfo = 'UPDATE '.USER_TABLE.' 
                                        SET pass = "'.$cryptpass.'" 
                                        WHERE id = "'.$user[0].'"';
                        $dbeUserInfo = mysql_query($dbuUserInfo);
                    }
                }
                if (!empty($website) && !is_int(stripos($website, 'http://'))) {
                    $website = 'http://'.$website;
                }
                // verification si avatar Url est rempli
                if ($avatarUrl == '') {
                    $avatarUrl = null;
                }
                //Upload du fichier et choix du répertoire de destination
                $avatar = $GLOBALS['nkFunctions']->UploadFiles($modName, 'avatarUpload', $avatarUrl);

                // recuperation de l'ancien avatar 
                if ($avatar != $oldAvatar) {
                    if (is_file($oldAvatar) && function_exists('unlink')) {
                        unlink($oldAvatar);
                    }
                }
                $dbuUpdate = '  UPDATE '.USER_TABLE.' 
                                SET publicMail   = "'.$publicMail.'", 
                                    userLanguage = "'.$userLang.'",
                                    country      = "'.$country.'",
                                    firstName    = "'.$firstName.'",
                                    age          = "'.$age.'",
                                    sex          = "'.$sex.'",
                                    city         = "'.$city.'",
                                    website      = "'.$website.'",
                                    avatar       = "'.$avatar.'",
                                    signing      = "'.$signing.'"
                                WHERE id = "'.$user[0].'"';
                $dbeUpdate = mysql_query($dbuUpdate);
                echo $GLOBALS['nkTpl']->nkDisplaySuccess(INFOMODIF, 'nkAlert nkAlertSuccess');
                redirect("index.php?file=User", 1);
            }
        }

        function userDetail($userId) {
            global $nuked, $language, $user, $visiteur;

                if ($userId == '') {
                    $userId = $user[0];
                }
                $dbsUserInfo = 'SELECT U.pseudo, U.website, U.privateMail, U.publicMail, U.created, U.avatar, U.countForum, U.countComment, U.countSuggest, S.lastUsed, U.countVisitor, U.lastVisitor            FROM '.USER_TABLE.' AS U 
                                LEFT JOIN '.SESSIONS_TABLE.' AS S ON U.id = S.userId 
                                WHERE U.id = "'.$userId.'"';
                $dbeUserInfo = mysql_query($dbsUserInfo);
                list($pseudo, $website, $privateMail, $publicMail, $created, $avatar, $countForum, $countComment, $countSuggest, $lastUsed, $countVisitor, $lastVisitor) = mysql_fetch_array($dbeUserInfo);
                if ($visiteur && $user[0] != $userId) {
                    $newCountVisitor = $countVisitor + 1;
                    $explodeVisitor = explode('|', $lastVisitor);
                    foreach ($explodeVisitor as $visitorKey => $visitorValue) {
                        if (!in_array($user[0], $explodeVisitor)) {
                            if ($lastVisitor != '') {
                                $newLastVisitor = $lastVisitor.'|'.$user[0];
                            } else {
                                $newLastVisitor = $user[0];
                            }
                            $dbuVisitor = ' UPDATE '.USER_TABLE.'
                                            SET lastVisitor  = "'.$newLastVisitor.'"
                                            WHERE id = "'.$userId.'"';
                            $dbeVisitor = mysql_query($dbuVisitor);
                        }
                        $dbuVisitorCount = 'UPDATE '.USER_TABLE.'
                                            SET countVisitor = "'.$newCountVisitor.'"
                                            WHERE id = "'.$userId.'"';
                        $dbeVisitorCount = mysql_query($dbuVisitorCount);
                    }
                }
                ?>
                <div class="userDetailContent">
                    <header>
                        <h3 class="nkAlignCenter"><?php echo PROFILOF.'&nbsp;'.$pseudo; ?></h3>
                    </header>
                    <div id="userDetailContent" class="nkWidthFull nkValignTop nkMarginLRAuto">
                        <section class="nkAlignLeft nkMarginBottom15">
                            <header class="nkSize14 nkAlignCenter nkPadding nkBold"><?php echo INFOUSER; ?></header>
                            <article class="nkPadding nkAlignCenter">
                                <?php
                                    infoUser($userId);
                                ?>
                            </article>
                        </section>
                        <section class="nkAlignLeft nkMarginBottom15">
                            <header class="nkSize14 nkAlignCenter nkPadding nkBold"><?php echo STATSUSER; ?></header>
                            <article class="nkPadding">
                                <?php
                                    statsUser($userId);
                                ?>
                            </article>
                        </section>
                        <section class="nkAlignLeft nkMarginBottom15">
                            <header class="nkSize14 nkAlignCenter nkPadding nkBold"><?php echo LASTVISITOR; ?></header>
                            <article class="nkPadding">
                                <?php
                                    infoVisitor($userId);
                                ?>
                            </article>
                        </section>
                    </div>
                </div>
        <?php
            if ($user[0] == $userId) {
                echo $GLOBALS['nkFunctions']->nkHistoryBack(null, 'nkAlignCenter');
            }
        }

        function memberList() {
            global $nuked, $theme, $modulePref;

            if ($_REQUEST['letter'] == OTHER) {
                $and = "AND pseudo NOT REGEXP '^[a-zA-Z].'";
            } elseif ($_REQUEST['letter'] != '' && preg_match('`^[A-Z]+$`', $_REQUEST['letter'])) {
                $and = "AND pseudo LIKE '" . $_REQUEST['letter'] . "%'";
            } else {
                $and = '';
            }
            $dbsCount = '   SELECT pseudo FROM '.USER_TABLE.' 
                            WHERE level > 0 '.$and;
            $dbeCount = mysql_query($dbsCount);
            $dbuCount = mysql_num_rows($dbeCount);
            if (!$_REQUEST['p']) {
                $_REQUEST['p'] = 1;
            }
            $start = $_REQUEST['p'] * $modulePref['maxMembers'] - $modulePref['maxMembers'];
            $alpha = array ("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", OTHER);
            ?>
            <article>
                <header>
                    <h3 class="nkAlignCenter"><?php echo MEMBERLIST; ?></h3>
                </header>
                <article class="nkAlignCenter nkMarginBottom15">
                    <span>
                        [ <a href="index.php?file=User&amp;op=memberList"><?php echo ALL; ?></a>&nbsp;|&nbsp;
                        <?php
                        $num = count($alpha) - 1;
                        $counter = 0;
                        while (list(, $lettre) = each($alpha)) {
                        ?>
                            <a href="index.php?file=User&amp;op=memberList&amp;letter=<?php echo $lettre; ?>"><?php echo $lettre; ?></a>
                            <?php
                            if ($counter == round($num / 2)) {
                                echo ' ]<br />[ ';
                            } elseif ($counter != $num) {
                                echo ' | ';
                            }
                            $counter++;
                        } 
                        ?>
                        &nbsp;]
                    </span>
                </article>
            </article>
            <?php
            if ($dbuCount > $modulePref['maxMembers']) {
                $url_members = 'index.php?file=User&amp;op=memberList&amp;letter='.$_REQUEST['letter'];
                number($dbuCount, $modulePref['maxMembers'], $url_members);
            } 

                $userDetail = '<ul class="nkMemberTitle">';
                $userDetail .= '<li>Pays</li>';
                $userDetail .= '<li class="nkWidthQuarter">Pseudo</li>';
                $userDetail .= '<li>Email</li>';
                $userDetail .= '<li>Website</li>';
                $userDetail .= '</ul>';
                // initialize
                $imgMail = '';
                $dbsUserInfo = 'SELECT id, pseudo, publicMail, website, country            
                                FROM '.USER_TABLE.'
                                WHERE level > 0 '.$and.'
                                ORDER BY pseudo 
                                LIMIT '.$start.', '.$modulePref['maxMembers'];
                $dbeUserInfo = mysql_query($dbsUserInfo);
                while(list($userId, $pseudo, $publicMail, $website, $userCountry) = mysql_fetch_array($dbeUserInfo)) {

                    if ($userCountry) {
                        $lang = substr(strtoupper($userCountry), 0, 2);
                        $userCountry = '<li><span class="nkFlags'.$lang.'" title="'.$userCountry.'"></span></li>';
                    } else {
                        $userCountry = '<li><span class="nkIconBlock" title="'.UNKNOW.'"></span></li>';
                    }

                    if ($publicMail && is_file('themes/'.$theme.'/images/mail.png')) {
                        $imgMail = '<a href="mailto:'.$publicMail.'" title="'.MAILHIM.'"><img src="themes/'.$theme.'/images/mail.png" /></a>';
                    } elseif ($publicMail) {
                        $imgMail = '<a href="mailto:'.$publicMail.'" title="'.MAILHIM.'"><span class="nkIconEmail" /></a>';
                    } else {
                        $imgMail = '<span class="nkIconBlock" title="'.UNKNOW.'" />';
                    }

                    if ($website != "" && preg_match("`http://`i", $website) && is_file('themes/'.$theme.'/images/website.png')) {
                        $website = '<a href="'.$website.'" title="'.$website.'" target="_blank"><img src="themes/'.$theme.'/images/website.png" /></a>';
                    } elseif ($website != "" && preg_match("`http://`i", $website)) {
                        $website = '<a href="'.$website.'" title="'.$website.'" target="_blank"><span class="nkIconGlobe" title="'.$website.'" /></a>';
                    } else {
                        $website = '<span class="nkIconBlock" title="'.UNKNOW.'" />';
                    } 


                    $userDetail .= '<ul class="nkMemberList">';
                    $userDetail .= $userCountry;
                    $userDetail .= '<li class="nkWidthQuarter"><a href="index.php?file=User&amp;op=userDetail&amp;userId='.$userId.'" title="'.SEEPROFILOF.'&nbsp;'.$pseudo.'">'.$pseudo.'</a></li>';
                    $userDetail .= '<li>'.$imgMail.'</li>';
                    $userDetail .= '<li>'.$website.'</li>';
                    $userDetail .= '</ul>';
                }

                echo '<nav id="memberList" class="nkWidthFull nkMarginLRAuto">'.$userDetail.'</nav>';
        }

        function envoiMail($email) {
            global $nuked;

            $pattern = '#^[a-z0-9]+[a-z0-9._-]*@[a-z0-9.-]+.[a-z0-9]{2,3}$#';
            if(!preg_match($pattern, $email)) {
                echo $GLOBALS['nkTpl']->nkDisplayError(WRONGMAIL, 'nkInitError');
                redirect("index.php?file=User&op=oubliPass", 3);                
                footer();
                exit();
            }

            $dbsTokenS = '  SELECT pseudo, token, token_time 
                            FROM '.USER_TABLE.' 
                            WHERE mail = "'.$email.'"';
            $dbuTokenS = mysql_query($dbsTokenS);
            $count = mysql_num_rows($dbsTokenS);
            $data = mysql_fetch_assoc($dbsTokenS);

            if ($count > 0) {
                if ($data['token'] != null && (time() - $data['token_time']) < 3600) {
                    echo $GLOBALS['nkTpl']->nkDisplayError(LINKALWAYSACTIVE, 'nkAlertError');
                    redirect('index.php', 3);                    
                    footer();
                    exit();
                } elseif ($data['token'] == null || ($data['token'] != null && (time() - $data['token_time']) > 3600)) {
                    $newToken = uniqid();
                    $dbuToken = '   UPDATE '.USER_TABLE.' 
                                    SET token = "'.$newToken.'", 
                                        token_time = "'.time().'" 
                                    WHERE mail = "'.mysql_real_escape_string($email).'"';
                    $dbeToken = mysql_query($dbuToken);

                    $link = '<a href="'.$nuked['url'].'/index.php?file=User&op=envoiPass&email='.$email.'&token='.$newToken.'">'.$nuked['url'].'/index.php?file=User&op=envoiPass&email='.$email.'&token='.$newToken.'</a>';

                    $message = '<html>
                                    <body>
                                        <p>'.HI.'&nbsp;'.$data['pseudo'].',</p>
                                        <p>'.LINKTONEWPASSWORD.' : </p>
                                        <p>'.$link.'</p>
                                        <p>'.LINKTIME.'</p>
                                        <p>'.$nuked['name'].' - '.$nuked['slogan'].'</p>
                                    </body>
                                </html>';
                    $headers ='From: '.$nuked['name'].' <'.$nuked['contactMail'].'>';
                    $headers .='Reply-To: '.$nuked['contactMail'];
                    $headers .='Content-Type: text/html; charset="iso-8859-1"';
                    $headers .='Content-Transfer-Encoding: 8bit'; 

                    $message = @html_entity_decode($message);

                    @mail($email, LOSTPASSWORD, $message, $headers);

                    echo $GLOBALS['nkTpl']->nkDisplaySuccess(MAILSEND, 'nkAlertSuccess');
                    redirect("index.php", 3);
                }
            }
            else{
                echo $GLOBALS['nkTpl']->nkDisplayError(MAILNOEXIST, 'nkAlertError');
                redirect('index.php?file=User&op=oubliPass', 3);
            }    
        }

        function envoiPass($email, $token) {
            global $nuked;

            $pattern = '#^[a-z0-9]+[a-z0-9._-]*@[a-z0-9.-]+.[a-z0-9]{2,3}$#';
            if(!preg_match($pattern, $email)) {
                echo $GLOBALS['nkTpl']->nkDisplayError(WRONGMAIL, 'nkAlertError');
                redirect("index.php", 3);                
                footer();
                exit();
            }

            $pattern = '#^[a-z0-9]{13}$#';
            if(!preg_match($pattern, $token)) {
                echo $GLOBALS['nkTpl']->nkDisplayError(WRONGTOKEN, 'nkAlertError');
                redirect("index.php", 3);                
                footer();
                exit();
            }

            $dbsToken = '   SELECT pseudo, token, token_time 
                            FROM '.USER_TABLE.' 
                            WHERE mail = "'.$email.'"';
            $dbeToken = mysql_query($dbsToken);
            $count    = mysql_num_rows($dbeToken);
            $data     = mysql_fetch_assoc($dbeToken);

            if ($count > 0) {
                if ($data['token'] != null && (time() - $data['token_time']) < 3600) {
                    if ($token == $data['token']) {
                        $new_pass = makePass();

                        $message = '<html>
                                        <body>
                                            <p>'.HI.'&nbsp;'.$data['pseudo'].',</p>
                                            <p>'.NEWPASSWORD.'&nbsp;:&nbsp;</p>
                                            <p>'.$new_pass.'</p>
                                            <p>'.$nuked['name'].' - '.$nuked['slogan'].'</p>
                                        </body>
                                    </html>';
                        $headers ='From: '.$nuked['name'].' <'.$nuked['contactMail'].'>';
                        $headers .='Reply-To: '.$nuked['contactMail'];
                        $headers .='Content-Type: text/html; charset="iso-8859-1"';
                        $headers .='Content-Transfer-Encoding: 8bit'; 

                        $message = @html_entity_decode($message);

                        @mail($email, YOURNEWPASSWORD, $message, $headers);

                        $new_pass = nk_hash($new_pass);

                        $dbuPass = 'UPDATE '.USER_TABLE.' 
                                    SET pass = "'.$new_pass.'", 
                                        token = "null", 
                                        token_time = "0" 
                                    WHERE mail = "'.mysql_real_escape_string($email).'"';
                        $dbePass = mysql_query($dbuPass);
                        echo $GLOBALS['nkTpl']->nkDisplaySuccess(NEWPASSSEND, 'nkAlertSuccess');
                        redirect('index.php?file=User&op=loginScreen', 3);
                    } else {
                        echo $GLOBALS['nkTpl']->nkDisplayError(WRONGTOKEN, 'nkAlertError');
                        redirect("index.php", 3);                        
                        footer();
                        exit();
                    }
                } elseif ($data['token'] == null || ($data['token'] != null && (time() - $data['token_time']) > 3600)) {
                    echo $GLOBALS['nkTpl']->nkDisplayError(LINKNOACTIVE, 'nkAlertError');
                    redirect("index.php?file=User&op=oubliPass", 3);                    
                    footer();
                    exit();
                }
            } else {
                echo $GLOBALS['nkTpl']->nkDisplayError(MAILNOEXIST, 'nkAlertError');
                redirect("index.php?file=User&op=oubliPass", 3);
            }
        }

        function makePass() {
            $makepass = '';
            $syllables = 'er,in,tia,wol,fe,pre,vet,jo,nes,al,len,son,cha,ir,ler,bo,ok,tio,nar,sim,ple,bla,ten,toe,cho,co,lat,spe,ak,er,po,co,lor,pen,cil,li,ght,wh,at,the,he,ck,is,mam,bo,no,fi,ve,any,way,pol,iti,cs,ra,dio,sou,rce,sea,rch,pa,per,com,bo,sp,eak,st,fi,rst,gr,oup,boy,ea,gle,tr,ail,bi,ble,brb,pri,dee,kay,en,be,se';
            $syllable_array = explode(',', $syllables);
            srand((double)microtime() * 1000000);
            for ($count = 1;$count <= 4;$count++) {
                if (rand() % 10 == 1) {
                    $makepass .= sprintf('%0.0f', (rand() % 50) + 1);
                } else {
                    $makepass .= sprintf('%s', $syllable_array[rand() % 62]);
                }
            }
            return($makepass);
        }

        function validation() {
            global $user, $nuked, $modulePref;

            if ($modulePref['validation'] == 'mail') {
                $dbsLevel = '   SELECT level 
                                FROM ' . USER_TABLE . ' 
                                WHERE id = "' . $_REQUEST['userId'] . '"';
                $dbeLevel = mysql_query($dbsLevel);
                list($level) = mysql_fetch_array($dbeLevel);

                if ($level > 0) {
                    echo $GLOBALS['nkTpl']->nkDisplayError(ALREADYVALID, 'nkAlertError');
                    redirect('index.php?file=User', 3);
                }
                else {
                    $dbuLevel = ' UPDATE '.USER_TABLE.' 
                                    SET level = 1 
                                    WHERE id = "'.$_REQUEST['userId'].'"';
                    $dbeLevel = mysql_query();

                    echo $GLOBALS['nkTpl']->nkDisplaySuccess(VALUSERID, 'nkAlertError');
                    redirect('index.php?file=User&op=loginScreen', 3);
                }
            }
        }

        /**
         * Delete moderator from FORUM_TABLE with a user ID
         * @param integer $userId : a user ID
         * @return bool : true if delete success, false if not
         */
        function delModerator($userId) {
            $dbsResultQuery = ' SELECT id,moderateurs 
                                FROM '.FORUM_TABLE.' 
                                WHERE moderateurs LIKE "%' . $userId . '%"';
            $dbeResultQuery = mysql_query($dbsResultQuery);
            while (list($forumID, $listModos) = mysql_fetch_row($dbeResultQuery)) {
                if (is_int(strpos($listModos, '|'))) {
                    var_dump($listModos);
                    $tmpListModos = explode('|', $listModos);
                    $tmpKey       = array_search($userId, $tmpListModos);
                    if ($tmpKey !== false) {
                        unset($tmpListModos[$tmpKey]);
                        $tmpListModos = implode('|', $tmpListModos);
                        $dbuUpdateQuery = ' UPDATE '.FORUM_TABLE.' 
                                            SET moderateurs = "' . $tmpListModos . '" 
                                            WHERE id = "' . $forumID . '"';
                        $dbeUpdateQuery = mysql_query($dbuUpdateQuery);
                    }
                } else {
                    if ($userId == $listModos) {
                        $dbuUpdateQuery = ' UPDATE '.FORUM_TABLE.' 
                                            SET moderateurs = ""
                                            WHERE id = "'.$forumID.'"';
                        $dbeUpdateQuery = mysql_query($dbuUpdateQuery);
                    }
                }
            }
            if ($dbeResultQuery) {
                return true;
            } else {
                return false;
            }
        }
            

        function delAccount($pass) {
            global $user, $nuked;

            if ($pass != '' && $modulePref['userAccountDelete'] == 'on') {
                $dbsDel = ' SELECT pass 
                            FROM '.USER_TABLE.' 
                            WHERE id = "'.$user[0].'"';
                $dbeDel = mysql_query($dbsDel);
                $dbpass = mysql_fetch_row($dbeDel);
                if (Check_Hash($pass, $dbpass[0])) {
                    $del1 = delModerator($user[0]);
                    // suppression de la session
                    $dbdSession = ' DELETE FROM '.SESSIONS_TABLE.' 
                                    WHERE userId = "'.$user[0].'"';
                    $dbeSession = mysql_query($dbdSession);
                    // suppression du compte utilisateur
                    $dbdUser = 'DELETE FROM '.USER_TABLE.' 
                                WHERE id = "'.$user[0].'"';
                    $dbeUser = mysql_query($dbdUser);
                    echo $GLOBALS['nkTpl']->nkDisplaySuccess(ACCOUNTDELETE, 'nkAlertError');
                    redirect("index.php", 2);
                } else {
                    echo $GLOBALS['nkTpl']->nkDisplayError(BADPASSWORD, 'nkAlertError');
                    redirect("index.php?file=User&op=editAccount", 2);
                }
            } else {
                    echo $GLOBALS['nkTpl']->nkDisplayError(NOPASSWORD, 'nkAlertError');
                redirect("index.php?file=User&op=editAccount", 2);
            }
        }

        switch ($_REQUEST['op']) {

            case"index":
                index();
                break;

            case"regScreen":                
                regScreen();                
                break;

            case"loginScreen":
                loginScreen();
                break;

            case"reg":                
                reg($_REQUEST['pseudo'], $_REQUEST['privateMail'], $_REQUEST['publicMail'], $_REQUEST['passReg'], $_REQUEST['passConf'], $_REQUEST['userLang'], $_REQUEST['country'], $_REQUEST['firstName'], $_REQUEST['day'], $_REQUEST['month'], $_REQUEST['year'], $_REQUEST['sex'], $_REQUEST['city'], $_REQUEST['website'], $_REQUEST['avatarUrl'], $_REQUEST['signing']);
                break;

            case"login":
                login($_REQUEST['pseudo'], $_REQUEST['pass'], $_REQUEST['rememberMe']);
                break;

            case"logout":
                logout();
                break;

            case"loginMessage":
                loginMessage();
                break;

            case"editAccount":                
                editAccount();                
                break;

            case"updateAccount": 
                updateAccount($_REQUEST['pseudo'], $_REQUEST['privateMail'], $_REQUEST['publicMail'], $_REQUEST['passReg'], $_REQUEST['passConf'], $_REQUEST['passOld'], $_REQUEST['userLang'], $_REQUEST['country'], $_REQUEST['firstName'], $_REQUEST['day'], $_REQUEST['month'], $_REQUEST['year'], $_REQUEST['sex'], $_REQUEST['city'], $_REQUEST['website'], $_REQUEST['avatarUrl'], $_REQUEST['signing'], $_REQUEST['remove']);                
                break;

            case"showAvatar":
                showAvatar();
                break;

            case"changeTheme":                
                changeTheme();                
                break;

            case"modifTheme":
                modifTheme($_REQUEST['userTheme']);
                break;

            case"applyTheme":
                applyTheme();
                break;

            case"modifLang":
                modifLang($_REQUEST);
                break;

            case"userDetail":
                userDetail($_REQUEST['userId']);
                break;

            case"memberList":
                memberList();
                break;

            case"oubliPass":                
                oubliPass();                
                break;

            case"envoiPass":                
                envoiPass($_REQUEST['email'], $_REQUEST['token']);                
                break;

            case"validation":                
                validation();                
                break;

            case"delAccount":                
                delAccount($_REQUEST['pass']);                
                break;

            case"envoiMail":                
                envoiMail($_REQUEST['email']);                
                break;

            default:
                index();
                break;
        }
    }
} else {
    // Si il y a une ou des erreur(s) on les affiche.
    echo $GLOBALS['nkInitError'];
}
?>