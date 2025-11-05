@extends('Front.layouts.app')

@section('title', 'ChromoXpert - Cart')


@section('content')
    <!-- Profile Section -->
<section id="profile" class="pt-24 pb-16 flex-grow">
    <div class="max-w-[1400px] mx-auto px-4 flex flex-col lg:flex-row gap-10">

    {{-- Include sidebar --}}
    @include('Front.partials.sidebar')


    {{-- Main Page --}}
    <main class="w-full lg:w-3/4">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Recent Orders</h2>

        <div class="grid md:grid-cols-2 gap-8">
        <!-- Order Card -->
            
        <div
                class="bg-white rounded-2xl p-6 shadow-soft border border-gray-100 order-card relative hover:shadow-lg transition cursor-pointer"
                onclick="window.location.href='{{url('billing-summary')}}'"
                >
            <div class="absolute top-0 right-0 bg-green-600 text-white text-xs font-semibold px-4 py-1 rounded-bl-lg rounded-tr-2xl">
                Incompleted
            </div>

            <!-- Order Header -->
            <div class="mb-3">
                <h3 class="font-semibold text-gray-800 text-base">
                Order ID <span class="font-normal text-gray-600">CP1001</span>
                </h3>

                <!-- Date + Paid in one line -->
                <div class="flex items-center text-sm text-gray-500 mt-1">
                <span>24/11/2025 • 11:00 AM</span>
                <span class="ml-3 px-2 py-0.5 bg-blue-100 text-blue-600 font-semibold rounded-full text-xs">
                    Paid
                </span>
                </div>
            </div>

            <!-- Test Details -->
            <div class="mt-3">
                <h4 class="font-semibold text-sm mb-2 text-gray-800">Test Details</h4>
                <ul class="space-y-1 text-sm text-gray-700 list-disc list-inside">
                <li>Canine Blood Parasite PCR Panel - 4</li>
                <li>Dirofilaria immitis PCR Test</li>
                <li>Canine Viral PCR Panel</li>
                </ul>
            </div>

            <!-- Pet & Price -->
            <div class="flex justify-between items-center mt-4">
                <div class="flex items-center gap-2">
                <i class="fa-solid fa-paw text-blue-500"></i>
                <span class="font-medium">Bruno</span>
                </div>
                <span class="text-orange-600 font-semibold">₹6600</span>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-5">
                <button class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-full text-sm font-medium">
                Cancel
                </button>
                <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2.5 rounded-full text-sm font-medium">
                Download Report
                </button>
            </div>

            <!-- Delivery Person -->
            <div class="mt-6 border-t border-gray-200 pt-3">
                <h4 class="font-semibold text-sm mb-1 text-gray-800">Delivery Person</h4>
                <p class="text-xs text-gray-500">Collection Time</p>
                <div class="flex justify-between text-sm mt-2">
                <span><i class="fa-solid fa-user text-blue-500 mr-1"></i> John Doe</span>
                <span><i class="fa-solid fa-phone text-blue-500 mr-1"></i> +91 9898565870</span>
                </div>
            </div>
        </div>

        <!-- Duplicate Card -->
        <div
                class="bg-white rounded-2xl p-6 shadow-soft border border-gray-100 order-card relative hover:shadow-lg transition cursor-pointer"
                onclick="window.location.href='{{url('billing-summary')}}'"
                >
            <div class="absolute top-0 right-0 bg-green-600 text-white text-xs font-semibold px-4 py-1 rounded-bl-lg rounded-tr-2xl">
                Incompleted
            </div>

            <!-- Order Header -->
            <div class="mb-3">
                <h3 class="font-semibold text-gray-800 text-base">
                Order ID <span class="font-normal text-gray-600">CP1001</span>
                </h3>

                <!-- Date + Paid in one line -->
                <div class="flex items-center text-sm text-gray-500 mt-1">
                <span>24/11/2025 • 11:00 AM</span>
                <span class="ml-3 px-2 py-0.5 bg-blue-100 text-blue-600 font-semibold rounded-full text-xs">
                    Paid
                </span>
                </div>
            </div>

            <!-- Test Details -->
            <div class="mt-3">
                <h4 class="font-semibold text-sm mb-2 text-gray-800">Test Details</h4>
                <ul class="space-y-1 text-sm text-gray-700 list-disc list-inside">
                <li>Canine Blood Parasite PCR Panel - 4</li>
                <li>Dirofilaria immitis PCR Test</li>
                <li>Canine Viral PCR Panel</li>
                </ul>
            </div>

            <!-- Pet & Price -->
            <div class="flex justify-between items-center mt-4">
                <div class="flex items-center gap-2">
                <i class="fa-solid fa-paw text-blue-500"></i>
                <span class="font-medium">Bruno</span>
                </div>
                <span class="text-orange-600 font-semibold">₹6600</span>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-5">
                <button class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-full text-sm font-medium">
                Cancel
                </button>
                <button class="bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2.5 rounded-full text-sm font-medium">
                Download Report
                </button>
            </div>

            <!-- Delivery Person -->
            <div class="mt-6 border-t border-gray-200 pt-3">
                <h4 class="font-semibold text-sm mb-1 text-gray-800">Delivery Person</h4>
                <p class="text-xs text-gray-500">Collection Time</p>
                <div class="flex justify-between text-sm mt-2">
                <span><i class="fa-solid fa-user text-blue-500 mr-1"></i> John Doe</span>
                <span><i class="fa-solid fa-phone text-blue-500 mr-1"></i> +91 9898565870</span>
                </div>
            </div>
        </div>
        </div>
    </main>
    </div>
</section>
@endsection
@push('scripts')
  <script src="{{ asset('front/js/profile.js') }}"></script>
@endpush