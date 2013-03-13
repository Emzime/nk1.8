<?php

    defined('INDEX_CHECK') or die ('<div style="text-align: center;">Access deny</div>');  

    $dbsWars = 'SELECT wt.id, wt.team, wt.paysTeam, wt.paysAdversary, wt.adversary, wt.urlAdversary, wt.tscoreTeam, wt.tscoreAdversary, wt.report, gt.name, gt.icon, tt.title 
                FROM '.WARS_TABLE.' AS wt
                LEFT JOIN '.GAMES_TABLE.' AS gt ON gt.id = wt.game
                LEFT JOIN '.TEAM_TABLE.' AS tt ON wt.team = tt.id
                WHERE wt.status = 1 
                ORDER BY wt.createdYear, wt.createdMonth, wt.createdDay DESC LIMIT '.$nbResultWars;
    $dbeWars = mysql_query($dbsWars);
    $dbcWars = mysql_num_rows($dbeWars);

    $returnResults = '';
    $buttonTous  = '';
    if ($dbcWars > 0) {
        $buttonTous = ' <nav class="backgroundTous nkInlineBlock"><a href="index.php?file=Wars" title="'.SEEALL.'" >
                            <img src="images/pixel.gif" width="53" height="15" alt="" /></a>
                        </nav>';
        while (list($id, $teamId, $countryTeam, $countryAdversary, $adversary, $urlAdversary, $scoreTeam, $scoreAdversary, $gameReport, $gameName, $gameIcon, $teamName) = mysql_fetch_array($dbeWars)) {

            $countryTeams = strtoupper(substr($countryTeam, 0, 2));
            $countryAdversarys = strtoupper(substr($countryAdversary, 0, 2));
            $teamName = strtoupper($teamName);
            $adversary = strtoupper($adversary);
            $gameReports = $GLOBALS['nkFunctions']->nkCutText($gameReport, '82');

            if ($scoreTeam > $scoreAdversary) {
                $colorWar = 'scoreColorWin';
            } elseif ($scoreTeam < $scoreAdversary) {
                $colorWar = 'scoreColorLoose';
            } else {
                $colorWar = 'scoreColorEqual';
            }

            $returnResults .= '  <li class="backgroundUnikWars">
                                    <div class="unikWarsGame nkInlineBlock nkAlignCenter">
                                        <a href="index.php?file=Team&amp;cid='.$teamId.'"><img class="nkValignMiddle" src="'.$gameIcon.'" alt="'.SEETEAM.'&nbsp;'.$gameName.'" title="'.SEETEAM.'&nbsp;'.$gameName.'" /></a>
                                    </div>
                                    <div class="nkInlineBlock nkValignTop nkSize12 unikWarsContent">
                                        <span class="nkFlags'.$countryTeams.'" title="'.$countryTeam.'"></span>  
                                        <a href="index.php?file=Team&amp;op=detail&amp;autor='.$teamName.'" title="'.SEETEAM.'&nbsp;'.$teamName.'">                                         
                                            <span class="nkValignMiddle teamNameColor">'.$teamName.'</span>
                                        </a>
                                        &nbsp;|&nbsp;
                                        <span class="nkFlags'.$countryAdversarys.'" title="'.$countryAdversary.'"></span>                                            
                                            <a href="'.$urlAdversary.'" title="'.SEEURLADVERSARY.'&nbsp;'.$adversary.'">
                                                <span class="nkValignMiddle adversaryNameColor">'.$adversary.'</span>
                                            </a>
                                        <div class="gameReport">
                                            <a href="index.php?file=Wars&amp;op=detail&amp;war_id='.$id.'" title="'.SEEWARS.'">
                                                <span class="nkIconAttachment" title="'.SEEWARS.'"></span>   
                                            </a>
                                            '.$gameReports.'
                                        </div>
                                    </div>
                                    <div class="nkInlineBlock nkAlignCenter unikWarsResults">
                                        <span class="nkInlineBlock nkAlignCenter '.$colorWar.'">'.$scoreTeam.'&nbsp;-&nbsp;'.$scoreAdversary.'</span>
                                    </div>
                                </li>';
        }
    } else {
        $returnResults = '<li class="backgroundUnikWarsNo nkAlignCenter">'.NOMATCH.'</li>';
    }
    $htmlWars = '<section>
                    <header id="headerUnikWars">
                        <h3 class="nkInlineBlock nkNoMargin nkValignTop">'.WARS.'</h3>
                        '.$buttonTous.'
                    </header>
                    <nav class="resultUnikWars nkInlineBlock">
                        <ul>
                            '.$returnResults.'
                        </ul>
                    </nav>
                </section>';
?>