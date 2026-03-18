@php
    $storageUrl = Storage::url('');
@endphp

@forelse ($stays as $index => $stay)
    <div class="listing-card bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden border border-slate-100 group mb-8" 
         data-aos="fade-up" 
         data-aos-delay="{{ ($index % 5) * 100 }}"
         data-type="{{ $stay->type }}"
         data-distance="{{ $stay->distance }}">
        
        <div class="flex flex-col lg:flex-row">
            <!-- Image Section -->
            <div class="lg:w-2/5 p-5 flex flex-col relative">
                <div class="aspect-w-16 aspect-h-12 rounded-2xl overflow-hidden bg-slate-100 relative shadow-inner">
                    @php
                        $imageUrl = $stay->image_path ? $storageUrl . $stay->image_path : 'https://placehold.co/800x600?text=No+Image';
                    @endphp
                    <img src="{{ $imageUrl }}" alt="{{ $stay->name }}" class="object-cover w-full h-full transform group-hover:scale-110 transition-transform duration-700">
                    
                    <!-- Floating Badges -->
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        <span class="bg-black/60 backdrop-blur-md text-white text-[10px] px-3 py-1.5 rounded-full font-bold uppercase tracking-wider flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-rose-400"></i> {{ $stay->distance }} km
                        </span>
                        <!-- <span class="bg-blue-600/90 backdrop-blur-md text-white text-[10px] px-3 py-1.5 rounded-full font-bold uppercase tracking-wider">
                            {{ $stay->type }}
                        </span> -->
                    </div>

                    @if($stay->is_luxury)
                    <div class="absolute top-4 right-4 bg-amber-400 text-slate-900 text-[10px] px-4 py-1.5 rounded-full font-bold uppercase tracking-widest flex items-center shadow-2xl animate-pulse">
                        <i class="fas fa-crown mr-2"></i> Luxury Curated
                    </div>
                    @endif
                </div>
            </div>

            <!-- Content Section -->
            <div class="lg:w-3/5 p-6 lg:pl-2 flex flex-col">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-4">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-900 mb-1 tracking-tight leading-tight">{{ $stay->name }}</h2>
                        <div class="flex items-center text-slate-400 text-xs font-bold uppercase tracking-widest">
                            <i class="fas fa-map-pin mr-2 text-rose-500"></i>
                            {{ $stay->area ?: 'Pune North' }}
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-end">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Security Deposit</div>
                        <div class="text-2xl font-bold text-emerald-600">{{ is_numeric($stay->deposit) ? '₹' . number_format($stay->deposit) : $stay->deposit }}</div>
                    </div>
                </div>
                
                <!-- Amenities -->
                <div class="flex flex-wrap gap-1.5 mb-6">
                    @foreach (array_slice($stay->amenities ?? [], 0, 5) as $amenity)
                        <span class="bg-slate-50 text-slate-500 text-[10px] px-3 py-1 rounded-md font-bold uppercase border border-slate-100">
                            {{ $amenity }}
                        </span>
                    @endforeach
                    @if(count($stay->amenities ?? []) > 5)
                        <span class="text-slate-300 text-[10px] font-bold self-center">+{{ count($stay->amenities) - 5 }} More</span>
                    @endif
                </div>

                <!-- Structured Pricing Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Room Tariffs -->
                    <div class="bg-slate-50/50 rounded-2xl border border-slate-100 overflow-hidden">
                        <div class="bg-slate-100/50 px-4 py-2 border-b border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Monthly Rent</span>
                            <div class="flex items-center gap-2">
                                <!-- <span class="text-[8px] font-bold uppercase px-2 py-0.5 rounded-full {{ ($stay->food_inclusion ?? 'Excluded') === 'Included' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                    Meals {{ $stay->food_inclusion ?? 'Excluded' }}
                                </span> -->
                                <i class="fas fa-bed text-slate-400 text-[10px]"></i>
                            </div>
                        </div>
                        <div class="p-4 space-y-3">
                            @if($stay->single_sharing_rent)
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-slate-500">Single Sharing</span>
                                <span class="text-sm font-bold text-slate-800">₹{{ number_format($stay->single_sharing_rent) }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between items-center">
                                <div class="flex flex-col">
                                    <!-- <span class="text-[9px] font-bold text-blue-600 uppercase tracking-wider">Most Popular</span> -->
                                    <span class="text-xs font-bold text-slate-500">Double Sharing</span>
                                </div>
                                <span class="text-sm font-bold text-black-700">₹{{ number_format($stay->double_sharing_rent) }}</span>
                            </div>

                            @if($stay->triple_sharing_rent)
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-slate-500">Triple Sharing</span>
                                <span class="text-sm font-bold text-slate-800">₹{{ number_format($stay->triple_sharing_rent) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Food Service -->
                    <div class="bg-slate-50/50 rounded-2xl border border-slate-100 overflow-hidden">
                        <div class="bg-slate-100/50 px-4 py-2 border-b border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Meal Services</span>
                            <i class="fas fa-utensils text-slate-400 text-[10px]"></i>

                            <span class="text-[8px] font-bold uppercase px-2 py-0.5 rounded-full {{ ($stay->food_inclusion ?? 'Excluded') === 'Included' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                    Meals {{ $stay->food_inclusion ?? 'Excluded' }}
                                </span>
                        </div>
                        <div class="p-4 h-full flex flex-col justify-center">
                            @if($stay->food_type !== 'None')
                                <div class="flex flex-col items-center text-center">
                                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-1">{{ $stay->food_type }}</span>
                                    @php
                                        $min = min($stay->weekday_meals_price, $stay->weekend_meals_price);
                                        $max = max($stay->weekday_meals_price, $stay->weekend_meals_price);
                                        $formatPrice = function($price) {
                                            if ($price >= 1000 && $price % 1000 === 0) return ($price / 1000) . 'k';
                                            return number_format($price);
                                        };
                                    @endphp
                                    <div class="text-xl font-bold text-slate-800 mb-1">
                                        @if($min == $max)
                                            ₹{{ $formatPrice($min) }} <small class="text-[10px] text-slate-400">/mo</small>
                                        @else
                                            ₹{{ $formatPrice($min) }}-{{ $formatPrice($max) }} <small class="text-[10px] text-slate-400">/mo</small>
                                        @endif
                                    </div>
                                    <p class="text-[9px] text-slate-400 font-bold leading-tight uppercase italic">
                                        Includes Weekday (2 Meals) <br>& Weekend (3 Meals)
                                    </p>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-4 opacity-50">
                                    <i class="fas fa-ban text-slate-300 mb-2"></i>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">No Food Service</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="mt-auto">
                    <button onclick="bookVisit({{ json_encode($stay) }})" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 shadow-xl shadow-primary/20 flex items-center justify-center group active:scale-95 uppercase tracking-widest text-[10px]">
                        <i class="fas fa-calendar-alt mr-3 group-hover:rotate-12 transition-transform"></i>
                        Confirm My Visit Request
                    </button>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-20 bg-slate-50/50 rounded-3xl border-2 border-dashed border-slate-100">
        <div class="inline-block p-6 rounded-3xl bg-white shadow-sm mb-6">
            <i class="fas fa-search text-slate-300 text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-slate-800 mb-3 tracking-tight">NO STAYS MATCH YOUR FILTERS</h3>
        <p class="text-slate-400 font-medium max-w-sm mx-auto">Flats Coming soon or resetting filters to find our hand-picked curated PGs.</p>
        <button onclick="window.location.reload()" class="mt-8 text-blue-600 font-bold text-xs uppercase tracking-widest hover:text-blue-800 transition-colors">
            <i class="fas fa-undo mr-2"></i> Reset Search
        </button>
    </div>
@endforelse
