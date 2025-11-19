// --- Prevent white flash before DOM loads ---
(function() {
  const savedMode = localStorage.getItem("darkMode");
  if (savedMode === "enabled") {
    // Enable dark mode immediately before rendering
    const link = document.getElementById("dark-mode-css");
    if (link) link.removeAttribute("disabled");
    document.documentElement.style.backgroundColor = "#232323"; // Optional dark fallback
  }
})();

document.addEventListener("DOMContentLoaded", function () {
  const toggle = document.getElementById("darkModeToggle");
  const darkCss = document.getElementById("dark-mode-css");

  if (!toggle || !darkCss) return;

  const knob = toggle.querySelector(".darkbtn");

  // Disable all transitions temporarily (Since we can't disable CSS transitions directly)
  function disableTransitionsTemporarily() {
    const style = document.createElement("style");
    style.id = "disable-transitions-style";
    style.innerHTML = `*, *::before, *::after { transition: none !important; }`;
    document.head.appendChild(style);

    // Remove after a short delay once mode is applied
    setTimeout(() => style.remove(), 150);
  }

  // --- Apply saved preference ---
  const savedMode = localStorage.getItem("darkMode");
  if (savedMode === "enabled") {
    darkCss.removeAttribute("disabled");
    if (knob) knob.textContent = "🌙";
  } else {
    darkCss.setAttribute("disabled", "");
    if (knob) knob.textContent = "☀️";
  }

  // --- Toggle mode on click ---
  toggle.addEventListener("click", () => {
    disableTransitionsTemporarily();

    const isDark = !darkCss.hasAttribute("disabled");

    if (isDark) {
      // Turn off dark mode
      darkCss.setAttribute("disabled", "");
      localStorage.setItem("darkMode", "disabled");
      if (knob) knob.textContent = "☀️";
      document.documentElement.style.backgroundColor = "#fff";
    } else {
      // Turn on dark mode
      darkCss.removeAttribute("disabled");
      localStorage.setItem("darkMode", "enabled");
      if (knob) knob.textContent = "🌙";
      document.documentElement.style.backgroundColor = "#232323";
    }
  });
});