$(document).ready(function() {
    // On boucle sur tous les selects de pays
    $('.editCountry').each(function() {
        // On détecte un changement sur un select
        $(this).change(function() {
            // On initialise les options du select de langues
            $(this).next().children('.editLang').children('option').each(function() {
                $(this).remove();
            });
            // on récupère l'iso code de l'option sélectionnée
            isoCountry = $("option:selected", this).data('iso');

            // on se place sur le select
            element = $(this).prev();
            // on parcours les class des options
            classes = element.attr('class').split(/\s+/);
            // on cherche celle qui contient l'attribut choisi
            pattern = /^nkFlags/;
            // on attribut un chiffre virtuelle
            for(i = 0; i < classes.length; i++) {
                className = classes[i];
                if(className.match(pattern)) {
                    // on supprime la classe choisi
                    element.removeClass(className);
                }
            }
            // on ajoute la nouvelle classe
            element.addClass('nkFlags' +isoCountry);
            // on compte le nombre de langue pour créer les options
            lengthLang = arrayCountry[isoCountry].length;
            // on initilise le compteur
            count = 0;
            for(i=0;i<lengthLang;i++) {
                // on crée les options de langues
                $(document.createElement('option')).val(arrayCountry[isoCountry][i]).html(arrayCountry[isoCountry][i]).appendTo($('.editLang'));
                count++;
            }
            // si le bouton submit est présent et que le compteur est a 1 on effectue l'envoi par le bouton
            if($(this).data('submit') == 1 && count == 1) {
                $(this).parents('form:first').submit();
            }
        });
    });
    $('.editLang').change(function() {
        // si le data est egal a 1 on fait l'envoi par onChange
        if($(this).data('submit') == '1') {
            $(this).parents('form:first').submit();
        }         
    });
    $('.editLang').each(function() {
        // le data egal a 2 on génèle le bouton et le contenu du language
        if($(this).data('submit') == '2') {
            // si la valeur de la langue contient un élément, on affiche celui ci sur le bouton
            if(buttonLang == '') {
                buttonLang = 'Submit';
            }
            // on crée le bouton et la valeur du bouton
            $(document.createElement('input')).addClass('nkButton').attr('type', 'submit').val(buttonLang).appendTo($(this).parent());
        }
    });
});
