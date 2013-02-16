<?php
/**
*   Block of Downloads module
*   Display the last/top 10 files
*
*   @version 1.8
*   @link http://www.nuked-klan.org Clan Management System 4 Gamers NK CMS
*   @license http://opensource.org/licenses/gpl-license.php GNU Public License
*   @copyright 2001-2013 Nuked Klan 
*/
defined('INDEX_CHECK') or die ('<div class="nkAlignCenter">'.CANTOPENPAGE.'</div>');
global $user, $visiteur, $blockSide;
$modName = basename(dirname(__FILE__));

// Bouton radio de sélection
$arrayanswer = array(
    'matchand' => MATCHAND.'<br />',
    'matchexact' => MATCHEXACT.'<br />',
    'matchor' => MATCHOR
);                        
$keyword = $GLOBALS['nkFunctions']->nkRadioBox('label', TYPEOFSEARCH.'&nbsp;:&nbsp;', '3', 'searchtype', $arrayanswer, 'searchtype', 'nkLabelSpacing nkValignTop nkInlineBlock', null, 'nkBlock');

// Nombre de reponse a retrouner
$arrayanswers = array(
    '10' => 10,
    '50' => 50,
    '100' => 100
);                      
$numberOfResponse =  $GLOBALS['nkFunctions']->nkRadioBox( 'label',NBANSWERS.'&nbsp;:&nbsp;', '3', 'limit', $arrayanswers, 'answers', 'nkLabelSpacing nkMarginLRAuto');


if ($blockSide[$modName] == 3 || $blockSide[$modName] == 4) {
?>

    <form method="post" action="index.php?file=Search&amp;op=seeResult" class="nkBorderDotted">
        <div class="nkAlignCenter">
            <h2>
                <?php 
                echo SEARCH; 
                ?>
            </h2>
        </div>
        <div class="nkMarginLRAuto nkPaddingLeft nkPaddingRight">
            <label for="main" class="nkLabelSpacing nkMarginLRAuto"><?php echo KEYWORDS; ?>&nbsp;:&nbsp;</label>
                <input type="text" id="main" name="main" size="30" value="" />
        </div>
        <div class="nkMarginLRAuto nkPaddingLeft nkPaddingRight">
            <?php  
            echo $keyword; 
            ?>
        </div>
        <div class="nkMarginLRAuto nkPaddingLeft nkPaddingRight">
            <label for="autor" class="nkLabelSpacing nkMarginLRAuto"><?php echo AUTHOR; ?>&nbsp;:&nbsp;</label>
                <input type="text" size="30" id="autor" name="autor"  value="" />
        </div>
        <div class="nkMarginLRAuto nkPaddingLeft nkPaddingRight">
            <label for="module" class="nkLabelSpacing nkMarginLRAuto"><?php echo COLUMN; ?>&nbsp;:&nbsp;</label>
                <select id="module" name="module">
                    <option value=""><?php echo SALL; ?></option>
                    <?php
                        $dbsModule = '  SELECT nom 
                                        FROM '.MODULES_TABLE.'
                                        WHERE niveau <= '.$visiteur.'
                                        AND niveau != -1
                                        AND nom != "Stats"
                                        AND nom != "Contact"';
                        $dbeModule = mysql_query($dbsModule);
                        while (list($listModule) = mysql_fetch_array($dbeModule)){
                            $listModule = strtoupper($listModule);
                            $listModule = constant($listModule);

                        ?>
                        <option value="<?php echo $listModule; ?>"><?php echo $listModule; ?></option>
                        <?php
                        }
                        ?>                  
                </select>
        </div>
        <div class="nkMarginLRAuto nkPaddingLeft nkPaddingRight">
            <?php   
            echo $numberOfResponse;
            ?>
        </div>
        <div class="nkAlignCenter nkMarginLRAuto nkMarginTop15 nkMarginBottom15">
            <input type="submit" class="nkButton" name="submit" value="<?php echo SEARCH; ?>" />
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
            <input type="submit" class="nkButton" name="submit" value="<?php echo SEARCH; ?>" />
        </div>
        <div class="nkAlignCenter">
            <a href="index.php?file=Search"><?php echo ADVANCEDSEARCH; ?></a>
        </div>
    </form>
<?php
}
?>