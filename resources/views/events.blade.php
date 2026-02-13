<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Events</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/event.css') }}" />
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
                @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
                    @foreach($upcomingEvents as $event)
                    <div class="event-item">
                        <div class="thumb">
                            @if($event->event_image_full_url)
                                <img src="{{ $event->event_image_full_url }}" alt="{{ $event->title }}" width="100%" height="100%" />
                            @endif
                        </div>
                        <div class="info">
                            <div class="date">
                                @if($event->start_date)
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d.m.Y | h:i A') }}
                                    @if($event->end_date)
                                        - {{ \Carbon\Carbon::parse($event->end_date)->format('d.m.Y | h:i A') }}
                                    @endif
                                @endif
                            </div>
                            <h3>{{ $event->title }}</h3>
                            <p>{{ $event->description ?? '' }}</p>
                            @if($event->location)
                                <p><strong>Location:</strong> {{ $event->location }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="event-item">
                        <div class="info">
                            <p>No upcoming events scheduled.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- TAB 2 -->
            <div class="tab-content" id="ongoing">
                @if(isset($ongoingEvents) && $ongoingEvents->count() > 0)
                    @foreach($ongoingEvents as $event)
                    <div class="event-item">
                        <div class="thumb">
                            @if($event->event_image_full_url)
                                <img src="{{ $event->event_image_full_url }}" alt="{{ $event->title }}" width="100%" height="100%" />
                            @endif
                        </div>
                        <div class="info">
                            <div class="date">
                                @if($event->start_date)
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d.m.Y | h:i A') }}
                                    @if($event->end_date)
                                        - {{ \Carbon\Carbon::parse($event->end_date)->format('d.m.Y | h:i A') }}
                                    @endif
                                @endif
                            </div>
                            <h3>{{ $event->title }}</h3>
                            <p>{{ $event->description ?? '' }}</p>
                            @if($event->location)
                                <p><strong>Location:</strong> {{ $event->location }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="event-item">
                        <div class="info">
                            <p>No ongoing events at the moment.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- TAB 3 -->
            <div class="tab-content" id="previous">
                @if(isset($previousEvents) && $previousEvents->count() > 0)
                    @foreach($previousEvents as $event)
                    <div class="event-item">
                        <div class="thumb">
                            @if($event->event_image_full_url)
                                <img src="{{ $event->event_image_full_url }}" alt="{{ $event->title }}" width="100%" height="100%" />
                            @endif
                        </div>
                        <div class="info">
                            <div class="date">
                                @if($event->end_date)
                                    {{ \Carbon\Carbon::parse($event->end_date)->format('d.m.Y | h:i A') }}
                                @elseif($event->start_date)
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d.m.Y | h:i A') }}
                                @endif
                            </div>
                            <h3>{{ $event->title }}</h3>
                            <p>{{ $event->description ?? '' }}</p>
                            @if($event->location)
                                <p><strong>Location:</strong> {{ $event->location }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="event-item">
                        <div class="info">
                            <p>No previous events found.</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>

    <section class="divine-section">
        <div class="container ">
            <h2>Events Photo Gallery</h2>
            <div class="divine-slider swiper">
                <div class="swiper-wrapper">
                    @if(isset($galleryEvents) && $galleryEvents->count() > 0)
                        @foreach($galleryEvents as $event)
                            @if($event->event_image_full_url)
                            <div class="swiper-slide">
                                <img src="{{ $event->event_image_full_url }}" alt="{{ $event->title }}">
                            </div>
                            @endif
                        @endforeach
                    @else
                        <div class="swiper-slide">
                            <img src="{{ asset('images/gallery-img.png') }}" alt="Gallery Photo">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    @include('components.footer')

    <script src="{{ asset('assets/js/header.js') }}"></script>
    <script src="{{ asset('assets/js/tab.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".divine-slider", {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: @json(isset($galleryEvents) && $galleryEvents->count() > 3),

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

