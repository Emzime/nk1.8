<?php

    defined('INDEX_CHECK') or die ('<div style="text-align: center;">Access deny</div>');  

    $footerMenu = '';
    $nbMenu = count($menuName);
    for($i= 0; $i < $nbMenu; $i++) {
        if ($activeUpperCase == 1) {
            $menuToUpper[$i] = strtoupper($menuName[$i]);
            $footerMenu .= '<li class="nkInline menuFooter"><a title="'.$menuName[$i].'" href="'.$menuLink[$i].'">'.$menuToUpper[$i].'</a></li>';
        } else {        
            $footerMenu .= '<li class="nkInline menuFooter"><a title="'.$menuName[$i].'" href="'.$menuLink[$i].'">'.$menuName[$i].'</a></li>';
        }  
    }

    $linkMenu = '';
    $linkSubMenu = '';
    $nbMenu = count($menuName);
    for($i= 0; $i < $nbMenu; $i++) {
        $link = parse_url($menuLink[$i]);
        $block ='';        
        if (!empty($_SERVER['QUERY_STRING'])) {
            $parts = explode("&", $_SERVER['QUERY_STRING']);
        }else {
            $parts[0] = 'file='.$GLOBALS['nuked']['index_site'];
        }

        if(!isset($link['query'])) {
            $link['query'] = 'file='.$GLOBALS['nuked']['index_site'];
        }

        if ($parts[0] == $link['query']) {
            $currentClass = 'currentClass';
        } else {
            $currentClass = '';
        }

        if (isset($menuSubName[$i])) {
            $menuLink[$i] = '#';
        }

        if (isset($menuSubLink[$i])) {
            foreach ($menuSubLink[$i] as $key => $value) {
                $sublk = parse_url($value);            
                if(!isset($sublk['query'])) {
                    $sublk['query'] = 'file='.$GLOBALS['nuked']['index_site'];
                }
                if ($sublk['query'] == $parts[0]) {
                    $block = 'nkInlineBlock';
                    $currentClass = 'currentClass';
                }
            }
        }

        if ($activeUpperCase == 1) {
            $menuToUpper[$i] = strtoupper($menuName[$i]);
            $linkMenu .= '<li class="menuCenter nkInlineBlock nkSize12 '.$currentClass.'"><a class="nkAlignCenter nkBlock" data-menu="nkMenu'.$menuName[$i].'" title="'.$menuName[$i].'" href="'.$menuLink[$i].'">'.$menuToUpper[$i].'</a></li>';
        } else {        
            $linkMenu .= '<li class="menuCenter nkInlineBlock nkSize12 '.$currentClass.'"><a class="nkAlignCenter nkBlock" data-menu="nkMenu'.$menuName[$i].'" title="'.$menuName[$i].'" href="'.$menuLink[$i].'">'.$menuName[$i].'</a></li>';
        }  

        if (isset($menuSubName[$i])) {
            $nbSubMenu = count($menuSubName[$i]);
            $linkSubMenu .= '<ul class="nkMenu'.$menuName[$i].' '.$block.' RL_mainSubMenu">';
            for($j= 0; $j < $nbSubMenu; $j++) {
                $parseSublink = parse_url($menuSubLink[$i][$j]);
                if(!isset($parseSublink['query'])) {
                    $parseSublink['query'] = 'file='.$GLOBALS['nuked']['index_site'];
                }
                if ($parseSublink['query'] == $parts[0]) {
                    $currentSubClass = 'currentSubClass';
                } else {
                    $currentSubClass = '';
                }
                if ($activeUpperCase == 1) {
                    $subMenuToUpper[$i][$j] = strtoupper($menuSubName[$i][$j]);
                    $linkSubMenu .= '<li class="subMenuCenter nkInlineBlock '.$currentSubClass.'"><a class="nkAlignCenter nkBlock" title="'.$menuSubName[$i][$j].'" href="'.$menuSubLink[$i][$j].'">'.$subMenuToUpper[$i][$j].'</a></li>';
                } else {        
                    $linkSubMenu .= '<li class="subMenuCenter nkInlineBlock '.$currentSubClass.'"><a class="nkAlignCenter nkBlock" title="'.$menuSubName[$i][$j].'" href="'.$menuSubLink[$i][$j].'">'.$menuSubName[$i][$j].'</a></li>';
                }                
            }
            $linkSubMenu .= '</ul>';
        }
    }
?>