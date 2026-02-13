<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Disclaimer</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/static-page.css') }}" />
</head>

<body>

    <!-- Header -->
    @include('components.header')

    <!-- PAGE BANNER -->
    <section class="page-banner">
        <h2>
            Disclaimer
        </h2>
        <img src="{{ asset('images/divine_img.png') }}" alt="Divine Image" class="banner-image">
    </section>

    <section class="static-section">
        <div class="container static-content">
            <div class="static-info">
                
                <div class="intro-box">
                    <p>
                        The information provided in this application is for general informational purposes only. While we strive 
                        to keep the information accurate and up-to-date, we make no representations or warranties of any kind 
                        regarding the completeness, accuracy, reliability, or suitability of the information.
                    </p>
                </div>

                <div class="content-wrapper">
                    <h4>1. General Information</h4>
                    <p>
                        The content provided in this app is intended for informational and community purposes related to the 
                        temple, trust activities, and associated events. All information is provided on an "as is" basis without 
                        any warranties or guarantees.
                    </p>

                    <h4>2. No Liability</h4>
                    <p>
                        We shall not be liable for any direct, indirect, incidental, special, or consequential damages arising 
                        from the use of this app or reliance on any information provided. Use of the app is at your own risk 
                        and discretion.
                    </p>

                    <h4>3. Event Information</h4>
                    <p>
                        Event dates, times, locations, and details are subject to change without prior notice. While we make 
                        every effort to provide accurate information, we are not responsible for any inconvenience caused due 
                        to changes or cancellations.
                    </p>

                    <h4>4. Donations</h4>
                    <p>
                        All donations made through this app are voluntary contributions. Donations are non-refundable and 
                        non-cancellable. The Trust reserves the right to use donations for religious, charitable, and social 
                        welfare purposes as determined appropriate.
                    </p>

                    <h4>5. Religious Content</h4>
                    <p>
                        The religious and spiritual content provided in this app is based on traditional beliefs and practices. 
                        This content is not intended to replace professional medical, legal, or financial advice. Any spiritual 
                        guidance should not be considered as a substitute for professional consultation.
                    </p>

                    <h4>6. External Links</h4>
                    <p>
                        This app may contain links to external websites or resources. We are not responsible for the content, 
                        accuracy, or availability of such external sites. The inclusion of any link does not imply endorsement 
                        by the Trust.
                    </p>

                    <h4>7. Technical Issues</h4>
                    <p>
                        While we strive to maintain the app's functionality, we are not responsible for any technical issues, 
                        interruptions, or errors that may occur. The app may be temporarily unavailable due to maintenance, 
                        updates, or technical problems beyond our control.
                    </p>

                    <h4>8. User Responsibility</h4>
                    <p>
                        Users are responsible for ensuring the accuracy of information they provide and for their use of the app. 
                        We are not liable for any consequences resulting from misuse of the app or reliance on inaccurate 
                        information provided by users.
                    </p>

                    <div class="note-box">
                        <p>
                            <strong>Note:</strong> By using this application, you acknowledge that you have read, understood, and agree to 
                            this Disclaimer. If you have any questions, please contact us at 
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
