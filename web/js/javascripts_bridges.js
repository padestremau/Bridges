// -------------------------------------------   Start scripts function - LBF  -----------------------------------------------

  // On load
  function onLoadData() {
    // Top button
    document.getElementById("button_to_top").className = "opacity0";
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



  // Change CSS function
  function changeCSSsheet(selector, property, value) {
    for (var i=0; i < document.styleSheets.length;i++) { //Loop through all styles
        //Try add rule
        try { document.styleSheets[i].insertRule(selector+ ' {'+property+':'+value+'}', document.styleSheets[i].cssRules.length);
        } catch(err) {try { document.styleSheets[i].addRule(selector, property+':'+value);} catch(err) {}}//IE
    }
  }





  //  BEGIN SMOOTH SCROLLING

  // Anchors
  var myAnchors = ['#home', '#aboutUs', '#stories', '#work', '#participate', '#footer'];
  var myAnchorsLinksId = ['#btn_section0', '#btn_section1', '#btn_section2', '#btn_section3', '#btn_section4', '#btn_section5'];
  var side_buttons = ['btn_side_0', 'btn_side_1', 'btn_side_2', 'btn_side_3', 'btn_side_4', 'btn_side_5'];
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

  // For mobile
  $("#mobile_nav a").click(function() {
    $('#mobile_nav').collapse('hide');
    $(this).closest(".dropdown-menu").prev().dropdown("toggle");
  });


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

    // Change Anchor active
    changeActiveAnchor(currentAnchor);
    changeSideButton(currentAnchor);
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
        getCurrentAnchor();
        if (currentAnchor > 0) {
          currentAnchor --;
          var idAgoToAnchor = myAnchorsLinksId[currentAnchor];
          // alert(idAgoToAnchor);
          $(idAgoToAnchor).trigger('click');
        }
        break;

      //down
      case 40:
      case 34:
        getCurrentAnchor();
        if (currentAnchor < myAnchors.length - 1) {
          currentAnchor ++;
          var idAgoToAnchor = myAnchorsLinksId[currentAnchor];
          // alert(idAgoToAnchor);
          $(idAgoToAnchor).trigger('click');
        }
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


    var window_height = window.innerHeight;
    var window_width = window.innerWidth;
    if (window_width > (window_height * 1.2)) {
      // Full page customized
      $('.section').css({'min-height':window_height+'px'});
    }

    // Modal height and scroll
    var window_height_modal = Math.round(window.innerHeight * 0.72);
    $(".modal-body").css({'max-height':window_height_modal+'px'});

    // alert(window_height+' and '+window_height_modal+' and '+$('.modal-body').css('max-height'));

    // Round images
    var widthImg = $('.product_img').width();
    $('.product_img').css({'height':widthImg+'px'});
    changeCSSsheet('.product_img', 'height', widthImg+'px');
    $(window).resize(function() {
            var widthImg = $('.product_img').width();
            $('.product_img').css({'height':widthImg+'px'});
            changeCSSsheet('.product_img', 'height', widthImg+'px');
              });
    var widthRecipe = $('.recipe_img').width() * 0.7;
    $('.recipe_img').css({'height':widthRecipe+'px'});
    changeCSSsheet('.recipe_img', 'height', widthRecipe+'px');
    $(window).resize(function() {
        var widthRecipe = $('.recipe_img').width() * 0.7;
        $('.recipe_img').css({'height':widthRecipe+'px'});
        changeCSSsheet('.recipe_img', 'height', widthRecipe+'px');
          });

    var coverPhoto_height_lg = $('.coverPhoto_img_admin').width() / 3.030303;
    $('.coverPhoto_img_admin').css({'height':coverPhoto_height_lg+'px'});
    changeCSSsheet('.coverPhoto_img_admin', 'height', coverPhoto_height_lg+'px');
    $(window).resize(function() {
          var coverPhoto_height_lg = $('.coverPhoto_img_admin').width() / 3.030303;
          $('.coverPhoto_img_admin').css({'height':coverPhoto_height_lg+'px'});
          changeCSSsheet('.coverPhoto_img_admin', 'height', coverPhoto_height_lg+'px');
    });


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
    if (goToAnchor != '#home') {
      document.getElementById("button_to_top").className = "opacity1";
    }
    else {
      document.getElementById("button_to_top").className = "opacity0";
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
    // In footer
    if (current == (side_buttons.length - 1)) {
      for (var i = 0; i < side_buttons.length; i++) {
        document.getElementById(side_buttons[i]).className += " btn-side-footer";
        if (i == current) {
          document.getElementById(side_buttons[i]).className += " btn-side-footer-active";
        }
      }
    }
  }

  // END SMOOTH SCROLLING


// Delete javascript functions

function areYouSureDeleteOrder(path) {
  if (confirm('Etes-vous certain de vouloir supprimer cette commande terminée ?')) {
    window.location = path;   
  }
}

/**
   * Show photos
   */
  function showPhotoCarousel(photoPath) {
    $('#photo_in_carousel_toReplace').attr({'src':photoPath});
    var modal_height = $('.modal-body').height();
    $('#photo_in_carousel_toReplace').css({'max-height':modal_height+'px !important'});
    $('#modal_photos').modal('show');
  }