<?php
/************************************************
*   Th?me Impact_Nk pour Nuked Klan *
*   Design :  Djgrim (http://www.impact-design.fr/) *
*   Codage : fce (http://www.impact-design.fr/)         *
************************************************/
defined("INDEX_CHECK") or die ("<div style=\"text-align: center;\">Access deny</div>");

if (!$user){
    $theuser = include("themes/Impact_Nk/blocks/login.php");
}
else{
    $sql2 = mysql_query("SELECT id FROM " . USERBOX_TABLE . " WHERE userFor = '" . $user[0] . "' AND status = 1");
    $nb_mess_lu = mysql_num_rows($sql2);
    list($mid) = mysql_fetch_array($sql2);

    if($nb_mess_lu>0){
        $mess="<a href=\"index.php?file=Userbox&amp;op=show_message&amp;mid=".$mid."\">".YOUVE." ".$nb_mess_lu." ".INNEW."</a>.";
    }
    else{
        $mess="<a href=\"index.php?file=Userbox\">".YOUVE." 0 ".INNEW."</a>";
    }
        include("themes/Impact_Nk/blocks/user.php");
}
?>