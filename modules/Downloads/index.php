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

global $language, $user, $nuked;

$modName = basename(dirname(__FILE__));

$level_access = nivo_mod($modName);
translate('modules/'.$modName.'/lang/'.$language.'.lang.php');
$visiteur = $user ? $user[1] : 0;
if ($visiteur >= $level_access && $level_access > -1) 
{
    compteur($modName);

    $arrayMenu = array(
        'index.php?file='.$modName                          =>  INDEX,
        'index.php?file='.$modName.'&amp;orderby=newse'     =>  NEWSFILE,
        'index.php?file='.$modName.'&amp;orderby=count'     =>  POPULAR,
        'index.php?file=Suggest&amp;module='.$modName.''    =>  SUGGESTFILE
    );

    $breadCrumbArray = array(
        'index.php'                 => HOME,
        'index.php?file='.$modName   => DOWNLOAD
    );

    if($_REQUEST['cat']){
        $orderByArray = array(
            'index.php?file='.$modName.'&amp;cat='.$_REQUEST['cat'].'&amp;orderbycat=news'     => DATE,
            'index.php?file='.$modName.'&amp;cat='.$_REQUEST['cat'].'&amp;orderbycat=count'    => TOPFILE,
            'index.php?file='.$modName.'&amp;cat='.$_REQUEST['cat'].'&amp;orderbycat=name'     => NAME,
            'index.php?file='.$modName.'&amp;cat='.$_REQUEST['cat'].'&amp;orderbycat=note'     => NOTE
        );
    }else{
        $orderByArray = array(
            'index.php?file='.$modName.'&amp;orderbycat=news'     => DATE,
            'index.php?file='.$modName.'&amp;orderbycat=count'    => TOPFILE,
            'index.php?file='.$modName.'&amp;orderbycat=name'     => NAME,
            'index.php?file='.$modName.'&amp;orderbycat=note'     => NOTE
        );
    }

    function index($cat){
        global $nuked, $arrayMenu, $breadCrumbArray, $orderByArray, $modName, $visiteur;

        $modulePref = $GLOBALS['nkFunctions']->nkModsPrefs($modName);

        $hide_donwload      = $modulePref['hideDescription'];   // affichage ou non de la description des téléchargements
        $fileMaxDownload    = $modulePref['fileMaxDownload'];   // nombre de fichier par page
        $fileNbSubcat       = $modulePref['fileNbSubcat'];      // nombre de sous cat a afficher
        $breadCrumbTheme    = $modulePref['breadCrumbTheme'];   // theme choisi pour le breadcrumb
        $fileNewTime        = $modulePref['fileNewTime'];       // temps pour qu'un fichier reste en NEW
        $nbFileNew          = $modulePref['nbFileNew'];         // Nombre de fichier pour le classement des fichiers New
        $nbFileHot          = $modulePref['nbFileHot'];         // nombre de telechargement pour qu'un fichier soit HOT
        $fileNbComment      = $modulePref['fileNbComment'];     // nombre de commentaire a afficher
        $fileNbCommentCut   = $modulePref['fileNbCommentCut'];  // nombre de lettres pour le découpe des mots

    /* Affichage si clic sur les blocks */
    if($_REQUEST['idDownload']){

        $requestFile = 'SELECT D.titre, D.description, D.taille, D.type, D.count, D.date, D.url, D.screen, D.level, D.edit, D.autor, D.url_autor, D.comp, C.titre, avg( V.vote ) AS note
            FROM '.DOWNLOADS_TABLE.' AS D
            LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS C ON C.cid = D.type
            LEFT JOIN '.VOTE_TABLE.' AS V ON D.id = V.vid
            AND V.module = \''.$modName.'\'
            WHERE D.id = '.$_REQUEST['idDownload'];
        $sqlFileExecute = mysql_query($requestFile);
        list($fileTitle, $fileDescription, $fileSize, $fileType, $fileCount, $fileDate, $fileUrl, $fileScreen, $fileLevel, $fileEdit, $fileAutor, $fileUrlAutor, $fileCompatibility, $fileCatTitle, $fileNote) = mysql_fetch_array($sqlFileExecute);


        /* A ADAPTER AVEC LE FUNCTION VOTE */
        $fileNote = round($fileNote, 2);
        $fileNote = $fileNote.'&nbsp;/&nbsp;10';

        /* Affichage de l'image correspondant a l'extension du fichier */
        $fileExtension = strrchr($fileUrl, '.');
        $fileExtension = substr($fileExtension, 1);
        if ($fileExtension == "zip") {
            $fileExtensionClass = '<span class="nkIconZip"></span>';
        } else if ($fileExtension == "rar") {
            $fileExtensionClass = '<span class="nkIconZip"></span>';
        } else if ($fileExtension == "jpg" || $fileExtension == "jpeg") {
            $fileExtensionClass = '<span class="nkIconJpg"></span>';
        }else if ($fileExtension == "png") {
            $fileExtensionClass = '<span class="nkIconPng"></span>';
        }else if ($fileExtension == "gif") {
            $fileExtensionClass = '<span class="nkIconGif"></span>';
        }else if ($fileExtension == "bmp") {
            $fileExtensionClass = '<span class="nkIconBmp"></span>';
        }else{
            $fileExtensionClass = '<span class="nkIconNone"></span>';
        }

        /* Affichage d'un message si la description est vide */
        if (empty($fileDescription)) {
            $fileTexte = '<p class="nkMargin">'.NOTKNOW.'</p>';
        } else {

            $fileDescriptions = htmlentities($fileDescription);
            $fileTexte = html_entity_decode($fileDescriptions);
            $fileTexte = icon($fileTexte);
        }

        /* Affichage de la taille du fichier si calculable */
        if ($fileSize != '' && $fileSize < 1000) {
            $fileSize = $fileSize.'&nbsp;'.KO;
        } else if ($fileSize != '' && $fileSize >= 1000) {
            $fileSize = $fileSize / 1000;
            $fileSize = $fileSize.'&nbsp;'.MO;
        } else {
            $fileSize = NOTKNOW;
        }

        /* Message d'erreur si compatibilité non précisé */
        if(empty($fileCompatibility)) {
            $fileCompatibility = NOTKNOW;
        }

        /* Message d'erreur si site de l'auteur inconnu sinon lien vers celui-ci */
        if(empty($fileUrlAutor)){
                $fileUrlAutor = NOTKNOW;
        }else{
                $fileUrlAutor = '<a href="'.$fileUrlAutor.'" target="_blank">'.VISITAUTORWEBSITE.'</a>';
        }

        /* Message d'erreur si auteur non précisé sinon affichage de son pseudo */
        if(empty($fileAutor)){
                $fileAutor = NOTKNOW;
        }else{
                $fileAutor = $fileAutor;
        }
        
        /* Affiche le nombre de commentaires */
        $sqlComDl = mysql_query('SELECT id FROM '.COMMENT_TABLE.' WHERE im_id = '.$_REQUEST['idDownload']);
        $fileNbComment = mysql_num_rows($sqlComDl);

        /* Affichage d'un message si catégorie null */
        if($fileCatTitle == '') $fileCatTitle = NONECAT;
        
        /* Affichage de l'image si existante sinon affichage image de substitution */
        if ($fileScreen != '') {
            $box = '<a href="'.checkimg($fileScreen).'" class="nkPopupBox"><img src="'.checkimg($fileScreen).'" title="'.$fileTitle.'" alt="" /></a>';
        } else {
            $box = '<img src="'.checkimg('images/noimage.png').'" title="'.$fileTitle.'" alt="" />';
        }

        /* Récupération de l'extention */
        if ($fileExtension != '' && !preg_match('`\?`i', $fileUrl) && !preg_match('`.html`i', $fileUrl) && !preg_match('`.htm`i', $fileUrl)) $fileExtension = $fileExtension;

        $fileName = strrchr($fileUrl, '/');
        $fileName = substr($fileName, 1);
        if ($fileName != '' && !preg_match('`\?`i', $fileUrl) && !preg_match('`.html`i', $fileUrl) && !preg_match('`.htm`i', $fileUrl)) $filename = $fileName;

        ?>

        <!-- Section interne du module -->
        <section class="nkWidthFull nkMarginLRAuto nkPersonalCssFor<?php echo $modName; ?>Desc nkPaddingBottom">
            <!-- Header de la section interne du module -->
            <header>
                <div class="nkInlineBlock">
                    <figure class="nkInline nkMarginLeft"> <?php echo $fileExtensionClass; ?></figure>
                    <h4 class="nkInline"><?php echo $fileTitle; ?></h4>
                </div>
                <div class="nkInlineBlock">
                    <?php
                        /* A COMPLETER QUAND LA LIBRAIRIE VOTE SERA FAITE */
                       // rating($modName, $_REQUEST['idDownload']);
                    ?>
                </div>
            </header>
            <!-- Article de la section interne du module -->
            <article class="nkBlock nkPadding">
                <div class="nkInlineBlock nkWidth3Quarter">
                    <h2 class="nkSize16 nkAlignCenter">
                        <?php echo INFO; ?>
                    </h2>
                    <div class="nkWidthHalf nkInlineBlock">
                        <ul class="nkInlineBlock nkValignTop">
                            <li><span class="nkIconFolder"></span><?php echo CAT; ?>&nbsp;:&nbsp;<small><?php echo $fileCatTitle; ?></small></li>
                            <li><span class="nkIconDate"></span><?php echo ADDTHE; ?>&nbsp;:&nbsp;<small><?php echo nkDate($fileDate); ?></small></li>
                            <?php
                            /* Affichage d'un message si pas d'édition */
                            if($fileEdit) {
                            ?>
                                <li><span class="nkIconDateUpdate"></span><?php echo EDITTHE; ?>&nbsp;:&nbsp;<small><?php echo nkDate($fileEdit); ?></small></li>
                            <?php
                            }else{
                            ?>
                                <li><span class="nkIconDateUpdate"></span><?php echo EDITTHE; ?>&nbsp;:&nbsp;<small><?php echo NOTKNOW; ?></small></li>
                            <?php
                            }
                            ?>
                            <li><span class="nkIconInfo"></span><?php echo SIZE; ?>&nbsp;:&nbsp;<small><?php echo $fileSize; ?></small></span></li>
                            <li><span class="nkIconRefresh"></span><?php echo COMPATIBLE; ?>&nbsp;:&nbsp;<small><?php echo $fileCompatibility; ?></small></li>
                        </ul>
                    </div>
                    <div class="nkWidthHalf nkInlineBlock">
                        <ul class="nkInlineBlock nkValignTop">
                            <li><span class="nkIconAutor"></span><?php echo AUTOR; ?>&nbsp;:&nbsp;<small><?php echo $fileAutor; ?></small></li>
                            <li><span class="nkIconGlobe"></span><?php echo SITE; ?>&nbsp;:&nbsp;<small><?php echo $fileUrlAutor; ?></small></li>
                            <li><?php echo $fileExtensionClass; ?><?php echo EXT; ?>&nbsp;:&nbsp;<small><?php echo $fileExtension; ?></small></li>
                            <li><span class="nkIconComments"></span><?php echo FILEVOTE; ?>&nbsp;:&nbsp;<small><?php echo $fileNote; ?></small></li>
                            <li><span class="nkIconDownload"></span><?php echo DOWNLOADED; ?>:&nbsp;<small><?php echo $fileCount.'&nbsp;'.TIMES; ?></small></li>
                        </ul>
                    </div>
                    <?php
                    /* Affichage de la description si option defini par l'administrateur */
                    if ($hide_donwload == "off") {
                    ?> 
                        <h3>
                            <?php echo DESCR; ?>
                        </h3>
                        <div class="nkMarginBottom">
                            <?php echo $fileTexte; ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <!-- Parti deporté pour le module commentaire -->
                <aside class="nkInlineBlock nkMarginTop15 nkValignTop nkWidthQuarter nkAlignCenter">
                    <figure><?php echo $box; ?></figure>
                        <?php 
                            viewComment($modName, $_REQUEST['idDownload'], $fileNbComment, $fileNbComment_cut);
                        ?>
                </aside>
            </article>
            <!-- Footer de la section interne du module -->
            <footer class="nkAlignCenter nkMargin nkWidth3Quarter">
                <?php
                    /* Affichage du bouton télécharger si le visiteur a le niveau */
                    if($visiteur >= $fileLevel){
                ?>
                        <a href="index.php?file=<?php echo $modName; ?>&amp;op=doDownload&amp;nuked_nude=index&amp;idDownload=<?php echo $_REQUEST['idDownload']; ?>" title="<?php echo DOWNLOAD.' '.$fileTitle; ?>" class="nkButton"><?php echo DOWNLOAD; ?></a>
                <?php
                    /* Affichage du bouton de demande d'itentification */
                    }else if($visiteur == 0){
                ?>
                        <a href="index.php?file=User&amp;nuked_nude=index&amp;op=login_screen" title="" class="nkPopupBox nkButton"><?php echo NEEDLOGIN; ?></a>
                <?php
                    /* Affichage du bouton si niveau requis */
                    }else if($visiteur < $level && $visiteur != 0){                                            
                ?>
                        <!-- A MODIFIER AVEC LA LIBRAIRIE USER REQUEST -->
                        <a href="" title="" class="nkButton"><?php echo NEEDLEVEL; ?></a>
                <?php
                    }
                ?>
            </footer>
        </section>
    <?php
    /* Affichage de l'index du module */
    }else{
        /* Definition de la page de demarrage de la fonction page */
        if (!$_REQUEST['p']){
            $_REQUEST['p'] = 1;
        }
        $start = $_REQUEST['p'] * $fileMaxDownload - $fileMaxDownload;

        /* Requete pour les fichiers */
        if($cat){
            $whereFileCat = 'WHERE type="'.$cat.'"';
            $whereCat = 'WHERE cid="'.$cat.'"';
        }else if($_REQUEST['orderby']){
            $whereFileCat = '';            
        }else{
            $whereFileCat = 'WHERE type=0';
            $whereCat = 'WHERE cid=0';
            $cat = 0;
        }

        /* Requete sur orderbycat */
        if ($_REQUEST['orderbycat'] == 'name') {
            $order = 'ORDER BY D.titre';
            $orderCatSelect = NAME;  
        } else if ($_REQUEST['orderbycat'] == 'count') {
            $order = 'ORDER BY D.count DESC';
            $orderCatSelect = TOPFILE; 
        } else if ($_REQUEST['orderbycat'] == 'note') {
            $order = 'ORDER BY note DESC';  
            $orderCatSelect = NOTE;  
        } else if (!isset($_REQUEST['orderbycat']) || $_REQUEST['orderbycat'] = 'news') {
            $order = 'ORDER BY D.date DESC';
            $orderCatSelect = DATE;
        }

        /* Requete sur orderby */
        if ($_REQUEST['orderby'] == 'count') {
            $order = 'ORDER BY D.count DESC'; 
            $orderSelect = POPULAR;  
        } else if ($_REQUEST['orderby'] == 'newse') {
            $order = 'ORDER BY D.date DESC LIMIT '.$nbFileNew;   
            $orderSelect = NEWSFILE;  
        } else if (!isset($_REQUEST['orderby'])) {
            $orderSelect = INDEX;  
        }

        /* Affichage si orderby present dans le lien */
        if(!$_REQUEST['orderby']){
            /* Requete pour la nav des catégories */
            $sqlCat = 'SELECT a.cid, a.titre as Cat, a.shortDescription,                
                GROUP_CONCAT(b.cid SEPARATOR "|") as subCatId, 
                GROUP_CONCAT(b.titre SEPARATOR "|") as subCatTitle
                FROM '.DOWNLOADS_CAT_TABLE.' AS a
                LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS b ON a.cid = b.parentid
                WHERE a.parentid = 0 
                Group by Cat';
            $sqlCatExecute = mysql_query($sqlCat);
            $nbCat = mysql_num_rows($sqlCatExecute);

            /* Requete pour les informations de catégories */
            $sqlCatDesc = 'SELECT a.description,
                GROUP_CONCAT(b.cid SEPARATOR "|") as subCatId
                FROM '.DOWNLOADS_CAT_TABLE.' AS a
                LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS b ON a.cid = b.parentid
                WHERE a.cid = '.$cat.'
                Group by a.cid';
            $sqlCatDescExecute = mysql_query($sqlCatDesc);
            list($catDesc, $catChildId) = mysql_fetch_array($sqlCatDescExecute);

            /* Affichage si la catégorie est egal a 0 et absence de orderby*/
            if($cat == 0 && !$_REQUEST['orderby'] ){
                $sqlViewCat = '<nav class="nkMarginTop15 nkAlignCenter nkWidthFull"><ul class="nkMarginTop nkWidthFully nkMarginLRAuto">';
                while(list($catId, $catTitle, $catShortDescription, $subCatId, $subCatTitle) = mysql_fetch_array($sqlCatExecute)){

                    /* Comptage des fichiers pour la catégorie appelée */
                    $sqlFile = mysql_query('SELECT type FROM '.DOWNLOADS_TABLE.' WHERE type = "'.$catId.'"');
                    $nbFile = mysql_num_rows($sqlFile);

                    /* Affichage du nombre de fichier dans la catégorie */
                    if ($nbFile > 0) {                            
                        $nbFileView = '<small class="nkValignTop">('.$nbFile.')</small>';                
                    }else{
                        $nbFileView = '<small class="nkValignTop">(0)</small>';
                    }

                    $sqlViewCat .= '<li class="nkPersonalCat nkInlineBlock nkWidthTier nkMarginBottom nkValignTop nkPadding nkMarginLeft nkMarginRight"><a href="index.php?file='.$modName.'&amp;cat='.$catId.'">'.$catTitle.'</a>&nbsp;'.$nbFileView;
                        $sqlViewCat .= '<div class="nkAlignLeft nkMarginLRAuto">'.$catShortDescription.'</div>';

                    /* Affichage si sous catégorie existante */
                    if(!is_null($subCatId) AND !is_null($subCatTitle)){
                        $subId = explode('|', $subCatId);
                        $subTitle = explode('|', $subCatTitle);
                        $mergeSubCat = array_combine($subId, $subTitle);
                        $sqlViewCat .= '<ul class="nkMarginLRAuto nkAlignLeft nkWidthFull nkValignTop">';
                        foreach ($mergeSubCat as $keyId => $valueTitle) {
                            $sqlnbFileSubCat = mysql_query('SELECT type FROM '.DOWNLOADS_TABLE.' WHERE type = "'.$keyId.'"');
                            $nbFileSub = mysql_num_rows($sqlnbFileSubCat);

                            if ($nbFileSub > 0) {
                                $nbFileSubView = '<small>&nbsp;('.$nbFileSub.')</small>';                
                            }else{
                                $nbFileSubView = '<small>&nbsp;(0)</small>';
                            }

                            if ($nbFileSub > $fileNbSubcat) {
                                $sqlViewCat .= '<li class="nkInlineBlock nkWidthHalf nkAlignCenter nkValignTop"><small><a href="index.php?file='.$modName.'&amp;cat='.$keyId.'">'.$valueTitle.'</a></small>'.$nbFileSubView.'</li>';
                            }else{
                                $sqlViewCat .= '<span>&hellip;</span>';
                            }
                        }
                        $sqlViewCat .= '</ul>';
                    }
                    $sqlViewCat .= '</li>';
                }
                $sqlViewCat .= '</ul></nav>';

            /* Affichage si catégorie differente de 0 et absence de orderby */
            }else if($cat != 0 && !$_REQUEST['orderby'] ){
                /* Affichage si pas de sous catégorie dans la catégorie appelée */
                if(!is_null($catChildId)){
                    $sqlViewCat = '<nav class="nkMarginTop15 nkAlignCenter nkWidthFull">';

                    while(list($catId, $catTitle, $catShortDescription, $subCatId, $subCatTitle) = mysql_fetch_array($sqlCatExecute)){

                        $sqlNbFile = 'SELECT type FROM '.DOWNLOADS_TABLE.' WHERE type = "'.$catId.'"';
                        $sqlNbFileExecute = mysql_query($sqlNbFile);
                        $nbFile = mysql_num_rows($sqlNbFileExecute);

                        if ($nbFile > 0) {                            
                            $nbFileView = '<small class="nkValignTop">('.$nbFile.')</small>';                
                        }else{
                            $nbFileView = '<small class="nkValignTop">(0)</small>';
                        }

                        if($catId == $cat || !isset($cat)){
                            if(!is_null($subCatId) AND !is_null($subCatTitle)){
                                $subId = explode('|', $subCatId);
                                $subTitle = explode('|', $subCatTitle);
                                $mergeSubCat = array_combine($subId, $subTitle);
                                
                                $sqlViewCat .= '<ul class="nkAlignCenter">';
                                foreach ($mergeSubCat as $keyId => $valueTitle) {
                                    
                                    $sqlSubCatDesc = mysql_query('SELECT shortDescription FROM '.DOWNLOADS_CAT_TABLE.' WHERE cid = "'.$keyId.'"');
                                    list($subCatDesc) = mysql_fetch_array($sqlSubCatDesc);
                                    
                                    $sqlnbFileSubCat = mysql_query('SELECT type FROM '.DOWNLOADS_TABLE.' WHERE type = "'.$keyId.'"');
                                    $nbFileSub = mysql_num_rows($sqlnbFileSubCat);
                                    if ($nbFileSub > 0) {                            
                                        $nbFileSubView = '<small>&nbsp;('.$nbFileSub.')</small>';                
                                    }else{
                                        $nbFileSubView = '<small>&nbsp;(0)</small>';
                                    }

                                    $sqlViewCat .= '<li class="nkPersonalCat nkInlineBlock nkWidthTier nkMarginBottom nkValignTop nkPadding nkMarginLeft nkMarginRight"><a href="index.php?file='.$modName.'&amp;cat='.$keyId.'">'.$valueTitle.'</a>'.$nbFileSubView;
                                    $sqlViewCat .= '<div class="nkAlignLeft nkMarginLRAuto nkWidthHalf">'.$subCatDesc.'</div></li>';
                                }
                                $sqlViewCat .= '</ul>';
                            }
                        }
                    }
                    $sqlViewCat .= '</nav>';
                }
            }
        }

        /* Recupération de la catégorie et sous catégorie pour le breadcrumb */
        if($cat != 0){
            $sqlBread = 'SELECT cat.cid, cat.titre AS Cat, subcat.cid AS subId,subcat.titre AS subCat
                FROM '.DOWNLOADS_CAT_TABLE.' AS cat
                LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS subcat ON subcat.cid = cat.parentid
                WHERE cat.cid = '.$cat;
            $sqlBreadExecute = mysql_query($sqlBread);
            list($idCat, $nameCat, $parentId, $parentName) = mysql_fetch_array($sqlBreadExecute);

            if(!is_null($parentName) || !is_null($parentId)){
                $newbreadCrumbArray = array(
                    'index.php?file='.$modName.'&amp;cat='.$parentId => $parentName,
                    'index.php?file='.$modName.'&amp;cat='.$idCat => $nameCat
                );
                $breadCrumbArray = array_merge($breadCrumbArray, $newbreadCrumbArray);
            }else{
                $newbreadCrumbArray = array(
                    'index.php?file='.$modName.'&amp;cat='.$idCat => $nameCat
                );
                $breadCrumbArray = array_merge($breadCrumbArray, $newbreadCrumbArray);
            }
        }
        // Affichage du breadcrumb
        $breadCrumbView = $GLOBALS['nkFunctions']->nkBreadCrumb($breadCrumbArray, $breadCrumbTheme, null, null, null);

        // Affichage du menu centrale
        if($cat == 0){
            $menuAffView =  $GLOBALS['nkFunctions']->nkMenu($modName, $arrayMenu, $orderSelect, 'nkAlignCenter', null, 'nkInline', 'active', '[', ']', '|');
        }
        /* Requete d'affichage des fichiers selon la catégorie */
        $requestFile = 'SELECT D.id, D.titre, D.description, D.taille, D.type, D.count, D.date, D.url, D.screen, D.level, D.edit, D.autor, D.url_autor, D.comp, C.titre, avg( V.vote ) AS note
            FROM '.DOWNLOADS_TABLE.' AS D
            LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS C ON C.cid = D.type
            LEFT JOIN '.VOTE_TABLE.' AS V ON D.id = V.vid
            AND V.module = \''.$modName.'\'
            '.$whereFileCat.' 
            GROUP BY D.id '.$order;
        $sqlFileExecute = mysql_query($requestFile);
        $nbPage = mysql_num_rows($sqlFileExecute);
        /* Requete pour les pages */
        if($nbPage > 0){
            $seek = mysql_data_seek($sqlFileExecute, $start);
        }
        ?>
        <section class="nkWidthFull nkMarginLRAuto nkPersonalCssFor<?php echo $modName; ?>">
            <header>
                <?php
                /* Affichage du breadCrumb */
                echo $breadCrumbView;
                ?>
                <h1 class="nkMarginTop15 nkAlignCenter"><?php echo DOWNLOAD; ?></h1>
                <?php

                echo'<div class="nkAlignCenter nkAlignLeft nkMarginLRAuto nkWidthHalf">'.$catDesc.'</div>';
                // Affichage du menu
                echo $menuAffView;

                /* Affichage des catérogies */
                if ($nbCat > 0) {
                ?>
                    <?php
                    /* Affichage du menu des catégories */
                    echo $sqlViewCat;

                    /* Affichage de la fonction Page */
                    if ($_REQUEST['orderby']) {
                        if ($nbPage > $fileMaxDownload) {
                        ?>
                            <div class="nkInlineBlock nkWidthFully nkAlignLeft nkMarginBottom">
                                <!-- Naviguation des pages -->
                                <nav id="globalPageNumber" class="nkInline">
                                    <?php
                                    if($cat){
                                        $setCat = '&amp;cat='.$cat;
                                    }
                                    if($_REQUEST['orderby']){
                                        $setOrderBy = '&amp;orderby='.$_REQUEST['orderby'];
                                    }
                                    if($_REQUEST['orderbycat']){
                                        $setOrderByCat = '&amp;orderbycat='.$_REQUEST['orderbycat'];
                                    }
                                    $urlPage = 'index.php?file='.$modName.$setCat.$setOrderBy.$setOrderByCat;
                                    number($nbPage, $fileMaxDownload, $urlPage);
                                    ?>
                                </nav>
                            </div> 
                        <?php
                        }
                    } else {
                        /* Affichage de la fonction Page */
                        if ($nbPage > $fileMaxDownload) {
                        ?>
                            <div class="nkInlineBlock nkWidthHalf nkAlignLeft nkMarginLeft">
                                <!-- Naviguation des pages -->
                                <nav id="globalPageNumber" class="nkInline">
                                    <?php
                                    if($cat){
                                        $setCat = '&amp;cat='.$cat;
                                    }
                                    if($_REQUEST['orderby']){
                                        $setOrderBy = '&amp;orderby='.$_REQUEST['orderby'];
                                    }
                                    if($_REQUEST['orderbycat']){
                                        $setOrderByCat = '&amp;orderbycat='.$_REQUEST['orderbycat'];
                                    }
                                    $urlPage = 'index.php?file='.$modName.$setCat.$setOrderBy.$setOrderByCat;
                                    number($nbPage, $fileMaxDownload, $urlPage);
                                    ?>
                                </nav>
                            </div>
                            <div class="nkInlineBlock nkWidthHalf nkAlignRight">
                            <?php
                                echo $GLOBALS['nkFunctions']->nkMenu($modName, $orderByArray, $orderCatSelect, ' nkAlignRight nkMarginTop nkMarginBottom', null, 'nkInline', 'active', null, null, '|', ORDERBY.'&nbsp;:');
                            ?>  
                            </div>
                        <?php
                        }else{
                        ?>
                            <div class="nkInlineBlock nkWidthFully nkAlignRight">
                            <?php
                                echo $GLOBALS['nkFunctions']->nkMenu($modName, $orderByArray, $orderCatSelect, ' nkAlignRight nkMarginTop nkMarginBottom', null, 'nkInline', 'active', null, null, '|', ORDERBY.'&nbsp;:');
                            ?>
                            </div>
                        <?php
                        }
                    }      
                }else{
                    if ($nbPage > $fileMaxDownload) {
                        ?>
                        <div class="nkInlineBlock nkWidthFully nkAlignLeft nkMarginBottom">
                            <!-- Naviguation des pages -->
                            <nav id="globalPageNumber" class="nkInline">
                                <?php
                                if($cat){
                                    $setCat = '&amp;cat='.$cat;
                                }
                                if($_REQUEST['orderby']){
                                    $setOrderBy = '&amp;orderby='.$_REQUEST['orderby'];
                                }
                                if($_REQUEST['orderbycat']){
                                    $setOrderByCat = '&amp;orderbycat='.$_REQUEST['orderbycat'];
                                }
                                $urlPage = 'index.php?file='.$modName.$setCat.$setOrderBy.$setOrderByCat;
                                number($nbPage, $fileMaxDownload, $urlPage);
                                ?>
                            </nav>
                        </div> 
                    <?php
                    }
                }
                ?>
            </header>
            <article>
                <?php
                /* Affichage du contenu des fichiers */
                for ($i = 0;$i < $fileMaxDownload;$i++) {
                    if (list($fileId, $fileTitre, $fileDescription, $fileSize, $fileCat, $fileCount, $fileDate, $fileUrl, $fileScreen, $fileLevel, $fileEdit, $fileAutor, $fileUrlAutor, $fileCompatibility, $fileCatTitle, $fileNote) = mysql_fetch_array($sqlFileExecute)) {
                        $newsdate = time() - $fileNewTime;
                        $isNewHot = '';

                        /* A ADAPTER AVEC LE FUNCTION VOTE */
                        $fileNote = round($fileNote, 2);
                        $fileNote = $fileNote.'&nbsp;/&nbsp;10';

                        /* Condition pour fichier NEW */
                        if($fileDate != '' && $fileDate > $newsdate){
                            $isNewHot = '<span class="nkInline">'.ISNEW.'</span>';
                        }

                        /* Condition pour fichier HOT */
                        $sqlhot = mysql_query('SELECT id FROM '.DOWNLOADS_TABLE.' ORDER BY count DESC LIMIT '.$nbFileHot);
                        mysql_data_seek($sqlhot, 0);
                        while (list($idHot) = mysql_fetch_array($sqlhot)) {
                            if ($fileId == $idHot && $nbFile > 1 && $fileCount > $nbFileHot) $isNewHot .= '<span class="nkInline">'.ISHOT.'</span>';
                        }

                        /* Affichage de l'image correspondant a l'extension du fichier */
                        $fileExtension = strrchr($fileUrl, '.');
                        $fileExtension = substr($fileExtension, 1);
                        if ($fileExtension == "zip") {
                            $fileExtensionClass = '<span class="nkIconZip"></span>';
                        } else if ($fileExtension == "rar") {
                            $fileExtensionClass = '<span class="nkIconZip"></span>';
                        } else if ($fileExtension == "jpg" || $fileExtension == "jpeg") {
                            $fileExtensionClass = '<span class="nkIconJpg"></span>';
                        }else if ($fileExtension == "png") {
                            $fileExtensionClass = '<span class="nkIconPng"></span>';
                        }else if ($fileExtension == "gif") {
                            $fileExtensionClass = '<span class="nkIconGif"></span>';
                        }else if ($fileExtension == "bmp") {
                            $fileExtensionClass = '<span class="nkIconBmp"></span>';
                        }else{
                            $fileExtensionClass = '<span class="nkIconNone"></span>';
                        }

                        /* Afficahge d'un message si la catégorie est vide */
                        if(is_null($fileCatTitle)){
                            $fileCatTitle = NONECAT;
                        }else{
                            $fileCatTitle = $fileCatTitle;
                        }

                        /* Affichage d'un message si la description est vide */
                        if (empty($fileDescription)) {
                            $fileText = '<p class="nkMargin">'.NOTKNOW.'</p>';
                        } else {
                            $fileDescriptions = htmlentities($fileDescription);
                            $fileText =  html_entity_decode($fileDescriptions);
                            $fileText = icon($fileText);
                        }

                        /* Affichage de la taille du fichier si calculable */
                        if ($fileSize != '' && $fileSize < 1000) {
                            $fileSize = $fileSize.'&nbsp;'.KO;
                        } else if ($fileSize != '' && $fileSize >= 1000) {
                            $fileSize = $fileSize / 1000;
                            $fileSize = $fileSize.'&nbsp;'.MO;
                        } else {
                            $fileSize = NOTKNOW;
                        }

                        /* Message d'erreur si compatibilité non précisé */
                        if(empty($fileCompatibility)) {
                            $fileCompatibility = NOTKNOW;
                        }

                        /* Message d'erreur si site de l'auteur inconnu sinon lien vers celui-ci */
                        if(empty($fileUrlAutor)){
                                $fileUrlAutor = NOTKNOW;
                        }else{
                                $fileUrlAutor = '<a href="'.$fileUrlAutor.'" target="_blank">'.VISITAUTORWEBSITE.'</a>';
                        }

                        /* Message d'erreur si auteur non précisé sinon affichage de son pseudo */
                        if(empty($fileAutor)){
                                $fileAutor = NOTKNOW;
                        }else{
                                $fileAutor = $fileAutor;
                        }
                        
                        /* Affiche le nombre de commentaires */
                        $sqlComDl = mysql_query('SELECT id FROM '.COMMENT_TABLE.' WHERE im_id = '.$fileId);
                        $fileNbComment = mysql_num_rows($sqlComDl);

                        if($fileNbComment == 0){
                            $fileNbComments = NOCOMMENTDB;
                        }else{
                            $fileNbComments = $fileNbComment;
                        }

                        /* Affichage d'un message si catégorie null */
                        if($catTitle == '') $catTitle = NONE;
                        
                        /* Affichage de l'image si existante sinon affichage image de substitution */
                        if ($fileScreen != '') {
                            $box = '<a href="'.checkimg($fileScreen).'" rel="shadowbox"><img  src="'.checkimg($fileScreen).'" title="'.$fileTitre.'" alt="" /></a>';
                        } else {
                            $box = '<img src="'.checkimg('images/noimage.png').'" title="'.$fileTitre.'" alt="" />';
                        }


                        /* Récupération de l'extention */
                        if ($fileExtension != '' && !preg_match('`\?`i', $fileUrl) && !preg_match('`.html`i', $fileUrl) && !preg_match('`.htm`i', $fileUrl)) $fileExtension = $fileExtension;

                        $fileName = strrchr($fileUrl, '/');
                        $fileName = substr($fileName, 1);
                        if ($fileName != '' && !preg_match('`\?`i', $fileUrl) && !preg_match('`.html`i', $fileUrl) && !preg_match('`.htm`i', $fileUrl)) $filename = $fileName;

                        ?>
           
                        <!-- Section interne du module -->
                        <section class="nkMarginBottom15 nkPaddingBottom">
                            <a name="<?php echo $fileId; ?>"></a>
                            <!-- Header de la section interne du module -->
                            <header>
                                <div class="nkInlineBlock">
                                    <figure class="nkInline nkMarginLeft"> <?php echo $fileExtensionClass; ?></figure>
                                    <h4 class="nkInline"><?php echo $fileTitre; ?></h4>
                                    <?php echo $isNewHot; ?>
                                </div>
                                <div class="nkInlineBlock">
                                    <?php
                                        /* A COMPLETER QUAND LA LIBRAIRIE VOTE SERA FAITE */
                                       // rating($modName, $fileId);
                                    ?>
                                </div>
                            </header>
                            <!-- Article de la section interne du module -->
                            <article class="nkBlock nkPadding">
                                <div class="nkInlineBlock nkWidth3Quarter">
                                    <h2 class="nkSize16 nkAlignCenter">
                                        <?php echo INFO; ?>
                                    </h2>
                                    <div class="nkWidthHalf nkInlineBlock">
                                        <ul class="nkInlineBlock nkValignTop">
                                            <li><span class="nkIconFolder"></span><?php echo CAT; ?>&nbsp;:&nbsp;<small><?php echo $fileCatTitle; ?></small></li>
                                            <li><span class="nkIconDate"></span><?php echo ADDTHE; ?>&nbsp;:&nbsp;<small><?php echo nkDate($fileDate); ?></small></li>

                                        <?php
                                        /* Affichage d'un message si pas d'édition */
                                        if($fileEdit) {
                                        ?>
                                            <li><span class="nkIconDateUpdate"></span><?php echo EDITTHE; ?>&nbsp;:&nbsp;<small><?php echo nkDate($fileEdit); ?></small></li>
                                        <?php
                                        }else{
                                        ?>
                                            <li><span class="nkIconDateUpdate"></span><?php echo EDITTHE; ?>&nbsp;:&nbsp;<small><?php echo NOTKNOW; ?></small></li>
                                        <?php
                                        }
                                        ?>
                                            <li><span class="nkIconInfo"></span><?php echo SIZE; ?>&nbsp;:&nbsp;<small><?php echo $fileSize; ?></small></span></li>
                                            <li><span class="nkIconRefresh"></span><?php echo COMPATIBLE; ?>&nbsp;:&nbsp;<small><?php echo $fileCompatibility; ?></small></li>
                                        </ul>
                                    </div>
                                    <div class="nkWidthHalf nkInlineBlock">
                                        <ul class="nkInlineBlock nkValignTop">
                                            <li><span class="nkIconAutor"></span><?php echo AUTOR; ?>&nbsp;:&nbsp;<small><?php echo $fileAutor; ?></small></li>
                                            <li><span class="nkIconGlobe"></span><?php echo SITE; ?>&nbsp;:&nbsp;<small><?php echo $fileUrlAutor; ?></small></li>
                                            <li><?php echo $fileExtensionClass; ?><?php echo EXT; ?>&nbsp;:&nbsp;<small><?php echo $fileExtension; ?></small></li>
                                            <li><span class="nkIconComments"></span><?php echo FILEVOTE; ?>&nbsp;:&nbsp;<small><?php echo $fileNote; ?></small></li>
                                            <li><span class="nkIconDownload"></span><?php echo DOWNLOADED; ?>:&nbsp;<small><?php echo $fileCount.'&nbsp;'.TIMES; ?></small></li>
                                        </ul>
                                    </div>
                                    <?php
                                    /* Affichage de la description si defini par l'admin */
                                    if ($hide_donwload == "off") {
                                    ?> 
                                        <h3>
                                            <?php echo DESCR; ?>
                                        </h3>
                                        <div class="nkMarginBottom">
                                            <?php echo $fileText; ?>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <!-- Parti deporté pour le module commentaire -->
                                <aside class="nkInlineBlock nkMarginTop15 nkValignTop nkWidthQuarter nkAlignCenter">
                                    <figure><?php echo $box; ?></figure>
                                        <?php 
                                            /* Affichage des commentaires du fichier */
                                            viewComment($modName, $fileId, $fileNbComment, $fileNbComment_cut);
                                        ?>
                                </aside>
                            </article>
                            <!-- Footer de la section interne du module -->
                            <footer class="nkAlignCenter nkMargin nkWidth3Quarter">
                                <?php
                                    /* Affichage du bouton télécharger si le visiteur a le niveau */
                                    if($visiteur >= $fileLevel){
                                ?>
                                        <a href="index.php?file=<?php echo $modName; ?>&amp;op=doDownload&amp;nuked_nude=index&amp;idDownload=<?php echo $fileId; ?>" title="<?php echo DOWNLOAD.' '.$fileTitre; ?>" class="nkButton"><?php echo DOWNLOAD; ?></a>
                                <?php
                                    /* Affichage du bouton d'identification */
                                    }else if($visiteur == 0){
                                ?>
                                        <a href="index.php?file=User&amp;nuked_nude=index&amp;op=login_screen" title="" class="nkPopupBox nkButton"><?php echo NEEDLOGIN; ?></a>
                                <?php
                                    /* Affichage du bouton si le visiteur n'a pas le niveau */
                                    }else if($visiteur < $fileLevel && $visiteur != 0){                                            
                                ?>
                                        <!-- A MODIFIER AVEC LA LIBRAIRIE USER REQUEST -->
                                        <a href="" title="" class="nkButton"><?php echo NEEDLEVEL; ?></a>
                                <?php
                                    }
                                ?>
                            </footer>
                        </section>
                    <?php
                    }
                }
                ?>
            </article>
        </section>

    <?php
        }
    }

    function verifDownload($url1, $url2, $url3){
        global $nuked;

        
        $urlVerify1 = $GLOBALS['nkFunctions']->nkVerifyUrl($url1);
        $urlVerify2 = $GLOBALS['nkFunctions']->nkVerifyUrl($url2);
        $urlVerify3 = $GLOBALS['nkFunctions']->nkVerifyUrl($url3);

        $headers    = @get_headers($urlVerify1);
        $headers2   = @get_headers($urlVerify2);
        $headers3   = @get_headers($urlVerify3);

        if(strpos($headers[0],'200') !== false) {
            $linkUrlVerify = $urlVerify1;
        }else if(strpos($headers2[0],'200') !== false) {
            $linkUrlVerify = $urlVerify2;
        }else if(strpos($headers3[0],'200') !== false) {
            $linkUrlVerify = $urlVerify3;
        }else{
            $linkUrlVerify = null;
        }
        
        return $linkUrlVerify;
       
    }


    function doDownload($idDownload) {
        global $nuked, $visiteur, $modName;

        $sql = mysql_query('SELECT url, url2, url3, count, level FROM '.DOWNLOADS_TABLE.' WHERE id = "'.$idDownload.'"');        
        list($urlDownload, $urlDownload2, $urlDownload3, $count, $level) = mysql_fetch_array($sql);

        if(mysql_num_rows($sql) <= 0) {
            redirect('index.php?file='.$modName.'&op=errorDownload&idDownload='.$idDownload, 0);
            die;
        }
        
        $url = verifDownload($urlDownload, $urlDownload2, $urlDownload3);

        if (!is_null($url)) {
            if ($visiteur >= $level) {
                $new_count = $count + 1;
                $upd = mysql_query('UPDATE '.DOWNLOADS_TABLE.' SET count = "'.$new_count.'" WHERE id = "'.$idDownload.'"');

                header("location: " . $url);
            } else {
                $GLOBALS['nkFunctions']->nkBadLevel();
                redirect($_SERVER['HTTP_REFERER'], 2);
            }            
        }else {
            errorDownload($idDownload, 'no', $_SERVER['HTTP_REFERER']);
        }     
    }

    function errorDownload($idDownload, $url, $referer) {
        global $language;

        if($url == 'no') {
            $sql = mysql_query('UPDATE '.DOWNLOADS_TABLE.' SET broke = broke + 1 WHERE id = "'.$idDownload.'"');

            echo $GLOBALS['nkTpl']->nkDisplayError(DOWNLOADURLERROR.'<br/>'.BROKENLINKREPORT);
            redirect($referer, 2);

        }else {
            echo $GLOBALS['nkTpl']->nkDisplayError(DOWNLOADIDERROR);
        }
    }



    switch ($_REQUEST['op']) {

        case "doDownload":
            doDownload($_REQUEST['idDownload']);
            break;

        case "errorDownload":
            errorDownload($_REQUEST['idDownload'], $_REQUEST['url']);
            break;

        case "viewComment":
            viewComment($_REQUEST['module'], $_REQUEST['idItem']);
            break;

        case "post_com":
            post_com($_REQUEST['module'], $_REQUEST['idItem']);
            break;

        case "sendRating":
            sendRating();
            break;
            
        case "post_comment":
            post_comment($_REQUEST['module'], $_REQUEST['idItem'], $_REQUEST['title'], $_REQUEST['text'], $_REQUEST['nick']);
            break;

        default:
            index($_REQUEST['cat']);
            break;
    }

} else if ($level_access == -1) {

    echo $GLOBALS['nkTpl']->nkModuleOff();

} else if ($level_access == 1 && $visiteur == 0) {

    echo $GLOBALS['nkTpl']->nkNoLogged('|');

} else {

    echo $GLOBALS['nkTpl']->nkBadLevel();

}
    
?>