$(document).ready(function() {
	$("#slideshow").css("overflow", "hidden");
	
	$("ul#slides").cycle({
		fx: 'fade',
		pause: 1,
		prev: '#prev',
		next: '#next'
	});
	
	$("#slideshow").hover(function() {
    	$("ul#nav").fadeIn();
  	},
  		function() {
    	$("ul#nav").fadeOut();
  	});

});
$(document).ready(function() {
    $("#slideshowTwo").css("overflow", "hidden");

    $("ul#slidesTwo").cycle({
        fx: 'fade',
        pause: 1,
        prev: '#prevTwo',
        next: '#nextTwo'
    });

    $("#slideshowTwo").hover(function() {
        $("ul#navTwo").fadeIn();
    },
  		function() {
  		    $("ul#navTwo").fadeOut();
  		});

});