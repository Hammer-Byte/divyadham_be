<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Terms and Conditions</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/static-page.css') }}" />
</head>

<body>

    <!-- Header -->
    @include('components.header')

    <!-- PAGE BANNER -->
    <section class="page-banner">
        <h2>
            Terms and Conditions
        </h2>
        <img src="{{ asset('images/divine_img.png') }}" alt="Divine Image" class="banner-image">
    </section>

    <section class="static-section">
        <div class="container static-content">
            <div class="static-info">
                
                <div class="intro-box">
                    <p>
                        By downloading, accessing, or using this application, you agree to the following Terms & Conditions. 
                        Please read them carefully.
                    </p>
                </div>

                <div class="content-wrapper">
                    <h4>1. Use of the App</h4>
                    <p>
                        This app is intended to provide information, updates, and services related to the community, temple, 
                        trust activities, and associated events. You agree to use the app only for lawful and respectful purposes.
                    </p>

                    <h4>2. User Responsibilities</h4>
                    <p>You are responsible for the accuracy of the information you provide.</p>
                    <ul>
                        <li>You must not misuse the app, post inappropriate content, or attempt to harm the platform or other users</li>
                        <li>You must not use the app for illegal, misleading, or harmful activities</li>
                    </ul>

                    <h4>3. Content and Information</h4>
                    <p>
                        All content provided in the app is for informational and community purposes. While we aim to keep 
                        information accurate and updated, we do not guarantee completeness or absolute accuracy at all times.
                    </p>

                    <h4>4. Donations and Payments</h4>
                    <p>
                        Any donations made through the app are voluntary and non-refundable unless otherwise stated. The app 
                        acts only as a platform to facilitate contributions.
                    </p>

                    <h4>5. Intellectual Property</h4>
                    <p>
                        All app content, including text, images, logos, and design elements, belongs to the app owners or 
                        respective rights holders and may not be copied or reused without permission.
                    </p>

                    <h4>6. Limitation of Liability</h4>
                    <p>
                        We are not responsible for any direct or indirect loss, technical issues, or interruptions arising 
                        from the use of the app. Use of the app is at your own discretion and responsibility.
                    </p>

                    <h4>7. Termination</h4>
                    <p>
                        We reserve the right to suspend or terminate access to the app if these Terms & Conditions are violated.
                    </p>

                    <h4>8. Changes to Terms</h4>
                    <p>
                        These Terms & Conditions may be updated periodically. Continued use of the app after updates indicates 
                        acceptance of the revised terms.
                    </p>

                    <div class="note-box">
                        <p>
                            <strong>Note:</strong> If you have any questions regarding these Terms & Conditions, please contact us at 
                            <strong>divydham@gmail.com</strong> or call <strong>+91 82383 46346</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('components.footer')

    <script src="{{ asset('assets/js/header.js') }}"></script>
</body>

</html>

