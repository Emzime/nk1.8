<?php
/**
*   Block Suggest
*   Display the last suggest
*
*   @version 1.8
*   @link http://www.nuked-klan.org Clan Management System 4 Gamers NK CMS
*   @license http://opensource.org/licenses/gpl-license.php GNU Public License
*   @copyright 2001-2013 Nuked Klan 
*/
defined('INDEX_CHECK') or die ('<div style="text-align: center;">'.CANTOPENPAGE.'</div>');

if(defined('TESTLANGUE')) { 

    function affichBlockCenter($blok) {
        global $language, $theme;

        $affModule = explode('|', $blok['content']);
        $affModuleOne = $affModule[0];
        $affModuleTwo = $affModule[1];

        $blockNameOne = strtoupper($affModuleOne);
        $blockNameOne = constant($blockNameOne);

        $blockNameTwo = strtoupper($affModuleTwo);
        $blockNameTwo = constant($blockNameTwo);

        $blockTestOne = 'modules/'.$affModuleOne.'/blok.php';   
        $blockTestTwo = 'modules/'.$affModuleTwo.'/blok.php'; 

        // Inclusion du Css personalisé du module depuis le theme et le fichier langue du module 1
        if (is_file(ROOT_PATH .'themes/'.$theme.'/css/modules/'.$affModuleOne.'.css') && is_file(ROOT_PATH .'modules/'.$affModuleOne.'/lang/'.$language.'.lang.php')) {
            echo'<link type="text/css" rel="stylesheet" href="themes/'.$theme.'/css/modules/'.$affModuleOne.'.css" media="screen" />';
            include_once ROOT_PATH .'modules/'.$affModuleOne.'/lang/'.$language.'.lang.php';
        } 
        // Inclusion du Css personalisé du module depuis le theme et le fichier langue du module 2
        if (is_file(ROOT_PATH .'themes/'.$theme.'/css/modules/'.$affModuleTwo.'.css') && is_file(ROOT_PATH .'modules/'.$affModuleTwo.'/lang/'.$language.'.lang.php')) {
            echo'<link type="text/css" rel="stylesheet" href="themes/'.$theme.'/css/modules/'.$affModuleTwo.'.css" media="screen" />';
            include_once ROOT_PATH .'modules/'.$affModuleTwo.'/lang/'.$language.'.lang.php';
        } 
        
        $blok['content'] = '';

        if ($affModuleOne != '' && is_file($blockTestOne)) {
            $blok['content'] .= '<div class="nkWidthHalf nkInlineBlock nkPadding nkValignTop nkMarginBottom15">
                                    <h3 class="nkAlignCenter">'.$blockNameOne.'</h3>';
            $blok['content'] .=     affBlock($affModuleOne);
            $blok['content'] .= '</div>';
        } else {
            $blok['content'] .= '<div class="nkWidthHalf nkInlineBlock nkPadding nkValignTop nkMarginBottom15">
                                    <h3 class="nkAlignCenter">'.$blockNameOne.'</h3>';
            $blok['content'] .=     '<p class="nkAlignCenter">'.CANTOPENBLOCK.'</p>';
            $blok['content'] .= '</div>';
        }


        if ($affModuleTwo != '' && is_file($blockTestTwo)) {
            $blok['content'] .= '<div class="nkWidthHalf nkInlineBlock nkValignTop nkMarginBottom15">
                                    <h3 class="nkAlignCenter">'.$blockNameTwo.'</h3>';           
            $blok['content'] .=     affBlock($affModuleTwo);
            $blok['content'] .= '</div>';
        } else {
            $blok['content'] .= '<div class="nkWidthHalf nkInlineBlock nkValignTop nkMarginBottom15">
                                    <h3 class="nkAlignCenter">'.$blockNameTwo.'</h3>';
            $blok['content'] .=     '<p class="nkAlignCenter">'.CANTOPENBLOCK.'</p>';
            $blok['content'] .= '</div>';
        }

        return $blok;
    }

    // Inclusion des blocs
    function affBlock($content) {
        ob_start();
        print eval(' include("modules/'.$content.'/blok.php"); ');
        $blok_content = ob_get_contents();
        ob_end_clean();
        return $blok_content;
    }


} else {
    echo $GLOBALS['nkTpl']->nkDisplayError(LANGNOTFOUND , 'nkAlignCenter');
}

    function edit_block_center($bid){
        global $nuked, $language;

        $sql = mysql_query('SELECT active, position, titre, module, content, type, nivo, page FROM ' . BLOCK_TABLE . ' WHERE bid = \'' . $bid . '\' ');
        list($active, $position, $titre, $modul, $content, $type, $nivo, $pages) = mysql_fetch_array($sql);
        $titre = printSecuTags($titre);

        if ($active == 3) $checked3 = 'selected="selected"';
        else if ($active == 4) $checked4 = 'selected="selected"';
        else $checked0 = 'selected="selected"';

        $mod = explode("|", $content);
        $mod1 = $mod[0];
        $mod2 = $mod[1];

        echo '<div class="content-box">',"\n" //<!-- Start Content Box -->
    			, '<div class="content-box-header"><h3>' , _BLOCKADMIN , '</h3>',"\n"
    			, '<a href="help/' , $language , '/block.html" rel="modal">',"\n"
    			, '<img style="border: 0;" src="help/help.gif" alt="" title="' , _HELP , '" /></a>',"\n"
    			, '</div>',"\n"
    			, '<div class="tab-content" id="tab2"><form method="post" action="index.php?file=Admin&amp;page=block&amp;op=modif_block">',"\n"
    			, '<table style="margin-left: auto;margin-right: auto;text-align: left;border: none;" cellspacing="0" cellpadding="2" >',"\n"
    			, '<tr><td><b>' , _TITLE , '</b></td><td><b>' , _BLOCK , '</b></td><td><b>' , _POSITION , '</b></td><td><b>' , _LEVEL , '</b></td></tr>',"\n"
    			, '<tr><td style="text-align:center;" ><input type="text" name="titre" size="40" value="' , $titre , '" /></td>',"\n"
    			, '<td align="center"><select name="active">',"\n"
    			, '<option value="3" ' , $checked3 , '>' , _CENTERBLOCK , '</option>',"\n"
    			, '<option value="4" ' , $checked4 , '>' , _FOOTERBLOCK , '</option>',"\n"
    			, '<option value="0" ' , $checked0 , '>' , _OFF , '</option></select></td>',"\n"
    			, '<td style="text-align:center;" ><input type="text" name="position" size="2" value="' , $position , '" /></td>',"\n"
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
    			, '<option>9</option></select></td></tr><tr><td colspan="4"><b>' , _MODULE , ' 1 :</b> <select name="content[1]"><option value="">' , _NORANK , '</option>',"\n";

        select_module($mod1);

        echo '</select> <b>' , _MODULE , ' 2 :</b> <select name="content[2]"><option value="">' , _NORANK , '</option>',"\n";

        select_module($mod2);

        echo '</select></td></tr><tr><td colspan="4">&nbsp;</td></tr>',"\n"
    			, '<tr><td colspan="4" style="text-align:center;" ><b>' ,  _PAGESELECT , ' : </b></td></tr><tr><td colspan="4">&nbsp;</td></tr>',"\n"
    			, '<tr><td colspan="4" style="text-align:center;" ><select name="pages[]" size="8" multiple="multiple">',"\n";

        select_mod2($pages);

        echo '</select></td></tr><tr><td colspan="4" style="text-align:center;"><br />'
    			, '<input type="hidden" name="type" value="' , $type , '" />',"\n"
    			, '<input type="hidden" name="bid" value="' , $bid , '" />',"\n"
    			, '<input type="submit" value="' , _MODIFBLOCK , '" /></td></tr></table>',"\n"
    			, '<div style="text-align: center;"><br />[ <a href="index.php?file=Admin&amp;page=block"><b>' , _BACK , '</b></a> ]</div></form><br /></div></div>',"\n";
    }

    function modif_advanced_center($data){
        if ($data['content'][1] != '' && $data['content'][2] != ''){
            $sep = '|';
        }
        else{
            $sep = '';
        }

        $content = $data['content'][1] . $sep . $data['content'][2];
        $data['content'] = $content;
        return $data;
    }

    function select_module($mod){
        $handle = opendir('modules');
        while (false !== ($f = readdir($handle))){
            if ($f != '.' && $f != '..' && $f != 'CVS' && $f != 'index.html'  && !preg_match("/\./", $f)){
                if ($mod == $f) $checked = 'selected="selected"';
                else $checked = '';

                if (is_file('modules/' . $f . '/blok.php')) echo '<option value="' , $f , '" ' , $checked , '>' , $f , '</option>',"\n";
            }
        }
        closedir($handle);
    }

?>