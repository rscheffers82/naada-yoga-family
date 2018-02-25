//
//  Custom JS for Naada
//  by Andrew@thinkup
//
jQuery( document ).ready(function( $ ) {

 fireSlick('div.online-carousel');
 fireSlick('div.clinic-carousel');
 fireSlick('div.nytt-carousel');
 loginForm();
 //parallaxInit();

  function healcodeWorkshopsReady(callback){
      var healCodeLoadingInterval = setInterval(function(){
        var healCodeLoading = $('div.naada-carousel healcode-widget .enrollment');
        // if the healcode .enrollment div is loaded and has content
        if (healCodeLoading.length !== 0) {
          callback();
          clearInterval(healCodeLoadingInterval);
        }
      },100);
  }

  function healcodeHomepageSchedReady(){
      var healCodeLoadingInterval2 = setInterval(function(){
        var healCodeLoading2 = $('div.horz-sched healcode-widget li.schedule_date');
        // if the healcode .enrollment div is loaded and has content
        if (healCodeLoading2.length !== 0) {
         //  callback();
          homepageSchedCode();
          clearInterval(healCodeLoadingInterval2);
        }
      },100);
  }

  healcodeHomepageSchedReady();

  // Call success functions for Healcode Workshops
   healcodeWorkshopsReady(function () {
       applySlickSlider();
       modifyMarkup();
       multiDayMarkup();
       fireModal();
   });

  function homepageSchedCode(){
    //  Add Next button for next day's schedule
    $('div.horz-sched healcode-widget div.header').hide().appendTo('div.horz-sched healcode-widget div.list_view td').fadeIn(200);

    // Each time you click the week links, reload this entire function
    $('div.horz-sched .week_links a').on("click", function(){
      healcodeHomepageSchedReady();
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

  function applySlickSlider() {
    // Call Slick Slider on the Workshops widget
    $('div.naada-carousel .filtered_collection').slick ({
      dots: true,
      infinite: false,
      slidesToShow: 3,
      slidesToScroll: 3,
      variableWidth: true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            variableWidth: true
          }
        },
        {
          breakpoint: 680,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            variableWidth: true
          }
        }
      ]
    });
  }

  function modifyMarkup(){

    // Adds read more to Event Meta
    $('div.naada-carousel .enrollment.slick-slide > div.healcode-date-area').after("<div class=\"more-info\"><a href=\"#\">More Info</a></div>");

    //Add css classes to columize events
    $('div.naada-carousel div.healcode div.enrollment, div.naada-carousel div.healcode div.healcode-course').css({"float": "left", "clear": "none" })

    // Hides event description area by default
    $("div.naada-carousel div.healcode-description-area").hide();

    // Remove 'Date:' in Healcode Output
    var date = $('div.naada-carousel div.healcode span.healcode-date-value');
    date.each(function(){
      var str = $(this).text().replace(/Date:/g, '');
      // if ($(this).text().length > 18){
      // //  console.log(this);
      //   var year = new Date().getFullYear();
      //   //var yearPos = this.str.search(year);
      //   str.replace(/year/g,'');
      // }
      $(this).text(str);
    });
  }

  function multiDayMarkup() {
    var multiDay = $('div.naada-carousel div.healcode-course.slick-slide');

    // Adds Content for Multiday Events
    multiDay.each(function(){
      var multiDayTag = "<div class='healcode-date-area'><span class='healcode-active-days'>Multi-day Event</span>";
      var firstDay = $(this).find("div.enrollment.child span.healcode-date-value").first().text();
      // Adds read more for multi-day
      $(this).find('span.healcode-time-value').last().before("<div class=\"more-info\"><a href=\"#\">More Info</a></div>");
      // Adds Starting Date
      $(this).children(".healcode-course-name").after(multiDayTag + "<span class='healcode-time-value'>Starting:" + firstDay + "</span></div>");

      // Removes un-needed markup in Multi-day events
      $(this).children('.healcode-description-area').siblings("div.clear").remove();
      //$(this).find('div.more-info').unwrap();
    });
  }

  function fireModal(){
    // Creates Modal window Markup
    var modal = (function(){
      var
      method = {},
      $overlay,
      $modal,
      $content,
      $close;

      // Center the modal in the viewport
      method.center = function () {
        var top, left;

        top = Math.max($(window).height() - $modal.outerHeight(), 0) / 2;
        left = Math.max($(window).width() - $modal.outerWidth(), 0) / 2;

        $modal.css({
          top:top + $(window).scrollTop(),
          left:left + $(window).scrollLeft()
        });
      };

      // Open the modal
      method.open = function (settings) {
        $content.append(settings.content);

        $modal.css({
          width: settings.width || 'auto',
          //width: settings.width || 'auto',
          height: settings.height || 'auto',
          margin: settings.margin || '2rem'
        });

        method.center();
        $(window).bind('resize.modal', method.center);
        $modal.show();
        $overlay.show();
      };

      // Close the modal
      method.close = function () {
        $modal.hide();
        $overlay.hide();
        $content.empty();
        $(window).unbind('resize.modal');
      };

      // Generate the HTML and add it to the document
      $overlay = $('<div id="overlay"></div>');
      $modal = $('<div id="modal"></div>');
      $content = $("<div id='content'></div>");
      $close = $('<a id="close" href="#">X</a>');

      $modal.hide();
      $overlay.hide();
      $modal.append($content, $close);

      $(document).ready(function(){
        $('body').append($overlay, $modal);
      });

      $close.click(function(e){
        e.preventDefault();
        method.close();
      });

      return method;
    }());

    // Call Modal for Single events
    $("div.enrollment .more-info a").click(function(e){
        e.preventDefault();
        // Opens modal with description area as content
        var htmlString =  $(this).parent().siblings("h2.healcode-enrollment-name").clone().html() + $(this).parent().siblings("div.healcode-description-area").clone().show().html();
        // var content  = $('div').append([
        //   $(this).parent().siblings("div.healcode-description-area").clone().show(),
        //   $(this).parent().siblings("div.healcode-enrollment-name").clone().show()
        // ]);

        modal.open({
          content : htmlString
          //content : content,
          // content: [
          //   $(this).parent().siblings("div.healcode-enrollment-name").clone().show(),
          //   $(this).parent().siblings("div.healcode-description-area").clone().show()
          // ]
        });

      });

    // Call Modal for Multi day Events
    $("div.healcode-course .more-info a").click(function(e){
      e.preventDefault();
      var topParent = $(this).parents(".healcode-course");
      // add attrs and show multi event sub entries
      topParent.find("div.enrollment.child").css({
        'width': '100%',
        'margin': '1rem'
      }).children("div.healcode-description-area").show();

      var multiEventString = topParent.children("h2.healcode-course-name").clone().append("<br>").html() + topParent.children("div.healcode-description-area").first().clone().show().html() + topParent.find("div.enrollment.child").parent().clone().show().html();

      modal.open({
        content : multiEventString
      });

    });

  }

  // Function to Call Slick slider on Online Courses
  function fireSlick(selector) {
    $(selector).slick ({
      dots: true,
      infinite: false,
      slidesToShow: 3,
      slidesToScroll: 1,
      variableWidth: true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
            variableWidth: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            variableWidth: true
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            variableWidth: true
          }
        }
      ]
    });
  }

  function loginForm() {
    // Move 'Remember Me' on Loginform
    $('div.form-group:nth-of-type(3)').appendTo('form#login');
    // Adds My Courses link to footer sign in
    $("<a class='course' href='/online-school/my-courses/'>Go to your Courses </a>").insertBefore('div.signin ul li a').after("| ");
  }

  function parallaxInit(){
    var ismobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
    if (ismobile === false){
      // Parallax background
      $('section.parallax-1').parallax("50%", 0.2, true);
      $('section.parallax-2').parallax("50%", 0.2, false);
    }
  }

});
