<footer class="site-footer">
    <div class="container footer-inner">
        <!-- Logo -->
        <a class="footer-logo" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Divya Dham Valasri" width="300" height="150">
        </a>

        <!-- Links -->
        <div class="footer-links">
            <div class="link-col">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('events') }}">Events</a></li>
                    <li><a href="{{ route('donation') }}">Donations</a></li>
                    <li><a href="{{ route('photo-gallery') }}">Gallery</a></li>
                    <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                </ul>
            </div>

            <div class="link-col">
                <h4>About Us</h4>
                <div class="second-col">
                    <ul>
                        <li><a href="{{ route('about-temple') }}">About Temple</a></li>
                        <li><a href="{{ route('about-trust') }}">About Trust</a></li>
                        <li><a href="{{ route('history') }}">History</a></li>
                        <li><a>Committee</a></li>
                    </ul>
                    <ul>
                        <li><a>How to Reach</a></li>
                        <li><a>Campus Facility</a></li>
                        <li><a>Nearby Places</a></li>
                        <li><a>Interesting Facts</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Social -->
        <div class="footer-social">
            <h4>Follow Us</h4>
            <div class="social-icons">
                <a href="#"><img src="{{ asset('images/instagram_icon.png') }}" alt="instagram icon"></a>
                <a href="#"><img src="{{ asset('images/whatsapp.png') }}" alt="whatsapp icon"></a>
                <a href="#"><img src="{{ asset('images/youtube.png') }}" alt="youtube icon"></a>
                <a href="#"><img src="{{ asset('images/facebook_icon.png') }}" alt="facebook icon"></a>
            </div>
        </div>
    </div>

    <!-- Bottom bar -->
    <div class="footer-bottom">
        All Rights Reserved | Copyright 2025 - Divya Dham Valaradi
    </div>
</footer>

