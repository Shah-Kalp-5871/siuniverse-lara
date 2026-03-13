@extends('layouts.admin')

@section('title', 'Inquiry For Stays - SIU Admin')

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
        <h1 class="text-2xl font-bold text-slate-800">Inquiry For Stays</h1>
        <p class="text-slate-500 text-sm">Review visit requests from students.</p>
    </div>
    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
        <!-- Search -->
        <div class="relative flex-1 md:flex-none min-w-[200px]">
            <input type="text" id="search-input" placeholder="Search inquiries..." class="pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-slate-500/20 focus:border-slate-800 transition-all w-full shadow-sm">
            <i class="fas fa-search absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
        </div>
    </div>
</header>

<!-- Content Table -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div id="inquiries-table"></div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableData = @json($inquiries);
        
        const table = new Tabulator("#inquiries-table", {
            data: tableData,
            layout: "fitColumns",
            responsiveLayout: "collapse",
            pagination: "local",
            paginationSize: 10,
            paginationSizeSelector: [10, 25, 50, 100],
            movableColumns: true,
            placeholder: "No inquiries yet.",
            columns: [
                {
                    title: "Student Info", 
                    field: "user_name", 
                    formatter: function(cell) {
                        const data = cell.getData();
                        return `
                            <div class="flex flex-col py-1">
                                <span class="text-sm font-bold text-slate-800">${data.user_name}</span>
                                <span class="text-[10px] text-slate-500 font-bold">${data.user_contact_number}</span>
                            </div>
                        `;
                    },
                    widthGrow: 1.5
                },
                {
                    title: "Stay Name", 
                    field: "stay.name",
                    formatter: function(cell) {
                        return `<span class="text-sm font-bold text-slate-700">${cell.getValue() || 'N/A'}</span>`;
                    },
                    widthGrow: 1.5
                },
                {
                    title: "Visit Date", 
                    field: "visit_date",
                    formatter: function(cell) {
                        return `<span class="text-xs font-semibold text-slate-600">${cell.getValue()}</span>`;
                    },
                    width: 120
                },
                {
                    title: "Visit Time", 
                    field: "visit_time",
                    formatter: function(cell) {
                        return `<span class="text-xs font-semibold text-slate-600">${cell.getValue()}</span>`;
                    },
                    width: 120
                },
                {
                    title: "Property Schedule", 
                    field: "visiting_schedule",
                    formatter: function(cell) {
                        return `<span class="text-xs text-slate-500 font-medium">${cell.getValue() || 'N/A'}</span>`;
                    }
                },
                {
                    title: "Submitted At", 
                    field: "created_at",
                    formatter: function(cell) {
                        const date = new Date(cell.getValue());
                        return `<span class="text-[10px] text-slate-400 font-bold">${date.toLocaleString()}</span>`;
                    },
                    width: 150
                },
                {
                    title: "Actions", 
                    field: "actions",
                    headerSort: false,
                    formatter: function(cell) {
                        const data = cell.getData();
                        return `
                            <div class="flex items-center space-x-2 py-1">
                                <button onclick="deleteInquiry(${data.id})" title="Delete" class="w-8 h-8 rounded-lg bg-slate-50 text-red-500 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        `;
                    },
                    width: 80
                }
            ],
            rowFormatter: function(row) {
                row.getElement().classList.add("hover:bg-slate-50/50", "transition-all", "border-b", "border-slate-50");
            }
        });

        // Search functionality
        document.getElementById("search-input").addEventListener("input", function(e) {
            table.setFilter("user_name", "like", e.target.value);
        });
    });

    function deleteInquiry(id) {
        Swal.fire({
            title: 'Delete Inquiry?',
            text: "Are you sure you want to remove this inquiry?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/admin/inquiries/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const res = await response.json();
                    if (res.success) {
                        Swal.fire('Deleted!', res.message, 'success').then(() => window.location.reload());
                    } else {
                        Swal.fire('Error', res.message || 'Failed to delete inquiry', 'error');
                    }
                } catch (error) {
                    Swal.fire('Error', 'An unexpected error occurred', 'error');
                }
            }
        });
    }
</script>
@endpush
