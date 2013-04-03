$(document).ready(function() {
    // lien du menu profil
    $('.siteAvatar img').each(function() {
        var avatarLink = $(this).attr("src");
        $(this).click(function(event) {
            opener.document.getElementById('editPhoto').value=avatarLink;
        });
    });
});