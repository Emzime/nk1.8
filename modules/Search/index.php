<?php
/**
*   Downloads module
*   Display files on database
*
*   @version 1.8
*   @link http://www.nuked-klan.org Clan Management System 4 Gamers NK CMS
*   @license http://opensource.org/licenses/gpl-license.php GNU Public License
*   @copyright 2001-2013 Nuked Klan 
*/
defined('INDEX_CHECK') or die ('<div style="text-align: center;">'.CANTOPENPAGE.'</div>');
global $language, $user;
$modName = basename(dirname(__FILE__));

$level_access = nivo_mod($modName);

compteur('Search');

// Vérification des variables
$requestArray = array(
        'main',
        'searchtype',
        'limit',
        'autor',
        'p',
        'result',
        'tab',
        'module'
    );
$GLOBALS['nkFunctions']->nkInitRequest($requestArray);


    function index($main, $searchtype, $limit, $autor, $module){
        global $nuked, $user;

        // Bouton radio de sélection
        $arrayanswers = array(
            'matchand' => MATCHAND.'<br />',
            'matchexact' => MATCHEXACT.'<br />',
            'matchor' => MATCHOR
        );                        
        $keyword = $GLOBALS['nkFunctions']->nkRadioBox('searchtype', 'nkWidthQuarter', '', '3', $arrayanswers, 'searchtype', 'nkWidth3Quarter');

        // Nombre de reponse a retrouner
        $arrayanswers = array(
            '10' => 10,
            '50' => 50,
            '100' => 100
        );                        
        $numberOfResponse =  $GLOBALS['nkFunctions']->nkRadioBox('limit', 'nkLabelSpacing nkWidthQuarter nkMarginLRAuto', NBANSWERS.'&nbsp;:&nbsp;', '3', $arrayanswers, 'answers');
        
        $main = stripslashes($main);

        if ($searchtype == MATCHOR) {
            $checked1 = 'checked="checked"';
        } elseif ($searchtype == MATCHEXACT) {
            $checked3 = 'checked="checked"';
        } else {
            $checked2 = 'checked="checked"';
        }

        if ($limit == 10) {
            $checked4 = 'checked="checked"';
        } elseif ($limit == 100) {
            $checked6 = 'checked="checked"';
        } else {
            $checked5 = 'checked="checked"';
        }
        ?>

        <article>
        	<form method="post" action="index.php?file=Search&amp;op=seeResult">
                <div class="nkAlignCenter">
            		<h2>
                        <?php 
                        echo SEARCHFOR; 
                        ?>
                    </h2>
                </div>
                <div class="nkWidth3Quarter  nkMarginLRAuto">
            		<label for="main" class="nkLabelSpacing nkWidthQuarter nkMarginLRAuto"><?php echo KEYWORDS; ?>&nbsp;:&nbsp;</label>
                        <input type="text" id="main" name="main" size="30" value="<?php echo printSecuTags($main); ?>" />
                </div>
                <div class="nkWidth3Quarter  nkMarginLRAuto">
                    <?php  
                    echo $keyword; 
                    ?>
                </div>
                <div class="nkWidth3Quarter  nkMarginLRAuto">
            		<label for="autor" class="nkLabelSpacing nkWidthQuarter nkMarginLRAuto"><?php echo AUTHOR; ?>&nbsp;:&nbsp;</label>
                        <input type="text" size="30" id="autor" name="autor"  value="<?php echo printSecuTags($autor); ?>" />
                </div>
                <div class="nkWidth3Quarter  nkMarginLRAuto">
            		<label for="module" class="nkLabelSpacing nkWidthQuarter nkMarginLRAuto"><?php echo COLUMN; ?>&nbsp;:&nbsp;</label>
                        <select id="module" name="module">
                            <option value=""><?php echo SALL; ?></option>
                            <?php
                            // Affichage des modules
                            seeModule();
                            ?>
                        </select>
                </div>
                <div class="nkWidth3Quarter nkMarginLRAuto">
                    <?php   
                    echo $numberOfResponse;
                    ?>
                </div>
                <div class="nkAlignCenter nkMarginLRAuto nkMarginTop15">
        			<input type="submit" class="nkButton" name="submit" value="<?php echo SEARCHFOR; ?>" />
                </div>
            </form>
        </article>
    <?php
    }

    function seeResult($main, $searchtype, $limit, $autor, $module){
        global $nuked, $user, $path;

        if (!$limit){
            $limit = 50;
        }

        if (!$searchtype){
            $searchtype = 'matchand';
        }

        index($main, $searchtype, $limit, $autor, $module);

        $main = trim($main);
        $autor = trim($autor);

        if ($main != '' || $autor != '') {
            if (strlen($main) < 3 && strlen($autor) < 3) {
                echo $GLOBALS['nkTpl']->nkDisplayError(CHARSMIN, 'nkAlignCenter');
                footer();
                exit();
            } 

            $main = mysql_real_escape_string(stripslashes($main));
            $autor = htmlentities($autor, ENT_QUOTES);
            $autor = nk_CSS($autor);
            $autor = mysql_real_escape_string(stripslashes($autor));
            $search = explode(' ', $main);
            $i = 0;

            
            $tab = array(
                'module' => array(), 
                'title' => array(), 
                'link' => array()
            );

            $handle = opendir($path);
            while ($mod = readdir($handle)) {
                if ($mod != '.' && $mod != '..' && $mod != 'index.html') {
                    $i++;
                    $mod = str_replace('.php', '', $mod);
                    $perm = nivo_mod($mod);
                    if (!$perm){
                        $perm = 0;
                    }
                    
                    if ($user[1] >= $perm && $perm > -1 && ($module == $mod || $module == '')){
                        $umod = strtoupper($mod);
                        $modname = 'S'.$umod;
                        if (defined($modname)) $modname = constant($modname);
                        else $modname = $mod;
                        require_once($path.$mod.'.php');
                    } 
                } 
            } 

            $l = count($tab['module']);

            if (!$_REQUEST['p']) {
                $_REQUEST['p'] = 1;
            }

            $pageStart = $_REQUEST['p'] * $limit - $limit;
            $pageEnd = $pageStart + $limit;

            if ($pageEnd > $l){
                $pageEnd = $l;
            }
            ?>

            <article class="nkWidthFully">
                <h2 class="nkAlignCenter">
                    <?php echo SEARCHRESULT; ?>
                </h2>
                <span>
                    <?php echo RETURNS; ?>&nbsp;<?php echo $l; ?>&nbsp;<?php echo RESULTS; ?>
                </span>
                
                <?php
                if ($l > $limit) { 
                    number($l, $limit, 'index.php?file=Search&amp;op=mod_search&amp;main='.urlencode($main).'&amp;autor='.$autor.'&amp;module='.$module.'&amp;limit='.$limit.'&amp;searchtype='.$searchtype);
                }
                ?>
                <nav>
                    <?php
                    for ($a = $pageStart;$a < $pageEnd;$a++) {
                    ?>
                    <ul class="nkAlternColor">
                        <li class="nkInlineBlock nkWidth3Quarter nkPaddingTop nkPaddingBottom"><a href="<?php echo $tab['link'][$a]; ?>"><?php echo $tab['title'][$a]; ?></a></li>
                        <li class="nkInlineBlock nkWidthQuarter nkAlignRight nkPaddingTop nkPaddingBottom"><?php echo $tab['module'][$a]; ?></li>

                    </ul>
                    <?php
                    } 
                    ?>
                </nav>
            </article>

            <?php
            if ($l > $limit){ 
                $search_url = "index.php?file=Search&amp;op=mod_search&amp;main=" . urlencode($main) . "&amp;autor=" . $autor . "&amp;module=" . $module . "&amp;limit=" . $limit . "&amp;searchtype=" . $searchtype;
                number($l, $limit, $search_url);
            }
        } 
        else{
            echo $GLOBALS['nkTpl']->nkExitAfterError(NOWORDS, 'nkAlignCenter');
        } 
    } 

    function seeModule() {
        global $nuked, $user;

        $dbsModule = '  SELECT nom 
                        FROM '.MODULES_TABLE.'
                        WHERE niveau <= '.$user[1].'
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
    }



    switch ($_REQUEST['op']) {

        case "seeResult":
        seeResult($_REQUEST['main'], $_REQUEST['searchtype'], $_REQUEST['limit'], $_REQUEST['autor'], $_REQUEST['module']);
        break;

        default:
        index($_REQUEST['main'], $_REQUEST['searchtype'], $_REQUEST['limit'], $_REQUEST['autor'], $_REQUEST['module']);
         break;
    }

?>