<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

global $user, $nuked, $language;
include('modules/Admin/design.php');

$visiteur = $user ? $user[1] : 0;

if ($visiteur >= 2)
{
    function main()
    {
        global $user, $nuked, $language;

        echo '<div class="content-box">',"\n" //<!-- Start Content Box -->
        . '<div class="content-box-header"><h3>' . ADMINACTION . '</h3>',"\n"
        . '<div style="text-align:right"><a href="help/' . $language . '/Action.php" rel="modal">',"\n"
        . '<img style="border: 0" src="help/help.gif" alt="" title="' . HELP . '" /></a>',"\n"
        . '</div></div>',"\n"
        . '<div class="tab-content" id="tab2"><br />',"\n"
        . '<div class="notification information png_bg">',"\n"
        . '<div>' .INFOACTION . '</div></div>',"\n"
        . '<br /><table><tr><td><b>' . DATE . '</b>',"\n"
        . '</td><td><b>' . INFORMATION . '</b>',"\n"
        . '</td></tr>',"\n";

        $sql = mysql_query("SELECT created, pseudo, action  FROM " . $nuked['prefix'] . "_action ORDER BY created DESC LIMIT 0, 50");
        while (list($date, $users, $texte) = mysql_fetch_array($sql))
        {
            if($users != '')
            {
                $users = mysql_real_escape_string($users);
            
                $sql2 = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id = '" . $users . "'");
                list($pseudo) = mysql_fetch_array($sql2);
            }
            else $pseudo = 'N/A';

            $date = nkDate($date);
            $texte = $pseudo . ' ' . $texte;

            echo '<tr><td>' . $date . '</td>',"\n"
            . '<td>' . $texte . '</td></tr>',"\n";

        }

        echo '</table><div style="text-align: center"><br />[ <a href="index.php?file=Admin"><b>' . BACK . '</b></a> ]</div></form><br /></div></div>',"\n";
        $theday = time();
        $compteur = 0;
        $delete = mysql_query("SELECT id, created  FROM " . $nuked['prefix'] . "_action ORDER BY created DESC");
        while (list($id, $date) = mysql_fetch_array($delete))
        {
            $limit_time = $date + 1209600;

            if ($limit_time < $theday)
            {
                $del = mysql_query("DELETE FROM " . $nuked['prefix'] . "_action WHERE id = '" . $id . "'");
                $compteur++;
            }
        }
        if ($compteur > 0)
        {
            if($compteur ==1) $text = $compteur. ' ' ._1NBRNOTACTION;
            else $text = $compteur . ' ' . NBRNOTACTION;

            $upd = mysql_query("INSERT INTO ". $nuked['prefix'] ."_notification  (`created` , `type` , `content`)  VALUES ('" . $theday . "', '3', '" . $text . "')");
        }
    }
    switch ($_REQUEST['op'])
    {
        case 'main':
        admintop();
        main();
        adminfoot();
        break;
        default:
        admintop();
        main();
        adminfoot();
        break;
    }

}
else if ($visiteur > 1)
{
    admintop();
    echo '<div class="notification error png_bg">',"\n"
    . '<div>',"\n"
    . '<br /><br /><div style="text-align: center">' . NOENTRANCE . '<br /><br /><a href="javascript:history.back()"><b>' . BACK . '</b></a></div><br /><br />',"\n"
    . '</div>',"\n"
    . '</div>',"\n";
    adminfoot();
}
else
{
    admintop();
    echo "<div class=\"notification error png_bg\">\n"
    . "<div>\n"
    . "<br /><br /><div style=\"text-align: center;\">" . ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . BACK . "</b></a></div><br /><br />"
    . "</div>\n"
    . "</div>\n";
    adminfoot();
}
?>
