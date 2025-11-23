@extends('layouts.app')

@section('page-title', 'Case Orders List')

@section('content')
<div class="p-6 space-y-6 bg-gray-300 min-h-screen">

    @if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-700 border border-green-300">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto rounded-xl shadow-lg mt-4">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-blue-900 text-white">
                    <th class="px-6 py-3 text-left">Case No.</th>
                    <th class="px-6 py-3 text-left">Clinic</th>
                    <th class="px-6 py-3 text-left">Patient</th>
                    <th class="px-6 py-3 text-left">Dentist</th>
                    <th class="px-6 py-3 text-left">Case Type</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Created</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($caseOrders as $caseOrder)
                <tr class="text-gray-700 text-sm hover:bg-gray-50">
                    <td class="px-6 py-3">
                        <a href="{{ route('admin.case-orders.show', $caseOrder->co_id) }}"
                            class="text-blue-600 hover:underline font-semibold">
                            {{ 'CASE-' . str_pad($caseOrder->co_id, 5, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td class="px-6 py-3">{{ $caseOrder->clinic->clinic_name ?? 'N/A' }}</td>
                    <td class="px-6 py-3">{{ $caseOrder->patient->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3">
                        {{ $caseOrder->dentist ? 'Dr. ' . $caseOrder->dentist->name : 'N/A' }}
                    </td>
                    <td class="px-6 py-3">{{ $caseOrder->case_type }}</td>
                    <td class="px-6 py-3">
                        @php
                        $statusColors = [
                        'pending' => 'bg-gray-100 text-gray-800', 'for appointment' => 'bg-blue-50 text-blue-700',
                        'in progress' => 'bg-blue-100 text-blue-800',
                        'under review' => 'bg-purple-100 text-purple-800',
                        'adjustment requested' => 'bg-orange-100 text-orange-800',
                        'revision in progress' => 'bg-yellow-100 text-yellow-800',
                        'completed' => 'bg-green-100 text-green-800',
                        ];
                        @endphp

                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$caseOrder->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($caseOrder->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-xs text-gray-500">
                        {{ $caseOrder->created_at->format('M d, Y') }}
                    </td>
                   <td class="px-6 py-3 text-center">
    <a href="{{ route('admin.case-orders.show', $caseOrder->co_id) }}"
        class="group relative inline-flex items-center justify-center bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">

       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="w-4 h-4">
                                    <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                                    <path fill-rule="evenodd"
                                        d="M1.38 8.28a.87.87 0 0 1 0-.566 7.003 7.003 0 0 1 13.238.006.87.87 0 0 1 0 .566A7.003 7.003 0 0 1 1.379 8.28ZM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                        clip-rule="evenodd" />
                                </svg>

        <span
            class="absolute left-1/2 -bottom-8 -translate-x-1/2 whitespace-nowrap bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition pointer-events-none">
            View Details
        </span>
    </a>
</td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-8 text-gray-500">No case orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $caseOrders->links() }}
    </div>
</div>
@endsection