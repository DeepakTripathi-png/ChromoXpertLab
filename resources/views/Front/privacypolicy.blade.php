@extends('Front.layouts.app')

@section('title', 'ChromoXpert - Privacy Policy')

@section('content')
    <section id="privacypolicy" class="pt-24 pb-16 bg-white text-gray-700">
        <div class="max-w-[1400px] mx-auto px-6">
            <h1 class="text-3xl md:text-4xl font-bold text-center text-[#5366B9] mb-10">
            Privacy Policy
            </h1>

            <p class="text-center text-gray-700 max-w-3xl mx-auto mb-12 leading-relaxed">
            At <span class="font-semibold text-[#5366B9]">ChromoXpert</span>, we value your trust and are committed to protecting 
            your personal information. This Privacy Policy outlines how we collect, use, store, and safeguard your data 
            while ensuring transparency and compliance with data protection standards.
            </p>

            <div class="space-y-6">
                <div class="grid gap-4">

                    <!-- 1 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">🔒</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">1. Information We Collect</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                            We collect information that you provide during registration, booking, or communication with our team. 
                            This may include your name, contact details, health-related information, and payment data.
                            </p>
                        </div>
                    </div>

                    <!-- 2 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">💡</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">2. How We Use Your Information</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                            Your data is used solely for providing diagnostic services, improving user experience, and communicating 
                            essential updates related to your reports or appointments. We do not sell or rent your data to third parties.
                            </p>
                        </div>
                    </div>

                    <!-- 3 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">🧠</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">3. Data Storage and Security</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                            All information is stored securely on encrypted servers with restricted access. We implement industry-standard 
                            security protocols to prevent unauthorized access, alteration, or misuse of your data.
                            </p>
                        </div>
                    </div>

                    <!-- 4 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">🤝</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">4. Sharing of Information</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                            We may share limited data with authorized partners or laboratories only to complete diagnostic procedures. 
                            Such partners are contractually obligated to maintain confidentiality and data protection.
                            </p>
                        </div>
                    </div>

                    <!-- 5 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">📱</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">5. Cookies and Tracking</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                            Our website uses cookies to enhance your browsing experience and analyze website traffic. 
                            You can choose to disable cookies in your browser settings, though some features may be limited.
                            </p>
                        </div>
                    </div>

                    <!-- 6 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">✉️</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">6. Your Rights</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                            You have the right to access, correct, or delete your personal data stored with us. 
                            To exercise these rights, please contact our support team at 
                            <a href="mailto:support@chromoxpert.in" class="text-[#5366B9] hover:underline font-medium">support@chromoxpert.in</a>.
                            </p>
                        </div>
                    </div>

                    <!-- 7 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">⚖️</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">7. Policy Updates</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                            This Privacy Policy may be updated periodically to reflect changes in technology or regulations. 
                            Updates will be posted on this page with the revised date.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-12 text-center text-sm text-gray-500">
                <p>Last updated on October 30, 2025</p>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
  <script src="{{ asset('front/js/profile.js') }}"></script>
@endpush
