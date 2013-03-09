<?php

    defined('INDEX_CHECK') or die ('<div style="text-align: center;">Access deny</div>');  

    $linkPartners  = '';
    $activePartners = $activePartners;
    $nbPartners = count($partnersName);
    for($i= 0; $i < $nbPartners; $i++) {
        $linkPartners .= '<li class="backgroundPartner"><a title="'.$partnersLink[$i].'" href="'.$partnersLink[$i].'" target="_blank"><img src="media/template/'.$theme.'/images/partners/'.$partnersName[$i].'" title="'.$partnersLink[$i].'" alt="'.$partnersLink[$i].'" /></a></li>';
    }

    if ($activeWars == 0 && $activePartners == 1) {
        $blokTitle = '  <header id="headerUnikWars"><h3 class="nkInlineBlock nkValignTop nkNoMargin">'.PARTNERS.'</h3></header>';
    } else {
        $blokTitle = '  <header class="headerBlockRight">'.PARTNERS.'</header>';
    }

        
    $htmlPartners = '<section>'.$blokTitle.'
                        <nav class="UnikPartners">
                            <ul>
                                '.$linkPartners.'
                            </ul>
                        </nav>
                    </section>';
?>