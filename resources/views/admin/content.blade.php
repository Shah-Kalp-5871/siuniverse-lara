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
                    <input type="checkbox" checked data-column="broker_name" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Broker</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="rent" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Rent</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="distance" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Distance</span>
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
                    title: "Broker", 
                    field: "broker_name",
                    formatter: function(cell) {
                        const data = cell.getData();
                        return `
                            <div class="py-1">
                                <p class="text-xs font-semibold text-slate-700">${data.broker_name}</p>
                                <p class="text-[10px] text-slate-400 font-bold">${data.broker_number}</p>
                            </div>
                        `;
                    }
                },
                {
                    title: "Rent", 
                    field: "rent",
                    formatter: function(cell) {
                        return `
                            <div class="flex items-center text-xs text-slate-600 font-semibold px-2">
                                <i class="fas fa-tag mr-1.5 text-[10px] text-slate-400"></i>
                                ₹${new Intl.NumberFormat().format(cell.getValue())}/mo
                            </div>
                        `;
                    },
                    width: 140
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
                            <label class="block text-xs font-bold text-slate-500 mb-1">Rent Amount (₹)</label>
                            <input id="swal-rent" type="number" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="e.g. 8500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Distance (Km)</label>
                            <input id="swal-distance" type="number" step="0.1" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="e.g. 1.2">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Broker Name</label>
                            <input id="swal-broker-name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="Full name">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Contact Number</label>
                            <input id="swal-broker-number" type="text" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="+91 00000 00000">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">External Link (Optional)</label>
                        <input id="swal-link" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="https://...">
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-slate-500">Amenities</label>
                            <button type="button" onclick="manageOptions('amenities')" class="text-[10px] text-blue-600 hover:text-blue-800 font-bold flex items-center">
                                <i class="fas fa-cog mr-1"></i> Manage
                            </button>
                        </div>
                        <div id="amenities-container" class="grid grid-cols-4 gap-2">
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
                        <div id="rules-container" class="grid grid-cols-3 gap-2">
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
                const rent = document.getElementById('swal-rent').value;
                const distance = document.getElementById('swal-distance').value;
                const brokerName = document.getElementById('swal-broker-name').value;
                const brokerNumber = document.getElementById('swal-broker-number').value;
                const link = document.getElementById('swal-link').value;

                // Validation
                if (!name || !rent) {
                    Swal.showValidationMessage('Name and Rent are required');
                    return false;
                }

                if (!/^\d+$/.test(rent)) {
                    Swal.showValidationMessage('Rent Amount must contain only numbers');
                    return false;
                }

                if (distance && isNaN(distance)) { // Distance is number check
                     Swal.showValidationMessage('Distance must be a valid number');
                     return false;
                }
                
                if (brokerName && !/^[a-zA-Z\s]+$/.test(brokerName)) {
                    Swal.showValidationMessage('Broker Name must contain only text (no numbers or special characters)');
                    return false;
                }

                if (brokerNumber && !/^\d{10}$/.test(brokerNumber)) {
                    Swal.showValidationMessage('Contact Number must be exactly 10 digits (0-9)');
                    return false;
                }

                if (link) {
                    try {
                        const url = new URL(link);
                        if (url.protocol !== 'https:') {
                            Swal.showValidationMessage('External Link must start with https://');
                            return false;
                        }
                    } catch (_) {
                        Swal.showValidationMessage('External Link must be a valid URL');
                        return false;
                    }
                }

                const formData = new FormData();
                formData.append('name', name);
                formData.append('type', document.getElementById('swal-type').value);
                formData.append('rent', rent);
                formData.append('distance', distance);
                formData.append('broker_name', brokerName);
                formData.append('broker_number', brokerNumber);
                formData.append('link', link);
                
                const amenities = Array.from(document.querySelectorAll('input[name="amenities"]:checked')).map(el => el.value);
                const rules = Array.from(document.querySelectorAll('input[name="rules"]:checked')).map(el => el.value);
                
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
                    Swal.fire('Error', result.message || 'Failed to list property', 'error');
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
                            <label class="block text-xs font-bold text-slate-500 mb-1">Rent Amount (₹)</label>
                            <input id="swal-edit-rent" type="number" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.rent}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Distance (Km)</label>
                            <input id="swal-edit-distance" type="number" step="0.1" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.distance}">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Broker Name</label>
                            <input id="swal-edit-broker-name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.broker_name}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Contact Number</label>
                            <input id="swal-edit-broker-number" type="text" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.broker_number}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">External Link (Optional)</label>
                        <input id="swal-edit-link" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${stay.link || ''}">
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-slate-500">Amenities</label>
                            <button type="button" onclick="manageOptions('amenities')" class="text-[10px] text-blue-600 hover:text-blue-800 font-bold flex items-center">
                                <i class="fas fa-cog mr-1"></i> Manage
                            </button>
                        </div>
                        <div id="amenities-container" class="grid grid-cols-4 gap-2">
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
                        <div id="rules-container" class="grid grid-cols-3 gap-2">
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
                const rent = document.getElementById('swal-edit-rent').value;
                const distance = document.getElementById('swal-edit-distance').value;
                const brokerName = document.getElementById('swal-edit-broker-name').value;
                const brokerNumber = document.getElementById('swal-edit-broker-number').value;
                const link = document.getElementById('swal-edit-link').value;

                // Validation
                if (!name || !rent) {
                    Swal.showValidationMessage('Name and Rent are required');
                    return false;
                }

                if (!/^\d+$/.test(rent)) {
                    Swal.showValidationMessage('Rent Amount must contain only numbers');
                    return false;
                }

                if (distance && isNaN(distance)) {
                     Swal.showValidationMessage('Distance must be a valid number');
                     return false;
                }
                
                if (brokerName && !/^[a-zA-Z\s]+$/.test(brokerName)) {
                    Swal.showValidationMessage('Broker Name must contain only text (no numbers or special characters)');
                    return false;
                }

                if (brokerNumber && !/^\d{10}$/.test(brokerNumber)) {
                    Swal.showValidationMessage('Contact Number must be exactly 10 digits (0-9)');
                    return false;
                }

                if (link) {
                    try {
                        const url = new URL(link);
                        if (url.protocol !== 'https:') {
                            Swal.showValidationMessage('External Link must start with https://');
                            return false;
                        }
                    } catch (_) {
                        Swal.showValidationMessage('External Link must be a valid URL');
                        return false;
                    }
                }

                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('name', name);
                formData.append('type', document.getElementById('swal-edit-type').value);
                formData.append('rent', rent);
                formData.append('distance', distance);
                formData.append('broker_name', brokerName);
                formData.append('broker_number', brokerNumber);
                formData.append('link', link);
                
                const amenities = Array.from(document.querySelectorAll('input[name="edit-amenities"]:checked')).map(el => el.value);
                const rules = Array.from(document.querySelectorAll('input[name="edit-rules"]:checked')).map(el => el.value);
                
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
                    Swal.fire('Error', result.message || 'Failed to update property', 'error');
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
            const containerId = `${type}-container`;
            const container = document.getElementById(containerId);
            if (container) {
                const nameAttr = container.id === 'amenities-container' ? 
                    (document.getElementById('swal-edit-name') ? 'edit-amenities' : 'amenities') : 
                    (document.getElementById('swal-edit-name') ? 'edit-rules' : 'rules');
                
                // Keep track of currently checked ones if in Edit mode
                const checked = Array.from(container.querySelectorAll('input:checked')).map(el => el.value);
                
                container.innerHTML = (type === 'amenities' ? currentAmenities : currentRules).map(opt => `
                    <label class="flex items-center text-[10px] text-slate-600">
                        <input type="checkbox" name="${nameAttr}" value="${opt}" ${checked.includes(opt) ? 'checked' : ''} class="mr-1"> ${opt}
                    </label>
                `).join('');
            }
        });
    }
</script>
@endpush
