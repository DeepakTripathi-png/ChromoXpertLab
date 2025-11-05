@extends('Front.layouts.app')

@section('title', 'ChromoXpert - Terms')

@section('content')
    <!-- ================= REFUND POLICY SECTION ================= -->
    <section id="terms" class="pt-24 pb-16 bg-white text-gray-700">
        <div class="max-w-[1400px] mx-auto px-6">
            <h1 class="text-3xl md:text-4xl font-bold text-center text-[#5366B9] mb-10">
                Terms & Conditions
            </h1>

            <p class="text-center text-gray-700 max-w-3xl mx-auto mb-12 leading-relaxed">
                Welcome to <span class="font-semibold text-[#5366B9]">ChromoXpert</span>.  
                These Terms and Conditions govern the use of our veterinary diagnostics and laboratory services.  
                By accessing or using our website, you agree to the terms stated below.
            </p>

            <div class="space-y-6">
                <div class="grid gap-4">

                    <!-- 1 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">📋</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">1. Acceptance of Terms</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                                By using our website or booking services, you agree to these Terms and Conditions in full.  
                                If you do not agree, please refrain from using our platform or services.
                            </p>
                        </div>
                    </div>

                    <!-- 2 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">🔬</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">2. Scope of Services</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                                <span class="font-semibold text-[#5366B9]">ChromoXpert</span> provides veterinary diagnostic and laboratory testing services
                                based on the information and samples provided by customers.  
                                We reserve the right to modify, suspend, or discontinue any part of our services without prior notice.
                            </p>
                        </div>
                    </div>

                    <!-- 3 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">💳</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">3. Payment and Billing</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                                All payments must be completed before the initiation of laboratory testing.  
                                Payment once made is non-transferable and subject to the <a href="{{ url('refundpolicy') }}" class="text-[#5366B9] hover:underline font-medium">Refund Policy</a>.
                            </p>
                        </div>
                    </div>

                    <!-- 4 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">🧪</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">4. Accuracy of Information</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                                Customers must provide accurate and complete information when booking tests or submitting samples.  
                                ChromoXpert is not responsible for any incorrect results arising from incomplete or misleading data.
                            </p>
                        </div>
                    </div>

                    <!-- 5 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">🔒</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">5. Data Privacy</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                                We respect your privacy and ensure that all personal and pet-related data is protected as per applicable data protection laws.  
                                For more details, please refer to our <a href="{{ url('privacypolicy') }}" class="text-[#5366B9] hover:underline font-medium">Privacy Policy</a>.
                            </p>
                        </div>
                    </div>

                    <!-- 6 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">⚙️</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">6. Service Limitations</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                                ChromoXpert's test results are based solely on the provided samples.  
                                We do not offer veterinary treatment or medical consultation unless explicitly stated.
                            </p>
                        </div>
                    </div>

                    <!-- 7 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">⚖️</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">7. Governing Law</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                                These Terms and Conditions are governed by the laws of India under the jurisdiction of Pune, Maharashtra.  
                                Any disputes shall be resolved amicably or through legal proceedings as necessary.
                            </p>
                        </div>
                    </div>

                    <!-- 8 -->
                    <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                        <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">📧</span>
                        <div class="text-justify">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">8. Contact Information</h3>
                            <p class="text-gray-700 text-base leading-relaxed">
                                For queries regarding these Terms & Conditions, please contact our support team at  
                                <a href="mailto:support@chromoxpert.in" class="text-[#5366B9] hover:underline font-medium">support@chromoxpert.in</a>.
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
    <!-- ======================= -->
@endsection
@push('scripts')
  <script src="{{ asset('front/js/profile.js') }}"></script>
@endpush