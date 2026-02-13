<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Temple</title>
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/about-template.css') }}" />
</head>

<body>

  <!-- Header -->
  @include('components.header')

  <!-- PAGE BANNER -->
  <section class="page-banner">
    <h2>
      Divine Temple of Aadya Shree Verai Mata - Valardi
    </h2>
    <img src="{{ asset('images/divine_img.png') }}" alt="Divine Image" class="banner-image">
  </section>

  <!-- CONTENT -->
  <section class="about-temple">
    <div class="container about-grid">

      <!-- LEFT -->
      <div class="about-text">
        <h2>Sacred Land and Vision</h2>
        <p>
          On the sacred land of Valardi village, located approximately 11 kilometers
          from Babra Taluka in Amreli district, Gujarat, a grand and divine temple of
          Aadya Shree Maa Bhagwati is envisioned.
          This temple will stand not merely as a religious monument, but as a
          spiritual center radiating faith, devotion, and cultural values.
        </p>

        <h2>Scale and Construction Material</h2>
        <p>
          The total area of the temple complex will span approximately 60000 square
          feet. The structure will be adorned with intricately carved elements and
          premium white marble, reflecting purity, grace, and spiritual prominence.
        </p>

        <h2>Sculptural Grandeur and Aesthetics</h2>
        <p>
          The circumambulatory path (Pradakshina Path) will feature exquisitely carved elephant and horse sculptures,
          symbolizing strength, protection, and divine authority. The temple complex will also house 64 beautifully
          sculpted idols of the Jogani Mata, representing various manifestations of Shakti worship.
          Within the inner sanctum (Guhya Mandap) of the main shrine, 51 artistically crafted idols of the Shakti
          Peethas, integrated with traditional architectural elements, will be installed—presenting a sacred spiritual
          map of India's Shakti tradition.
        </p>
      </div>

      <!-- RIGHT -->
      <div class="about-image">
        <img src="{{ asset('images/divine_side.png') }}" alt="Temple">
      </div>

    </div>
  </section>
  <div class="temple-image"></div>
  <section class="about-temple">
    <div class="container about-second-grid">
      <!-- LEFT -->
      <div class="about-image">
        <img src="{{ asset('images/divine_side.png') }}" alt="Temple">
      </div>
      <!-- RIGHT -->
      <div class="about-text">
        <h2>Mandaps and Entrance</h2>
        <p>
          Devotees entering the temple will pass through a vast and gracefully designed Dance Mandap (Nritya Mandap).
          The temple courtyard will feature a magnificently carved and ornately designed grand entrance gateway,
          offering a powerful first impression of divine splendor.
        </p>

        <h2>Height and Dhajagand</h2>
        <p>
          A defining feature of the temple will be its towering presence. With the Dhajagand rising skyward, the temple
          will reach an impressive height of 113 feet, symbolizing spiritual ascent and divine connection.
        </p>

        <h2>Metals and Shilpa Shastra</h2>
        <p>
          The construction will incorporate pure metals such as gold, silver, copper, and brass, enhancing both sanctity
          and durability. The entire temple will be built strictly in accordance with Shilpa Shastra principles, aligned
          with cardinal directions, celestial calculations, and traditional Vedic architectural guidelines.
        </p>
      </div>

    </div>
  </section>
  <section class="divine-section">
    <div class="divine-container">
      <h2>Divine Distinction</h2>
      <p>
        The most extraordinary aspect of this temple will be the manifestation of
        Goddess Bhagwati Verai Mata in the form of a sacred flame (Jyot) – a divine
        presence dedicated to the welfare of all living beings in the universe.
        This eternal flame will serve as the spiritual heart of the temple and a
        beacon of universal harmony.
      </p>

      <p>
        In the years to come, this sacred shrine will emerge as a major center for
        Shakti worship, spiritual awakening, and service to humanity.
      </p>
    </div>
  </section>

  <!-- Footer -->
  @include('components.footer')

  <script src="{{ asset('assets/js/header.js') }}"></script>
</body>

</html>

