$(document).ready(function() {
    $('#editCountry').change(function(){
        isoCountry = $('#editCountry option:selected').data('iso');
        changeLang(isoCountry);
        // On supprime les options obsolètes
        $('#editLang').children().each(function(){
            $(this).remove(); 
        });
        lengthLang = arrayCountry[isoCountry].length;
        for(i=0;i<lengthLang;i++){
            $(document.createElement('option')).val(arrayCountry[isoCountry][i]).html(arrayCountry[isoCountry][i]).appendTo($('#editLang'));
        }
    });
    
});

function changeLang(flag) {
    $('#viewFlags').removeClass();
    $('#viewFlags').addClass("nkFlags" + flag);
}