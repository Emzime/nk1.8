<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK")){
	exit('You can\'t run this file alone.');
}



function affich_block_login($blok){
    global $user, $nuked;

    list($login, $messpv, $members, $online, $avatar) = explode('|', $blok['content']); 
    $blok['content'] = '<div class="nkBlockLogin">';
	$c = 0;	
	if($login != 'off'){
		if (!$user){
			$blok['content'] .= '<form action="index.php?file=User&amp;nuked_nude=index&amp;op=login" method="post">
									<div>
										<label for="BlockLoginPseudo">'.PSEUDO.' : </label>
											<input id="BlockLoginPseudo" class="nkInput" type="text" name="pseudo" size="10" maxlength="250" />
									</div>
									<div>
										<label for="BlockLoginPassword">'.PASSWORD.' : </label>
											<input id="BlockLoginPassword" class="nkInput" type="password" name="pass" size="10" maxlength="15" />
									</div>';																		
			$blok['content'] .= 	$GLOBALS['nkFunctions']->nkCheckBox('remember_me', 'Remember', 'BlockLoginRememberId', 'BlockLoginRemember nkWidthHalf', REMEMBERME, 'ok', true);
			$blok['content'] .= '		<input type="submit" class="nkButton" value="'.SEND.'" />										
									<nav>
										<small>
											<a href="index.php?file=User&amp;op=reg_screen">'.REGISTER.'</a>&nbsp;/&nbsp;
											<a href="index.php?file=User&amp;op=oubli_pass">'.PASSFORGET.' ?</a>
										</small>
									</nav>
								</form>';
		}
		else{
			$blok['content'] .= '
								<h4>'.WELCOME.', <small>'.$user[2].'</small></h4>';

								if ($avatar != 'off'){
									$sqlAvatar=mysql_query('SELECT avatar FROM ' . USER_TABLE . ' WHERE id = \'' . $user[0] . '\' ');
									list($avatarUrl) = mysql_fetch_array($sqlAvatar);

									if($avatarUrl){
										$blok['content'] .= '
										<figure>
											<img src="' . $avatarUrl . '" alt="' . $user[2] . ' avatar" />
										</figure>';
									}else{										
										$blok['content'] .= '
										<figure>
											<img src="images/noavatar.png" alt="" />
										</figure>';
									}
			}
			$blok['content'] .= '<nav>
									<a href="index.php?file=User" class="nkButtonLink">'.ACCOUNT.'</a> / <a href="index.php?file=User&amp;nuked_nude=index&amp;op=logout" class="nkButtonLink">'.LOGOUT.'</a>
								</nav>';
		}
		$c++;
	}

    if($messpv != 'off' && $user[0] != ''){
		if ($c > 0) $blok['content'] .= '<div class="nkSeparator" /></div>';
	
		$sqlMid = mysql_query('SELECT mid FROM ' . USERBOX_TABLE . ' WHERE user_for = \'' . $user[0] . '\' AND status = 1');
		$nbMessLu = mysql_num_rows($sqlMid);
	
		$blok['content'] .= '<h5>
								<span class="nkIconMail"></span>'.MESSPV.'
							</h5>
							<ul>';
	
		if ($user[5] > 0){
			$blok['content'] .= '<li>
									<span class="nkIconMailReceive"></span>'.NOTREAD.' : <a href="index.php?file=Userbox">'.$user[5].'</a>
								</li>';
		}
		else{
			$blok['content'] .= '<li>
									<span class="nkIconMailReceive"></span>'.NOTREAD.' : '.$user[5].'
								</li>';
		}
	
		if ($nbMessLu > 0){
			$blok['content'] .= '<li>
									<span class="nkIconMailLock"></span>'.READ.' : <a href="index.php?file=Userbox">'.$nbMessLu.'</a>
								</li>';
		}
		else{
			$blok['content'] .= '<li>
									<span class="nkIconMailLock"></span>'.READ.' : '.$nbMessLu.'
								</li>';
		}
	
		$blok['content'] .='</ul>';
		$c++;
    }

	if ($members != 'off'){
		if ($c > 0) $blok['content'] .= '<div class="nkSeparator" /></div>';

    	$blok['content'] .= '<h5>
    							<span class="nkIconMembers"></span>'.MEMBERS.'
							</h5>
							<ul>';

    	$sqlUsers = mysql_query('SELECT id FROM ' . USER_TABLE . ' WHERE niveau < 3');
    	$nbUsers = mysql_num_rows($sqlUsers);

    	$sqlAdmin = mysql_query('SELECT id FROM ' . USER_TABLE . ' WHERE niveau > 2');
    	$nbAdmin = mysql_num_rows($sqlAdmin);

    	$sqlLastMember = mysql_query('SELECT pseudo FROM ' . USER_TABLE . ' ORDER BY date DESC LIMIT 0, 1');
    	list($LastMember) = mysql_fetch_array($sqlLastMember);

    	$blok['content'] .= '<li>
								<span class="nkIconNext"></span>'.ADMINS.' : '.$nbAdmin.'
							</li>
							<li>
								<span class="nkIconNext"></span>'.MEMBERS.' : '.$nbUsers.' [ <a href="index.php?file=Members">'.LISTING.'</a> ]
							</li>
							<li>
								<span class="nkIconNext"></span>'.LASTMEMBER.' : <a href="index.php?file=Members&amp;op=detail&amp;autor='.urlencode($LastMember).'">'.$LastMember.'</a>
							</li>
						</ul>';

		 $c++;
	}

	if ($online != 'off'){
		if ($c > 0) $blok['content'] .= '<div class="nkSeparator" /></div>';

    	$blok['content'] .= '<h5>
								<span class="nkIconAutor"></span>'.WHOISONLINE.'
							</h5>
							<ul>';

						    	$nb = nbvisiteur();

						    	if ($nb[1] > 0){
									$userOnline = '<ul>';
									$sqlUserOnline = mysql_query('SELECT username FROM ' . NBCONNECTE_TABLE . ' WHERE type BETWEEN 1 AND 2 ORDER BY date');
									while (list($userOnlineName) = mysql_fetch_array($sqlUserOnline)){
										   $userOnline .= '<li>'.$userOnlineName.'</li>';
									}
									$userOnline .= '</ul>';
									// definition du tooltip

									$userList = $GLOBALS['nkFunctions']->nkTooltip($userOnline, '#', '[ '.LISTING.' ]');
								}
						    	else{
									$userList = '';
						    	}

								if ($nb[2] > 0){
									$adminOnline = '<ul>';
									$sqlAdminOnline = mysql_query('SELECT username FROM ' . NBCONNECTE_TABLE . ' WHERE type > 2 ORDER BY date');
									while (list($adminOnlineName) = mysql_fetch_array($sqlAdminOnline)){
										   $adminOnline .= '<li>'.$adminOnlineName.'</li>';
									}
									$adminOnline .= '</ul>';
									// definition du tooltip
									$adminList = $GLOBALS['nkFunctions']->nkTooltip($adminOnline, '#', '[ '.LISTING.' ]');

								}
								else{
									$adminList = '';
								}
	
		$blok['content'] .= '	<li>
									<span class="nkIconNext"></span>'.VISITOR;
									if ($nb[0] > 1) $blok['content'] .= 's';

		$blok['content'] .= ' : '.$nb[0].'</li>
								<li>
									<span class="nkIconNext"></span>'.MEMBER;
									if ($nb[1] > 1) $blok['content'] .= 's';

		$blok['content'] .= ' : ' . $nb[1] . ' ' . $userList . '
								</li>
								<li>
									<span class="nkIconNext"></span>'.ADMIN;
									if ($nb[2] > 1) $blok['content'] .= 's';

		$blok['content'] .= ' : ' . $nb[2] . ' ' . $adminList . '</li>
								</ul>';
	
		$c++;
   }
	$blok['content'] .= "</div>";
   return $blok;
}

function edit_block_login($bid){
    global $nuked, $language;

    $sqlBlock = mysql_query('SELECT active, position, titre, module, content, type, nivo, page FROM ' . BLOCK_TABLE . ' WHERE bid = \'' . $bid . '\' ');
    list($activeBlock, $positionBlock, $titleBlock, $modulBlockBlock, $contentBlock, $typeBlock, $nivoBlock, $pagesBlock) = mysql_fetch_array($sqlBlock);
    $titleBlock = printSecuTags($titleBlock);
    list($login, $messpv, $members, $online, $avatar) = explode('|', $contentBlock);

    if ($activeBlock == 1) $checked1 = 'selected="selected"';
    else if ($activeBlock == 2) $checked2 = 'selected="selected"';
    else $checked0 = 'selected="selected"';

    if ($login == 'off') $checked3 = 'selected="selected"'; else $checked3 = '';
    if ($messpv == 'off') $checked4 = 'selected="selected"'; else $checked4 = '';
    if ($members == 'off') $checked5 = 'selected="selected"'; else $checked5 = '';
    if ($online == 'off') $checked6 = 'selected="selected"'; else $checked6 = '';
	if ($avatar == 'off') $checked7 = 'selected="selected"'; else $checked7 = '';
	
	?>

        <header>
            <h3  class="width_3_quarter inline">
            <?php echo ADMINBLOCK; ?>
            </h3>
            <h4  class="width_quarter inline float-right align-right">
                <a href="help/<?php echo $language; ?>/block.php" rel="rightBox" data-name="<?php echo BLOCK; ?>"><img src="help/help.gif" alt="" title="<?php echo HELP; ?>" /></a>
            </h4>
        </header>
        <article class="padding-left padding-right margin-bottom margin-top">
			<form method="post" action="index.php?file=Admin&amp;page=block&amp;op=modif_block">
			<div class="nkBoxcontainer padding-left">
				<label for="blockLoginTitle" class="nkLabelSpacing"><?php echo TITLE; ?>&nbsp;:&nbsp;</label>
					<input id="blockLoginTitle" type="text" name="titre" size="40" value="<?php echo $titleBlock; ?>" />
			</div>
			<?php
			/*** Position Options ***/
			$activeBlockValue = array(
	                0 => LEFT,
	                1 => RIGHT,
	                2 => OFF
	            );
			echo $GLOBALS['nkFunctions']->nkRadioBox('active', 'nkLabelSpacing', BLOCK, 3, $activeBlockValue, 'InputForactive', 'InputIdactive')

			?>

			<div class="nkBoxcontainer padding-left">
				<label for="blockLoginPosition" class="nkLabelSpacing"><?php echo POSITION; ?> : </label>
					<input id="blockLoginPosition" type="text" name="position" size="2" value="<?php echo $positionBlock; ?>" />
			</div>

			<div class="nkBoxcontainer padding-left">
				<label for="nivo" class="nkLabelSpacing"><?php echo LEVEL; ?>&nbsp;:&nbsp;</label>
					<?php 
					echo $GLOBALS['nkFunctions']->nkLevelSelect('nivo', $nivoBlock);
					?>
			</div>
			<?php 
			/*** Login options ***/
			$loginValue = array(
					ON => YES,
					OFF => NO
	            );
			echo $GLOBALS['nkFunctions']->nkRadioBox('login', 'nkLabelSpacing', LOGIN.'&nbsp;:&nbsp;', 2, $loginValue, 'blockLoginLoginId');
				
			/*** Private message options ***/	
			$messpvValue = array(
					ON => YES,
					OFF => NO
	            );			
			echo $GLOBALS['nkFunctions']->nkRadioBox('messpv', 'nkLabelSpacing', MESSPV.'&nbsp;:&nbsp;', 2, $messpvValue, 'blockLoginmesspvId');

			/*** Members options ***/
			$membersValue = array(
					ON => YES,
					OFF => NO
	            );
			echo $GLOBALS['nkFunctions']->nkRadioBox('members', 'nkLabelSpacing', MEMBERS.'&nbsp;:&nbsp;', 2, $membersValue, 'blockLoginmembersId');
				
			/*** Online options ***/
			$onlineValue = array(
					ON => YES,
					OFF => NO
	            );
			echo $GLOBALS['nkFunctions']->nkRadioBox('online', 'nkLabelSpacing', WHOISONLINE.'&nbsp;:&nbsp;', 2, $onlineValue, 'blockLoginonlineId');
				
			/*** Avatar options ***/
			$avatarValue = array(
					ON => YES,
					OFF => NO
	            );
			echo $GLOBALS['nkFunctions']->nkRadioBox('avatar', 'nkLabelSpacing', SHOWAVATAR.'&nbsp;:&nbsp;', 2, $avatarValue, 'blockLoginavatarId');			
			?>
			<div class="nkBoxcontainer padding-left">
				<label for="blockLoginPages" class="nkLabelSpacing valign-top"><?php echo PAGESELECT; ?>&nbsp;:&nbsp;</label>
					<select id="blockLoginPages" class="margin-top" name="pages[]" size="8" multiple="multiple">
						<?php
						select_mod2($pagesBlock);
						?>
					</select>
			</div>
			<div class="width_quarter align-center margin-top padding-bottom">
				<input type="hidden" name="type" value="<?php echo $typeBlock; ?>" />
				<input type="hidden" name="bid" value="<?php echo $bid; ?>" />
				<input type="submit" name="send" class="nkButton" value="<?php echo SEND; ?>" />
			</div>
		</article>
	<?php
}

?>