@extends('Front.layouts.app')

@section('title', 'ChromoXpert - Manage Address')


@section('content')
   <section id="manage-address" class="pt-24 pb-16 flex-grow">
        <div class="max-w-[1400px] mx-auto px-4 flex flex-col lg:flex-row gap-10">
            {{-- Include sidebar --}}
            @include('Front.partials.sidebar')
            

            <!-- Manage Address Summary -->
            <main class="w-full lg:w-3/4">
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">Manage Address</h2>

                    <!-- Add Address Button -->
                    <div class="border-2 border-dashed border-blue-400 rounded-xl p-4 text-center hover:bg-blue-50 transition cursor-pointer"
                    onclick="openAddressModal()">
                    <span class="text-blue-600 font-semibold text-lg flex justify-center items-center gap-2">
                        <i class="fa-solid fa-plus text-xl"></i> Add Address
                    </span>
                    </div>

                    
                    <!-- Address List -->
                    <div class="mt-8 space-y-4">

                    <!-- Address 1 -->
                    <div class="bg-gray-50 p-4 rounded-2xl shadow-sm flex justify-between items-start hover:bg-gray-100 transition">
                        <div>
                        <h3 class="font-semibold text-gray-800 text-lg mb-1">Address 1</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            123 National Street, Dive Road, Manasi Colony, Haspasar 454110 Pune
                        </p>
                        </div>
                        <div class="flex gap-3 text-gray-500">
                        <button class="hover:text-blue-600 transition" title="Edit Address" onclick="openAddressModal()">
                            <i class="fa-solid fa-pen-to-square text-lg"></i>
                        </button>
                        <button class="hover:text-red-600 transition" title="Delete Address" onclick="deleteAddress(this)">
                            <i class="fa-solid fa-trash text-lg"></i>
                        </button>
                        </div>
                    </div>

                    <!-- Address 2 -->
                    <div class="bg-gray-50 p-4 rounded-2xl shadow-sm flex justify-between items-start hover:bg-gray-100 transition">
                        <div>
                        <h3 class="font-semibold text-gray-800 text-lg mb-1">Address 2</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            345 Sharad Street, Shankar Sheth Road, Parijat Colony, Haspasar 454120 Pune
                        </p>
                        </div>
                        <div class="flex gap-3 text-gray-500">
                        <button class="hover:text-blue-600 transition" title="Edit Address" onclick="openAddressModal()">
                            <i class="fa-solid fa-pen-to-square text-lg"></i>
                        </button>
                        <button class="hover:text-red-600 transition" title="Delete Address" onclick="deleteAddress(this)">
                            <i class="fa-solid fa-trash text-lg"></i>
                        </button>
                        </div>
                    </div>

                    <!-- Address 3 -->
                    <div class="bg-gray-50 p-4 rounded-2xl shadow-sm flex justify-between items-start hover:bg-gray-100 transition">
                        <div>
                        <h3 class="font-semibold text-gray-800 text-lg mb-1">Address 3</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            678 Welcome Street, Vinayak Road, Shivneri Colony, Haspasar 454120 Pune
                        </p>
                        </div>
                        <div class="flex gap-3 text-gray-500">
                        <button class="hover:text-blue-600 transition" title="Edit Address" onclick="openAddressModal()">
                            <i class="fa-solid fa-pen-to-square text-lg"></i>
                        </button>
                        <button class="hover:text-red-600 transition" title="Delete Address" onclick="deleteAddress(this)">
                            <i class="fa-solid fa-trash text-lg"></i>
                        </button>
                        </div>
                    </div>

                    </div>

                </div>

                <!-- Modal -->
                <div id="addressModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 relative">
                    <!-- Close Button -->
                    <button onclick="closeAddressModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>

                    <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center">Add New Address</h3>

                    <form class="space-y-4">
                        <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address Line</label>
                        <input type="text" placeholder="Enter address"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" placeholder="Enter city"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pincode</label>
                        <input type="text" placeholder="Enter pincode"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>

                        <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeAddressModal()"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                        <button type="button"
                            class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Save</button>
                        </div>
                    </form>
                    </div>
                </div>
            </main>
        </div>
    </section>
@endsection
@push('scripts')
  <script src="{{ asset('front/js/profile.js') }}"></script>
@endpush