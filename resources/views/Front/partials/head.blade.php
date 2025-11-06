<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>ChromoXpert</title>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<style>
    body { font-family: 'Montserrat', sans-serif; scroll-behavior: smooth; }

    .nav-link.active {
        color: #1d4ed8; /* Tailwind blue-700 */
        font-weight: 700;
    }
    .nav-link { text-decoration: none !important; }
    .hero-slide {
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain; /* ✅ prevents cutting */
        width: 100%;
        height: auto;
        min-height: 585px; /* ensures desktop height */
    }

    /* For mobile – auto height, image fully visible */
    @media (max-width: 768px) {
        .hero-slide {
        background-size: contain;
        background-position: center top;
        min-height: 280px; /* enough height for mobile */
        }
    }

    .hero-overlay {
        @apply absolute inset-0 flex flex-col items-center justify-center text-white text-center;
        background: rgba(0, 0, 0, 0.35);
    }
    #map {
        position: relative;
        z-index: 1; /* below mobile menu */
    }
    header {
        position: relative;
        z-index: 2000;
    }
    @media (max-width: 768px) {
        #map {
            height: 350px; /* reduce height for smaller screens */
            border-radius: 0;
            margin-top: 1rem;
        }
    }

/*Service Slider */
    .services-swiper .swiper-slide {
        display: flex;
        height: auto;
    }
    .services-swiper .swiper-slide > div {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    /* Pagination style */
    .services-swiper .swiper-pagination-bullet {
        background: #6483B9;
        opacity: 0.4;
        width: 10px;
        height: 10px;
    }
    .services-swiper .swiper-pagination-bullet-active {
        opacity: 1;
    }
    /*Navigation Arrow Hide*/
    .services-button-prev,
    .services-button-next {
        visibility: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }
    /* Fix visible edges of hidden slides */
    /* Properly hide edges of non-visible slides without breaking slide motion */
    .services-swiper {
        overflow: hidden !important;
    }

    .services-swiper .swiper-wrapper {
        overflow: visible !important; /* must stay visible for Swiper translation */
    }

    .services-swiper .swiper-slide {
        overflow: hidden !important; /* hides inner box-shadow or border of cards */
    }
/*End Of Service Slider*/
/* --- Review Slider Styling --- */
    .reviews-swiper {
        overflow: hidden !important;
        padding-bottom: 2rem;
    }
    .reviews-swiper .swiper-slide {
        display: flex;
        height: auto;
    }
    .reviews-swiper .swiper-slide > div {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .reviews-swiper .swiper-pagination-bullet {
        background: #6483B9;
        opacity: 0.4;
        width: 10px;
        height: 10px;
    }
    .reviews-swiper .swiper-pagination-bullet-active {
        opacity: 1;
    }
    /* Hide navigation but keep functionality */
    .reviews-button-prev,
    .reviews-button-next {
        visibility: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }
</style>