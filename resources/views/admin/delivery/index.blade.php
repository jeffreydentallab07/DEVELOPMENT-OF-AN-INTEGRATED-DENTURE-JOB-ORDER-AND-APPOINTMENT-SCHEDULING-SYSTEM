@extends('layouts.app')

@section('page-title', 'Delivery Management')

@section('content')
<div class="p-6 space-y-6 bg-gray-300 min-h-screen">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Delivery Management</h1>
            <p class="text-gray-600">Manage all delivery records and track delivery status</p>
        </div>
        <a href="{{ route('admin.delivery.create') }}"
            class="bg-orange-500 text-white px-5 py-2 rounded font-semibold hover:bg-orange-600 transition">
            + Create Delivery
        </a>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-700 border border-green-300">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="flex border-b">
            <button onclick="filterDeliveries('all')"
                class="filter-tab px-6 py-3 font-medium text-gray-600 hover:text-orange-600 border-b-2 border-orange-600 text-orange-600">
                All
            </button>
            <button onclick="filterDeliveries('ready to deliver')"
                class="filter-tab px-6 py-3 font-medium text-gray-600 hover:text-orange-600 border-b-2 border-transparent">
                Ready to Deliver
            </button>
            <button onclick="filterDeliveries('in transit')"
                class="filter-tab px-6 py-3 font-medium text-gray-600 hover:text-orange-600 border-b-2 border-transparent">
                In Transit
            </button>
            <button onclick="filterDeliveries('delivered')"
                class="filter-tab px-6 py-3 font-medium text-gray-600 hover:text-orange-600 border-b-2 border-transparent">
                Delivered
            </button>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl shadow-lg">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-blue-900 text-white">
                    <th class="px-6 py-3 text-left">Delivery ID</th>
                    <th class="px-6 py-3 text-left">Appointment</th>
                    <th class="px-6 py-3 text-left">Clinic</th>
                    <th class="px-6 py-3 text-left">Address</th>
                    <th class="px-6 py-3 text-left">Rider</th>
                    <th class="px-6 py-3 text-left">Delivery Date</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deliveries as $delivery)
                <tr class="delivery-row border-b hover:bg-gray-50" data-status="{{ $delivery->delivery_status }}">
                    <td class="px-6 py-3 font-semibold text-gray-800">
                        DEL-{{ str_pad($delivery->delivery_id, 5, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-3">
                        <a href="{{ route('admin.appointments.show', $delivery->appointment_id) }}"
                            class="text-blue-600 hover:underline">
                            APT-{{ str_pad($delivery->appointment_id, 5, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td class="px-6 py-3 text-gray-700">
                        {{ $delivery->appointment->caseOrder->clinic->clinic_name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-3 text-gray-700 text-sm">
                        {{ Str::limit($delivery->appointment->caseOrder->clinic->address ?? 'N/A', 30) }}
                    </td>
                    <td class="px-6 py-3 text-gray-700">
                        {{ $delivery->rider->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-600">
                        {{ $delivery->delivery_date ? $delivery->delivery_date->format('M d, Y') : 'Not set' }}
                    </td>
                    <td class="px-6 py-3">
                        <span
                            class="px-2 py-1 text-xs rounded-full font-medium
                            {{ $delivery->delivery_status === 'delivered' ? 'bg-green-100 text-green-800' : 
                               ($delivery->delivery_status === 'in transit' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $delivery->delivery_status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-3">
                        <a href="{{ route('admin.delivery.show', $delivery->delivery_id) }}"
                           class="group relative inline-flex items-center justify-center bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">

      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="w-4 h-4">
                                    <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                                    <path fill-rule="evenodd"
                                        d="M1.38 8.28a.87.87 0 0 1 0-.566 7.003 7.003 0 0 1 13.238.006.87.87 0 0 1 0 .566A7.003 7.003 0 0 1 1.379 8.28ZM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                        clip-rule="evenodd" />
                                </svg> <span
        class="absolute left-1/2 -bottom-8 -translate-x-1/2 whitespace-nowrap bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition pointer-events-none">
        View Details
    </span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-8 text-gray-500">No delivery records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $deliveries->links() }}
    </div>
</div>

<script>
    function filterDeliveries(status) {
    const rows = document.querySelectorAll('.delivery-row');
    const tabs = document.querySelectorAll('.filter-tab');
    
    tabs.forEach(tab => {
        tab.classList.remove('border-orange-600', 'text-orange-600');
        tab.classList.add('border-transparent', 'text-gray-600');
    });
    event.target.classList.add('border-orange-600', 'text-orange-600');
    event.target.classList.remove('border-transparent', 'text-gray-600');
    
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