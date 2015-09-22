// -------------------------------------------   Ajax load function - Mission Andina  -----------------------------------------------

function displaySelectedPage(path_chosen, id_toSet_active)
{
	$('#pageShow_content').fadeOut('slow',loadContent);
	var toLoad = path_chosen +' #pageShow_content';

	function loadContent() {
		$('#pageShow_content').load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#pageShow_content').fadeIn('slow');

				$('.pageShow_link').attr('class', 'pageShow_link');
				document.getElementById(id_toSet_active).className = "pageShow_link li_pageShow_active";
			}
			else {
	            alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});
	}

	//to change the browser URL to 'path_chosen'
    if(path_chosen!=window.location){
        window.history.pushState({path:path_chosen},'',path_chosen);    
    }

	return false;
}



function loadContentAdmin(path_chosen)
{
	$('#section_admin').fadeOut('slow',loadContent);

	function loadContent() {
		document.getElementById('section_admin').innerHTML = '';
		var toLoad = path_chosen +' #section_admin';
		var headerChange = path_chosen +' #nav_admin';
		$('#section_admin').load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#section_admin').fadeIn('slow');
			}
			else {
	            alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});
		$('#nav_admin').load(headerChange,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#nav_admin').fadeIn('slow');
			}
			else {
	            alert("Error: " + xhr.status + ": " + xhr.statusText);
			}
		});
	}

	//to change the browser URL to 'path_chosen'
    if(path_chosen!=window.location){
        window.history.pushState({path:path_chosen},'',path_chosen);    
    }

	return false;
}