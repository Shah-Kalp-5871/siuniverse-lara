@extends('layouts.app')

@section('title', 'Explore Stays - SIU UNIVERSE')

@section('content')
@php
    $storageUrl = Storage::url('');
@endphp

<!-- Hero Section -->
<section class="pt-4 pb-6 relative z-[50]">
    <div class="container mx-auto px-4">
        <div class="text-center mb-6" data-aos="fade-up">
            <h1 class="text-3xl md:text-5xl font-black text-white mb-1 tracking-tighter uppercase">Explore Stays</h1>
            <div class="flex items-center justify-center gap-4">
                <span class="h-[1px] w-12 bg-white/20"></span>
                <p class="text-slate-400 font-bold uppercase tracking-[0.3em] text-[8px]">Curated Premium Living</p>
                <span class="h-[1px] w-12 bg-white/20"></span>
            </div>
        </div>

        <!-- Advanced Filters -->
        <div class="max-w-6xl mx-auto mb-8 px-4 md:px-0 relative z-[60]" data-aos="fade-up" data-aos-delay="200">
            <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                <!-- Outside Filter: Property Type -->
                <div class="flex bg-white/5 rounded-[2rem] p-1 border border-white/10 w-full md:w-auto overflow-hidden">
                    <button class="type-btn flex-1 md:flex-none px-6 py-3 rounded-[1.8rem] text-[10px] font-black uppercase tracking-widest transition-all text-white/40 hover:text-white" data-type="PG">PG</button>
                    <button class="type-btn flex-1 md:flex-none px-6 py-3 rounded-[1.8rem] text-[10px] font-black uppercase tracking-widest transition-all text-white/40 hover:text-white" data-type="Flat">Flat</button>
                </div>

                <!-- Consolidated Filter Button -->
                <div class="relative w-full md:w-auto z-[70]">
                    <button id="filterToggleBtn" class="w-full md:w-auto flex items-center justify-center gap-3 px-10 py-4 rounded-[2rem] font-black uppercase tracking-widest text-[10px] transition-all bg-white/5 text-white border border-white/10 hover:bg-white/10">
                        <i class="fas fa-filter text-sm text-amber-500"></i>
                        <span>Filters</span>
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-300" id="filterChevron"></i>
                    </button>

                    <!-- Consolidated Filter Panel -->
                    <div id="filterPanel" class="hidden absolute top-full left-0 right-0 md:left-auto md:right-0 mt-4 w-full md:w-[350px] bg-slate-900/95 backdrop-blur-3xl p-6 rounded-[2.5rem] border border-white/10 shadow-2xl z-[100] space-y-6">
                        
                        <!-- Luxury Curated -->
                        <div>
                            <button id="luxuryBtn" class="w-full flex items-center justify-center gap-3 px-8 py-4 rounded-[1.5rem] font-black uppercase tracking-widest text-[10px] transition-all bg-white/5 text-white/40 hover:bg-white/10" data-filter="luxury">
                                <i class="fas fa-crown text-sm"></i>
                                <span>Luxury Curated</span>
                            </button>
                        </div>

                        <!-- Area Filter -->
                        <div class="space-y-2">
                            <span class="text-white/40 text-[9px] font-black uppercase tracking-widest px-4">Select Area</span>
                            <div class="relative">
                                <select id="areaFilter" class="w-full appearance-none bg-white/5 text-white text-[10px] font-black uppercase tracking-widest rounded-[1.5rem] px-6 py-4 pr-12 border border-white/10 focus:outline-none focus:border-amber-400 transition-all cursor-pointer hover:bg-white/10">
                                    <option value="" class="bg-slate-900">All Areas</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area }}" class="bg-slate-900">{{ $area }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-white/20 pointer-events-none text-xs"></i>
                            </div>
                        </div>

                        <!-- Gender Filter -->
                        <div class="space-y-2">
                            <span class="text-white/40 text-[9px] font-black uppercase tracking-widest px-4">Gender</span>
                            <div class="flex bg-white/5 rounded-[1.5rem] p-1 border border-white/10 w-full overflow-hidden">
                                <button class="gender-btn flex-1 px-4 py-3 rounded-[1.2rem] text-[9px] font-black uppercase tracking-widest transition-all text-white/40 hover:text-white" data-gender="Boys">Boys</button>
                                <button class="gender-btn flex-1 px-4 py-3 rounded-[1.2rem] text-[9px] font-black uppercase tracking-widest transition-all text-white/40 hover:text-white" data-gender="Girls">Girls</button>
                                <button class="gender-btn flex-1 px-4 py-3 rounded-[1.2rem] text-[9px] font-black uppercase tracking-widest transition-all text-white/40 hover:text-white" data-gender="Co-living">Co-living</button>
                            </div>
                        </div>

                        <!-- Max Budget Dropdown -->
                        <div class="space-y-2">
                            <span class="text-white/40 text-[9px] font-black uppercase tracking-widest px-4">Max Budget</span>
                            <div class="relative">
                                <select id="priceDropdown" class="w-full appearance-none bg-white/5 text-white text-[10px] font-black uppercase tracking-widest rounded-[1.5rem] px-6 py-4 pr-12 border border-white/10 focus:outline-none focus:border-amber-400 transition-all cursor-pointer hover:bg-white/10">
                                    <option value="" class="bg-slate-900">Any Budget</option>
                                    <option value="5000" class="bg-slate-900">Under ₹5,000</option>
                                    <option value="10000" class="bg-slate-900">Under ₹10,000</option>
                                    <option value="15000" class="bg-slate-900">Under ₹15,000</option>
                                    <option value="20000" class="bg-slate-900">Under ₹20,000</option>
                                    <option value="30000" class="bg-slate-900">Under ₹30,000</option>
                                    <option value="50000" class="bg-slate-900">Under ₹50,000</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-white/20 pointer-events-none text-xs"></i>
                            </div>
                        </div>

                        <!-- Distance Filter -->
                        <div class="space-y-3 px-4 py-2 bg-white/5 rounded-[1.5rem] border border-white/10">
                            <div class="flex justify-between items-center">
                                <span class="text-white/40 text-[9px] font-black uppercase tracking-widest">Max Distance</span>
                                <span id="distanceValue" class="text-amber-400 font-extrabold text-xs tracking-tighter">15 km</span>
                            </div>
                            <input type="range" id="distanceFilter" min="0" max="15" step="0.5" value="15" class="w-full h-1 bg-white/10 rounded-lg appearance-none cursor-pointer accent-amber-500">
                            <div class="flex justify-between text-[8px] text-white/20 font-bold uppercase">
                                <span>0 km</span>
                                <span>15 km</span>
                            </div>
                        </div>

                        <!-- Clear All Filters -->
                        <button id="clearFiltersBtn" class="w-full py-3 text-[9px] font-black uppercase tracking-widest text-amber-500/60 hover:text-amber-500 transition-colors">
                            Clear All Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-12 max-w-6xl mx-auto" id="staysListing">
            @include('customer.partials.stay-listings', ['stays' => $stays])
        </div>
    </div>
</section>

@push('styles')
<style>
    html, body {
        background: #000000 !important;
        margin: 0 !important;
        padding: 0 !important;
        min-height: 100vh !important;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1 0 auto;
        padding-top: 64px !important;
        padding-bottom: 0 !important;
        margin-bottom: 0 !important;
        background: transparent !important;
    }

    section {
        margin-bottom: 0 !important;
        padding-bottom: 2rem !important;
    }

    footer {
        flex-shrink: 0;
        margin-top: 0 !important;
        border-top: 1px solid rgba(255,255,255,0.05);
        background-color: rgba(0,0,0,0.3) !important;
    }

    nav {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
    }

    .filter-main-btn.active {
        background: #f59e0b !important;
        color: white !important;
    }

    .gender-btn.active {
        background: rgba(255,255,255,0.1);
        color: #f59e0b !important;
    }

    .loading-overlay {
        position: relative;
    }

    .loading-overlay::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.3);
        backdrop-filter: blur(2px);
        z-index: 10;
        border-radius: 1rem;
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
    const priceDropdown = document.getElementById('priceDropdown');
    const distanceFilter = document.getElementById('distanceFilter');
    const distanceValue = document.getElementById('distanceValue');
    const staysListing = document.getElementById('staysListing');
    const clearFiltersBtn = document.getElementById('clearFiltersBtn');

    let priceTimeout;
    let distanceTimeout;

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

    function updateListing(params) {
        staysListing.classList.add('loading-overlay');
        
        const url = new URL(window.location.href);
        // Clear existing relevant search params
        ['luxury', 'area', 'gender', 'type', 'max_rent', 'max_distance'].forEach(p => url.searchParams.delete(p));
        
        // Add new params
        Object.keys(params).forEach(key => url.searchParams.set(key, params[key]));
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
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

    function resetConsolidatedFilters(except) {
        if (except !== 'luxury') {
            luxuryBtn.classList.remove('active', 'bg-amber-500', 'text-slate-900', 'shadow-xl', 'shadow-amber-500/20');
            luxuryBtn.classList.add('bg-white/5', 'text-white/40');
        }
        if (except !== 'area') areaFilter.value = "";
        if (except !== 'gender') genderBtns.forEach(btn => btn.classList.remove('active', 'text-amber-400', 'bg-white/10'));
        if (except !== 'price') priceDropdown.value = "";
        if (except !== 'distance') {
            distanceFilter.value = 15;
            distanceValue.textContent = '15 km';
        }
    }

    // Type Filter (Outside) - Requirement says only 1 filter should apply overall
    typeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.classList.contains('active')) {
                btn.classList.remove('active', 'text-amber-400', 'bg-white/10');
                updateListing({});
            } else {
                typeBtns.forEach(b => b.classList.remove('active', 'text-amber-400', 'bg-white/10'));
                resetConsolidatedFilters();
                btn.classList.add('active', 'text-amber-400', 'bg-white/10');
                updateListing({ type: btn.dataset.type });
            }
        });
    });

    // Consolidated Filters
    luxuryBtn.addEventListener('click', () => {
        if (luxuryBtn.classList.contains('active')) {
            resetConsolidatedFilters();
            updateListing({});
        } else {
            resetConsolidatedFilters('luxury');
            typeBtns.forEach(b => b.classList.remove('active', 'text-amber-400', 'bg-white/10'));
            luxuryBtn.classList.add('active', 'bg-amber-500', 'text-slate-900', 'shadow-xl', 'shadow-amber-500/20');
            luxuryBtn.classList.remove('bg-white/5', 'text-white/40');
            updateListing({ luxury: 1 });
        }
    });

    areaFilter.addEventListener('change', () => {
        if (areaFilter.value) {
            resetConsolidatedFilters('area');
            typeBtns.forEach(b => b.classList.remove('active', 'text-amber-400', 'bg-white/10'));
            updateListing({ area: areaFilter.value });
        } else {
            updateListing({});
        }
    });

    genderBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.classList.contains('active')) {
                resetConsolidatedFilters();
                updateListing({});
            } else {
                resetConsolidatedFilters('gender');
                typeBtns.forEach(b => b.classList.remove('active', 'text-amber-400', 'bg-white/10'));
                btn.classList.add('active', 'text-amber-400', 'bg-white/10');
                updateListing({ gender: btn.dataset.gender });
            }
        });
    });

    priceDropdown.addEventListener('change', () => {
        if (priceDropdown.value) {
            resetConsolidatedFilters('price');
            typeBtns.forEach(b => b.classList.remove('active', 'text-amber-400', 'bg-white/10'));
            updateListing({ max_rent: priceDropdown.value });
        } else {
            updateListing({});
        }
    });

    distanceFilter.addEventListener('input', () => {
        const val = parseFloat(distanceFilter.value);
        distanceValue.textContent = val + ' km';
        
        clearTimeout(distanceTimeout);
        distanceTimeout = setTimeout(() => {
            resetConsolidatedFilters('distance');
            typeBtns.forEach(b => b.classList.remove('active', 'text-amber-400', 'bg-white/10'));
            updateListing({ max_distance: val });
        }, 400);
    });

    clearFiltersBtn.addEventListener('click', () => {
        resetConsolidatedFilters();
        typeBtns.forEach(b => b.classList.remove('active', 'text-amber-400', 'bg-white/10'));
        updateListing({});
        filterPanel.classList.add('hidden');
        filterChevron.classList.remove('rotate-180');
    });

    // Modal / Visit logic (keeping it global as before)
    window.bookVisit = async function(stay) {
        // Disclaimer Popup
        const disclaimerResult = await Swal.fire({
            title: '<h2 class="text-xl font-black text-slate-900 uppercase tracking-tighter">Terms of Use & Disclaimer</h2>',
            html: `
                <div class="text-left py-4 px-2 space-y-6">
                    <!-- Policy Highlight -->
                    <div class="bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-hand-holding-heart text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest leading-none mb-1">SIU UNIVERSE POLICY</p>
                            <p class="text-sm font-bold text-slate-700">We charge <strong>ZERO fees</strong> or commission from students.</p>
                        </div>
                    </div>

                    <!-- Core Disclaimers Grid -->
                    <div class="grid gap-4">
                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/30 flex gap-4">
                            <div class="text-slate-400 mt-1"><i class="fas fa-search-dollar"></i></div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-900 uppercase tracking-wider mb-1">Data Accuracy</h4>
                                <p class="text-[11px] leading-relaxed text-slate-500 font-medium">We do not guarantee the accuracy of rent, deposit, amenities, or availability for any PG or Flat listed.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/30 flex gap-4">
                            <div class="text-slate-400 mt-1"><i class="fas fa-user-shield"></i></div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-900 uppercase tracking-wider mb-1">Agreement Privacy</h4>
                                <p class="text-[11px] leading-relaxed text-slate-500 font-medium">SIU Universe is NOT a party to any legal agreement or financial transaction between you and the property owner.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/30 flex gap-4">
                            <div class="text-slate-400 mt-1"><i class="fas fa-exclamation-triangle"></i></div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-900 uppercase tracking-wider mb-1">Liability Notice</h4>
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
            confirmButtonColor: '#0f172a',
            showCancelButton: true,
            cancelButtonText: 'CANCEL',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-[1.5rem] border border-slate-100',
                confirmButton: 'px-10 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-2xl',
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
                            <p class="text-xs text-slate-600">${stay.visiting_schedule || 'Contact owner for schedule'}</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Your Name</label>
                        <input id="swal-user-name" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="Enter your full name">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Contact Number</label>
                        <input id="swal-user-contact" type="text" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="10-digit mobile number">
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
                            <i class="fas fa-info-circle mr-1"></i> Owner will contact you within 24 hours to confirm your visit.
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

                if (!/^\d{10}$/.test(contact)) {
                    Swal.showValidationMessage('Please enter a valid 10-digit contact number');
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
