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

        <div class="header-right">
            <a href="tel:+919876543210" class="call-btn"> <img src="{{ asset('images/phone.png') }}" alt="phone" width="18"
                    height="18"> +91-9876543210</a>
            <div class="menu-toggle" onclick="toggleMenu()">☰</div>
        </div>
    </div>
</header>

