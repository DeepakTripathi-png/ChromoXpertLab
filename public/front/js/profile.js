function toggleSubmenu(id, button) {
    const submenu = document.getElementById(id);
    const chevron = button.querySelector('i.fa-chevron-down');
    submenu.classList.toggle('hidden');
    chevron.classList.toggle('rotate-180');
}

// Active link highlighting
const currentPage = window.location.pathname.split("/").pop();
document.querySelectorAll('.menu-item, .submenu-item').forEach(link => {
    if (link.getAttribute('href') === currentPage) {
        link.classList.add('bg-blue-50', 'text-blue-600', 'font-semibold');
    }
});
/* Start Smooth Behaviour of SPA Link from this Pages */
    document.querySelectorAll('a[href*="#"]').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const href = link.getAttribute('href');
            const hash = href.split('#')[1];
            // store the section name before redirect
            localStorage.setItem('scrollToSection', hash);
            window.location.href = '/';
        });
    });
/* End Smooth Behaviour of SPA Link from this Pages */

// ===== Manage Modal Functions =====
function openAddressModal() {
    document.getElementById('addressModal').classList.remove('hidden');
}

function closeAddressModal() {
    document.getElementById('addressModal').classList.add('hidden');
}

function deleteAddress(button) {
    if (confirm('Are you sure you want to delete this address?')) {
        button.closest('.bg-gray-50').remove();
    }
}