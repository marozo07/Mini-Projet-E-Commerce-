
(function () {
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mainNav = document.getElementById('mainNav');
    const navOverlay = document.getElementById('navOverlay');

    function openNav() {
        mainNav.classList.add('open');
        hamburgerBtn.classList.add('active');
        hamburgerBtn.setAttribute('aria-label', 'Fermer le menu');
        navOverlay.classList.add('visible');
        navOverlay.setAttribute('aria-hidden', 'false');
        document.body.classList.add('nav-open');
    }

    function closeNav() {
        mainNav.classList.remove('open');
        hamburgerBtn.classList.remove('active');
        hamburgerBtn.setAttribute('aria-label', 'Ouvrir le menu');
        navOverlay.classList.remove('visible');
        navOverlay.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('nav-open');
    }

    function toggleNav() {
        if (mainNav.classList.contains('open')) {
            closeNav();
        } else {
            openNav();
        }
    }

    if (hamburgerBtn && mainNav && navOverlay) {
        hamburgerBtn.addEventListener('click', toggleNav);
        navOverlay.addEventListener('click', closeNav);

        mainNav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeNav);
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && mainNav.classList.contains('open')) {
                closeNav();
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 768 && mainNav.classList.contains('open')) {
                closeNav();
            }
        });
    }
})();
