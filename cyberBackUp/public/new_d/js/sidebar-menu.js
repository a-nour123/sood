(function ($) {
    "use strict";
    $(".toggle-nav").on("click", function () {
      $("#sidebar-links .nav-menu").css("left", "0px");
    });
    $(".mobile-back").on("click", function () {
      $("#sidebar-links .nav-menu").css("left", "-410px");
    });
    $(".page-wrapper").attr(
      "class",
      "page-wrapper " + localStorage.getItem("page-wrapper")
    );
    if (localStorage.getItem("page-wrapper") === null) {
      $(".page-wrapper").addClass("compact-sidebar compact-small material-icon");
    }
    // left sidebar and vertical menu
    if ($("#pageWrapper").hasClass("compact-wrapper")) {
      $(".sidebar-title").append(
        '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
      );
      $(".sidebar-title").on("click", function () {
        $(".sidebar-title")
          .removeClass("active")
          .find("div")
          .replaceWith(
            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
          );
        $(".sidebar-submenu, .submenu-wrapper").slideUp("normal");
        $(".submenu-wrapper").slideUp("normal");
        if ($(this).next().is(":hidden") == true) {
          $(this).addClass("active");
          $(this)
            .find("div")
            .replaceWith(
              '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
            );
          $(this).next().slideDown("normal");
        } else {
          $(this)
            .find("div")
            .replaceWith(
              '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
            );
        }
      });
      $(".sidebar-submenu, .submenu-wrapper").hide();
      $(".submenu-title").append(
        '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
      );
      $(".submenu-title").on("click", function () {
        $(".submenu-title")
          .removeClass("active")
          .find("div")
          .replaceWith(
            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
          );
        $(".submenu-content").slideUp("normal");
        if ($(this).next().is(":hidden") == true) {
          $(this).addClass("active");
          $(this)
            .find("div")
            .replaceWith(
              '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
            );
          $(this).next().slideDown("normal");
        } else {
          $(this)
            .find("div")
            .replaceWith(
              '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
            );
        }
      });
      $(".submenu-content").hide();
    } else if ($("#pageWrapper").hasClass("horizontal-wrapper")) {
      $(window).resize(function () {
        if (1184 >= $(window).width()) {
          $("#pageWrapper")
            .removeClass("horizontal-wrapper")
            .addClass("compact-sidebar compact-small material-icon");
          $(".page-body-wrapper")
            .removeClass("horizontal-menu")
            .addClass("sidebar-icon");
          $(".submenu-title").append(
            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
          );
          $(".submenu-title").on("click", function () {
            $(".submenu-title").removeClass("active");
            $(".submenu-title")
              .find("div")
              .replaceWith(
                '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
              );
            $(".submenu-content").slideUp("normal");
            if ($(this).next().is(":hidden") == true) {
              $(this).addClass("active");
              $(this)
                .find("div")
                .replaceWith(
                  '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
                );
              $(this).next().slideDown("normal");
            } else {
              $(this)
                .find("div")
                .replaceWith(
                  '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                );
            }
          });
          $(".submenu-content").hide();
          $(".sidebar-title").append(
            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
          );
          $(".sidebar-title").on("click", function () {
            $(".sidebar-title").removeClass("active");
            $(".sidebar-title")
              .find("div")
              .replaceWith(
                '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
              );
            $(".sidebar-submenu, .submenu-wrapper").slideUp("normal");
            if ($(this).next().is(":hidden") == true) {
              $(this).addClass("active");
              $(this)
                .find("div")
                .replaceWith(
                  '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
                );
              $(this).next().slideDown("normal");
            } else {
              $(this)
                .find("div")
                .replaceWith(
                  '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
                );
            }
          });
          $(".sidebar-submenu, .submenu-wrapper").hide();
        }
      })
    } else if ($("#pageWrapper").hasClass("compact-sidebar")) {
      var contentwidth = $(window).width();
      $(".sidebar-title").on("click", function () {
        $(".sidebar-title").removeClass("active");
        $(".sidebar-submenu").removeClass("close-submenu").slideUp("normal");
        $(".sidebar-submenu, .submenu-wrapper").slideUp("normal");
        $(".submenu-wrapper").slideUp("normal");
        if ($(this).next().is(":hidden") == true) {
          $(this).addClass("active");
          $(this).next().slideDown("normal");
          $(".sidebar-wrapper").removeClass("sidebar-default");
          $(".page-header").removeClass("sidebar-default");
        }
      });
      $(".sidebar-menu").on("click", function () {
        $(".sidebar-menu").removeClass("active");
        $(".submenu-wrapper").removeClass("close-submenu").slideUp("normal");
        $(".submenu-wrapper").slideUp("normal");
        $(".submenu-wrapper").slideUp("normal");
        if ($(this).next().is(":hidden") == true) {
          $(this).addClass("active");
          $(this).next().slideDown("normal");
        }
      });
      $(".sidebar-submenu, .submenu-wrapper").hide();
      $(".submenu-title").append(
        '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
      );
      $(".submenu-title").on("click", function () {
        $(".submenu-title")
          .removeClass("active")
          .find("div")
          .replaceWith(
            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
          );
        $(".submenu-content").slideUp("normal");
        if ($(this).next().is(":hidden") == true) {
          $(this).addClass("active");
          $(this)
            .find("div")
            .replaceWith(
              '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
            );
          $(this).next().slideDown("normal");
        } else {
          $(this)
            .find("div")
            .replaceWith(
              '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
            );
        }
      });
      $(".submenu-content").hide();
    }
    // toggle sidebar


    var $nav = $(".sidebar-wrapper");
    var $header = $(".page-header");
    var $toggle_nav_top = $(".toggle-sidebar");
  


    $toggle_nav_top.on("click", function () {

      $nav.toggleClass("close_icon");
      $header.toggleClass("close_icon");
      $('.app-content.content').toggleClass("toggle_sidebar");
      $('.footer').toggleClass("toggle_sidebar");
      
     
    });

    $nav = $(".sidebar-wrapper");
    $header = $(".page-header");
    $toggle_nav_top = $(".sidebar-title");
    $toggle_nav_top.on("click", function () {

      $nav.toggleClass("sidebar-default");
      $header.toggleClass("sidebar-default");
    });
    $(".sidebar-wrapper .back-btn").on("click", function (e) {
      $(".page-header").toggleClass("close_icon");
      $(".sidebar-wrapper").toggleClass("close_icon");
    });
    var $body_part_side = $(".body-part");
    $body_part_side.on("click", function () {
      $toggle_nav_top.attr("checked", false);
      $nav.addClass("close_icon");
      $header.addClass("close_icon");
    });
    //    responsive sidebar
    var $window = $(window);
    var widthwindow = $window.width();
    (function ($) {
      "use strict";
      if (widthwindow <= 1184) {
        $toggle_nav_top.attr("checked", false);
        $nav.addClass("close_icon");
        $header.addClass("close_icon");
      }
    })(jQuery);
    $(window).on("resize", function () {
      var widthwindaw = $window.width();
      if (widthwindaw <= 1184) {
        $toggle_nav_top.attr("checked", false);
        $nav.addClass("close_icon");
        $header.addClass("close_icon");
      } else {
        $toggle_nav_top.attr("checked", true);
        $nav.removeClass("close_icon");
        $header.removeClass("close_icon");
      }
    });
    // horizontal arrows
    var view = $("#sidebar-menu");
    var move = "500px";
    var leftsideLimit = -500;
    var getMenuWrapperSize = function () {
      return $(".sidebar-wrapper").innerWidth();
    };
    var menuWrapperSize = getMenuWrapperSize();
    if (menuWrapperSize >= "1660") {
      var sliderLimit = -3000;
    } else if (menuWrapperSize >= "1440") {
      var sliderLimit = -3600;
    } else {
      var sliderLimit = -4200;
    }
    $("#left-arrow").addClass("disabled");
    $("#right-arrow").on("click", function () {
      var currentPosition = parseInt(view.css("marginLeft"));
      if (currentPosition >= sliderLimit) {
        $("#left-arrow").removeClass("disabled");
        view.stop(false, true).animate(
          {
            marginLeft: "-=" + move,
          },
          {
            duration: 400,
          }
        );
        if (currentPosition == sliderLimit) {
          $(this).addClass("disabled");
          console.log("sliderLimit", sliderLimit);
        }
      }
    });
    $("#left-arrow").on("click", function () {
      var currentPosition = parseInt(view.css("marginLeft"));
      if (currentPosition < 0) {
        view.stop(false, true).animate(
          {
            marginLeft: "+=" + move,
          },
          {
            duration: 400,
          }
        );
        $("#right-arrow").removeClass("disabled");
        $("#left-arrow").removeClass("disabled");
        if (currentPosition >= leftsideLimit) {
          $(this).addClass("disabled");
        }
      }
    });
    // page active
    if ($("#pageWrapper").hasClass("compact-wrapper")) {
      $(".sidebar-wrapper nav").find("a").removeClass("active");
      $(".sidebar-wrapper nav").find("li").removeClass("active");
      var current = window.location.pathname;
      $(".sidebar-wrapper nav ul li a").filter(function () {
        var link = $(this).attr("href");
        if (link) {
          if (current.indexOf(link) != -1) {
            $(this).parents().children("a").addClass("active");
            $(this).parents().parents().children("ul").css("display", "block");
            $(this).addClass("active");
            $(this)
              .parent()
              .parent()
              .parent()
              .children("a")
              .find("div")
              .replaceWith(
                '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
              );
            $(this)
              .parent()
              .parent()
              .parent()
              .parent()
              .parent()
              .children("a")
              .find("div")
              .replaceWith(
                '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
              );
            return false;
          }
        }
      });
    }
    $(document).on("ready", function () {
      $(".outside").on("click", function () {
        $(this).find(".menu-to-be-close").slideToggle("fast");
      });
    });
    $(document).on("click", function (event) {
      var $trigger = $(".outside");
      if ($trigger !== event.target && !$trigger.has(event.target).length) {
        $(".menu-to-be-close").slideUp("fast");
      }
    });

    // $(".notification-box").on("click", function () {
    
    //  $(".onclick-show-div").toggleClass("d-block");
    
    // });

  

    // $(document).on('click','.open-sub-menu-item', function(){
    //   let menuData = $(this).data('subsubmenu');
    //   const subMenu = document.getElementById("menuTop");
    //   $(".menu-top").removeClass("d-none");
    //   let menuHTML = menuData.map(function (item) {

    //     return `
    //       <swiper-slide>
    //         <a href="${item.url}">${item.name}</a>
    //       </swiper-slide>`;
    //   }).join(''); 
    //   console.log(menuHTML);

    //   subMenu.innerHTML = menuHTML;
      
    // });
//       $(document).on('click', '.open-sub-menu-item', function() {
//     let menuData = $(this).data('subsubmenu');
//     const subMenu = document.getElementById("menuTop");

//     $(".sidebar-submenu").slideUp(500, 'linear', function() {
      

//             let menuHTML = menuData.map(function (item) {
//                 return `
//                   <swiper-slide>
//                     <a href="${item.url}">${item.name}</a>
//                   </swiper-slide>`;
//             }).join('');

//             subMenu.innerHTML = menuHTML;
//             $(".menu-top").removeClass("d-none");
      
//     });
// });



$(document).on('click', '.open-sub-menu-item', function() {
  let menuData = $(this).data('subsubmenu');
  const subMenu = document.getElementById("menuTop");
  subMenu.innerHTML = '';
  $(".sidebar-submenu").slideUp(500, 'linear', function() {
      let menuHTML = menuData.map(function (item) {
          return `
 
            `;
      }).join('');

      subMenu.innerHTML = menuHTML;
      $("#menuTopExist").addClass("d-none");
      $("#menuTop").removeClass("d-none");
      
      //navigation at first tab
      if (menuData.length > 0) {
          // window.location.href = menuData[0].url;
      }
 
  });
});
$(document).on('click', function(event) {
  if (!$(event.target).closest('.sidebar-submenu').length && !$(event.target).closest('.sidebar-link ').length) {
      $(".sidebar-submenu").slideUp(500, 'linear');
  }
});






    //Submenu
    // $(".sidebar-list").on("click", function (e) {
    //   // Store reference to 'this' (the clicked element)
    //   var clickedItem = $(this);

    //   $.ajax({
    //     type: "GET",
    //     url: "/admin/horizontalMenu.json", // Make sure this URL is correct and accessible
    //     success: function (response) {
    //       const subMenu = document.getElementById("menuTop");
    //       var getName = clickedItem.data('name'); // Use the stored 'this'
    //       $(".menu-top").removeClass("d-none");
    //       console.log('Clicked item:', clickedItem); // Log the clicked item

    //       const swiperSlides = response.menu.map(function (item) {
    //         if (item.name === getName) {
    //           return item.submenu.map(function (items) {
    //             console.log('Items:', items); // Log items to see its structure

    //             if (items.route) { // Ensure that `items.route` exists
    //               console.log('route:', items.route); // Log the route name

    //               return (
    //                 `<swiper-slide key="${items.route}" data-route="${items.route}">
    //                                   ${items.name}
    //                               </swiper-slide>`
    //               );
    //             } else {
    //               console.warn('No route found for:', items); // Log when no route is found
    //               return ''; // Return an empty string if no route is found
    //             }
    //           }).join(''); // Join submenu slides into a single string
    //         }
    //       }).join(''); // Join top-level slides into a single string

    //       // Update the submenu
    //       subMenu.innerHTML = swiperSlides; // Ensure swiperSlides is joined into a single string

    //       // Attach click event to each swiper-slide
    //       // Attach click event to each swiper-slide
    //       $(subMenu).find('swiper-slide').on('click', function () {
    //         var route = $(this).data('route'); // Get the route from the clicked swiper-slide

    //         if (route) {
    //           alert(route);

    //           // Here you can use Laravel's route helper in your Blade file to construct URLs
    //           // Assuming `route` is the dynamic route you're interested in
    //           var url = "{{ route('items.route', ['param' => 'value']) }}"; // Replace 'items.route' and parameters as needed
    //           window.location.href = url; // Navigate to the full URL
    //         }
    //       });

    //     },
    //     error: function (xhr, status, error) {
    //       console.error("Error fetching menu data:", error);
    //     }
    //   });
    // });






    // Get the base URL from the environment variable
    // var appUrl = `{{ env('APP_URL') }}`;
    // var localJsonUrl = appUrl + '/admin/horizontalMenu.json';

    // $(document).ready(function () {
    //   let topMenu;

    //   // Fetch the JSON data
    //   $.getJSON(localJsonUrl, function(data) {
    //     topMenu = data;

    //     // Set up the click event handler after the data is loaded
    //     $(".sidebar-list").on("click", function (e) {
    //       const subMenu = document.getElementById("menuTop");
    //       var getName = $(this).data('name');
    //       $(".menu-top").removeClass("d-none");

    //       // Clear the submenu before updating
    //       subMenu.innerHTML = '';

    //       // Filter the topMenu based on the clicked item
    //       topMenu.map(function(item) {
    //         if(item.name === getName) {
    //           let swiperSlide = item.submenu.map(function(items) {
    //             var route = `{{ route('${items.route.replaceAll('.', '/')}') }}`;
    //             return `<swiper-slide>
    //                       <a href="${route}">${items.name}</a>
    //                     </swiper-slide>`;
    //           }).join('');

    //           // Update the submenu
    //           subMenu.innerHTML = swiperSlide;
    //         }
    //       });
    //     });
    //   }).fail(function(jqxhr, textStatus, error) {
    //     console.error("Error loading menu data:", textStatus, error);
    //   });
    // });



    if ($(window).width() <= 1199) {
      $(".left-header .link-section").children("ul").css("display", "none");
      $(this).parent().children("ul").toggleClass("d-block").slideToggle();
    }
    // active link
    if (
      $(".simplebar-wrapper .simplebar-content-wrapper") &&
      $("#pageWrapper").hasClass("compact-wrapper")
    ) {
      $(".simplebar-wrapper .simplebar-content-wrapper").animate(
        {
          scrollTop:
            $(".simplebar-wrapper .simplebar-content-wrapper a.active").offset()
              .top - 400,
        },
        1000
      );
    }
  })(jQuery);

  $(document).ready(function () {
    // Select all modal elements on the page except the one with id 'sedationModal'
    $(".modal").each(function () {
      const modalElement = $(this);
  
      // Skip the modal with id 'sedationModal'
      if (modalElement.attr('id') === 'sedationModal') {
        return; // Skip this iteration
      }
  
      // Initialize the Bootstrap modal with options
      const modal = new bootstrap.Modal(modalElement[0], {
        backdrop: 'static',  // Prevents closing the modal when clicking outside it
        keyboard: false      // Prevents closing the modal when pressing the Esc key
      });
  
      // Add an event listener for when the modal is fully shown
      modalElement.on('shown.bs.modal', function () {
        console.log("current modal"); // Message when the modal is open
      });
    });
  });
  


