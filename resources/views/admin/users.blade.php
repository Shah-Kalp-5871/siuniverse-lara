@extends('layouts.admin')

@section('title', 'User Management - SIU Admin')

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
    .tabulator-placeholder span {
        font-style: italic;
        color: #94a3b8;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 space-y-4 md:space-y-0">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Student Directory</h1>
        <p class="text-slate-500 text-sm">Manage and verify student accounts.</p>
    </div>
    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
        <!-- Search -->
        <div class="relative flex-1 md:flex-none min-w-[200px]">
            <input type="text" placeholder="Search students..." class="pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-800 transition-all w-full shadow-sm">
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
                    <span class="text-xs font-bold text-slate-600">Student Info</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="institute" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Institute & Course</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="origin" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Status</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="created_at" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Joined Date</span>
                </label>
                <label class="flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg cursor-pointer transition-colors">
                    <input type="checkbox" checked data-column="actions" class="col-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-xs font-bold text-slate-600">Actions</span>
                </label>
            </div>
        </div>

        <button onclick="addUser()" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 flex items-center justify-center flex-1 md:flex-none">
            <i class="fas fa-user-plus mr-2"></i> Register
        </button>
    </div>
</header>


<!-- Users Table -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div id="students-table"></div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableData = @json($students);
        
        const table = new Tabulator("#students-table", {
            data: tableData,
            layout: "fitColumns",
            responsiveLayout: "collapse",
            pagination: "local",
            paginationSize: 10,
            paginationSizeSelector: [10, 25, 50, 100],
            movableColumns: true,
            placeholder: "No students registered yet.",
            columns: [
                {
                    title: "Student Information", 
                    field: "name", 
                    formatter: function(cell) {
                        const data = cell.getData();
                        const initial = data.name.charAt(0).toUpperCase();
                        return `
                            <div class="flex items-center space-x-3 py-1">
                                <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs uppercase shrink-0">
                                    ${initial}
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-slate-800 truncate">${data.name}</p>
                                    <p class="text-xs text-slate-500 truncate">${data.email}</p>
                                </div>
                            </div>
                        `;
                    },
                    widthGrow: 2
                },
                {
                    title: "Institute & Course", 
                    field: "institute",
                    formatter: function(cell) {
                        const data = cell.getData();
                        return `
                            <div class="py-1">
                                <p class="text-sm font-semibold text-slate-700">${data.institute}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">${data.course}</p>
                            </div>
                        `;
                    }
                },
                {
                    title: "Status", 
                    field: "origin",
                    formatter: function(cell) {
                        const val = cell.getValue();
                        return `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600 border border-green-100 uppercase">${val}</span>`;
                    },
                    width: 120
                },
                {
                    title: "Joined", 
                    field: "created_at",
                    formatter: function(cell) {
                        return `<p class="text-xs text-slate-500 px-2">${cell.getValue().split('T')[0]}</p>`;
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
                                <button onclick='editUser(${JSON.stringify(data)})' class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button onclick="deleteUser(${data.id}, '${data.name}')" class="w-8 h-8 rounded-lg bg-slate-100 text-red-500 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
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
        document.querySelector('input[placeholder="Search students..."]').addEventListener("input", function(e) {
            table.setFilter("name", "like", e.target.value);
        });
    });

    async function addUser() {
        const { value: formValues } = await Swal.fire({
            title: 'Register New Student',
            html: `
                <div class="text-left space-y-4 max-h-[70vh] overflow-y-auto px-1">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Full Name</label>
                        <input id="swal-name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="Student Name">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Institutional Email</label>
                        <input id="swal-email" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="name.surname.course-year@institute.siu.edu.in">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Institute</label>
                            <select id="swal-institute" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="SAII">SAII</option>
                                <option value="SIMC">SIMC</option>
                                <option value="SIBM">SIBM</option>
                                <option value="SIDTM">SIDTM</option>
                                <option value="SIT">SIT</option>
                                <option value="SSBF">SSBF</option>
                                <option value="SSVAP">SSVAP</option>
                                <option value="SSCANS">SSCANS</option>
                                <option value="SCON">SCON</option>
                                <option value="SCHS">SCHS</option>
                                <option value="SSSS">SSSS</option>
                                <option value="SIHS">SIHS</option>
                                <option value="SMCW">SMCW</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Course</label>
                            <input id="swal-course" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" placeholder="e.g. B.Tech CS">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Section</label>
                            <select id="swal-section" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Accommodation</label>
                            <select id="swal-accommodation" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white" onchange="toggleGymChoice(this.value)">
                                <option value="Day scholar">Day scholar</option>
                                <option value="Hostel">Hostel</option>
                                <option value="PG/Flats">PG/Flats</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Campus Location</label>
                            <select id="swal-location" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="Hill Top">Hill Top</option>
                                <option value="Hill Base">Hill Base</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Study Year</label>
                            <select id="swal-year" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                                <option value="5">5th Year</option>
                            </select>
                        </div>
                    </div>
                    <div id="gym-container" class="hidden">
                        <label class="block text-xs font-bold text-slate-500 mb-1">Gym Choice</label>
                        <select id="swal-gym" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                            <option value="">No Gym</option>
                            <option value="Morning Batch">Morning Batch</option>
                            <option value="Evening Batch">Evening Batch</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Student Origin</label>
                        <div class="flex gap-4">
                            <label class="flex items-center text-sm text-slate-600">
                                <input type="radio" name="origin" value="national" checked class="mr-2"> National
                            </label>
                            <label class="flex items-center text-sm text-slate-600">
                                <input type="radio" name="origin" value="international" class="mr-2"> International
                            </label>
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Register Student',
            didOpen: () => {
                // Initialize gym toggle based on accommodation
                window.toggleGymChoice = (value) => {
                    const container = document.getElementById('gym-container');
                    if (value === 'Hostel') {
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                        document.getElementById('swal-gym').value = '';
                    }
                };
            },
            preConfirm: () => {
                const data = {
                    name: document.getElementById('swal-name').value,
                    email: document.getElementById('swal-email').value,
                    institute: document.getElementById('swal-institute').value,
                    course: document.getElementById('swal-course').value,
                    section: document.getElementById('swal-section').value,
                    accommodation: document.getElementById('swal-accommodation').value,
                    campus_location: document.getElementById('swal-location').value,
                    current_study_year: document.getElementById('swal-year').value,
                    gym_choice: document.getElementById('swal-gym') ? document.getElementById('swal-gym').value || null : null,
                    origin: document.querySelector('input[name="origin"]:checked').value
                };

                // Basic frontend validation
                if (!data.name || !data.email || !data.institute || !data.course || !data.section) {
                    Swal.showValidationMessage('Please fill in all basic information');
                    return false;
                }

                if (!/^[a-zA-Z\s]+$/.test(data.name)) {
                    Swal.showValidationMessage('Full Name must contain only text');
                    return false;
                }

                if (!/^[a-zA-Z\s]+$/.test(data.course)) {
                    Swal.showValidationMessage('Course must contain only text');
                    return false;
                }

                return data;
            }
        });

        if (formValues) {
            try {
                const response = await fetch("{{ route('admin.students.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formValues)
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: result.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    let errorMessage = result.message;
                    if (result.errors) {
                        errorMessage = Object.values(result.errors).flat().join('<br>');
                    }
                    Swal.fire('Error', errorMessage, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to register student. Please try again.', 'error');
            }
        }
    }

    async function editUser(user) {
        const { value: formValues } = await Swal.fire({
            title: 'Edit Student Details',
            html: `
                <div class="text-left space-y-4 max-h-[70vh] overflow-y-auto px-1">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Full Name</label>
                        <input id="swal-edit-name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${user.name}">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Institutional Email</label>
                        <input id="swal-edit-email" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${user.email}">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Institute</label>
                            <select id="swal-edit-institute" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="SAII" ${user.institute === 'SAII' ? 'selected' : ''}>SAII</option>
                                <option value="SIMC" ${user.institute === 'SIMC' ? 'selected' : ''}>SIMC</option>
                                <option value="SIBM" ${user.institute === 'SIBM' ? 'selected' : ''}>SIBM</option>
                                <option value="SIDTM" ${user.institute === 'SIDTM' ? 'selected' : ''}>SIDTM</option>
                                <option value="SIT" ${user.institute === 'SIT' ? 'selected' : ''}>SIT</option>
                                <option value="SSBF" ${user.institute === 'SSBF' ? 'selected' : ''}>SSBF</option>
                                <option value="SSVAP" ${user.institute === 'SSVAP' ? 'selected' : ''}>SSVAP</option>
                                <option value="SSCANS" ${user.institute === 'SSCANS' ? 'selected' : ''}>SSCANS</option>
                                <option value="SCON" ${user.institute === 'SCON' ? 'selected' : ''}>SCON</option>
                                <option value="SCHS" ${user.institute === 'SCHS' ? 'selected' : ''}>SCHS</option>
                                <option value="SSSS" ${user.institute === 'SSSS' ? 'selected' : ''}>SSSS</option>
                                <option value="SIHS" ${user.institute === 'SIHS' ? 'selected' : ''}>SIHS</option>
                                <option value="SMCW" ${user.institute === 'SMCW' ? 'selected' : ''}>SMCW</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Course</label>
                            <input id="swal-edit-course" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none" value="${user.course}">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Section</label>
                            <select id="swal-edit-section" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="A" ${user.section === 'A' ? 'selected' : ''}>A</option>
                                <option value="B" ${user.section === 'B' ? 'selected' : ''}>B</option>
                                <option value="C" ${user.section === 'C' ? 'selected' : ''}>C</option>
                                <option value="D" ${user.section === 'D' ? 'selected' : ''}>D</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Accommodation</label>
                            <select id="swal-edit-accommodation" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white" onchange="toggleEditGymChoice(this.value)">
                                <option value="Day scholar" ${user.accommodation === 'Day scholar' ? 'selected' : ''}>Day scholar</option>
                                <option value="Hostel" ${user.accommodation === 'Hostel' ? 'selected' : ''}>Hostel</option>
                                <option value="PG/Flats" ${user.accommodation === 'PG/Flats' ? 'selected' : ''}>PG/Flats</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Campus Location</label>
                            <select id="swal-edit-location" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="Hill Top" ${user.campus_location === 'Hill Top' ? 'selected' : ''}>Hill Top</option>
                                <option value="Hill Base" ${user.campus_location === 'Hill Base' ? 'selected' : ''}>Hill Base</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Study Year</label>
                            <select id="swal-edit-year" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                                <option value="1" ${user.current_study_year == 1 ? 'selected' : ''}>1st Year</option>
                                <option value="2" ${user.current_study_year == 2 ? 'selected' : ''}>2nd Year</option>
                                <option value="3" ${user.current_study_year == 3 ? 'selected' : ''}>3rd Year</option>
                                <option value="4" ${user.current_study_year == 4 ? 'selected' : ''}>4th Year</option>
                                <option value="5" ${user.current_study_year == 5 ? 'selected' : ''}>5th Year</option>
                            </select>
                        </div>
                    </div>
                    <div id="edit-gym-container" class="${user.accommodation === 'Hostel' ? '' : 'hidden'}">
                        <label class="block text-xs font-bold text-slate-500 mb-1">Gym Choice</label>
                        <select id="swal-edit-gym" class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none bg-white">
                            <option value="" ${!user.gym_choice ? 'selected' : ''}>No Gym</option>
                            <option value="Morning Batch" ${user.gym_choice === 'Morning Batch' ? 'selected' : ''}>Morning Batch</option>
                            <option value="Evening Batch" ${user.gym_choice === 'Evening Batch' ? 'selected' : ''}>Evening Batch</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Student Origin</label>
                        <div class="flex gap-4">
                            <label class="flex items-center text-sm text-slate-600">
                                <input type="radio" name="edit-origin" value="national" ${user.origin === 'national' ? 'checked' : ''} class="mr-2"> National
                            </label>
                            <label class="flex items-center text-sm text-slate-600">
                                <input type="radio" name="edit-origin" value="international" ${user.origin === 'international' ? 'checked' : ''} class="mr-2"> International
                            </label>
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Update Student',
            didOpen: () => {
                window.toggleEditGymChoice = (value) => {
                    const container = document.getElementById('edit-gym-container');
                    if (value === 'Hostel') {
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                        document.getElementById('swal-edit-gym').value = '';
                    }
                };
            },
            preConfirm: () => {
                const data = {
                    name: document.getElementById('swal-edit-name').value,
                    email: document.getElementById('swal-edit-email').value,
                    institute: document.getElementById('swal-edit-institute').value,
                    course: document.getElementById('swal-edit-course').value,
                    section: document.getElementById('swal-edit-section').value,
                    accommodation: document.getElementById('swal-edit-accommodation').value,
                    campus_location: document.getElementById('swal-edit-location').value,
                    current_study_year: document.getElementById('swal-edit-year').value,
                    gym_choice: document.getElementById('swal-edit-gym') ? document.getElementById('swal-edit-gym').value || null : null,
                    origin: document.querySelector('input[name="edit-origin"]:checked').value
                };

                if (!data.name || !data.email || !data.institute || !data.course || !data.section) {
                    Swal.showValidationMessage('Please fill in all basic information');
                    return false;
                }

                if (!/^[a-zA-Z\s]+$/.test(data.name)) {
                    Swal.showValidationMessage('Full Name must contain only text');
                    return false;
                }

                if (!/^[a-zA-Z\s]+$/.test(data.course)) {
                    Swal.showValidationMessage('Course must contain only text');
                    return false;
                }

                return data;
            }
        });

        if (formValues) {
            try {
                const response = await fetch(`/admin/students/${user.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formValues)
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: result.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    let errorMessage = result.message;
                    if (result.errors) {
                        errorMessage = Object.values(result.errors).flat().join('<br>');
                    }
                    Swal.fire('Error', errorMessage, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to update student. Please try again.', 'error');
            }
        }
    }

    function deleteUser(id, name) {
        Swal.fire({
            title: 'Delete Student?',
            text: `Are you sure you want to permanently delete "${name}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Keep Account'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/admin/students/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const res = await response.json();
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => window.location.reload());
                    } else {
                        Swal.fire('Error', res.message || 'Failed to delete student', 'error');
                    }
                } catch (error) {
                    Swal.fire('Error', 'An unexpected error occurred', 'error');
                }
            }
        });
    }
</script>
@endpush
