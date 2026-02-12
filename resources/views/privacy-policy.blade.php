<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Privacy Policy</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/static-page.css') }}" />
</head>

<body>

    <!-- Header -->
    @include('components.header')

    <!-- PAGE BANNER -->
    <section class="page-banner">
        <h2>
            Privacy Policy
        </h2>
        <img src="{{ asset('images/divine_img.png') }}" alt="Divine Image" class="banner-image">
    </section>

    <section class="static-section">
        <div class="container static-content">
            <div class="static-info">
                
                <div class="intro-box">
                    <p>
                        We respect your privacy and are committed to protecting the personal information you share with us. 
                        This Privacy Policy explains how we collect, use, and safeguard your information when you use this application.
                    </p>
                </div>

                <div class="content-wrapper">
                    <h4>1. Information We Collect</h4>
                    <p>
                        When you use the app, we may collect the following information:
                    </p>
                    <ul>
                        <li>Basic personal details such as name, mobile number, email address, and location, if provided by you</li>
                        <li>Profile information you choose to share</li>
                        <li>App usage data to improve performance and user experience</li>
                    </ul>
                    <p>
                        We collect only the information that is necessary to provide and improve our services.
                    </p>

                    <h4>2. How We Use Your Information</h4>
                    <p>
                        Your information is used to:
                    </p>
                    <ul>
                        <li>Create and manage your account</li>
                        <li>Share updates about temple activities, events, and announcements</li>
                        <li>Improve app functionality and user experience</li>
                        <li>Communicate important notices related to the app</li>
                    </ul>
                    <p>
                        We do not sell, rent, or trade your personal information to third parties.
                    </p>

                    <h4>3. Data Security</h4>
                    <p>
                        We take reasonable technical and organizational measures to protect your personal data from unauthorized 
                        access, misuse, or disclosure. While we strive to protect your information, no digital platform can 
                        guarantee complete security.
                    </p>

                    <h4>4. Sharing of Information</h4>
                    <p>
                        Your information may be shared only:
                    </p>
                    <ul>
                        <li>When required by law</li>
                        <li>With trusted service providers who help us operate the app, under strict confidentiality</li>
                    </ul>

                    <h4>5. Your Choices</h4>
                    <p>
                        You may review or update your profile information within the app. If you wish to deactivate your account 
                        or have questions about your data, you may contact the app administrators.
                    </p>

                    <h4>6. Changes to This Policy</h4>
                    <p>
                        We may update this Privacy Policy from time to time. Any changes will be reflected within the app. 
                        Continued use of the app means you accept the updated policy.
                    </p>

                    <div class="note-box">
                        <p>
                            <strong>Note:</strong> If you have any questions regarding this Privacy Policy, please contact us at 
                            <strong>divydham@gmail.com</strong> or call <strong>+91 82383 46346</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('components.footer')

    <script src="{{ asset('js/header.js') }}"></script>
</body>

</html>
