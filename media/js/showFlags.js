$(document).ready(function() {
    var flag = $('#editCountry option:selected').data('iso');
    changeLang(flag);
    $('#editCountry').change(function(event) {
        event.preventDefault();
        $('.nkLang' + flag).addClass('nkNone').removeClass('nkInlineBlock');
        flag = $('#editCountry option:selected').data('iso');
        changeLang(flag);
        $('#editLang option:selected').each(function() {
            var language = $('#editCountry option:selected').data('lang');
            $(this).removeAttr('selected');
            $("select option[value=" + language + "]").attr("selected","selected");
        });
    });
});

function changeLang(flag){
    $('#viewFlags').removeClass();
    $('#viewFlags').addClass("nkFlags" + flag + " nkInlineBlock");
    $('.nkLang' + flag).removeClass('nkNone').addClass('nkInlineBlock');
}