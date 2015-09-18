// -------------------------------------------   Start scripts function - Mission Andina  -----------------------------------------------

  // On load
  function onLoadData() {
    // Top button
    document.getElementById("button_to_top").className = "opacity0";
  }

  // Auto risize textareas
  $(function() {
    //  changes mouse cursor when highlighting loawer right of box
    $("textarea").mousemove(function(e) {
        var myPos = $(this).offset();
        myPos.bottom = $(this).offset().top + $(this).outerHeight();
        myPos.right = $(this).offset().left + $(this).outerWidth();
        
        if (myPos.bottom > e.pageY && e.pageY > myPos.bottom - 16 && myPos.right > e.pageX && e.pageX > myPos.right - 16) {
            $(this).css({ cursor: "nw-resize" });
        }
        else {
            $(this).css({ cursor: "" });
        }
    })
    //  the following simple make the textbox "Auto-Expand" as it is typed in
    .keyup(function(e) {
        //  the following will help the text expand as typing takes place
        while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
            $(this).height($(this).height()+1);
        };
    });
  });





  //  BEGIN SMOOTH SCROLLING

  // Anchors
  var myAnchors = ['#accueil', '#actu', '#ecoliers', '#etudiants', '#jeunesPro', '#nosBesoins', '#assoc', '#footer'];
  var myAnchorsLinksIds = ['#btn_section0', '#btn_section1', '#btn_section2', '#btn_section3', '#btn_section4', '#btn_section5', '#btn_section6', '#btn_section7'];
  var myAnchorsHeaderIds = ['btn_header0', 'btn_header1', 'btn_header2', 'btn_header2', 'btn_header2', 'btn_header5', 'btn_header6', 'btn_header7'];
  var side_buttons = ['btn_side_0', 'btn_side_1', 'btn_side_2', 'btn_side_3', 'btn_side_4', 'btn_side_5', 'btn_side_6', 'btn_side_7'];
  var slider_containers = ['', '', '#slide_container_content_ecoliers', '#slide_container_content_etudiants', '#slide_container_content_jeunesPro', '', '', ''];
  var slider_pos = ['', '', 1, 1, 1, '', '', ''];
  var currentAnchor = 0;
  if (document.location.hash) {
    var the_hash = document.location.hash;
    // the_hash = the_hash.replace("#","");
    for (var i = 0; i < myAnchors.length; i++) {
      if (myAnchors[i] == the_hash) {
        currentAnchor = i;
        break;
      }
    }
  }
  changeActiveAnchor(currentAnchor);
  changeSideButton(currentAnchor);
  var currentPosition = $(window).scrollTop();

  // Initiate scroll allowed
  var allowedToScrollWithKeys = true;


  /**
   * Get current anchor
   */
  function getCurrentAnchor() {
    // Get container scroll position
    var gap_point = window.innerHeight * 0.4;
    var currentPosition = $(window).scrollTop();
    // Get id of current scroll item
    for (var i = 0; i < myAnchors.length; i++) {
      if (Math.abs(currentPosition - $(myAnchors[i]).offset().top) < gap_point) {
        currentAnchor = i;
      }
    }
  }
  
  /**
   * Scrolling event
   */
  $(window).scroll(function(){
    // Get current Anchor
    getCurrentAnchor();
    changeActiveAnchor(currentAnchor);
    changeSideButton(currentAnchor);
    showMenuThenAnchor();
  });

  /**
   * Sliding with arrow keys, both, vertical and horizontal
   */
  $(document).keydown(function(e) {
    //preventing the scroll with arrow keys
    if(e.which == 40 || e.which == 38){
      e.preventDefault();
    }

    switch (e.which) {
      //up
      case 38:
      case 33:
        if (allowedToScrollWithKeys == true) {
          getCurrentAnchor();
          if (currentAnchor > 0) {
            currentAnchor --;
            var idAgoToAnchor = myAnchorsLinksIds[currentAnchor];
            // alert(idAgoToAnchor);
            $(idAgoToAnchor).trigger('click');
          }
        }
        break;

      //down
      case 40:
      case 34:
        if (allowedToScrollWithKeys == true) {
          getCurrentAnchor();
          if (currentAnchor < myAnchors.length - 1) {
            currentAnchor ++;
            var idAgoToAnchor = myAnchorsLinksIds[currentAnchor];
            // alert(idAgoToAnchor);
            $(idAgoToAnchor).trigger('click');
          }
        }
        break;

      //left
      case 37:
        getCurrentAnchor();
        if (currentAnchor == 2 || currentAnchor == 3 || currentAnchor == 4) {
          var slider_container = slider_containers[currentAnchor];
          var goToSlideInPos = slider_pos[currentAnchor];
          if (goToSlideInPos > 0) {
            goToSlideInPos --;
            slider_pos[currentAnchor] = goToSlideInPos;
          }
          // alert('left');
          slideToAnchor(slider_container, goToSlideInPos);
        }
        break;

      //right
      case 39:
        getCurrentAnchor();
        if (currentAnchor == 2 || currentAnchor == 3 || currentAnchor == 4) {
          var slider_container = slider_containers[currentAnchor];
          var goToSlideInPos = slider_pos[currentAnchor];
          if (goToSlideInPos < 2) {
            goToSlideInPos ++;
            slider_pos[currentAnchor] = goToSlideInPos;
          }
          // alert('right');
          slideToAnchor(slider_container, goToSlideInPos);
        }
        break;

      // ESC -- to quit DIAPO
      case 27:
        closeDiapo();
        break;


      default:
        return; // exit this handler for other keys
    }

    changeActiveAnchor(currentAnchor);
    changeSideButton(currentAnchor);

  });

  
  /**
   * Soft scrolling on click
   */
  $(document).ready(function(){ 

    // Initiate slide size
    var window_height_slide = window.innerHeight * 0.8;
    var window_width_slide = window.innerWidth;
    var window_width_slide_container = window_width_slide * 3.1;
    $('.slide').css({'height':window_height_slide+'px', 'width':window_width_slide+'px', 'min-height':window_height_slide+'px'});
    $('.slide_container').css({'height':window_height_slide+'px', 'width':window_width_slide+'px', 'min-height':window_height_slide+'px'});
    $('.slide_container_content').css({'height':window_height_slide+'px', 'width':window_width_slide_container+'px', 'min-height':window_height_slide+'px'});
    
    $('.slide_content').css({'min-height':window_height_slide+'px'});

    // var height_content_ecoliers = $('#slide_content_Ecoliers').innerHeight; 
    // $('#infosEcoliers').css({'height':height_content_ecoliers+'px', 'min-height':height_content_ecoliers+'px'});
    // $('#slide_container_content_ecoliers').css({'height':height_content_ecoliers+'px', 'min-height':height_content_ecoliers+'px'});
    // $('#slide_container_content_ecoliers.slide_container_content').css({'height':height_content_ecoliers+'px', 'min-height':height_content_ecoliers+'px'});
    // var height_content_etudiants = $('#slide_content_Etudiants').innerHeight; 
    // $('#infosEtudiants').css({'height':height_content_etudiants+'px', 'min-height':height_content_etudiants+'px'});
    // $('#slide_container_content_etudiants').css({'height':height_content_etudiants+'px', 'min-height':height_content_etudiants+'px'});
    // $('#slide_container_content_etudiants.slide_container_content').css({'height':height_content_etudiants+'px', 'min-height':height_content_etudiants+'px'});
    // var height_content_jeunesPro = $('#slide_content_JeunesPro').innerHeight; 
    // $('#infosJeunesPro').css({'height':height_content_jeunesPro+'px', 'min-height':height_content_jeunesPro+'px'});
    // $('#slide_container_content_jeunesPro').css({'height':height_content_jeunesPro+'px', 'min-height':height_content_jeunesPro+'px'});
    // $('#slide_container_content_jeunesPro.slide_container_content').css({'height':height_content_jeunesPro+'px', 'min-height':height_content_jeunesPro+'px'});

    // alert(height_content_ecoliers);
    // alert(height_content_etudiants);
    // alert(height_content_jeunesPro);

    function changeCSSsheet(selector, property, value) {
      for (var i=0; i < document.styleSheets.length;i++) { //Loop through all styles
          //Try add rule
          try { document.styleSheets[i].insertRule(selector+ ' {'+property+':'+value+'}', document.styleSheets[i].cssRules.length);
          } catch(err) {try { document.styleSheets[i].addRule(selector, property+':'+value);} catch(err) {}}//IE
      }
    }

    var cw = $('.article_photo').width() * 0.5625;  // 16:9e
    changeCSSsheet('.article_photo', 'height', cw+'px');
    var cw = $('.photo_content').width() * 0.5625;  // 16:9e
    changeCSSsheet('.photo_content', 'height', cw+'px');
    var cw = $('.photo_action').width();
    changeCSSsheet('.photo_action', 'height', cw+'px');
    var cw = $('.besoin_photo').width();
    changeCSSsheet('.besoin_photo', 'height', cw+'px');
    $(window).resize(function() {
      var cw = $('.article_photo').width() * 0.5625;  // 16:9e
      changeCSSsheet('.article_photo', 'height', cw+'px');
      var cw = $('.photo_content').width() * 0.5625;  // 16:9e
      changeCSSsheet('.photo_content', 'height', cw+'px');
      var cw = $('.photo_action').width();
      changeCSSsheet('.photo_action', 'height', cw+'px');
      var cw = $('.besoin_photo').width();
      changeCSSsheet('.besoin_photo', 'height', cw+'px');
    });

    // Initiate section size -- Full page customized
    var window_height = window.innerHeight;
    var window_width = window.innerWidth;
    if (navigator.userAgent.match(/Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i)) {
      if (window_width > window_height) {
        $('.section').css({'min-height':window_width+'px'});
      }
      else {
        $('.section').css({'min-height':window_height+'px'});
      }
    }
    else {
      $('.section').css({'min-height':window_height+'px'});
    }

    // To reload page on browser size change !!
    $(window).resize(function() {
      if (navigator.userAgent.match(/Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i)) {}
      else {
        var window_height = window.innerHeight;
        var window_width = window.innerWidth;
        if (window_width > (window_height * 1.2) && window_width < (window_height * 2)) {
          window.location.reload();
        }
      }
    });

    // For mobile
    $("#top_menu_dropdown a.link_in_dropdown").click(function() {
      $('#top_menu_dropdown').collapse('hide');
      $(this).closest(".dropdown-menu").prev().dropdown("toggle");
    });

    // Initiate side buttons display none
    $('.pop_hover_side').css({'display':'none'});

    // Initiate the website in the middle
    for (var i = 2; i < 5; i++) {
      var slide_init = window.innerWidth + 4;
      $(slider_containers[i]).animate({
          scrollLeft: slider_pos[i] * slide_init
      }, 600);
    };

    // Modal height and scroll
    var window_height_modal = Math.round(window.innerHeight * 0.72);
    $(".modal-body").css({'max-height':window_height_modal+'px'});


    // SMOOTH SCROLL FUNCTION
    (function($) {
      $.fn.juizScrollTo = function( speed ) { 
        if ( !speed ) var speed = 'slow';  
        
        // coeur du plugin
        return this.each( function() {  
          $(this).click( function() {  
            var goscroll = false;  
            var the_hash = $(this).attr("href");  
            var regex = new RegExp("(.*)\#(.*)","gi");

            // Check no bootstrap tabs
            // if (the_hash.indexOf('tab') > -1) {
            //   return false;
            // }

            if ( the_hash.match("\#") ) {  
              the_hash = the_hash.replace(regex,"$2");
              if($("#"+the_hash).length>0) {  
                the_element = "#" + the_hash;  
                goscroll = true;  
              }  
              else if ( $("a[name=" + the_hash + "]").length>0 ) {  
                the_element = "a[name=" + the_hash + "]";  
                goscroll = true;  
              }  
              if ( goscroll ) {  
                var container = 'body';
                $(container).animate( {  
                  scrollTop: $(the_element).offset().top  
                }, speed, function() {
                  tab_n_focus(the_hash)
                  write_hash(the_hash);
                });  

                for (var i = 0; i < myAnchors.length; i++) {
                  if (myAnchors[i] == '#'+the_hash) {
                    currentAnchor = i;
                    break;
                  }
                }
                currentPosition = $(window).scrollTop();
                changeActiveAnchor(currentAnchor);
                changeSideButton(currentAnchor);

                return false;  
              }  
            }  
          });  
        });
        
        // fonctions
        
        // écriture du hash
        function write_hash( the_hash ) {
          document.location.hash =  the_hash;
        }
        
        // accessibilité au clavier
        function tab_n_focus( the_hash ) {  
          $(the_hash).attr('tabindex','0').focus().removeAttr('tabindex');  
        }

      };  
      
      // appel de la fonction sur toutes les ancres !
      $('a').juizScrollTo('slow');
      
      // fonction de slide au chargement
      function trigger_click_for_slide() {
        var the_hash = document.location.hash;
        if ( the_hash )
          $('a[href~="'+the_hash+'"]').trigger('click');
      }
      trigger_click_for_slide();

    })(jQuery)
  });

  
  /**
   * Acivate anchor link in menu
   */
  function changeActiveAnchor(current) {
    var goToAnchor = myAnchors[current];
    // Top button
    if (goToAnchor != '#accueil') {
      document.getElementById("button_to_top").className = "opacity1";
    }
    else {
      document.getElementById("button_to_top").className = "opacity0";
    }

    // For menu
    var anchorHeader = '';
    for (var i = 0; i < myAnchorsHeaderIds.length; i++) {
      if (myAnchorsHeaderIds[i] != anchorHeader) {
        anchorHeader = myAnchorsHeaderIds[i];
        document.getElementById(myAnchorsHeaderIds[i]).className = "border_right_li";
      }
      if (i == current) {
        document.getElementById(myAnchorsHeaderIds[i]).className = "border_right_li active";
      }
    }
  }

  /**
   * Side buttons
   */
  function changeSideButton(current) {
    for (var i = 0; i < side_buttons.length; i++) {
      if (i == current) {
        document.getElementById(side_buttons[i]).className = "btn-side btn-side-active";
      }
      else {
        document.getElementById(side_buttons[i]).className = "btn-side";
      }
    }
    // For white
    if (current == (side_buttons.length - 1) || current == 0) {
      for (var i = 0; i < side_buttons.length; i++) {
        document.getElementById(side_buttons[i]).className = "btn-side-invert";
        if (i == current) {
          document.getElementById(side_buttons[i]).className = "btn-side-invert btn-side-invert-active";
        }
      }
    }
  }

  /**
   * Show menu for the rest of the web site
   */
  function showMenuThenAnchor() {
    var window_height = window.innerHeight * 0.95;
    var top_offset = $(window).scrollTop();
    if (top_offset > window_height) {
      $('#header').fadeIn('normal');
    }
    else {
      $('#header').fadeOut('normal');
    }
    if (top_offset < 5 || currentAnchor == 2 || currentAnchor == 3 || currentAnchor == 4) {
      $('#btn-accueil').fadeIn('fast');
    }
    else {
      $('#btn-accueil').fadeOut('fast');
    }
  }

  /**
   * Slide functions
   */
  function slideToAnchor(id_slider_content, toGoPos) {
    var widthToSlide = window.innerWidth + 4;
    var coef = eval(toGoPos);
    // alert('pos cur'+currentPos+ 'togopos ' + toGoPos+' move '+ widthToSlide * coef);
    $(id_slider_content).animate({
        scrollLeft: widthToSlide * coef
    }, 600);

    // Save slide position
    getCurrentAnchor();
    if (currentAnchor == 2 || currentAnchor == 3 || currentAnchor == 4) {
      slider_pos[currentAnchor] = toGoPos;
    }
  }

  // END SMOOTH SCROLLING

  /**
   * Show photos
   */
  function showPhotoCarousel(photoPath) {
    $('#photo_in_carousel_toReplace').attr({'src':photoPath});
    var modal_height = $('.modal-body').height();
    $('#photo_in_carousel_toReplace').css({'max-height':modal_height+'px !important'});
    $('#modal_photos').modal('show');
  }