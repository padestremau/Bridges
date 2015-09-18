// -------------------------------------------   Ajax load function - Mission Andina  -----------------------------------------------

function displaySelectedArticle(path_chosen, id_toSet_active)
{
	$('#article_content').fadeOut('slow',loadContent);
	var toLoad = path_chosen +' #article_content';

	function loadContent() {
		$('#article_content').load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#article_content').fadeIn('slow');

				$('.article_link').attr('class', 'article_link');
				document.getElementById(id_toSet_active).className = "article_link li_article_active";
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

function displaySelectedVideo(path_chosen, id_content, id_toSet_active)
{
	var id_content_toLoad = '#'+id_content;
	$(id_content_toLoad).fadeOut('slow',loadContent);

	var toLoad = path_chosen +' '+id_content_toLoad;

	function loadContent() {
		$(id_content_toLoad).load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$(id_content_toLoad).fadeIn('slow');

				$('.video_link').attr('class', 'video_link');
				document.getElementById(id_toSet_active).className = "video_link li_video_active";
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


function displaySelectedElement(path_chosen, id_toSet_active)
{
	$('#element_content').fadeOut('slow',loadContent);
	var toLoad = path_chosen +' #element_content';

	function loadContent() {
		$('#element_content').load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#element_content').fadeIn('slow');

				$('.element_link').attr('class', 'element_link');
				document.getElementById(id_toSet_active).className = "element_link li_element_active";
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


function displaySelectedPage(path_chosen, id_toSet_active)
{
	$('#page_content_content').fadeOut('slow',loadContent);
	var toLoad = path_chosen +' #page_content_content';

	function loadContent() {
		$('#page_content_content').load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#page_content_content').fadeIn('slow');

				$('.page_link').attr('class', 'page_link');
				document.getElementById(id_toSet_active).className = "page_link li_page_active";
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

function displaySelectedAide(path_chosen, id_toSet_active)
{
	$('#aide_content').fadeOut('slow',loadContent);
	var toLoad = path_chosen +' #aide_content';

	function loadContent() {
		$('#aide_content').load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#aide_content').fadeIn('slow');

				$('.aide_link').attr('class', 'aide_link');
				document.getElementById(id_toSet_active).className = "aide_link li_aide_active";
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

function displaySelectedPartner(path_chosen, id_toSet_active)
{
	$('#partner_content').fadeOut('slow',loadContent);
	var toLoad = path_chosen +' #partner_content';

	function loadContent() {
		$('#partner_content').load(toLoad,'',function(responseTxt, statusTxt, xhr) {
			if(statusTxt == "success") {
				$('#partner_content').fadeIn('slow');

				$('.partner_link').attr('class', 'partner_link');
				document.getElementById(id_toSet_active).className = "partner_link li_partner_active";
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