/*==================================================================
[ Cross-Page Smooth Scrolling – Start at Top + 1s Delay ]
==================================================================*/
document.addEventListener("DOMContentLoaded", function () {
  const scrollSpeed = 800; // scroll duration (ms)
  const crossPageDelay = 1000; // wait before scrolling (ms)

  if (typeof $ !== "undefined") {
    // Smooth scroll for same-page navigation
    $('a[href*="#"]').on("click", function (e) {
      const href = $(this).attr("href");
      const [page, hash] = href.split("#");

      if (!hash) return; // no section ID

      // Same-page scrolling
      if (page === "" || page === window.location.pathname.split("/").pop()) {
        e.preventDefault();
        const target = $("#" + hash);
        if (target.length) {
          $("html, body").stop().animate(
            { scrollTop: target.offset().top },
            scrollSpeed
          );
        }
      } else {
        // Cross-page scrolling: save target and redirect
        sessionStorage.setItem("scrollTo", "#" + hash);
        // scroll to top immediately on next page
      }
    });

    // On new page load
    const scrollTarget = sessionStorage.getItem("scrollTo");
    if (scrollTarget) {
      sessionStorage.removeItem("scrollTo");

      // Prevent instant jump and reset to top
      history.replaceState(null, "", window.location.pathname);
      window.scrollTo(0, 0);

      // Wait before smooth scroll
      setTimeout(() => {
        const target = $(scrollTarget);
        if (target.length) {
          $("html, body").stop().animate(
            { scrollTop: target.offset().top },
            scrollSpeed
          );
          // Add hash back to the URL
          history.replaceState(null, "", scrollTarget);
        }
      }, crossPageDelay);
    }
  }
});