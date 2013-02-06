$(document).ready(function(){
	$('[data-api=tooltip]').each(function() {
		// définition des data pour la récupération des données de configuration
		var $this 			= $(this);
		var placement 		= $this.data('placement');
		var contentUse 		= $this.data('content');
		var themeUse 		= $this.data('themeuse');
		var animationUse 	= $this.data('animation');
		var maxWidth		= $this.data('maxwidth');
		var arrowColorUse	= $this.data('arrowcolor');

		// Vérification de l'existance des data sinon application d'un theme par defaut
		if (typeof placement === 'undefined' ) {
			placement = 'left';
		};

		if (typeof contentUse === 'undefined' ) {
			contentUse = 'Le texte de la tooltip est absent';
		};

		if (typeof themeUse === 'undefined' ) {
			themeUse = 'tooltipster-nk';
		};

		if (typeof animationUse === 'undefined' ) {
			animationUse = 'fade';
		};

		if (typeof maxWidth === 'undefined' ) {
			maxWidth = 0;
		};

		if (typeof arrowColorUse === 'undefined') {
			arrowColorUse = '';
		};

		// Création du tooltip
		$(this).tooltipster({
			position: placement,
			content: contentUse,
			theme: '.'+themeUse,
			animation: animationUse,
			maxWidth: maxWidth,
			interactive: true,
			arrowColor: arrowColorUse
		});
	});
});