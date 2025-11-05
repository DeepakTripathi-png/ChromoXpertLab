@extends('Front.layouts.app')

@section('title', 'ChromoXpert - Refund Policy')

@section('content')
    <!-- ================= REFUND POLICY SECTION ================= -->
    <section id="refund" class="pt-24 pb-16 bg-white text-gray-700">
        <div class="max-w-[1400px] mx-auto px-6">
            <h1 class="text-3xl md:text-4xl font-bold text-center text-[#5366B9] mb-10">
                Refund Policy
            </h1>

            <p class="text-center text-gray-700 max-w-3xl mx-auto mb-12 leading-relaxed">
            At <span class="font-semibold text-[#5366B9]">ChromoXpert</span>, customer satisfaction is our priority.
            We aim to ensure a transparent and fair refund process for all diagnostic services.
            Please review our policy below to understand eligibility and timelines for refunds.
            </p>

        <div class="space-y-6">
        <!-- Common structure -->
            <div class="grid gap-4">
                
                <!-- Point Item -->
                <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">🧾</span>
                <div class="text-justify">
                    <h3 class="font-semibold text-gray-800 text-lg mb-1">1. Eligibility for Refund</h3>
                    <p class="text-gray-700 text-base leading-relaxed">
                    Refunds are applicable only when a payment has been made for services that are not yet initiated,
                    or if a booking has been canceled within the permitted cancellation window.
                    </p>
                </div>
                </div>

                <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">📅</span>
                <div class="text-justify">
                    <h3 class="font-semibold text-gray-800 text-lg mb-1">2. Cancellation Window</h3>
                    <p class="text-gray-700 text-base leading-relaxed">
                    Cancellations made within <span class="font-medium text-gray-800">24 hours</span> of booking
                    are eligible for a full refund. Beyond this period, partial refunds may apply depending on the service preparation stage.
                    </p>
                </div>
                </div>

                <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">💳</span>
                <div class="text-justify">
                    <h3 class="font-semibold text-gray-800 text-lg mb-1">3. Mode of Refund</h3>
                    <p class="text-gray-700 text-base leading-relaxed">
                    All refunds will be processed using the same payment method used during booking — whether it's a credit card,
                    debit card, or UPI. Refunds typically take <span class="font-medium text-gray-800">5–7 business days</span> to reflect in your account.
                    </p>
                </div>
                </div>

                <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">⚕️</span>
                <div class="text-justify">
                    <h3 class="font-semibold text-gray-800 text-lg mb-1">4. Services Not Eligible for Refund</h3>
                    <p class="text-gray-700 text-base leading-relaxed">
                    Once a test sample has been collected and registered in our system, the service is considered “initiated” and becomes non-refundable.
                    This is because diagnostic processes start immediately after sample receipt.
                    </p>
                </div>
                </div>

                <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">📄</span>
                <div class="text-justify">
                    <h3 class="font-semibold text-gray-800 text-lg mb-1">5. Rescheduling Instead of Refund</h3>
                    <p class="text-gray-700 text-base leading-relaxed">
                    In cases where you cannot proceed with the test on the scheduled date, you may choose to reschedule the appointment instead of canceling.
                    This ensures full value retention without refund deduction.
                    </p>
                </div>
                </div>

                <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">💬</span>
                <div class="text-justify">
                    <h3 class="font-semibold text-gray-800 text-lg mb-1">6. Refund Request Process</h3>
                    <p class="text-gray-700 text-base leading-relaxed">
                    To initiate a refund, please email our support team at 
                    <a href="mailto:support@chromoxpert.in" class="text-[#5366B9] hover:underline font-medium">support@chromoxpert.in</a>
                    with your booking ID, registered contact number, and payment details.
                    </p>
                </div>
                </div>

                <div class="grid grid-cols-[40px_1fr] gap-5 items-start">
                <span class="flex items-center justify-center w-9 h-9 bg-[#E9EEF8] text-[#5366B9] rounded-full text-lg">⚖️</span>
                <div class="text-justify">
                    <h3 class="font-semibold text-gray-800 text-lg mb-1">7. Dispute Resolution</h3>
                    <p class="text-gray-700 text-base leading-relaxed">
                    Any disputes regarding payments or refunds will be handled as per the laws of India under the jurisdiction of Pune, Maharashtra.
                    ChromoXpert reserves the right to make the final decision in genuine refund cases.
                    </p>
                </div>
                </div>

            </div>
        </div>

        <div class="mt-12 text-center text-sm text-gray-500">
            <p>Last updated on October 31, 2025</p>
        </div>
        </div>
    </section>
    <!-- ======================= -->
@endsection
@push('scripts')
  <script src="{{ asset('front/js/profile.js') }}"></script>
@endpush
