// Petit effet : navbar 
(function () {
  const nav = document.getElementById("mainNavbar");
  if (!nav) return;

  function onScroll() {
    if (window.scrollY > 10) {
      nav.classList.add("py-1");
      nav.classList.remove("py-2");
    } else {
      nav.classList.add("py-2");
      nav.classList.remove("py-1");
    }
  }

  // init
  nav.classList.add("py-2");
  window.addEventListener("scroll", onScroll);
  onScroll();
})();
