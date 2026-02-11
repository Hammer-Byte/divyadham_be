<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Events</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/event.css') }}" />
</head>

<body>

    <!-- Header -->
    @include('components.header')

    <!-- PAGE BANNER -->
    <section class="page-banner">
        <h2>
            Events
        </h2>
        <img src="{{ asset('images/divine_img.png') }}" alt="Divine Image" class="banner-image">
    </section>

    <section class="events">
        <div class="container">

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active" data-tab="upcoming">Upcoming Events</button>
                <button class="tab" data-tab="ongoing">Ongoing Events</button>
                <button class="tab" data-tab="previous">Previous Events</button>
            </div>

            <!-- TAB 1 -->
            <div class="tab-content active" id="upcoming">
                <div class="event-item">
                    <div class="thumb">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="info">
                        <div class="date">14.10.2025 | 09:00 AM</div>
                        <h3>Event 1</h3>
                        <p>
                            A grand temple of Maa Bhagwati is being constructed on the sacred land of Valardi village,
                            11 km from Babra in Amreli district, Gujarat, for the welfare of all living beings. The
                            temple will cover 60,000 sq. ft, adorned with 111,000 cubic ft of white marble stone.
                        </p>
                    </div>
                </div>

                <div class="event-item">
                    <div class="thumb"></div>
                    <div class="info">
                        <div class="date">14.10.2025 | 09:00 AM</div>
                        <h3>Event 2</h3>
                        <p>
                            A grand temple of Maa Bhagwati is being constructed on the sacred land of Valardi village,
                            11 km from Babra in Amreli district, Gujarat, for the welfare of all living beings. The
                            temple will cover 60,000 sq. ft, adorned with 111,000 cubic ft of white marble stone. </p>
                    </div>
                </div>
            </div>

            <!-- TAB 2 -->
            <div class="tab-content" id="ongoing">
                <div class="event-item">
                    <div class="thumb"></div>
                    <div class="info">
                        <div class="date">Today</div>
                        <h3>Live Darshan</h3>
                        <p>Watch ongoing temple activities and aarti.</p>
                    </div>
                </div>
            </div>

            <!-- TAB 3 -->
            <div class="tab-content" id="previous">
                <div class="event-item">
                    <div class="thumb"></div>
                    <div class="info">
                        <div class="date">Completed</div>
                        <h3>Navratri Mahotsav</h3>
                        <p>Thank you for joining the grand celebration.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="divine-section">
        <div class="container ">
            <h2>Events Photo Gallery</h2>
            <div class="divine-slider swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery-img.png') }}" alt="Gallery Photo">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery-img.png') }}" alt="Gallery Photo">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery-img.png') }}" alt="Gallery Photo">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/gallery-img.png') }}" alt="Gallery Photo">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    @include('components.footer')

    <script src="{{ asset('js/header.js') }}"></script>
    <script src="{{ asset('js/tab.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".divine-slider", {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,

            autoplay: {
                delay: 1000,
                disableOnInteraction: false,
            },

            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                600: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
            },
        });
    </script>
</body>

</html>

