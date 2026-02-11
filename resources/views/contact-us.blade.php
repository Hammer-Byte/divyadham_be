<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/contact-us.css') }}" />
</head>

<body>

    <!-- Header -->
    @include('components.header')

    <!-- PAGE BANNER -->
    <section class="page-banner">
        <h2>
            Contact Us
        </h2>
        <img src="{{ asset('images/divine_img.png') }}" alt="Divine Image" class="banner-image">
    </section>
    <section class="contact-section">
        <div class="container contact-content">
            <div class="contact-info">
                <h3>
                    Divyadham Temple
                    Contact Information
                </h3>
                <div class="contact-inner">
                    <div class="contact-icon">
                        <img src="{{ asset('images/call.png') }}" alt="call Icon" height="24" width="24">
                    </div>
                    <div class="contact-text">
                        <strong>Call Us:</strong>
                        +91 82383 46346
                    </div>
                </div>
                <div class="contact-inner">
                    <div class="contact-icon">
                        <img src="{{ asset('images/mail.png') }}" alt="mail Icon" height="24" width="30">
                    </div>
                    <div class="contact-text">
                        <strong>Send Email:</strong>
                        divydham@gmail.com
                    </div>
                </div>
                <div class="contact-inner">
                    <div class="contact-icon">
                        <img src="{{ asset('images/location.png') }}" alt="Location Icon" height="30" width="24">
                    </div>
                    <div class="contact-text">
                        <strong>Our Location:</strong>
                        Divyadham Temple, Valardi, Ta. Babra, G. Amreli- 365410
                    </div>
                </div>
            </div>
            <div class="map-wrapper">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14815.007952443111!2d71.20646953636724!3d21.828511404161944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39588b7d6be50abb%3A0x213b56df34f16f93!2sDivyadham%20Mandir!5e0!3m2!1sen!2sin!4v1770562811740!5m2!1sen!2sin"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>
    </section>
    <!-- Footer -->
    @include('components.footer')

    <script src="{{ asset('js/header.js') }}"></script>
</body>

</html>

