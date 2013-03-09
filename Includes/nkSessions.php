<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined('INDEX_CHECK') or die;

/**
 * Configuration for sessions.
 */

/*****************************
 * Begin sessions handler. *
 ****************************/

/**
 * Open session.
 * @param string $savePath
 * @param string $sessionName
 * @return boolean : true session opened 
 */
function session_open($savePath, $sessionName){
    return true;
}

/**
 * Close session.
 * @return boolean : true session closed
 */
function session_close() {
    return true;
}

/**
 * Read session.
 * @param string $sessionId : session id
 * @return boolean : true if session read, else false 
 */
function session_read($sessionId) {
    nkTryConnect();
    $result = '';
    $sessionVar = nkDB_select('SELECT session_vars FROM ' . TMPSES_TABLE . ' WHERE session_id = ' . nkDB_escape($sessionId));
    if (nkDB_numRows() > 0 && !empty($sessionVar)) {
        $result = $sessionVar[0]['session_vars'];
    }
    return $result;
}

/**
 * Write session.
 * @param string $sessionId : session id
 * @param string $data
 * @return boolean : true if session wrote, else false 
 */
function session_write($sessionId, $data) {
    nkTryConnect();
    
    $fields = array( 'session_id', 'session_start', 'session_vars' );
    $values = array( $sessionId, time(), $data );
    $rs = nkDB_insert( TMPSES_TABLE, $fields, $values );
    
    if ($rs === false || nkDB_affected_rows() == 0) {
        $fields = array('session_vars');
        $values = array($data);
        $rs = nkDB_update( TMPSES_TABLE, $fields, $values, 'session_id = '. nkDB_escape($sessionId));
    }
    return $rs;
}

/**
 * Delete session.
 * @param string $id : session id
 * @return mixed : resource if session deleted, else false 
 */
function session_delete($sessionId){
    nkTryConnect();
    
    $rs = nkDB_delete( TMPSES_TABLE, 'session_id = ' . nkDB_escape($sessionId));

    return $rs;
}

/**
 * Kill dead session.
 * @param string $maxlife: maxlife time
 * @return boolean : session deleted 
 */
function session_gc($maxlife){
    $time = time() - $maxlife;

    nkTryConnect();
    
    $rs = nkDB_delete( TMPSES_TABLE, 'session_start < ' . $time);

    return true;
}

/**
 * Runtime configuration for PHP sessions.
 */
function nkConfigureSessions() {
    
    /**
     * Sets user-level session storage functions.
     */
    if (ini_get('session.save_handler') == 'files') {
        session_set_save_handler(
                'session_open',
                'session_close',
                'session_read',
                'session_write',
                'session_delete',
                'session_gc');
    }
    
    /**
     * Control activation extension suhosin.
     */
    if(ini_get('suhosin.session.encrypt') == '1'){
        @ini_set('session.gc_probability', 100);
        @ini_set('session.gc_divisor', 100);
        @ini_set('session.gc_maxlifetime', (1440));
    }
    
}

/**************************
 * End sessions handler. *
 **************************/

/**
 * Start a nk session.
 */
function nkSessionInit() {
    
    nkConfigureSessions();
    
    //session_name('nuked');
    
    // Starting the native PHP session
    session_start();
    
    /*
    if (session_id() == '') {
        exit(ERROR_SESSION);
    }
    */
    
    // Prepare sessions vars
    $lifetime     = $GLOBALS['nuked']['sess_days_limit'] * 86400;
    $timesession  = $GLOBALS['nuked']['sess_inactivemins'] * 60;
    $time         = time();
    $timelimit    = $time + $lifetime;
    $sessionlimit = $time + $timesession;
    $userTheme    = '';
    $userLangue   = '';

    // Recherche de l'adresse IP
    $uip = (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    
    // Prepare session cookie name
    $cookieSession = $GLOBALS['nuked']['cookiename'] . '_sessId';
    $cookieTheme   = $GLOBALS['nuked']['cookiename'] . '_userTheme';
    $cookieLangue  = $GLOBALS['nuked']['cookiename'] . '_userLangue';
    $cookie_visit  = $GLOBALS['nuked']['cookiename'] . '_lastVisit';
    $cookie_admin  = $GLOBALS['nuked']['cookiename'] . '_adminSession';
    $cookieForum   = $GLOBALS['nuked']['cookiename'] . '_forumRead';
    $cookieUserId  = $GLOBALS['nuked']['cookiename'] . '_userId';
    $cookieCaptcha = $GLOBALS['nuked']['cookiename'] . '_captcha';
    
    // Get theme cookie of user if exists
    if  (isset($_COOKIE[$cookieTheme]) && $_COOKIE[$cookieTheme] != '') {
        $user_theme = $_COOKIE[$cookieTheme];
    }

    // Get language cookie of user if exists
    if (isset( $_COOKIE[$cookieLangue] ) && $_COOKIE[$cookieLangue] != '') {
        $user_langue = $_COOKIE[$cookieLangue];
    }

    // Check IP address user validity and get user IP
    if (isset($uip) && filter_var($uip, FILTER_VALIDATE_IP) !== FALSE) {
        $user_ip = $uip;
    } else {
        $user_ip = '';
    }
    
    // Prepares global vars of session
    $GLOBALS['lifetime']      = $lifetime;
    $GLOBALS['timesession']   = $timesession;
    $GLOBALS['timelimit']     = $timelimit;
    $GLOBALS['sessionlimit']  = $sessionlimit ;
    $GLOBALS['cookieSession'] = $cookieSession;
    $GLOBALS['cookieTheme']   = $cookieTheme;
    $GLOBALS['cookieLangue']  = $cookieLangue;
    $GLOBALS['cookieVisit']   = $cookie_visit ;
    $GLOBALS['cookieAdmin']   = $cookie_admin;
    $GLOBALS['cookieForum']   = $cookieForum ;
    $GLOBALS['cookieUserId']  = $cookieUserId;
    $GLOBALS['cookieCaptcha'] = $cookieCaptcha;
    $GLOBALS['time']          = $time;
    $GLOBALS['user_ip']       = $user_ip;
    $GLOBALS['userTheme']     = $userTheme;
    $GLOBALS['userLangue']    = $userLangue;
}


// debug($GLOBALS);exit;



//    session_name('nuked');
//    
//    // Starting the native PHP session
//    session_start();
//    
//    if (session_id() == '') {
//        exit(ERROR_SESSION);
//    }
//    $lifetime = $nuked['sess_days_limit'] * 86400;
//    $timesession = $nuked['sess_inactivemins'] * 60;
//    $time = time();
//    $timelimit = $time + $lifetime;
//    $sessionlimit = $time + $timesession;
//    
//    $cookieSession = $nuked['cookiename'] . '_sess_id';
//    $cookieTheme = $nuked['cookiename'] . '_user_theme';
//    $cookieLangue = $nuked['cookiename'] . '_user_langue';
//    $cookie_visit = $nuked['cookiename'] . '_last_visit';
//    $cookie_admin = $nuked['cookiename'] . '_admin_session';
//    $cookieForum = $nuked['cookiename'] . '_forum_read';
//    $cookieUserId = $nuked['cookiename'] . '_userid';
//
//    // Création d'un cookie captcha
//    $cookieCaptcha = $nuked['cookiename'] . '_captcha';
//    setcookie($cookieCaptcha, 1);
//
//    // Recherche de l'adresse IP
//    $uip = (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
//    
//    // Validité adresse IP v4 / v6
//    //if(isset($uip) && !empty($uip)) {
//    //    if(preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/', $uip)) $user_ip = $uip;
//    //    elseif(preg_match('/^(([A-Fa-f0-9]{1,4}:){7}[A-Fa-f0-9]{1,4})$|^([A-Fa-f0-9]{1,4}::([A-Fa-f0-9]{1,4}:){0,5}[A-Fa-f0-9]{1,4})$|^(([A-Fa-f0-9]{1,4}:){2}:([A-Fa-f0-9]{1,4}:){0,4}[A-Fa-f0-9]{1,4})$|^(([A-Fa-f0-9]{1,4}:){3}:([A-Fa-f0-9]{1,4}:){0,3}[A-Fa-f0-9]{1,4})$|^(([A-Fa-f0-9]{1,4}:){4}:([A-Fa-f0-9]{1,4}:){0,2}[A-Fa-f0-9]{1,4})$|^(([A-Fa-f0-9]{1,4}:){5}:([A-Fa-f0-9]{1,4}:){0,1}[A-Fa-f0-9]{1,4})$|^(([A-Fa-f0-9]{1,4}:){6}:[A-Fa-f0-9]{1,4})$/', $uip)) $user_ip = $uip;
//    //    else $user_ip = '';
//    //}




/**
 * Secure user data
 * @return array : Numeric indexed array of user data
 */
function secure(){
    global $nuked, $user_ip, $time, $cookieVisit, $cookieSession, $cookieUserId, $cookieForum, $sessionlimit, $timesession, $timelimit;

    $id_user = '';
    $user_type = 0;
    $user_name = '';
    $last_visite = 0;
    $nb_mess = 0;
    $id_de_session = '';

    if (isset($_COOKIE[$cookieSession]) && !empty($_COOKIE[$cookieSession]))
        $id_de_session = $_COOKIE[$cookieSession];
    if (isset($_COOKIE[$cookieUserId]) && !empty($_COOKIE[$cookieUserId]))
        $id_user = $_COOKIE[$cookieUserId];

    if ($id_de_session != null && $id_user != null) {
        $sql = mysql_query("SELECT created, ip, lastUsed FROM " . SESSIONS_TABLE . " WHERE id = '" . $id_de_session . "' AND userId = '" . $id_user . "'");
        $secu_user = mysql_num_rows($sql);
        $row = mysql_fetch_assoc($sql);
        if ($row['created'] > $time - $timesession && $row['ip'] != $user_ip)
            $secu_user = 0;
        if ($secu_user  == 1) {
            $last_used = $row['lastUsed'];
            $sql2 = mysql_query("SELECT level, pseudo FROM " . USER_TABLE . " WHERE id = '" . $id_user . "'");
            list($user_type, $user_name) = mysql_fetch_array($sql2);
            
            $last_visite = $last_used;
            
            $upd = mysql_query("UPDATE " . SESSIONS_TABLE . "  lastUsed = '" . $time . "' WHERE id = '" . $id_de_session . "'");

            if (isset($_REQUEST['file']) && isset($_REQUEST['thread_id']) && $_REQUEST['file'] == 'Forum' && is_numeric($_REQUEST['thread_id']) && $_REQUEST['thread_id'] > 0 && $secu_user > 0) {
                $select_thread = "SELECT MAX(id) FROM " . FORUM_MESSAGES_TABLE . " WHERE created > '" . $last_used . "' AND threadId = '" . $_REQUEST['thread_id'] . "' ";
                $sql_thread = mysql_query($select_thread);
                list($max_mess_id) = mysql_fetch_array($sql_thread);

                if ($max_mess_id > 0) {
                    if (isset($_REQUEST[$cookieForum]) && !empty($_REQUEST[$cookieForum])){
                        $id_read_forum = $_REQUEST[$cookieForum];
                        if (preg_match("`[^0-9,]`i", $id_read_forum)) $id_read_forum = '';
                        $table_read_forum = explode(',',$id_read_forum);
                        if (!in_array($max_mess_id, $table_read_forum)) setcookie($cookieForum, $id_read_forum.",".$max_mess_id, $timelimit);
                    }
                    else setcookie($cookieForum, $max_mess_id, $timelimit);
                }
            }
        }
        // Incorect session information
        else {
            mysql_query("DELETE FROM " . SESSIONS_TABLE . " WHERE id = '" . $id_de_session."'");
            mysql_query("DELETE FROM " . SESSIONS_TABLE . " WHERE userId = '" . $id_user . "'");
        }

    }
    //Not connected
    else {
        $secu_user = 0;
    }

    if ($secu_user == 1) {
        $sql_mess = mysql_query("SELECT id FROM " . USERBOX_TABLE . " WHERE userFor = '" . $id_user . "' AND status = 0");
        $nb_mess = mysql_num_rows($sql_mess);
        $user = array($id_user, $user_type, mysql_real_escape_string($user_name), $user_ip, $last_visite, $nb_mess);
    }
    else {
        $user = array();
    }
    return $user;
}

function admin_check() {
    return isset($_SESSION['admin']) && $_SESSION['admin'] == true ? 1 : 0;
}


function session_check() {
    global $nuked, $user_ip, $cookieSession, $time, $timesession;

    if (isset($_COOKIE[$cookieSession]) && !empty($_COOKIE[$cookieSession])) {
        $session = 1;
    }
    else {
        $id_de_session = '';
        $session = 0;
        $user = array();
    }
    return $session;
}

// initialise avec les microsecondes
function make_seed() {
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

function init_cookie() {
    global $cookieSession, $cookieUserId, $cookieTheme, $cookieLangue, $cookieForum, $cookieCaptcha;
    $test = setcookie($cookieSession, '');
    setcookie($cookieUserId, '');
    setcookie($cookieTheme, '');
    setcookie($cookieLangue, '');
    setcookie($cookieForum, '');
    setcookie($cookieCaptcha, 1);
    return($test);
}

function session_new($userid, $rememberMe) {
    global $nuked, $cookieSession, $cookieUserId, $cookieTheme, $cookieLangue, $cookieForum, $user_ip, $timelimit, $sessionlimit, $time;


    //On prend un ID de session unique
    do {
        $session_id = md5(uniqid());
    }
    while($sql = mysql_query('SELECT id FROM ' . SESSIONS_TABLE . 'WHERE id = \'' . $session_id . '\'') && mysql_num_rows($sql) != 0);

    $test = init_cookie();

    $upd = mysql_query("UPDATE " . SESSIONS_TABLE . " SET `id` = '" . $session_id . "', lastUsed = created, `created` =  '" . $time . "', `ip` = '" . $user_ip . "' WHERE userId = '" . $userid . "'");

    $ins = '';
    if (mysql_affected_rows() == 0) 
        $ins = mysql_query("INSERT INTO " . SESSIONS_TABLE . " ( `id` , `userId` , `created` , `ip` , `vars` ) VALUES( '" . $session_id . "' , '" . $userid . "' , '" . $time . "' , '" . $user_ip . "', '' )");
    
    if ($upd !== FALSE && $ins !== FALSE) {

        if ($rememberMe == "ok") {
            setcookie($cookieSession, $session_id, $timelimit);
            setcookie($cookieUserId, $userid, $timelimit);

        } else {
            setcookie($cookieSession, $session_id);
            setcookie($cookieUserId, $userid);
        }
    }
    else {
        mysql_query("DELETE FROM " . SESSIONS_TABLE . " WHERE `userId` = '" . $userid . "'");
    }
}
?>