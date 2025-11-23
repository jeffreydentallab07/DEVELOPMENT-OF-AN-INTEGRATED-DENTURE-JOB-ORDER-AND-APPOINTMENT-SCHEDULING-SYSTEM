@extends('layouts.app')

@section('page-title', 'Billing Management')

@section('content')
<div class="p-6 space-y-6 bg-gray-300 min-h-screen">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Billing Management</h1>
            <p class="text-gray-600">Manage all billing records</p>
        </div>
        <a href="{{ route('admin.billing.create') }}"
            class="bg-green-500 text-white px-5 py-2 rounded font-semibold hover:bg-green-600 transition">
            + Create Billing
        </a>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-700 border border-green-300">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="flex border-b">
            <button onclick="filterBillings('all')"
                class="filter-tab px-6 py-3 font-medium text-gray-600 hover:text-blue-600 border-b-2 border-blue-600 text-blue-600">
                All
            </button>
            <button onclick="filterBillings('unpaid')"
                class="filter-tab px-6 py-3 font-medium text-gray-600 hover:text-blue-600 border-b-2 border-transparent">
                Unpaid
            </button>
            <button onclick="filterBillings('partial')"
                class="filter-tab px-6 py-3 font-medium text-gray-600 hover:text-blue-600 border-b-2 border-transparent">
                Partial
            </button>
            <button onclick="filterBillings('paid')"
                class="filter-tab px-6 py-3 font-medium text-gray-600 hover:text-blue-600 border-b-2 border-transparent">
                Paid
            </button>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl shadow-lg">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-blue-900 text-white">
                    <th class="px-6 py-3 text-left">Billing ID</th>
                    <th class="px-6 py-3 text-left">Appointment</th>
                    <th class="px-6 py-3 text-left">Clinic</th>
                    <th class="px-6 py-3 text-left">Patient</th>
                    <th class="px-6 py-3 text-left">Total Amount</th>
                    <th class="px-6 py-3 text-left">Payment Status</th>
                    <th class="px-6 py-3 text-left">Payment Method</th>
                    <th class="px-6 py-3 text-left">Date Created</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($billings as $billing)
                <tr class="billing-row border-b hover:bg-gray-50" data-status="{{ $billing->payment_status }}">
                    <td class="px-6 py-3 font-semibold text-gray-800">
                        BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-3">
                        <a href="{{ route('admin.appointments.show', $billing->appointment_id) }}"
                            class="text-blue-600 hover:underline">
                            APT-{{ str_pad($billing->appointment_id, 5, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td class="px-6 py-3 text-gray-700">
                        {{ $billing->appointment->caseOrder->clinic->clinic_name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-3 text-gray-700">
                        {{ $billing->appointment->caseOrder->patient->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-3 font-semibold text-green-600">
                        ₱{{ number_format($billing->total_amount, 2) }}
                    </td>
                    <td class="px-6 py-3">
                        <span
                            class="px-2 py-1 text-xs rounded-full font-medium
                            {{ $billing->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                               ($billing->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($billing->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-gray-700 text-sm">
                        {{ $billing->payment_method ?? 'Not specified' }}
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-600">
                        {{ $billing->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-3">
                 <a href="{{ route('admin.billing.show', $billing->id) }}"
   class="group relative inline-flex items-center justify-center bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">

    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.178.07.207.07.437 0 .644C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" />
    </svg>

    <span class="absolute left-1/2 -bottom-8 -translate-x-1/2 whitespace-nowrap bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition pointer-events-none">
        View Details
    </span>
</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-8 text-gray-500">No billing records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $billings->links() }}
    </div>
</div>

<script>
    function filterBillings(status) {
    const rows = document.querySelectorAll('.billing-row');
    const tabs = document.querySelectorAll('.filter-tab');
    
    tabs.forEach(tab => {
        tab.classList.remove('border-blue-600', 'text-blue-600');
        tab.classList.add('border-transparent', 'text-gray-600');
    });
    event.target.classList.add('border-blue-600', 'text-blue-600');
    event.target.classList.remove('border-transparent', 'text-gray-600');
    
    // Filter rows
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection