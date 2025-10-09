/*==================================================================
[ Smooth Scrolling: Hybrid - Universal Effect ]
==================================================================*/
document.addEventListener("DOMContentLoaded", function () {
  if (typeof $ !== "undefined") {
    // jQuery smooth scroll
    $('a[href^="#"]').on("click", function (e) {
      var target = $(this.getAttribute("href"));
      if (target.length) {
        e.preventDefault();
        $("html, body").stop().animate(
          {
            scrollTop: target.offset().top,
          },
          800 // standard speed
        );
      }
    });
  } else {
    // Vanilla JS fallback
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));
        if (target) {
          target.scrollIntoView({
            behavior: "smooth",
            block: "start",
          });
        }
      });
    });
  }
});