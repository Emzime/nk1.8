<?php
/**
*   Block Login
*   Display account details
*
*   @version 1.8
*   @link http://www.nuked-klan.org Clan Management System 4 Gamers NK CMS
*   @license http://opensource.org/licenses/gpl-license.php GNU Public License
*   @copyright 2001-2013 Nuked Klan 
*/
defined('INDEX_CHECK') or die('<div class="nkAlignCenter">'.CANTOPENPAGE.'</div>');

if (defined('TESTLANGUE')) { 

    function affichBlockLogin($blok) {
        global $user, $nuked, $visiteur;
        list($login, $messpv, $members, $online, $avatar) = explode('|', $blok['content']); 
        $blok['content'] = '<div class="nkBlockLogin">';
        $c = 0; 
        if ($login != 'off') {
            if (!$user) {
                $blok['content'] .= '
                                    <form action="index.php?file=User&amp;nuked_nude=index&amp;op=login" method="post">
                                        <div>
                                            <label for="BlockLoginPseudo">'.PSEUDO.' : </label>
                                                <input id="BlockLoginPseudo" class="nkInput" type="text" name="pseudo" size="10" maxlength="250" />
                                        </div>
                                        <div>
                                            <label for="BlockLoginPassword">'.PASSWORD.' : </label>
                                                <input id="BlockLoginPassword" class="nkInput" type="password" name="pass" size="10" maxlength="15" />
                                        </div>';                                                                        
                $blok['content'] .=     $GLOBALS['nkFunctions']->nkCheckBox('rememberMe', 'Remember', 'BlockLoginRememberId', 'BlockLoginRemember nkInline', REMEMBERME, 'ok', true);
                $blok['content'] .= '           <input type="submit" class="nkButton" value="'.SEND.'" />                                       
                                        <nav>
                                            <small>
                                                <a href="index.php?file=User&amp;op=reg_screen">'.REGISTER.'</a>&nbsp;/&nbsp;
                                                <a href="index.php?file=User&amp;op=oubli_pass">'.PASSFORGET.' ?</a>
                                            </small>
                                        </nav>
                                    </form>';
            } else {
                $blok['content'] .= '
                                    <h4>'.WELCOME.', <small>'.$user[2].'</small></h4>';
                                if ($avatar != 'off') {
                                    $dbsAvatar = '  SELECT avatar 
                                                    FROM '.USER_TABLE.' 
                                                    WHERE id = \''.$user[0].'\' ';
                                    $dbeAvatar = mysql_query($dbsAvatar);
                                    list($avatarUrl) = mysql_fetch_array($dbeAvatar);
                                    if ($avatarUrl) {
                                        $blok['content'] .= '
                                        <figure>
                                            <img src="'.$avatarUrl.'" alt="'.$user[2].' avatar" />
                                        </figure>';
                                    } else {                                        
                                        $blok['content'] .= '
                                        <figure>
                                            <img src="images/noavatar.png" alt="" />
                                        </figure>';
                                    }
                                }
                $blok['content'] .= '
                                    <nav>
                                        <a href="index.php?file=User" class="nkButtonLink">'.ACCOUNT.'</a> / 
                                        <a href="index.php?file=User&amp;nuked_nude=index&amp;op=logout" class="nkButtonLink">'.LOGOUT.'</a>
                                    </nav>';
            }
            $c++;
        }

        if ($messpv != 'off' && $user) {
            if ($c > 0) {
                $blok['content'] .= '
                                    <div class="nkSeparator"></div>';
            }
            $dbsMessPvIdRead = 'SELECT id 
                                FROM '.USERBOX_TABLE.' 
                                WHERE userFor = \''.$user[0].'\' 
                                AND status = 1';
            $dbeMessPvIdRead = mysql_query($dbsMessPvIdRead);
            $dbcMessPvIdRead = mysql_num_rows($dbeMessPvIdRead);        
            $blok['content'] .= '   <h5>
                                        <span class="nkIconMail"></span>'.MESSPV.'
                                    </h5>
                                    <ul>';      
            if ($user[5] > 0) { 
                $blok['content'] .= '   <li>
                                            <span class="nkIconMailReceive"></span>'.NOTREAD.' : <a href="index.php?file=Userbox">'.$user[5].'</a>
                                        </li>';
            } else {
                $blok['content'] .= '   <li>
                                            <span class="nkIconMailReceive"></span>'.NOTREAD.' : '.$user[5].'
                                        </li>';
            }       
            if ($dbcMessPvIdRead > 0) {
                $blok['content'] .= '   <li>
                                            <span class="nkIconMailLock"></span>'.READ.' : <a href="index.php?file=Userbox">'.$dbcMessPvIdRead.'</a>
                                        </li>';
            } else {
                $blok['content'] .= '   <li>
                                            <span class="nkIconMailLock"></span>'.READ.' : '.$dbcMessPvIdRead.'
                                        </li>';
            }       
            $blok['content'] .='    </ul>';
            $c++;
        }

        if ($members != 'off') {
            if ($c > 0) {
                $blok['content'] .= '
                                    <div class="nkSeparator"></div>';
            }
            $blok['content'] .= '   <h5>
                                        <span class="nkIconMembers"></span>'.MEMBERS.'
                                    </h5>
                                    <ul>';
            $dbsMembers = ' SELECT count(id) AS nbMembers, 
                                (
                                  SELECT count(id)
                                  FROM '.USER_TABLE.' 
                                  WHERE level >1
                                 ) AS nbAdmins,
                                (
                                  SELECT pseudo
                                  FROM '.USER_TABLE.' 
                                  ORDER BY created DESC 
                                  LIMIT 0, 1
                                 ) AS lastMembers
                            FROM '.USER_TABLE.' 
                            WHERE level = 1';
            $dbeMembers = mysql_query($dbsMembers);
            list($nbMembers, $nbAdmins, $lastMembers) = mysql_fetch_array($dbeMembers);
            $blok['content'] .= '       <li>
                                            <span class="nkIconNext"></span>'.ADMINS.' : '.$nbAdmins.'
                                        </li>
                                        <li>
                                            <span class="nkIconNext"></span>'.MEMBERS.' : '.$nbMembers.' [ <a href="index.php?file=Members">'.LISTING.'</a> ]
                                        </li>
                                        <li>
                                            <span class="nkIconNext"></span>'.LASTMEMBER.' : <a href="index.php?file=Members&amp;op=detail&amp;autor='.urlencode($lastMembers).'">'.$lastMembers.'</a>
                                        </li>
                                    </ul>';
            $c++;
        }

        if ($online != 'off') {
            $nb = nbvisiteur();
            if ($nb[1] > 0) { 
                $userOnline = '<ul>';
                $dbsUserOnline = '  SELECT userName 
                                    FROM '.NBCONNECTE_TABLE.' 
                                    WHERE type = 1 
                                    ORDER BY created';
                $dbeUserOnline = mysql_query($dbsUserOnline);
                while (list($userOnlineName) = mysql_fetch_array($dbeUserOnline)) {
                       $userOnline .= '<li>'.$userOnlineName.'</li>';
                }
                $userOnline .= '</ul>';
                // definition du tooltip
                $userList = $GLOBALS['nkFunctions']->nkTooltip($userOnline, '#', '[ '.LISTING.' ]');
            } else {
                $userList = '';
            }
            if ($nb[2] > 0) {
                $adminOnline = '<ul>';
                $dbsAdminOnline = ' SELECT userName 
                                    FROM '.NBCONNECTE_TABLE.' 
                                    WHERE type > 1 
                                    ORDER BY created';
                $dbeAdminOnline = mysql_query($dbsAdminOnline);
                while (list($adminOnlineName) = mysql_fetch_array($dbeAdminOnline)) {
                       $adminOnline .= '<li>'.$adminOnlineName.'</li>';
                }
                $adminOnline .= '</ul>';
                // definition du tooltip
                $adminList = $GLOBALS['nkFunctions']->nkTooltip($adminOnline, '#', '[ '.LISTING.' ]');
            } else {
                $adminList = '';
            }
            if ($c > 0) {
                $blok['content'] .= '
                                    <div class="nkSeparator"></div>';
            }
            $blok['content'] .= '   <h5>
                                        <span class="nkIconAutor"></span>'.WHOISONLINE.'
                                    </h5>
                                    <ul>';      
            $blok['content'] .= '       <li>
                                            <span class="nkIconNext"></span>'.VISITOR;
                                            if ($nb[0] > 1) {
                                                $blok['content'] .= 's';
                                            }
            $blok['content'] .= '           : '.$nb[0].'
                                        </li>
                                        <li>
                                            <span class="nkIconNext"></span>'.MEMBER;
                                            if ($nb[1] > 1) {
                                                $blok['content'] .= 's';
                                            }
            $blok['content'] .= '           : ' . $nb[1] . ' ' . $userList . '
                                        </li>
                                        <li>
                                            <span class="nkIconNext"></span>'.ADMIN;
                                            if ($nb[2] > 1) {
                                                $blok['content'] .= 's';
                                            }
            $blok['content'] .= '           : ' . $nb[2] . ' ' . $adminList . '
                                        </li>
                                    </ul>';     
            $c++;
        }
        $blok['content'] .= '</div>';
        return $blok;
    }

    function edit_block_login($bid){
        global $nuked, $language;

        $sqlBlock = mysql_query('SELECT active, position, titre, module, content, type, nivo, page FROM ' . BLOCK_TABLE . ' WHERE bid = \'' . $bid . '\' ');
        list($activeBlock, $positionBlock, $titleBlock, $modulBlockBlock, $contentBlock, $typeBlock, $nivoBlock, $pagesBlock) = mysql_fetch_array($sqlBlock);
        $titleBlock = printSecuTags($titleBlock);
        list($login, $messpv, $members, $online, $avatar) = explode('|', $contentBlock);

        if ($activeBlock == 1) {
            $checked1 = 'selected="selected"';
        } elseif ($activeBlock == 2) {
            $checked2 = 'selected="selected"';
        } else {
            $checked0 = 'selected="selected"';
        }
        if ($login == 'off') {
            $checked3 = 'selected="selected"'; 
        } else {
            $checked3 = '';
        }
        if ($messpv == 'off') {
            $checked4 = 'selected="selected"'; 
        } else {
            $checked4 = '';
        }
        if ($members == 'off') {
            $checked5 = 'selected="selected"'; 
        } else {
            $checked5 = '';
        }
        if ($online == 'off') {
            $checked6 = 'selected="selected"'; 
        } else {
            $checked6 = '';
        }
        if ($avatar == 'off') {
            $checked7 = 'selected="selected"'; 
        } else {
            $checked7 = '';
        }
        ?>
            <header>
                <h3  class="width_3_quarter inline">
                <?php echo ADMINBLOCK; ?>
                </h3>
                <h4  class="width_quarter inline float-right align-right">
                    <a href="help/<?php echo $language; ?>/block.php" rel="rightBox" data-name="<?php echo BLOCK; ?>"><img src="help/help.gif" alt="" title="<?php echo HELP; ?>" /></a>
                </h4>
            </header>
            <article class="padding-left padding-right margin-bottom margin-top">
                <form method="post" action="index.php?file=Admin&amp;page=block&amp;op=modif_block">
                    <div class="nkBoxcontainer padding-left">
                        <label for="blockLoginTitle" class="nkLabelSpacing"><?php echo TITLE; ?>&nbsp;:&nbsp;</label>
                            <input id="blockLoginTitle" type="text" name="titre" size="40" value="<?php echo $titleBlock; ?>" />
                    </div>
                    <?php
                    /*** Position Options ***/
                    $activeBlockValue = array(
                            0 => LEFT,
                            1 => RIGHT,
                            2 => OFF
                        );
                    echo $GLOBALS['nkFunctions']->nkRadioBox('active', 'nkLabelSpacing', BLOCK, 3, $activeBlockValue, 'InputForactive', 'InputIdactive')
                    ?>
                    <div class="nkBoxcontainer padding-left">
                        <label for="blockLoginPosition" class="nkLabelSpacing"><?php echo POSITION; ?> : </label>
                            <input id="blockLoginPosition" type="text" name="position" size="2" value="<?php echo $positionBlock; ?>" />
                    </div>

                    <div class="nkBoxcontainer padding-left">
                        <label for="nivo" class="nkLabelSpacing"><?php echo LEVEL; ?>&nbsp;:&nbsp;</label>
                            <?php 
                            echo $GLOBALS['nkFunctions']->nkLevelSelect('nivo', $nivoBlock);
                            ?>
                    </div>
                    <?php 
                    /*** Login options ***/
                    $loginValue = array(
                            ON => YES,
                            OFF => NO
                        );
                    echo $GLOBALS['nkFunctions']->nkRadioBox('login', 'nkLabelSpacing', LOGIN.'&nbsp;:&nbsp;', 2, $loginValue, 'blockLoginLoginId');
                    /*** Private message options ***/   
                    $messpvValue = array(
                            ON => YES,
                            OFF => NO
                        );          
                    echo $GLOBALS['nkFunctions']->nkRadioBox('messpv', 'nkLabelSpacing', MESSPV.'&nbsp;:&nbsp;', 2, $messpvValue, 'blockLoginmesspvId');
                    /*** Members options ***/
                    $membersValue = array(
                            ON => YES,
                            OFF => NO
                        );
                    echo $GLOBALS['nkFunctions']->nkRadioBox('members', 'nkLabelSpacing', MEMBERS.'&nbsp;:&nbsp;', 2, $membersValue, 'blockLoginmembersId');
                    /*** Online options ***/
                    $onlineValue = array(
                            ON => YES,
                            OFF => NO
                        );
                    echo $GLOBALS['nkFunctions']->nkRadioBox('online', 'nkLabelSpacing', WHOISONLINE.'&nbsp;:&nbsp;', 2, $onlineValue, 'blockLoginonlineId');
                    /*** Avatar options ***/
                    $avatarValue = array(
                            ON => YES,
                            OFF => NO
                        );
                    echo $GLOBALS['nkFunctions']->nkRadioBox('avatar', 'nkLabelSpacing', SHOWAVATAR.'&nbsp;:&nbsp;', 2, $avatarValue, 'blockLoginavatarId');            
                    ?>
                    <div class="nkBoxcontainer padding-left">
                        <label for="blockLoginPages" class="nkLabelSpacing valign-top"><?php echo PAGESELECT; ?>&nbsp;:&nbsp;</label>
                            <select id="blockLoginPages" class="margin-top" name="pages[]" size="8" multiple="multiple">
                                <?php
                                select_mod2($pagesBlock);
                                ?>
                            </select>
                    </div>
                    <div class="width_quarter align-center margin-top padding-bottom">
                        <input type="hidden" name="type" value="<?php echo $typeBlock; ?>" />
                        <input type="hidden" name="bid" value="<?php echo $bid; ?>" />
                        <input type="submit" name="send" class="nkButton" value="<?php echo SEND; ?>" />
                    </div>
                </form>
            </article>
        <?php
    }
} else {
    echo $GLOBALS['nkTpl']->nkDisplayError(LANGNOTFOUND , 'nkAlignCenter');
}
?>