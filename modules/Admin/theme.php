<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}
global $user, $language;
include("modules/Admin/design.php");
if (!$user)
{
    $visiteur = 0;
}
else
{
    $visiteur = $user[1];
}

if ($visiteur == 9)
{
    function main()
    {
        global $user, $nuked;
        if(file_exists("themes/".$nuked['theme']."/admin.php"))
        {
        
            echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . GESTEMPLATE . "</h3>\n"
    . "</div>\n"
    . "<div class=\"tab-content\" id=\"tab2\">\n";
        
            include("themes/".$nuked['theme']."/admin.php");
            echo "</div>";
        }
        else
        {
        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . GESTEMPLATE . "</h3>\n"
    . "</div>\n"
    . "<div class=\"tab-content\" id=\"tab2\">\n";
        ?>
            <div class="notification error png_bg">
                <div>
                    <?php echo NOADMININTERNE; ?>
                </div>
            </div>
            </div>
        <?php
        }
    }
    switch ($_REQUEST['op'])
    {
        case "main":
    admintop();
        main();
    adminfoot();
        break;
        default:
    admintop();
        main();
    adminfoot();
        break;
    }

}
else if ($visiteur > 1)
{
    admintop();
    echo "<div class=\"notification error png_bg\">\n"
    . "<div>\n"
    . "<br /><br /><div style=\"text-align: center;\">" . NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . BACK . "</b></a></div><br /><br />"
    . "</div>\n"
    . "</div>\n";
    adminfoot();
}
else
{
    admintop();
    echo "<div class=\"notification error png_bg\">\n"
    . "<div>\n"
    . "<br /><br /><div style=\"text-align: center;\">" . ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . BACK . "</b></a></div><br /><br />"
    . "</div>\n"
    . "</div>\n";
    adminfoot();
}
?>
