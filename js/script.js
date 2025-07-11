// Theme Toggle Functionality
function initThemeToggle() {
  const themeToggle = document.getElementById("themeToggle");
  if (!themeToggle) return;

  const html = document.documentElement;

  const savedTheme = localStorage.getItem("theme");
  const systemPrefersDark = window.matchMedia(
    "(prefers-color-scheme: dark)"
  ).matches;
  let currentTheme = savedTheme || (systemPrefersDark ? "dark" : "light");

  html.setAttribute("data-theme", currentTheme);

  themeToggle.addEventListener("click", () => {
    const newTheme =
      html.getAttribute("data-theme") === "dark" ? "light" : "dark";
    html.setAttribute("data-theme", newTheme);
    localStorage.setItem("theme", newTheme);
  });

  window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", (e) => {
      if (!localStorage.getItem("theme")) {
        html.setAttribute("data-theme", e.matches ? "dark" : "light");
      }
    });
}

document.addEventListener("DOMContentLoaded", () => {
  initThemeToggle();

  // Password visibility toggle
  document.querySelectorAll(".toggle-password").forEach((button) => {
    button.addEventListener("click", function () {
      const input = this.parentElement.querySelector("input");
      const icon = this.querySelector("i");
      const type =
        input.getAttribute("type") === "password" ? "text" : "password";
      input.setAttribute("type", type);

      icon.classList.toggle("fa-eye");
      icon.classList.toggle("fa-eye-slash");
    });
  });

  // Form toggling
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

  // Close alert on '×' click
  document.querySelectorAll(".alert-close").forEach((btn) => {
    btn.addEventListener("click", function () {
      const alert = this.closest(".alert");
      if (alert) {
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), 300);
      }
    });
  });

  // ✅ Testimonial Slider Logic
  const slides = document.querySelectorAll(".testimonial-slide");
  const prevBtn = document.querySelector(".slider-prev");
  const nextBtn = document.querySelector(".slider-next");
  const dotsContainer = document.querySelector(".slider-dots");
  let currentIndex = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle("active", i === index);
    });

    if (dotsContainer) {
      Array.from(dotsContainer.children).forEach((dot, i) => {
        dot.classList.toggle("active", i === index);
      });
    }
  }

  function createDots() {
    if (!dotsContainer) return;
    slides.forEach((_, index) => {
      const dot = document.createElement("span");
      dot.classList.add("dot");
      if (index === 0) dot.classList.add("active");
      dot.addEventListener("click", () => {
        currentIndex = index;
        showSlide(currentIndex);
      });
      dotsContainer.appendChild(dot);
    });
  }

  if (slides.length > 0) {
    createDots();
    showSlide(currentIndex);

    if (prevBtn) {
      prevBtn.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(currentIndex);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
      });
    }
  }
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
