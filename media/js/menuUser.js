$(document).ready(function() {
    // lien du menu profil
    $('#menuProfil a').each(function() {
        var linkId = $(this).attr("href");
        $(this).click(function(event) {
            event.preventDefault();
            $(this).each(function() {
                $(this).parent().siblings().removeClass("active");
            });

            $("#"+ linkId).each(function() {
                $(this).siblings().removeClass("nkBlock");
                $(this).siblings().addClass("nkNone");
                if($("#"+ linkId).hasClass("nkNone")) {
                    $(this).removeClass("nkNone");
                    $(this).addClass("nkBlock");
                }
            });
            $(this).parent().addClass("active");
        });
    });

    // lien sur les href des statistiques
    $('.link').each(function() {
        var menuLink = $(this).attr("href");
        $(this).click(function(event) {
            event.preventDefault();
            $('#menuProfil a').each(function() {
                $(this).parent().removeClass("active");
            });

            $("#"+ menuLink).each(function() {
                $(this).siblings().removeClass("nkBlock");
                $(this).siblings().addClass("nkNone");
                if($("#"+ menuLink).hasClass("nkNone")) {
                    $(this).removeClass("nkNone");
                    $(this).addClass("nkBlock");
                }
            });
            $('#menuProfil a').each(function() {
                var profilLink = $(this).attr("href");
                if (menuLink == profilLink ) {
                     $(this).parent().addClass("active");
                };
            });                
        });
    });
});