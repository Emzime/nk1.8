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
class NK_tpl {    
    
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
           self::$_instance = new NK_tpl();
        }
        return self::$_instance;
    }
    
    /**
     * Generator content with tags (open / close style).
     * @param string $tag : tag to generate ('div', 'span', ....)
     * @param string $content content to display inside div
     * @param mixed $classes list of classes to display, false if not class
     * @param mixed $id : id to display, false if not id
     * @example
     *                      nkContentTag('div', 'my text', 'nkError nkCenter', 'idTest')
     *             ==> <div class="nkError nkCenter">my text</div>
     */
    public function nkContentTag($tag, $content, $classes = false, $id = false) {
        // Tag which will be generated
        $tagDisplay = '';
        // Attributes which will be generated
        $attrStr = '';
        if ($classes != false) {
            $attrStr .= ' class="'. $classes .'"';
        }
        if ($id != false) {
            $attrStr .= ' id="'. $id .'"';
        }

        $tagDisplay = '<' . $tag . $attrStr . '>' . $content . '</' . $tag . '>';
        return $tagDisplay;
    }
    
    /**
     * Display error on a tag.
     * @param string $content : text to display 
     * @param string $classes : class used for text
     * @param boolean $center if true, center text, else not
     * @param mixed $id : id to display, false if not id
     * @ return string to display
     */
    public function nkDisplayError($content, $classes = 'nkError', $center = true, $id = false) {
        if ($center) {
            $classes .= ' nkCenter'; 
        }
        return $this->nkContentTag('div', $content, $classes, $id);
    }

    /**
     * Display success on a tag.
     * @param string $content : text to display 
     * @param string $classes : class used for text
     * @param boolean $center if true, center text, else not
     * @param mixed $id : id to display, false if not id
     * @ return string to display
     */
    public function nkDisplaySuccess($content, $classes = 'nkSuccess', $center = true, $id = false) {
        if ($center) {
            $classes .= ' nkCenter';  
        }
        return $this->nkContentTag('div', $content, $classes, $id);
    }

    /**
     * Exit after a display error on a tag.
     * @param string $content : text to display 
     * @param string $url : url for back button
     * @ return string to display, back button and exit function
     */
    public function nkExitAfterError($content, $class = 'nkCenter', $url = null){

        echo $this->nkDisplayError($content, $class, true);
        exit();
    }

    /**
     * level display if access denied.
     * @param string $url : url for back button
     * @ return informed that the member does not have the required level
     */
    public function nkBadLevel($url=null) {
        $return = $this->nkDisplayError(NOENTRANCE, 'nkError', true);
        $return .= $GLOBALS['nkTpl']->nkContentTag('div', $GLOBALS['nkFunctions']->nkHistoryBack(), 'nkError nkCenter margin-bottom');
        return($return);
    }

    /**
     * Display if disabled module.
     * @param string $url : url for back button
     * @ return informs that the module is disabled
     */
    public function nkModuleOff($url=null) {
        $referer = is_null($url) ? 'index.php' : $url;
        $return = $this->nkDisplayError(MODULEOFF, 'nkError', true);
        $return .= $GLOBALS['nkFunctions']->nkHistoryBack($url);
        return($return);
    }

    /**
     * Return identification required.
     * @param string $pipe : display a selector
     * @ returns a link to the identification or recording
     */
    public function nkNoLogged($pipe = null) {
        global $user;
        $visiteur = $user ? $user[1] : 0;

        if ($visiteur == 0) {             
            return($this->nkDisplayError('<h1>'.USERENTRANCE.'</h1><a href="index.php?file=User&amp;op=login_screen">'.TOLOG.'</a>&nbsp;'.$pipe.'&nbsp;<a href="index.php?file=User&amp;op=reg_screen">'.REGISTERUSER.'</a>', 'nkError', true));
        }
    }   
}

// Test generator
/*
$nkTpl = NK_tpl::getInstance();
echo $nkTpl->nkContentTag('div', 'my text', 'nkError nkCenter', 'idTest');
echo $nkTpl->nkDisplayError('my text');
 */
?>