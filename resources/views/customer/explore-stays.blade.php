@extends('layouts.app')

@section('title', 'Explore Stays - SIU UNIVERSE')

@section('content')
@php
    $storageUrl = Storage::url('');
@endphp

<!-- Hero Search Section -->
<section class="relative bg-gradient-to-br from-accent/10 to-primary/10 py-12 z-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
            <h1 class="text-4xl font-bold text-gray-800 mb-4 tracking-tight uppercase">Explore Stays</h1>
            <p class="text-gray-600 mb-8 font-medium">Find Your Perfect Stay Around Campus.</p>
            
            <!-- Advanced Filters -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 text-left max-w-4xl mx-auto relative z-[60]">
                <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                    <!-- Outside Filter: Property Type -->
                    <div class="flex bg-gray-50 rounded-lg p-1 border border-gray-100 w-full md:w-auto overflow-hidden">
                        <button class="type-btn flex-1 md:flex-none px-6 py-2 rounded-md text-sm font-bold transition-all text-gray-500 hover:text-primary" data-type="PG">PG</button>
                        <button class="type-btn flex-1 md:flex-none px-6 py-2 rounded-md text-sm font-bold transition-all text-gray-500 hover:text-primary" data-type="Flat">Flat</button>
                    </div>

                    <!-- Luxury Curated Button -->
                    <button id="luxuryBtn" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-2 rounded-lg font-bold text-sm transition-all bg-gray-50 text-gray-500 border border-gray-100 hover:text-amber-500 hover:bg-amber-50" data-filter="luxury">
                        <i class="fas fa-crown text-amber-500"></i>
                        <span>Luxury Curated</span>
                    </button>

                    <!-- Consolidated Filter Button -->
                    <div class="relative w-full md:w-auto z-[70]">
                        <button id="filterToggleBtn" class="w-full md:w-auto flex items-center justify-center gap-2 px-6 py-2 rounded-lg font-bold text-sm transition-all bg-primary/10 text-primary border border-primary/20 hover:bg-primary/20">
                            <i class="fas fa-filter text-sm"></i>
                            <span>Filters</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-300" id="filterChevron"></i>
                        </button>

                        <!-- Consolidated Filter Panel -->
                        <div id="filterPanel" class="hidden absolute top-full left-0 right-0 md:left-auto md:right-0 mt-4 w-full md:w-[350px] bg-white p-6 rounded-2xl border border-gray-100 shadow-2xl z-[100] space-y-6">
                            
                            <!-- Area Filter -->
                            <div class="space-y-2">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1">Select Area</span>
                                <div class="relative">
                                    <select id="areaFilter" class="w-full appearance-none bg-gray-50 text-gray-800 text-sm font-medium rounded-lg px-4 py-3 pr-10 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all cursor-pointer">
                                        <option value="">All Areas</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area }}">{{ $area }}</option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                            </div>

                            <!-- Gender Filter -->
                            <div class="space-y-2">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1">Gender</span>
                                <div class="flex bg-gray-50 rounded-lg p-1 border border-gray-100 w-full overflow-hidden">
                                    <button class="gender-btn flex-1 px-3 py-2 rounded-md text-sm font-bold transition-all text-gray-500 hover:text-primary" data-gender="Boys">Boys</button>
                                    <button class="gender-btn flex-1 px-3 py-2 rounded-md text-sm font-bold transition-all text-gray-500 hover:text-primary" data-gender="Girls">Girls</button>
                                    <button class="gender-btn flex-1 px-3 py-2 rounded-md text-sm font-bold transition-all text-gray-500 hover:text-primary" data-gender="Co-living">Co-living</button>
                                </div>
                            </div>

                            <!-- Max Budget Slider -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center px-1">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Max Budget</span>
                                    <span id="priceDisplay" class="text-primary text-sm font-bold">Any Budget</span>
                                </div>
                                <div class="px-1 pb-2">
                                    <input type="range" id="priceSlider" min="0" max="50000" step="500" value="50000" 
                                        class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary hover:bg-gray-300 transition-colors">
                                    <div class="flex justify-between mt-2 text-xs text-gray-400 font-medium tracking-wider">
                                        <span>₹0</span>
                                        <span>₹50,000+</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Max Distance Slider -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center px-1">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Max Distance</span>
                                    <span id="distanceDisplay" class="text-primary text-sm font-bold">Any Distance</span>
                                </div>
                                <div class="px-1 pb-2">
                                    <input type="range" id="distanceSlider" min="1" max="15" step="1" value="15" 
                                        class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary hover:bg-gray-300 transition-colors">
                                    <div class="flex justify-between mt-2 text-xs text-gray-400 font-medium tracking-wider">
                                        <span>1 km</span>
                                        <span>15 km</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Apply Filter Button -->
                            <button id="applyFiltersBtn" class="w-full py-4 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                                Apply Filters
                            </button>

                            <!-- Clear All Filters -->
                            <button id="clearFiltersBtn" class="w-full py-2 text-xs font-bold text-gray-400 hover:text-red-500 transition-colors">
                                Clear All Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stays Listing Section -->
<section class="py-12 bg-gray-50 min-h-[400px]">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto" id="staysListing">
            @include("customer.partials.stay-listings", ["stays" => $stays])
        </div>
    </div>
</section>

@push("styles")
<style>
    .loading-overlay {
        position: relative;
    }
    .loading-overlay::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.6);
        backdrop-filter: blur(2px);
        z-index: 10;
        border-radius: 1rem;
    }

    /* Range Slider Styling */
    input[type="range"]::-webkit-slider-runnable-track {
        background: #e5e7eb;
        border-radius: 9999px;
        height: 6px;
    }
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        margin-top: -5px;
        background-color: #3b82f6;
        border-radius: 9999px;
        height: 16px;
        width: 16px;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
        border: 2px solid white;
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterToggleBtn = document.getElementById('filterToggleBtn');
    const filterPanel = document.getElementById('filterPanel');
    const filterChevron = document.getElementById('filterChevron');
    const luxuryBtn = document.getElementById('luxuryBtn');
    const areaFilter = document.getElementById('areaFilter');
    const genderBtns = document.querySelectorAll('.gender-btn');
    const typeBtns = document.querySelectorAll('.type-btn');
    const priceSlider = document.getElementById('priceSlider');
    const priceDisplay = document.getElementById('priceDisplay');
    const distanceSlider = document.getElementById('distanceSlider');
    const distanceDisplay = document.getElementById('distanceDisplay');
    const staysListing = document.getElementById('staysListing');
    const applyFiltersBtn = document.getElementById('applyFiltersBtn');
    const clearFiltersBtn = document.getElementById('clearFiltersBtn');

    let debounceTimer;

    // Toggle Filter Panel
    filterToggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        filterPanel.classList.toggle('hidden');
        filterChevron.classList.toggle('rotate-180');
    });

    // Close panel on outside click
    document.addEventListener('click', (e) => {
        if (!filterPanel.contains(e.target) && !filterToggleBtn.contains(e.target)) {
            filterPanel.classList.add('hidden');
            filterChevron.classList.remove('rotate-180');
        }
    });

    function getActiveFilters() {
        const params = {};
        
        // Luxury
        if (luxuryBtn && luxuryBtn.classList.contains('active')) {
            params.luxury = 1;
        }

        // Area
        if (areaFilter.value) {
            params.area = areaFilter.value;
        }

        // Gender (Multiple supported by UI toggles)
        const selectedGenders = Array.from(genderBtns)
            .filter(btn => btn.classList.contains('active'))
            .map(btn => btn.dataset.gender);
        if (selectedGenders.length > 0) {
            params.gender = selectedGenders.join(',');
        }

        // Type (Multiple supported by UI toggles)
        const selectedTypes = Array.from(typeBtns)
            .filter(btn => btn.classList.contains('active'))
            .map(btn => btn.dataset.type);
        if (selectedTypes.length > 0) {
            params.type = selectedTypes.join(',');
        }

        // Max Rent (Only if slider is not at max)
        if (parseInt(priceSlider.value) < 50000) {
            params.max_rent = priceSlider.value;
        }

        // Distance
        if (parseInt(distanceSlider.value) < 15) {
            params.max_distance = distanceSlider.value;
        }

        return params;
    }

    function updateListing() {
        staysListing.classList.add('loading-overlay');
        
        const params = getActiveFilters();
        const url = new URL(window.location.href);
        
        // Clear all filter params first
        ['luxury', 'area', 'gender', 'type', 'max_rent', 'max_distance'].forEach(p => url.searchParams.delete(p));
        
        // Add active params
        Object.keys(params).forEach(key => url.searchParams.set(key, params[key]));
        
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            staysListing.innerHTML = html;
            staysListing.classList.remove('loading-overlay');
            if (window.AOS) window.AOS.refresh();
        })
        .catch(err => {
            console.error('Filter error:', err);
            staysListing.classList.remove('loading-overlay');
        });
    }

    // Type Filter (Mutually Exclusive)
    typeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const isActive = btn.classList.contains('active');
            
            // Deactivate all first
            typeBtns.forEach(b => b.classList.remove('active', 'text-primary', 'bg-primary/10'));
            
            // If it wasn't active, activate it now
            if (!isActive) {
                btn.classList.add('active', 'text-primary', 'bg-primary/10');
            }
            
            // Keeping top-level type buttons instant as they are outside the panel
            updateListing();
        });
    });

    // Luxury Filter (Additive)
    if (luxuryBtn) {
        luxuryBtn.addEventListener('click', () => {
            luxuryBtn.classList.toggle('active');
            if (luxuryBtn.classList.contains('active')) {
                luxuryBtn.classList.add('bg-amber-500', 'text-white', 'shadow-xl', 'shadow-amber-500/20');
                luxuryBtn.classList.remove('bg-gray-50', 'text-gray-500');
            } else {
                luxuryBtn.classList.remove('bg-amber-500', 'text-white', 'shadow-xl', 'shadow-amber-500/20');
                luxuryBtn.classList.add('bg-gray-50', 'text-gray-500');
            }
            updateListing();
        });
    }

    // Apply Filters Button
    applyFiltersBtn.addEventListener('click', () => {
        updateListing();
        filterPanel.classList.add('hidden');
        filterChevron.classList.remove('rotate-180');
    });

    // Area Filter
    // areaFilter.addEventListener('change', updateListing);

    // Gender Filter (Multi-select)
    genderBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            btn.classList.toggle('active');
            btn.classList.toggle('text-primary');
            btn.classList.toggle('bg-primary/10');
            // updateListing();
        });
    });

    // Price Slider
    priceSlider.addEventListener('input', () => {
        const val = parseInt(priceSlider.value);
        if (val >= 50000) {
            priceDisplay.textContent = 'Any Budget';
        } else {
            priceDisplay.textContent = `Under ₹${val.toLocaleString()}`;
        }
        
        // clearTimeout(debounceTimer);
        // debounceTimer = setTimeout(updateListing, 500);
    });

    // Distance Slider
    distanceSlider.addEventListener('input', () => {
        const val = parseInt(distanceSlider.value);
        if (val >= 15) {
            distanceDisplay.textContent = 'Any Distance';
        } else {
            distanceDisplay.textContent = `Under ${val} km`;
        }
    });

    // Clear All
    clearFiltersBtn.addEventListener('click', () => {
        // Reset all buttons
        typeBtns.forEach(btn => btn.classList.remove('active', 'text-primary', 'bg-primary/10'));
        genderBtns.forEach(btn => btn.classList.remove('active', 'text-primary', 'bg-primary/10'));
        
        if (luxuryBtn) {
            luxuryBtn.classList.remove('active', 'bg-amber-500', 'text-white', 'shadow-xl', 'shadow-amber-500/20');
            luxuryBtn.classList.add('bg-gray-50', 'text-gray-500');
        }
        
        areaFilter.value = "";
        distanceSlider.value = 15;
        distanceDisplay.textContent = 'Any Distance';
        
        priceSlider.value = 50000;
        priceDisplay.textContent = 'Any Budget';
        
        updateListing();
        filterPanel.classList.add('hidden');
        filterChevron.classList.remove('rotate-180');
    });

    // Modal / Visit logic (keeping it global as before)
    window.bookVisit = async function(stay) {
        // Disclaimer Popup
        const disclaimerResult = await Swal.fire({
            title: '<h2 class="text-xl font-bold text-slate-900 uppercase tracking-tighter">Terms of Use & Disclaimer</h2>',
            html: `
                <div class="text-left py-4 px-2 space-y-6">
                    <!-- Core Disclaimers Grid -->
                    <div class="grid gap-4">
                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/30 flex gap-4">
                            <div class="text-slate-400 mt-1"><i class="fas fa-search-dollar"></i></div>
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-900 uppercase tracking-wider mb-1">Data Accuracy</h4>
                                <p class="text-[11px] leading-relaxed text-slate-500 font-medium">We do not guarantee the accuracy of rent, deposit, amenities, or availability for any PG or Flat listed.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/30 flex gap-4">
                            <div class="text-slate-400 mt-1"><i class="fas fa-user-shield"></i></div>
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-900 uppercase tracking-wider mb-1">Agreement Privacy</h4>
                                <p class="text-[11px] leading-relaxed text-slate-500 font-medium">SIU Universe is NOT a party to any legal agreement or financial transaction between you and the property owner.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/30 flex gap-4">
                            <div class="text-slate-400 mt-1"><i class="fas fa-exclamation-triangle"></i></div>
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-900 uppercase tracking-wider mb-1">Liability Notice</h4>
                                <p class="text-[11px] leading-relaxed text-slate-500 font-medium">We are not responsible for any disputes, fraud, loss of deposits, or issues arising from your property selection.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Warning -->
                    <div class="bg-amber-50 p-4 rounded-xl border border-amber-100 flex items-start gap-4">
                        <i class="fas fa-info-circle text-amber-500 mt-0.5"></i>
                        <p class="text-[11px] font-bold text-amber-900 leading-tight">
                            MANDATORY: Please verify all details, documents, and property conditions in person before making any payments.
                        </p>
                    </div>
                </div>
            `,
            confirmButtonText: 'I ACCEPT ALL TERMS',
            confirmButtonColor: '#3b82f6',
            showCancelButton: true,
            cancelButtonText: 'CANCEL',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-[1.5rem] border border-slate-100',
                confirmButton: 'px-10 py-4 rounded-xl font-bold text-[10px] uppercase tracking-widest shadow-2xl',
                cancelButton: 'px-10 py-4 rounded-xl font-bold text-[10px] uppercase tracking-widest text-slate-400'
            }
        });

        if (!disclaimerResult.isConfirmed) return;

        const { value: formValues } = await Swal.fire({
            title: 'Schedule a Visit',
            html: `
                <div class="text-left space-y-4">
                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 mb-4">
                        <p class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-1">Property</p>
                        <p class="text-sm font-bold text-slate-800">${stay.name}</p>
                        <div class="mt-2">
                            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-0.5">Visiting Schedule</p>
                            <p class="text-xs text-slate-600">${stay.visiting_schedule || 'We will contact you for schedule'}</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Your Name</label>
                        <input id="swal-user-name" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="Enter your full name">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Contact Number</label>
                        <input id="swal-user-contact" type="text" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^[^6789]+/, '').slice(0, 10)" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="10-digit mobile number">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Preferred Date</label>
                            <input id="swal-visit-date" type="date" min="${new Date().toISOString().split('T')[0]}" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Preferred Time</label>
                            <input id="swal-visit-time" type="time" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none">
                        </div>
                    </div>
                    
                    <div class="bg-amber-50 p-3 rounded-lg border border-amber-100 mt-4">
                        <p class="text-xs text-amber-800 text-center font-medium">
                            <i class="fas fa-info-circle mr-1"></i> We'll confirm your visit within 12 hours.
                        </p>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Confirm Visit Request',
            confirmButtonColor: '#1e293b',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                const name = document.getElementById('swal-user-name').value;
                const contact = document.getElementById('swal-user-contact').value;
                const date = document.getElementById('swal-visit-date').value;
                const time = document.getElementById('swal-visit-time').value;

                if (!name || !contact || !date || !time) {
                    Swal.showValidationMessage('Please fill in all fields');
                    return false;
                }

                if (!/^[6789]\d{9}$/.test(contact)) {
                    Swal.showValidationMessage('Contact number must be 10 digits and start with 6, 7, 8, or 9');
                    return false;
                }

                return {
                    stay_id: stay.id,
                    user_name: name,
                    user_contact_number: contact,
                    visit_date: date,
                    visit_time: time,
                    visiting_schedule: stay.visiting_schedule || 'Not specified'
                };
            }
        });

        if (formValues) {
            try {
                Swal.fire({
                    title: 'Submitting...',
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    allowOutsideClick: false
                });

                const response = await fetch("{{ route('inquiries.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formValues)
                });

                let result;
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    result = await response.json();
                } else {
                    const errorText = await response.text();
                    console.error("Non-JSON response received:", errorText);
                    throw new Error("Server returned an invalid response. Please check the logs.");
                }

                if (result.success) {
                    Swal.fire({
                        title: 'Request Sent!',
                        text: result.message,
                        icon: 'success',
                        confirmButtonColor: '#1e293b'
                    });
                } else {
                    let errorMessage = result.message || 'Failed to submit request';
                    if (result.error) {
                        errorMessage += "\n\nDetails: " + result.error;
                    }
                    if (result.errors) {
                        // Validation errors
                        errorMessage += "\n" + Object.values(result.errors).flat().join("\n");
                    }
                    Swal.fire('Error', errorMessage, 'error');
                }
            } catch (error) {
                console.error("Inquiry submission error:", error);
                Swal.fire('Error', error.message || 'An unexpected error occurred', 'error');
            }
        }
    }
});
</script>
@endpush
@endsection
