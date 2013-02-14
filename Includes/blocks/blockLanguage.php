<?php
/**
*   Block Language
*   Select your language
*
*   @version 1.8
*   @link http://www.nuked-klan.org Clan Management System 4 Gamers NK CMS
*   @license http://opensource.org/licenses/gpl-license.php GNU Public License
*   @copyright 2001-2013 Nuked Klan 
*/
defined('INDEX_CHECK') or die ('<div style="text-align: center;">'.CANTOPENPAGE.'</div>');

if (defined('TESTLANGUE')) { 

    function affichBlockLanguage($blok) {
        global $cookie_langue;

        $blok['content'] .= '   <form method="post" action="index.php?file=User&amp;nuked_nude=index&amp;op=modif_langue">
                                <div class="nkAlignCenter">
                                    <select name="user_langue" onchange="submit();">
                                        <option value="">--------^-------</option>';

        if ($rep = @opendir('lang/')) {
            while (false !== ($f = readdir($rep))) {
                if ($f != '..' && $f != '.' && $f != 'index.html') {
    				list($langfile, ,) = explode ('.', $f);
    				
                    if ($cookie_langue == $langfile) {
                        $checked = 'selected="selected"';
                    } else {
                        $checked = '';
                    }

                    $blok['content'] .= '<option value="' . $langfile . '" ' . $checked . '>' . $langfile . '</option>';
                }
            }
            closedir($rep);
            clearstatcache();
        }
        $blok['content'] .= '       </select>
                                </div>
                                </form>';
        return $blok;
    }
} else {
    echo $GLOBALS['nkTpl']->nkDisplayError(LANGNOTFOUND , 'nkAlignCenter');
}

    function edit_block_language($bid){
        global $nuked, $language;

        $sql = mysql_query('SELECT active, position, titre, module, content, type, nivo, page FROM ' . BLOCK_TABLE . ' WHERE bid = \'' . $bid . '\' ');
        list($active, $position, $titre, $modul, $content, $type, $nivo, $pages) = mysql_fetch_array($sql);
        $titre = printSecuTags($titre);

        if ($active == 1) $checked1 = 'selected="selected"';
        else if ($active == 2) $checked2 = 'selected="selected"';
        else $checked0 = 'selected="selected"';

        echo '<div class="content-box">',"\n" //<!-- Start Content Box -->
    			, '<div class="content-box-header"><h3>' , _BLOCKADMIN , '</h3>',"\n"
    			, '<a href="help/' , $language , '/block.html" rel="modal">',"\n"
    			, '<img style="border: 0;" src="help/help.gif" alt="" title="' , _HELP , '" /></a>',"\n"
    			, '</div>',"\n"
    			, '<div class="tab-content" id="tab2"><form method="post" action="index.php?file=Admin&amp;page=block&amp;op=modif_block">',"\n"
    			, '<table style="margin-left: auto;margin-right: auto;text-align: left;" cellspacing="0" cellpadding="2" border="0">',"\n"
    			, '<tr><td><b>' , _TITLE , '</b></td><td><b>' , _BLOCK , '</b></td><td><b>' , _POSITION , '</b></td><td><b>' , _LEVEL , '</b></td></tr>',"\n"
    			, '<tr><td align="center"><input type="text" name="titre" size="40" value="' , $titre , '" /></td>',"\n"
    			, '<td align="center"><select name="active">',"\n"
    			, '<option value="1" ' , $checked1 , '>' , _LEFT , '</option>',"\n"
    			, '<option value="2" ' , $checked2 , '>' , _RIGHT , '</option>',"\n"
    			, '<option value="0" ' , $checked0 , '>' , _OFF , '</option></select></td>',"\n"
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
    			, '<option>9</option></select></td></tr><tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4" align="center"><b>' , _PAGESELECT , ' :</b></td></tr><tr><td colspan="4">&nbsp;</td></tr>',"\n"
    			, '<tr><td colspan="4" align="center"><select name="pages[]" size="8" multiple="multiple">',"\n";

        select_mod2($pages);

        echo '</select></td></tr><tr><td colspan="4" align="center"><br />',"\n"
    			, '<input type="hidden" name="type" value="' , $type , '" />',"\n"
    			, '<input type="hidden" name="bid" value="' , $bid , '" />',"\n"
    			, '<input type="submit" name="send" value="' , _MODIFBLOCK , '" />',"\n"
    			, '</td></tr></table>'
    			, '<div style="text-align: center;"><br />[ <a href="index.php?file=Admin&amp;page=block"><b>' , _BACK , '</b></a> ]</div></form><br /></div></div>',"\n";

    }
?>