$(document).ready(function(){
	$("[data-api=tooltip]").each(function() {
		// définition des data pour la récupération des données de configuration
		var $this 		= $(this);
		var placement 	= $this.data("placement");
		var alignement 	= $this.data("alignement");
		var content 	= $this.data("content");
		var textColor 	= $this.data("textColor");
		var themeUse 	= $this.data("themeUse");
		// Vérification de l'existance des data sinon application d'un theme par defaut
		if (typeof placement === "undefined" ) {
			placement = "left";
		};
		if (typeof alignement === "undefined" ) {
			alignement = "center";
		};
		if (typeof content === "undefined" ) {
			content = "Le texte de la tooltip est absent";
		};
		if (typeof textColor === "undefined" ) {
			textColor = "";
		};
		if (typeof themeUse === "undefined" ) {
			themeUse = "all-black";
		};
		// Création du tooltip
		$this.CreateBubblePopup({
			themeMargins : {
				total: '13px',
				difference: '0px'
			},
			divStyle : {
				'z-index': '250'
			},
			position : placement,
			align : alignement,
			innerHtml : content,
			innerHtmlStyle: {
			color: textColor
		},
		themeName: themeUse,
		themePath: "images/tooltip-themes"
		});
	});
});