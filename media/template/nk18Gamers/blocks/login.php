<?php

    defined('INDEX_CHECK') or die ('<div style="text-align: center;">Access deny</div>');
      

    if (!$user) {
    ?>
        <nav id="RL_mainLogin" class="nkInlineBlock nkValignTop nkSize12">
            <ul class="ulLogin nkinlineBlock nkAlignCenter">
                <li class="nkInline nkSize12 loginCenter">
                    <a class="loginInput" href="index.php?file=User&amp;op=loginScreen"><?php echo TOLOG; ?></a>
                </li>
                <li class="nkInline nkSize12 loginCenter">
                    <a class="loginInput" href="index.php?file=User&amp;op=regScreen"><?php echo REGISTRER; ?></a>
                </li>
            </ul>
        </nav>
    <?php
    } else {

        $dbsNbCount = ' SELECT id 
                        FROM '.USERBOX_TABLE.' 
                        WHERE userFor = "'.$user[0].'" 
                        AND status = 0';
        $dbeNbCount = mysql_query($dbsNbCount);
        $dbcNbCount = mysql_num_rows($dbeNbCount);

        if ($dbcNbCount > 0) {
            $mess = '<a href="index.php?File=Usebox" title="'.SEEMP.'"><span id="mpIn" class="nkIcon24MailReceive nkNoMargin"></span></a>';
        }
        else{
            $mess = '<span id="mp" class="nkIcon24Mail nkNoMargin" title="'.NOMP.'"></span>';
        }

        if ($user[1] >= 2) {
            $adm = '<span id="mp" class="nkIcon24Admin nkNoMargin marg" title="'.ACCESADMIN.'"></span>';
        } else {
            $adm = '';
        }

        $logOut  = '<a href="index.php?file=User&amp;nuked_nude=index&amp;op=logout"><span id="mp" class="nkIcon24LogOut nkNoMargin marg" title="'.LOGOUTME.'"></span></a>';
        $account = '<a href="index.php?file=User"><span id="mp" class="nkIcon24Home nkNoMargin marg" title="'.ACCESMYACCOUNT.'"></span></a>';
    ?>
        <span id="RL_mainLogin" class="nkInlineBlock nkValignTop nkSize14">
            <?php 
                echo WELCOME.'&nbsp;'.$user[2].'
                    &nbsp;-&nbsp;
                    '.$mess.'
                    '.$account.'
                    '.$logOut.'
                    '.$adm;
            ?>
        </span>
    <?php
    }
?>
