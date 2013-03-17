$(document).ready(function() {
    var flag = $('#editCountry option:selected').data('iso');
    changeLang(flag);
    $('#editCountry').change(function(event) {
        event.preventDefault();
        $('.nkLang' + flag).addClass('nkNone').removeClass('nkInlineBlock');
        flag = $('#editCountry option:selected').data('iso');
        changeLang(flag);
    });
});

function changeLang(flag) {
    $('#viewFlags').removeClass();
    $('#viewFlags').addClass("nkFlags" + flag + " nkInlineBlock");
    $('.nkLang' + flag).removeClass('nkNone').addClass('nkInlineBlock');
}