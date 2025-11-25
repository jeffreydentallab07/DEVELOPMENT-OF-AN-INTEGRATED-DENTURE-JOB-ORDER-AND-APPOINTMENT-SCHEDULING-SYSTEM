@extends('layouts.app')

@section('page-title', 'Case Orders List')

@section('content')
<div class="p-6 space-y-6 bg-gray-300 min-h-screen">

    @if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-700 border border-green-300">
        {{ session('success') }}
    </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form method="GET" action="{{ route('admin.case-orders.index') }}" class="space-y-4">

            <!-- Search Bar -->
            <div class="flex gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by case ID, clinic, patient, or dentist..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search
                </button>
                @if(request()->hasAny(['search', 'status', 'clinic_id', 'case_type', 'date_from', 'date_to']))
                <a href="{{ route('admin.case-orders.index') }}"
                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                    Clear
                </a>
                @endif
            </div>

            <!-- Filters -->
            <details class="group">
                <summary class="cursor-pointer text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2">
                    <svg class="w-5 h-5 transition-transform group-open:rotate-90" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    Advanced Filters
                    @if(request()->hasAny(['status', 'clinic_id', 'case_type', 'date_from', 'date_to']))
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Active</span>
                    @endif
                </summary>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" {{ request('status')===$value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Clinic Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Clinic</label>
                        <select name="clinic_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">All Clinics</option>
                            @foreach($clinics as $clinic)
                            <option value="{{ $clinic->clinic_id }}" {{ request('clinic_id')==$clinic->clinic_id ?
                                'selected' : '' }}>
                                {{ $clinic->clinic_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Case Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Case Type</label>
                        <select name="case_type"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">All Types</option>
                            @foreach($caseTypes as $type)
                            <option value="{{ $type }}" {{ request('case_type')===$type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </details>
        </form>
    </div>

    <!-- Results Summary -->
    <div class="flex justify-between items-center text-sm text-gray-600">
        <div>
            Showing {{ $caseOrders->firstItem() ?? 0 }} to {{ $caseOrders->lastItem() ?? 0 }} of {{ $caseOrders->total()
            }} results
        </div>
        <div>
            Page {{ $caseOrders->currentPage() }} of {{ $caseOrders->lastPage() }}
        </div>
    </div>

    <!-- Table -->
    <div class="rounded-xl shadow-lg">
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
                        'pending' => 'bg-gray-100 text-gray-800',
                        'for appointment' => 'bg-blue-50 text-blue-700',
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
                    <td colspan="8" class="text-center py-8 text-gray-500">
                        @if(request()->hasAny(['search', 'status', 'clinic_id', 'case_type', 'date_from', 'date_to']))
                        No case orders found matching your filters.
                        @else
                        No case orders found.
                        @endif
                    </td>
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