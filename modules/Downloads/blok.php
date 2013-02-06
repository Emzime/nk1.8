<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined('INDEX_CHECK') or die ('<div style="text-align: center;">You cannot open this page directly</div>');
global $language, $user;
translate('modules/Downloads/lang/'.$language.'.lang.php');

$visiteur = $user ? $user[1] : 0;

$sql2 = mysql_query('SELECT active FROM '.BLOCK_TABLE.' WHERE bid="'.$bid.'"');
list($active) = mysql_fetch_array($sql2);
if ($active == 3 || $active == 4) {

    if (is_file('themes/'.$theme.'/images/files.gif')) {
        $img = '<img src="themes/'.$theme.'/images/files.gif" alt="" />';
    } else {
        $img = '<img src="modules/Downloads/images/files.gif" alt="" />';
    }

    $modulePref = $GLOBALS['nkFunctions']->nkModsPrefs('Downloads');
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
                        $sql = mysql_query('SELECT id, titre, date, type, description FROM '.DOWNLOADS_TABLE.' WHERE '.$visiteur.' >= level ORDER BY id DESC LIMIT 0, 10');
                        while (list($idDownload, $title, $date, $cat, $description) = mysql_fetch_array($sql)) 
                        {
                            $title = printSecuTags($title);
                            $date = nkDate($date);

                            if(!$description){
                                $description = NONEDESC;
                            }else{
                                $description = $GLOBALS['nkFunctions']->nkCutText($description, '100');
                            }

                            $sql4 = mysql_query('SELECT titre, parentid FROM '.DOWNLOADS_CAT_TABLE.' WHERE cid = "'.$cat.'"');
                            list($cat_name, $parentid) = mysql_fetch_array($sql4);
                            $cat_name = printSecuTags($cat_name);

                            if ($cat == 0) {
                                $category = '';
                            } else if ($parentid > 0) {
                                $sql5 = mysql_query('SELECT titre FROM '.DOWNLOADS_CAT_TABLE.' WHERE cid = "'.$parentid.'"');
                                list($parent_name) = mysql_fetch_array($sql5);
                                $parent_name = printSecuTags($parent_name);

                                $category = '<a href="index.php?file=Downloads&amp;cat='.$parentid.'">'.$parent_name.'</a>&nbsp;-&nbsp;<a href="index.php?file=Downloads&amp;cat='.$cat.'">'.$cat_name.'</a>';
                            } else {
                                $category = '<a href="index.php?file=Downloads&amp;cat='.$cat.'">'.$cat_name.'</a>';
                            }
                            ?>
                                <li class="nkPadding">
                                    <?php
                                        echo $GLOBALS['nkFunctions']->nkTooltip($description, 'index.php?file=Downloads&amp;nuked_nude=index&amp;idDownload='.$idDownload, $title, 'nkPopupBox', $modulePref['tooltipTheme'], $modulePref['tooltipPosition'], $modulePref['tooltipAnimation'], $modulePref['tooltipMaxWidth'], $modulePref['tooltipArrowColor']);
                                    ?>
                                </li>
                            <?php
                            if ($category != ''){
                                echo'<span class="nkPersonalCatMarginLeft15"><small>'.$category.'</small></span>';
                            }else{
                                echo'<span class="nkPersonalCatMarginLeft15"><small>'.NONECAT.'</small></span>';
                            }
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
                        $sql3 = mysql_query('SELECT id, titre, count, type, description FROM '.DOWNLOADS_TABLE.' WHERE '.$visiteur.' >= level ORDER BY count DESC LIMIT 0, 10');
                        while (list($tidDownload, $ttitle, $tcount, $tcat, $tdesc) = mysql_fetch_array($sql3)) {
                            $sql4 = mysql_query('SELECT titre, parentid FROM '.DOWNLOADS_CAT_TABLE.' WHERE cid = "'.$tcat.'"');
                            list($tcat_name, $tparentid) = mysql_fetch_array($sql4);
                            $tcat_name = printSecuTags($tcat_name);

                            if(!$tdesc){
                                $description = NONEDESC;
                            }else{
                                $description = $GLOBALS['nkFunctions']->nkCutText($tdesc, '100');
                            }

                            if ($tcat == 0) {
                                $tcategory = '';
                            } else if ($tparentid > 0) {
                                $sql5 = mysql_query('SELECT titre FROM '.DOWNLOADS_CAT_TABLE.' WHERE cid = "'.$tparentid.'"');
                                list($tparent_name) = mysql_fetch_array($sql5);
                                $tparent_name = printSecuTags($tparent_name);

                                $tcategory = '<a href="index.php?file=Downloads&amp;cat='.$tparentid.'">'.$tparent_name.'</a>&nbsp;-&nbsp;<a href="index.php?file=Downloads&amp;cat='.$tcat.'">'.$tcat_name.'</a>';
                            } else {
                                $tcategory = '<a href="index.php?file=Downloads&amp;cat='.$tcat.'">'.$tcat_name.'</a>';
                            }
                            ?>
                                <li class="nkPadding">
                                    <?php
                                        echo $GLOBALS['nkFunctions']->nkTooltip($description, 'index.php?file=Downloads&amp;nuked_nude=index&amp;idDownload='.$tidDownload, $ttitle, 'nkPopupBox', $modulePref['tooltipTheme'], $modulePref['tooltipPosition'], $modulePref['tooltipAnimation'], $modulePref['tooltipMaxWidth'], $modulePref['tooltipArrowColor']);
                                    ?>
                                </li>
                            <?php
                            if ($tcategory != ''){
                                echo'<span class="nkPersonalCatMarginLeft15"><small>'.$tcategory.'</small></span>';
                            }else{
                                echo'<span class="nkPersonalCatMarginLeft15"><small>'.NONECAT.'</small></span>';
                            }
                        }
                        ?>
                    </ol>
                </nav>
            </section>
        </article>
        <footer class="nkAlignCenter nkWidthFully nkBlock nkMarginTop15">
            <nav>
                <ul>
                    <li class="nkInlineBlock nkMarginLRAuto nkWidthHalf"><a href="index.php?file=Downloads&amp;orderby=news"><small>+&nbsp;<?php echo MORELAST; ?></small></a></li>
                    <li class="nkInlineBlock nkMarginLRAuto nkWidthHalf"><a href="index.php?file=Downloads&amp;orderby=count"><small>+&nbsp;<?php echo MORETOP; ?></small></a></li>
                </ul>
            </nav>
        </footer>
    </article>
<?php
} else {
    $modulePref = $GLOBALS['nkFunctions']->nkModsPrefs('Downloads');
?>
    <ol class="downloadsOl">
        <?php
        $sql = mysql_query('SELECT dt.id, dt.titre, dt.date, dt.description, dct.titre FROM '.DOWNLOADS_TABLE.' AS dt LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS dct ON dt.type = dct.cid WHERE '.$visiteur.' >= dt.level ORDER BY dt.date DESC LIMIT 0, 10');
        while (list($idDownload, $title, $date, $description, $fileCatName) = mysql_fetch_array($sql)) {
            $titre = printSecuTags($title);
            $date = nkDate($date);
            ?>
            <li>
                <?php
                if(!$description){
                    $description = NONEDESC;
                }else{
                    $description = $GLOBALS['nkFunctions']->nkCutText($description, '100');
                }
                echo $GLOBALS['nkFunctions']->nkTooltip($description, 'index.php?file=Downloads&amp;nuked_nude=index&amp;idDownload='.$idDownload, $title.'<small>&nbsp;('.$date.')</small>', 'nkPopupBox', $modulePref['tooltipTheme'], $modulePref['tooltipPosition'], $modulePref['tooltipAnimation'], $modulePref['tooltipMaxWidth'], $modulePref['tooltipArrowColor']);
                ?>                
            </li>
        <?php
        }
        ?>
    </ol>
<?php
}
?>