<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Trust</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/about-trust.css') }}" />
</head>

<body>

    <!-- Header -->
    @include('components.header')

    <!-- PAGE BANNER -->
    <section class="page-banner">
        <h2>
            Divine Temple of Trust - Valardi
        </h2>
        <img src="{{ asset('images/divine_img.png') }}" alt="Divine Image" class="banner-image">
    </section>

    <section class="about-temple">
        <div class="container about-grid">

            <!-- LEFT -->
            <div class="about-text">
                <div>
                    <h2>Establishment and Background</h2>
                    <p>
                        Divyadham Charitable Trust was established with the noble purpose of systematically advancing
                        the
                        religious, social, and humanitarian activities associated with the sacred Divyadham, located at
                        Valardi in Babra Taluka of Amreli District, Gujarat.
                        Inspired by the divine grace of Veraimata and Pato Dada, the trust was founded by devoted
                        followers
                        to give an organized and enduring structure to centuries-old faith, sacrifice, and spiritual
                        heritage, and to channel it towards the welfare of society.
                    </p>
                </div>
                <div class="core-objectives">
                    <h2>Core Objectives of the Trust</h2>
                    <p>
                        The primary objectives of Divyadham Charitable Trust are:
                    </p>
                    <ul>
                        <li>To promote and preserve religious culture, traditions, and spiritual values</li>
                        <li>To instill the belief that "Service to humanity is the highest form of service to God"</li>
                        <li>To provide selfless support to the poor, needy, underprivileged, and distressed</li>
                        <li>To foster social harmony, unity, compassion, and spiritual awareness</li>
                    </ul>
                    <p>To guide society through service, values, and collective commitment</p>
                </div>

            </div>

            <!-- RIGHT -->
            <div class="about-image">
                <img src="{{ asset('images/about_trust_1.png') }}" alt="about_trust_1">
            </div>

        </div>
    </section>
    <div class="temple-image"></div>
    <section class="services">
        <div class="container">
            <h2 class="section-title">Key Service Activities</h2>

            <div class="service-grid">

                <!-- Card -->
                <div class="service-card">
                    <div class="card-head">Religious Services</div>
                    <div class="card-body">
                        <strong>Akhand Homkund Yagna</strong>
                        <p>
                            A 24-hour uninterrupted sacred fire ritual with continuous chanting
                            in devotion to the Goddess
                        </p>
                    </div>
                </div>

                <!-- Card -->
                <div class="service-card">
                    <div class="card-head">Food Service</div>
                    <div class="card-body">
                        <strong>Annakshetra (Free Food Service)</strong>
                        <p>
                            Providing free meals to pilgrims, devotees, and the needy
                        </p>
                    </div>
                </div>

                <!-- Card -->
                <div class="service-card">
                    <div class="card-head">Healthcare Services</div>
                    <div class="card-body">
                        <ul>
                            <li>Free medical check-up camps</li>
                            <li>Blood donation camps</li>
                        </ul>
                    </div>
                </div>

                <!-- Card -->
                <div class="service-card">
                    <div class="card-head">Cow Protection (Gauseva)</div>
                    <div class="card-body">
                        <ul>
                            <li>Providing fodder and care for cows</li>
                            <li>Ensuring protection and welfare of cattle</li>
                        </ul>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="service-card">
                    <div class="card-head">Social Welfare</div>
                    <div class="card-body">
                        <ul>
                            <li>Food support for orphaned and underprivileged children</li>
                            <li>De-addiction awareness and rehabilitation initiatives</li>
                        </ul>
                    </div>
                </div>

                <div class="service-card">
                    <div class="card-head">Environmental Service</div>
                    <div class="card-body">
                        <ul>
                            <li>Tree plantation drives</li>
                            <li>Environmental conservation and awareness programs</li>
                        </ul>
                    </div>
                </div>

                <div class="service-card">
                    <div class="card-head">Compassion for Living Beings</div>
                    <div class="card-body">
                        <ul>
                            <li>Providing food for ants and small creatures</li>
                            <li>Feeding grains and providing water for birds</li>
                        </ul>
                    </div>
                </div>

                <div class="service-card">
                    <div class="card-head">Facilities for Devotees</div>
                    <div class="card-body">
                        <ul>
                            <li>Construction of Divya Bhavan (a grand Dharamshala)</li>
                            <li>Accommodation facilities for thousands of pilgrims and visitors</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="divine-section">
        <div class="divine-container">
            <h2>Divine Resolution</h2>
            <p>
                The guiding principle of Divyadham Charitable Trust is:
            </p>
            <div class="divine-center">
                <img src="{{ asset('images/quote.png') }}" alt="quote img" width="40" height="34">
                <h5>To uplift society on a spiritual and humane path through service, values, and unwavering commitment</h5>
            </div>
            <p>
                The Trust stands not merely as an institution, but as a living embodiment of faith, compassion, and
                collective service.
            </p>
        </div>
    </section>

    <!-- Footer -->
    @include('components.footer')

    <script src="{{ asset('assets/js/header.js') }}"></script>
</body>

</html>

