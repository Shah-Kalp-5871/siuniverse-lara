@extends('layouts.app')

@section('title', 'Explore Stays - SIU UNIVERSE')

@section('content')
@php
    $storageUrl = Storage::url('');
@endphp

<!-- Hero Section -->
<section class="pt-8 pb-12">
    <div class="container mx-auto px-4 pb-8">
        <h1 class="text-4xl font-bold text-white text-center mb-2" data-aos="fade-up">Explore Stays</h1>
        <p class="text-gray-400 text-center mb-8" data-aos="fade-up" data-aos-delay="100">Find the best PGs & Flats near your college</p>

        <!-- Filters -->
        <div class="max-w-4xl mx-auto mb-10 bg-white/10 backdrop-blur-md p-4 rounded-xl shadow-lg border border-white/10 flex flex-col md:flex-row gap-4 items-center justify-between" data-aos="fade-up" data-aos-delay="200">
            <!-- Type Filter -->
            <div class="flex bg-black/20 rounded-lg p-1">
                <button class="filter-btn active px-6 py-2 rounded-md font-bold transition-all text-white bg-primary" data-filter="PG">PGs</button>
                <button class="filter-btn px-6 py-2 rounded-md font-bold text-blue-100 hover:text-white transition-all" data-filter="Flat">Flats</button>
            </div>

            <!-- Distance Filter -->
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <span class="text-blue-100 text-sm whitespace-nowrap"><i class="fas fa-map-marker-alt mr-1"></i> Max Distance:</span>
                <select id="distanceFilter" class="bg-black/20 text-white text-sm rounded-lg px-4 py-2 border border-white/20 focus:outline-none focus:border-primary w-full md:w-48">
                    <option class="bg-black" value="100">Any Distance</option>
                    <option class="bg-black" value="2">< 2 km</option>
                    <option class="bg-black" value="5">< 5 km</option>
                    <option class="bg-black" value="10">< 10 km</option>
                </select>
            </div>
        </div>

        <div class="grid gap-8 max-w-5xl mx-auto" id="listingsContainer">
            @foreach ($stays as $index => $stay)
                <div class="listing-card bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100" 
                     data-aos="fade-up" 
                     data-aos-delay="{{ $index * 100 }}"
                     data-type="{{ $stay->type }}"
                     data-distance="{{ $stay->distance }}">
                    
                    <div class="flex flex-col md:flex-row">
                        <!-- Left Side: Photo and Website Link -->
                        <div class="md:w-1/3 p-4 flex flex-col space-y-4 relative">
                            <div class="aspect-w-16 aspect-h-12 rounded-xl overflow-hidden bg-gray-200 relative group">
                                @php
                                    $imageUrl = $stay->image_path ? $storageUrl . $stay->image_path : 'https://placehold.co/600x400?text=No+Image';
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $stay->name }}" class="object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-2 left-2 bg-black/70 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-md font-medium">
                                    <i class="fas fa-map-marker-alt mr-1 text-red-400"></i> {{ $stay->distance }} km from college
                                </div>
                                <div class="absolute top-2 right-2 bg-primary text-white text-xs px-2 py-1 rounded-md font-bold uppercase tracking-wider">
                                    {{ $stay->type }}
                                </div>
                            </div>
                            @if ($stay->link)
                            <a href="{{ $stay->link }}" target="_blank" class="block w-full text-center bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium py-2 rounded-lg border border-gray-200 transition-colors">
                                <i class="fas fa-external-link-alt mr-2 text-sm"></i> Visit Website
                            </a>
                            @endif
                        </div>

                        <!-- Right Side: Details -->
                        <div class="md:w-2/3 p-6 md:pl-0 flex flex-col justify-center">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $stay->name }}</h2>
                            
                            <!-- Amenities Tags -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach ($stay->amenities ?? [] as $amenity)
                                    <span class="bg-blue-50 text-blue-600 text-xs px-2.5 py-1 rounded-full font-medium border border-blue-100">
                                        {{ $amenity }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 mb-6">
                                <div class="flex items-center text-gray-600">
                                    <div class="w-8 flex justify-center mr-3">
                                        <i class="fas fa-rupee-sign text-green-500 text-lg"></i>
                                    </div>
                                    <span class="font-medium">Rent:</span> &nbsp;₹{{ number_format($stay->rent) }}/month
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <div class="w-8 flex justify-center mr-3">
                                        <i class="fas fa-phone text-blue-400 text-lg"></i>
                                    </div>
                                    <span class="font-medium">Contact:</span> &nbsp;{{ $stay->broker_number }}
                                </div>
                            </div>

                            <!-- Broker Details -->
                            @if ($stay->broker_name)
                                <div class="bg-amber-50 rounded-xl p-4 border border-amber-100 mt-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Broker Name</h3>
                                            <p class="font-bold text-gray-800">{{ $stay->broker_name }}</p>
                                        </div>
                                        <!-- <a href="tel:{{ $stay->broker_number }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-amber-100">
                                            <i class="fas fa-phone-alt mr-2"></i> Contact
                                        </a> -->
                                    </div>
                                </div>
                            @endif

                            @if (!empty($stay->rules))
                                <!-- Rules for Stays -->
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 mt-4">
                                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Rules & Regulations</h3>
                                    <ul class="space-y-2">
                                        @foreach ($stay->rules as $rule)
                                            <li class="flex items-start text-gray-600 text-sm">
                                                <i class="fas fa-check-circle text-primary mt-0.5 mr-2.5"></i>
                                                <span>{{ $rule }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Book My Visit Button -->
                            <div class="mt-6">
                                <button onclick="bookVisit({{ json_encode($stay) }})" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg flex items-center justify-center group">
                                    <i class="fas fa-calendar-check mr-2 group-hover:scale-110 transition-transform"></i>
                                    Book My Visit
                                </button>
                                <p class="text-[10px] text-gray-400 text-center mt-2 italic">
                                    "Owner will contact you within 24 hours to confirm your visit."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- No Results Message -->
        <div id="noResults" class="hidden text-center py-20">
            <div class="inline-block p-4 rounded-full bg-white/10 mb-4">
                <i class="fas fa-search text-blue-200 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">No listings found</h3>
            <p class="text-blue-200">Try adjusting your filters to see more results.</p>
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

    #listingsContainer {
        margin-bottom: 0 !important;
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const distanceFilter = document.getElementById('distanceFilter');
    const listingsContainer = document.getElementById('listingsContainer');
    const listings = document.querySelectorAll('.listing-card');
    const noResults = document.getElementById('noResults');

    let currentType = 'PG';
    let maxDistance = 100;

    // Type Filter Logic
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class from all
            filterBtns.forEach(b => {
                b.classList.remove('bg-primary', 'text-white');
                b.classList.add('text-gray-300');
            });
            // Add active class to clicked
            btn.classList.add('bg-primary', 'text-white');
            btn.classList.remove('text-gray-300');

            currentType = btn.dataset.filter;
            filterListings();
        });
    });

    // Distance Filter Logic
    if(distanceFilter) {
        distanceFilter.addEventListener('change', (e) => {
            maxDistance = parseFloat(e.target.value);
            filterListings();
        });
    }

    // Run initial filter
    filterListings();

    function filterListings() {
        let visibleCount = 0;

        listings.forEach(card => {
            const type = card.dataset.type; // 'PG' or 'Flat'
            const distance = parseFloat(card.dataset.distance);

            const matchesType = currentType === 'all' || type === currentType;
            const matchesDistance = distance <= maxDistance;

            if (matchesType && matchesDistance) {
                card.style.display = 'block';
                card.style.opacity = '1';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }

    window.bookVisit = async function(stay) {
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
