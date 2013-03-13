<?php
/**
*   News module
*   Display news on database
*
*   @version 1.8
*   @link http://www.nuked-klan.org Clan Management System 4 Gamers NK CMS
*   @license http://opensource.org/licenses/gpl-license.php GNU Public License
*   @copyright 2001-2013 Nuked Klan 
*/
defined('INDEX_CHECK') or die ('<div style="text-align: center;">'.CANTOPENPAGE.'</div>');
$modName = basename(dirname(__FILE__));
include_once 'Includes/nkCaptcha.php';
if (NKCAPTCHA == 'off') $captcha = 0;
else if ((NKCAPTCHA == 'auto' OR NKCAPTCHA == 'on') && (!empty($user) && $user[1] > 0)) $captcha = 0;
else $captcha = 1;

// Initialisation des variables et verifications de leur type
$newsRequestArray = array(
        'integer' => array('p','newsId','categoryId', 'idItem'),
        'boolean' => array('full','listCategory'),
        'string' => array('module')
    );
$GLOBALS['nkFunctions']->nkInitRequest($newsRequestArray,$GLOBALS['indexRequestArray']);
// Verification qu'il n'y a aucune erreur dans le request
if (!isset($GLOBALS['nkInitError'])) {
          
    compteur($modName);

    $modulePref = $GLOBALS['nkFunctions']->nkModsPrefs($modName);

    function index() {

        global $theme, $modName, $visiteur, $adminMod, $modulePref;

        if(!$_REQUEST['p']) {
            $_REQUEST['p'] = 1;
        }
        $pageStart = $_REQUEST['p'] * $modulePref['nbMaxNews'] - $modulePref['nbMaxNews'];

        $day = time();

        if (isset($_REQUEST['categoryId'])) {
            $whereNews = 'nt.category = '.$_REQUEST['categoryId'].' AND '.$day.' >= nt.created ORDER BY created DESC LIMIT '.$pageStart.', '.$modulePref['nbMaxNews'];
            $where     = 'category = '.$_REQUEST['categoryId'].' AND '.$day.' >= created';
        } elseif ($_REQUEST['full'] == 'true') {
            $whereNews = 'nt.id = '.$_REQUEST['newsId'].' AND '.$day.' >= nt.created';
            $where     = 'id = '.$_REQUEST['newsId'].' AND '.$day.' >= created';
        } else {
            $whereNews = $day.' >= nt.created ORDER BY nt.created DESC LIMIT '.$pageStart.', '.$modulePref['nbMaxNews'];
            $where     = $day.' >= created';
        }

        // Affichage des catégories de news
        if ($_REQUEST['listCategory'] == 'true') {
            $htmlCategory = '';
            $dbsCategory = 'SELECT id, title, content, image
                            FROM '.NEWS_CAT_TABLE.' 
                            ORDER BY title';
            $dbeCategory = mysql_query($dbsCategory);
            while ($arrayCategory = mysql_fetch_assoc($dbeCategory)) {
                $htmlCategory .= '  <article class="nkMargin nkMarginBottom15">
                                        <figure class="nkInlineBlock nkMarginRight" style="max-width: 100%;">
                                            <a href="index.php?file=News&amp;categoryId='.$arrayCategory['id'].'"><img style="max-width: 100%;" src="'.$arrayCategory['image'].'" alt=""  title="'. SEENEWS.'&nbsp;'.$arrayCategory['title'].'" /></a>
                                        </figure>
                                        <div class="nkInlineBlock nkValignTop">
                                            <h2 class="nkNoMargin">
                                                '.$arrayCategory['title'].'
                                            </h2>
                                            <div>
                                                '.$arrayCategory['content'].'
                                            </div>
                                        </div>
                                    </article>';
            }
            ?>
            <section class="nkWidthFull nkMarginLRAuto nkPersonalCssForNews">
                <header>                        
                    <h1 class="nkMarginTop15 nkAlignCenter"><?php echo CATEGORYNEWS; ?></h1>
                </header>
                    <?php echo $htmlCategory; ?>
                <footer class="nkAlignCenter">
                    <span>
                        <small>(<?php echo CLICSCREEN; ?>)</small>
                    </span>   
                </footer>
            </section>
            <?php            
        } else {
            // Recuperation du nombre de news pour la pagination
            $dbsNbNews = '  SELECT id 
                            FROM '.NEWS_TABLE.' 
                            WHERE '.$where;
            $dbeNbNews = mysql_query($dbsNbNews);
            $dbcNbNews = mysql_num_rows($dbeNbNews);  
            
            if ($dbcNbNews <= 0) {
            ?>
                <div class="nkAlignCenter nkMarginTop15">
                    <?php echo NONEWSINDB; ?>
                </div>
            <?php
            } else {
                // Génération des news en fonction des requests pour la fonction news()
                $dbsNews = 'SELECT nt.id, nt.autorId, nt.created, nt.title, nt.content, nt.continuation, nt.category, nct.title AS catTitle, nct.image AS catImage, ut.pseudo AS author, ut.avatar AS authorAvatar,
                                (
                                    SELECT COUNT(id) 
                                    FROM '.COMMENT_TABLE.'
                                    WHERE itemId = nt.id
                                    AND module =  "'.$modName.'"
                                ) AS nbComment
                            FROM '.NEWS_TABLE.' AS nt
                            LEFT JOIN '.NEWS_CAT_TABLE.' AS nct ON nct.id = nt.category
                            LEFT JOIN '.USER_TABLE.' AS ut ON ut.id = nt.autorId
                            WHERE '.$whereNews;
                //echo $dbsNews;
                $dbeNews = mysql_query($dbsNews); 
                while ($tabNews = mysql_fetch_assoc($dbeNews)) {
                    if (empty($tabNews['author'])) {
                        $tabNews['author'] = UNKNOWAUTHOR;
                    }

                    $commentLink            = '<a href="index.php?file=News&amp;full=true&amp;newsId=' . $tabNews['id'] . '">'.COMMENT.'</a>';
                    $data['authorUrl']      = 'index.php?file=Members&amp;op=detail&amp;autor='.urlencode($tabNews['author']);
                    $data['authorAvatar']   = $tabNews['authorAvatar'];
                    $data['date']           = nkDate($tabNews['created']);
                    $data['date_timestamp'] = $tabNews['created'];
                    $data['catTitle']       = printSecuTags($tabNews['catTitle']);
                    $data['catId']          = $tabNews['category'];
                    $data['id']             = $tabNews['id'];
                    $data['title']          = printSecuTags($tabNews['title']);
                    $data['author']         = $tabNews['author'];
                    $data['comment']        = $commentLink;
                    $data['linkComment']    = 'index.php?file=News&amp;full=true&amp;newsId='.$tabNews['id'];
                    $data['nbComment']      = $tabNews['nbComment'];
                    $data['printPage']      = '<a title="'.PDF.'" href="index.php?file=News&amp;nuked_nude=index&amp;op=pdf&amp;newsId='.$tabNews['id'].'" onclick="window.open(this.href); return false;"><span class="nkIcon24Pdf"></span></a>';

                    $data['friend']         = '<a title="'.FSEND.'" href="index.php?file=News&amp;op=sendfriend&amp;newsId='.$tabNews['id'].'"><span class="nkIcon24MailSend"></span></a>';

                    if (!empty($tabNews['catImage'])) {
                       $data['catImage'] = '<a title="'.$tabNews['catTitle'].'" href="index.php?file=News&amp;listCategory=true"><img src="'.$tabNews['catImage'].'" alt="'.$tabNews['catTitle'].'" title="'.$tabNews['catTitle'].'" /></a>';
                    } else {
                        $data['catImage'] = '';
                    }

                    if ($_REQUEST['full'] == 'true') {
                        if($visiteur >= $adminMod){
                            ?>
                                <script type="text/javascript">
                                    function delnews(id) {
                                        if (confirm('<?php echo DELTHISNEWS ?> ?')) {
                                            document.location.href = 'index.php?file=News&page=admin&op=do_del&newsId='+id;
                                        }
                                    }
                                </script>
                                <div class="nkAlignRight">
                                    <a href="index.php?file=News&amp;page=admin&amp;op=edit&amp;newsId=<?php echo $tabNews['id']; ?>" title="<?php echo EDIT; ?>">
                                        <span class="nkIcon24Edit"></span>
                                    </a>
                                    <a href="javascript:delnews('<?php echo $tabNews['id']; ?>');" title="<?php echo DEL; ?>">
                                        <span class="nkIcon24Trash"></span>
                                    </a>
                                </div>
                            <?php
                        }
                        if (!empty($tabNews['continuation'])) {
                            $data['content'] = $tabNews['content'].''.$tabNews['continuation'];
                            $data['readMore'] = '';
                        } else {
                            $data['readMore'] = '';
                            $data['content'] = $tabNews['content'];
                        }
                        $newsId = $tabNews['id'];
                                           
                    } elseif (!empty($tabNews['continuation'])) {
                        // Bouton lire la suite du thème ou texte par défaut
                        if ($modulePref['txtReadMore'] == 'off' && is_file('themes/'.$theme.'/images/readmore.png')) {
                            $button = '<img src="themes/'.$theme.'/images/readmore.png" alt="" title="'.READMORE.'" />';
                        } elseif ($modulePref['txtReadMore'] == 'off') {                            
                            $button = '<span class="nkIcon24ReadMore"></span>';
                        } else {
                            $button = READMORE;
                        }
                        $data['readMore'] = '<a title="'.READMORE.'" href="index.php?file=News&amp;full=true&amp;newsId='.$tabNews['id'].'">'.$button.'</a>';
                        $data['content'] = $tabNews['content'];
                    } else {
                        $data['readMore'] = '';
                        $data['content'] = $tabNews['content'];
                    }
                    if (!isset($_REQUEST['nuked_nude'])) {
                        news($data);
                    }
                    
                }
                
                if ($dbcNbNews > $modulePref['nbMaxNews']) {
                    if (isset($_REQUEST['categoryId'])) {
                        $url = 'index.php?file=News&amp;categoryId='.$_REQUEST['categoryId'];
                    } else {
                        $url = 'index.php?file=News';
                    }
                    number($dbcNbNews, $modulePref['nbMaxNews'], $url);
                }                         
            }

            if (isset($newsId)) {
                viewComment($modName, $newsId, $modulePref['nbComment'], $modulePref['commentCut']); 
            }
        }        
    }

    function pdf($newsId) {
        global $nuked, $language, $modulePref;

        if(!is_numeric($newsId)) {
            echo $GLOBALS['nkTpl']->nkDisplayError('Error ID');
        } else {
            $dbsNews = 'SELECT nt.created, nt.title, nt.content, nt.continuation, ut.pseudo 
                        FROM '.NEWS_TABLE.' AS nt
                        LEFT JOIN '.USER_TABLE.' AS ut ON ut.id = nt.autorId
                        WHERE nt.id = '.$newsId;
            $dbeNews = mysql_query($dbsNews);
            $row = mysql_fetch_assoc($dbeNews);
            $row['created'] = nkDate($row['created'], true);

            if (empty($row['pseudo'])) {
                $row['pseudo'] = UNKNOWAUTHOR;
            } else {
                $row['pseudo'] = '<a href="index.php?file=Members&op=detail&autor='.urlencode($row['pseudo']).'">'.$row['pseudo'].'</a>';
            }

            if (empty($row['continuation'])) {
                $content = '<div>'.$row['content'].'</div>';
            } else {
                $content = '<div>'.$row['content'].'</div><div>'.$row['continuation'].'</div>';
            }

            $articleUrl = $nuked['url'].'/index.php?file=News&full=true&news_id='.$newsId;
            $link = '<a href="'.$articleUrl.'">'.$articleUrl.'</a>';
            $siteName = @html_entity_decode($nuked['name']);

            $html = '    <h1>'.$row['title'].'</h1>
                                <div style="font-size:small;text-align:right">'.NEWSPOSTBY.'&nbsp;'.$row['pseudo'].'</div>
                                '.$content.'
                                <hr />
                                <h3>'.$siteName.'</h3>
                                <p>'.$link.'</p>';

            $fileName = $siteName.'_'.$row['title'];
            $fileName = str_replace(' ','_',$fileName);
            $fileName .= '.pdf';

            $GLOBALS['nkFunctions']->generatedPdf($html,$fileName,$modulePref);
        }
    }


    function sendfriend($news_id) {
        global $nuked, $user, $captcha;

        //opentable();

        echo '<script type="text/javascript">function verifchamps(){if(document.REQUESTElementById(\'sf_pseudo\').value.length == 0){alert(\''.NONICK.'\');return false;}if(document.REQUESTElementById(\'sf_mail\').value.indexOf(\'@\') == -1){alert(\''.BADMAIL.'\');return false;}return true;}</script>';

        $sql = mysql_query("SELECT title FROM ".NEWS_TABLE." WHERE id = '$news_id'");
        list($title) = mysql_fetch_array($sql);

        echo '<form method="post" action="index.php?file=News" onsubmit="return verifchamps()">
              <table style="margin:0 auto;text-align:left;" width="60%" cellspacing="1" cellpadding="1" border="0">
              <tr><td align="center"><br /><big><b>'.FSEND.'</b></big><br /><br />'.YOUSUBMIT.' :<br /><br />
              <b>'.$title.'</b><br /><br /></td></tr><tr><td align="left">
              <b>'.YNICK.' : </b>&nbsp;<input type="text" id="sf_pseudo" name="pseudo" value="'.$user[2].'" size="20" /></td></tr>
              <tr><td><b>'.FMAIL.' : </b>&nbsp;<input type="text" id="sf_mail" name="mail" value="mail@gmail.com" size="25" /></td></tr>
              <tr><td><b>'.YCOMMENT.' : </b><br /><textarea name="comment" style="width:100%;" rows="10"></textarea></td></tr>';

        if ($captcha == 1) create_captcha(1);

        echo '<tr><td align="center"><input type="hidden" name="op" value="sendnews" />
              <input type="hidden" name="news_id" value="'.$news_id.'" />
              <input type="hidden" name="title" value="'.$title.'" />
              <input type="submit" value="'.SEND.'" /></td></tr></table></form><br />';

       // closetable();
    }

    function sendnews($title, $news_id, $comment, $mail, $pseudo) {
        global $nuked, $captcha,$user_ip;

        //opentable();

        if ($captcha == 1 && !ValidCaptchaCode($_POST['code_confirm'])) {
            echo '<div style="text-align:center;"><br /><br />'.BADCODECONFIRM.'<br /><br /><a href="javascript:history.back()">[ <b>'.BACK.'</b> ]</a></div>';
        } else {
            $date2 = time();
            $date2 = nkDate($date2);
            $mail = trim($mail);
            $pseudo = trim($pseudo);

            $subject = $nuked['name'].', '.$date2;
            $corps = $pseudo." (IP : $user_ip) ".READNEWS." $title, ".NEWSURL."\r\n{$nuked['url']}/index.php?file=News&op=index_comment&news_id=$news_id\r\n\r\n".YCOMMENT." : $comment\r\n\r\n\r\n{$nuked['name']} - {$nuked['slogan']}";
            $from = "From: {$nuked['name']} <{$nuked['contactMail']}>\r\nReply-To: ".$nuked['contactMail'];

            $subject = @html_entity_decode($subject);
            $corps = @html_entity_decode($corps);
            $from = @html_entity_decode($from);

            mail($mail, $subject, $corps, $from);

            echo '<div style="text-align:center;"><br />'.SENDFMAIL.'<br /><br /></div>';
            redirect('index.php?file=News', 2);
        }

        //closetable();
    }

    switch ($_REQUEST['op']) {

        case'index':
        index();
        break;

        case "viewComment":
        viewComment($_REQUEST['module'], $_REQUEST['idItem']);
        break;

        case "post_com":
        post_com($_REQUEST['module'], $_REQUEST['idItem']);
        break;

        case "post_comment":
        post_comment($_REQUEST['module'], $_REQUEST['idItem'], $_REQUEST['title'], $_REQUEST['text'], $_REQUEST['nick']);
        break;

        case'pdf':
        pdf($_REQUEST['newsId']);
        break;

        case'sendfriend':
        sendfriend($_REQUEST['newsId']);
        break;

        case'sendnews':
        sendnews($_REQUEST['title'], $_REQUEST['news_id'], $_REQUEST['comment'], $_REQUEST['mail'], $_REQUEST['pseudo']);
        break;

        default:
        index();
        break;

    }
} else {
    // Si il y a une ou des erreur(s) on les affiche.
    echo $GLOBALS['nkInitError'];
}
?>
