<?php
/**
*   Block of Search module
*   Display the last/top 10 files
*
*   @version 1.8
*   @link http://www.nuked-klan.org Clan Management System 4 Gamers NK CMS
*   @license http://opensource.org/licenses/gpl-license.php GNU Public License
*   @copyright 2001-2013 Nuked Klan 
*/
defined('INDEX_CHECK') or die ('<div style="text-align: center;">'.CANTOPENPAGE.'</div>');
global $user, $visiteur, $blockSide;
$modName = basename(dirname(__FILE__));

if ($blockSide == 3 || $blockSide == 4) {
?>
    <form method="post" action="index.php?file=Search&amp;op=mod_search">
        <div class="nkAlignCenter nkMarginTop15 nkMarginBottom15">
            <input type="text" name="main" size="30" />
        </div>
        <div class="nkAlignCenter nkMarginBottom15">
            <input type="submit" class="nkButton" name="submit" value="<?php echo SEARCHFOR; ?>" />
        </div>
        <div class="nkAlignCenter nkMarginBottom15">
            <label for="module"><?php echo COLUMN; ?>&nbsp;:&nbsp;</label>
                <select id="module" name="module">
                    <option value=""><?php echo SALL; ?></option>
                    <?php
                    $path = 'modules/Search/rubriques/';
                    $modules = array();
                    $handle = opendir($path);
                    
                    while ($mod = readdir($handle)){
                        if ($mod != '.' && $mod != '..' && $mod != 'index.html'){
                            $i++;
                            $mod = str_replace('.php', '', $mod);
                            $perm = nivo_mod($mod);
                            if (!$perm) $perm = 0;
                            
                            if ($user[1] >= $perm && $perm > -1){
                                $umod = strtoupper($mod);
                                $modname = '_S' . $umod;
                                if (defined($modname)) $modname = constant($modname);
                                else $modname = $mod;
                                array_push($modules, $modname.'|'.$mod);
                            }
                        }
                    }                   
                    natcasesort($modules);                  
                    foreach($modules as $value){
                        $temp = explode('|', $value);
                        if ($temp[1] == $_REQUEST['file']) $selected = 'selected="selected"';
                        else $selected = '';
                        ?>
                        <option value="<?php echo $temp[1]; ?>" <?php echo $selected; ?>><?php echo $temp[0]; ?></option>
                    <?php
                    }
                    ?>
                </select>
        </div>
    </form>
<?php
}else{
?>
    <form method="post" action="index.php?file=Search&amp;op=mod_search">
        <div class="nkAlignCenter nkMarginBottom15">
            <input type="text" class="nkInput" name="main" />
        </div>
        <div class="nkAlignCenter nkMarginBottom15">
            <input type="hidden" name="module" value="" />
            <input type="submit" class="nkButton" name="submit" value="<?php echo SEARCHFOR; ?>" />
        </div>
        <div class="nkAlignCenter">
            <a href="index.php?file=Search"><?php echo ADVANCEDSEARCH; ?></a>
        </div>
    </form>
<?php
}
?>