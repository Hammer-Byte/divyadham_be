<!-- HEADER -->
<header class="header">
    <div class="container header-content">
        <a class="logo" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Temple Logo" width="220" height="100">
        </a>

        <nav class="nav" id="navMenu">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <div class="nav-item dropdown">
                <a href="#" class="dropdown-toggle">
                    About Us <span class="arrow"><img src="{{ asset('images/arrow-down.png') }}" alt="Arrow" /></span>
                </a>

                <ul class="dropdown-menu">
                    <li><a href="{{ route('about-temple') }}" class="{{ request()->routeIs('about-temple') ? 'active' : '' }}">About the temple</a></li>
                    <li><a href="{{ route('about-trust') }}" class="{{ request()->routeIs('about-trust') ? 'active' : '' }}">About trust</a></li>
                    <li><a href="{{ route('history') }}" class="{{ request()->routeIs('history') ? 'active' : '' }}">History</a></li>
                </ul>
            </div>
            <a href="{{ route('events') }}" class="{{ request()->routeIs('events') ? 'active' : '' }}">Events</a>
            <a href="{{ route('donation') }}" class="{{ request()->routeIs('donation') ? 'active' : '' }}">Donations</a>
            <a href="{{ route('photo-gallery') }}" class="{{ request()->routeIs('photo-gallery') ? 'active' : '' }}">Gallery</a>
            <a href="{{ route('contact-us') }}" class="{{ request()->routeIs('contact-us') ? 'active' : '' }}">Contact Us</a>
        </nav>

        <div class="translate-wrapper notranslate">
            <button type="button" class="language-btn" id="languageTrigger" aria-label="Change language">                
                <span class="language-text">Language</span>
            </button>
            <div id="google_translate_element" class="google-translate-dropdown"></div>
        </div>

        <div class="header-right">
            <a href="tel:+918238346346" class="call-btn"> <img src="{{ asset('images/phone.png') }}" alt="phone" width="18"
                    height="18"> +91-8238346346</a>
            <div class="menu-toggle" onclick="toggleMenu()">☰</div>
        </div>
    </div>
</header>

@once
<script>
(function() {
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,hi,gu,ta,te,kn,bn,mr,pa,ml,ur'
        }, 'google_translate_element');
        function attachLanguageClick() {
            var select = document.querySelector('#google_translate_element select.goog-te-combo');
            if (select) {
                var btn = document.getElementById('languageTrigger');
                if (btn && !btn._translateAttached) {
                    btn._translateAttached = true;
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        select.focus();
                        select.click();
                    });
                }
                return true;
            }
            return false;
        }
        if (!attachLanguageClick()) {
            var attempts = 0;
            var t = setInterval(function() {
                if (attachLanguageClick() || ++attempts > 20) clearInterval(t);
            }, 200);
        }
    }
    window.googleTranslateElementInit = googleTranslateElementInit;
    var script = document.createElement('script');
    script.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
    script.async = true;
    document.head.appendChild(script);
})();
</script>
@endonce
