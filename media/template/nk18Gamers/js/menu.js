/* Affichage du sous menu */
$(document).ready(function() {    
    $('#RL_mainNav a').each(function() {
        var subMenu = $(this).data('menu');
        $(this).click(function(event) {
            if($(this).attr("href") == '#') {

                event.preventDefault();
            }
            $(this).each(function() {
                $(this).parent().siblings().removeClass("currentClass");
            });
            $("[class^=nkMenu]").each(function() {
                if($(this).hasClass("nkInlineBlock")) {
                    $(this).removeClass("nkInlineBlock");
                }
            });
            $(this).parent().addClass("currentClass");
            $("."+ subMenu).addClass("nkInlineBlock");
        });
    });
});