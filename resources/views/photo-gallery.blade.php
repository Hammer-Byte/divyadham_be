<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Photo Gallery</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/photo-gallery.css') }}" />
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
                    @if(isset($templeMedia) && $templeMedia->count() > 0)
                        @foreach($templeMedia as $media)
                            @php
                                $mediaUrl = $media->media_full_url ?? $media->media_url ?? null;
                            @endphp
                            @if($mediaUrl)
                                <div class="gallery-item">
                                    @if($media->media_type == 'image')
                                        <img src="{{ $mediaUrl }}" alt="{{ $media->title ?? 'Gallery Image' }}" />
                                    @elseif($media->media_type == 'video')
                                        @php
                                            $videoUrl = $mediaUrl;
                                            $isYouTube = $videoUrl && (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false);
                                            
                                            // Extract YouTube video ID if it's a YouTube URL
                                            if ($isYouTube) {
                                                // Check if already an embed URL
                                                if (strpos($videoUrl, 'youtube.com/embed/') !== false) {
                                                    $embedUrl = $videoUrl . (strpos($videoUrl, '?') !== false ? '&' : '?') . 'rel=0';
                                                } elseif (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches)) {
                                                    $youtubeId = $matches[1];
                                                    $embedUrl = 'https://www.youtube.com/embed/' . $youtubeId . '?rel=0';
                                                } else {
                                                    $embedUrl = $videoUrl;
                                                }
                                            }
                                        @endphp
                                        @if($isYouTube)
                                            <iframe 
                                                src="{{ $embedUrl }}" 
                                                title="{{ $media->title ?? 'Gallery Video' }}"
                                                frameborder="0" 
                                                width="100%" 
                                                height="100%"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen>
                                            </iframe>
                                        @else
                                            <video controls width="100%" height="100%">
                                                <source src="{{ $videoUrl }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="gallery-item gallery-item-empty">
                            <p class="gallery-empty-message">No media available in Temple gallery.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- TAB 2 -->
            <div class="tab-content" id="events">
                <div class="gallery-grid">
                    @if(isset($eventsMedia) && $eventsMedia->count() > 0)
                        @foreach($eventsMedia as $media)
                            @php
                                $mediaUrl = $media->media_full_url ?? $media->media_url ?? null;
                            @endphp
                            @if($mediaUrl)
                                <div class="gallery-item">
                                    @if($media->media_type == 'image')
                                        <img src="{{ $mediaUrl }}" alt="{{ $media->title ?? 'Gallery Image' }}" />
                                    @elseif($media->media_type == 'video')
                                        @php
                                            $videoUrl = $mediaUrl;
                                            $isYouTube = $videoUrl && (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false);
                                            
                                            // Extract YouTube video ID if it's a YouTube URL
                                            if ($isYouTube) {
                                                // Check if already an embed URL
                                                if (strpos($videoUrl, 'youtube.com/embed/') !== false) {
                                                    $embedUrl = $videoUrl . (strpos($videoUrl, '?') !== false ? '&' : '?') . 'rel=0';
                                                } elseif (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches)) {
                                                    $youtubeId = $matches[1];
                                                    $embedUrl = 'https://www.youtube.com/embed/' . $youtubeId . '?rel=0';
                                                } else {
                                                    $embedUrl = $videoUrl;
                                                }
                                            }
                                        @endphp
                                        @if($isYouTube)
                                            <iframe 
                                                src="{{ $embedUrl }}" 
                                                title="{{ $media->title ?? 'Gallery Video' }}"
                                                frameborder="0" 
                                                width="100%" 
                                                height="100%"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen>
                                            </iframe>
                                        @else
                                            <video controls width="100%" height="100%">
                                                <source src="{{ $videoUrl }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="gallery-item gallery-item-empty">
                            <p class="gallery-empty-message">No media available in Events gallery.</p>
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
</body>

</html>

