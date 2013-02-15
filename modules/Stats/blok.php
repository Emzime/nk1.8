<?php
/**
*   Block of Stats module
*   Display stats on block
*
*   @version 1.8
*   @link http://www.nuked-klan.org Clan Management System 4 Gamers NK CMS
*   @license http://opensource.org/licenses/gpl-license.php GNU Public License
*   @copyright 2001-2013 Nuked Klan 
*/
defined('INDEX_CHECK') or die ('<div class="nkAlignCenter">'.CANTOPENPAGE.'</div>');
global $language, $user, $visiteur, $blockSide, $nuked;
$modName = basename(dirname(__FILE__));

// Veridication du chargement du fichier langue
$langTest = strtoupper($modName);
$langTest = constant('TESTLANGUEFILE'.$langTest);
if($langTest == true) { 
$counter = '';

    if ($blockSide[$modName] == 3 || $blockSide[$modName] == 4) {
        $sql = mysql_query("SELECT count FROM " . STATS_TABLE . " WHERE type = 'pages'");
        while (list($count) = mysql_fetch_array($sql))
        {
            $counter = $counter + $count;
        }

        $date_install = nkDate($nuked['date_install']);

        echo "<div style=\"text-align: center;\">" . _WERECEICED . "&nbsp;" . $counter . "&nbsp;" . _PAGESEE . "&nbsp;" . $date_install . ".</div><br />\n";

        $sql_users = mysql_query("SELECT id FROM " . USER_TABLE);
        $nb_users = mysql_num_rows($sql_users);

        echo "&nbsp;<b><big>&middot;</big></b>&nbsp;<b>" . $nb_users . "</b> " . _MEMBERSRECORD . "<br />\n";

        if (nivo_mod("News") != -1)
        {
            $sql_news = mysql_query("SELECT id FROM " . NEWS_TABLE);
            $nb_news = mysql_num_rows($sql_news);
            echo "&nbsp;<b><big>&middot;</big></b>&nbsp;<b>" . $nb_news . "</b> " . _NEWSINDB . "<br />\n";
        }

        if (nivo_mod("Downloads") != -1)
        {
            $sql_dl = mysql_query("SELECT id FROM " . DOWNLOADS_TABLE);
            $nb_downloads = mysql_num_rows($sql_dl);
            echo "&nbsp;<b><big>&middot;</big></b>&nbsp;<b>" . $nb_downloads . "</b> " . _FILESINDB . "<br />\n";
        }

        if (nivo_mod("Links") != -1)
        {
            $sql_links = mysql_query("SELECT id FROM " . LINKS_TABLE);
            $nb_liens = mysql_num_rows($sql_links);
            echo "&nbsp;<b><big>&middot;</big></b>&nbsp;<b>" . $nb_liens . "</b> " . _LINKSINDB . "<br /><br />\n";
        }

        echo "<div style=\"text-align: center;\"><a href=\"index.php?file=Stats\">" . _STATSBLOCK . "</a>/<a href=\"index.php?file=Stats&amp;op=top10\">" . _TOPBLOCK . "</a></div>\n";
    }
    else
    {
        $sql = mysql_query("SELECT count FROM " . STATS_TABLE . " WHERE type = 'pages'");
        while (list($count) = mysql_fetch_array($sql))
        {
            $counter = $counter + $count;
        }

        $date_install = nkDate($nuked['date_install']);

        $sql_users = mysql_query("SELECT id FROM " . USER_TABLE);
        $nb_users = mysql_num_rows($sql_users);

        echo "<div style=\"text-align: center;\">" . _PAGESEE . "<br />" . $date_install . " : " . $counter . "</div>\n"
        . "<hr style=\"height: 1px;\" />"
        . "&nbsp;<b><big>&middot;</big></b>&nbsp;" . _NBMEMBERS . " : <b>" . $nb_users . "</b><br />\n";

        if (nivo_mod("News") != -1)
        {
            $sql_news = mysql_query("SELECT id FROM " . NEWS_TABLE);
            $nb_news = mysql_num_rows($sql_news);
            echo "&nbsp;<b><big>&middot;</big></b>&nbsp;" . _NBNEWS . " : <b>" . $nb_news . "</b><br />\n";
        }

        if (nivo_mod("Downloads") != -1)
        {
            $sql_dl = mysql_query("SELECT id FROM " . DOWNLOADS_TABLE);
            $nb_downloads = mysql_num_rows($sql_dl);
            echo "&nbsp;<b><big>&middot;</big></b>&nbsp;" . _NBDOWNLOAD . " : <b>" . $nb_downloads . "</b><br />\n";
        }

        if (nivo_mod("Links") != -1)
        {
            $sql_links = mysql_query("SELECT id FROM " . LINKS_TABLE);
            $nb_liens = mysql_num_rows($sql_links);
            echo "&nbsp;<b><big>&middot;</big></b>&nbsp;" . _NBLINKS . " : <b>" . $nb_liens . "</b><br />\n";
        }

        echo "<hr style=\"height: 1px;\" />\n"
        . "<div style=\"text-align: center;\"><a href=\"index.php?file=Stats\">" . _STATSBLOCK . "</a>/<a href=\"index.php?file=Stats&amp;page=top\">" . _TOPBLOCK . "</a></div>\n";
    }
} else {
    echo $GLOBALS['nkTpl']->nkDisplayError(LANGNOTFOUND , 'nkAlignCenter');
}

?>