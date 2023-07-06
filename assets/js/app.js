!function (e) {
    "use strict";
    var o, t;
    e(".dropdown-menu a.dropdown-toggle").on("click", function (t) {
        return e(this).next().hasClass("show") || e(this).parents(".dropdown-menu").first().find(".show").removeClass("show"),
            e(this).next(".dropdown-menu").toggleClass("show"),
            !1
    }),
        [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function (t) {
            return new bootstrap.Tooltip(t)
        }),
        [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function (t) {
            return new bootstrap.Popover(t)
        }),
        o = document.getElementsByTagName("body")[0],
        (t = document.querySelectorAll(".light-dark-mode")) && t.length && t.forEach(function (t) {
            t.addEventListener("click", function (t) {

                if (o.hasAttribute("data-bs-theme") && "dark" == o.getAttribute("data-bs-theme")) {
                    document.body.setAttribute("data-bs-theme", "light")
                    localStorage.setItem("darkMode","light");
                } else {
                    document.body.setAttribute("data-bs-theme", "dark")
                    localStorage.setItem("darkMode","dark");
                }

            })
        }),
        Waves.init()
}(jQuery);
