/**
 * http://kopatheme.com
 * Copyright (c) 2014 Kopatheme
 *
 * Licensed under the GPL license:
 *  http://www.gnu.org/licenses/gpl.html
 **/

/**
 *   1- Main menu
 *   2- Mobile menu
 *   3- Validate form 
 *   4- Accordion
 *   5- Toggle
 *   6- Google Map
 *   7- Vertical Menu
 *   8- Waypoint
 *   9- Back to top
 *   10- Quick link
 *   11- Kopa tab 1 widget
 * 	 12- Video wrapper
 *   13- Owl carousel
 *   14- Others
 *-----------------------------------------------------------------
 **/
const base_url = "http://ittires.com/";
var kopa_variable = {
    "contact": {
        "address": "Lorem ipsum dolor sit amet, consectetur adipiscing elit",
        "marker": "/url image"
    },
    "i18n": {
        "VIEW": "View",
        "VIEWS": "Views",
        "validate": {
            "form": {
                "SUBMIT": "Submit",
                "SENDING": "Sending..."
            },
            "name": {
                "REQUIRED": "Please enter your name",
                "MINLENGTH": "At least {0} characters required"
            },
            "email": {
                "REQUIRED": "Please enter your email",
                "EMAIL": "Please enter a valid email"
            },
            "url": {
                "REQUIRED": "Please enter your url",
                "URL": "Please enter a valid url"
            },
            "message": {
                "REQUIRED": "Please enter a comment",
                "MINLENGTH": "At least {0} characters required"
            }
        }
    }
};
$(document).ready(function () {
    setTimeout(function () {
        jQuery('*').removeClass('loading');
    }, 400);
    /* =========================================================
     1. Main menu
     ============================================================ */

    Modernizr.load([
        {
            load: '/../assets/js/superfish.js',
            complete: function () {

                //Main menu
                jQuery('#main-menu').superfish({
                    delay: 400,
                    speed: 'fast',
                    cssArrows: false
                });
            }
        }
    ]);
    /* =========================================================
     2. Mobile menu
     ============================================================ */
    $("#mobile-menu").hide();
    $(".show_mobile_menu").click(function (e) {
        e.preventDefault();
        $("#mobile-menu").slideToggle();
    });	 	 /*$('.inner').hide();	 $('.toggle').click(function(e) {		e.preventDefault();	  		var $this = $(this);	  		if ($this.next().hasClass('show')) {			$this.next().removeClass('show');			$this.next().slideUp(350);		} else {			$this.parent().parent().find('li .inner').removeClass('show');			$this.parent().parent().find('li .inner').slideUp(350);			$this.next().toggleClass('show');			$this.next().slideToggle(350);		}	});*/
    /*Modernizr.load([
     {
     load: '/../assets/js/jquery.navgoco.js',
     complete: function () {
     
     var mobileMenu = jQuery("#mobile-menu");
     mobileMenu.navgoco({accordion: true});
     jQuery("#main-nav").find("i").on("click", function () {
     mobileMenu.stop().slideToggle("slow");
     });
     }
     }
     ]);*/

    // Vertical Menu hide and show
    $("#menu_list .accordion-icon").click(function () {
        var selected = $(this).attr('data-target'); //get ID from <a> name
        //alert(selected);
        $('#divmenu0, #divmenu1, #divmenu2, #divmenu3, #divmenu4, #divmenu5, #divmenu6, #divmenu7, #divmenu8').hide('fast');
        $('#div' + selected).show('fast');
        //siblings().hide('slow');
    });


    var screenHeight = jQuery(window).height();
    var mmHeight = screenHeight - 45;
    if (jQuery(window).width() < 639) {
        jQuery("#mobile-menu").css("max-height", mmHeight + 'px');
    }

    $(window).resize(function () {
        var screenHeight = jQuery(window).height();
        var mmHeight = screenHeight - 45;
        if (jQuery(window).width() < 639) {
            jQuery("#mobile-menu").css("max-height", mmHeight + 'px');
        }
    });
    /* =========================================================
     3. Validate form
     ============================================================ */

    if (jQuery('.comments-form,.contact-form').length > 0) {
        Modernizr.load([{
                load: ['/../assets/js/jquery.form.js', '/../assets/js/jquery.validate.js'],
                complete: function () {
                    jQuery('.comments-form,.contact-form').validate({
                        // Add requirements to each of the fields
                        rules: {
                            name: {
                                required: true,
                                minlength: 5
                            },
                            email: {
                                required: true,
                                email: true
                            },
                            message: {
                                required: true,
                                minlength: 20
                            }
                        },
                        // Specify what error messages to display
                        // when the user does something horrid
                        messages: {
                            name: {
                                required: kopa_variable.i18n.validate.name.REQUIRED,
                                minlength: jQuery.format(kopa_variable.i18n.validate.name.MINLENGTH)
                            },
                            email: {
                                required: kopa_variable.i18n.validate.email.REQUIRED,
                                email: kopa_variable.i18n.validate.email.EMAIL
                            },
                            message: {
                                required: kopa_variable.i18n.validate.message.REQUIRED,
                                minlength: jQuery.format(kopa_variable.i18n.validate.message.MINLENGTH)
                            }
                        },
                        // Use Ajax to send everything to processForm.php
                        submitHandler: function (form) {
                            jQuery(".comments-form .input-submit,.contact-form .input-submit").attr("value", kopa_variable.i18n.validate.form.SENDING);
                            jQuery(form).ajaxSubmit({
                                success: function (responseText, statusText, xhr, $form) {
                                    jQuery("#response").html(responseText).hide().slideDown("fast");
                                    jQuery(".comments-form .input-submit,.contact-form .input-submit").attr("value", kopa_variable.i18n.validate.form.SUBMIT);
                                    $('#msg').html('<span style="color:red">Message has been send</span>');
//                                    window.location.reload();
                                    $('#contact_name').val('');
                                    $('#contact_email').val('');
                                    $('#contact_url').val('');
                                    $('#contact_message').val('');
                                }
                            });
                            return false;
                        }
                    });
                }
            }]);
    }

    /* =========================================================
     4. Accordion
     ============================================================ */

    Modernizr.load([{
            load: '/../assets/js/jquery-ui.min.js',
            complete: function () {
                $(".kopa-accordion").accordion({
                    heightStyle: "content",
                    icons: false
                            //collapsible: true
                });
            }
        }]);
    $(".kopa-accordion h4, .kopa-toggle h4").each(function () {
        var titleHeight = $(this).outerHeight();
        var titleHeight1 = titleHeight + "px";
        $(this).find("i").css("line-height", titleHeight1);
        if (titleHeight > 50) {
            $(this).find("span").removeClass("corner");
        } else {
            return;
        }
    });
    /* =========================================================
     5. Toggle
     ============================================================ */

    var $kopa_toggle = $(".kopa-toggle");
    var $head_toggle = $kopa_toggle.find("h4");
//chua co active, dat mac dinh
    if ($kopa_toggle.find(".active").length <= 0) {
        $head_toggle.eq(0).addClass('active');
    }

//an tat ca panel, tru panel active
    $head_toggle.not(".active").next().hide();
    $head_toggle.on("click", function (event) {
        var $panel = $(this).next();
        $panel.slideToggle(300);
        $(this).toggleClass('active');
    });
    /* =========================================================
     6. Google Map
     ============================================================ */
    var map;
    if (jQuery('.kp-map').length > 0) {
        var id_map = jQuery('.kp-map').attr('id');
        var lat = parseFloat(jQuery('.kp-map').attr('data-latitude'));
        var lng = parseFloat(jQuery('.kp-map').attr('data-longitude'));
        var place = jQuery('.kp-map').attr('data-place');
        map = new GMaps({
            el: '#' + id_map,
            lat: lat,
            lng: lng,
            zoomControl: true,
            zoomControlOpt: {
                style: 'SMALL',
                position: 'TOP_LEFT'
            },
            panControl: false,
            streetViewControl: false,
            mapTypeControl: false,
            overviewMapControl: false
        });
        map.addMarker({
            lat: lat,
            lng: lng,
            title: place
        });
    }
    ;
    $('#kp-map').on("mouseenter", function () {
        $('.contact-info-wrapper').stop().fadeOut();
    }).on("mouseleave", function () {
        $('.contact-info-wrapper').stop().fadeIn();
    });
    /* =========================================================
     7. Vertical Menu
     ============================================================ */

    if (jQuery('.sf-vertical').length > 0) {

        Modernizr.load([
            {
                load: '/../assets/js/superfish.js',
                complete: function () {

                    var $sf_vertical = $('.sf-vertical');
                    var device = 0; //0 desktop, 1 mobile
                    var point = 992;
                    if ($(window).width() >= point) { //desktop
                        initSf();
                    } else { //mobile
                        sfMobile();
                        device = 1;
                    }

                    $(window).resize(function () {
                        console.log($(window).width() + " -- " + device);
                        if ($(window).width() >= point && !$sf_vertical.hasClass('sf-js-enabled') && device != 0) { //desktop
                            destroySfMobile();
                            initSf();
                            device = 0;
                        } else if ($(window).width() < point && device != 1) { //mobile
                            $sf_vertical.superfish('destroy');
                            sfMobile();
                            device = 1;
                        }
                        return false;
                    });
                    function initSf() {
                        $sf_vertical.superfish({
                            delay: 400,
                            speed: 'fast',
                            cssArrows: false
                        });
                    }

                    function sfMobile() {
                        //them class theo sf
                        $sf_vertical.find("ul").prev().addClass("sf-with-ul");

                        /*$sf_vertical.children("li").on("click", function () {
                         if ($(this).children("ul").length) {
                         //dong, mo LI
                         $(this).children("ul").toggleClass('sfHover');
                         $(this).children("ul").stop().slideToggle("slow");
                         //xoa class nhung LI khac                        
                         $(this).siblings().removeClass("sfHover").children("ul").slideUp("slow");
                         return false;
                         }
                         });*/
                    }

                    function destroySfMobile() {
                        $sf_vertical.children("li").unbind();
                        $sf_vertical.find(".sf-with-ul").removeClass("sf-with-ul");
                        $sf_vertical.find(".sfHover").removeClass(".sfHover");
                    }
                }
            }
        ]);
    }


    /* =========================================================
     8. Waypoint
     ============================================================ */

    Modernizr.load([
        {
            load: ['/../assets/js/waypoints.min.js', '/../assets/js/waypoints-sticky.min.js'],
            complete: function () {
                $(".waypoint").waypoint('sticky');
            }
        }
    ]);
    /* =========================================================
     9. Back to top
     ============================================================ */
    jQuery(".back-to-top").hide();
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 100) {
            jQuery('.back-to-top').fadeIn();
        } else {
            jQuery('.back-to-top').fadeOut();
        }
        return false;
    });
    jQuery('.back-to-top').on("click", function (event) {
        jQuery('body,html').animate({
            scrollTop: 0
        }, 800);
        event.preventDefault();
        return false;
    })


    /* =========================================================
     10. Quick link
     ============================================================ */

    $(".quick-link").on("click", function () {
        $(this).next().stop().slideToggle("slow");
        return false;
    });
//find-car - kopa-home-2
    var $find_cars_wrap = $(".kopa-home-2").find(".find-cars-wrap");
    $find_cars_wrap.find(".head-fc").on("click", function () {

        if ($find_cars_wrap.hasClass("fc-active")) {
            $find_cars_wrap.find(".find-cars").slideUp(200, function () {
                $find_cars_wrap.toggleClass("fc-active");
            })
        } else {
            $find_cars_wrap.find(".find-cars").slideDown(200, function () {
                $find_cars_wrap.toggleClass("fc-active");
            })
        }
        return false;
    });
//upload file
    $(".upload").change(function () {
        $(this).parent().find('.txt-file').attr("value", this.value);
        return false;
    });
//slide-sell-your-car - device-width-sm
    var $sell_your_car_slide = $(".sell-your-car-slide");
    var $content = $sell_your_car_slide.find(".content");
    $sell_your_car_slide.find(".h3").on("click", function () {
        if ($(window).width() < 768) {
            if ($content.hasClass("active")) {
                $content.css("height", "40px").toggleClass("active");
            } else {
                $content.css("height", "100%").toggleClass("active");
            }
        }
        return false;
    });
//man hinh > device-sm thi reset
    $(window).resize(function () {
        if ($(window).width() >= 768) {
//$content.css("height", "auto").removeClass("active");
            $content.attr("style", "").removeClass("active");
        }
        return false;
    });
    /* =========================================================
     11. Kopa tab 1 (count li items to calculate li width in percent)
     ============================================================ */

    if (jQuery('.kopa-tab-1 ul').length > 0) {
        jQuery('.kopa-tab-1 ul').each(function () {
            var $this = jQuery(this);
            var li_length = $this.find('li').length;
            var li_width = (1 / li_length * 100) + '%';
            $this.find('li').css('width', li_width);
        });
    }


    /* =========================================================
     12. Video wrapper
     ============================================================ */
    if ($(".video-wrapper").length > 0) {
        Modernizr.load([{
                load: '/../assets/js/fitvids.js',
                complete: function () {
                    $(".video-wrapper").fitVids();
                }
            }]);
    }
    ;
    /* =========================================================
     13. Owl Carousel
     ============================================================ */

    /* Home - Top Slide */
    if (jQuery('#kopa-owl-top-slide').length > 0) {

        Modernizr.load([
            {
                load: '/../assets/js/owl.carousel.min.js',
                complete: function () {

                    var $slide = $("#kopa-owl-top-slide");
                    var $control_top_slide = $slide.next();
                    var $control_item = $control_top_slide.find('li');
                    var $find_cars = $(".find-cars");
                    var $intro = $slide.find(".intro");
                    var setIndex = 0;
                    $control_item.each(function (index) {
                        if ($(this).hasClass('active')) {
                            setIndex = index;
                            return false;
                        }
                    });
                    $slide.owlCarousel({
                        items: 1,
                        itemsDesktop: [1210, 1],
                        itemsDesktopSmall: [992, 1],
                        itemsTablet: [768, 1],
                        itemsMobile: [480, 1],
                        autoHeight: false,
                        lazyLoad: true,
                        navigation: false,
                        pagination: false,
                        navigationText: false,
                        slideSpeed: 600,
                        paginationSpeed: 600,
                        autoPlay: 10000,
                        afterAction: afterAction

                    });
                    var owl = $slide.data('owlCarousel');
                    owl.goTo(setIndex);
                    function afterAction() {
                        $control_item.removeClass("active");
                        $control_item.eq(this.owl.currentItem).addClass('active');
                        //position
                        var height_slide = $slide.outerHeight();
                        if ($intro.length <= 0) { //slide home 1
                            if ($(window).width() > 1210) {
                                height_slide -= 64;
                            }
                        }

                        $control_top_slide.css("top", (height_slide - $control_top_slide.outerHeight()) / 2);
                        $find_cars.css("top", (height_slide - $find_cars.outerHeight()) / 2);
                        //show
                        $(".kopa-home-1").find(".find-cars").fadeIn(300);
                        $(".control-top-slide").fadeIn(300);
                    }

                    $control_item.on("click", function () {
                        owl.goTo($(this).index());
                        return false;
                    });
                    if ($slide.parents(".kopa-home-2").length) {
                        $control_top_slide.mouseenter(function () {
                            $(".mask").toggleClass("opacity-0");
                        });
                        $control_top_slide.mouseleave(function () {
                            $(".mask").toggleClass("opacity-0");
                        });
                        return false;
                    }
                }
            }
        ]);
    }

    /* Home-Recent Tweets Widget */
    if (jQuery('.owl-recent-tweets').length > 0) {
        Modernizr.load([
            {
                load: '/../assets/js/owl.carousel.min.js',
                complete: function () {
                    $(".owl-recent-tweets").owlCarousel({
                        items: 1,
                        itemsDesktop: [1024, 1],
                        itemsDesktopSmall: [979, 1],
                        itemsTablet: [768, 1],
                        itemsMobile: [479, 1],
                        lazyLoad: true,
                        navigation: true,
                        pagination: false,
                        navigationText: false,
                        slideSpeed: 1000,
                        paginationSpeed: 1000
                    });
                }
            }
        ]);
    }

    /* Home Shop - Top slide */
    if (jQuery('.owl-home-shop-top-slide').length > 0) {
        Modernizr.load([
            {
                load: '/../assets/js/owl.carousel.min.js',
                complete: function () {
                    $(".owl-home-shop-top-slide").owlCarousel({
                        items: 1,
                        itemsDesktop: [1024, 1],
                        itemsDesktopSmall: [979, 1],
                        itemsTablet: [768, 1],
                        itemsMobile: [479, 1],
                        lazyLoad: true,
                        navigation: false,
                        pagination: true,
                        navigationText: false,
                        slideSpeed: 1000,
                        paginationSpeed: 1000
                    });
                }
            }
        ]);
    }

    /* News & Review slide */
    if (jQuery('.owl-single-item-2').length > 0) {
        Modernizr.load([
            {
                load: '/../assets/js/owl.carousel.min.js',
                complete: function () {
                    $(".owl-single-item-2").owlCarousel({
                        items: 1,
                        itemsDesktop: [1024, 1],
                        itemsDesktopSmall: [979, 1],
                        itemsTablet: [768, 1],
                        itemsMobile: [479, 1],
                        lazyLoad: true,
                        navigation: false,
                        pagination: true,
                        navigationText: false,
                        slideSpeed: 1000,
                        paginationSpeed: 1000
                    });
                }
            }
        ]);
    }

    /* Home - Week offer widget */
    if (jQuery('.owl-week-offer').length > 0) {
        Modernizr.load([
            {
                load: '/../assets/js/owl.carousel.min.js',
                complete: function () {
                    $(".owl-week-offer").owlCarousel({
                        items: 1,
                        itemsDesktop: [1024, 1],
                        itemsDesktopSmall: [979, 1],
                        itemsTablet: [768, 1],
                        itemsMobile: [479, 1],
                        lazyLoad: true,
                        navigation: false,
                        pagination: true,
                        navigationText: false,
                        slideSpeed: 1000,
                        paginationSpeed: 1000
                    });
                }
            }
        ]);
    }

    $(".owl-week-offer .offer-tabs li a").on("click", function () {
        $(this).closest("ul").find(".mask").css("background-color", "rgba(0, 0, 0, .4)");
        $(this).closest("li").find(".mask").css("background-color", "transparent");
    });
    if (jQuery('#sidebar .owl-testi-1').length > 0) {
        Modernizr.load([
            {
                load: '/../assets/js/owl.carousel.min.js',
                complete: function () {
                    $('#sidebar .owl-testi-1').owlCarousel({
                        items: 1,
                        itemsDesktop: [1024, 1],
                        itemsDesktopSmall: [979, 1],
                        itemsTablet: [768, 1],
                        itemsMobile: [479, 1],
                        lazyLoad: true,
                        navigation: false,
                        pagination: true,
                        navigationText: false,
                        slideSpeed: 1000,
                        paginationSpeed: 1000
                    });
                }
            }
        ]);
    }

    /* Home - Tesimonial slide */
    if (jQuery('.owl-testi-1').length > 0) {
        Modernizr.load([
            {
                load: '/../assets/js/owl.carousel.min.js',
                complete: function () {
                    $(".owl-testi-1").owlCarousel({
                        items: 2,
                        itemsDesktop: [1024, 2],
                        itemsDesktopSmall: [979, 2],
                        itemsTablet: [768, 1],
                        itemsMobile: [479, 1],
                        lazyLoad: true,
                        navigation: false,
                        pagination: true,
                        navigationText: false,
                        slideSpeed: 1000,
                        paginationSpeed: 1000
                    });
                }
            }
        ]);
    }

    /* ============================================================
     14. Other
     ============================================================ */

    var doc = document.documentElement;
    doc.setAttribute('data-useragent', navigator.userAgent);
    jQuery('#footer-responsive-menu').change(function () {
        window.location = jQuery(this).val();
    });
});
$(document).ready(function () {
// bootstrap popover enable
    //$('[data-toggle="popover"]').popover();
    // script used for checkout page
    $('.checkOutSteps').on('click', '.radio-inline', function () {
        var payOpt = $(this).find('.paymentOpt').data('payment-type');
        //alert(payOpt);
        if (payOpt == 'paypal') {
// $('.silWalletInfo').slideUp();
            $('.creaditCardInfo').slideUp();
        } else if (payOpt == 'siloWallet') {
            $('.creaditCardInfo').slideUp();
            // $('.silWalletInfo').slideDown();
        } else {
// $('.silWalletInfo').slideUp();
            $('.creaditCardInfo').slideDown();
        }
    });
    /*Filter popup hide|show*/
    $('body').on('click', function () {
        if ($('body').hasClass('modal-open')) {
            $('.shopSearchFilter').show();
            $('#form_filter_product').show();
        }
    })

    // product page slider
    if ($('#productSliderFor').length) {
        $('#productSliderFor').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '#productSliderNav'
        });
    }
    if ($('#productSliderNav').length) {
        $('#productSliderNav').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            asNavFor: '#productSliderFor',
            dots: false,
            centerMode: true,
            focusOnSelect: true
        });
    }
});
// function used in checkout page
if (jQuery('#memberDetailsForm').length > 0) {
    Modernizr.load([{
            load: ['/../assets/js/jquery.validate.js'],
            complete: function () {
                jQuery('#memberDetailsForm').validate({
                    rules: {
                        //// For General Sales Inquiries
                        first_name: {
                            required: true,
                            lettersonly: true
                        },
                        last_name: {
                            required: true,
                            lettersonly: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        password: 'required',
                        confirmpassword: {
                            equalTo: "#password"
                        },
                        phone: {
                            minlength: 9,
                            required: true
                        },
                        billing_city: {
                            required: true,
                            lettersonly: true
                        },
                        billing_country: {
                            required: true,
                            //lettersonly: true
                        },
                        billing_state: {
                            required: true,
                            //lettersonly: true
                        },
                        address: {
                            required: true,
                        },
                        zip: {
                            required: true,
                            digits: true
                        },
                    },
                    ////// Messages for Rules Goes Below //////

                    messages: {
                        //// For General Sales Inquiries
                        first_name: {
                            lettersonly: "Letters only please",
                            required: "Please enter first name"
                        },
                        last_name: {
                            lettersonly: "Letters only please",
                            required: "Please enter last name"
                        },
                        email: {
                            email: "Please enter a valid email address",
                            required: "Please enter an email address"
                        },
                        phone: {
                            minlength: "Please enter a valid phone number",
                            required: "Please enter phone number"
                        },
                        password: "Please enter a password",
                        confirmpassword: "Confirm password and password should match",
                        billing_address: "Please enter address",
                        billing_city: {
                            lettersonly: "Letters only please",
                            required: "Please enter city"
                        },
                        billing_country: {
                            lettersonly: "Letters only please",
                            required: "Please select country"
                        },
                        billing_state: {
                            lettersonly: "Letters only please",
                            required: "Please select state"
                        },
                        zip: {
                            digits: "Digits only please",
                            required: "Please enter zip"
                        },
                        address: {
                            lettersonly: "Letters only please",
                            required: "Please enter address"
                        },
                    },
                    submitHandler: function (form) {


                        $.ajax({
                            // url: '/index.php/members/userExist',
                            url: 'home/user/',
                            type: 'POST',
                            data: {first_name: $('#first_name').val(), last_name: $('#last_name').val(), country_code: $('#country_code').val(), phone: $('#phone').val(), email: $('#email').val(), u_password: $('#password').val(), billing_address: $('#billing_address').val(), billing_city: $('#billing_city').val(), billing_country: $('#billing_country').val(), billing_state: $('#billing_state').val(), billing_zip: $('#billing_zip').val(), role: 'user'},
                            success: function (res) {

                                if (res == 'exist') {
                                    alert('User with this email already exist. Please try with different email.');
                                } else {
                                    $('li[role=presentation]').removeClass('active');
                                    $('.tab-pane').removeClass('active');
                                    $('.payment_details').addClass('active');
                                }
                            }
                        });
                        // $('li[role=presentation]').removeClass('active');
                        // $('.tab-pane').removeClass('active');
                        // $('.payment_details').removeClass('disabled').addClass('active');
                    }
                });
                $.validator.addMethod("lettersonly", function (value, element) {
                    return this.optional(element) || /^[a-z]+$/i.test(value);
                }, "Letters only please");
            }
        }]);
}

// function used in checkout page
if (jQuery('#paymentDetailsForm').length > 0) {
    Modernizr.load([{
            load: ['/../assets/js/jquery.validate.js'],
            complete: function () {
                jQuery('#paymentDetailsForm').validate({
                    rules: {
                        exp_month: {
                            required: 'required',
                            maxlength: 2,
                            minlength: 2
                        },
                        exp_year: {
                            required: 'required',
                            maxlength: 2,
                            minlength: 2
                        },
                        credit_number: {
                            required: true,
                            creditcard: true
                        },
                        security_code: {
                            required: true,
                            digits: true,
                            maxlength: 3,
                            minlength: 3
                        },
                        terms: 'required'
                    },
                    ////// Messages for Rules Goes Below //////

                    messages: {
                        //// For General Sales Inquiries
                        exp_month: {
                            creditcard: "Please enter a valid credit card number",
                            required: "Please enter card expiry month",
                            minlength: "Please enter a valid security code",
                            maxlength: "Please enter a valid security code",
                        },
                        exp_year: {
                            creditcard: "Please enter a valid credit card number",
                            required: "Please enter card expiry month",
                            minlength: "Please enter a valid security code",
                            maxlength: "Please enter a valid security code",
                        },
                        credit_number: {
                            creditcard: "Please enter a valid credit card number",
                            required: "Please enter credit card number"
                        },
                        security_code: {
                            minlength: "Please enter a valid security code",
                            maxlength: "Please enter a valid security code",
                            required: "Please enter security code",
                            digits: "Digits only please"
                        },
                        terms: 'Please access terms and conditions'
                    },
                    submitHandler: function (form) {
                        Stripe.setPublishableKey('pk_test_Q5EEVATtiOtsgVgPgRglKRgR');
                        var $form = $('#paymentDetailsForm');

                        // Disable the submit button to prevent repeated clicks:
                        $form.find('.strip-btn').prop('disabled', true);
                        $form.find('.strip-btn').html('Please wait...');
                        // Request a token from Stripe:
                        Stripe.card.createToken($form, stripeResponseHandler);
                        // Prevent the form from being submitted:
                        return false;

                        $('li[role=presentation]').removeClass('active');
                        $('.tab-pane').removeClass('active');
                        $('.status_details').removeClass('disabled').addClass('active');
                    }
                });
            }
        }]);
}


function stripeResponseHandler(status, response) {

    if (response.error) {
//        alert(response.error.message);
        $("#paystatus").html('<div class="alert alert-danger"><strong>Error! </strong>' + response.error.message + '</div>');
        $('.strip-btn').prop('disabled', false);
        $('.strip-btn').html('PLACE ORDER');
    } else {
        $.ajax({
            url: base_url + 'home/Home/stripePaySubmit',
            data: {access_token: response.id},
            type: 'POST',
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
                if (response.success)
                    window.location.href = base_url + "home/checkout/success";
            },
            error: function (error) {
                console.log(error);
            }
        });
        //console.log(response.id);
    }
}



// function to change states according to country in checkout page.
//$("#billing_country").on('change', function (e) {
//    if (this.value != 'select') {
//        $.ajax({
//            url: getCityURL,
//            method: 'post',
//            async: false,
//            data: {'country_id': this.value},
//            success: function (data) {
//                // $("#project_portfolio").empty();
//                // alert(data);
//                $("#billing_state").html(data);
//            }
//        });
//    } else {
//
//        $("#billing_state").html("<option value='select'>Select State</option>");
//    }
//
//});

// function to disallow user to enter character
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105)) {
        return false;
    }

    return true;
}

// shooping cart table script
$('.cartTable').on('click', '.btn', function () {
    $(this).closest('tr').remove();
});
if ($('.mCustomScrollbar').length) {
    $('.mCustomScrollbar').mCustomScrollbar({
        theme: "dark",
        scrollButtons: {
            enable: false,
        }
    });
}
