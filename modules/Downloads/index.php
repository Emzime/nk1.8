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
$modName = basename(dirname(__FILE__));

global $language, $user, $nuked;

$level_access = nivo_mod($modName);
translate('modules/'.$modName.'/lang/'.$language.'.lang.php');

if ($user) {
    $visiteur = $user['1'];
} else {
    $visiteur = 0;
}

if ($visiteur >= $level_access && $level_access > -1) {
    compteur($modName);

    // Vérification des variables
    $requestArray = array(
            'cat',
            'requestedId',
            'orderby',
            'url',
            'p',
            'orderbycat'
        );
    $GLOBALS['nkFunctions']->nkInitRequest($requestArray);

    $arrayMenu = array(
        'index.php?file='.$modName                          =>  INDEX,
        'index.php?file='.$modName.'&amp;orderby=newse'     =>  NEWSFILE,
        'index.php?file='.$modName.'&amp;orderby=count'     =>  POPULAR,
        'index.php?file=Suggest&amp;module='.$modName       =>  SUGGESTFILE
    );

    $breadCrumbArray = array(
        'index.php'                 => HOME,
        'index.php?file='.$modName  => DOWNLOAD
    );

    if (isset($_REQUEST['cat'])) {
        $orderByArray = array(
            'index.php?file='.$modName.'&amp;cat='.$_REQUEST['cat'].'&amp;orderbycat=news'     => DATE,
            'index.php?file='.$modName.'&amp;cat='.$_REQUEST['cat'].'&amp;orderbycat=count'    => TOPFILE,
            'index.php?file='.$modName.'&amp;cat='.$_REQUEST['cat'].'&amp;orderbycat=name'     => NAME,
            'index.php?file='.$modName.'&amp;cat='.$_REQUEST['cat'].'&amp;orderbycat=note'     => NOTE
        );
    } else {
        $orderByArray = array(
            'index.php?file='.$modName.'&amp;orderbycat=news'     => DATE,
            'index.php?file='.$modName.'&amp;orderbycat=count'    => TOPFILE,
            'index.php?file='.$modName.'&amp;orderbycat=name'     => NAME,
            'index.php?file='.$modName.'&amp;orderbycat=note'     => NOTE
        );
    }

    function index($cat, $requestedId, $orderby, $orderbycat) {
        global $nuked, $arrayMenu, $breadCrumbArray, $orderByArray, $modName, $visiteur;

        $modulePref = $GLOBALS['nkFunctions']->nkModsPrefs($modName);
/*
        $hideDescription  = $modulePref['hideDescription'];  // affichage ou non de la description des téléchargements
        $fileMaxDownload  = $modulePref['fileMaxDownload'];  // nombre de fichier par page
        $fileNbSubcat     = $modulePref['fileNbSubcat'];     // nombre de sous cat a afficher
        $breadCrumbTheme  = $modulePref['breadCrumbTheme'];  // theme choisi pour le breadcrumb
        $fileNewTime      = $modulePref['fileNewTime'];      // temps pour qu'un fichier reste en NEW
        $nbFileNew        = $modulePref['nbFileNew'];        // Nombre de fichier pour le classement des fichiers New
        $nbFileHot        = $modulePref['nbFileHot'];        // nombre de telechargement pour qu'un fichier soit HOT
        $fileNbComment    = $modulePref['fileNbComment'];    // nombre de commentaire a afficher
        $fileNbCommentCut = $modulePref['fileNbCommentCut']; // nombre de lettres pour le découpe des mots
*/
        // Requete pour statistique en bas de page
        $dbsFile = 'SELECT count( id ), 
                        (
                            SELECT count( cid )
                            FROM '.DOWNLOADS_CAT_TABLE.'
                            WHERE parentid !=0
                        ) AS subcat, 
                        (
                            SELECT count( cid )
                            FROM '.DOWNLOADS_CAT_TABLE.'
                            WHERE parentid =0
                        ) AS cat
                    FROM '.DOWNLOADS_TABLE;
        $dbeFile = mysql_query($dbsFile);
        list($statFile, $statSubCat, $statCat) = mysql_fetch_array($dbeFile);

        // Affichage si clic sur les blocks 
        if ($requestedId) {

            $dbsRequestFile = ' SELECT D.titre, D.description, D.taille, D.type, D.count, D.date, D.url, D.screen, D.level, D.edit, D.autor, D.url_autor, D.comp, C.titre, avg( V.vote ) AS note
                                FROM '.DOWNLOADS_TABLE.' AS D
                                LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS C ON C.cid = D.type
                                LEFT JOIN '.VOTE_TABLE.' AS V ON D.id = V.vid AND V.module = \''.$modName.'\'
                                WHERE D.id = '.$requestedId;
            $dbeRequestFile = mysql_query($dbsRequestFile);
            list($fileTitle, $fileDescription, $fileSize, $fileType, $fileCount, $fileDate, $fileUrl, $fileScreen, $fileLevel, $fileEdit, $fileAutor, $fileUrlAutor, $fileCompatibility, $fileCatTitle, $fileNote) = mysql_fetch_array($dbeRequestFile);
            
            // Affiche le nombre de commentaires 
            $dbsComDl = 'SELECT id 
                         FROM '.COMMENT_TABLE.' 
                         WHERE im_id = '.$requestedId;
            $dbeComDl = mysql_query($dbsComDl);
            $dbcFileNbComment = mysql_num_rows($dbeComDl);

            // A ADAPTER AVEC LE FUNCTION VOTE 
            $fileNote = round($fileNote, 2);
            $fileNote = $fileNote.'&nbsp;/&nbsp;10';

            // Affichage de l'image correspondant a l'extension du fichier 
            $fileExtension = strrchr($fileUrl, '.');
            $fileExtension = substr($fileExtension, 1);
            if ($fileExtension == "zip") {
                $fileExtensionClass = 'nkIconZip';
            } elseif ($fileExtension == "rar") {
                $fileExtensionClass = 'nkIconZip';
            } elseif ($fileExtension == "jpg" || $fileExtension == "jpeg") {
                $fileExtensionClass = 'nkIconJpg';
            } elseif ($fileExtension == "png") {
                $fileExtensionClass = 'nkIconPng';
            } elseif ($fileExtension == "gif") {
                $fileExtensionClass = 'nkIconGif';
            } elseif ($fileExtension == "bmp") {
                $fileExtensionClass = 'nkIconBmp';
            } else {
                $fileExtensionClass = 'nkIconNone';
            }

            // Affichage de la description si option defini par l'administrateur 
            if ($modulePref['hideDescription'] == "off") {

                // Affichage d'un message si la description est vide 
                if (empty($fileDescription)) {
                    $fileTexte = '<p class="nkMargin">'.NOTKNOW.'</p>';
                } else {
                    $fileDescriptions = htmlentities($fileDescription);
                    $fileTexte = html_entity_decode($fileDescriptions);
                    $fileTexte = icon($fileTexte);
                }
                $fileDescriptionView = '    <h3>'.DESCR.'</h3>'
                                        . ' <div class="nkMarginBottom">'
                                        .       $fileTexte 
                                        . ' </div>';
            }       

            // Affichage de la taille du fichier si calculable 
            if ($fileSize != '' && $fileSize < 1000) {
                $fileSize = $fileSize.'&nbsp;'.KO;
            } elseif ($fileSize != '' && $fileSize >= 1000) {
                $fileSize = $fileSize / 1000;
                $fileSize = $fileSize.'&nbsp;'.MO;
            } else {
                $fileSize = NOTKNOW;
            }

            // Message d'erreur si compatibilité non précisé 
            if (empty($fileCompatibility)) {
                $fileCompatibility = NOTKNOW;
            }

            // Message d'erreur si site de l'auteur inconnu sinon lien vers celui-ci 
            if (empty($fileUrlAutor)) {
                $fileUrlAutor = NOTKNOW;
            } else {
                $fileUrlAutor = '<a href="'.$fileUrlAutor.'" target="_blank">'.VISITAUTORWEBSITE.'</a>';
            }

            // Message d'erreur si auteur non précisé sinon affichage de son pseudo 
            if (empty($fileAutor)) {
                $fileAutor = NOTKNOW;
            } else {
                $fileAutor = $fileAutor;
            }

            // Affichage d'un message si catégorie null 
            if ($fileCatTitle == '') {
                $fileCatTitle = NONECAT;
            }

            // Affichage d'un message si pas d'édition 
            if ($fileEdit) {
                $fileEdit = nkDate($fileEdit); 
            } else {
                $fileEdit = NOTKNOW;
            }

            // Affichage de l'image si existante sinon affichage image de substitution 
            if ($fileScreen != '') {
                $box = '<a href="'.checkimg($fileScreen).'" class="nkPopupBox"><img src="'.checkimg($fileScreen).'" title="'.$fileTitle.'" alt="" /></a>';
            } else {
                $box = '<img src="'.checkimg('images/noimage.png').'" title="'.$fileTitle.'" alt="" />';
            }

            // Récupération de l'extention 
            if ($fileExtension != '' && !preg_match('`\?`i', $fileUrl) && !preg_match('`.html`i', $fileUrl) && !preg_match('`.htm`i', $fileUrl)) {
                $fileExtension = $fileExtension;
            } 

            // Condition d'affichage du bouton de téléchargement
            if ($visiteur >= $fileLevel) {
                // Affichage du bouton télécharger si le visiteur a le niveau 
                $filesButtonView = '<a href="index.php?file='.$modName.'>&amp;op=doDownload&amp;nuked_nude=index&amp;requestedId='.$requestedId.'" title="'.DOWNLOAD.' '.$fileTitle.'" class="nkButton">'.DOWNLOAD.'</a>';
            } elseif ($visiteur == 0) {
                // Affichage du bouton de demande d'itentification 
                $filesButtonView = '<a href="index.php?file=User&amp;nuked_nude=index&amp;op=login_screen" title="" class="nkPopupBox nkButton">'.NEEDLOGIN.'</a>';
            } elseif ($visiteur < $level && $visiteur != 0) {   
                // Affichage du bouton si niveau requis                                           
                // A MODIFIER AVEC LA LIBRAIRIE USER REQUEST
                $filesButtonView = '<a href="" title="" class="nkButton">'.NEEDLEVEL.'</a>';
            }
            ?>

            <!-- Section interne du module -->
            <section class="nkWidthFull nkMarginLRAuto nkPersonalCssFor<?php echo $modName; ?>Desc nkPaddingBottom">
                <!-- Header de la section interne du module -->
                <header>
                    <div class="nkInlineBlock">
                        <figure class="nkInline nkMarginLeft">
                            <span class="<?php echo $fileExtensionClass; ?>"></span>
                        </figure>
                        <h4 class="nkInline"><?php echo $fileTitle; ?></h4>
                    </div>
                    <div class="nkInlineBlock">
                        <?php
                            // A COMPLETER QUAND LA LIBRAIRIE VOTE SERA FAITE 
                            // rating($modName, $requestedId);
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
                                <li><span class="nkIconDateUpdate"></span><?php echo EDITTHE; ?>&nbsp;:&nbsp;<small><?php echo $fileEdit; ?></small></li>
                                <li><span class="nkIconInfo"></span><?php echo SIZE; ?>&nbsp;:&nbsp;<small><?php echo $fileSize; ?></small></li>
                                <li><span class="nkIconRefresh"></span><?php echo COMPATIBLE; ?>&nbsp;:&nbsp;<small><?php echo $fileCompatibility; ?></small></li>
                            </ul>
                        </div>
                        <div class="nkWidthHalf nkInlineBlock">
                            <ul class="nkInlineBlock nkValignTop">
                                <li><span class="nkIconAutor"></span><?php echo AUTOR; ?>&nbsp;:&nbsp;<small><?php echo $fileAutor; ?></small></li>
                                <li><span class="nkIconGlobe"></span><?php echo SITE; ?>&nbsp;:&nbsp;<small><?php echo $fileUrlAutor; ?></small></li>
                                <li><span class="<?php echo $fileExtensionClass; ?>"></span><?php echo EXT; ?>&nbsp;:&nbsp;<small><?php echo $fileExtension; ?></small></li>
                                <li><span class="nkIconComments"></span><?php echo FILEVOTE; ?>&nbsp;:&nbsp;<small><?php echo $fileNote; ?></small></li>
                                <li><span class="nkIconDownload"></span><?php echo DOWNLOADED; ?>:&nbsp;<small><?php echo $fileCount.'&nbsp;'.TIMES; ?></small></li>
                            </ul>
                        </div>
                        <?php
                        if ($modulePref['hideDescription'] == "off") {
                            echo $fileDescriptionView;
                        }
                        ?>
                    </div>
                    <!-- Parti deporté pour le module commentaire -->
                    <aside class="nkInlineBlock nkMarginTop15 nkValignTop nkWidthQuarter nkAlignCenter">
                        <figure><?php echo $box; ?></figure>
                            <?php 
                                viewComment($modName, $requestedId, $modulePref['fileNbComment'], $modulePref['fileNbCommentCut']);
                            ?>
                    </aside>
                </article>
                <!-- Footer de la section interne du module -->
                <footer class="nkAlignCenter nkMargin nkWidth3Quarter">
                    <?php
                    echo $filesButtonView;
                    ?>
                </footer>
            </section>
        <?php
        // Affichage de l'index du module 
        } else {
            // Definition de la page de demarrage de la fonction page 
            if (!$_REQUEST['p']) {
                $_REQUEST['p'] = 1;
            }
            $pageStart = $_REQUEST['p'] * $modulePref['fileMaxDownload'] - $modulePref['fileMaxDownload'];

            // Requete pour les fichiers 
            if ($cat) {
                $whereFileCat = 'WHERE type="'.$cat.'"';
                $whereCat = 'WHERE cid="'.$cat.'"';
            } elseif ($orderby) {
                $whereFileCat = '';            
            } else {
                $whereFileCat = 'WHERE type=0';
                $whereCat = 'WHERE cid=0';
                $cat = 0;
            }

            // Requete sur orderbycat 
            if ($orderbycat == 'name') {
                $order = 'ORDER BY D.titre';
                $orderCatSelect = NAME;  
            } elseif ($orderbycat == 'count') {
                $order = 'ORDER BY D.count DESC';
                $orderCatSelect = TOPFILE; 
            } elseif ($orderbycat == 'note') {
                $order = 'ORDER BY note DESC';  
                $orderCatSelect = NOTE;  
            } elseif (!$orderbycat || $orderbycat == 'news') {
                $order = 'ORDER BY D.date DESC';
                $orderCatSelect = DATE;
            }

            // Requete sur orderby 
            if ($orderby == 'count') {
                $order = 'ORDER BY D.count DESC'; 
                $orderSelect = POPULAR;  
            } elseif ($orderby == 'newse') {
                $order = 'ORDER BY D.date DESC LIMIT '.$modulePref['nbFileNew'];   
                $orderSelect = NEWSFILE;  
            } elseif (!$orderby) {
                $orderSelect = INDEX;  
            }

            // Affichage si orderby n'est pas present dans le lien 
            if (!$orderby) {
                // Requete pour la nav des catégories 
                $sqlCat = ' SELECT a.cid, a.titre AS Cat, a.shortDescription,                
                            GROUP_CONCAT(b.cid SEPARATOR "|") AS subCatId, 
                            GROUP_CONCAT(b.titre SEPARATOR "|") AS subCatTitle
                            FROM '.DOWNLOADS_CAT_TABLE.' AS a
                            LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS b ON a.cid = b.parentid
                            WHERE a.parentid = 0 
                            GROUP BY Cat';
                $sqlCatExecute = mysql_query($sqlCat);
                $nbCat = mysql_num_rows($sqlCatExecute);

                // Requete pour les informations de catégories 
                $sqlCatDesc = ' SELECT a.description,
                                GROUP_CONCAT(b.cid SEPARATOR "|") AS subCatId
                                FROM '.DOWNLOADS_CAT_TABLE.' AS a
                                LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS b ON a.cid = b.parentid
                                WHERE a.cid = '.$cat.'
                                GROUP BY a.cid';
                $sqlCatDescExecute = mysql_query($sqlCatDesc);
                list($catDesc, $catChildId) = mysql_fetch_array($sqlCatDescExecute);

                // Affichage de la navigation des catégories à l'index
                if ($cat == 0 && !$orderby) {                
                    $sqlViewCat = '<nav class="nkMarginTop15 nkAlignCenter nkWidthFull"><ul class="nkMarginTop nkWidthFully nkMarginLRAuto">';
                    while (list($catId, $catTitle, $catShortDescription, $subCatId, $subCatTitle) = mysql_fetch_array($sqlCatExecute)) {
                        // Comptage des fichiers pour la catégorie appelée 
                        $dbsSqlFile = ' SELECT id 
                                        FROM '.DOWNLOADS_TABLE.' 
                                        WHERE type = '.$catId;
                        $dbeSqlFile = mysql_query($dbsSqlFile);
                        $dbcNbFile  = mysql_num_rows($dbeSqlFile);

                        // Affichage du nombre de fichier dans la catégorie 
                        if ($dbcNbFile > 0) {                            
                            $nbFileView = $dbcNbFile;                
                        } else {
                            $nbFileView = 0;
                        }

                        $sqlViewCat .= '<li class="nkPersonalCat nkInlineBlock nkWidthTier nkMarginBottom nkValignTop nkPadding nkMarginLeft nkMarginRight"><a href="index.php?file='.$modName.'&amp;cat='.$catId.'">'.$catTitle.'</a>&nbsp;<small class="nkValignTop">('.$nbFileView.')</small>';
                        $sqlViewCat .= '<div class="nkAlignLeft nkMarginLRAuto">'.$catShortDescription.'</div>';

                        // Affichage si sous catégorie existante
                        if (!is_null($subCatId) AND !is_null($subCatTitle)) {
                            $subId = explode('|', $subCatId);
                            $subTitle = explode('|', $subCatTitle);
                            $mergeSubCat = array_combine($subId, $subTitle);
                            $sqlViewCat .= '<ul class="nkMarginLRAuto nkAlignCenter nkWidthFull nkValignTop">';
                            $fileNbSubcatCount = 1;
                            foreach ($mergeSubCat as $keyId => $valueTitle) {     
                         
                                $dbsSqlNbFileSubCat = ' SELECT id 
                                                        FROM '.DOWNLOADS_TABLE.' 
                                                        WHERE type = '.$keyId;
                                $dbeSqlNbFileSubCat = mysql_query($dbsSqlNbFileSubCat);
                                $dbcNbFileSub       = mysql_num_rows($dbeSqlNbFileSubCat);

                                if ($dbcNbFileSub > 0) {
                                    $nbFileSubView = $dbcNbFileSub;                
                                } else {
                                    $nbFileSubView = 0;
                                }

                                if ($fileNbSubcatCount <= $modulePref['fileNbSubcat']) {
                                    $sqlViewCat .= '<li class="nkInlineBlock nkMarginRight nkMarginLeft nkValignTop"><small><a href="index.php?file='.$modName.'&amp;cat='.$keyId.'">'.$valueTitle.'</a>&nbsp;('.$nbFileSubView.')</small></li>';
                                } elseif ($modulePref['fileNbSubcat'] != 0) {
                                    $sqlViewCat .= '<li class="nkInlineBlock nkMarginRight nkMarginLeft nkValignTop"><small><a href="index.php?file='.$modName.'&amp;cat='.$catId.'">&hellip;</a></small></li>';
                                }
                                $fileNbSubcatCount++;
                            }
                            $sqlViewCat .= '</ul>';
                        }
                        $sqlViewCat .= '</li>';
                    }
                    $sqlViewCat .= '</ul></nav>';

                // Affichage si catégorie differente de 0 et absence de orderby 
                } elseif ($cat != 0 && !$orderby) {
                    // Affichage si pas de sous catégorie dans la catégorie appelée 
                    if (!is_null($catChildId)) {
                        $sqlViewCat = '<nav class="nkMarginTop15 nkAlignCenter nkWidthFull">';
                        while (list($catId, $catTitle, $catShortDescription, $subCatId, $subCatTitle) = mysql_fetch_array($sqlCatExecute)) {
                            if ($catId == $cat || !isset($cat)) {
                                if (!is_null($subCatId) AND !is_null($subCatTitle)) {
                                    $subId = explode('|', $subCatId);
                                    $subTitle = explode('|', $subCatTitle);
                                    $mergeSubCat = array_combine($subId, $subTitle);
                                    
                                    $sqlViewCat .= '<ul class="nkAlignCenter">';
                                    foreach ($mergeSubCat as $keyId => $valueTitle) {
                                        // Selection des sous catégories + affichage du nombre de fichiers dans celle-ci
                                        $dbsSqlSubCatDesc = 'SELECT dct.shortDescription, 
                                                                (
                                                                    SELECT count( id )
                                                                    FROM '.DOWNLOADS_TABLE.'
                                                                    WHERE TYPE = dct.cid
                                                                ) AS countFile
                                                            FROM '.DOWNLOADS_CAT_TABLE.' AS dct
                                                            WHERE cid = '.$keyId;
                                        $dbeSqlSubCatDesc = mysql_query($dbsSqlSubCatDesc);
                                        list($subCatDesc, $dbcNbFileSub) = mysql_fetch_array($dbeSqlSubCatDesc);

                                        if ($dbcNbFileSub > 0) {                            
                                            $nbFileSubView = $dbcNbFileSub;                
                                        } else {
                                            $nbFileSubView = 0;
                                        }

                                        $sqlViewCat .= '<li class="nkPersonalCat nkInlineBlock nkWidthTier nkMarginBottom nkValignTop nkPadding nkMarginLeft nkMarginRight"><a href="index.php?file='.$modName.'&amp;cat='.$keyId.'">'.$valueTitle.'</a>&nbsp;<small class="nkValignTop">('.$nbFileSubView.')</small>';
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

            // Recupération de la catégorie et sous catégorie pour le breadcrumb 
            if ($cat != 0) {
                $dbsBreadCrumb = '  SELECT cat.cid, cat.titre AS Cat, subcat.cid AS subId,subcat.titre AS subCat
                                    FROM '.DOWNLOADS_CAT_TABLE.' AS cat
                                    LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS subcat ON subcat.cid = cat.parentid
                                    WHERE cat.cid = '.$cat;
                $dbeBreadCrumb = mysql_query($dbsBreadCrumb);
                list($idCat, $nameCat, $parentId, $parentName) = mysql_fetch_array($dbeBreadCrumb);

                if (!is_null($parentName) || !is_null($parentId)) {
                    $newbreadCrumbArray = array(
                            'index.php?file='.$modName.'&amp;cat='.$parentId => $parentName,
                            'index.php?file='.$modName.'&amp;cat='.$idCat => $nameCat
                        );
                    $breadCrumbArray = array_merge($breadCrumbArray, $newbreadCrumbArray);
                } else {
                    $newbreadCrumbArray = array(
                            'index.php?file='.$modName.'&amp;cat='.$idCat => $nameCat
                        );
                    $breadCrumbArray = array_merge($breadCrumbArray, $newbreadCrumbArray);
                }
            }
            // Affichage du breadcrumb
            $breadCrumbView = $GLOBALS['nkFunctions']->nkBreadCrumb($breadCrumbArray, $modulePref['breadCrumbTheme']);

            // Affichage du menu centrale
            $menuAffView = $GLOBALS['nkFunctions']->nkMenu($modName, $arrayMenu, $orderSelect, 'nkAlignCenter nkMarginBottom', null, 'nkInline', 'active', '[', ']', '|');

            //Requete d'affichage des fichiers selon la catégorie 
            $dbsRequestFile = ' SELECT D.id, D.titre, D.description, D.taille, D.type, D.count, D.date, D.url, D.screen, D.level, D.edit, D.autor, D.url_autor, D.comp, C.titre, avg( V.vote ) AS note
                                FROM '.DOWNLOADS_TABLE.' AS D
                                LEFT JOIN '.DOWNLOADS_CAT_TABLE.' AS C ON C.cid = D.type
                                LEFT JOIN '.VOTE_TABLE.' AS V ON D.id = V.vid AND V.module = \''.$modName.'\'
                                '.$whereFileCat.' 
                                GROUP BY D.id '.$order;
            $dbeRequestFile = mysql_query($dbsRequestFile);
            $dbcNbPage = mysql_num_rows($dbeRequestFile);

           // Requete pour les pages 
            if ($dbcNbPage > 0) {
                $seek = mysql_data_seek($dbeRequestFile, $pageStart);
            }

            // Affichage du lien orderby
            $linkOrderBy = $GLOBALS['nkFunctions']->nkMenu($modName, $orderByArray, $orderCatSelect, ' nkAlignRight nkMarginTop nkMarginBottom', null, 'nkInline', 'active', null, null, '|', ORDERBY.'&nbsp;:');
            ?>
            <section class="nkWidthFull nkMarginLRAuto nkPersonalCssFor<?php echo $modName; ?>">
                <header>
                    <?php
                   //Affichage du breadCrumb 
                    echo $breadCrumbView;
                    ?>
                    <h1 class="nkMarginTop15 nkAlignCenter"><?php echo DOWNLOAD; ?></h1>
                    <?php 
                    if (!$orderby) {
                    ?>
                    <div class="nkAlignCenter nkAlignLeft nkMarginLRAuto nkWidthHalf">
                        <?php
                            echo $catDesc; 
                        ?>
                    </div>
                    <?php
                    }
                    //Affichage du menu des catégories 
                    if ($cat == 0) {
                        echo $menuAffView;
                    }
                    //Affichage des catérogies 
                    if ($orderby) {
                        if ($dbcNbPage > $modulePref['fileMaxDownload']) {
                            ?>
                            <div class="nkInlineBlock nkWidthFully nkAlignLeft nkMarginBottom">
                                <nav id="globalPageNumber" class="nkInline">
                                    <?php

                                    number($dbcNbPage, $modulePref['fileMaxDownload'], 'index.php?file='.$modName.'&amp;orderby='.$orderby);

                                    ?>
                                </nav>
                            </div> 
                        <?php
                        }
                    } elseif ($nbCat > 0) {
                       //Affichage du menu des sous catégories
                        if (!is_null($catChildId) || ($cat == 0 && is_null($catChildId))) {
                            echo $sqlViewCat;
                        }

                        if ($dbcNbPage > $modulePref['fileMaxDownload']) {
                        ?>
                            <div class="nkInlineBlock nkWidthHalf nkAlignLeft nkMarginLeft">
                                <nav id="globalPageNumber" class="nkInline">
                                    <?php

                                    if ($orderbycat) {
                                        $setOrderByCat = '&amp;orderbycat='.$orderbycat;
                                    }else{
                                        $setOrderByCat = '';
                                    }

                                    number($dbcNbPage, $modulePref['fileMaxDownload'], 'index.php?file='.$modName.'&amp;cat='.$cat.$setOrderByCat);

                                    ?>
                                </nav>
                            </div>
                            <div class="nkInlineBlock nkWidthHalf nkAlignRight">
                                <?php
                                echo $linkOrderBy;
                                ?>  
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="nkInlineBlock nkWidthFully nkAlignRight">
                                <?php
                                echo $linkOrderBy;
                                ?>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </header>
                <article>
                    <?php
                    // Affichage du contenu des fichiers 
                    for ($i = 0;$i < $modulePref['fileMaxDownload'];$i++) {
                        if (list($fileId, $fileTitre, $fileDescription, $fileSize, $fileCat, $fileCount, $fileDate, $fileUrl, $fileScreen, $fileLevel, $fileEdit, $fileAutor, $fileUrlAutor, $fileCompatibility, $fileCatTitle, $fileNote) = mysql_fetch_array($dbeRequestFile)) {
                            $newsdate = time() - $modulePref['fileNewTime'];
                            $isNewHot = '';

                            // A ADAPTER AVEC LE FUNCTION VOTE 
                            $fileNote = round($fileNote, 2);
                            $fileNote = $fileNote.'&nbsp;/&nbsp;10';

                            // Condition pour fichier NEW 
                            if ($fileDate != '' && $fileDate > $newsdate) {
                                $isNewHot = '<span class="nkInline nkBold nkItalic isNew nkMarginLeft">'.ISNEW.'</span>';
                            }

                            // Condition pour fichier HOT 
                            $dbsSqlHot = '  SELECT id 
                                            FROM '.DOWNLOADS_TABLE.' 
                                            ORDER BY count DESC LIMIT '.$modulePref['nbFileHot'];
                            $dbeSqlHot = mysql_query($dbsSqlHot);
                            mysql_data_seek($dbeSqlHot, 0);
                            while (list($idHot) = mysql_fetch_array($dbeSqlHot)) {
                                if ($fileId == $idHot && $dbeSqlHot > 1 && $fileCount > $modulePref['nbFileHot']) $isNewHot .= '<span class="nkInline nkBold nkItalic isHot nkMarginLeft">'.ISHOT.'</span>';
                            }
                            
                            // Affiche le nombre de commentaires 
                            $dbsSqlComDl = 'SELECT id 
                                            FROM '.COMMENT_TABLE.' 
                                            WHERE im_id = '.$fileId;
                            $dbeSqlComDl = mysql_query($dbsSqlComDl);
                            $dbcFileNbComment = mysql_num_rows($dbeSqlComDl);

                            if ($dbcFileNbComment == 0) {
                                $dbcFileNbComments = NOCOMMENTDB;
                            } else {
                                $dbcFileNbComments = $dbcFileNbComment;
                            }

                            // Affichage de l'image correspondant a l'extension du fichier 
                            $fileExtension = strrchr($fileUrl, '.');
                            $fileExtension = substr($fileExtension, 1);
                            if ($fileExtension == "zip") {
                                $fileExtensionClass = 'nkIconZip';
                            } elseif ($fileExtension == "rar") {
                                $fileExtensionClass = 'nkIconZip';
                            } elseif ($fileExtension == "jpg" || $fileExtension == "jpeg") {
                                $fileExtensionClass = 'nkIconJpg';
                            } elseif ($fileExtension == "png") {
                                $fileExtensionClass = 'nkIconPng';
                            } elseif ($fileExtension == "gif") {
                                $fileExtensionClass = 'nkIconGif';
                            } elseif ($fileExtension == "bmp") {
                                $fileExtensionClass = 'nkIconBmp';
                            } else {
                                $fileExtensionClass = 'nkIconNone';
                            }

                            // Afficahge d'un message si la catégorie est vide 
                            if (is_null($fileCatTitle)) {
                                $fileCatTitle = NONECAT;
                            } else {
                                $fileCatTitle = $fileCatTitle;
                            }

                            // Affichage de la description si option defini par l'administrateur 
                            if ($modulePref['hideDescription'] == "off") {

                                // Affichage d'un message si la description est vide 
                                if (empty($fileDescription)) {
                                    $fileTexte = '<p class="nkMargin">'.NOTKNOW.'</p>';
                                } else {
                                    $fileDescriptions = htmlentities($fileDescription);
                                    $fileTexte = html_entity_decode($fileDescriptions);
                                    $fileTexte = icon($fileTexte);
                                }

                                $fileDescriptionView = '    <h3>'.DESCR.'</h3>'
                                                        . ' <div class="nkMarginBottom">'
                                                        .       $fileTexte 
                                                        . ' </div>';
                            }   

                            // Affichage de la taille du fichier si calculable 
                            if ($fileSize != '' && $fileSize < 1000) {
                                $fileSize = $fileSize.'&nbsp;'.KO;
                            } else if ($fileSize != '' && $fileSize >= 1000) {
                                $fileSize = $fileSize / 1000;
                                $fileSize = $fileSize.'&nbsp;'.MO;
                            } else {
                                $fileSize = NOTKNOW;
                            }

                            // Message d'erreur si compatibilité non précisé 
                            if (empty($fileCompatibility)) {
                                $fileCompatibility = NOTKNOW;
                            }

                            // Message d'erreur si site de l'auteur inconnu sinon lien vers celui-ci 
                            if (empty($fileUrlAutor)) {
                                    $fileUrlAutor = NOTKNOW;
                            } else {
                                    $fileUrlAutor = '<a href="'.$fileUrlAutor.'" target="_blank">'.VISITAUTORWEBSITE.'</a>';
                            }

                            // Message d'erreur si auteur non précisé sinon affichage de son pseudo 
                            if (empty($fileAutor)) {
                                    $fileAutor = NOTKNOW;
                            } else {
                                    $fileAutor = $fileAutor;
                            }

                            /*// Affichage d'un message si catégorie null 
                            if (isset($catTitle) && $catTitle == '') {
                                $catTitle = NONE;
                            }
                            */
                            // Affichage de l'image si existante sinon affichage image de substitution 
                            if ($fileScreen != '') {
                                $box = '<a href="'.checkimg($fileScreen).'" rel="shadowbox"><img  src="'.checkimg($fileScreen).'" title="'.$fileTitre.'" alt="" /></a>';
                            } else {
                                $box = '<img src="'.checkimg('images/noimage.png').'" title="'.$fileTitre.'" alt="" />';
                            }

                            // Récupération de l'extention 
                            if ($fileExtension != '' && !preg_match('`\?`i', $fileUrl) && !preg_match('`.html`i', $fileUrl) && !preg_match('`.htm`i', $fileUrl)) {
                                $fileExtension = $fileExtension;
                            }

                            // Affichage de la date si fichier édité
                            if ($fileEdit) {
                                $fileEdit = nkDate($fileEdit);
                            } else {
                                $fileEdit = NOTKNOW;
                            }

                            if ($visiteur >= $fileLevel) {
                                // Affichage du bouton télécharger si le visiteur a le niveau 
                                $filesButtonView = '<a href="index.php?file='.$modName.'&amp;op=doDownload&amp;nuked_nude=index&amp;requestedId='.$fileId.'" title="'.DOWNLOAD.' '.$fileTitre.'" class="nkButton">'.DOWNLOAD.'</a>'; 
                            } elseif ($visiteur == 0) {
                                // Affichage du bouton d'identification
                                $filesButtonView = '<a href="index.php?file=User&amp;nuked_nude=index&amp;op=login_screen" title="" class="nkPopupBox nkButton">'.NEEDLOGIN.'</a>';
                            } elseif ($visiteur < $fileLevel && $visiteur != 0) {  
                                // Affichage du bouton si le visiteur n'a pas le niveau                                           
                                // A MODIFIER AVEC LA LIBRAIRIE USER REQUEST
                                $filesButtonView = '<a href="" title="" class="nkButton">'.NEEDLEVEL.'</a>';
                            }
                            ?>
               
                            <!-- Section interne du module -->
                            <section class="nkMarginBottom15 nkPaddingBottom">
                                <a name="<?php echo $fileId; ?>"></a>
                                <!-- Header de la section interne du module -->
                                <header>
                                    <div class="nkInlineBlock">
                                        <figure class="nkInline nkMarginLeft">
                                            <span class="<?php echo $fileExtensionClass; ?>"></span>
                                        </figure>
                                        <h4 class="nkInline">
                                            <?php echo $fileTitre; ?>
                                        </h4>
                                        <?php echo $isNewHot; ?>
                                    </div>
                                    <div class="nkInlineBlock">
                                        <?php
                                            // A COMPLETER QUAND LA LIBRAIRIE VOTE SERA FAITE 
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
                                                <li><span class="nkIconDateUpdate"></span><?php echo EDITTHE; ?>&nbsp;:&nbsp;<small><?php echo $fileEdit; ?></small></li>
                                                <li><span class="nkIconInfo"></span><?php echo SIZE; ?>&nbsp;:&nbsp;<small><?php echo $fileSize; ?></small></li>
                                                <li><span class="nkIconRefresh"></span><?php echo COMPATIBLE; ?>&nbsp;:&nbsp;<small><?php echo $fileCompatibility; ?></small></li>
                                            </ul>
                                        </div>
                                        <div class="nkWidthHalf nkInlineBlock">
                                            <ul class="nkInlineBlock nkValignTop">
                                                <li><span class="nkIconAutor"></span><?php echo AUTOR; ?>&nbsp;:&nbsp;<small><?php echo $fileAutor; ?></small></li>
                                                <li><span class="nkIconGlobe"></span><?php echo SITE; ?>&nbsp;:&nbsp;<small><?php echo $fileUrlAutor; ?></small></li>
                                                <li><span class="<?php echo $fileExtensionClass; ?>"></span><?php echo EXT; ?>&nbsp;:&nbsp;<small><?php echo $fileExtension; ?></small></li>
                                                <li><span class="nkIconComments"></span><?php echo FILEVOTE; ?>&nbsp;:&nbsp;<small><?php echo $fileNote; ?></small></li>
                                                <li><span class="nkIconDownload"></span><?php echo DOWNLOADED; ?>:&nbsp;<small><?php echo $fileCount.'&nbsp;'.TIMES; ?></small></li>
                                            </ul>
                                        </div>
                                        <?php
                                        if ($modulePref['hideDescription'] == "off") {
                                            echo $fileDescriptionView;
                                        }
                                        ?>
                                    </div>
                                    <!-- Parti deporté pour le module commentaire -->
                                    <aside class="nkInlineBlock nkMarginTop15 nkValignTop nkWidthQuarter nkAlignCenter">
                                        <figure>
                                            <?php echo $box; ?>
                                        </figure>
                                        <?php 
                                        // Affichage des commentaires du fichier 
                                        viewComment($modName, $fileId, $modulePref['fileNbComment'], $modulePref['fileNbCommentCut']);
                                        ?>
                                    </aside>
                                </article>
                                <!-- Footer de la section interne du module -->
                                <footer class="nkAlignCenter nkMargin nkWidth3Quarter">
                                    <?php
                                    echo $filesButtonView;
                                    ?>
                                </footer>
                            </section>
                        <?php
                        }
                    }
                    ?>
                </article>
                <footer class="nkAlignCenter">
                    <span><small>( <?php echo THEREIS,'&nbsp;',$statFile,'&nbsp;',FILES,'&nbsp;-&nbsp;',$statSubCat,'&nbsp;',NBSUBCAT,'&nbsp;&amp;&nbsp;',$statCat,'&nbsp;',NBCAT,'&nbsp;',INDATABASE; ?> )</small></span>   
                </footer>
            </section>

        <?php
        }
    }

    function verifDownload($url1, $url2, $url3) {
        global $nuked;
        
        $urlVerify1 = $GLOBALS['nkFunctions']->nkVerifyUrl($url1);
        $urlVerify2 = $GLOBALS['nkFunctions']->nkVerifyUrl($url2);
        $urlVerify3 = $GLOBALS['nkFunctions']->nkVerifyUrl($url3);

        $headers    = @get_headers($urlVerify1);
        $headers2   = @get_headers($urlVerify2);
        $headers3   = @get_headers($urlVerify3);

        if (strpos($headers[0],'200') !== false) {
            $linkUrlVerify = $urlVerify1;
        } elseif (strpos($headers2[0],'200') !== false) {
            $linkUrlVerify = $urlVerify2;
        } elseif (strpos($headers3[0],'200') !== false) {
            $linkUrlVerify = $urlVerify3;
        } else {
            $linkUrlVerify = null;
        }
        return $linkUrlVerify;       
    }

    function doDownload($requestedId) {
        global $nuked, $visiteur, $modName;

        $dbsDl =   'SELECT url, url2, url3, count, level 
                    FROM '.DOWNLOADS_TABLE.' 
                    WHERE id = '.$requestedId;  
        $dbeDl = mysql_query($dbsDl);      
        list($urlDownload, $urlDownload2, $urlDownload3, $count, $level) = mysql_fetch_array($dbeDl);

        if (mysql_num_rows($dbeDl) <= 0) {
            redirect('index.php?file='.$modName.'&op=errorDownload&requestedId='.$requestedId, 0);
            die;
        }
        
        $url = verifDownload($urlDownload, $urlDownload2, $urlDownload3);

        if (!is_null($url)) {
            if ($visiteur >= $level) {
                $newCount = $count + 1;

                $dbuCount = 'UPDATE '.DOWNLOADS_TABLE.' 
                             SET count = "'.$newCount.'" 
                             WHERE id = '.$requestedId;
                $dbeCount = mysql_query($dbuCount);

                header("location: " . $url);
            } else {
                $GLOBALS['nkFunctions']->nkBadLevel();
                redirect($_SERVER['HTTP_REFERER'], 2);
            }            
        } else {
            errorDownload($requestedId, 'no', $_SERVER['HTTP_REFERER']);
        }     
    }

    function errorDownload($requestedId, $url, $referer) {
        global $language;

        if ($url == 'no') {
            $dbuUpd =  'UPDATE '.DOWNLOADS_TABLE.' 
                        SET broke = broke + 1 
                        WHERE id = '.$requestedId;
            $dbeUpd = mysql_query($dbuUpd);

            echo $GLOBALS['nkTpl']->nkDisplayError(DOWNLOADURLERROR.'<br/>'.BROKENLINKREPORT);
            redirect($referer, 2);

        } else {
            echo $GLOBALS['nkTpl']->nkDisplayError(DOWNLOADIDERROR);
        }
    }


    switch ($_REQUEST['op']) {

        case "doDownload":
            doDownload($_REQUEST['requestedId']);
            break;

        case "errorDownload":
            errorDownload($_REQUEST['requestedId'], $_REQUEST['url']);
            break;

        case "viewComment":
            viewComment($_REQUEST['module'], $_REQUEST['fileId']);
            break;

        case "post_com":
            post_com($_REQUEST['module'], $_REQUEST['fileId']);
            break;

        case "sendRating":
            sendRating();
            break;
            
        case "post_comment":
            post_comment($_REQUEST['module'], $_REQUEST['idItem'], $_REQUEST['title'], $_REQUEST['text'], $_REQUEST['nick']);
            break;

        default:
            index($_REQUEST['cat'], $_REQUEST['requestedId'], $_REQUEST['orderby'], $_REQUEST['orderbycat']);
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