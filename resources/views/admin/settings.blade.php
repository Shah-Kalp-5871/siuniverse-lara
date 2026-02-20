@extends('layouts.admin')

@section('title', 'Admin Settings - SIU Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">System Settings</h1>
            <p class="text-slate-500 text-sm">Configure system-wide parameters and access controls.</p>
        </div>
    </div>

    <!-- Allowed Domains Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-slate-700">Allowed Email Domains</h3>
                <p class="text-xs text-slate-500 mt-1">Only emails with these domains can register or login.</p>
            </div>
            <button onclick="addDomain()" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-700 transition-colors flex items-center shadow-lg shadow-blue-500/20">
                <i class="fas fa-plus mr-1.5"></i> Add Domain
            </button>
        </div>
        
        <div class="p-6">
            @if($allowedDomains->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($allowedDomains as $domain)
                        <div class="flex items-center justify-between p-3 bg-white border border-slate-100 rounded-xl hover:border-slate-200 hover:shadow-sm transition-all group">
                            <div class="flex items-center overflow-hidden">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mr-3">
                                    <i class="fas fa-globe text-xs"></i>
                                </div>
                                <span class="text-sm font-semibold text-slate-700 truncate" title="{{ $domain->domain }}">{{ $domain->domain }}</span>
                            </div>
                            <button onclick="deleteDomain({{ $domain->id }}, '{{ $domain->domain }}')" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-slate-300 text-2xl"></i>
                    </div>
                    <h3 class="text-slate-900 font-medium mb-1">No domains configured</h3>
                    <p class="text-slate-500 text-sm">All email domains are currently blocked.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Admin Security Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mt-8">
        <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50">
            <h3 class="font-bold text-slate-700">Admin Security</h3>
            <p class="text-xs text-slate-500 mt-1">Update your administrative access credentials.</p>
        </div>
        
        <div class="p-6">
            <form id="password-change-form" onsubmit="handlePasswordChange(event)" class="max-w-md">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Current Password</label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" required class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                            <button type="button" onclick="togglePassword('current_password')" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">New Password</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password" required class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                            <button type="button" onclick="togglePassword('new_password')" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required class="w-full px-4 py-2 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm">
                            <button type="button" onclick="togglePassword('new_password_confirmation')" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-slate-900 transition-all shadow-lg shadow-slate-500/20 flex items-center">
                            <i class="fas fa-key mr-2"></i> Update Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function addDomain() {
        const { value: domain } = await Swal.fire({
            title: 'Add Allowed Domain',
            input: 'text',
            inputPlaceholder: 'e.g., sitpune.siu.edu.in',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Add Domain',
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to write a domain!'
                }
                if (!value.includes('.')) {
                    return 'Please enter a valid domain format'
                }
            }
        });

        if (domain) {
            try {
                const response = await fetch("{{ route('admin.settings.domains.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ domain: domain.toLowerCase().trim() })
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added!',
                        text: result.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Failed to add domain', 'error');
            }
        }
    }

    function deleteDomain(id, domain) {
        Swal.fire({
            title: 'Remove Domain?',
            text: `Users with @${domain} emails will no longer be able to register.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Yes, Remove',
            cancelButtonText: 'Cancel'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/admin/settings/domains/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const res = await response.json();
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => window.location.reload());
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                } catch (error) {
                    Swal.fire('Error', 'Failed to remove domain', 'error');
                }
            }
        });
    }

    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    async function handlePasswordChange(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        if (data.new_password !== data.new_password_confirmation) {
            Swal.fire('Error', 'New passwords do not match', 'error');
            return;
        }

        try {
            const response = await fetch("{{ route('admin.settings.password.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                form.reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: result.message,
                    confirmButtonText: 'Okay'
                });
            } else {
                Swal.fire('Error', result.message || 'Failed to update password', 'error');
            }
        } catch (error) {
            Swal.fire('Error', 'An unexpected error occurred', 'error');
        }
    }
</script>
@endpush
