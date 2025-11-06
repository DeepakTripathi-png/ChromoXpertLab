// Delete item on click
   document.addEventListener('DOMContentLoaded', () => {

    // ✅ Handle Remove Item Buttons
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', async function() {
            const cartItem = this.closest('.cart-item');   // div of the item
            const cartId = cartItem.dataset.id;            // get cart item ID

            if (!cartId) return;

            try {
                const res = await fetch(`/cart/remove/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();

                if (data.success) {
                    cartItem.remove(); // remove from DOM

                    // ✅ Update cart count
                    if (window.updateCartCount) {
                        window.updateCartCount(data.cartCount);
                    }

                    // ✅ Update payment summary
                    updatePaymentSummary();

                } else {
                    alert(data.message || 'Failed to remove item.');
                }
            } catch (error) {
                console.error('Error removing item:', error);
                alert('Network error. Please try again.');
            }
        });
    });

    // Call this on page load
    updatePaymentSummary();
});

function updatePaymentSummary() {
    const items = document.querySelectorAll('.cart-item');
    let mrp = 0;

    items.forEach(item => {
        mrp += parseFloat(item.dataset.price) || 0;
    });

    const discount = 0; // change if needed
    const delivery = 50;
    const sample = 50;
    const total = mrp - discount + delivery + sample;

    document.getElementById('summary-mrp').textContent = `₹${mrp.toFixed(2)}`;
    document.getElementById('summary-discount').textContent = `- ₹${discount.toFixed(2)}`;
    document.getElementById('summary-delivery').textContent = `₹${delivery.toFixed(2)}`;
    document.getElementById('summary-sample').textContent = `₹${sample.toFixed(2)}`;
    document.getElementById('summary-total').textContent = `₹${total.toFixed(2)}`;
}

// Address Modal Logic
    const addAddressModal = document.getElementById('addAddressModal');
    const addAddressBtn = document.getElementById('addAddressBtn');
    const cancelAddAddress = document.getElementById('cancelAddAddress');

    // Open modal
    addAddressBtn.addEventListener('click', (e) => {
      e.preventDefault();
      addAddressModal.classList.remove('hidden');
    });

    // Close modal
    cancelAddAddress.addEventListener('click', () => {
      addAddressModal.classList.add('hidden');
    });

    // Close when clicking outside
    addAddressModal.addEventListener('click', (e) => {
      if (e.target === addAddressModal) {
        addAddressModal.classList.add('hidden');
      }
    });

    const changeAddressModal = document.getElementById('changeAddressModal');
    const cancelChangeAddress = document.getElementById('cancelChangeAddress');
    const saveChangeAddress = document.getElementById('saveChangeAddress');
    const changeAddressBtn = document.getElementById('changeAddressBtn');

    // Open modal on “Change Address” click
    if (changeAddressBtn) {
        changeAddressBtn.addEventListener('click', (e) => {
            e.preventDefault();
            changeAddressModal.classList.remove('hidden');
        });
    }

    // Close on Cancel or Save
    [cancelChangeAddress, saveChangeAddress].forEach(btn => {
        if (btn) {
            btn.addEventListener('click', () => {
            changeAddressModal.classList.add('hidden');
            });
        }
    });

    // Close when clicking outside
    if (changeAddressModal) {
        changeAddressModal.addEventListener('click', (e) => {
            if (e.target === changeAddressModal) {
            changeAddressModal.classList.add('hidden');
            }
        });
    }
    const addPetModal = document.getElementById('addPetModal');
    const addNewPetBtn = document.getElementById('addNewPetBtn');
    const cancelAddPet = document.getElementById('cancelAddPet');
    const addPetForm = document.getElementById('addPetForm');

    // Open modal when clicking Add New
    addNewPetBtn.addEventListener('click', (e) => {
        e.preventDefault();
        addPetModal.classList.remove('hidden');
    });

    // Close modal on Cancel
    cancelAddPet.addEventListener('click', () => {
        addPetModal.classList.add('hidden');
    });

    // Close modal when clicking outside
    addPetModal.addEventListener('click', (e) => {
        if (e.target === addPetModal) addPetModal.classList.add('hidden');
    });

    // Handle form submission (can connect to PHP later)
    addPetForm.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Pet added successfully!');
        addPetModal.classList.add('hidden');
        addPetForm.reset();
    });
    document.addEventListener("DOMContentLoaded", () => {
      const selectPetModal = document.getElementById('selectPetModal');
      const changePetBtn = document.getElementById('changePetBtn');
      const cancelSelectPet = document.getElementById('cancelSelectPet');
      const selectPetForm = document.getElementById('selectPetForm');

      // ✅ Open Modal
      changePetBtn.addEventListener('click', (e) => {
        e.preventDefault();
        selectPetModal.classList.remove('hidden');
      });

      // ✅ Close Modal on cancel or outside click
      cancelSelectPet.addEventListener('click', () => {
        selectPetModal.classList.add('hidden');
      });

      selectPetModal.addEventListener('click', (e) => {
        if (e.target === selectPetModal) selectPetModal.classList.add('hidden');
      });

      // ✅ Handle form submit
      selectPetForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const selectedPet = document.querySelector('input[name="petSelect"]:checked').value;
        alert(`Selected Pet: ${selectedPet}`);
        selectPetModal.classList.add('hidden');
      });
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