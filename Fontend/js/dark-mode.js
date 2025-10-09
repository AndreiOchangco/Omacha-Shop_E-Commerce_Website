/*==================================================================
[ Universal Dark Mode Toggle ]
==================================================================*/
document.addEventListener("DOMContentLoaded", function () {
  const toggle = document.getElementById("darkModeToggle");
  const darkCss = document.getElementById("dark-mode-css");

  // Make sure elements exist before running
  if (!toggle || !darkCss) return;

  const knob = toggle.querySelector(".darkbtn");

  // --- Apply Saved Preference on Load ---
  const savedMode = localStorage.getItem("darkMode");
  if (savedMode === "enabled") {
    darkCss.removeAttribute("disabled");
    if (knob) knob.textContent = "🌙";
  } else {
    darkCss.setAttribute("disabled", "");
    if (knob) knob.textContent = "☀️";
  }

  // --- Toggle Dark Mode on Click ---
  toggle.addEventListener("click", () => {
    const isDark = !darkCss.hasAttribute("disabled");

    if (isDark) {
      // Turn off dark mode
      darkCss.setAttribute("disabled", "");
      localStorage.setItem("darkMode", "disabled");
      if (knob) knob.textContent = "☀️";
    } else {
      // Turn on dark mode
      darkCss.removeAttribute("disabled");
      localStorage.setItem("darkMode", "enabled");
      if (knob) knob.textContent = "🌙";
    }
  });
});