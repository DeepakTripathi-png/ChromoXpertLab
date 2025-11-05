@extends('Front.layouts.app')

@section('title', 'ChromoXpert - Home')

@section('content')
    <!-- Home Section -->
    <section id="home" class="relative w-full pt-16 md:pt-20">
        <div class="swiper mySwiper w-full">
            <div class="swiper-wrapper">

            <!-- Slide 1 -->
            <div class="swiper-slide flex justify-center">
                <img src="{{ url('front/images/banner/banner1.svg') }}" alt="Banner 1" class="w-full max-w-full h-auto">
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide flex justify-center">
                <img src="{{ url('front/images/banner/banner2.svg') }}" alt="Banner 2" class="w-full max-w-full h-auto">
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide flex justify-center">
                <img src="{{ url('front/images/banner/banner3.svg') }}" alt="Banner 3" class="w-full max-w-full h-auto">
            </div>

            </div>

            <!-- Navigation -->
            <div class="swiper-button-next text-white"></div>
            <div class="swiper-button-prev text-white"></div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- About Section -->
    <section id="about" class="py-16 bg-white w-full pt-16 md:pt-20">
        <div class="max-w-[1600px] mx-auto px-4 md:px-6 flex flex-col md:flex-row items-center md:items-start gap-10 md:gap-16">

            <!-- Text Column -->
            <div class="md:w-2/3 flex flex-col justify-center text-center md:text-left">
            <h2 class="text-pink-700 font-bold mb-2 text-lg md:text-xl">MORE ABOUT US</h2>
            <h3 class="text-xl md:text-2xl lg:text-3xl font-bold text-[#6483B9] mb-6 leading-snug">
                ChromoXpert: Excellence in Diagnostics and Research
            </h3>
            <div class="text-gray-700 leading-relaxed space-y-4 text-[15px] md:text-[16px] max-w-xl md:max-w-none">
                <p>At ChromoXpert Research and Diagnostics, we are committed to advancing health and science — for both humans and animals. Established in 2014, ChromoXpert is a leading provider of high-quality genetic and molecular diagnostics, with specialized expertise in Cytogenetics and Molecular Genetics.</p>
                <p>We offer a comprehensive range of advanced diagnostic services for veterinary and human health, including karyotyping, genetic disease diagnosis, and molecular testing for infectious diseases. Our capabilities also span Pathology, Hematology, Microbiology, and Parasitology.</p>
                <p>In addition to diagnostics, our laboratory conducts in-vitro cell culture studies, contract research, polyclonal antibody production, and animal transport clearance testing. We also offer Avian DNA sexing, Stem Cell Genetics, Technical Writing, Research Skills Development, and Healthcare Consulting services.</p>
                <p>Driven by innovation, scientific integrity, and accuracy, ChromoXpert delivers reliable, ethical diagnostic and research solutions that support excellence in healthcare and science.</p>
            </div>
            </div>

            <!-- Images Column -->
            <div class="md:w-1/3 flex justify-center md:justify-end items-center relative">
            <div class="relative w-[80%] max-w-[400px] aspect-[4/5] min-w-[220px] min-h-[240px]">

                <!-- Back Image -->
                <div class="absolute top-0 right-0 w-[70%] h-[90%] rounded-2xl bg-white shadow-xl border border-gray-200 overflow-hidden z-10">
                <img src="{{ url('front/images/image/overlap1.png') }}" alt="Dog vet" class="w-full h-full object-cover rounded-2xl" />
                </div>

                <!-- Front Image -->
                <div class="absolute bottom-0 left-0 w-[60%] h-[75%] rounded-2xl bg-white shadow-2xl border border-gray-200 overflow-hidden z-20 -translate-x-1/4 translate-y-1/12">
                <img src="{{ url('front/images/image/overlap.png') }}" alt="Cat vet" class="w-full h-full object-cover rounded-2xl" />
                </div>

            </div>
            </div>

        </div>
    </section>
    <!-- Book Section -->
    <section id="packages" class="py-16 bg-blue-50 w-full pt-16 md:pt-20">
        <div class="max-w-[1600px] mx-auto px-6 text-center">
            <!-- Title -->
            <h2 class="text-3xl font-bold mb-10 text-[#6483B9]">Book Tests</h2>

            <!-- Cards Grid -->
            <div id="test-grid" class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-8"></div>

            <!-- View All Link -->
            <div class="mt-10">
            <button id="view-all-btn"
                class="inline-block text-[#6483B9] font-semibold border border-[#6483B9] px-6 py-2 rounded-lg hover:bg-[#6483B9] hover:text-white transition">
                View All Tests
            </button>
            </div>
        </div>
    </section>
    <!-- Services Section -->
    <section id="services" class="py-16 bg-white w-full pt-16 md:pt-20" >
        <div class="max-w-[1600px] mx-auto px-6 text-center mb-10">
            <h2 class="text-3xl font-bold mb-4 text-[#6483B9]">Our Laboratory Services</h2>
        </div>
        <!-- Swiper Container -->
        <div class="swiper services-swiper max-w-[1600px] mx-auto px-6">
            <div class="swiper-wrapper">

            
            <!-- Card 1 -->
            <div class="swiper-slide">
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 p-6 flex flex-col justify-between h-full">
                <img src="{{ url('front/images/image/vet_lab.png') }}" alt="Veterinary Laboratory" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-semibold text-[#5169A6] mb-3 text-center">Veterinary Laboratory Diagnostics</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-justify flex-grow">
                    This service offers comprehensive diagnostic lab testing for companion animals, including routine health screens, specialized assays, and tissue analysis. Linked imaging (X-ray, ultrasound) enhances diagnosis, supporting accurate treatment, preventive care, and better pet health outcomes.
                </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="swiper-slide">
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 p-6 flex flex-col justify-between h-full">
                <img src="{{ url('front/images/image/human_lab.png') }}" alt="Human Laboratory" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-semibold text-[#5169A6] mb-3 text-center">Human Laboratory Diagnostics</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-justify flex-grow">
                    Health testing for pet owners or shared human–animal clinics, supporting the “One Health” approach by addressing zoonotic risks and maintaining high diagnostic standards. This broadens services and strengthens the human–animal health connection.
                </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="swiper-slide">
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 p-6 flex flex-col justify-between h-full">
                <img src="{{ url('front/images/image/mobilexray_lab.png') }}" alt="Mobile X-ray" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-semibold text-[#5169A6] mb-3 text-center">Mobile X-ray</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-justify flex-grow">
                    This service provides mobile X-ray imaging for pets using portable digital equipment at homes or clinics. It’s ideal for elderly or immobile animals, reducing stress and enabling quick, accurate diagnosis of injuries or internal conditions.
                </p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="swiper-slide">
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 p-6 flex flex-col justify-between h-full">
                <img src="{{ url('front/images/image/sonography_lab.png') }}" alt="Sonography" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-semibold text-[#5169A6] mb-3 text-center">Sonography</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-justify flex-grow">
                    This service provides non-invasive ultrasound imaging for pets, including abdominal, cardiac, and soft tissue scans. It allows real-time assessment of organs and heart function, aiding diagnosis of tumors, pregnancy, heart disease, and other conditions for a complete picture of health.
                </p>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="swiper-slide">
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 p-6 flex flex-col justify-between h-full">
                <img src="{{ url('front/images/image/research_lab.png') }}" alt="Contract Research" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-semibold text-[#5169A6] mb-3 text-center">Contract Research Testing</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-justify flex-grow">
                    This service offers contract testing and analytical support for veterinary research, biotech, and academic clients, including molecular and microbiology assays for pets. It provides custom test development, high-throughput analysis, and quality-assured data to meet research needs.
                </p>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="swiper-slide">
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 p-6 flex flex-col justify-between h-full">
                <img src="{{ url('front/images/image/academicres_lab.png') }}" alt="Academic Research" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-semibold text-[#5169A6] mb-3 text-center">Academic Research Projects</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-justify flex-grow">
                    This service facilitates collaboration with universities and research centers on pet health studies, including disease research, diagnostics, and treatment outcomes. It supports experimental design, data analysis, and publication, advancing veterinary knowledge and innovation.
                </p>
                </div>
            </div>

            <!-- Card 7 -->
            <div class="swiper-slide">
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 p-6 flex flex-col justify-between h-full">
                <img src="{{ url('front/images/image/stemcell_lab.png') }}" alt="Stem Cell Facility" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-semibold text-[#5169A6] mb-3 text-center">Stem Cell Facility</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-justify flex-grow">
                    Regenerative medicine for pets using stem-cell therapy, including cell isolation, expansion, and cryopreservation. It treats conditions like osteoarthritis, tendon injuries, and certain organ diseases, improving quality of life for companion animals.
                </p>
                </div>
            </div>

            <!-- Card 8 -->
            <div class="swiper-slide">
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300 p-6 flex flex-col justify-between h-full">
                <img src="{{ url('front/images/image/foodtest_lab.png') }}" alt="Food Testing" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-semibold text-[#5169A6] mb-3 text-center">Food Testing</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-justify flex-grow">
                    Analytical testing of pet food for safety, nutritional quality, and compliance — ensuring healthy diets and protecting pet health. It supports manufacturers, retailers, and pet owners in delivering safe, high-quality nutrition.
                </p>
                </div>
            </div>

            </div>
            <!-- Pagination + Navigation -->
            <div class="flex justify-center items-center gap-4 mt-8 relative">
                <div class="services-button-prev cursor-pointer p-2 bg-[#E6ECF8] rounded-full hover:bg-[#C4D2F2] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#5169A6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <div class="services-pagination swiper-pagination !static"></div>
                <div class="services-button-next cursor-pointer p-2 bg-[#E6ECF8] rounded-full hover:bg-[#C4D2F2] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#5169A6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </div>
    </section>
    <!-- Booking Section -->
    <section id="booking" class="py-16 bg-blue-50 w-full pt-16 md:pt-20">
        <div class="max-w-[1600px] mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-10 text-[#6483B9]">How To Book Test</h2>

            <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">

            <!-- Step 1 -->
            <div class="bg-[#6483B9] text-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                <h3 class="font-semibold text-lg mb-2 flex items-center justify-center gap-2">
                📅 Book Appointment
                </h3>
                <p class="text-blue-100 text-sm">
                Select a Test / Package and book appointment on ChromoXpert
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-[#6483B9] text-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                <h3 class="font-semibold text-lg mb-2 flex items-center justify-center gap-2">
                🏠 Home Collection
                </h3>
                <p class="text-blue-100 text-sm">
                A sample collector agent visit you for sample collection at your selected time slot
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-[#6483B9] text-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                <h3 class="font-semibold text-lg mb-2 flex items-center justify-center gap-2">
                ⚡ Fast & Accurate Result
                </h3>
                <p class="text-blue-100 text-sm">
                Get Report in 24–48 Hrs View and Download from app/website
                </p>
            </div>

            </div>
        </div>
    </section>
    <!-- Reviews Section -->
    <section id="reviews" class="py-16 bg-white w-full pt-16 md:pt-20">
        <div class="max-w-[1600px] mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-[#6483B9] mb-10">Customer Reviews</h2>

            <!-- Swiper Container -->
            <div class="swiper reviews-swiper">
            <div class="swiper-wrapper" id="reviews-wrapper">
                <!-- Reviews injected via JS -->
            </div>

            <!-- Pagination + Navigation -->
            <div class="flex justify-center items-center gap-4 mt-8 relative">
                <div class="reviews-button-prev cursor-pointer p-2 bg-[#E6ECF8] rounded-full hover:bg-[#C4D2F2] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#5169A6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                </div>
                <div class="reviews-pagination swiper-pagination !static"></div>
                <div class="reviews-button-next cursor-pointer p-2 bg-[#E6ECF8] rounded-full hover:bg-[#C4D2F2] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#5169A6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                </div>
            </div>
            </div>
        </div>
    </section>
    <!-- Contact Section -->
    <section id="contact" class="py-10 bg-white w-full pt-16 md:pt-20">
        <div class="max-w-[1600px] mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-[#6483B9] mb-10">Contact Us</h2>
            <div class="grid md:grid-cols-2 gap-10 items-stretch">
                <!-- Left: Contact Form -->
                <form class="bg-[#6483B9] text-white p-8 rounded-2xl shadow flex flex-col justify-between">
                    <div class="space-y-4 text-left">
                    <div>
                        <label class="block mb-1 font-medium">Name</label>
                        <input type="text" placeholder="Enter Full Name"
                        class="w-full p-3 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#6483B9]">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Contact</label>
                        <input type="text" placeholder="Enter Mobile Number"
                        class="w-full p-3 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#6483B9]">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Email</label>
                        <input type="email" placeholder="Enter Email"
                        class="w-full p-3 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#6483B9]">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Message</label>
                        <textarea rows="4" placeholder="Enter Message"
                        class="w-full p-3 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#6483B9]"></textarea>
                    </div>
                    </div>
                    <button type="submit"
                    class="mt-6 bg-white text-[#6483B9] font-semibold py-3 rounded hover:bg-gray-100 transition">
                    Send Message
                    </button>
                </form>

                <!-- Right: Image + Contact Info -->
                <div class="flex flex-col justify-between">
                    <!-- Image -->
                    <img src="{{ url('front/images/image/forcontact.png') }}" alt="Contact"
                    class="w-full h-80 md:h-[380px] object-cover rounded-2xl shadow-lg mb-6">

                    <!-- Contact Info -->
                    <div class="bg-white text-left px-4 md:px-0">
                        <h3 class="font-bold text-lg mb-3 text-gray-800">Contact Info</h3>
                        <div class="space-y-3 text-gray-700">
                            <p class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-[#6483B9]"></i>
                            <span><b>Call Us:</b> 7506195350</span>
                            </p>
                            <p class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-[#6483B9] mt-1"></i>
                            <span><b>Address (Main Branch):</b> 243, 233, Silver Springs, Plot A, Taloja MIDC, Taloja, Navi Mumbai, 410208, Maharashtra, India</span>
                            </p>
                            <p class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-[#6483B9]"></i>
                            <span><b>Email Us:</b> info@chromoxpert.com</span>
                            </p>
                            <p class="flex items-center gap-3">
                            <i class="fa-solid fa-globe text-[#6483B9]"></i>
                            <span><b>Website:</b> www.chromoxpert.com</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Full-Width Google Map -->
        <div id="map" class="w-full h-[500px] mt-10 rounded-xl shadow-lg"></div>
    </section>
    <!-- Start Modal for Tests List-->
    <div id="test-modal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-lg w-[95%] max-w-[1600px] max-h-[90vh] overflow-hidden p-6 relative flex flex-col">
            <!-- Close Button -->
            <button id="close-modal" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>

            <!-- Modal Header -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-3 mb-4 mt-2">
                <!-- Title -->
                <h3 class="text-2xl font-bold text-[#6483B9] text-center flex-1 order-1 md:order-none">
                    Book Tests
                </h3>

                <!-- Search Box -->
                <div class="w-full md:w-auto order-2 md:order-none flex justify-center md:justify-end">
                    <div class="relative w-full sm:w-64 md:w-72">
                        <input type="text" id="test-search" placeholder="Search tests..."
                            class="border border-gray-300 rounded-full py-2 pl-10 pr-3 text-sm w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Scrollable Grid -->
            <div class="overflow-y-auto pr-2" style="max-height: calc(90vh - 80px);min-height: 50vh;">
                <div id="all-test-grid"
                    class="grid xl:grid-cols-4 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal for Test List-->
    <!-- Sign IN Modal Background -->
    <div id="login-modal"
        class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
        <!-- Modal Box -->
        <div class="bg-white rounded-2xl shadow-lg w-[90%] max-w-sm p-6 relative text-center">
        
        <!-- Close Button -->
        <button id="close-login"
            class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>
        
        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <img src="{{ url('front/images/logo/logo.jpeg') }}" alt="ChromoXpert Logo"
            class="w-48">
        </div>

        <!-- Title -->
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Log In</h2>

        <!-- Input -->
        <div class="mb-4 text-left">
            <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">
                Enter Mobile Number
            </label>

            <div class="relative">
                <!-- Phone Icon -->
                <i class="fa-solid fa-phone text-[#6483B9] absolute left-3 top-1/2 -translate-y-1/2"></i>

                <!-- Input -->
                <input
                type="tel"
                id="mobile" maxlength="10"
                placeholder="90989785898"
                class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2.5 text-sm text-gray-700 
                        focus:ring-2 focus:ring-[#5366B9] focus:border-[#5366B9] outline-none transition"
                />
            </div>
        </div>
        <div id="login-msg" class="hidden text-sm mb-3 text-center"></div>
        <!-- Login Button -->
        <button id="login-btn" 
            class="w-full bg-[#5366B9] text-white py-2 rounded-md text-sm font-semibold hover:bg-[#4152a0] transition">
            Login
        </button>

        <p id="mobile-error" class="text-red-500 text-xs mt-1 hidden">Please enter a valid 10-digit mobile number.</p>
        <!-- Signup link -->
        <p class="text-center text-sm text-gray-600 mt-4">
            Don’t have an account?
            <button id="open-signup" class="text-blue-600 font-semibold hover:underline">Sign Up</button>
        </p>
        </div>
    </div>
    <!-- SIGNUP MODAL -->
    <div id="signup-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white w-full max-w-sm mx-4 p-6 rounded-2xl relative overflow-y-auto max-h-[90vh]">
            <button id="close-signup" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

            <h2 class="text-2xl font-semibold text-center mb-4 text-blue-600">Sign Up</h2>

            <form id="signup-form">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2">
                First Name<span class="text-red-500">*</span>
                </label>
                <input type="text" name="first_name" placeholder="Enter Pet Parent/Care Of Name"
                class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2">
                Last Name<span class="text-red-500">*</span>
                </label>
                <input type="text" name="last_name" placeholder="Enter Pet Name"
                class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2">
                Gender<span class="text-red-500">*</span>
                </label>
                <select name="gender" class="w-full border rounded-md px-3 py-2 bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2">
                Contact Number<span class="text-red-500">*</span>
                </label>
                <input type="text" name="mobile" placeholder="Enter Contact Number"
                class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2">
                Email<span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" placeholder="Enter Email"
                class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                Continue
            </button>
            <div id="signup-message" class="hidden mb-4 text-center text-sm font-medium"></div>
            </form>

            <p class="text-center text-sm text-gray-600 mt-4">
                Already have an account?
                <button id="back-to-login" class="text-blue-600 font-semibold hover:underline">Sign In</button>
            </p>
        </div>
    </div>

    <!-- OTP Verification Modal -->
    <div id="otp-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white w-full max-w-sm mx-4 p-6 rounded-2xl shadow-lg relative text-center">
            <!-- Close -->
            <button id="close-otp" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

            <!-- Logo -->
            <img src="{{ url('front/images/logo/logo.jpeg') }}" alt="ChromoXpert Logo" class="mx-auto h-12 mb-3">

            <!-- Heading -->
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Login With Mobile Number</h2>
            <p class="text-sm text-gray-600 mb-5">
            Enter OTP Code Sent To Your Number <span class="font-medium text-gray-800" id="otp-mobile">+919132568987</span>
            </p>

            <!-- OTP Inputs -->
            <div class="flex justify-center gap-3 mb-6">
            <input type="text" maxlength="1"
                class="otp-input w-10 h-10 text-center border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 outline-none text-lg font-medium" />
            <input type="text" maxlength="1"
                class="otp-input w-10 h-10 text-center border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 outline-none text-lg font-medium" />
            <input type="text" maxlength="1"
                class="otp-input w-10 h-10 text-center border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 outline-none text-lg font-medium" />
            <input type="text" maxlength="1"
                class="otp-input w-10 h-10 text-center border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 outline-none text-lg font-medium" />
            </div>
            <div id="otp-msg" class="hidden text-sm mb-3 text-center"></div>
            <!-- Continue Button -->
            <button id="verify-otp"
            class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition font-medium">
            Continue
            </button>

            <!-- Resend -->
            <p class="text-sm text-gray-600 mt-4">
            Didn’t receive the code?
            <button id="resend-otp" class="text-blue-600 font-semibold hover:underline">Resend OTP</button>
            </p>
        </div>
    </div>
    <input type="hidden" id="base_url" name="base_url" value="/">
@endsection
