<?php
/**
*   Block module
*   block management to display block of a module
*
*   @version 1.8
*   @link http://www.nuked-klan.org Clan Management System 4 Gamers NK CMS
*   @license http://opensource.org/licenses/gpl-license.php GNU Public License
*   @copyright 2001-2013 Nuked Klan 
*/
defined('INDEX_CHECK') or die ('<div style="text-align: center;">'.CANTOPENPAGE.'</div>');

if (defined('TESTLANGUE')) { 

    function affichBlockModule($blok){
        //check des modules
        $handle = opendir('modules/');        
        while ($mod = readdir($handle)) {
            if($mod != 'index.html' && file_exists('modules/'.$mod.'/blok.php')) {
                $autorized_modules[] = $mod;
            }
        }
        
        if (false===array_search($blok['module'], $autorized_modules)) {
             $blok_content = '';
        } else {
            ob_start();
            print eval('$id = \'$blok["id"]\';');
            print eval(' include "modules/'.$blok["module"].'/blok.php"); ');
            $blok_content = ob_get_contents();
            ob_end_clean();
        }
        return $blok;
    }
} else {
    echo $GLOBALS['nkTpl']->nkDisplayError(LANGNOTFOUND , 'nkAlignCenter');
}

    function edit_blockModule($bid){
        global $nuked, $language;

        $dbsBlock = '   SELECT side, placing, title, module, content, type, level, page 
                        FROM '.BLOCK_TABLE.' 
                        WHERE id = '.$bid;
        $dbeBlock = mysql_query($dbsBlock);
        list($active, $position, $titre, $modul, $content, $type, $nivo, $pages) = mysql_fetch_array($dbeBlock);
        //check des modules
        $handle = opendir('modules/');
        while ($mod = readdir($handle)) {
            if($mod != 'index.html' && file_exists('modules/'.$mod.'/blok.php')) {
                $autorized_modules[] = $mod; 
            }            
        }

        if (false===array_search($modul, $autorized_modules)) {
             die('<div style="text-align: center;"><big>Blok corrupted, lease delete it!</big></div>');
        }
        
        $titre = printSecuTags($titre);

        if ($active == 1) $checked1 = 'selected="selected"';
        else if ($active == 2) $checked2 = 'selected="selected"';
        else if ($active == 3) $checked3 = 'selected="selected"';
        else if ($active == 4) $checked4 = 'selected="selected"';
        else $checked0 = 'selected="selected"';

        echo '<div class="content-box">',"\n" //<!-- Start Content Box -->
                , '<div class="content-box-header"><h3>' , BLOCKADMIN , '</h3>',"\n"
                , '<a href="help/' , $language , '/block.html" rel="modal">',"\n"
                , '<img style="border: 0;" src="help/help.gif" alt="" title="' , HELP , '" /></a>',"\n"
                , '</div>',"\n"
                , '<div class="tab-content" id="tab2"><form method="post" action="index.php?file=Admin&amp;page=block&amp;op=modif_block">',"\n"
                , '<table style="margin-left: auto;margin-right: auto;text-align: left;" cellspacing="0" cellpadding="2" border="0">',"\n"
                , '<tr><td><b>' , TITLE , '</b></td><td><b>' , BLOCK , '</b></td><td><b>' , POSITION , '</b></td><td><b>' , LEVEL , '</b></td></tr>',"\n"
                , '<tr><td align="center"><input type="text" name="titre" size="40" value="' , $titre , '" /></td>',"\n"
                , '<td align="center"><select name="active">',"\n"
                , '<option value="1" ' , $checked1 , '>' , LEFT , '</option>',"\n"
                , '<option value="2" ' , $checked2 , '>' , RIGHT , '</option>',"\n"
                , '<option value="3" ' , $checked3 , '>' , CENTERBLOCK , '</option>',"\n"
                , '<option value="4" ' , $checked4 , '>' , FOOTERBLOCK , '</option>',"\n"
                , '<option value="0" ' , $checked0 , '>' , OFF , '</option></select></td>',"\n"
                , '<td align="center"><input type="text" name="position" size="2" value="' , $position , '" /></td>',"\n"
                , '<td align="center"><select name="nivo"><option>' , $nivo , '</option>',"\n"
                , '<option>0</option>',"\n"
                , '<option>1</option>',"\n"
                , '<option>2</option>',"\n"
                , '<option>3</option>',"\n"
                , '<option>4</option>',"\n"
                , '<option>5</option>',"\n"
                , '<option>6</option>',"\n"
                , '<option>7</option>',"\n"
                , '<option>8</option>',"\n"
                , '<option>9</option></select></td></tr>',"\n"
                , '<tr><td colspan="4"><b>' , TYPE , ' : </b> ' , MODBLOCK , '</td></tr><tr><td colspan="4"><select name="module">',"\n";

        select_mod($modul);

        echo '</select></td></tr><tr><td colspan="4">&nbsp;</td></tr>',"\n"
            , '<tr><td colspan="4" align="center"><b>' , PAGESELECT , ' :</b></td></tr><tr><td colspan="4">&nbsp;</td></tr>',"\n"
            , '<tr><td colspan="4" align="center"><select name="pages[]" size="8" multiple="multiple">',"\n";

        select_mod2($pages);

        echo '</select></td></tr><tr><td colspan="4" align="center"><br />',"\n"
            , '<input type="hidden" name="type" value="' , $type , '" />',"\n"
            , '<input type="hidden" name="bid" value="' , $bid , '" />',"\n"
            , '<input type="submit" name="send" value="' , MODIFBLOCK , '" />',"\n"
            , '</td></tr></table>',"\n"
            , '<div style="text-align: center;"><br />[ <a href="index.php?file=Admin&amp;page=block"><b>' , BACK , '</b></a> ]</div></form><br /></div></div>',"\n";

    }
?>