<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Photo Gallery</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/photo-gallery.css') }}" />
</head>

<body>

    <!-- Header -->
    @include('components.header')

    <!-- PAGE BANNER -->
    <section class="page-banner">
        <h2>
            Photo Gallery
        </h2>
        <img src="{{ asset('images/divine_img.png') }}" alt="Divine Image" class="banner-image">
    </section>
    <section class="photo-gallery">
        <div class="container">

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active" data-tab="temple">Temple</button>
                <button class="tab" data-tab="events">Events</button>
            </div>

            <!-- TAB 1 -->
            <div class="tab-content active" id="temple">
                <div class="gallery-grid">
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                </div>
            </div>

            <!-- TAB 2 -->
            <div class="tab-content" id="events">
                <div class="gallery-grid">
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset('images/event_1.png') }}" alt="Event Thumbnail" width="100%" height="100%" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    @include('components.footer')

    <script src="{{ asset('js/header.js') }}"></script>
    <script src="{{ asset('js/tab.js') }}"></script>
</body>

</html>

