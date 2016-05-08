<script type='text/javascript'>

var isMobile = {
    Android: function() {
	    return navigator.userAgent.match(/Android/i);
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
		},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},  
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
		},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i);
		},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}

};


$(document).ready(function() {


//		$('head').append('<link rel="stylesheet" type="text/css" href="css/new_euro.css" />');

	//window.alert(isMobile.any());
		if(isMobile.any()){
		$('head').append('<link rel="stylesheet" type="text/css" href="css/mobile_large_portrait.css" " />');
		$('head').append('<link rel="stylesheet" type="text/css" href="css/styles.css" " />');
		$('head').append('<script href="js/script.css" />');
	}
	else{
		$("head").append("<link rel='stylesheet' type='text/css' href='css/menu.css' />");
		$('head').append('<link rel="stylesheet" type="text/css" href="css/new_euro.css" />');
	}

});

</script>

