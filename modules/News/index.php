<?php
/**
*   News module
*   Display files on database
*
*   @version 1.8
*   @link http://www.nuked-klan.org Clan Management System 4 Gamers NK CMS
*   @license http://opensource.org/licenses/gpl-license.php GNU Public License
*   @copyright 2001-2013 Nuked Klan 
*/
defined('INDEX_CHECK') or die ('<div style="text-align: center;">'.CANTOPENPAGE.'</div>');
global $user, $visiteur, $levelMod;
$modName = basename(dirname(__FILE__));

include_once 'Includes/nkCaptcha.php';

if (NKCAPTCHA == 'off') $captcha = 0;
else if ((NKCAPTCHA == 'auto' OR NKCAPTCHA == 'on') && (!empty($user) && $user[1] > 0)) $captcha = 0;
else $captcha = 1;

    // Vérification des variables
    $requestArray = array(
            'p',
            'op'
        );
    $GLOBALS['nkFunctions']->nkInitRequest($requestArray);

    compteur('News');

    function index(){

        global $nuked, $language, $theme;

        $max_news = $nuked['max_news'];
        $day = time();

        if ($_REQUEST['op'] == 'categorie') {
            $where = "WHERE category = '{$_REQUEST['cat_id']}' AND $day >= created";
        } elseif ($_REQUEST['op'] == 'continuation' || $_REQUEST['op'] == 'index_comment') {
            $where = "WHERE id = '{$_REQUEST['news_id']}' AND $day >= created";
        } else {
            $where = "WHERE $day >= created";
        }

        $sql_nbnews = mysql_query("SELECT id FROM ".NEWS_TABLE." $where");
        $nb_news = mysql_num_rows($sql_nbnews);

        if(!$_REQUEST['p']) $_REQUEST['p'] = 1;
        $start = $_REQUEST['p'] * $max_news - $max_news;

        if ($_REQUEST['op'] == 'categorie') {
            $WhereNews = "WHERE category = '{$_REQUEST['cat_id']}' AND $day >= created ORDER BY created DESC LIMIT $start, $max_news";
        } elseif ($_REQUEST['op'] == 'continuation' || $_REQUEST['op'] == 'index_comment') {
            $WhereNews = "WHERE id = '{$_REQUEST['news_id']}'";
        } else {
            $WhereNews = "WHERE $day >= created ORDER BY created DESC LIMIT $start, $max_news";
        }
        
        $sql = mysql_query("SELECT id, autor, autorId, created, title, content, continuation, category FROM ".NEWS_TABLE." $WhereNews");
        
        if (mysql_num_rows($sql) <= 0) {
            echo '<p style="text-align: center">'.NONEWSINDB . '</p>';
        }
        
        while ($TabNews = mysql_fetch_assoc($sql)) {
            $TabNews['title'] = printSecuTags($TabNews['title']);

            $sql2 = mysql_query("SELECT itemId FROM ".COMMENT_TABLE." WHERE itemId = '{$TabNews['id']}' AND module = 'News'");
            $nb_comment = mysql_num_rows($sql2);

            $sql3 = mysql_query("SELECT title, image FROM ".NEWS_CAT_TABLE." WHERE id = '{$TabNews['category']}'");
            $TabCat = mysql_fetch_assoc($sql3);

            if (!empty($autorId)) {
                $sql4 = mysql_query("SELECT pseudo FROM ".USER_TABLE." WHERE id = '{$TabNews['autorId']}'");
                $test = mysql_num_rows($sql4);
            }

            if (!empty($autorId) && $test > 0) list($autor) = mysql_fetch_array($sql4);
            else $autor = $TabNews['autor'];
            
            $data['date'] = nkDate($TabNews['created']);
            $data['date_timestamp'] = $TabNews['created'];
            $data['cat'] = $TabCat['title'];
            $data['catid'] = $TabNews['category'];
            $data['id'] = $TabNews['id'];
            $data['titre'] = printSecuTags($TabNews['title']);
            $data['auteur'] = $autor;
            $data['nb_comment'] = $nb_comment;
            $data['printpage'] = '<a title="'.PDF.'" href="index.php?file=News&amp;nuked_nude=index&amp;op=pdf&amp;news_id='.$TabNews['id'].'" onclick="window.open(this.href); return false;"><img style="border:none;" src="images/pdf.gif" alt="'.PDF.'" title="'.PDF.'" width="16" height="16" /></a>';
            $data['friend'] = '<a title="'.FSEND.'" href="index.php?file=News&amp;op=sendfriend&amp;news_id='.$TabNews['id'].'"><img style="border:none;" src="images/friend.gif" alt="'.FSEND.'" title="'.FSEND.'" width="16" height="16" /></a>';
 
            $data['image'] = (!empty($TabCat['image'])) ? '<a title="'.$TabCat['title'].'" href="index.php?file=Archives&amp;op=sujet&amp;cat_id='.$TabNews['category'].'"><img style="float:right;border:0;" src="'.$TabCat['image'].'" alt="'.$TabCat['title'].'" title="'.$TabCat['title'].'" /></a>' : '';

            if ($_REQUEST['op'] == 'continuation' || $_REQUEST['op'] == 'index_comment' && !empty($TabNews['continuation'])) {
                $data['content'] = $TabNews['content'].'<br /><br />'.$TabNews['continuation'];
            } elseif (!empty($TabNews['continuation'])) {
                // Bouton lire la suite du thème ou texte par défaut
                $data['bouton'] = (is_file('themes/' . $theme . '/images/readmore.png')) ? '<img src="themes/' . $theme . '/images/readmore.png" alt="" title="'.READMORE . '" />' : READMORE;

                $data['texte'] = $TabNews['content'].'<div style="text-align:right;"><a title="'.READMORE.'" href="index.php?file=News&amp;op=suite&amp;news_id='.$TabNews['id'].'">' . $data['bouton'] . '</a></div>';
            } else {
                $data['texte'] = $TabNews['content'];
            }

            news($data);

        }

        
        $url = ($_REQUEST['op'] == 'categorie') ? 'index.php?file=News&amp;op=categorie&amp;cat_id='.$_REQUEST['cat_id'] : 'index.php?file=News';

        if ($nb_news > $max_news) {
            echo '&nbsp;';
            number($nb_news, $max_news, $url);
            echo '<br /><br />';
        }
    }

    function index_comment($news_id) {

        global $user, $visiteur, $nuked, $adminMod;

        if( $visiteur >= $adminMod){
            echo '<script type="text/javascript">function delnews(id){if(confirm(\''.DELTHISNEWS.' ?\')){document.location.href = \'index.php?file=News&page=admin&op=do_del&news_id=\'+id;}}</script>
                  <div style="text-align:right;">
                    <a href="index.php?file=News&amp;page=admin&amp;op=edit&amp;news_id='.$news_id.'">
                        <img style="border:none;" src="images/edition.gif" alt="" title="'.EDIT.'" />
                    </a>&nbsp;
                    <a href="javascript:delnews(\''.$news_id.'\');">
                        <img style="border:none;" src="images/delete.gif" alt="" title="'.DEL.'" />
                    </a>
                  </div>';
        }
        
        index();
        

        if ($visiteur >= nivo_mod('Comment') && nivo_mod('Comment') > -1) {
           
            viewComment('news', $news_id, 4);
        }
    }

    function suite($news_id) {
        global $user, $visiteur, $nuked;

        if ($visiteur >= $adminMod) {
            echo '<script type="text/javascript">function delnews(id){if(confirm(\''.DELTHISNEWS.' ?\')){document.location.href = \'index.php?file=News&page=admin&op=do_del&news_id=\'+id;}}</script>
                  <div style="text-align:right;">
                    <a href="index.php?file=News&amp;page=admin&amp;op=edit&amp;news_id='.$news_id.'">
                        <img style="border:none;" src="images/edition.gif" alt="" title="'.EDIT.'" />
                    </a>&nbsp;
                    <a href="javascript:delnews(\''.$news_id.'\');">
                        <img style="border:none;" src="images/delete.gif" alt="" title="'.DEL.'" />
                    </a>
                  </div>';
        }

        index();
        
        $sql = mysql_query("SELECT active FROM ".$nuked['prefix']."_comment_mod WHERE module = 'news'");
        $row = mysql_fetch_array($sql);

        if ($row['active'] == 1 && $visiteur >= nivo_mod('Comment') && nivo_mod('Comment') > -1) {
            include ('modules/Comment/index.php');
            com_index('news', $news_id);
        }

    }

    function categorie($cat_id){
        index();
    }

    function sujet(){
        global $nuked;

        //opentable();

        echo '<br /><div style="text-align:center;"><big><b>'.SUBJECTNEWS.'</b></big></div><br /><br />
              <table cellspacing="0" cellpadding="3" border="0">';

        $sql = mysql_query("SELECT nid, titre, description, image FROM ".NEWS_CAT_TABLE." ORDER BY titre");
        while ($row = mysql_fetch_assoc($sql)) {
            
            $row['titre'] = printSecuTags($row['titre']);

            echo '<tr>';

            if (!empty($row['image'])) {
                echo '<td><a href="index.php?file=News&amp;op=categorie&amp;cat_id='.$row['nid'].'">
                      <img style="border:none;" src="'.$row['image'].'" align="left" alt="" title="'.SEENEWS.'&nbsp;'.$row['titre'].'" /></a></td>';
            }

            echo '<td><b>'.$row['titre'].' :</b><br />'.$row['description'].'</td></tr><tr><td colspan="2">&nbsp;</td></tr>';
        }
        
        echo '</table><br /><br /><div style="text-align:center;"><small><i>( '.CLICSCREEN.' )</i></small></div><br />';

       // closetable();
    }

    function pdf($news_id) {
        global $nuked, $language;

        if ($language == "french" && strpos("WIN", PHP_OS)) setlocale (LC_TIME, "french");
        else if ($language == "french" && strpos("BSD", PHP_OS)) setlocale (LC_TIME, "fr_FR.ISO8859-1");
        else if ($language == "french") setlocale (LC_TIME, "fr_FR");
        else setlocale (LC_TIME, $language);

        $sql = mysql_query("SELECT auteur, auteur_id, date, titre, texte, suite FROM ".NEWS_TABLE." WHERE id = '$news_id'");
        $row = mysql_fetch_assoc($sql);

        $heure = strftime("%H:%M", $row['date']);
        $text = $row['texte'].'<br><br>'.$row['suite'];

        if (!empty($row['auteur_id'])) {
            $sql2 = mysql_query("SELECT pseudo FROM ".USER_TABLE." WHERE id = '$autor_id'");
            $test = mysql_num_rows($sql2);
        }

        if (!empty($row['auteur_id']) && $test > 0) {
            list($auteur) = mysql_fetch_array($sql2);
            $auteur = @html_entity_decode($auteur);
        } else {
            $auteur = $row['auteur'];
        }

        $date = nkDate($row['date']);

        $posted = '<font size="1">'.NEWSPOSTBY.' <a href="'.$nuked['url'].'/index.php?file=Members&op=detail&autor='.$auteur.'">'.$auteur.'</a> '.$date.'</font><br><br>';

        $texte = $posted.$text;

        $articleurl = $nuked['url'].'/index.php?file=News&op=index_comment&news_id='.$news_id;

        include 'Includes/html2pdf/html2pdf.class.php';
        $sitename = $nuked['name'].' - '.$nuked['slogan'];
        $sitename  = @html_entity_decode($sitename);

        $texte = "<h1>{$row['titre']}</h1><hr />$texte<hr />$sitename<br />$articleurl.";
        $_REQUEST['file'] = $sitename.'_'.$title;
        $_REQUEST['file'] = str_replace(' ','_',$_REQUEST['file']);
        $_REQUEST['file'] .= '.pdf';
        
        $pdf = new HTML2PDF('P','A4','fr');
    $pdf->setDefaultFont('dejavusans');
        $pdf->WriteHTML(utf8_encode($texte));
        $pdf->Output($_REQUEST['file']);
    }


    function sendfriend($news_id) {
        global $nuked, $user, $captcha;

        //opentable();

        echo '<script type="text/javascript">function verifchamps(){if(document.REQUESTElementById(\'sf_pseudo\').value.length == 0){alert(\''.NONICK.'\');return false;}if(document.REQUESTElementById(\'sf_mail\').value.indexOf(\'@\') == -1){alert(\''.BADMAIL.'\');return false;}return true;}</script>';

        $sql = mysql_query("SELECT titre FROM ".NEWS_TABLE." WHERE id = '$news_id'");
        list($title) = mysql_fetch_array($sql);

        echo '<form method="post" action="index.php?file=News" onsubmit="return verifchamps()">
              <table style="margin:0 auto;text-align:left;" width="60%" cellspacing="1" cellpadding="1" border="0">
              <tr><td align="center"><br /><big><b>'.FSEND.'</b></big><br /><br />'.YOUSUBMIT.' :<br /><br />
              <b>'.$title.'</b><br /><br /></td></tr><tr><td align="left">
              <b>'.YNICK.' : </b>&nbsp;<input type="text" id="sf_pseudo" name="pseudo" value=""'.$user[2].'" size="20" /></td></tr>
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
            $from = "From: {$nuked['name']} <{$nuked['mail']}>\r\nReply-To: ".$nuked['mail'];

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

        case'index_comment':
        index_comment($_REQUEST['news_id']);
        break;

        case'suite':
        suite($_REQUEST['news_id']);
        break;

        case'categorie':
        categorie($_REQUEST['cat_id']);
        break;

        case'sujet':
        sujet();
        break;

        case'pdf':
        pdf($_REQUEST['news_id']);
        break;

        case'sendfriend':
        sendfriend($_REQUEST['news_id']);
        break;

        case'sendnews':
        sendnews($_REQUEST['title'], $_REQUEST['news_id'], $_REQUEST['comment'], $_REQUEST['mail'], $_REQUEST['pseudo']);
        break;

        default:
        index();
        break;

    }

?>
