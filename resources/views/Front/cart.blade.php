@extends('Front.layouts.app')

@section('title', 'ChromoXpert - Cart')

@section('content')
  <!-- CART SECTION -->
  <section id="cart" class="pt-28 pb-20 px-4 sm:px-6 lg:px-8 flex-grow">
      <div class="max-w-[1400px] mx-auto grid lg:grid-cols-3 md:grid-cols-2 gap-10">

      <!-- CART ITEMS -->
      <div id="cart-items" class="lg:col-span-2 space-y-6">
        <h2 class="text-3xl font-bold text-[#6483B9] mb-6">Your Selected Tests</h2>

        <!-- Single Cart Item -->
        <div
          class="cart-item relative bg-white rounded-2xl shadow hover:shadow-lg transition-all p-6 border border-gray-100"
        >
          <button
            class="absolute top-3 right-4 text-red-500 hover:text-red-700 transition remove-item"
            title="Remove"
          >
            <i class="fa-solid fa-trash text-lg"></i>
          </button>
          <h3 class="font-semibold text-lg text-gray-900">Dirofilaria immitis PCR Test</h3>
          <p class="text-sm text-gray-600 mt-1">
            Detecting Dirofilaria immitis in canine blood samples.Detecting Dirofilaria
            immitis in canine blood samples.Detecting Dirofilaria immitis in canine blood
            samples.Detecting Dirofilaria immitis in canine blood samples.
          </p>
          <p class="text-xs mt-2 text-gray-400">Sample Type: Blood</p>
          <div class="mt-3 flex justify-end items-center gap-2">
            <span class="line-through text-gray-400 text-sm">₹2400</span>
            <span class="text-green-600 font-semibold text-lg">₹2200</span>
          </div>
        </div>

        <div
          class="cart-item relative bg-white rounded-2xl shadow hover:shadow-lg transition-all p-6 border border-gray-100"
        >
          <button
            class="absolute top-3 right-4 text-red-500 hover:text-red-700 transition remove-item"
            title="Remove"
          >
            <i class="fa-solid fa-trash text-lg"></i>
          </button>
          <h3 class="font-semibold text-lg text-gray-900">Canine Blood Parasite PCR Panel</h3>
          <p class="text-sm text-gray-600 mt-1">Detects blood-borne infections and pathogens.</p>
          <p class="text-xs mt-2 text-gray-400">Sample Type: Blood</p>
          <div class="mt-3 flex justify-end items-center gap-2">
            <span class="line-through text-gray-400 text-sm">₹2400</span>
            <span class="text-green-600 font-semibold text-lg">₹2100</span>
          </div>
        </div>

        <div
          class="cart-item relative bg-white rounded-2xl shadow hover:shadow-lg transition-all p-6 border border-gray-100"
        >
          <button
            class="absolute top-3 right-4 text-red-500 hover:text-red-700 transition remove-item"
            title="Remove"
          >
            <i class="fa-solid fa-trash text-lg"></i>
          </button>
          <h3 class="font-semibold text-lg text-gray-900">Canine Viral PCR Panel</h3>
          <p class="text-sm text-gray-600 mt-1">Detects viral pathogens in dogs.</p>
          <p class="text-xs mt-2 text-gray-400">Sample Type: Blood</p>
          <div class="mt-3 flex justify-end items-center gap-2">
            <span class="line-through text-gray-400 text-sm">₹2400</span>
            <span class="text-green-600 font-semibold text-lg">₹2300</span>
          </div>
        </div>
      </div>

      <!-- SUMMARY -->
      <aside class="space-y-6">

        <!-- Delivery Address -->
        <div class="bg-white shadow rounded-2xl p-6">
          <h3 class="font-semibold mb-3 text-[#6483B9] text-lg">Delivery Address</h3>
          <p class="text-sm text-gray-700 leading-relaxed">
            123 National Street, Dive, Pune 412345
          </p>

          <div class="text-xs text-[#6483B9] mt-3 space-x-2">
            <button id="changeAddressBtn" type="button" class="hover:underline">Change Address</button> |
            <button id="addAddressBtn" class="hover:underline">Add Address</button>
          </div>
        </div>

        <!-- Pet Info -->
        <div class="bg-white shadow rounded-2xl p-6">
          <h3 class="font-semibold mb-3 text-[#6483B9] text-lg">Pet Information</h3>
          <p class="text-sm text-gray-700"><strong>Pet:</strong> Bruno</p>
          <p class="text-sm text-gray-700"><strong>Parent:</strong> John Brown</p>
          <p class="text-sm text-gray-700"><strong>Species:</strong> Canis Lupus</p>
          <div class="text-xs text-[#6483B9] mt-3 space-x-2">
            <button id="changePetBtn" type="button" class="hover:underline">Change Pet</button> |
            <button id="addNewPetBtn" type="button" class="hover:underline">Add Pet</button>
          </div>
        </div>

        <!-- Payment Summary -->
        <div class="bg-white shadow rounded-2xl p-6">
          <h3 class="font-semibold mb-4 text-[#6483B9] text-lg">Payment Summary</h3>

          <div class="text-sm text-gray-700 space-y-2">
            <div class="flex justify-between"><span>MRP</span><span>₹6700</span></div>
            <div class="flex justify-between"><span>Discount</span><span>- ₹100</span></div>
            <div class="flex justify-between"><span>Delivery Charges</span><span>₹50</span></div>
            <div class="flex justify-between"><span>Sample Collection</span><span>₹50</span></div>
            <hr class="my-2">
            <div class="flex justify-between font-semibold text-lg text-gray-900">
              <span>Total</span><span>₹6700</span>
            </div>
          </div>

          <div class="mt-5 space-y-2 text-sm">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="payment" checked class="text-blue-600 focus:ring-blue-500">
              <span>Cash on Delivery</span>
            </label>

            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="payment" class="text-blue-600 focus:ring-blue-500" disabled>
              <span>Pay Online</span>
            </label>
          </div>

          <button
            class="w-full mt-6 bg-[#6483B9] hover:bg-[#4f6ca0] text-white py-3 rounded-lg font-semibold text-base transition"
          >
            Book Now
          </button>
        </div>
      </aside>
    </div>
  </section>
  <!-- ADD ADDRESS MODAL -->
  <div id="addAddressModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 md:mx-0 p-6 relative">

      <!-- Modal Header -->
      <h3 class="text-xl md:text-2xl font-bold text-[#6483B9] mb-6 text-center">Add Address</h3>

      <!-- Address Form -->
      <form class="space-y-4">
        <input
          type="text"
          placeholder="Flat, House number, Company, Apartment"
          class="w-full border border-gray-300 focus:border-[#6483B9] rounded-lg p-2.5 focus:outline-none"
        >
        <input
          type="text"
          placeholder="Area, Street, Sector, Village"
          class="w-full border border-gray-300 focus:border-[#6483B9] rounded-lg p-2.5 focus:outline-none"
        >
        <input
          type="text"
          placeholder="Landmark"
          class="w-full border border-gray-300 focus:border-[#6483B9] rounded-lg p-2.5 focus:outline-none"
        >
        <input
          type="text"
          placeholder="Pincode"
          class="w-full border border-gray-300 focus:border-[#6483B9] rounded-lg p-2.5 focus:outline-none"
        >
        <input
          type="text"
          placeholder="City/Town"
          class="w-full border border-gray-300 focus:border-[#6483B9] rounded-lg p-2.5 focus:outline-none"
        >
      </form>

      <!-- Buttons -->
      <div class="flex justify-end mt-6 gap-3">
        <button
          id="cancelAddAddress"
          class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-medium transition"
        >
          Cancel
        </button>
        <button
          class="bg-[#6483B9] hover:bg-[#4f6ca0] text-white px-5 py-2 rounded-lg font-medium transition"
        >
          Save
        </button>
      </div>
    </div>
  </div>
  <!-- Change ADDRESS MODAL -->
  <div id="changeAddressModal"
  class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 md:mx-0 p-6 relative">

    <!-- Header -->
    <h3 class="text-xl md:text-2xl font-bold text-[#6483B9] mb-6 text-center">Select Address</h3>

    <!-- Address Options -->
    <form class="space-y-3">
      <label class="flex items-start gap-3 cursor-pointer border border-gray-200 rounded-lg p-3 hover:border-[#6483B9] transition">
        <input type="radio" name="address" class="mt-1 text-blue-600 focus:ring-[#6483B9]" checked>
        <span class="text-gray-700 text-sm md:text-base leading-snug">
          123 National Street, Dive rd 412345 Pune, India
        </span>
      </label>

      <label class="flex items-start gap-3 cursor-pointer border border-gray-200 rounded-lg p-3 hover:border-[#6483B9] transition">
        <input type="radio" name="address" class="mt-1 text-blue-600 focus:ring-[#6483B9]">
        <span class="text-gray-700 text-sm md:text-base leading-snug">
          245 Shankar Sheth Rd, Sadashiv Peth, Pune 411210
        </span>
      </label>

      <label class="flex items-start gap-3 cursor-pointer border border-gray-200 rounded-lg p-3 hover:border-[#6483B9] transition">
        <input type="radio" name="address" class="mt-1 text-blue-600 focus:ring-[#6483B9]">
        <span class="text-gray-700 text-sm md:text-base leading-snug">
          145 Tilak Rd, Subhashnagar, Shukrawar Peth, Pune 411240
        </span>
      </label>
    </form>

    <!-- Buttons -->
    <div class="flex justify-end mt-6 gap-3">
      <button id="cancelChangeAddress"
        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-medium transition">
        Cancel
      </button>
      <button id="saveChangeAddress"
        class="bg-[#6483B9] hover:bg-[#4f6ca0] text-white px-5 py-2 rounded-lg font-medium transition">
        Save
      </button>
    </div>
  </div>
</div>
<!-- ADD PET MODAL -->
<div id="addPetModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl mx-4 md:mx-0 p-6 relative">
    <h3 class="text-2xl font-semibold text-[#6483B9] mb-6 text-center">Add Pet</h3>
    <form id="addPetForm" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Pet Type*</label>
        <select class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-[#6483B9]" required>
          <option value="">Select Type</option>
          <option>Dog</option>
          <option>Cat</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Pet Name*</label>
        <input type="text" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-[#6483B9]" placeholder="Enter Pet Name" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Species*</label>
        <select class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-[#6483B9]" required>
          <option value="">Select Species</option>
          <option>Canis Lupus</option>
          <option>Felis Catus</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Breed*</label>
        <input type="text" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-[#6483B9]" placeholder="Enter Breed" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Gender*</label>
        <select class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-[#6483B9]" required>
          <option value="">Select Gender</option>
          <option>Male</option>
          <option>Female</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Age*</label>
        <input type="number" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-[#6483B9]" placeholder="Enter Age" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Weight*</label>
        <input type="number" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-[#6483B9]" placeholder="Enter Weight" required>
      </div>

      <div class="flex justify-end gap-3 pt-4">
        <button type="button" id="cancelAddPet" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-medium transition">Cancel</button>
        <button type="submit" class="bg-[#6483B9] hover:bg-[#4f6ca0] text-white px-5 py-2 rounded-lg font-medium transition">Save</button>
      </div>
    </form>
  </div>
</div>
<!--Change Pet Model-->
 <div id="selectPetModal" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-start z-50 hidden overflow-y-auto">
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 md:mx-0 mt-20 p-6 relative">
      <h3 class="text-2xl font-semibold text-[#6483B9] mb-6 text-center">Select Pet</h3>

      <!-- Pet List -->
      <form id="selectPetForm" class="space-y-4">
        <!-- Pet 1 -->
        <label class="flex items-start gap-3 cursor-pointer border-b border-gray-200 pb-3">
          <input type="radio" name="petSelect" value="Luna" class="mt-1 text-blue-600 focus:ring-blue-500" checked>
          <div>
            <p class="text-sm text-gray-800 font-semibold">Pet Parent/Care Of: Johny Brown</p>
            <p class="text-sm text-gray-700">Pet Name: Luna</p>
            <p class="text-sm text-gray-700">Species: Canis Lupus</p>
          </div>
        </label>

        <!-- Pet 2 -->
        <label class="flex items-start gap-3 cursor-pointer border-b border-gray-200 pb-3">
          <input type="radio" name="petSelect" value="Bravo" class="mt-1 text-blue-600 focus:ring-blue-500">
          <div>
            <p class="text-sm text-gray-800 font-semibold">Pet Parent/Care Of: Johny Brown</p>
            <p class="text-sm text-gray-700">Pet Name: Bravo</p>
            <p class="text-sm text-gray-700">Species: Canis Lupus</p>
          </div>
        </label>

        <!-- Pet 3 -->
        <label class="flex items-start gap-3 cursor-pointer">
          <input type="radio" name="petSelect" value="Bruno" class="mt-1 text-blue-600 focus:ring-blue-500">
          <div>
            <p class="text-sm text-gray-800 font-semibold">Pet Parent/Care Of: Johny Brown</p>
            <p class="text-sm text-gray-700">Pet Name: Bruno</p>
            <p class="text-sm text-gray-700">Species: Canis Lupus</p>
          </div>
        </label>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 pt-6">
          <button type="button" id="cancelSelectPet" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-medium transition">Cancel</button>
          <button type="submit" class="bg-[#6483B9] hover:bg-[#4f6ca0] text-white px-5 py-2 rounded-lg font-medium transition">Save</button>
        </div>
      </form>
    </div>
  </div>
@endsection
@push('scripts')
  <script src="{{ asset('front/js/cart.js') }}"></script>
@endpush