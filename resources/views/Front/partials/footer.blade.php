<footer class="bg-[#0C1322] text-gray-400 py-12 w-full">
    <div class="max-w-[1600px] mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10 text-center lg:text-left">
        <!-- Logo + Copyright -->
        <div>
        <img src="{{ url('front/images/logo/footer_logo.png') }}" alt="Logo" class="h-12 mb-4 mx-auto lg:mx-0">
        <p class="text-sm leading-relaxed">
            © 2025 <span class="font-medium text-white">ChromoXpert</span>.<br>
            All rights reserved.
        </p>
        </div>

        <!-- Company -->
        <div>
        <h4 class="font-semibold text-white mb-4 text-lg">Company</h4>
        <ul class="space-y-2 text-sm">
            <li><a href="{{ url('/') }}#about" class="hover:text-white transition-colors">About Us</a></li>
            <li><a href="{{ url('/') }}#services" class="hover:text-white transition-colors">Services</a></li>
            <li><a href="{{ url('/') }}#contact" class="hover:text-white transition-colors">Contact</a></li>
            <li><a href="{{ url('termsandcondition') }}" class="hover:text-white transition-colors whitespace-nowrap">Terms & Conditions</a></li>
            <li><a href="{{ url('refundpolicy') }}" class="hover:text-white transition-colors">Refund Policy</a></li>
            <li><a href="{{ url('privacypolicy') }}" class="hover:text-white transition-colors">Privacy Policy</a></li>
        </ul>
        </div>

        <!-- Opening Time -->
        <div>
        <h4 class="font-semibold text-white mb-4 text-lg">Opening Time</h4>
        <p class="text-sm leading-relaxed">
            Mon–Fri: 9AM–6PM<br>Sat: 9AM–4PM
        </p>
        </div>

        <!-- Follow Us -->
        <div>
        <h4 class="font-semibold text-white mb-4 text-lg">Follow Us</h4>
        <div class="flex justify-center lg:justify-start space-x-4">
            <a href="#" class="hover:text-[#3b5998] transition"><i class="fab fa-facebook-f text-xl"></i></a>
            <a href="#" class="hover:text-[#1DA1F2] transition"><i class="fab fa-twitter text-xl"></i></a>
            <a href="#" class="hover:text-[#0077B5] transition"><i class="fab fa-linkedin-in text-xl"></i></a>
            <a href="#" class="hover:text-[#E4405F] transition"><i class="fab fa-instagram text-xl"></i></a>
        </div>
        </div>

        <!-- Play Store -->
        <div>
        <h4 class="font-semibold text-white mb-4 text-lg">Get Our App</h4>
        <a href="#" target="_blank" class="inline-block">
            <img src="{{ url('front/images/logo/play-store.png') }}" alt="Get it on Google Play" class="h-12 w-auto hover:opacity-90 transition mx-auto lg:mx-0">
        </a>
        </div>
    </div>
</footer>