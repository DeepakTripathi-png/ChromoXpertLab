@extends('Front.layouts.app')

@section('title', 'ChromoXpert - Cart')


@section('content')
    <section id="billing_summary" class="pt-24 pb-16 flex-grow">
        <div class="max-w-[1400px] mx-auto px-4 flex flex-col lg:flex-row gap-10">
            {{-- Include sidebar --}}
            @include('Front.partials.sidebar')
            <!-- Billing Summary -->
            <main class="w-full lg:w-3/4">
                <!-- Grid for Test Card + Bill Summary -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- 🧪 Test Card -->
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 md:p-8 relative overflow-hidden">
                    <!-- Status Badge -->
                    <div class="absolute top-0 right-0 bg-green-600 text-white text-xs font-semibold px-4 py-1 rounded-bl-lg rounded-tr-2xl shadow">
                        Completed
                    </div>

                    <!-- Title -->
                    <h3 class="text-[#6483B9] font-semibold text-sm mb-4 uppercase tracking-wide">Test</h3>

                    <!-- Order Info -->
                    <div class="flex justify-between items-start mb-2">
                        <div>
                        <h3 class="font-semibold text-gray-800 text-base">
                            Order ID <span class="font-normal text-gray-600">CP1001</span>
                        </h3>
                        </div>
                    </div>

                    <!-- Date & Paid -->
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                        <div class="flex flex-col">
                        <span>24/11/2025</span>
                        <span>11.00 AM</span>
                        </div>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Paid</span>
                    </div>

                    <!-- Test Detail -->
                    <div class="mt-4">
                        <h4 class="font-semibold text-gray-800 text-sm mb-2">Test Details</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-circle text-blue-600 text-[8px] mt-[5px]"></i>
                            Canine Blood Parasite PCR Panel - 4 (Blood Sample)
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-circle text-blue-600 text-[8px] mt-[5px]"></i>
                            Dirofilaria immitis PCR Test (Blood Sample)
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-circle text-blue-600 text-[8px] mt-[5px]"></i>
                            Canine Viral PCR Panel (Blood Sample)
                        </li>
                        </ul>
                    </div>

                    <!-- Pet + Amount -->
                    <div class="flex justify-between items-center mt-6 border-t border-gray-200 pt-4">
                        <div class="flex items-center gap-2 text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-paw text-blue-500"></i> Bruno
                        </div>
                        <span class="text-orange-600 font-semibold text-base">₹6600</span>
                    </div>

                    <!-- Download Report -->
                    <div class="mt-6">
                        <button
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-6 py-2.5 rounded-full text-sm shadow-md hover:shadow-lg transition">
                        <i class="fa-solid fa-file-arrow-down mr-2"></i> Download Report
                        </button>
                    </div>
                    </div>

                    <!-- 💳 Billing Summary Card -->
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 md:p-8">
                    <h3 class="text-[#6483B9] font-semibold text-sm mb-4 uppercase tracking-wide">Bill Summary</h3>

                    <!-- Header -->
                    <div class="flex justify-between items-start mb-4">
                        <div>
                        <h3 class="font-semibold text-gray-800 text-base">
                            Order ID <span class="font-normal text-gray-600">CP1001</span>
                        </h3>
                        <h4 class="text-[#6483B9] font-semibold text-sm mb-3">Pet Detail</h4>
                        </div>
                    </div>

                    <!-- Pet Info -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 text-sm text-gray-700 mb-4 gap-3">
                        <div>
                        <h4 class="font-semibold text-gray-800">Pet Parent</h4>
                        <p>Johny Brown</p>
                        </div>
                        <div>
                        <h4 class="font-semibold text-gray-800">Pet Name</h4>
                        <p>Luna</p>
                        </div>
                        <div>
                        <h4 class="font-semibold text-gray-800">Species</h4>
                        <p>Canis Lupus</p>
                        </div>
                    </div>

                    <!-- Test Summary Box -->
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-6">
                        <div class="flex justify-between items-start">
                        <h4 class="font-semibold text-sm text-gray-800">Test</h4>
                        <span class="font-semibold text-gray-800">₹6600</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                        Dirofilaria immitis PCR Test, Canine Blood Parasite PCR Panel - 4,
                        Canine Viral PCR Panel
                        </p>
                    </div>

                    <!-- Price Details -->
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex justify-between"><span>MRP</span><span class="font-medium">₹6600</span></div>
                        <div class="flex justify-between"><span>Discount</span><span class="font-medium text-red-500">- ₹100</span></div>
                        <div class="flex justify-between"><span>Delivery Charges</span><span class="font-medium">₹50</span></div>
                        <div class="flex justify-between"><span>Sample Collection Charges</span><span class="font-medium">₹50</span></div>
                        <div class="flex justify-between"><span>GST</span><span class="font-medium">₹00</span></div>

                        <div class="border-t border-gray-200 my-3"></div>

                        <div class="flex justify-between text-base font-semibold text-gray-800">
                        <span>Total</span>
                        <span class="text-blue-600">₹6600</span>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- 💾 Download Invoice Button -->
                <div class="text-center mt-10">
                    <button
                    class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-10 py-3 rounded-full shadow-lg hover:shadow-xl transition">
                    <i class="fa-solid fa-file-invoice mr-2"></i> Download Invoice
                    </button>
                </div>
            </main>
        </div>
    </section>
@endsection
@push('scripts')
  <script src="{{ asset('front/js/profile.js') }}"></script>
@endpush