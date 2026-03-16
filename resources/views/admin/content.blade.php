@extends('layouts.admin')

@section('title', 'Stays Management - SIU Admin')

@push('styles')
<style>
    .tabulator {
        border: none !important;
    }
    .tabulator-header .tabulator-col {
        border-right: 1px solid #e2e8f0 !important;
        background-color: #f8fafc !important;
    }
    .tabulator-header .tabulator-col:last-child {
        border-right: none !important;
    }
    .tabulator-row .tabulator-cell {
        border-right: 1px solid #e2e8f0 !important;
        padding: 12px 16px !important;
    }
    .tabulator-row .tabulator-cell:last-child {
        border-right: none !important;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 space-y-4 md:space-y-0">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Explore Stays Control</h1>
        <p class="text-slate-500 text-sm">Manage PG and Flat listings.</p>
    </div>
    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
        <!-- Search -->
        <div class="relative flex-1 md:flex-none min-w-[200px]">
            <input type="text" placeholder="Search stays..." class="pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-800 transition-all w-full shadow-sm">
            <i class="fas fa-search absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
        </div>

        <!-- Food Filter -->
        <div class="relative flex-1 md:flex-none">
            <select id="food-filter" onchange="filterByFood(this.value)" class="appearance-none pl-10 pr-8 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-800 transition-all w-full md:w-44 shadow-sm cursor-pointer font-medium text-slate-700">
                <option value="">All Meals</option>
                <option value="Included">Included</option>
                <option value="Excluded">Excluded</option>
            </select>
            <i class="fas fa-utensils absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
            <i class="fas fa-chevron-down absolute right-3.5 top-4 text-slate-300 text-[10px]"></i>
        </div>

        <!-- Sort -->
        <div class="relative flex-1 md:flex-none">
            <select id="sort-control" class="appearance-none pl-10 pr-8 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-800 transition-all w-full md:w-40 shadow-sm cursor-pointer font-medium text-slate-700">
                <option value="default">Sort: Default</option>
                <option value="asc">Name: A-Z</option>
                <option value="desc">Name: Z-A</option>
            </select>
            <i class="fas fa-sort-alpha-down absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
            <i class="fas fa-chevron-down absolute right-3.5 top-4 text-slate-300 text-[10px]"></i>
        </div>

        <!-- Column Visibility -->
        <div class="relative flex-1 md:flex-none group">
            <button id="col-toggle-btn" class="flex items-center justify-between pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-800 transition-all w-full md:w-40 shadow-sm font-medium text-slate-700">
                <span>Columns</span>
                <i class="fas fa-columns absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                <i class="fas fa-chevron-down text-slate-300 text-[10px] ml-2"></i>
            </button>
            <div id="col-dropdown" class="absolute right-0 top-full mt-2 w-48 bg-white rounded-2xl border border-slate-100 shadow-xl opacity-0 invisible group-focus-within:opacity-100 group-focus-within:visible transition-all z-[60] p-3 space-y-2">
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="name" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Property Info</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="type" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Type</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="sharing_prices" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Sharing Prices</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="deposit" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Deposit</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="distance" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Distance</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="food_inclusion" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Meal Inclusion</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="actions" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Actions</span>
                </label>
            </div>
        </div>

        <button onclick="addStay()" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-900 transition-all shadow-lg shadow-slate-500/20 flex items-center justify-center flex-1 md:flex-none">
            <i class="fas fa-plus mr-2"></i> Add Stay
        </button>
    </div>
</header>


<!-- Content Table -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div id="stays-table"></div>
</div>
@endsection

@push('scripts')
<script>
    // Server-side amenities and rules
    let currentAmenities = @json($amenities);
    let currentRules = @json($rules);

    document.addEventListener('DOMContentLoaded', function() {
        const tableData = @json($stays);
        const storageUrl = "{{ Storage::url('') }}";
        
        const table = new Tabulator("#stays-table", {
            data: tableData,
            layout: "fitColumns",
            responsiveLayout: "collapse",
            pagination: "local",
            paginationSize: 10,
            paginationSizeSelector: [10, 25, 50, 100],
            movableColumns: true,
            placeholder: "No stays listed yet.",
            columns: [
                {
                    title: "Stay Name / Title", 
                    field: "name", 
                    formatter: function(cell) {
                        const data = cell.getData();
                        const imageUrl = data.image_path ? `${storageUrl}${data.image_path}` : null;
                        return `
                            <div class="flex items-center space-x-3 py-1">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center overflow-hidden shrink-0">
                                    ${imageUrl ? `<img src="${imageUrl}" class="w-full h-full object-cover">` : '<i class="fas fa-home text-lg"></i>'}
                                </div>
                                <span class="text-sm font-bold text-slate-800 truncate">${data.name}</span>
                            </div>
                        `;
                    },
                    widthGrow: 2
                },
                {
                    title: "Type", 
                    field: "type",
                    formatter: function(cell) {
                        return `<span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200 uppercase">${cell.getValue()}</span>`;
                    },
                    width: 100
                },
                {
                    title: "Status", 
                    field: "is_luxury",
                    formatter: function(cell) {
                        if (cell.getValue()) {
                            return `<span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-100 uppercase flex items-center gap-1"><i class="fas fa-crown text-[8px]"></i> Luxury</span>`;
                        }
                        return `<span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2.5 py-1 rounded-md border border-slate-100 uppercase">Standard</span>`;
                    },
                    width: 100
                },
                {
                    title: "Area", 
                    field: "area",
                    formatter: function(cell) {
                        return `<span class="text-xs text-slate-600 font-medium">${cell.getValue() || "N/A"}</span>`;
                    },
                    width: 120
                },
                {
                    title: "Gender", 
                    field: "gender",
                    formatter: function(cell) {
                        const val = cell.getValue();
                        let color = "slate";
                        if(val === 'Boys') color = "blue";
                        if(val === 'Girls') color = "purple";
                        if(val === 'Co-living') color = "green";
                        return `<span class="text-[10px] font-bold text-${color}-600 bg-${color}-50 px-2.5 py-1 rounded-md border border-${color}-200 uppercase">${val || "Co-living"}</span>`;
                    },
                    width: 100
                },
                {
                    title: "Sharing Prices", 
                    field: "sharing_prices",
                    headerSort: false,
                    formatter: function(cell) {
                        const data = cell.getData();
                        return `
                            <div class="py-1 space-y-1">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase">Single</span>
                                    <span class="text-[10px] font-bold text-slate-700">₹${data.single_sharing_rent || '—'}</span>
                                </div>
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase">Double</span>
                                    <span class="text-[10px] font-bold text-slate-700">₹${data.double_sharing_rent || '—'}</span>
                                </div>
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-[9px] text-slate-400 font-bold uppercase">Triple</span>
                                    <span class="text-[10px] font-bold text-slate-700">₹${data.triple_sharing_rent || '—'}</span>
                                </div>
                                ${data.food_type !== 'None' ? `
                                <div class="pt-1 mt-1 border-t border-slate-100">
                                    <p class="text-[9px] font-bold text-blue-500 uppercase">${data.food_type}</p>
                                    <div class="flex justify-between text-[8px] text-slate-500 font-bold">
                                        <span>WD: ₹${data.weekday_meals_price || 0}</span>
                                        <span>WE: ₹${data.weekend_meals_price || 0}</span>
                                    </div>
                                </div>
                                ` : ''}
                            </div>
                        `;
                    },
                    width: 150
                },
                {
                    title: "Meals", 
                    field: "food_inclusion",
                    formatter: function(cell) {
                        const val = cell.getValue() || 'Excluded';
                        const colorClass = val === 'Included' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-slate-50 text-slate-500 border-slate-100';
                        return `<span class="text-[10px] font-bold ${colorClass} px-2.5 py-1 rounded-md border uppercase">${val}</span>`;
                    },
                    width: 100
                },
                {
                    title: "Deposit", 
                    field: "deposit",
                    formatter: function(cell) {
                        const val = cell.getValue();
                        const displayVal = isNaN(val) ? val : new Intl.NumberFormat().format(val);
                        return `
                            <div class="flex items-center text-xs text-slate-600 font-semibold px-2">
                                <i class="fas fa-wallet mr-1.5 text-[10px] text-slate-400"></i>
                                ${displayVal}
                            </div>
                        `;
                    },
                    width: 120
                },
                {
                    title: "Distance", 
                    field: "distance",
                    formatter: function(cell) {
                        return `<p class="text-xs text-slate-500 font-medium px-2"><i class="fas fa-map-marker-alt mr-1.5 text-slate-300"></i>${cell.getValue()} Km</p>`;
                    },
                    width: 120
                },
                {
                    title: "Actions", 
                    field: "actions",
                    headerSort: false,
                    formatter: function(cell) {
                        const data = cell.getData();
                        return `
                            <div class="flex items-center space-x-2 py-1">
                                <button onclick='editStay(${JSON.stringify(data)})' title="Edit" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button onclick="deleteStay(${data.id}, '${data.name}')" title="Delete" class="w-8 h-8 rounded-lg bg-slate-50 text-red-500 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        `;
                    },
                    width: 120
                }
            ],
            rowFormatter: function(row) {
                row.getElement().classList.add("hover:bg-slate-50/50", "transition-all", "border-b", "border-slate-50");
            }
        });

        // Sorting functionality
        document.getElementById('sort-control').addEventListener('change', function(e) {
            if (e.target.value === 'default') {
                table.clearSort();
            } else {
                table.setSort("name", e.target.value);
            }
        });

        // Column Visibility functionality
        document.querySelectorAll('.col-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function(e) {
                const columnField = e.target.dataset.column;
                if (e.target.checked) {
                    table.showColumn(columnField);
                } else {
                    table.hideColumn(columnField);
                }
            });
        });

        // Search functionality
        document.querySelector('input[placeholder="Search stays..."]').addEventListener("input", function(e) {
            table.setFilter("name", "like", e.target.value);
        });
    });

    function filterByFood(value) {
        if (!value) {
            table.clearFilter();
        } else {
            table.setFilter("food_inclusion", "=", value);
        }
    }

    async function addStay() {
        const { value: formValues } = await Swal.fire({
            title: 'Register New Accommodation',
            width: '600px',
            html: `
                <div class="text-left space-y-4 max-h-[70vh] overflow-y-auto px-1">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Stay Name</label>
                            <input id="swal-name" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="e.g. Malti Kunj">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Type</label>
                            <select id="swal-type" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="PG">PG</option>
                                <option value="Flat">Flat</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Security Deposit</label>
                            <input id="swal-deposit" type="text" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="e.g. 1.5 Months or 8500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Distance (Km)</label>
                            <input id="swal-distance" type="number" step="0.1" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="e.g. 1.2">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Single Sharing Rent (Optional)</label>
                            <input id="swal-single-rent" type="number" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="₹">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Double Sharing Rent (Required)</label>
                            <input id="swal-double-rent" type="number" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="₹">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Triple Sharing Rent (Optional)</label>
                            <input id="swal-triple-rent" type="number" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="₹">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Visiting Schedule</label>
                            <input id="swal-visiting-schedule" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="e.g. Mon–Sat 8am–8pm">
                        </div>
                    </div>

                    <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100/50 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-blue-700 mb-2">Food / Tiffin Service</label>
                            <select id="swal-food-type" onchange="toggleFoodPrices()" class="w-full px-4 py-2 rounded-lg border border-blue-200 focus:outline-none bg-white">
                                <option value="None">None</option>
                                <option value="Food Service">Food Service (Provided by PG)</option>
                                <option value="Tiffin Service">Tiffin Service (Arranged by PG)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-blue-700 mb-2">Meal Inclusion</label>
                            <select id="swal-food-inclusion" class="w-full px-4 py-2 rounded-lg border border-blue-200 focus:outline-none bg-white">
                                <option value="Excluded">Excluded from Rent</option>
                                <option value="Included">Included in Rent</option>
                            </select>
                        </div>
                        <div id="food-prices-container" class="grid grid-cols-2 gap-4 hidden">
                            <div>
                                <label class="block text-[10px] font-bold text-blue-600 uppercase mb-1">Weekday (2 Meals) Monthly Price</label>
                                <input id="swal-weekday-price" type="number" class="w-full px-4 py-2 rounded-lg border border-blue-200 focus:outline-none" placeholder="Monthly ₹">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-blue-600 uppercase mb-1">Weekend (3 Meals) Monthly Price</label>
                                <input id="swal-weekend-price" type="number" class="w-full px-4 py-2 rounded-lg border border-blue-200 focus:outline-none" placeholder="Monthly ₹">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Area / Location</label>
                            <input id="swal-area" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="e.g. Baner">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Gender Type</label>
                            <select id="swal-gender" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="Co-living">Co-living</option>
                                <option value="Boys">Boys Only</option>
                                <option value="Girls">Girls Only</option>
                            </select>
                        </div>
                    </div>
                    <div class="bg-amber-50 p-4 rounded-xl border border-amber-100 flex items-center justify-between">
                        <div>
                            <label class="block text-xs font-bold text-amber-700">Luxury Curated</label>
                            <p class="text-[10px] text-amber-600">Show in the "Luxury" section on Explore Stays</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <input id="swal-is-luxury" type="checkbox" class="w-5 h-5 rounded border-amber-300 text-amber-600 focus:ring-amber-500">
                            <div class="w-20">
                                <label class="block text-[8px] font-bold text-amber-600 uppercase">Order</label>
                                <input id="swal-luxury-order" type="number" class="w-full px-2 py-1 text-xs rounded border border-amber-200 focus:outline-none" placeholder="1">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-slate-500">Amenities</label>
                            <button type="button" onclick="manageOptions('amenities')" class="text-[10px] text-blue-600 hover:text-blue-800 font-bold flex items-center">
                                <i class="fas fa-cog mr-1"></i> Manage
                            </button>
                        </div>
                        <div id="add-amenities-container" class="grid grid-cols-4 gap-2">
                            ${currentAmenities.map(opt => `
                                <label class="flex items-center text-[10px] text-slate-600">
                                    <input type="checkbox" name="amenities" value="${opt}" class="mr-1"> ${opt}
                                </label>
                            `).join('')}
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-slate-500">Rules & Regulations</label>
                            <button type="button" onclick="manageOptions('rules')" class="text-[10px] text-blue-600 hover:text-blue-800 font-bold flex items-center">
                                <i class="fas fa-cog mr-1"></i> Manage
                            </button>
                        </div>
                        <div id="add-rules-container" class="grid grid-cols-3 gap-2">
                            ${currentRules.map(opt => `
                                <label class="flex items-center text-[10px] text-slate-600">
                                    <input type="checkbox" name="rules" value="${opt}" class="mr-1"> ${opt}
                                </label>
                            `).join('')}
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Cover Image (Max 10MB)</label>
                        <input id="swal-image" type="file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#1e293b',
            confirmButtonText: 'List Property',
            preConfirm: () => {
                const name = document.getElementById('swal-name').value;
                const deposit = document.getElementById('swal-deposit').value;
                const distance = document.getElementById('swal-distance').value;
                const singleSharing = document.getElementById('swal-single-rent').value;
                const doubleSharing = document.getElementById('swal-double-rent').value;
                const tripleSharing = document.getElementById('swal-triple-rent').value;
                const foodType = document.getElementById('swal-food-type').value;
                const weekdayPrice = document.getElementById('swal-weekday-price').value;
                const weekendPrice = document.getElementById('swal-weekend-price').value;
                const isLuxury = document.getElementById('swal-is-luxury').checked;
                const luxuryOrder = document.getElementById('swal-luxury-order').value;
                const area = document.getElementById('swal-area').value;
                const gender = document.getElementById('swal-gender').value;

                // Validation
                if (!name || !deposit || !doubleSharing) {
                    Swal.showValidationMessage('Name, Deposit and Double Sharing Rent are required');
                    return false;
                }

                const formData = new FormData();
                formData.append('name', name);
                formData.append('type', document.getElementById('swal-type').value);
                formData.append('deposit', deposit);
                formData.append('distance', distance);
                formData.append('single_sharing_rent', singleSharing);
                formData.append('double_sharing_rent', doubleSharing);
                formData.append('triple_sharing_rent', tripleSharing);
                formData.append('food_type', foodType);
                formData.append('food_inclusion', document.getElementById('swal-food-inclusion').value);
                formData.append('weekday_meals_price', weekdayPrice);
                formData.append('weekend_meals_price', weekendPrice);
                formData.append('visiting_schedule', document.getElementById('swal-visiting-schedule').value);
                formData.append('area', area);
                formData.append('gender', gender);
                if (isLuxury) {
                    formData.append('is_luxury', '1');
                    formData.append('luxury_order', luxuryOrder);
                }                
                
                const modal = Swal.getHtmlContainer();
                const amenities = Array.from(modal.querySelectorAll('input[name="amenities"]:checked')).map(el => el.value);
                const rules = Array.from(modal.querySelectorAll('input[name="rules"]:checked')).map(el => el.value);
                
                amenities.forEach(a => formData.append('amenities[]', a));
                rules.forEach(r => formData.append('rules[]', r));

                const imageFile = document.getElementById('swal-image').files[0];
                if (imageFile) {
                    if (imageFile.size > 10 * 1024 * 1024) {
                        Swal.showValidationMessage('Image exceeds 10MB');
                        return false;
                    }
                    formData.append('image', imageFile);
                }

                return formData;
            }
        });

        if (formValues) {
            try {
                const response = await fetch("{{ route('admin.stays.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formValues
                });

                const result = await response.json();
                if (result.success) {
                    Swal.fire('Listed!', result.message, 'success').then(() => window.location.reload());
                } else {
                    let errorMessage = result.message || 'Failed to list property';
                    if (result.errors) {
                        errorMessage += '<br><ul class="text-left text-xs mt-2 list-disc list-inside">';
                        Object.values(result.errors).flat().forEach(err => {
                            errorMessage += `<li>${err}</li>`;
                        });
                        errorMessage += '</ul>';
                    }
                    Swal.fire({
                        title: 'Error',
                        html: errorMessage,
                        icon: 'error'
                    });
                }
            } catch (error) {
                Swal.fire('Error', 'An unexpected error occurred', 'error');
            }
        }
    }

    async function editStay(stay) {
        const { value: formValues } = await Swal.fire({
            title: 'Edit Property Details',
            width: '600px',
            html: `
                <div class="text-left space-y-4 max-h-[70vh] overflow-y-auto px-1">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Stay Name</label>
                            <input id="swal-edit-name" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.name}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Type</label>
                            <select id="swal-edit-type" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="PG" ${stay.type === 'PG' ? 'selected' : ''}>PG</option>
                                <option value="Flat" ${stay.type === 'Flat' ? 'selected' : ''}>Flat</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Security Deposit</label>
                            <input id="swal-edit-deposit" type="text" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.deposit}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Distance (Km)</label>
                            <input id="swal-edit-distance" type="number" step="0.1" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.distance}">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Single Sharing Rent (Optional)</label>
                            <input id="swal-edit-single-rent" type="number" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.single_sharing_rent || ''}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Double Sharing Rent (Required)</label>
                            <input id="swal-edit-double-rent" type="number" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.double_sharing_rent}">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Triple Sharing Rent (Optional)</label>
                            <input id="swal-edit-triple-rent" type="number" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.triple_sharing_rent || ''}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Visiting Schedule</label>
                            <input id="swal-edit-visiting-schedule" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.visiting_schedule || ''}" placeholder="e.g. Mon–Sat 8am–8pm">
                        </div>
                    </div>

                    <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100/50 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-blue-700 mb-2">Food / Tiffin Service</label>
                            <select id="swal-edit-food-type" onchange="toggleFoodPrices('edit')" class="w-full px-4 py-2 rounded-lg border border-blue-200 focus:outline-none bg-white">
                                <option value="None" ${stay.food_type === 'None' ? 'selected' : ''}>None</option>
                                <option value="Food Service" ${stay.food_type === 'Food Service' ? 'selected' : ''}>Food Service (Provided by PG)</option>
                                <option value="Tiffin Service" ${stay.food_type === 'Tiffin Service' ? 'selected' : ''}>Tiffin Service (Arranged by PG)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-blue-700 mb-2">Meal Inclusion</label>
                            <select id="swal-edit-food-inclusion" class="w-full px-4 py-2 rounded-lg border border-blue-200 focus:outline-none bg-white">
                                <option value="Excluded" ${stay.food_inclusion === 'Excluded' ? 'selected' : ''}>Excluded from Rent</option>
                                <option value="Included" ${stay.food_inclusion === 'Included' ? 'selected' : ''}>Included in Rent</option>
                            </select>
                        </div>
                        <div id="edit-food-prices-container" class="grid grid-cols-2 gap-4 ${stay.food_type === 'None' ? 'hidden' : ''}">
                            <div>
                                <label class="block text-[10px] font-bold text-blue-600 uppercase mb-1">Weekday (2 Meals)</label>
                                <input id="swal-edit-weekday-price" type="number" class="w-full px-4 py-2 rounded-lg border border-blue-200 focus:outline-none" value="${stay.weekday_meals_price || ''}" placeholder="Price ₹">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-blue-600 uppercase mb-1">Weekend (3 Meals)</label>
                                <input id="swal-edit-weekend-price" type="number" class="w-full px-4 py-2 rounded-lg border border-blue-200 focus:outline-none" value="${stay.weekend_meals_price || ''}" placeholder="Price ₹">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Area / Location</label>
                            <input id="swal-edit-area" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.area || ''}" placeholder="e.g. Baner">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Gender Type</label>
                            <select id="swal-edit-gender" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="Co-living" ${stay.gender === 'Co-living' ? 'selected' : ''}>Co-living</option>
                                <option value="Boys" ${stay.gender === 'Boys' ? 'selected' : ''}>Boys Only</option>
                                <option value="Girls" ${stay.gender === 'Girls' ? 'selected' : ''}>Girls Only</option>
                            </select>
                        </div>
                    </div>
                    <div class="bg-amber-50 p-4 rounded-xl border border-amber-100 flex items-center justify-between">
                        <div>
                            <label class="block text-xs font-bold text-amber-700">Luxury Curated</label>
                            <p class="text-[10px] text-amber-600">Show in the "Luxury" section on Explore Stays</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <input id="swal-edit-is-luxury" type="checkbox" ${stay.is_luxury ? 'checked' : ''} class="w-5 h-5 rounded border-amber-300 text-amber-600 focus:ring-amber-500">
                            <div class="w-20">
                                <label class="block text-[8px] font-bold text-amber-600 uppercase">Order</label>
                                <input id="swal-edit-luxury-order" type="number" class="w-full px-2 py-1 text-xs rounded border border-amber-200 focus:outline-none" value="${stay.luxury_order || ''}" placeholder="1">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-slate-500">Amenities</label>
                            <button type="button" onclick="manageOptions('amenities')" class="text-[10px] text-blue-600 hover:text-blue-800 font-bold flex items-center">
                                <i class="fas fa-cog mr-1"></i> Manage
                            </button>
                        </div>
                        <div id="edit-amenities-container" class="grid grid-cols-4 gap-2">
                            ${currentAmenities.map(opt => `
                                <label class="flex items-center text-[10px] text-slate-600">
                                    <input type="checkbox" name="edit-amenities" value="${opt}" ${stay.amenities && stay.amenities.includes(opt) ? 'checked' : ''} class="mr-1"> ${opt}
                                </label>
                            `).join('')}
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-slate-500">Rules & Regulations</label>
                            <button type="button" onclick="manageOptions('rules')" class="text-[10px] text-blue-600 hover:text-blue-800 font-bold flex items-center">
                                <i class="fas fa-cog mr-1"></i> Manage
                            </button>
                        </div>
                        <div id="edit-rules-container" class="grid grid-cols-3 gap-2">
                            ${currentRules.map(opt => `
                                <label class="flex items-center text-[10px] text-slate-600">
                                    <input type="checkbox" name="edit-rules" value="${opt}" ${stay.rules && stay.rules.includes(opt) ? 'checked' : ''} class="mr-1"> ${opt}
                                </label>
                            `).join('')}
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Change Image (Optional)</label>
                        <input id="swal-edit-image" type="file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#1e293b',
            confirmButtonText: 'Update Details',
            preConfirm: () => {
                const name = document.getElementById('swal-edit-name').value;
                const deposit = document.getElementById('swal-edit-deposit').value;
                const distance = document.getElementById('swal-edit-distance').value;
                const singleSharing = document.getElementById('swal-edit-single-rent').value;
                const doubleSharing = document.getElementById('swal-edit-double-rent').value;
                const tripleSharing = document.getElementById('swal-edit-triple-rent').value;
                const foodType = document.getElementById('swal-edit-food-type').value;
                const weekdayPrice = document.getElementById('swal-edit-weekday-price').value;
                const weekendPrice = document.getElementById('swal-edit-weekend-price').value;
                const isLuxury = document.getElementById('swal-edit-is-luxury').checked;
                const luxuryOrder = document.getElementById('swal-edit-luxury-order').value;
                const area = document.getElementById('swal-edit-area').value;
                const gender = document.getElementById('swal-edit-gender').value;

                // Validation
                if (!name || !deposit || !doubleSharing) {
                    Swal.showValidationMessage('Name, Deposit and Double Sharing Rent are required');
                    return false;
                }

                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('name', name);
                formData.append('type', document.getElementById('swal-edit-type').value);
                formData.append('deposit', deposit);
                formData.append('distance', distance);
                formData.append('single_sharing_rent', singleSharing);
                formData.append('double_sharing_rent', doubleSharing);
                formData.append('triple_sharing_rent', tripleSharing);
                formData.append('food_type', foodType);
                formData.append('food_inclusion', document.getElementById('swal-edit-food-inclusion').value);
                formData.append('weekday_meals_price', weekdayPrice);
                formData.append('weekend_meals_price', weekendPrice);
                formData.append('visiting_schedule', document.getElementById('swal-edit-visiting-schedule').value);
                formData.append('area', area);
                formData.append('gender', gender);
                if (isLuxury) {
                    formData.append('is_luxury', '1');
                    formData.append('luxury_order', luxuryOrder);
                }                
                
                const modal = Swal.getHtmlContainer();
                const amenities = Array.from(modal.querySelectorAll('input[name="edit-amenities"]:checked')).map(el => el.value);
                const rules = Array.from(modal.querySelectorAll('input[name="edit-rules"]:checked')).map(el => el.value);
                
                amenities.forEach(a => formData.append('amenities[]', a));
                rules.forEach(r => formData.append('rules[]', r));

                const imageFile = document.getElementById('swal-edit-image').files[0];
                if (imageFile) {
                    if (imageFile.size > 10 * 1024 * 1024) {
                        Swal.showValidationMessage('Image exceeds 10MB');
                        return false;
                    }
                    formData.append('image', imageFile);
                }

                return formData;
            }
        });

        if (formValues) {
            try {
                const response = await fetch(`/admin/stays/${stay.id}`, {
                    method: 'POST', // Use POST with _method=PUT for FormData compatibility
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formValues
                });

                const result = await response.json();
                if (result.success) {
                    Swal.fire('Updated!', result.message, 'success').then(() => window.location.reload());
                } else {
                    let errorMessage = result.message || 'Failed to update property';
                    if (result.errors) {
                        errorMessage += '<br><ul class="text-left text-xs mt-2 list-disc list-inside">';
                        Object.values(result.errors).flat().forEach(err => {
                            errorMessage += `<li>${err}</li>`;
                        });
                        errorMessage += '</ul>';
                    }
                    Swal.fire({
                        title: 'Error',
                        html: errorMessage,
                        icon: 'error'
                    });
                }
            } catch (error) {
                Swal.fire('Error', 'An unexpected error occurred', 'error');
            }
        }
    }

    function deleteStay(id, name) {
        Swal.fire({
            title: 'Delete Stay?',
            text: `Are you sure you want to permanently delete "${name}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Keep Listing'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/admin/stays/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const res = await response.json();
                    if (res.success) {
                        Swal.fire('Deleted!', res.message, 'success').then(() => window.location.reload());
                    } else {
                        Swal.fire('Error', res.message || 'Failed to delete listing', 'error');
                    }
                } catch (error) {
                    Swal.fire('Error', 'An unexpected error occurred', 'error');
                }
            }
        });
    }

    async function manageOptions(type) {
        const currentItems = type === 'amenities' ? currentAmenities : currentRules;
        const addRoute = type === 'amenities' ? "{{ route('admin.amenities.store') }}" : "{{ route('admin.rules.store') }}";
        const deleteRoute = type === 'amenities' ? "{{ route('admin.amenities.destroy') }}" : "{{ route('admin.rules.destroy') }}";
        
        // Check which modal is currently open to use correct container ID and name attribute
        const isEditModal = !!document.getElementById('swal-edit-name');
        const containerId = isEditModal ? `edit-${type}-container` : `add-${type}-container`;
        const nameAttr = isEditModal ? `edit-${type}` : type;

        const { value: newItems } = await Swal.fire({
            title: `Manage ${type === 'amenities' ? 'Amenities' : 'Rules'}`,
            width: '400px',
            html: `
                <div class="text-left space-y-3">
                    <div class="flex gap-2">
                        <input id="swal-new-option" class="flex-1 px-3 py-2 text-sm rounded-lg border border-slate-200 focus:outline-none" placeholder="Add new...">
                        <button type="button" onclick="addOptionToList()" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm"><i class="fas fa-plus"></i></button>
                    </div>
                    <div id="options-list" class="max-h-[30vh] overflow-y-auto space-y-1 pr-1">
                        ${currentItems.map((item, index) => `
                            <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg group">
                                <span class="text-xs font-bold text-slate-700">${item}</span>
                                <button type="button" onclick="removeOptionFromList('${item}', ${index})" class="text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </button>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Done',
            didOpen: () => {
                let items = [...currentItems];
                
                window.addOptionToList = async () => {
                    const input = document.getElementById('swal-new-option');
                    const val = input.value.trim();
                    if (!val) return;
                    if (items.includes(val)) {
                        Swal.showValidationMessage('Option already exists');
                        return;
                    }

                    try {
                        const response = await fetch(addRoute, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ name: val })
                        });
                        const res = await response.json();
                        
                        if (res.success) {
                            items.push(val);
                            input.value = '';
                            if(type === 'amenities') currentAmenities = items;
                            else currentRules = items;
                            renderList();
                        } else {
                            Swal.showValidationMessage(res.message || 'Failed to add option');
                        }
                    } catch (error) {
                        Swal.showValidationMessage('Error connecting to server');
                    }
                };

                window.removeOptionFromList = async (val, idx) => {
                    try {
                        const response = await fetch(deleteRoute, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ name: val })
                        });
                        const res = await response.json();
                        
                        if (res.success) {
                            items.splice(idx, 1);
                            if(type === 'amenities') currentAmenities = items;
                            else currentRules = items;
                            renderList();
                        } else {
                            Swal.showValidationMessage(res.message || 'Failed to delete option');
                        }
                    } catch (error) {
                        Swal.showValidationMessage('Error connecting to server');
                    }
                };

                function renderList() {
                    document.getElementById('options-list').innerHTML = items.map((item, idx) => `
                        <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg group">
                            <span class="text-xs font-bold text-slate-700">${item}</span>
                            <button type="button" onclick="removeOptionFromList('${item}', ${idx})" class="text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-trash-alt text-[10px]"></i>
                            </button>
                        </div>
                    `).join('');
                }
            }
        }).then(() => {
            // Re-render the options in the main modal
            const container = document.getElementById(containerId);
            if (container) {
                // Keep track of currently checked ones
                const checked = Array.from(container.querySelectorAll('input:checked')).map(el => el.value);
                
                container.innerHTML = (type === 'amenities' ? currentAmenities : currentRules).map(opt => `
                    <label class="flex items-center text-[10px] text-slate-600">
                        <input type="checkbox" name="${nameAttr}" value="${opt}" ${checked.includes(opt) ? 'checked' : ''} class="mr-1"> ${opt}
                    </label>
                `).join('');
            }
        });
    }

    function toggleFoodPrices(context = 'add') {
        const typeId = context === 'add' ? 'swal-food-type' : 'swal-edit-food-type';
        const containerId = context === 'add' ? 'food-prices-container' : 'edit-food-prices-container';
        
        const type = document.getElementById(typeId).value;
        const container = document.getElementById(containerId);
        
        if (type === 'None') {
            container.classList.add('hidden');
        } else {
            container.classList.remove('hidden');
        }
    }
</script>
@endpush
