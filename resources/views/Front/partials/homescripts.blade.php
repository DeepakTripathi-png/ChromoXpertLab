<!-- External Libraries -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
function showToast(message, type = 'info') {
    let bgColor;

    switch (type) {
        case 'success':
            bgColor = "#16a34a"; // green
            break;
        case 'error':
            bgColor = "#dc2626"; // red
            break;
        case 'warning':
            bgColor = "#f59e0b"; // amber
            break;
        default:
            bgColor = "#3b82f6"; // blue (info)
    }

    Toastify({
        text: message,
        duration: 3000,
        gravity: "bottom", // top or bottom
        position: "right", // left, center or right
        backgroundColor: bgColor,
        stopOnFocus: true,
        close: true, // adds a close (×) icon
    }).showToast();
}    
document.addEventListener("DOMContentLoaded", async () => {

    /* ==============================
       1️⃣ HEADER MENU SECTION
    ===============================*/

    // Mobile Menu Toggle
    const toggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('mobile-menu');

    if (toggle && menu) {
        toggle.addEventListener('click', () => menu.classList.toggle('hidden'));
        document.querySelectorAll('#mobile-menu .nav-link').forEach(link => {
            link.addEventListener('click', () => menu.classList.add('hidden'));
        });
    }

    // --- Active Link Highlight (Desktop + Mobile) ---
    const sections = document.querySelectorAll('section[id]');
    const allLinks = document.querySelectorAll('header nav a.nav-link, #mobile-menu a.nav-link');
    const header = document.querySelector('header');

    window.addEventListener('scroll', () => {
        let current = '';
        const offset = window.innerWidth < 768 ? 10 : 100;
        const headerHeight = header ? header.offsetHeight : 0;
        const scrollPos = window.scrollY + headerHeight + offset;

        sections.forEach(section => {
            if (scrollPos >= section.offsetTop && scrollPos < section.offsetTop + section.offsetHeight) {
                current = section.getAttribute('id');
            }
        });

        allLinks.forEach(link => {
            if (link.href.endsWith(`#${current}`)) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    });

    // trigger once on page load
    window.dispatchEvent(new Event('scroll'));

    /* ==============================
       2️⃣ HOME BANNER SLIDER
    ===============================*/

    const swiper = new Swiper('.mySwiper', {
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    });


    /* ==============================
       3️⃣ CUSTOMER REVIEW SECTION
    ===============================*/

    const reviews = [
        { name: "Dr. Swati Birmole", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 2.5, text: "I have visited ChromoXpert lab 3/4 times in the last 3 years for my pet dog’s lab tests. They have always given excellent service." },
        { name: "Sumit Gaikwad", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 5, text: "Well-equipped multi-facility lab available in the Navi Mumbai area where genetic as well as COVID tests are performed. Supportive, coherent, and experienced staff available." },
        { name: "Rashmi Nimbalkar", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 3, text: "Highly satisfied with services, best lab I have ever seen. Good setup, experienced staff. Happy with service. All the best doctor." },
        { name: "Rohan Deshmukh", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 4.5, text: "Very friendly staff and professional service. Reports are always on time and well explained." },
        { name: "Neha Kulkarni", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 4, text: "Clean, efficient, and well-organized lab. A great experience for pet owners who want quality diagnostics." },
        { name: "Dr. Swati Birmole", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 2.5, text: "I have visited ChromoXpert lab 3/4 times in the last 3 years for my pet dog’s lab tests. They have always given excellent service." },
        { name: "Sumit Gaikwad", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 5, text: "Well-equipped multi-facility lab available in the Navi Mumbai area where genetic as well as COVID tests are performed. Supportive, coherent, and experienced staff available." },
        { name: "Rashmi Nimbalkar", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 3, text: "Highly satisfied with services, best lab I have ever seen. Good setup, experienced staff. Happy with service. All the best doctor." },
        { name: "Rohan Deshmukh", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 4.5, text: "Very friendly staff and professional service. Reports are always on time and well explained." },
        { name: "Neha Kulkarni", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 4, text: "Clean, efficient, and well-organized lab. A great experience for pet owners who want quality diagnostics." },
        { name: "Dr. Swati Birmole", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 2.5, text: "I have visited ChromoXpert lab 3/4 times in the last 3 years for my pet dog’s lab tests. They have always given excellent service." },
        { name: "Sumit Gaikwad", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 5, text: "Well-equipped multi-facility lab available in the Navi Mumbai area where genetic as well as COVID tests are performed. Supportive, coherent, and experienced staff available." },
        { name: "Rashmi Nimbalkar", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 3, text: "Highly satisfied with services, best lab I have ever seen. Good setup, experienced staff. Happy with service. All the best doctor." },
        { name: "Rohan Deshmukh", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 4.5, text: "Very friendly staff and professional service. Reports are always on time and well explained." },
        { name: "Neha Kulkarni", img: "{{ url('front/images/image/reviewLogo.png') }}", rating: 4, text: "Clean, efficient, and well-organized lab. A great experience for pet owners who want quality diagnostics." },
    
    ];

    function renderStars(rating) {
        const full = '<i class="fa-solid fa-star text-yellow-400"></i>';
        const half = '<i class="fa-solid fa-star-half-stroke text-yellow-400"></i>';
        const empty = '<i class="fa-regular fa-star text-yellow-400"></i>';
        let stars = '';
        for (let i = 1; i <= 5; i++) stars += rating >= i ? full : rating >= i - 0.5 ? half : empty;
        return stars;
    }

    const reviewWrapper = document.getElementById('reviews-wrapper');
    if (reviewWrapper) {
        reviews.forEach(r => {
            const slide = document.createElement('div');
            slide.className = 'swiper-slide';
            slide.innerHTML = `
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg p-6 flex flex-col justify-between h-full">
                    <div class="flex items-center mb-4">
                        <img src="${r.img}" alt="${r.name}" class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <h4 class="font-semibold text-gray-800">${r.name}</h4>
                            <div class="flex space-x-1">${renderStars(r.rating)}</div>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">${r.text}</p>
                </div>
            `;
            reviewWrapper.appendChild(slide);
        });
    }

    new Swiper('.reviews-swiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        pagination: { el: '.reviews-pagination', clickable: true },
        navigation: { nextEl: '.reviews-button-next', prevEl: '.reviews-button-prev' },
        autoplay: { delay: 3000, disableOnInteraction: false },
        breakpoints: { 640: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
    });


    /* ==============================
       4️⃣ MAP SECTION
    ===============================*/

    const mapContainer = document.getElementById('map');
    if (mapContainer) {
        const map = L.map('map').setView([19.080, 73.131], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 12 }).addTo(map);
        L.marker([19.080285697350398, 73.13151749473663])
            .addTo(map)
            .bindPopup('📍 ChromoXpert - Main Branch')
            .openPopup();
    }


    
    /* ---------------------------
       🧬 Dynamic Test Cards
    --------------------------- */
    async function loadTests() {
        try {
                const response = await fetch('/front/tests');
                const tests = await response.json();
                //console.log('Fetched tests:', tests);
                let filteredTests = [...tests];
                const createCard = (test) => `
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col justify-between h-full border border-gray-100">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <img src="/front/images/image/testing_img.png" alt="Icon" class="w-10 h-10">
                            <div class="text-left">
                                <h3 class="font-semibold text-lg text-[#6483B9]">${test.name}</h3>
                                <p class="text-gray-600 text-sm">${test.short_name || 'No short name'}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div class="text-left">
                            <!--<span class="line-through text-gray-400 text-sm mr-1">₹${parseFloat(test.total_price) + 200}</span>-->
                            <span class="text-green-600 font-semibold text-lg">₹${test.total_price}</span>
                        </div>
                        <button class="add-to-cart bg-[#6483B9] hover:bg-[#4f6ca0] text-white px-4 py-2 rounded-lg text-sm font-medium transition" data-id="${test.id}">Add to Cart</button>
                    </div>
                    <p class="text-xs text-gray-500 mt-4 text-center">Report Within 24–48 hr</p>
                </div>
            `;

            const testGrid = document.getElementById('test-grid');
            const allTestGrid = document.getElementById('all-test-grid');

            if (testGrid) testGrid.innerHTML = tests.slice(0, 4).map(createCard).join('');
            if (allTestGrid) allTestGrid.innerHTML = tests.map(createCard).join('');
            const renderTests = (data) => {
                const grid = document.getElementById('all-test-grid');
                if (grid) {
                    grid.innerHTML =
                        data.length > 0
                            ? data.map(createCard).join('')
                            : `<p class="col-span-full text-center text-gray-500 py-10">No tests found.</p>`;
                }
            };

            // initial render
            renderTests(filteredTests);

            // search logic
            const searchInput = document.getElementById('test-search');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    const q = e.target.value.toLowerCase().trim();
                    filteredTests = tests.filter((t) =>
                        (t.name?.toLowerCase().includes(q)) ||
                        (t.short_name?.toLowerCase().includes(q)) ||
                        (t.test_code?.toLowerCase().includes(q))
                    );
                    renderTests(filteredTests);
                });
            }
            document.addEventListener('click', async (e) => {
                if (e.target.classList.contains('add-to-cart')) {
                    e.preventDefault();
                    const testId = e.target.getAttribute('data-id');

                    try {
                        const res = await fetch('/front/check-login');
                        const data = await res.json();

                        if (!data.loggedIn) {
                            // User is not logged in → show login modal
                            const loginModal = document.getElementById('login-modal');
                            if (loginModal) {
                                loginModal.classList.remove('hidden');
                                document.body.classList.add('overflow-hidden');
                            }
                            return;
                        }

                        // 🛒 If logged in → proceed to add to cart
                        await addToCart(testId);
                    } catch (error) {
                        console.error('Error checking login:', error);
                    }
                }
            });

        }catch (error) {
            console.error('Error fetching tests:', error);
        }
    }
    loadTests();
    // ===================== Modal Control =====================
    const modal = document.getElementById('test-modal');
    const openBtn = document.getElementById('view-all-btn');
    const closeBtn = document.getElementById('close-modal');

    if (openBtn && modal) {
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    }

    if (closeBtn && modal) {
        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    }

    // Close when clicking the background (outside content)
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
    /* ADD To Cart Functionality */
        window.updateCartCount = function(count, addedIds = []) {
            const cartBadges = [
                document.getElementById('cart-count-desktop'),
                document.getElementById('cart-count-mobile')
            ];

            cartBadges.forEach(el => {
                if (!el) return;
                el.textContent = count;
                el.style.opacity = count > 0 ? '1' : '0';
            });

            addedIds.forEach(id => {
                const btn = document.querySelector(`.add-to-cart[data-id="${id}"]`);
                if (btn) {
                    btn.textContent = '✅ Added';
                    btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    btn.classList.add('bg-green-600', 'cursor-default');
                    btn.disabled = true;
                }
            });
        }
        async function addToCart(testId) {
            try {
                const res = await fetch('/front/add-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ test_id: testId })
                });

                const data = await res.json();

                // ✅ Get the clicked button
                const button = document.querySelector(`.add-to-cart[data-id="${testId}"]`);

                if (data.success) {
                    updateCartCount(data.cartCount);
                    showToast('Test added to cart successfully!', 'success');

                    // ✅ Change button text to "Added"
                    if (button) {
                        button.textContent = '✅ Added';
                        button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        button.classList.add('bg-green-600', 'cursor-default');
                        button.disabled = true; // optional (prevents multiple adds)
                    }
                } else {
                    showToast(data.message || 'Failed to add test to cart!', 'error');
                }
            } catch (error) {
                console.error('Add to cart error:', error);
            }
        }
        try {
            const res = await fetch('/front/cart-count');
            const data = await res.json();
            updateCartCount(data.cartCount, data.testIds || []);
        } catch (error) {
            console.error('Error fetching cart count:', error);
        }
        
    /* END OF Add To Cart Functionality */
    
    /* ==============================
       5️⃣ SERVICE SLIDER
    ===============================*/

    new Swiper(".services-swiper", {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        grabCursor: true,
        autoplay: { delay: 3500, disableOnInteraction: false },
        pagination: { el: ".services-pagination", clickable: true },
        navigation: { nextEl: ".services-button-next", prevEl: ".services-button-prev" },
        breakpoints: { 640: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
    });


    /* ==============================
       6️⃣ LOGIN / SIGNUP / OTP MODALS
    ===============================*/

    const loginModal = document.getElementById('login-modal');
    const signupModal = document.getElementById('signup-modal');
    const otpModal = document.getElementById('otp-modal');

    const loginOpenBtns = document.querySelectorAll('.open-login-btn');
    const loginClose = document.getElementById('close-login');
    const openSignup = document.getElementById('open-signup');
    const closeSignup = document.getElementById('close-signup');
    const backToLogin = document.getElementById('back-to-login');
    const closeOtp = document.getElementById('close-otp');
    const verifyOtp = document.getElementById('verify-otp');
    const loginBtn = document.getElementById('login-btn');
    const mobileInput = document.getElementById('mobile');
    const errorMsg = document.getElementById('mobile-error');
    const otpInputs = document.querySelectorAll('.otp-input');

    // Login modal open/close
    loginOpenBtns.forEach(btn => btn.addEventListener('click', () => loginModal?.classList.remove('hidden')));
    loginClose?.addEventListener('click', () => loginModal?.classList.add('hidden'));
    loginModal?.addEventListener('click', e => { if (e.target === loginModal) loginModal.classList.add('hidden'); });

    // Signup modal open/close
    openSignup?.addEventListener('click', () => { loginModal.classList.add('hidden'); signupModal.classList.remove('hidden'); });
    closeSignup?.addEventListener('click', () => signupModal.classList.add('hidden'));
    backToLogin?.addEventListener('click', () => { signupModal.classList.add('hidden'); loginModal.classList.remove('hidden'); });

    // OTP logic
    loginBtn?.addEventListener('click', async e => {
        e.preventDefault();

        const mobile = mobileInput.value.trim();
        const valid = /^[6-9]\d{9}$/;
        const loginMsg = document.getElementById('login-msg');

        // Reset previous message
        loginMsg.className = "hidden text-sm mb-3 text-center";
        loginMsg.textContent = "";

        if (!valid.test(mobile)) {
            mobileInput.classList.add('border-red-500');
            loginMsg.textContent = "Please enter a valid 10-digit mobile number.";
            loginMsg.className = "text-sm mb-3 text-center text-red-600";
            return;
        }
        mobileInput.classList.remove('border-red-500');

        loginBtn.disabled = true;
        loginBtn.textContent = "Sending OTP...";

        try {
            const response = await fetch("{{ route('front.sendOtp') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ mobile })
            });

            const result = await response.json();

            if (result.status === 'success') {
                loginModal.classList.add('hidden');
                otpModal.classList.remove('hidden');

                // ✅ success message shown in login modal before switching
                loginMsg.textContent = "OTP sent successfully to " + mobile;
                loginMsg.className = "text-sm mb-3 text-center text-green-600";

                // Also show message in OTP modal if you want
                const otpMessage = document.getElementById('otp-mobile');
                if (otpMessage) {
                    otpMessage.textContent = "+91"+mobile;
                    otpMessage.classList.remove('hidden');
                    otpMessage.classList.add('text-green-600');
                }
            } else {
                loginMsg.textContent = result.message || "Failed to send OTP. Please try again.";
                loginMsg.className = "text-sm mb-3 text-center text-red-600";
            }

        } catch (err) {
            loginMsg.textContent = "Network error while sending OTP.";
            loginMsg.className = "text-sm mb-3 text-center text-red-600";
        } finally {
            loginBtn.disabled = false;
            loginBtn.textContent = "Send OTP";
        }
    });

    closeOtp?.addEventListener('click', () => otpModal.classList.add('hidden'));
    otpModal?.addEventListener('click', e => { if (e.target === otpModal) otpModal.classList.add('hidden'); });

    otpInputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length === 1 && index < otpInputs.length - 1) otpInputs[index + 1].focus();
        });
        input.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && index > 0 && !input.value) otpInputs[index - 1].focus();
        });
    });

    verifyOtp?.addEventListener('click', async () => {
       const otpInputs = document.querySelectorAll('.otp-input');
        const otp = Array.from(otpInputs).map(i => i.value.trim()).join('');
        const otpMsg = document.getElementById('otp-msg');
        const otpMobileEl = document.getElementById('otp-mobile');

        // ✅ Extract clean 10-digit mobile number
        let mobile = '';
        if (otpMobileEl) {
            const raw = otpMobileEl.textContent.replace(/\D/g, '');
            mobile = raw.slice(-10);
        }

        // Reset message
        otpMsg.className = "hidden text-sm text-center mb-3";
        otpMsg.textContent = "";

        if (otp.length < 4) {
            otpMsg.textContent = "Please enter complete 4-digit OTP.";
            otpMsg.className = "text-sm text-center text-red-600 mb-3";
            return;
        }

        if (!/^[6-9]\d{9}$/.test(mobile)) {
            otpMsg.textContent = "Invalid or missing mobile number. Please resend OTP.";
            otpMsg.className = "text-sm text-center text-red-600 mb-3";
            return;
        }

        verifyOtp.disabled = true;
        verifyOtp.textContent = "Verifying...";

        try {
            const response = await fetch("{{ route('front.verifyOtp') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ mobile, otp })
            });

            const result = await response.json();

            if (result.status === "success") {
                otpMsg.textContent = "OTP verified successfully! Redirecting...";
                otpMsg.className = "text-sm text-center text-green-600 mb-3";

                setTimeout(() => {
                    otpModal.classList.add('hidden');
                    window.location.reload();
                }, 1200);
            } else {
                otpMsg.textContent = result.message || "Invalid OTP. Please try again.";
                otpMsg.className = "text-sm text-center text-red-600 mb-3";
            }
        } catch (error) {
            otpMsg.textContent = "Network error while verifying OTP.";
            otpMsg.className = "text-sm text-center text-red-600 mb-3";
        } finally {
            verifyOtp.disabled = false;
            verifyOtp.textContent = "Continue";
        }
    });

    /* Start Smooth Behaviour of SPA Link from Another Pages */
    const scrollToSection = () => {
        const section = localStorage.getItem('scrollToSection');
        if (!section) return;

        let attempts = 0;
        const maxAttempts = 50; // ~10 seconds retry
        const interval = 200; // retry every 200ms

        const tryScroll = () => {
            const target = document.getElementById(section);
            if (target) {
                const headerOffset = document.querySelector('header')?.offsetHeight || 0;
                const offsetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerOffset;

                window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
                console.log("✅ Scrolled to:", section);

                localStorage.removeItem('scrollToSection'); // remove after success
            } else if (attempts < maxAttempts) {
                attempts++;
                setTimeout(tryScroll, interval);
            } else {
                console.warn("❌ Section not found:", section);
                localStorage.removeItem('scrollToSection'); // avoid infinite retry
            }
        };

        setTimeout(tryScroll, 200); // initial delay for DOM content
    };
    if (window.location.pathname === '/' || window.location.pathname === '/index') {
        scrollToSection();
    }
    window.addEventListener('load', () => {
        if (window.location.pathname === '/' || window.location.pathname === '/index') {
            scrollToSection();
        }
    });
    /* End Smooth Behaviour of SPA Link from Another Pages */
    /* Sign Up Form Submitt */
    const signupForm = document.getElementById('signup-form');
    if (signupForm) {
        signupForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const data = new FormData(form);
            const messageBox = document.getElementById('signup-message');
            // Reset previous messages
            messageBox.className = "hidden mb-4 text-center text-sm font-medium";
            messageBox.textContent = "";
            try {
                const response = await fetch("{{ route('front.register') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: data
                });
                const result = await response.json();
                if (result.status === 'success') {
                    // ✅ Show success message
                    messageBox.textContent = result.message;
                    messageBox.className = "mb-4 text-center text-sm font-medium text-green-600";
                    form.reset();

                    // Close modal after a short delay
                    setTimeout(() => {
                        document.getElementById('signup-modal').classList.add('hidden');
                    }, 1500);

                } else if (result.status === 'error') {
                    // ❌ Show error message
                    messageBox.textContent = result.message || 'Something went wrong. Please try again.';
                    messageBox.className = "mb-4 text-center text-sm font-medium text-red-600";
                }
            } catch (error) {
                // ⚠️ Handle fetch/network errors
                messageBox.textContent = 'Network error. Please check your connection.';
                messageBox.className = "mb-4 text-center text-sm font-medium text-red-600";
            }
        });
    }

    /* Resend OTP Form Submit*/
    const resendOtpBtn = document.getElementById('resend-otp');
    resendOtpBtn?.addEventListener('click', async () => {
        const otpMsg = document.getElementById('otp-msg');
        const otpMobileEl = document.getElementById('otp-mobile');
        let mobile = '';

        // ✅ Extract clean 10-digit number
        if (otpMobileEl) {
            const raw = otpMobileEl.textContent.replace(/\D/g, '');
            mobile = raw.slice(-10);
        }

        otpMsg.className = "hidden text-sm text-center mb-3";
        otpMsg.textContent = "";

        // ✅ Validate mobile
        if (!/^[6-9]\d{9}$/.test(mobile)) {
            otpMsg.textContent = "Invalid or missing mobile number. Please close and try again.";
            otpMsg.className = "text-sm text-center text-red-600 mb-3";
            return;
        }

        // ✅ Disable resend temporarily to prevent multiple clicks
        resendOtpBtn.disabled = true;
        resendOtpBtn.textContent = "Resending...";

        try {
            const response = await fetch("{{ route('front.resendOtp') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ mobile })
            });

            const result = await response.json();

            if (result.status === "success") {
                otpMsg.textContent = "OTP resent successfully to " + mobile;
                otpMsg.className = "text-sm text-center text-green-600 mb-3";

                // ✅ Start resend countdown
                let seconds = 60;
                const countdown = setInterval(() => {
                    resendOtpBtn.textContent = `Resend in ${seconds}s`;
                    seconds--;
                    if (seconds < 0) {
                        clearInterval(countdown);
                        resendOtpBtn.textContent = "Resend OTP";
                        resendOtpBtn.disabled = false;
                    }
                }, 1000);
            } else {
                otpMsg.textContent = result.message || "Failed to resend OTP. Please try again.";
                otpMsg.className = "text-sm text-center text-red-600 mb-3";
                resendOtpBtn.disabled = false;
                resendOtpBtn.textContent = "Resend OTP";
            }
        } catch (error) {
            otpMsg.textContent = "Network error while resending OTP.";
            otpMsg.className = "text-sm text-center text-red-600 mb-3";
            resendOtpBtn.disabled = false;
            resendOtpBtn.textContent = "Resend OTP";
        }
    });
});
</script>
