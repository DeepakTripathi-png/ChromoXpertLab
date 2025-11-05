@extends('Front.layouts.app')

@section('title', 'ChromoXpert - Cart')


@section('content')
    <section id="edit-profile" class="pt-24 pb-16 flex-grow">
        <div class="max-w-[1400px] mx-auto px-4 flex flex-col lg:flex-row gap-10">
            {{-- Include sidebar --}}
            @include('Front.partials.sidebar')

            
            <!-- Edit Profile Section -->
            <main class="w-full lg:w-3/4">
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8">

                    <!-- Header -->
                    <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-user-pen text-blue-600"></i> Edit Profile
                    </h2>
                    </div>

                    <!-- Form -->
                    <form class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Name -->
                    <div class="flex flex-col">
                        <label for="name" class="text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="name" name="name"
                        placeholder="Enter your full name"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col">
                        <label for="email" class="text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" name="email"
                        placeholder="Enter your email address"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>

                    <!-- Mobile Number -->
                    <div class="flex flex-col">
                        <label for="mobile" class="text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                        <input type="tel" id="mobile" name="mobile"
                        placeholder="Enter your mobile number"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>

                    </form>

                    <!-- Save Button (bottom-centered for all screens) -->
                    <div class="mt-8 flex justify-center md:justify-end">
                    <button
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition-all duration-200 shadow-sm w-full md:w-auto">
                        Save Changes
                    </button>
                    </div>

                </div>
            </main>

        </div>
    </section>
@endsection
@push('scripts')
  <script src="{{ asset('front/js/profile.js') }}"></script>
@endpush