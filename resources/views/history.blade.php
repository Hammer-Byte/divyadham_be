<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>History</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/history.css') }}" />
</head>

<body>

    <!-- Header -->
    @include('components.header')

    <!-- PAGE BANNER -->
    <section class="page-banner">
        <h2>
            About History
        </h2>
        <img src="{{ asset('images/divine_img.png') }}" alt="Divine Image" class="banner-image">
    </section>

    <section class="about-temple">
        <div class="container about-grid">

            <!-- LEFT -->
            <div class="about-text">
                <div>
                    <h2>History</h2>
                    <p>
                        This sacred history dates back approximately 450 years. At that time, there were no well-formed
                        villages as we know today—only small hamlets scattered across the land. Human life was extremely
                        simple and harsh. Many people did not even possess sufficient clothing to cover their bodies,
                        and material wealth was almost nonexistent.
                    </p>
                    <p>
                        In such an era lived a frail yet spiritually luminous family, blessed with a remarkable child
                        named Pato Vaghasiya, only three years old. Despite his tender age, Pato possessed extraordinary
                        devotion. It is believed that he communicated daily with the Divine Mother, engaging in divine
                        conversations far beyond human comprehension.
                    </p>
                    <p>
                        The Mother Goddess would tell him:
                    </p>
                    <div class="divine-box">
                        "I am Veraimata, the deity of your lineage. Take me with you. Come to the forests of Junagadh,
                        and I shall reveal my divine proof."
                    </div>
                    <p>One day, Pato set out to bring the Goddess. At that moment, the Divine Mother manifested as a
                        sacred flame (Jyot) in the palm of his small hand. As he walked forward, a celestial voice
                        echoed from the heavens:
                    </p>
                    <div class="divine-box">
                        "Pato, you may take me with you—but after you, who will worship me?"
                    </div>
                    <p>With unwavering faith, Pato replied:</p>
                    <div class="divine-box">
                        "Mother, whether others worship you or not, I shall remain yours forever."
                    </div>
                    <p>Immediately after these words, the flame vanished from his hand, and another heavenly voice
                        declared:
                    </p>
                    <div class="divine-box">
                        "On the day you build my temple, I shall manifest again in the form of divine flame."
                    </div>
                    <p>Deeply saddened yet resolute, Pato devoted his entire life to this divine purpose. He dedicated
                        himself to the welfare of all eighteen communities, protected the dignity of the helpless, and
                        saved countless lives—ultimately sacrificing his own life in this sacred mission.
                    </p>
                    <p>The pillar (Khambhi) associated with his sacrifice is believed to remain spiritually alive even
                        today. Devotees firmly believe that sincere prayers offered here are fulfilled. Pato Dada is
                        said to manifest in serpent form (Nāg Swaroop), appearing in different forms to guide devotees
                        and draw them into his divine presence.
                    </p>
                    <p>
                        Pato Dada's final wish was that the entire Vaghasiya lineage and all eighteen communities unite
                        to build a temple for Veraimata, where she would once again manifest as a sacred flame and bring
                        welfare and harmony to the world.
                    </p>
                    <p>
                        Today, this holy site is located between Valardi and Chamardi villages, along the main road in
                        Babra Taluka, Amreli District, Gujarat, India.
                    </p>
                    <div class="address-box">
                        <ul>
                            <li>Location: Divyadham Mandir, Valardi</li>
                            <li>Taluka: Babra</li>
                            <li>District: Amreli</li>
                            <li>State: Gujarat</li>
                        </ul>
                        <ul>
                            <li>Approx. 80 km from Rajkot</li>
                            <li>32 km from Amreli</li>
                            <li>9 km from Babra</li>
                        </ul>
                    </div>
                    <p>This sacred place stands not merely as a temple, but as a living testament of devotion,
                        sacrifice, faith, and collective spiritual heritage.
                    </p>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="about-image">
                <img src="{{ asset('images/history_1.png') }}" alt="history_1">
                <img src="{{ asset('images/history_2.png') }}" alt="history_2">
            </div>

        </div>
    </section>
    <section class="divine-section">
        <div class="container">
            <h2>Events Video Gallery</h2>
            <div class="video-gallery">
                <div class="video-item">
                    <iframe 
                        src="https://www.youtube.com/embed/YOUTUBE_VIDEO_ID_1" 
                        title="Event Video 1"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="video-item">
                    <iframe 
                        src="https://www.youtube.com/embed/YOUTUBE_VIDEO_ID_2" 
                        title="Event Video 2"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="video-item">
                    <iframe 
                        src="https://www.youtube.com/embed/YOUTUBE_VIDEO_ID_3" 
                        title="Event Video 3"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    @include('components.footer')

    <script src="{{ asset('assets/js/header.js') }}"></script>
</body>

</html>

