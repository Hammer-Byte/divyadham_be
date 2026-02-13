<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Divya Dham</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>

<body>
    @include('components.header')

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-overlay"></div>

        <div class="container hero-content">
            <div class="hero-text">
                <h1>
                    A divine temple rising for<br />
                    the welfare of all, by the<br />
                    grace of <span>Maa Bhagwati</span>
                </h1>
            </div>
        </div>
    </section>
    <div class="add-bottom"></div>
    <section class="about-section">
        <div class="container about-container">

            <!-- Left Content -->
            <div class="about-content">
                <h2>About Divyadham</h2>
                <p>
                    A grand temple of Maa Bhagwati is being constructed at the sacred land
                    of Valvadi village, 11 km from Babra in Amreli district, Gujarat, for the
                    welfare of all living beings. The temple will cover 60000 sq ft,
                    adorned with 11000 cubic ft of white marble stone.
                </p>
                <p>
                    The temple's design includes artistic carvings of elephants and horses,
                    along with 64 Yogini Mata idols on the perimeter walls. Inside the
                    sanctum, there will be 51 beautifully crafted idols representing Shakti
                    Peethas.
                </p>
                <p>
                    Built as per traditional shilpa shastra principles, the temple will
                    symbolize Maa Bhagwati as an eternal source of divine energy, becoming
                    part of this divine effort and earning spiritual merit.
                </p>

                <a href="#" class="btn">Know More</a>
            </div>

            <!-- Right Image -->
            <div class="about-image">
                <img src="{{ asset('images/mata.png') }}" alt="Jay Verai Mataji" height="470" width="100%" />
            </div>

        </div>
    </section>
    <section class="darshan-section">
        <div class="darshan-background"></div>
        <div class="container darshan-container">

            <!-- Top Border Pattern -->
            <div class="pattern top"></div>

            <h2 class="section-title">Daily Darshan</h2>

            <div class="darshan-cards">

                <!-- Card 1 -->
                <div class="darshan-card">
                    <div class="card-title">Verai Mataji</div>
                    <div class="video-box">
                        <video id="video1" poster="{{ asset('images/gallery-img.png') }}">
                            <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                        </video>
                        <div class="play-btn" onclick="toggleVideo('video1', this)"></div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="darshan-card">
                    <div class="card-title">Pata Dada</div>
                    <div class="video-box">
                        <video id="video2" poster="{{ asset('images/event_1.png') }}">
                            <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                        </video>
                        <div class="play-btn" onclick="toggleVideo('video2', this)"></div>
                    </div>
                </div>

            </div>

            <!-- Bottom Border Pattern -->
            <div class="pattern bottom"></div>

        </div>
    </section>
    <section class="events-section">
        <h2 class="events-title">Upcoming Events or Festival</h2>

        <div class="container events-container">

            <!-- Card -->
            <div class="event-card">
                <div class="event-img">
                    <img src="{{ asset('images/event_1.png') }}" alt="Event">
                    <span class="event-date">02 Oct, 2025 | 02:00 PM</span>
                </div>
                <div class="event-content">
                    <h3>Aenean eu ante sit amet neque pretium ullamcorper</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin elementum iaculis convallis.</p>
                </div>
                <div class="arrow-btn"><span class="arrow-icon"></span></div>
            </div>

            <!-- Card -->
            <div class="event-card">
                <div class="event-img">
                    <img src="{{ asset('images/event_2.png') }}" alt="Event">
                    <span class="event-date">02 Oct, 2025 | 02:00 PM</span>
                </div>
                <div class="event-content">
                    <h3>Aenean eu ante sit amet neque pretium ullamcorper</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin elementum iaculis convallis.</p>
                </div>
                <div class="arrow-btn"><span class="arrow-icon"></span></div>
            </div>

            <!-- Card -->
            <div class="event-card">
                <div class="event-img">
                    <img src="{{ asset('images/event_3.png') }}" alt="Divyadham">
                    <span class="event-date">02 Oct, 2025 | 02:00 PM</span>
                </div>
                <div class="event-content">
                    <h3>Aenean eu ante sit amet neque pretium ullamcorper</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin elementum iaculis convallis.</p>
                </div>
                <div class="arrow-btn"><span class="arrow-icon"></span></div>
            </div>

            <!-- Card -->
            <div class="event-card">
                <div class="event-img">
                    <img src="{{ asset('images/event_4.png') }}" alt="Event">
                    <span class="event-date">02 Oct, 2025 | 02:00 PM</span>
                </div>
                <div class="event-content">
                    <h3>Aenean eu ante sit amet neque pretium ullamcorper</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin elementum iaculis convallis.</p>
                </div>
                <div class="arrow-btn"><span class="arrow-icon"></span></div>
            </div>

        </div>

        <div class="center-btn">
            <a href="{{ route('events') }}" class="check-more">Check More <span>»</span></a>
        </div>
    </section>
    <section class="join-parivar">
        <div class="join-background"></div>
        <div class="container parivar-container">
            <h2>Join Parivar</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Proin elementum iaculis convallis
            </p>

            <div class="store-buttons">
                <a href="#" class="store-btn">
                    <span class="icon"><img src="{{ asset('images/googleplay.png') }}" alt="Google Play Store" width="52"
                            height="57"></span>
                    <span class="text">
                        Download the app from
                        Google Play Store
                    </span>
                </a>

                <a href="#" class="store-btn">
                    <span class="icon"><img src="{{ asset('images/apple.png') }}" alt="Apple App Store" width="52" height="58"></span>
                    <span class="text">
                        Download the app from
                        Apple App Store
                    </span>
                </a>
            </div>
        </div>
    </section>
    <section class="info-section">
        <div class="container info-container">

            <!-- Donations Card -->
            <div class="card">
                <div class="card-header">
                    <h3>Donations</h3>
                    <a href="{{ route('donation') }}" class="header-btn">Donate Now »</a>
                </div>

                <div class="card-body donation-body">
                    <div class="donation-img">
                        <img src="{{ asset('images/donation_img.png') }}" alt="Donation" width="180" height="180">
                    </div>

                    <div class="donation-content">
                        <p>
                            Be part of the Maa Bhagwati Temple's divine journey.
                            Your donation is a sacred offering that brings blessings
                            and eternal merit.
                        </p>

                        <div class="donation-tags">
                            <span>Pooja</span>
                            <span>Gaushala</span>
                            <span>Renovation</span>
                            <span>Utsav</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blogs Card -->
            <div class="card">
                <div class="card-header">
                    <h3>Blogs</h3>
                    <a href="#" class="header-btn">View Blogs»</a>
                </div>

                <div class="card-body blog-body">
                    <ul class="blog-list">
                        <li>
                            <div>1.</div> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Phasellus ornare non ante sed auctor
                        </li>
                        <li>
                            <div>2.</div> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Phasellus ornare non ante sed auctor
                        </li>
                        <li>
                            <div>3.</div> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Phasellus ornare non ante sed auctor
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </section>
    @include('components.footer')
    
    <script src="{{ asset('assets/js/header.js') }}"></script>
    <script>
        function toggleVideo(videoId, btn) {
            var video = document.getElementById(videoId);

            // Pause all other videos (optional but good)
            document.querySelectorAll("video").forEach(v => {
                if (v.id !== videoId) {
                    v.pause();
                    if (v.nextElementSibling) {
                        v.nextElementSibling.classList.remove("pause");
                    }
                }
            });

            if (video.paused) {
                video.play();
                btn.classList.add("pause");   // change to pause icon
            } else {
                video.pause();
                btn.classList.remove("pause"); // back to play icon
            }
        }

        /* When video finished */
        document.querySelectorAll("video").forEach(video => {
            video.addEventListener("ended", function () {
                if (this.nextElementSibling) {
                    this.nextElementSibling.classList.remove("pause");
                }
            });
        });
    </script>

</body>

</html>

