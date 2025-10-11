document.addEventListener("DOMContentLoaded", function () {
  const toggle = document.getElementById("darkModeToggle");
  const darkCss = document.getElementById("dark-mode-css");

  if (!toggle || !darkCss) return;
  const knob = toggle.querySelector(".darkbtn");

  // --- Disable all transitions temporarily ---
  function disableTransitionsTemporarily() {
    const style = document.createElement("style");
    style.id = "disable-transitions-style";
    style.innerHTML = `*, *::before, *::after { transition: none !important; }`;
    document.head.appendChild(style);

    // Remove after short delay (once theme is applied)
    setTimeout(() => {
      style.remove();
    }, 100);
  }

  // --- Apply Saved Preference on Load ---
  const savedMode = localStorage.getItem("darkMode");
  if (savedMode === "enabled") {
    darkCss.removeAttribute("disabled");
    if (knob) knob.textContent = "🌙";
  } else {
    darkCss.setAttribute("disabled", "");
    if (knob) knob.textContent = "☀️";
  }

  // --- Toggle Dark Mode ---
  toggle.addEventListener("click", () => {
    disableTransitionsTemporarily(); // Stop transitions instantly
    const isDark = !darkCss.hasAttribute("disabled");

    if (isDark) {
      darkCss.setAttribute("disabled", "");
      localStorage.setItem("darkMode", "disabled");
      if (knob) knob.textContent = "☀️";
    } else {
      darkCss.removeAttribute("disabled");
      localStorage.setItem("darkMode", "enabled");
      if (knob) knob.textContent = "🌙";
    }
  });
});