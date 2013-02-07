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

defined('INDEX_CHECK') or die ('<div style="text-align: center;">You cannot open this page directly</div>');
global $language, $user;
translate('modules/Downloads/lang/'.$language.'.lang.php');

if($user){
    $visiteur = $user['1'];
}else{
    $visiteur = 0;
}

$dbsActive = 'SELECT active FROM '.BLOCK_TABLE.' WHERE bid = '.$bid;
$dbeActive = mysql_query($dbsActive);
list($active) = mysql_fetch_array($dbeActive);

$modulePref = $GLOBALS['nkFunctions']->nkModsPrefs('Downloads');

$dbsLastBlock = 'SELECT dt.id, dt.titre, dt.date, dt.type, dt.description, dct.titre, dct.parentid, dct2.titre 
            FROM '.DOWNLOADS_TABLE.' AS dt 
            LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS dct ON dt.type = dct.cid 
            LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS dct2 ON dct.parentid = dct2.cid 
            WHERE '.$visiteur.' >= dt.level 
            ORDER BY dt.date 
            DESC LIMIT 0, 10';
$dbeLastBlock = mysql_query($dbsLastBlock);

if ($active == 3 || $active == 4) {
?>

    <article class="nkWidthFully nkMarginBottom15">
        <article class="nkInlineBlock nkWidthHalf nkValignTop">
            <header>
                <h2 class="nkAlignCenter"><a href="index.php?file=Download&amp;orderby=news"><?php echo LASTDOWN; ?></a></h2>
            </header>
            <section id="nkPersonalCss" class="nkBlock nkWidthFully">
                <nav>
                    <ol class="downloadsOl nkInlineBlock">
                        <?php
                        while (list($fileId, $fileTitle, $fileDate, $fileCatId, $fileDescription, $fileCatName, $fileParentId, $fileParentCatName) = mysql_fetch_array($dbeLastBlock)) 
                        {
                            $fileTitle = printSecuTags($fileTitle);
                            $fileDate = nkDate($fileDate);
                            $fileCatName = printSecuTags($fileCatName);
                            $fileParentCatName = printSecuTags($fileParentCatName);

                            if(!$fileDescription){
                                $fileDescription = NONEDESC;
                            }else{
                                $fileDescription = $GLOBALS['nkFunctions']->nkCutText($fileDescription, '100');
                            }

                            if ($fileParentId == 0 && !is_null($fileParentId)) {
                                $linkLastView = '<a href="index.php?file=Downloads&amp;cat='.$fileCatId.'">'.$fileCatName.'</a>';
                            } else if ($fileParentId > 0) {
                                $linkLastView = '<a href="index.php?file=Downloads&amp;cat='.$fileParentId.'">'.$fileParentCatName.'</a>&nbsp;-&nbsp;<a href="index.php?file=Downloads&amp;cat='.$fileCatId.'">'.$fileCatName.'</a>';
                            } else {
                                $linkLastView = NONECAT;
                            }

                            ?>
                            <li class="nkPadding">
                                <?php
                                    echo $GLOBALS['nkFunctions']->nkTooltip($fileDescription, 'index.php?file=Downloads&amp;nuked_nude=index&amp;idDownload='.$fileId, $fileTitle, 'nkPopupBox', $modulePref['tooltipTheme'], $modulePref['tooltipPosition'], $modulePref['tooltipAnimation'], $modulePref['tooltipMaxWidth'], $modulePref['tooltipArrowColor']);
                                ?>
                            </li>
                            <span class="nkPersonalCatMarginLeft15"><small><?php echo $linkLastView ?></small></span> 
                        <?php                               
                        }
                        ?>
                    </ol>
                </nav>
            </section>
        </article>
        <article class="nkInlineBlock nkWidthHalf nkValignTop">
            <header>
                <h2 class="nkAlignCenter"><a href="index.php?file=Downloads&amp;orderby=count"><?php echo TOPDOWN; ?></a><h2>
            </header>
            <section class="nkBlock nkWidthFully">
                <nav>
                    <ol class="downloadsOl nkInlineBlock">
                        <?php
                        $dbsTopBlock = 'SELECT dt.id, dt.titre, dt.date, dt.type, dt.description, dct.titre, dct.parentid, dct2.titre 
                                    FROM '.DOWNLOADS_TABLE.' AS dt 
                                    LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS dct ON dt.type = dct.cid 
                                    LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS dct2 ON dct.parentid = dct2.cid 
                                    WHERE '.$visiteur.' >= dt.level 
                                    ORDER BY dt.count 
                                    DESC LIMIT 0, 10';
                        $dbeTopBlock = mysql_query($dbsTopBlock);
                        while (list($fileTopId, $fileTopTitle, $fileTopDate, $fileTopCatId, $fileTopDescription, $fileTopCatName, $fileTopParentId, $fileTopParentCatName) = mysql_fetch_array($dbeTopBlock)) 
                        {
                            $fileTopTitle = printSecuTags($fileTopTitle);
                            $fileTopDate = nkDate($fileTopDate);
                            $fileTopCatName = printSecuTags($fileTopCatName);
                            $fileTopParentCatName = printSecuTags($fileTopParentCatName);

                            if(!$fileTopDescription){
                                $fileTopDescription = NONEDESC;
                            }else{
                                $fileTopDescription = $GLOBALS['nkFunctions']->nkCutText($fileTopDescription, '100');
                            }

                            if ($fileTopParentId == 0 && !is_null($fileTopParentId)) {
                                $linkTopView = '<a href="index.php?file=Downloads&amp;cat='.$fileTopCatId.'">'.$fileTopCatName.'</a>';
                            } else if ($fileTopParentId > 0) {
                                $linkTopView = '<a href="index.php?file=Downloads&amp;cat='.$fileTopParentId.'">'.$fileTopParentCatName.'</a>&nbsp;-&nbsp;<a href="index.php?file=Downloads&amp;cat='.$fileTopCatId.'">'.$fileTopCatName.'</a>';
                            } else {
                                $linkTopView = NONECAT;
                            }

                            ?>
                            <li class="nkPadding">
                                <?php
                                    echo $GLOBALS['nkFunctions']->nkTooltip($fileTopDescription, 'index.php?file=Downloads&amp;nuked_nude=index&amp;idDownload='.$fileTopId, $fileTopTitle, 'nkPopupBox', $modulePref['tooltipTheme'], $modulePref['tooltipPosition'], $modulePref['tooltipAnimation'], $modulePref['tooltipMaxWidth'], $modulePref['tooltipArrowColor']);
                                ?>
                            </li>
                            <span class="nkPersonalCatMarginLeft15"><small><?php echo $linkTopView ?></small></span> 
                        <?php       
                        }
                        ?>
                    </ol>
                </nav>
            </section>
        </article>
        <footer class="nkAlignCenter nkWidthFully nkBlock nkMarginTop15">
            <nav>
                <ul>
                    <li class="nkInlineBlock nkMarginLRAuto nkWidthHalf"><a href="index.php?file=Downloads&amp;orderby=newse"><small>+&nbsp;<?php echo MORELAST; ?></small></a></li>
                    <li class="nkInlineBlock nkMarginLRAuto nkWidthHalf"><a href="index.php?file=Downloads&amp;orderby=count"><small>+&nbsp;<?php echo MORETOP; ?></small></a></li>
                </ul>
            </nav>
        </footer>
    </article>
<?php
} else {
?>
    <ol class="downloadsOl">
        <?php
        while (list($fileId, $fileTitle, $fileDate, $fileCatId, $fileDescription, $fileCatName, $fileParentId, $fileParentCatName) = mysql_fetch_array($dbeLastBlock)) {
            $fileTitle = printSecuTags($fileTitle);
            $fileDate = nkDate($fileDate);
            if(!$fileDescription){
                $fileDescription = NONEDESC;
            }else{
                $fileDescription = $GLOBALS['nkFunctions']->nkCutText($fileDescription, '100');
            }
            ?>
            <li>
                <?php
                echo $GLOBALS['nkFunctions']->nkTooltip($fileDescription, 'index.php?file=Downloads&amp;nuked_nude=index&amp;idDownload='.$fileId, $fileTitle.'<small>&nbsp;('.$fileDate.')</small>', 'nkPopupBox', $modulePref['tooltipTheme'], $modulePref['tooltipPosition'], $modulePref['tooltipAnimation'], $modulePref['tooltipMaxWidth'], $modulePref['tooltipArrowColor']);
                ?>                
            </li>
        <?php
        }
        ?>
    </ol>
<?php
}
?>