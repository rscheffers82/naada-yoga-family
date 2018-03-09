//
//  Custom JS for Naada's Homepage
//  by Andrew@thinkupdesign.ca
//

jQuery( document ).ready(function( $ ) {

  // Filter out content on home or workshops depending on the page.
  var interval = 250;

  // home
  if ($('body').hasClass('page-id-27')) {
    FilterNonFamilyContent('.slick-track div.enrollment');
  }

  // workshops
  if ($('body').hasClass('page-id-10')) {
    FilterNonFamilyContent('healcode-widget .filtered_collection > div');
  }

  function FilterNonFamilyContent(selector) {
    var filterFamilyContent = setInterval(function() {
      var elementWrapper = $(selector);
      if (elementWrapper.length !== 0) {
        $(selector)
          .each(function(){
            var classLevel = $(this).data('hcClassLevel');
            if (classLevel !== 6) $(this).hide();
          });
          clearInterval(filterFamilyContent);
      }
    }, interval);
  }
  // ---

  naadaSearch();
  misc();
  scrollNavReveal();
  go_to_top();
  healcodeFamilySchedReady();

  function healcodeFamilySchedReady(){
      var healCodeLoadingInterval2 = setInterval(function(){
        var healCodeLoading2 = $('div.horz-sched healcode-widget li.schedule_date');
        // if the healcode .enrollment div is loaded and has content
        if (healCodeLoading2.length !== 0) {
         //  callback();
          familySchedCode();
          clearInterval(healCodeLoadingInterval2);
        }
      },100);
  }


  function familySchedCode(){
    //  Add Next button for next day's schedule
    $('div.horz-sched healcode-widget div.header').hide().appendTo('div.horz-sched healcode-widget div.list_view td').fadeIn(200);

    // Each time you click the week links, reload this entire function
    $('div.horz-sched .week_links a').on("click", function(){
      healcodeFamilySchedReady();
     });

    $('div.horz-sched table td li.odd span.classname a').each(function(){
      if ($(this).text().length > 25) {
        //$(this).css("background-color","red");
        var classname = $(this).text();
        var trimd = classname.substring(0, 25) + "...";
          $(this).text(trimd);
      }
    });
  }


  function scrollNavReveal() {
    var nav = $('nav.nav-primary');
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = nav.outerHeight();

    $(window).scroll(function(event){
        didScroll = true;
    });

    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if(Math.abs(lastScrollTop - st) <= delta)
            return;

        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight){
            // Scroll Down
            nav.fadeOut('fast');
        } else {
            // Scroll Up
            if(st + $(window).height() < $(document).height()) {
                nav.fadeIn('fast');
            }
        }

        lastScrollTop = st;
    }
  }

  function naadaSearch() {
    var searchForm = $('.site-header form.search-form');
    var searchFormInput = $('input[type="search"]', searchForm);
    searchFormInput.before('<span class="ico ico-mglass"></span>');
    searchForm.hover(
      function(){
      searchForm.animate({width: "150px"}, 500);
      searchFormInput.show();
    }, function() {
      searchForm.animate({width: "30px"}, 500);
      searchFormInput.hide();
    });
  }

  function misc(){

    // Swaps Horizontal schedule buttons with class listing
    // Used on Family Yoga & Home pages
    $('div.horz-sched healcode-widget div.header').hide().appendTo('div.horz-sched healcode-widget div.list_view td').fadeIn(200);

    // Add row wrapper to columnized layout
    var columns = $('div.twocol');
    columns.first().each(function(){
      $(this).next('.twocol').andSelf().wrapAll("<div class=\"row\">");
    });

    // Duplicates Add to Cart button to button of Product page
    var cartButton = $('body.single-product form.cart');
    //console.log(cartButton);
    cartButton.clone().appendTo('div.product').children('button.single_add_to_cart_button').addClass('large centered');

    // Open dropdown Container containing longer content
    $('#dropdownOpen').click(function(e){
      e.preventDefault();
      console.log('clicked open button');
      $('.dropdownContainer').animate({
        height: 2000,
        overflow: "visible"
      }, 3000, function(){
          $('.dropdownContainer').removeClass('closed');
          $('#dropdownOpen').hide();
      })
    });

  }

  //* Add smooth scrolling for any link having the class of "naada-top"
  function go_to_top() {
		$('a.naada-top').click(function() {
      	$('html, body').animate({scrollTop:0}, 'slow', function(){
          $('nav.nav-primary').fadeIn(100);
        });
    })
    $('.videoCallout a.call-out, .familyCallout a.call-out').click(function(e){
      e.preventDefault();
      $('html, body').animate({
       scrollTop: $("div.homeContentWrap").offset().top
      }, 1500);
    })
  }

});
