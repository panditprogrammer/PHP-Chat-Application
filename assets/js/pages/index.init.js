$(document).ready(function () {
    $(".popup-img").magnificPopup({
        type: "image",
        closeOnContentClick: !0,
        mainClass: "mfp-img-mobile",
        image: {
            verticalFit: !0
        }
    });
    $("#user-status-carousel").owlCarousel({
        items: 4,
        loop: !1,
        margin: 16,
        nav: !1,
        dots: !1
    });
    $("#chatinputmorelink-carousel").owlCarousel({
        items: 2,
        loop: !1,
        margin: 16,
        nav: !1,
        dots: !1,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 5,
                nav: !1
            },
            992: {
                items: 8
            }
        }
    });
    $("#user-profile-hide").click(function () {
        $(".user-profile-sidebar").hide()
    });
    $(".user-profile-show").click(function () {
        $(".user-profile-sidebar").show()
    });

    // user chat conversation section 
    // $(".chat-user-list li a").click(function() {
    //     $(".user-chat").addClass("user-chat-show")
    // }),
    // $(".user-chat-remove").click(function() {
    //     $(".user-chat").removeClass("user-chat-show")
    // })
});
