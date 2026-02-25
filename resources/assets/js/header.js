document.addEventListener("click", function (e) {

  const toggleBtn = e.target.closest(".dropdown-toggle");

  // CLICK ON DROPDOWN BUTTON
  if (toggleBtn) {
    e.preventDefault();

    const currentDropdown = toggleBtn.closest(".dropdown");

    // close all first
    document.querySelectorAll(".dropdown").forEach(d => {
      if (d !== currentDropdown) {
        d.classList.remove("open");
      }
    });

    // toggle current
    currentDropdown.classList.toggle("open");
    return;
  }

  // CLICK OUTSIDE → CLOSE ALL
  if (!e.target.closest(".dropdown")) {
    document.querySelectorAll(".dropdown")
      .forEach(d => d.classList.remove("open"));
  }

});

// Active link highlighting is now handled by Laravel Blade template
// This function is kept for backward compatibility but active class is set server-side
function toggleMenu() {
  document.getElementById("navMenu").classList.toggle("show");
}

// Header scroll effect - toggle white background on scroll
window.addEventListener('scroll', function() {
  const header = document.querySelector('.header');
  if (header) {
    if (window.scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }
});
