function changeCSSsheet(selector, property, value) {
    for (var i=0; i < document.styleSheets.length;i++) { //Loop through all styles
        //Try add rule
        try { document.styleSheets[i].insertRule(selector+ ' {'+property+':'+value+'}', document.styleSheets[i].cssRules.length);
        } catch(err) {try { document.styleSheets[i].addRule(selector, property+':'+value);} catch(err) {}}//IE
    }
}

var cw = $('.photo_admin').width();
$('.photo_admin').css({'height':cw+'px'});
changeCSSsheet('.photo_admin', 'height', cw+'px');
var cw = $('.story_img_admin').width() * 0.5;
$('.story_img_admin').css({'height': cw+'px'});
changeCSSsheet('.story_img_admin', 'height', cw+'px');
$(window).resize(function() {
	var cw = $('.photo_admin').width();
	$('.photo_admin').css({'height':cw+'px'});
	changeCSSsheet('.photo_admin', 'height', cw+'px');
  	var cw = $('.story_img_admin').width() * 0.5;
	$('.story_img_admin').css({'height': cw+'px'});
	changeCSSsheet('.story_img_admin', 'height', cw+'px');
});




function areYouSureDeleteStory(path) {
	if (confirm('Seguro que desea suprimir esta historia ?')) {
		window.location = path;
	}
}

function areYouSureDeletePhoto(path) {
	if (confirm('Seguro que desea suprimir esta foto ?')) {
		window.location = path;
	}
}

