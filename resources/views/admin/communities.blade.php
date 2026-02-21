@extends('layouts.admin')

@section('title', 'WhatsApp Groups - SIU Admin')

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
        <h1 class="text-2xl font-bold text-slate-800">WhatsApp Communities</h1>
        <p class="text-slate-500 text-sm">Manage verified WhatsApp group links.</p>
    </div>
    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
        <!-- Search -->
        <div class="relative flex-1 md:flex-none min-w-[200px]">
            <input type="text" placeholder="Search groups..." class="pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-800 transition-all w-full shadow-sm">
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
                    <span class="text-xs font-bold text-slate-600">Group Name</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="invite_link" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Invite Link</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="status" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Status</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="actions" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Actions</span>
                </label>
            </div>
        </div>

        <button onclick="addCommunity()" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20 flex items-center justify-center flex-1 md:flex-none">
            <i class="fas fa-plus mr-2"></i> Create Group
        </button>
    </div>
</header>


<!-- Communities Table -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-10">
    <div id="communities-table"></div>
</div>

<!-- Bulk Actions Floating Bar -->
<div id="bulk-actions-bar" class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl z-[100] flex items-center gap-6 transition-all duration-300 pointer-events-none opacity-0 translate-y-10">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center">
            <i class="fas fa-check-double text-sm"></i>
        </div>
        <div>
            <p class="text-sm font-bold leading-none mb-1"><span id="selected-count-v2">0</span> Groups Selected</p>
            <p class="text-[10px] text-slate-400 font-medium">Manage multiple groups at once</p>
        </div>
    </div>
    <div class="h-8 w-px bg-slate-700"></div>
    <div class="flex items-center gap-2">
        <button onclick="bulkDeleteCommunities()" class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all flex items-center">
            <i class="fas fa-trash-alt mr-2"></i> Bulk Delete
        </button>
        <button onclick="clearTableSelection()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 px-4 py-2 rounded-lg text-sm font-bold transition-all">
            Cancel
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateBulkDeleteButton(count) {
        const bar = document.getElementById('bulk-actions-bar');
        const countSpan = document.getElementById('selected-count-v2');
        console.log("Updating bar count:", count);
        
        if (!bar) return;

        if (count > 0) {
            countSpan.textContent = count;
            bar.classList.remove('opacity-0', 'translate-y-10', 'pointer-events-none');
            bar.classList.add('translate-y-0');
        } else {
            bar.classList.add('opacity-0', 'translate-y-10', 'pointer-events-none');
            bar.classList.remove('translate-y-0');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tableData = @json($communities);
        
        const table = new Tabulator("#communities-table", {
            data: tableData,
            layout: "fitColumns",
            responsiveLayout: "collapse",
            pagination: "local",
            paginationSize: 10,
            paginationSizeSelector: [10, 25, 50, 100],
            selectable: true,
            placeholder: "No WhatsApp groups registered yet.",
            columns: [
                {
                    formatter: "rowSelection", 
                    titleFormatter: "rowSelection", 
                    hozAlign: "center", 
                    headerSort: false, 
                    width: 50,
                    cellClick: function(e, cell) {
                        cell.getRow().toggleSelect();
                    }
                },
                {
                    title: "Group Name", 
                    field: "name", 
                    formatter: function(cell) {
                        const data = cell.getData();
                        const isActive = data.status === 'Active';
                        return `
                            <div class="flex items-center space-x-3 py-1">
                                <div class="w-9 h-9 rounded-xl ${isActive ? 'bg-green-50 text-green-600' : 'bg-slate-50 text-slate-400'} flex items-center justify-center shrink-0">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-slate-800 truncate">${data.name}</p>
                                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">${data.category}</p>
                                </div>
                            </div>
                        `;
                    },
                    widthGrow: 2
                },
                {
                    title: "Invite Link", 
                    field: "invite_link",
                    formatter: function(cell) {
                        const link = cell.getValue();
                        return `
                            <div class="flex items-center justify-between bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                <code class="text-[10px] text-slate-500 truncate mr-2 font-mono">${link}</code>
                                <button onclick="copyToClipboard('${link}')" class="text-blue-600 hover:text-blue-800 transition-colors shrink-0">
                                    <i class="fas fa-copy text-xs"></i>
                                </button>
                            </div>
                        `;
                    },
                    widthGrow: 1.5
                },
                {
                    title: "Status", 
                    field: "status",
                    formatter: function(cell) {
                        const val = cell.getValue();
                        const isActive = val === 'Active';
                        return `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold ${isActive ? 'bg-green-50 text-green-600 border-green-100' : 'bg-slate-100 text-slate-500 border-slate-200'} border uppercase">${val}</span>`;
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
                                <button onclick='editCommunity(${JSON.stringify(data)})' class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button onclick="deleteCommunity(${data.id}, '${data.name}')" class="w-8 h-8 rounded-lg bg-slate-100 text-red-500 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                                <a href="${data.invite_link}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center hover:bg-green-600 hover:text-white transition-all">
                                    <i class="fas fa-external-link-alt text-xs"></i>
                                </a>
                            </div>
                        `;
                    },
                    width: 150
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
        document.querySelector('input[placeholder="Search groups..."]').addEventListener("input", function(e) {
            table.setFilter("name", "like", e.target.value);
        });

        table.on("rowSelectionChanged", function(data, rows) {
            console.log("Selection event fired:", data.length);
            updateBulkDeleteButton(data.length);
        });
    });

    function toggleCommunityFields(prefix) {
        const categoryEl = document.getElementById(`${prefix}-category`);
        const hostelFields = document.getElementById(`${prefix}-hostel-fields`);
        const originFields = document.getElementById(`${prefix}-origin-fields`);

        if (!categoryEl || !hostelFields || !originFields) return;

        const category = categoryEl.value;

        if (category === 'Hostel') {
            hostelFields.style.display = 'block';
            originFields.style.display = 'block';
        } else if (category === 'PG/Flats' || category === 'Day Scholars') {
            hostelFields.style.display = 'none';
            originFields.style.display = 'block';
        } else {
            hostelFields.style.display = 'none';
            originFields.style.display = 'none';
        }
    }


    function clearTableSelection() {
        const table = Tabulator.findTable("#communities-table")[0];
        if (table) table.deselectRow();
    }

    async function bulkDeleteCommunities() {
        const table = Tabulator.findTable("#communities-table")[0];
        const selectedData = table.getSelectedData();
        const ids = selectedData.map(item => item.id);

        if (ids.length === 0) return;

        const result = await Swal.fire({
            title: 'Delete Selected Groups?',
            text: `Are you sure you want to delete ${ids.length} selected WhatsApp groups? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete all',
            cancelButtonText: 'Cancel'
        });

        if (result.isConfirmed) {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the selected groups.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch('{{ route("admin.communities.bulk-delete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids: ids })
                });

                const data = await response.json();

                if (data.success) {
                    await Swal.fire({
                        title: 'Deleted!',
                        text: data.message,
                        icon: 'success'
                    });
                    location.reload();
                } else {
                    throw new Error(data.message || 'Bulk deletion failed');
                }
            } catch (error) {
                console.error('Bulk Delete Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'An unexpected error occurred during bulk deletion.',
                    icon: 'error'
                });
            }
        }
    }

    async function addCommunity() {
        try {
            const { value: formValues } = await Swal.fire({
                title: 'Create New WhatsApp Group',
                html: `
                    <div class="text-left space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Group Name</label>
                            <input id="swal-name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="e.g. SIT Hostel Community">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Category</label>
                            <select id="swal-category" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white" onchange="toggleCommunityFields('swal')">
                                <option value="">Select Category</option>
                                <option value="Hostel">Hostel</option>
                                <option value="PG/Flats">PG/Flats</option>
                                <option value="Day Scholars">Day Scholars</option>
                            </select>
                        </div>
                        
                        <div id="swal-hostel-fields" style="display: none;" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Select Mess</label>
                                <select id="swal-mess" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                    <option value="">Select Mess</option>
                                    <option value="Viola Mess">Viola Mess</option>
                                    <option value="SIT Mess">SIT Mess</option>
                                    <option value="Petunia Mess">Petunia Mess</option>
                                    <option value="Hilltop Mess">Hilltop Mess</option>
                                    <option value="Medical Mess">Medical Mess</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Select Gym</label>
                                <select id="swal-gym" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                    <option value="">Select Gym</option>
                                    <option value="SIT Gym">SIT Gym</option>
                                    <option value="Viola Gym">Viola Gym</option>
                                    <option value="Medical Gym">Medical Gym</option>
                                    <option value="Hill Top Gym">Hill Top Gym</option>
                                </select>
                            </div>
                        </div>

                        <div id="swal-origin-fields" style="display: none;">
                            <label class="block text-xs font-bold text-slate-500 mb-1">Origin</label>
                            <select id="swal-origin" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="">Select Origin</option>
                                <option value="National">National</option>
                                <option value="International">International</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">WhatsApp Invite Link</label>
                            <input id="swal-link" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="https://chat.whatsapp.com/...">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Status</label>
                            <select id="swal-status" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                confirmButtonText: 'Create Group',
                didOpen: () => {
                    toggleCommunityFields('swal');
                },
                preConfirm: () => {
                    const name = document.getElementById('swal-name')?.value;
                    const category = document.getElementById('swal-category')?.value;
                    const invite_link = document.getElementById('swal-link')?.value;
                    const status = document.getElementById('swal-status')?.value;
                    const mess = document.getElementById('swal-mess')?.value || '';
                    const gym = document.getElementById('swal-gym')?.value || '';
                    const origin = document.getElementById('swal-origin')?.value || '';

                    if (!name || !category || !invite_link) {
                        Swal.showValidationMessage('Please fill in required fields');
                        return false;
                    }

                    if (category === 'Hostel' && (!mess || !gym || !origin)) {
                        Swal.showValidationMessage('Please select Mess, Gym and Origin for Hostel');
                        return false;
                    }

                    if ((category === 'PG/Flats' || category === 'Day Scholars') && !origin) {
                        Swal.showValidationMessage(`Please select Origin for ${category}`);
                        return false;
                    }

                    if (!/^[a-zA-Z\s]+$/.test(name)) {
                        Swal.showValidationMessage('Group Name must contain only text');
                        return false;
                    }

                    try {
                        const url = new URL(invite_link);
                        if (url.protocol !== 'https:') {
                            Swal.showValidationMessage('Invite Link must start with https://');
                            return false;
                        }
                    } catch (_) {
                        Swal.showValidationMessage('Invite Link must be a valid URL');
                        return false;
                    }

                    return { name, category, invite_link, status, mess, gym, origin };
                }
            });

            if (formValues) {
                const response = await fetch("{{ route('admin.communities.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(formValues)
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Server responded with ${response.status}: ${errorText.substring(0, 100)}`);
                }

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Created!',
                        text: result.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire('Error', result.message || 'Failed to create group', 'error');
                }
            }
        } catch (error) {
            console.error('Add Community Error:', error);
            Swal.fire('Error', 'An unexpected error occurred: ' + error.message, 'error');
        }
    }

    async function editCommunity(community) {
        try {
            const { value: formValues } = await Swal.fire({
                title: 'Edit Community',
                html: `
                    <div class="text-left space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Group Name</label>
                            <input id="swal-edit-name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${community.name}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Category</label>
                            <select id="swal-edit-category" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white" onchange="toggleCommunityFields('swal-edit')">
                                <option value="Hostel" ${community.category === 'Hostel' ? 'selected' : ''}>Hostel</option>
                                <option value="PG/Flats" ${community.category === 'PG/Flats' ? 'selected' : ''}>PG/Flats</option>
                                <option value="Day Scholars" ${community.category === 'Day Scholars' ? 'selected' : ''}>Day Scholars</option>
                            </select>
                        </div>

                        <div id="swal-edit-hostel-fields" style="display: none;" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Select Mess</label>
                                <select id="swal-edit-mess" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                    <option value="">Select Mess</option>
                                    <option value="Viola Mess" ${community.mess === 'Viola Mess' ? 'selected' : ''}>Viola Mess</option>
                                    <option value="SIT Mess" ${community.mess === 'SIT Mess' ? 'selected' : ''}>SIT Mess</option>
                                    <option value="Petunia Mess" ${community.mess === 'Petunia Mess' ? 'selected' : ''}>Petunia Mess</option>
                                    <option value="Hilltop Mess" ${community.mess === 'Hilltop Mess' ? 'selected' : ''}>Hilltop Mess</option>
                                    <option value="Medical Mess" ${community.mess === 'Medical Mess' ? 'selected' : ''}>Medical Mess</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Select Gym</label>
                                <select id="swal-edit-gym" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                    <option value="">Select Gym</option>
                                    <option value="SIT Gym" ${community.gym === 'SIT Gym' ? 'selected' : ''}>SIT Gym</option>
                                    <option value="Viola Gym" ${community.gym === 'Viola Gym' ? 'selected' : ''}>Viola Gym</option>
                                    <option value="Medical Gym" ${community.gym === 'Medical Gym' ? 'selected' : ''}>Medical Gym</option>
                                    <option value="Hill Top Gym" ${community.gym === 'Hill Top Gym' ? 'selected' : ''}>Hill Top Gym</option>
                                </select>
                            </div>
                        </div>

                        <div id="swal-edit-origin-fields" style="display: none;">
                            <label class="block text-xs font-bold text-slate-500 mb-1">Origin</label>
                            <select id="swal-edit-origin" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="">Select Origin</option>
                                <option value="National" ${community.origin === 'National' ? 'selected' : ''}>National</option>
                                <option value="International" ${community.origin === 'International' ? 'selected' : ''}>International</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">WhatsApp Invite Link</label>
                            <input id="swal-edit-link" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${community.invite_link}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Status</label>
                            <select id="swal-edit-status" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="Active" ${community.status === 'Active' ? 'selected' : ''}>Active</option>
                                <option value="Inactive" ${community.status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                            </select>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'Save Changes',
                didOpen: () => {
                    toggleCommunityFields('swal-edit');
                },
                preConfirm: () => {
                    const name = document.getElementById('swal-edit-name')?.value;
                    const category = document.getElementById('swal-edit-category')?.value;
                    const invite_link = document.getElementById('swal-edit-link')?.value;
                    const status = document.getElementById('swal-edit-status')?.value;
                    const mess = document.getElementById('swal-edit-mess')?.value || '';
                    const gym = document.getElementById('swal-edit-gym')?.value || '';
                    const origin = document.getElementById('swal-edit-origin')?.value || '';

                    if (!name || !category || !invite_link) {
                        Swal.showValidationMessage('Please fill in required fields');
                        return false;
                    }

                    if (category === 'Hostel' && (!mess || !gym || !origin)) {
                        Swal.showValidationMessage('Please select Mess, Gym and Origin for Hostel');
                        return false;
                    }

                    if ((category === 'PG/Flats' || category === 'Day Scholars') && !origin) {
                        Swal.showValidationMessage(`Please select Origin for ${category}`);
                        return false;
                    }

                    if (!/^[a-zA-Z\s]+$/.test(name)) {
                        Swal.showValidationMessage('Group Name must contain only text');
                        return false;
                    }

                    try {
                        const url = new URL(invite_link);
                        if (url.protocol !== 'https:') {
                            Swal.showValidationMessage('Invite Link must start with https://');
                            return false;
                        }
                    } catch (_) {
                        Swal.showValidationMessage('Invite Link must be a valid URL');
                        return false;
                    }

                    return { name, category, invite_link, status, mess, gym, origin };
                }
            });

            if (formValues) {
                const response = await fetch(`/admin/communities/${community.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(formValues)
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Server responded with ${response.status}: ${errorText.substring(0, 100)}`);
                }

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: result.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire('Error', result.message || 'Failed to update community', 'error');
                }
            }
        } catch (error) {
            console.error('Edit Community Error:', error);
            Swal.fire('Error', 'An unexpected error occurred: ' + error.message, 'error');
        }
    }

    function deleteCommunity(id, name) {
        Swal.fire({
            title: 'Delete Community?',
            text: `Are you sure you want to permanently delete "${name}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Keep Group'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/admin/communities/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        }
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        throw new Error(`Server responded with ${response.status}: ${errorText.substring(0, 100)}`);
                    }

                    const res = await response.json();
                    if (res.success) {
                        Swal.fire('Deleted!', res.message, 'success').then(() => window.location.reload());
                    } else {
                        Swal.fire('Error', res.message || 'Failed to delete', 'error');
                    }
                } catch (error) {
                    console.error('Delete Community Error:', error);
                    Swal.fire('Error', 'An unexpected error occurred: ' + error.message, 'error');
                }
            }
        });
    }

    async function quickAddLink() {
        try {
            const link = document.getElementById('quick-link-input')?.value;
            if (!link) {
                Swal.fire('Error', 'Please paste a valid WhatsApp link.', 'error');
                return;
            }
            if (!link.includes('chat.whatsapp.com')) {
                Swal.fire('Invalid Link', 'Please paste a valid WhatsApp invite link.', 'warning');
                return;
            }
            
            const { value: name } = await Swal.fire({
                title: 'Link Detected!',
                text: 'Provide a name for this group:',
                input: 'text',
                inputPlaceholder: 'e.g. SIT Cricket Group',
                showCancelButton: true,
                confirmButtonText: 'Create Group',
                preConfirm: (val) => {
                    if (!val) {
                        Swal.showValidationMessage('Group name is required');
                    }
                    return val;
                }
            });

            if (name) {
                const response = await fetch("{{ route('admin.communities.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        name: name,
                        category: 'General',
                        invite_link: link,
                        status: 'Active'
                    })
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Server responded with ${response.status}: ${errorText.substring(0, 100)}`);
                }

                const result = await response.json();
                if (result.success) {
                    Swal.fire('Successfully Added!', result.message, 'success').then(() => window.location.reload());
                } else {
                    Swal.fire('Error', result.message || 'Failed to add group', 'error');
                }
            }
        } catch (error) {
            console.error('Quick Add Error:', error);
            Swal.fire('Error', 'An unexpected error occurred: ' + error.message, 'error');
        }
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            icon: 'success',
            title: 'Link copied!'
        });
    }
</script>
@endpush
