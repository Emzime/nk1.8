<?php

// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//

/**
 * Light template library.
 * @name NK_tpl
 * @desc Custom class for include template
 */
class NK_functions {

    /**
     * @var instance
     * @access private
     * @static
     */
    private static $_instance = null;
    
    /**
     * Constructor.
     */
    private function __construct() {
    }
    
     /**
      * Single instance of class.
      * @param void
      * @return Singleton
      */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
           self::$_instance = new NK_functions();
        }
        return self::$_instance;
    }

    /**
     * Fonction pour afficher le menu
     * @param $module       -> Nom du module à interroger
     * @param $arrayMenu    -> Liens du menu (array / string)
     * @param $selected     -> Nom de l'op selectionné pour mettre en gras
     * @param $navClass     -> css for nav
     * @param $ulClass      -> css for ul
     * @param $liClass      -> class for li
     * @param $active       -> class for active link
     * @param $separator1   -> séparateur ouvrant ex: [
     * @param $separator2   -> séparateur fermant ex: ]   
     * @param $pipe         -> séparateur entre lien ex: |
     * @param $title        -> séparateur entre lien ex: |
     * return a menu for module administration
    **/
    public function nkMenu($module, $arrayMenu, $selected, $navClass = null, $ulClass = null, $liClass = null, $active = null, $separator1 = null, $separator2 = null, $pipe = null, $title=null) {

        if($navClass != null){$navClass = $navClass;}else{$navClass = '';}
        if($ulClass != null){$ulClass = 'class="'.$ulClass.'"';}else{$ulClass = '';}
        if($liClass != null){$liClass = $liClass;}else{$liClass = '';}
        if($title != null){$title = '<li class="'.$liClass.'">'.$title.'</li>';}else{$title = '';}

        $module = strtolower($module);

        $return = '<nav id="moduleMenuNav" class="'.$module.'_menuNav '.$navClass.'">
                <ul '.$ulClass.'>
                    '.$title.'&nbsp;
                    '.$separator1.'&nbsp;';
                
                $i = 0;
                foreach($arrayMenu as $arrayLink => $key) {
                    if($i>0) $return .= '&nbsp;'.$pipe.'&nbsp;';

                    if($key == $selected) {
                        $return .= '<li class="'.$active.' '.$liClass.'">';
                        $return .= $key;
                    }
                    else{
                        $return .= '<li class="'.$liClass.'">';
                        $return .= '<a href="'.$arrayLink.'" >'.$key.'</a>';
                    }            
                    $return .= '</li>';
                    $i++;
                }            
                $return .= '&nbsp;'.$separator2.'
                </ul>
            </nav>';

            return $return;
    }


    /** 
     * @param $link => array
     * @param $template => template use for breadcrumb
     * @param $navClass => css for nav
     * @param $ulClass => css for ul 
     * @param $liClass => class for li
    **/
    public function nkBreadCrumb($link, $template, $navClass=null, $ulClass=null, $liClass=null){

        if($navClass != null){$navClass = 'class="'.$navClass.'"';}else{$navClass = '';}
        if($ulClass != null){$ulClass = $ulClass;}else{$ulClass = '';}
        if($liClass != null){$liClass = 'class="'.$liClass.'"';}else{$liClass = '';}

        $return = ' <nav id="nkBreadCrumb" '.$navClass.'>
                        <ul class="'.$template.' '.$ulClass.'">';

                        $i = 0;
                        $nbCount = count($link);                        
                        foreach($link as $k => $v) {   
                            $return .= '<li '.$liClass.'>
                                            <a href="'.$k.'" style="z-index:'.$nbCount.';">'.$v.'</a>
                                        </li>';
                            $i++;
                            $nbCount--;
                        }
        $return .= '    </ul>
                    </nav>';

        return $return;
    }


    /**
    * Cut a chain keeping HTML formatting
    * @param string $text       -> Text to be cut
    * @param integer $length    -> Length to keep
    * @param string $ending     -> Characters to add at the end
    * @param boolean $exact     -> exact cut
    * @return string
    * exemple: $GLOBALS['nkFunctions']->nkCutText($description, '100');
    **/
    public function nkCutText($text, $length, $ending = '...', $exact = false) {
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        preg_match_all('/(<.+?>)?([^<>]*)/is', $text, $matches, PREG_SET_ORDER);
        $total_length = 0;
        $arr_elements = array();
        $truncate = '';
        foreach($matches as $element) {
            if (!empty($element[1])) {
                if(preg_match('/^<\s*.+?\/\s*>$/s', $element[1])) {
                } elseif(preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $element[1], $element2)) {
                    $pos = array_search($element2[1], $arr_elements);
                    if($pos !== false) {
                        unset($arr_elements[$pos]);
                    }
                } elseif(preg_match('/^<\s*([^\s>!]+).*?>$/s', $element[1], $element2)) {
                    array_unshift($arr_elements,
                    strtolower($element2[1]));
                }
                $truncate .= $element[1];
            }
            $content_length = strlen(preg_replace('/(&[a-z]{1,6};|&#[0-9]+;)/i', ' ', $element[2]));
            if ($total_length >= $length) {
                break;
            } elseif ($total_length+$content_length > $length) {
                $left = $total_length>$length?$total_length-$length:$length-$total_length;
                $entities_length = 0;
                if(preg_match_all('/&[a-z]{1,6};|&#[0-9]+;/i', $element[2], $element3, PREG_OFFSET_CAPTURE)) {
                    foreach($element3[0] as $entity) {
                        if($entity[1]+1-$entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else break;
                    }
                }
                $truncate .= substr($element[2], 0, $left+$entities_length);
                break;
            } else {
                $truncate .= $element[2];
                $total_length += $content_length;
            }
        }
        if (!$exact) {
            $spacepos = strrpos($truncate, ' ');
            if (isset($spacepos)) {
                $truncate = substr($truncate, 0, $spacepos);
            }
        }
        $truncate .= $ending;
        foreach($arr_elements as $element) {
            $truncate .= '</' . $element . '>';
        }
        return $truncate;
    }

    /**
     * Create tooltip CSS                                                     
     * @param $content      ->  Content displayed in tooltip
     * @param $lien         ->  Url link  ex: index.php?file=Download
     * @param $text         ->  Text for button ex: [ '.LISTING.' ] ou MYTEXT
     * @param $class        ->  Class for href (exemple: nkPopupBox for open link in nkPopup) (optional)
     * @param $themeUse     ->  Theme use for tooltip (see media/css/themes or use in administration of module) (optional)
     * @param $placement    ->  Placement of tooltip (top - left - right - bottom) (optional)
     * @param $animation    ->  Animation for tooltip (fade, grow, swing, slide, fall) (optional)
     * @param $maxWidth     ->  Set a max width for the tooltip (optional)
     * @param $arrowColor   ->  Color for arrow hex code / rgb (optional)
     *
     * http://calebjacob.com/tooltipster/#options   
     * exemple: echo $GLOBALS['nkFunctions']->nkTooltip($description, 'index.php?file=Downloads&amp;op=description&amp;nuked_nude=index&amp;idDownload='.$idDownload, $title, 'nkPopupBox', $modulePref['tooltipTheme'], $modulePref['tooltipPosition'], $modulePref['tooltipAnimation'], $modulePref['tooltipMaxWidth'], $modulePref['tooltipArrowColor']);
     **/
    public function nkTooltip($content, $lien='#', $text, $class=null, $themeUse=null, $placement=null, $animation=null, $maxWidth=null, $arrowColor=null) {

        $class          = !is_null($class)          ? 'class="'.$class.'"'                  : ''; 
        $placement      = !is_null($placement)      ? 'data-placement="'.$placement.'"'     : '';
        $animation      = !is_null($animation)      ? 'data-animation="'.$animation.'"'     : ''; 
        $themeUse       = !is_null($themeUse)       ? 'data-themeuse="'.$themeUse.'"'       : ''; 
        $maxWidth       = !is_null($maxWidth)       ? 'data-maxwidth="'.$maxWidth.'"'       : ''; 
        $arrowColor     = !is_null($arrowColor)     ? 'data-arrowcolor="'.$arrowColor.'"'   : ''; 
        $content = str_replace('"', "'", $content);
        $return = '<a '.$class.' href="'.$lien.'" data-api="tooltip" data-content="'.$content.'" '.$placement.' '.$animation.' '.$themeUse.' '.$maxWidth.' '.$arrowColor.'>'.$text.'</a>';
        return $return;
    }

    /**
     * Return to previous page.
     * @param string $url : url for back button
     *
     * return back button
     */
    public function nkHistoryBack($url=null, $class = null) { 
        $referer = is_null($url) ? $_SERVER['HTTP_REFERER'] : $url;
        $class = !is_null($class) ? 'class="'.$class.'"' : 'nkAlignCenter';
        return('<a href="'.$referer.'" '.$class.' >'.BACK.'</a>');    
    }

    /**
     * Level Select function for assigning levels of modules 
     * @param $name     ->  name menuSelect
     * @param $checked  ->  parameter recovery of the variable for the edition
     *
     * Exemple: $GLOBAL['nkFunctions']->nkLevelSelect(‘level’, $level);
     **/
    public function nkLevelSelect($name, $checked = null) {
    ?>
        <select id="<?php echo $name; ?>" name="<?php echo $name; ?>">        
            <?php
            for ($i = 0; $i <= 9; $i++) {
                if (!is_null($checked) && $checked==$i) {
                    echo '<option value="' . $i . '" selected="selected">' . $i . '</option>';
                } else {
                    echo '<option value="' . $i . '" >' . $i . '</option>';
                }
            }
            ?>
        </select>
    <?php
    }



    /** 
    * Create Checkbox simply
    * @param inputName      -> Name of select
    * @param inputClass     -> Class for input
    * @param inputId        -> ID for input
    * @param labelClass     -> Class for label (optional)
    * @param labelContent   -> Content for label (lang Name)
    * @param inputValue     -> Value for Input (lang: OK ...)
    * @param check          -> Value for checking checked="checked" (optional = true) 
    *
    * Exemple: $GLOBALS['nkFunctions']->nkCheckBox('remember_me', 'Remember', 'BlockLoginRememberId', 'BlockLoginRemember', REMEMBERME, 'ok', true);
    **/
    public function nkCheckBox($inputName, $inputClass, $inputId, $labelClass, $labelContent, $inputValue, $check=null) {
    
        if (!is_null($check)) {
            $checked = 'checked="checked"';
        }
        $return = ' <div class="nkCheckBox">
                        <label for="'.$inputId.'" class="nkLabelSpacing '.$labelClass.'">'.$labelContent.'</label>
                        <div class="nkCheckBoxRounded">
                            <input type="checkbox" value="'.$inputValue.'" id="'.$inputId.'" class="'.$inputClass.'" name="'.$inputName.'" '.$checked.' />
                            <label for="'.$inputId.'"></label>
                        </div>
                    </div>';
        return $return;
    }


    /**
     * nkRadioBox display bouton radio
     * @param  string $typeTag     specify type of tag
     * @param  string $tagContent  content for typeTag
     * @param  integer $numberRadio number option for radio button
     * @param  string $inputName   name for input
     * @param  string $inputValue  value for input
     * @param  string $inputFor    id for input
     * @param  string $tagClass    class for typeTag
     * @param  string $divClass    class for div
     * @param  string $labelClass  class for label
     * @return mixed
     */
    public function nkRadioBox($typeTag, $tagContent, $numberRadio, $inputName, $inputValue, $inputFor=null, $tagClass=null, $divClass=null, $labelClass=null) {
        foreach($inputValue as $key => $arrayValue) {

                $value[] = $arrayValue;
                $keyValue[] = $key;
        }
        $return = ' <'.$typeTag.' class="'.$tagClass.'">'.$tagContent.'</'.$typeTag.'>
                        <div class="nkRadioBox '.$divClass.'">';
                            $i = 0;
                            for ($i = 0; $i < $numberRadio; $i++) {
                                $return .= '<input type="radio" class="nkRadioBoxInput" name="'.$inputName.'" value="'.$keyValue[$i].'" id="'.$inputFor.$i.'" checked>
                                                <label for="'.$inputFor.$i.'" class="nkRadioBoxLabel nkRadioBoxLabel-off '.$labelClass.'">'.$value[$i].'</label>';                               
                            }
        $return .= '        <span class="nkRadioBoxSelection"></span>
                        </div>';
        return $return;
    }


    /**
     *  Insert dans la table action les actions effectué dans l'aministration
     *  @param 
     *
     **/
    public function nkTextAction($content) {
        $acdate = time();
        $sqlaction = mysql_query('INSERT INTO '.ACTION_TABLE.' (`date`, `pseudo`, `action`) VALUES ("'.$acdate.'", "'.$user[0].'", "'.$content.'")');
    }


    /**
     *  Fonction d'interrogation sur les tables de configuration des modules
     *  @param $module -> Nom du module à interroger
     *
     *  Appel de la fonction $GLOBALS['nkFunctions']->nkModsPrefs($modName); (modName defini par $modName = basename(dirname(__FILE__)); dans le module)
     **/
    public function nkModsPrefs($mods) {
        $mods = strtoupper($mods);
        $constantMods = constant($mods.'_CONFIG_TABLE');
        $sql = mysql_query('SELECT name, value FROM '.$constantMods);
        while($row = mysql_fetch_array($sql)) {
            $return[$row['name']] = printSecuTags(htmlentities($row['value'], ENT_NOQUOTES));
        }
        return $return;
    }

    /**
     * Validation function links             
     * @param $url -> link / file  to the page  
     **/
    public function nkVerifyUrl($url, $check=null) {
        global $nuked;

        /* On verifie le format de l'url */
        if (version_compare(PHP_VERSION, '5.2.0', '>')) {
            if (filter_var($url, FILTER_VALIDATE_URL)) {               
                $urlVerify = $url;
            } else {
                $urlVerify = $nuked['url'].'/'. $url;
            }
        } else {
            $regex = "#((http|https|ftp)://(\S*?\.\S*?))(\s|\;|\)|\]|\[|\{|\}|,|\"|'|:|\<|$|\.\s)#ie";   
            if (preg_match($regex, $url)) {
                $urlVerify = $url;
            } else {
                $urlVerify = $nuked['url'].'/'. $url;
            }
        }

        if (!is_null($check)) {
            $urlReturn = @get_headers($urlVerify);

            if (strpos($urlReturn[0],'200') !== false) {
                $linkUrlVerify = $urlVerify;
            } else {
                echo $GLOBALS['nkTpl']-> nkDisplayError(URLNOTFOUND);
                echo $GLOBALS['nkFunctions']->nkHistoryBack();
            }
        } else {
            $linkUrlVerify = $urlVerify;
        }

        return $linkUrlVerify;
    }

    /**
     * nkInitRequest initializes the elements of the array
     * @param array $array 
     */
    public function nkInitRequest($array) {
        foreach ($array as $value) {
            if (!isset($_REQUEST[$value])) {
                $_REQUEST[$value] = null;
            }
        }
    }

    /**
     * infoBlocks display block
     */
    function infoBlocks() {
        $dbsActiveBlock = ' SELECT id, side, placing, module, title, content, type, level, page 
                            FROM '.BLOCK_TABLE.' 
                            WHERE side != 0 
                            ORDER BY side';
        $dbeActiveBlock = mysql_query($dbsActiveBlock)or die(mysql_error());
        $dbcActiveBlock = mysql_num_rows($dbeActiveBlock);
        if ($dbcActiveBlock > 0) {
            $infos = array(1 => array(), 2 => array(), 3 => array(), 4 => array());
            while($row = mysql_fetch_assoc($dbeActiveBlock)) {
                $blockArray = array(
                    'id'      => $row['id'],
                    'side'    => $row['side'],
                    'placing'  => $row['placing'],
                    'module'  => $row['module'], 
                    'title'   => $row['title'],
                    'content' => $row['content'],
                    'type'    => $row['type'],
                    'level'   => $row['level'],
                    'page'    => $row['page'] 
                );
                for($i=1;$i<=4;$i++) {
                    if($i == $row['side']) {
                        $infos[$i][] = $blockArray;
                    }
                }
            }
        }
        return $infos;
    }

    /**
     * infoModules return all information on modules
     * @return array array of all informations
     */
    function infoModules() {
        $dbsActiveModule = 'SELECT id, name, newName, level, admin 
                            FROM '. MODULES_TABLE;
        $dbeActiveModule = mysql_query($dbsActiveModule)or die(mysql_error());
        while($row = mysql_fetch_assoc($dbeActiveModule)) {
            $moduleArray[$row['name']] = array(
                    'id'      => $row['id'],
                    'name'    => $row['name'],
                    'newName' => $row['newName'],
                    'level'   => $row['level'],
                    'admin'   => $row['admin']
                );
        }
        return $moduleArray;
    }

    /**
     * nkSeeModule list module actived
     * @param  array $blackListMods list blacklisted module
     * @return mixed option for select list module where module doesn't blacklisted
     */
    public function nkSeeModule($blackListMods) {
        $activMods = activatedModules($blackListMods);
        $return = '';
        foreach ($activMods as $key => $value) {
            $nameModule = strtoupper($key);
            $nameModule = constant($nameModule);

            if (!empty($value['newName']) && @constant($value['newName'])) {
                $nameModule = constant($value['newName']);
            } elseif (!empty($value['newName'])) {
                $nameModule = $value['newName'];
            }
            $return .= '<option value="'.$key.'">'.$nameModule.'</option>';
        }
        return $return;
    }
}
?>