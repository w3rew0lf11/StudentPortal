// Theme Toggle Functionality
function initThemeToggle() {
  const themeToggle = document.getElementById("themeToggle");
  if (!themeToggle) return;

  const html = document.documentElement;

  // Check for saved theme or system preference
  const savedTheme = localStorage.getItem("theme");
  const systemPrefersDark = window.matchMedia(
    "(prefers-color-scheme: dark)"
  ).matches;

  // Determine initial theme
  let currentTheme = savedTheme || (systemPrefersDark ? "dark" : "light");

  // Apply theme
  html.setAttribute("data-theme", currentTheme);

  // Toggle theme when button is clicked
  themeToggle.addEventListener("click", () => {
    const newTheme =
      html.getAttribute("data-theme") === "dark" ? "light" : "dark";
    html.setAttribute("data-theme", newTheme);
    localStorage.setItem("theme", newTheme);
  });

  // Watch for system theme changes
  window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", (e) => {
      if (!localStorage.getItem("theme")) {
        html.setAttribute("data-theme", e.matches ? "dark" : "light");
      }
    });
}

document.addEventListener("DOMContentLoaded", initThemeToggle);

// Toggle password visibility
document.querySelectorAll(".toggle-password").forEach((button) => {
  button.addEventListener("click", function () {
    const input = this.parentElement.querySelector("input");
    const icon = this.querySelector("i");
    const type =
      input.getAttribute("type") === "password" ? "text" : "password";
    input.setAttribute("type", type);

    if (type === "password") {
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    } else {
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    }
  });
});

// Form toggling functionality
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".switch-form").forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const targetForm = e.target.getAttribute("data-target");

      document.querySelectorAll(".auth-form").forEach((form) => {
        form.classList.remove("active");
      });

      document.getElementById(targetForm).classList.add("active");
    });
  });
});

// Auto-remove alerts after 5 seconds
document.querySelectorAll(".alert").forEach((alert) => {
  setTimeout(() => {
    alert.style.opacity = "0";
    setTimeout(() => alert.remove(), 300);
  }, 5000);
});

// Clean URL after load
window.addEventListener("load", () => {
  if (
    window.location.search.includes("message=") ||
    window.location.search.includes("success=")
  ) {
    history.replaceState({}, "", window.location.pathname);
  }
});

// Close alert on '×' click
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".alert-close").forEach((btn) => {
    btn.addEventListener("click", function () {
      const alert = this.closest(".alert");
      if (alert) {
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), 300); // Wait for fade-out transition
      }
    });
  });
});
