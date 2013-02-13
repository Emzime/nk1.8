<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

global $user, $language;
translate("modules/Admin/lang/" . $language . ".lang.php");
include("modules/Admin/design.php");
if (!$user)
{
    $visiteur = 0;
}
else
{
    $visiteur = $user[1];
}

if ($visiteur == 9)
{
    function index()
    {
        global $nuked, $language;
		
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _TSLIDEADMIN . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/menu.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Admin&amp;page=themes_slide&amp;op=add\">" . _ADD . "</a></div><br />\n"
			. "<div class=\"tab-content\" id=\"tab2\"><table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"80%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 25%;\" align=\"center\"><b>" . _TITRE . "</b></td>\n"
			. "<td style=\"width: 25%;\" align=\"center\"><b>" . _URLT . "</b></td>\n"
			. "<td style=\"width: 25%;\" align=\"center\"><b>" . _IMG . "</b></td>\n"
			. "<td style=\"width: 25%;\" align=\"center\"><b>" . _EDIT . "</b></td></tr>\n";

        $sql = mysql_query("SELECT  id, titre, url, img FROM " . $nuked['prefix'] . "_themes_slide");
        while (list($bid, $titre, $url, $img) = mysql_fetch_array($sql))
        {
            $titre = htmlentities($titre);

            echo "<tr>\n"
            . "<td style=\"width: 25%;\">" . $titre . "</td>\n"
            . "<td style=\"width: 25%;\" align=\"center\"><a href=\"" . $url . "\"><img src=\"images/files.gif\" width=\"16\" alt=\"" . _DOWNSLIDE . "\" title=\"" . _DOWNSLIDE . "\" /></a></td>\n"
            . "<td style=\"width: 25%;\" align=\"center\"><a href=\"" . $img . "\" rel=\"modal\" ><img src=\"" . $img . "\" alt=\"" . _CLICTOSCREEN . "\" title=\"" . _CLICTOSCREEN . "\" width=\"20\" /></a></td>\n"
            . "<td style=\"width: 25%;\" align=\"center\"><a href=\"index.php?file=Admin&amp;page=themes_slide&amp;op=edit&amp;bid=" . $bid . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDIT . "\" /></a></td></tr>\n";

        }
        echo "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin\"><b>" . _BACK . "</b></a> ]</div><br /></div></div>\n";
    }

    function edit($bid)
    {
        global $nuked, $user, $language;
		
		$img_screen1 = 100;

        $sql = mysql_query("SELECT titre, url, img FROM " . $nuked['prefix'] . "_themes_slide WHERE id = '" . $bid . "'");
        while(list($titre, $url, $img) = mysql_fetch_array($sql)){
			$titre = htmlentities($titre);

			if (!preg_match("`%20`i", $img)) list($w, $h, $t, $a) = @getimagesize($img);
			if ($w != "" && $w <= $img_screen1) $width = "width=\"" . $w . "\"";
			else $width = "width=\"" . $img_screen1 . "\"";
			$image = "<img style=\"border: 1px solid #000000;\" src=\"" . $img . "\" " . $width . " alt=\"\" title=\"" .  _CLICTOSCREEN . "\" />";

			$name = strrchr($img, '/');
			$name = substr($name, 1);
			$name_enc = rawurlencode($name);
			$img = str_replace($name, $name_enc, $img);
			
			echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _TSLIDEADMIN . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Gallery.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Admin&amp;page=themes_slide&amp;op=send_edit&amp;bid=" . $bid . "\" enctype=\"multipart/form-data\" onsubmit=\"backslash('img_texte');\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellpadding=\"10\" cellspacing=\"0\" border=\"0\">\n"
			. "<tr>\n"
			. "<tr><td><a href=\"" . $img . "\" rel=\"modal\">" . $image . "</a></td></tr></table>\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellpadding=\"10\" cellspacing=\"0\" border=\"0\">\n"
			. "<tr><td><b>" . _TITRE . "</b>:</td><td style=\"text-align: left;\"><input type=\"text\" name=\"titre\" size=\"30\" maxlength=\"200\" value=\"" . $titre . "\" /></td>\n"
			. "<tr><td><b>" . _URLT . "</b>:</td><td style=\"text-align: left;\"><input type=\"text\" name=\"url\" size=\"70\" maxlength=\"200\" value=\"" . $url . "\" /></td>\n"
			. "<tr><td><b>" . _IMG . "</b>:</td><td style=\"text-align: left;\"><input type=\"text\" name=\"img\" size=\"70\" maxlength=\"200\" value=\"" . $img . "\" /></td>\n"
			. "</tr></table><div style=\"text-align: center;\"><br />\n"
			. "&nbsp;<input type=\"submit\" value=\"" . _EDIT . "\" /></div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=themes_slide\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>";
		}     
    }
	
	function send_edit($bid, $titre, $url, $img){
		global $nuked, $language;

		
        $titre = mysql_real_escape_string(stripslashes($titre));
        if ($url == "http://") $url = "";
		if ($img == "http://") $img = "";

		if(!$titre || !$url || !$img)
		{
        echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _SLIDENOTEDIT . "\n"
			. "</div>\n"
			. "</div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a> ]</div>\n";
		}else{
		
            $sql = mysql_query("UPDATE ". $nuked['prefix'] ."_themes_slide SET titre = '" . $titre . "', url = '" . $url . "', img = '" . $img . "' WHERE id = '" . $bid . "'");
			
			// Action
			$texteaction = "". _ACTIONEDITSLIDE .": ".$titre."";
			$acdate = time();
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
			//Fin action
			
			echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _SLIDEEDIT . "\n"
				. "</div>\n"
				. "</div>\n";
			echo "<script>\n"
				."setTimeout('screen()','3000');\n"
				."function screen() { \n"
				."screenon('index.php?file=Admin', 'index.php?file=Admin&page=themes_slide');\n"
				."}\n"
				."</script>\n";
		}
	}
	
	function add(){
		global $nuked, $language;
		
        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _TSLIDEADMIN . " : " . $titre . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/menu.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div></div>\n"
			. "<div class=\"tab-content\" id=\"tab2\">\n"
			. "<form method=\"post\" action=\"index.php?file=Admin&amp;page=themes_slide&amp;op=do_add\" enctype=\"multipart/form-data\">\n"
			. "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
            . "<td><b>" . _TITRE . "</b>:</td><td style=\"text-align: left;\"><input type=\"text\" name=\"titre\" size=\"46\" maxlength=\"200\" value=\"\" /></td>\n"
			. "</tr>\n"
			. "<tr>\n"
            . "<td><b>" . _URLT . "</b>:</td><td><input type=\"text\" name=\"url\" size=\"70\" maxlength=\"200\" value=\"http://\" /></td>\n"
			. "</tr>\n"
			. "<tr>\n"
            . "<td><b>" . _IMG . "</b>:</td><td><input type=\"text\" name=\"img\" size=\"70\" maxlength=\"200\" value=\"http://\" /></td>\n" 
			. "</tr>\n"

			. "</table><div style=\"text-align: center;\"><br />\n"
			. "&nbsp;<input type=\"submit\" value=\"" . _ADD . "\" /></div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=themes_slide\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>";
	}
	
	function do_add($titre, $url, $img){
		global $nuked, $language;
				
        $titre = mysql_real_escape_string(stripslashes($titre));
        if ($url == "http://") $url = "";
		if ($img == "http://") $img = "";

		if(!$titre || !$url || !$img)
		{
        echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _SLIDENOTADD . "\n"
			. "</div>\n"
			. "</div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a> ]</div>\n";
		}else{
		
			$sql = mysql_query("INSERT INTO ". $nuked['prefix'] ."_themes_slide  ( `id`, `titre`, `url`, `img`)  VALUES ('', '".$titre."', '".$url."', '".$img."')");
			
			// Action
			$texteaction = "". _ACTIONADDSLIDE .": ".$titre."";
			$acdate = time();
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
			//Fin action
			
			echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _SLIDEADD . "\n"
				. "</div>\n"
				. "</div>\n";
			echo "<script>\n"
				."setTimeout('screen()','3000');\n"
				."function screen() { \n"
				."screenon('index.php?file=Admin', 'index.php?file=Admin&page=themes_slide');\n"
				."}\n"
				."</script>\n";
		}
	}

    switch ($_REQUEST['op'])
    {
        case "index":
            admintop();
            index();
            adminfoot();
            break;

        case "edit":
            admintop();
            edit($_REQUEST['bid']);
            adminfoot();
            break;

        case "add":
            admintop();
            add();
            adminfoot();
            break;

        case "do_add":
            admintop();
            do_add($_REQUEST['titre'], $_REQUEST['url'], $_REQUEST['img']);
            adminfoot();
            break;

        case "send_edit":
            admintop();
            send_edit($_REQUEST['bid'], $_REQUEST['titre'], $_REQUEST['url'], $_REQUEST['img']);
            adminfoot();
            break;

        default:
            admintop();
            index();
            adminfoot();
            break;
    }

}
else if ($visiteur > 1)
{
    admintop();
    echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
    adminfoot();
}
else
{
    admintop();
    echo "<div class=\"notification error png_bg\">\n"
	. "<div>\n"
	. "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
	. "</div>\n"
	. "</div>\n";
    adminfoot();
}
?>
