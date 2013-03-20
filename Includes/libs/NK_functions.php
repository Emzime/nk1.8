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
     * Single instance of class
     * @return Singleton [description]
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
           self::$_instance = new NK_functions();
        }
        return self::$_instance;
    }

    /**
     * [nkMenu description]
     * @param  string $module     module name questioned
     * @param  string $arrayMenu  Menu Links (array / string)
     * @param  string $selected   Name of the selected op for bold
     * @param  string $navClass   css for nav
     * @param  string $ulClass    css for ul
     * @param  string $liClass    class for li
     * @param  string $active     class for active link
     * @param  string $separator1 opening delimiter ex: [
     * @param  string $separator2 closing delimiter ex: ]
     * @param  string $pipe       separator between link ex: |
     * @param  string $title      title of li (optional)
     * @return mixed             [description]
     */
    public function nkMenu($module, $arrayMenu, $selected, $navClass = null, $ulClass = null, $liClass = null, $active = null, $separator1 = null, $separator2 = null, $pipe = null, $title=null) {
        if ($navClass != null) {
            $navClass = $navClass;
        } else {
            $navClass = '';
        }
        if ($ulClass != null) {
            $ulClass = 'class="'.$ulClass.'"';
        } else {
            $ulClass = '';
        }
        if ($liClass != null) {
            $liClass = $liClass;
        } else {
            $liClass = '';
        }
        if ($title != null) {
            $title = '<li class="'.$liClass.'">'.$title.'</li>';
        } else {
            $title = '';
        }
        $module = strtolower($module);
        $return = ' <nav id="moduleMenuNav" class="'.$module.'_menuNav '.$navClass.'">
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
     * display breadcrumb in module
     * @param  string $link     array
     * @param  string $template template use for breadcrumb
     * @param  string $navClass class for nav
     * @param  string $ulClass  class for ul
     * @param  string $liClass  class for li
     * @return mixed           [description]
     */
    public function nkBreadCrumb($link, $template, $navClass=null, $ulClass=null, $liClass=null) {
        if ($navClass != null) {
            $navClass = 'class="'.$navClass.'"';
        } else {
            $navClass = '';
        }
        if ($ulClass != null) {
            $ulClass = $ulClass;
        } else {
            $ulClass = '';
        }
        if ($liClass != null) {
            $liClass = 'class="'.$liClass.'"';
        } else {
            $liClass = '';
        }
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
     * @param string $text     Text to be cut
     * @param integer $length  Length to keep
     * @param string $ending   Characters to add at the end
     * @param boolean $exact   exact cut
     * @return mixed
     */
    public function nkCutText($text, $length, $ending = '...', $exact = false) {
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        preg_match_all('/(<.+?>)?([^<>]*)/is', $text, $matches, PREG_SET_ORDER);
        $total_length = 0;
        $arr_elements = array();
        $truncate     = '';
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
     * @param  string $content    Content displayed in tooltip
     * @param  string $lien       Url link  ex: index.php?file=Download
     * @param  string $text       Text for button ex: [ '.LISTING.' ] ou MYTEXT
     * @param  string $class      Class for href (exemple: nkPopupBox for open link in nkPopup) (optional)
     * @param  string $themeUse   Theme use for tooltip (see media/css/themes or use in administration of module) (optional)
     * @param  string $placement  Placement of tooltip (top - left - right - bottom) (optional)
     * @param  string $animation  Animation for tooltip (fade, grow, swing, slide, fall) (optional)
     * @param  integer $maxWidth   Set a max width for the tooltip (optional)
     * @param  string $arrowColor Color for arrow hex code / rgb (optional)
     * @return mixed             [description]
     */
    public function nkTooltip($content, $lien='#', $text, $class=null, $themeUse=null, $placement=null, $animation=null, $maxWidth=null, $arrowColor=null) {
        $class      = !is_null($class)          ? 'class="'.$class.'"'                  : ''; 
        $placement  = !is_null($placement)      ? 'data-placement="'.$placement.'"'     : '';
        $animation  = !is_null($animation)      ? 'data-animation="'.$animation.'"'     : ''; 
        $themeUse   = !is_null($themeUse)       ? 'data-themeuse="'.$themeUse.'"'       : ''; 
        $maxWidth   = !is_null($maxWidth)       ? 'data-maxwidth="'.$maxWidth.'"'       : ''; 
        $arrowColor = !is_null($arrowColor)     ? 'data-arrowcolor="'.$arrowColor.'"'   : ''; 
        $content    = str_replace('"', "'", $content);
        $return     = '<a '.$class.' href="'.$lien.'" data-api="tooltip" data-content="'.$content.'" '.$placement.' '.$animation.' '.$themeUse.' '.$maxWidth.' '.$arrowColor.'>'.$text.'</a>';
        return $return;
    }

    /**
     * Return to previous page
     * @param  string $url   url for back button
     * @param  string $class class for div
     * @return mixed         [description]
     */
    public function nkHistoryBack($url=null, $class = null) {
        if (!is_null($url)) {
            $referer = $url;
        } else {
            if (isset($_SERVER['HTTP_REFERER']) === false) {
                $referer = 'index.php';
            } else {
                $referer = $_SERVER['HTTP_REFERER'];
            }
        }
        $class = !is_null($class) ? 'class="'.$class.'"' : 'nkAlignCenter';
        return('<div '.$class.' ><a href="'.$referer.'">'.BACK.'</a></div>');    
    }

    /**
     * Level Select function for assigning levels of modules 
     * @param  string $name    name menuSelect
     * @param  string $checked parameter recovery of the variable for the edition
     * @return mixed          [description]
     */
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
     * [nkCheckBox description]
     * @param  string $inputName    Name of select
     * @param  string $inputClass   Class for input
     * @param  integer $inputId     ID for input
     * @param  string $labelClass   Class for label (optional)
     * @param  string $labelContent Content for label (lang Name)
     * @param  string $inputValue   Value for Input (lang: OK ...)
     * @param  string $check        Value for checking checked="checked" (optional = true)
     * @return mixed               [description]
     */
    public function nkCheckBox($inputName, $inputClass, $inputId, $labelClass, $labelContent, $inputValue, $check=null) {    
        if (!is_null($check)) {
            $checked = 'checked="checked"';
        } else {
            $checked = '';
        }
        $return = ' <div id="nkCheck" class="nkCheckBox">
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
     * @param  string $typeTag      specify type of tag
     * @param  string $tagContent   content for typeTag
     * @param  integer $numberRadio number option for radio button
     * @param  string $inputName    name for input
     * @param  string $inputValue   value for input
     * @param  string $inputFor     id for input
     * @param  string $tagClass     class for typeTag
     * @param  string $divClass     class for div
     * @param  string $labelClass   class for label
     * @param  string $checked      value was checked
     * @return mixed               [description]
     */
    public function nkRadioBox($typeTag, $tagContent, $numberRadio, $inputName, $inputValue, $tagSeparate, $inputFor=null, $tagClass=null, $divClass=null, $labelClass=null, $checked=null) {
        foreach($inputValue as $key => $arrayValue) {
            $value[]    = $arrayValue;
            $keyValue[] = $key;
        }
        $return = ' <'.$typeTag.' class="'.$tagClass.'">'.$tagContent.'</'.$typeTag.'>'.$tagSeparate.'
                        <div class="nkRadioBox '.$divClass.'">';
                            $i = 0;
                            for ($i = 0; $i < $numberRadio; $i++) {
                                if ($checked == $keyValue[$i]) {
                                    $check = 'checked';
                                } else {
                                    $check = '';
                                }
                                $return .= '<input type="radio" class="nkRadioBoxInput" name="'.$inputName.'" value="'.$keyValue[$i].'" id="'.$inputFor.$i.'" '.$check.'>
                                                <label for="'.$inputFor.$i.'" class="nkRadioBoxLabel nkRadioBoxLabel-off '.$labelClass.'">'.$value[$i].'</label>';                               
                            }
        $return .= '        <span class="nkRadioBoxSelection"></span>
                        </div>';
        return $return;
    }

    /**
     * Insert in action table actions do in aministration
     * @param  string $content description of actions
     * @return mixed          [description]
     */
    public function nkTextAction($content) {
        $acdate = time();
        $sqlaction = mysql_query('INSERT INTO '.ACTION_TABLE.' (`date`, `pseudo`, `action`) VALUES ("'.$acdate.'", "'.$user[0].'", "'.$content.'")');
    }

    /**
     * Query function on module configuration tables
     * @param  string $mods module name questioned
     * @return mixed       [description]
     */
    public function nkModsPrefs($mods) {
        $mods = strtoupper($mods);
        $constantMods = constant($mods.'_CONFIG_TABLE');
        // debug($constantMods);
        $sql = mysql_query('SELECT name, value FROM '.$constantMods);
        while($row = mysql_fetch_array($sql)) {
            $return[$row['name']] = printSecuTags(htmlentities($row['value'], ENT_NOQUOTES));
        }
        return $return;
    }

    /**
     * Validation function links
     * @param  string $url   link / file  to the page
     * @param  string $check [description]
     * @return mixed        [description]
     */
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
     * @param  string $array array
     * @param  string $index array for init index.php (don't touch)
     * @return mixed        [description]
     */
    public function nkInitRequest($array, $index = null) {
        if (!isset($GLOBALS['nkInitError'])) {
            $GLOBALS['nkInitError'] = null;
        }
        if (!is_null($index)) {
            $mergeArray      = array_merge_recursive($array,$index);
            $valueMergeArray = array();
            foreach ($mergeArray as $key => $value) {
                $valueMergeArray = array_merge($value,$valueMergeArray);
            }
            $valueQueryArray = array();
            if (!empty($_SERVER['QUERY_STRING'])) {
                $parts = explode("&", $_SERVER['QUERY_STRING']);              
                foreach ($parts as $val) {               
                    $val_parts = explode("=", $val);
                    $valueQueryArray[] = $val_parts[0];
                }
            } else {
                $valueQueryArray = array_keys($_GET);
            }
            foreach ($valueQueryArray as $k => $v) {
                if (!in_array($v, $valueMergeArray)) {
                    $errorContent = '   <h3>'.ERRORARGUMENT.'&nbsp;'.$v.'</h3>
                                        <p>'.NOTINITARGUMENT.'</p>';
                    $GLOBALS['nkInitError'] .= $GLOBALS['nkTpl']->nkContentTag('div', $errorContent, 'nkAlert nkAlertError');
                }
            }
        }
        foreach ($array as $key => $value) {
            if ($key == 'integer') {
                foreach ($value as $k) {
                    if (!isset($_REQUEST[$k])) {
                        $_REQUEST[$k] = null;
                    } elseif (!preg_match("/^[0-9]*$/", $_REQUEST[$k])) {
                        $errorContent = '   <h3>'.ERRORARGUMENT.'&nbsp;'.$k.'</h3>
                                            <p>'.NOTINTEGERARGUMENT.'</p>';
                        $GLOBALS['nkInitError'] .= $GLOBALS['nkTpl']->nkContentTag('div', $errorContent, 'nkAlert nkAlertError');
                    }
                }                    
            } elseif ($key == 'boolean') {
                foreach ($value as $k) {
                    if (!isset($_REQUEST[$k])) {
                        $_REQUEST[$k] = null;
                    } elseif (!preg_match("/^(true|false)$/", $_REQUEST[$k])) {
                        $errorContent = '   <h3>'.ERRORARGUMENT.'&nbsp;'.$k.'</h3>
                                            <p>'.NOTBOOLEENARGUMENT.'</p>';
                        $GLOBALS['nkInitError'] .= $GLOBALS['nkTpl']->nkContentTag('div', $errorContent, 'nkAlert nkAlertError');
                    }
                }   
            } elseif ($key == 'string') {
                foreach ($value as $k) {
                    if (!isset($_REQUEST[$k])) {
                        $_REQUEST[$k] = null;
                    } elseif (!preg_match("/^[a-z]+[0-9]?[a-z]*$/i", $_REQUEST[$k])) {
                        $errorContent = '   <h3>'.ERRORARGUMENT.'&nbsp;'.$k.'</h3>
                                            <p>'.NOTSTRINGARGUMENT.'</p>';
                        $GLOBALS['nkInitError'] .= $GLOBALS['nkTpl']->nkContentTag('div', $errorContent, 'nkAlert nkAlertError');
                    } elseif (preg_match("/^(outfile|onmouse|select|update|insert|delete|union)$/", $_REQUEST[$k])) {
                        $errorContent = '   <h3>'.ERRORARGUMENT.'&nbsp;'.$k.'</h3>
                                            <p>'.BLACKLISTARGUMENT.'</p>';
                        $GLOBALS['nkInitError'] .= $GLOBALS['nkTpl']->nkContentTag('div', $errorContent, 'nkAlert nkAlertError');
                    }
                } 
            } elseif ($key == 'uniqid') {
                foreach ($value as $k) {
                    if (!isset($_REQUEST[$k])) {
                        $_REQUEST[$k] = null;
                    } elseif (!preg_match("/^[a-zA-Z0-9]{20}$/", $_REQUEST[$k])) {
                        $errorContent = '   <h3>'.ERRORARGUMENT.'&nbsp;'.$k.'</h3>
                                            <p>'.NOTUNIQIDARGUMENT.'</p>';
                        $GLOBALS['nkInitError'] .= $GLOBALS['nkTpl']->nkContentTag('div', $errorContent, 'nkAlert nkAlertError');
                    }
                }
            }             
        }
    }

    /**
     * infoBlocks display block
     * @return mixed [description]
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
                    'placing' => $row['placing'],
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
     * @return array  array of all informations
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

    /**
     * generated Pdf file
     * @param  [type] $html       [description]
     * @param  [type] $fileName   [description]
     * @param  [type] $modulePref [description]
     * @return [type]             [description]
     */
    public function generatedPdf($html, $fileName, $modulePref) {
        global $lang;
        require_once'Includes/tcpdf/config/nkLang/'.$lang.'.php';
        require_once'Includes/tcpdf/tcpdf.php';
        $copyright = "http://www.nuked-klan.org\n";
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set default header data
        $pdf->SetHeaderData('nkPdfLogo.png', 30, $GLOBALS['nuked']['name'], TFOR.' '.$copyright.''.POWERED. ' '.PDF_HEADER_STRING);
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //set some language-dependent strings
        $pdf->setLanguageArray($l);
        // set font
        $pdf->SetFont($modulePref['pdfFont'], $modulePref['pdfFontStyle'], $modulePref['pdfFontSize']);
        // add a page
        $pdf->AddPage($modulePref['pdfDirection'],$modulePref['pdfFormat']);
        // set some text to print
        // print a block of text using Write()
        //$pdf->Write($h=0, $txt, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
        $pdf->writeHTML($html, true, false, true, false, '');
        ob_clean();
        //Close and output PDF document
        $pdf->Output($fileName, $modulePref['pdfGeneratedType']);
    }
   
   /**
    * upload file function
    * @param string $module        module name
    * @param string $fileName      name of $_FILE
    * @param string $urlTesting    value of input file without upload
    */
    public function UploadFiles($module, $fileName, $urlTesting=NULL) {
        global $user;
        // initialise variable
        $name   = '';
        $type   = '';
        $handle = '';
        $temp   = '';
        // defini les extentions autorisées
        $validTypes  = array('image/jpeg', 'image/png', 'image/gif');
        // definition des variables
        $module      = ucfirst($module);
        if (!empty($_FILES)) {
            $temp = $_FILES[$fileName]['tmp_name'];
            $type = $_FILES[$fileName]['type'];
            $name = $_FILES[$fileName]['name'];
        }
        if ($name != '') {
            $extentionCheck = in_array($type, $validTypes);
            if ($extentionCheck == false) {
                echo $GLOBALS['nkTpl']->nkDisplayError(NOUPLOADVALID, 'nkAlert nkAlertError');
                echo $this->nkHistoryBack(null, 'nkAlignCenter nkMarginTop15');
                footer();
                exit();
            } 
            // si la fonction mkdir existe on crée un dossier par membre sinon on upload dans upload/nom du module            
            if (function_exists('mkdir')) {
                $handle = 'upload/'.$module.'/'.$user[2].'/';
                if (!is_dir($handle)) {
                    mkdir($handle, 0777);
                    if (!is_file($handle.'/index.html') && function_exists('copy')) {
                        copy('upload/'.$module.'/index.html', $handle.'/index.html');
                    }
                }
            } else {
                $handle = 'upload/'.$module.'/';
            } 
            $userDir = $handle.$name;
            if(!is_uploaded_file($temp)) {
                echo $GLOBALS['nkTpl']->nkDisplayError(NOUPLOAD, 'nkAlert nkAlertError');
                footer();
                exit();
            } elseif (!move_uploaded_file($temp, $userDir)) {
                echo $GLOBALS['nkTpl']->nkDisplayError(NOUPLOADAVALABLE, 'nkAlert nkAlertError');
                footer();
                exit();
            } else {
                move_uploaded_file($temp, $name);
                chmod ($handle, 0644);
                $avatar   = $userDir;
                return $avatar;
            }
        } elseif (!is_null($urlTesting)) {
            $avatar   = $urlTesting;
            return $avatar;
        } else {
            $avatar   = '';
            return $avatar;
        }
    }

    /**
     * transform unicode to utf8
     * @param  string $content value to convert
     * @return string          [description]
     */
    private function unicodeToUtf8($content) {
        $return = html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $content), ENT_NOQUOTES, 'UTF-8');
        return $return;
    }

    /**
     * see country and auto select language
     * @param  string $checked          check user country
     * @param  string $checkedLang      check user lang
     * @param  string $submitButton    value button if you want a button
     * @param  string $divClass         class for div lang
     * @param  string $labelClass       class for label lang
     * @param  string $submitOnSelect   create onChange function on <select>
     * @return string                   return country and language for user
     */
    public function nkSelectCountry($checkedCountry=null, $checkedLang=null, $submitButton=null, $submitOnSelect=null, $flagClass=null, $divClass=null, $labelClass=null) {
        global $nuked, $user;

        if (!is_null($divClass)) {
            $divClass = $divClass;
        } else {
            $divClass = '';
        }
        if (!is_null($labelClass)) {
            $labelClass = $labelClass;
        } else {
            $labelClass = '';
        }
        if (!is_null($flagClass)) {
            $flagClass = $flagClass;
        } else {
            $flagClass = '';
        }
        if (!is_null($submitOnSelect) && is_null($submitButton)) {
            $submitOnSelect = 'data-submit="1"';
        } elseif (is_null($submitOnSelect) && !is_null($submitButton)) {
            $submitOnSelect = 'data-submit="2"';
        } else {
            $submitOnSelect = 'data-submit="0"';
        }

        // initialize
        $viewCountry = '';
        $viewLang    = '';
        $codeSelected = '';
        // suppression des \ pour les langues spéciales
        $checkedLang = stripslashes($checkedLang);        
        // sélection du pays et des langues
        $dbsCountry = ' SELECT ct.code, ct.name, ct.language
                        FROM '.COUNTRY_TABLE.' AS ct 
                        WHERE ct.active = 1
                        ORDER BY ct.name, ct.language';
        $dbeCountry = mysql_query($dbsCountry);
        // création du tableau pour le changement des langues
        $return  = '<script type="text/javascript">
                        var arrayCountry = new Array();
                        var buttonLang = "'.$submitButton.'";
                    ';
        while (list($code, $countryList, $langText) = mysql_fetch_array($dbeCountry)) {
            $langTmp = explode('|', $langText);
            // check si la langue utilisé existe dans le tableau
            if ($checkedCountry == $countryList) {
                // création du selected si la langue existe dans le tableau
                $check   = 'selected="selected"';
                // ajout de l'iso code
                $codeSelected = $code;
            } else {
                $check = '';
            }
            // On créer un sous tableau par pays
            $return .= 'arrayCountry["'.$code.'"] = new Array(';
            foreach ($langTmp as $lg) {
                // cherche si la langue existe dans le tableau
                if ($checkedLang == $lg) {
                    // ajout d'un selected si la langue existe dans le tableau
                    $checkLang = 'selected="selected"';
                } else {
                    $checkLang = '';
                }
                // vérification que le pays utilisé existe dans le tableau
                if($checkedCountry == $countryList) {
                    // ajout de la langue du pays vérifié
                    $viewLang .= '<option value="'.$lg.'" '.$checkLang.'>'.$lg.'</option>';
                }
                // On complete le sous tableau avec les langues correspondantes
                $return .= '"'.$lg.'",';
            }
            // création de la liste des pays
            $viewCountry .= '<option class="nkSelectFlags'.$code.'" data-iso="'.$code.'" value="'.$countryList.'" '.$check.'>'.$countryList.'</option>';            
            // On enlève la virgule en trop
            $return = substr($return,0, -1);
            // Fermeture du tableau des langues
            $return .= ');'."\n";
        }
        $return .= '</script>';
        // création du formulaire
        $return .= '    <span class="nkFlags'.$codeSelected.' '.$flagClass.'"></span>
                        <select class="nkInput nkSelectCountry editCountry" name="country" '.$submitOnSelect.' >'.$viewCountry.'</select>
                        <div class="nkWidthFully '.$divClass.'">
                            <label class="nkLabelSpacing '.$labelClass.'" for="editLang">'.LANGUAGE.'</label>&nbsp;:&nbsp;
                                <select class="nkInput editLang" name="userLang"  '.$submitOnSelect.'>'.$viewLang.'</select>
                        </div>';
        return $return;
    }
}
?>