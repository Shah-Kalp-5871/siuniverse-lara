@extends('layouts.app')

@section('title', 'Discover Peers & Communities - SIU UNIVERSE')

@section('content')
<!-- Hero Search Section -->
<section class="relative bg-gradient-to-br from-primary/10 to-secondary/10 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Discover Peers & Communities</h1>
            <p class="text-gray-600 mb-8">Find students from your institute or explore campus-wide groups.</p>
            
            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow-xl p-10 mb-8 text-left">
                <div class="mb-10 pt-0 border-t border-gray-50 flex items-center">
                    <div class="relative flex-1 w-full">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="searchInput" placeholder="Search by name..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border-none rounded-lg text-sm focus:ring-2 ring-primary/20 outline-none">
                    </div>
                    <div class="ml-4 flex bg-gray-100 p-1 rounded-lg">
                        <button onclick="switchTab('peers')" id="tabPeers" class="px-4 py-1.5 rounded-md text-sm font-bold transition-all bg-white shadow-sm text-primary">Peers</button>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Institute</label>
                        <select id="filterInst" class="w-full bg-gray-50 border border-gray-100 rounded-lg p-2 text-sm focus:ring-2 ring-primary/20 outline-none">
                            <option value="">All Institutes</option>
                            <option @if($institute == 'SIT') selected @endif>SAII</option>
                            <option @if($institute == 'SCHS') selected @endif>SIMC</option>
                            <option @if($institute == 'SSVAP') selected @endif>SIBM</option>
                            <option @if($institute == 'SSVAP') selected @endif>SIDTM</option>
                            <option @if($institute == 'SSVAP') selected @endif>SIT</option>
                            <option @if($institute == 'SSVAP') selected @endif>SSBF</option>
                            <option @if($institute == 'SSVAP') selected @endif>SSVAP</option>
                            <option @if($institute == 'SSVAP') selected @endif>SSCANS</option>
                            <option @if($institute == 'SSVAP') selected @endif>SCON</option>
                            <option @if($institute == 'SSVAP') selected @endif>SCHS</option>
                            <option @if($institute == 'SSVAP') selected @endif>SSSS</option>
                            <option @if($institute == 'SSVAP') selected @endif>SIHS</option>
                            <option @if($institute == 'SSVAP') selected @endif>SMCW</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Course</label>
                        <select id="filterCourse" class="w-full bg-gray-50 border border-gray-100 rounded-lg p-2 text-sm focus:ring-2 ring-primary/20 outline-none">
                            <option value="">All Courses</option>
                            <option @if($course == 'B.Tech') selected @endif>B.Tech</option>
                            <option @if($course == 'BBA') selected @endif>BBA</option>
                            <option @if($course == 'BCA') selected @endif>BCA</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Year</label>
                        <select id="filterYear" class="w-full bg-gray-50 border border-gray-100 rounded-lg p-2 text-sm focus:ring-2 ring-primary/20 outline-none">
                            <option value="">All Years</option>
                            <option>1st Year</option>
                            <option>2nd Year</option>
                            <option>3rd Year</option>
                            <option>4th Year</option>
                            <option>5th Year</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Accommodation</label>
                        <select id="filterAcc" class="w-full bg-gray-50 border border-gray-100 rounded-lg p-2 text-sm focus:ring-2 ring-primary/20 outline-none">
                            <option value="">All Types</option>
                            <option>Hostel</option>
                            <option>PG / Flat</option>
                            <option>Day Scholar</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div id="access-notice" class="bg-blue-50 border border-blue-100 p-3 rounded-xl inline-flex items-center text-xs text-blue-700">
                <i class="fas fa-shield-alt mr-2"></i> Showing all students for <strong>Discovery</strong>. (Filters: {{ $institute }} - {{ $course }})
            </div>
        </div>
    </div>
</section>

<!-- Discovery Results -->
<section class="py-12 bg-gray-50 min-h-[400px]">
    <div class="container mx-auto px-4">
        
        <!-- Peers Grid -->
        <div id="peersSection" class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($students as $s)
            <div class="peer-card bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-all border border-gray-50 text-center" 
                 data-name="{{ strtolower($s->name) }}" 
                 data-year="{{ $s->current_study_year }}{{ 
                    $s->current_study_year == 1 ? 'st' : ($s->current_study_year == 2 ? 'nd' : ($s->current_study_year == 3 ? 'rd' : 'th')) 
                 }} Year" 
                 data-acc="{{ $s->accommodation }}"
                 data-inst="{{ $s->institute }}"
                 data-course="{{ $s->course }}">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($s->name) }}&background=random" class="w-16 h-16 rounded-2xl mx-auto mb-3 border-2 border-gray-50">
                <h3 class="font-bold text-gray-800 text-sm mb-1">{{ $s->name }}</h3>
                <p class="text-[11px] text-gray-500 mb-4">{{ $s->current_study_year }}{{ 
                    $s->current_study_year == 1 ? 'st' : ($s->current_study_year == 2 ? 'nd' : ($s->current_study_year == 3 ? 'rd' : 'th')) 
                 }} Year • {{ $s->accommodation }}</p>
                <div class="flex justify-center space-x-2">
                    <button class="p-1.5 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-white transition-all text-xs">
                        <i class="fas fa-comment"></i>
                    </button>
                    <button class="p-1.5 bg-gray-50 text-gray-400 rounded-lg hover:bg-gray-100 transition-all text-xs">
                        <i class="fas fa-user-plus"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Groups Grid (Initially Hidden) -->
        <div id="groupsSection" class="hidden grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Community Cards -->
            <div class="group-card bg-white rounded-2xl p-6 shadow-sm border border-blue-100" data-name="saii hostel">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-bold">Hostel</span>
                    <i class="fab fa-whatsapp text-2xl text-green-500"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-1">SAII Hostel Main</h3>
                <p class="text-sm text-gray-500 mb-4">Official group for all residents.</p>
                <button class="w-full bg-gray-50 hover:bg-gray-100 text-gray-700 py-2 rounded-xl text-sm font-bold transition-all">Request Join</button>
            </div>
            
            <div class="group-card bg-white rounded-2xl p-6 shadow-sm border border-purple-100" data-name="international students">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-xs font-bold">Global</span>
                    <i class="fab fa-whatsapp text-2xl text-green-500"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-1">International Communities</h3>
                <p class="text-sm text-gray-500 mb-4">Global student support network.</p>
                <button class="w-full bg-gray-50 hover:bg-gray-100 text-gray-700 py-2 rounded-xl text-sm font-bold transition-all">Request Join</button>
            </div>
        </div>

        <!-- No Results -->
        <div id="noResults" class="hidden text-center py-20">
            <i class="fas fa-search-minus text-4xl text-gray-200 mb-4"></i>
            <h3 class="text-gray-400 font-medium">No results found for your filters</h3>
        </div>

    </div>
</section>

<!-- Search Tips -->
<section class="py-12 bg-white border-t border-gray-200">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-accent mr-2"></i>
                    Search Tips
                </h3>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>Search by community name (e.g., "Hostel", "PG", "Day Scholar")</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>No filter system — search is name-based only</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>All communities are predefined — no auto-creation</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                        <span>Each community has only one WhatsApp group</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function switchTab(tab) {
        const peers = document.getElementById('peersSection');
        const groups = document.getElementById('groupsSection');
        const tabP = document.getElementById('tabPeers');
        const tabG = document.getElementById('tabGroups');
        const notice = document.getElementById('access-notice');

        if (tab === 'peers') {
            peers.classList.remove('hidden');
            groups.classList.add('hidden');
            tabP.className = 'px-4 py-1.5 rounded-md text-sm font-bold transition-all bg-white shadow-sm text-primary';
            if(tabG) tabG.className = 'px-4 py-1.5 rounded-md text-sm font-bold transition-all text-gray-500';
            notice.classList.remove('opacity-0');
        } else {
            peers.classList.add('hidden');
            groups.classList.remove('hidden');
            if(tabG) tabG.className = 'px-4 py-1.5 rounded-md text-sm font-bold transition-all bg-white shadow-sm text-primary';
            tabP.className = 'px-4 py-1.5 rounded-md text-sm font-bold transition-all text-gray-500';
            notice.classList.add('opacity-0');
        }
        filterResults();
    }

    function filterResults() {
        const searchInput = document.getElementById('searchInput');
        if(!searchInput) return;
        const search = searchInput.value.toLowerCase();
        const year = document.getElementById('filterYear').value;
        const acc = document.getElementById('filterAcc').value;
        const inst = document.getElementById('filterInst').value;
        const course = document.getElementById('filterCourse').value;
        const isPeers = !document.getElementById('peersSection').classList.contains('hidden');
        
        let visibleCount = 0;
        const items = isPeers ? document.querySelectorAll('.peer-card') : document.querySelectorAll('.group-card');
        
        items.forEach(item => {
            const itemName = item.getAttribute('data-name');
            const itemYear = item.getAttribute('data-year') || '';
            const itemAcc = item.getAttribute('data-acc') || '';
            const itemInst = item.getAttribute('data-inst') || '';
            const itemCourse = item.getAttribute('data-course') || '';
            
            const matchSearch = itemName.includes(search);
            const matchYear = !year || itemYear === year;
            const matchAcc = !acc || itemAcc === acc;
            const matchInst = !inst || itemInst === inst;
            const matchCourse = !course || itemCourse === course;
            
            if (matchSearch && matchYear && matchAcc && matchInst && matchCourse) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        document.getElementById('noResults').classList.toggle('hidden', visibleCount > 0);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterYear = document.getElementById('filterYear');
        const filterAcc = document.getElementById('filterAcc');
        const filterInst = document.getElementById('filterInst');
        const filterCourse = document.getElementById('filterCourse');

        if(searchInput) searchInput.addEventListener('input', filterResults);
        if(filterYear) filterYear.addEventListener('change', filterResults);
        if(filterAcc) filterAcc.addEventListener('change', filterResults);
        if(filterInst) filterInst.addEventListener('change', filterResults);
        if(filterCourse) filterCourse.addEventListener('change', filterResults);

        // Animate search box on load
        if(searchInput) {
            anime({
                targets: '#searchInput',
                translateY: [20, 0],
                opacity: [0, 1],
                duration: 800,
                easing: 'easeOutCubic'
            });
        }
    });

    // Search on Enter key
    document.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            filterResults();
        }
    });
</script>
@endpush
