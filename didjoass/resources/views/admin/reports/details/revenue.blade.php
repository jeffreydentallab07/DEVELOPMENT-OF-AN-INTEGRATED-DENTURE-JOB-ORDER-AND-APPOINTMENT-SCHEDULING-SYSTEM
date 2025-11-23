@extends('layouts.app')

@section('page-title', 'Revenue Report - Detailed Breakdown')

@section('content')
<div class="p-6 space-y-6 bg-gray-300 min-h-screen">

    <div class="flex justify-between items-center">
        <div>
            <a href="{{ route('admin.reports.index', ['type' => 'revenue', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                class="text-green-600 hover:underline mb-2 inline-block">
                ← Back to Reports
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Revenue - Detailed Breakdown</h1>
            <p class="text-gray-600">Period: {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} - {{
                \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}</p>
        </div>
       <div class="relative group inline-block">
    <button onclick="exportDetailPDF()" 
        class="bg-red-600 text-white px-5 py-2 rounded font-semibold hover:bg-red-700 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
        </svg>
    </button>
    
    <span class="absolute top-full mt-2 left-1/2 transform -translate-x-1/2 px-2 py-1 text-sm rounded bg-gray-800 text-white opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
        Export Detailed PDF
    </span>
</div>

    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Financial Overview</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="text-center p-4 bg-green-50 rounded-lg border-2 border-green-200 transform transition duration-300 hover:-translate-y-2 hover:shadow-2xl">
            <h3 class="text-sm text-gray-600">Total Revenue (Paid)</h3>
            <p class="text-4xl font-bold text-green-600 mt-2">₱{{ number_format($data['total_revenue'], 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">Collected payments</p>
        </div>
        <div class="text-center p-4 bg-yellow-50 rounded-lg border-2 border-yellow-200 transform transition duration-300 hover:-translate-y-2 hover:shadow-2xl">
            <h3 class="text-sm text-gray-600">Pending Payment</h3>
            <p class="text-4xl font-bold text-yellow-600 mt-2">₱{{ number_format($data['pending_revenue'], 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">Awaiting payment</p>
        </div>
        <div class="text-center p-4 bg-orange-50 rounded-lg border-2 border-orange-200 transform transition duration-300 hover:-translate-y-2 hover:shadow-2xl">
            <h3 class="text-sm text-gray-600">Partial Payment</h3>
            <p class="text-4xl font-bold text-orange-600 mt-2">₱{{ number_format($data['partial_revenue'], 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">Partially paid</p>
        </div>
        <div class="text-center p-4 bg-blue-50 rounded-lg border-2 border-blue-200 transform transition duration-300 hover:-translate-y-2 hover:shadow-2xl">
            <h3 class="text-sm text-gray-600">Total Expected</h3>
            <p class="text-4xl font-bold text-blue-600 mt-2">₱{{ number_format($data['total_revenue'] +
                $data['pending_revenue'] + $data['partial_revenue'], 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">All billings</p>
        </div>
    </div>
</div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Payment Status Distribution</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
            <div>
                @php
                $totalBillings = $data['billings']->count();
                $paidCount = $data['billings']->where('payment_status', 'paid')->count();
                $unpaidCount = $data['billings']->where('payment_status', 'unpaid')->count();
                $partialCount = $data['billings']->where('payment_status', 'partial')->count();
                @endphp
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Paid Billings</span>
                        <span class="text-sm font-bold text-green-600">{{ $paidCount }} ({{ $totalBillings > 0 ?
                            number_format(($paidCount/$totalBillings)*100, 1) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-6">
                        <div class="bg-green-500 h-6 rounded-full flex items-center justify-end pr-2"
                            style="width: {{ $totalBillings > 0 ? ($paidCount/$totalBillings)*100 : 0 }}%">
                            <span class="text-xs text-white font-bold">₱{{ number_format($data['total_revenue'], 0)
                                }}</span>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Unpaid Billings</span>
                        <span class="text-sm font-bold text-yellow-600">{{ $unpaidCount }} ({{ $totalBillings > 0 ?
                            number_format(($unpaidCount/$totalBillings)*100, 1) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-6">
                        <div class="bg-yellow-500 h-6 rounded-full flex items-center justify-end pr-2"
                            style="width: {{ $totalBillings > 0 ? ($unpaidCount/$totalBillings)*100 : 0 }}%">
                            <span class="text-xs text-white font-bold">₱{{ number_format($data['pending_revenue'], 0)
                                }}</span>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Partial Billings</span>
                        <span class="text-sm font-bold text-orange-600">{{ $partialCount }} ({{ $totalBillings > 0 ?
                            number_format(($partialCount/$totalBillings)*100, 1) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-6">
                        <div class="bg-orange-500 h-6 rounded-full flex items-center justify-end pr-2"
                            style="width: {{ $totalBillings > 0 ? ($partialCount/$totalBillings)*100 : 0 }}%">
                            <span class="text-xs text-white font-bold">₱{{ number_format($data['partial_revenue'], 0)
                                }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center">
                <div class="text-center">
                    @php
                    $totalExpected = $data['total_revenue'] + $data['pending_revenue'] + $data['partial_revenue'];
                    $collectionRate = $totalExpected > 0 ? ($data['total_revenue'] / $totalExpected) * 100 : 0;
                    @endphp
                    <div class="relative inline-block">
                        <svg class="w-48 h-48">
                            <circle cx="96" cy="96" r="80" fill="none" stroke="#e5e7eb" stroke-width="16" />
                            <circle cx="96" cy="96" r="80" fill="none" stroke="#10b981" stroke-width="16"
                                stroke-dasharray="{{ 2 * 3.14159 * 80 }}"
                                stroke-dashoffset="{{ 2 * 3.14159 * 80 * (1 - $collectionRate/100) }}"
                                transform="rotate(-90 96 96)" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div>
                                <p class="text-4xl font-bold text-green-600">{{ number_format($collectionRate, 1) }}%
                                </p>
                                <p class="text-xs text-gray-500">Collection Rate</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Payment collection efficiency</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Monthly Revenue Trend</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Month</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visual Trend</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                    $maxRevenue = $data['revenue_by_month']->max('total');
                    @endphp
                    @foreach($data['revenue_by_month'] as $month)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-800">
                            {{ date('F Y', mktime(0, 0, 0, $month->month, 1, $month->year)) }}
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-green-600">₱{{ number_format($month->total, 2) }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-4">
                                    <div class="bg-gradient-to-r from-green-400 to-green-600 h-4 rounded-full"
                                        style="width: {{ $maxRevenue > 0 ? ($month->total / $maxRevenue) * 100 : 0 }}%">
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $maxRevenue > 0 ? number_format(($month->total /
                                    $maxRevenue) * 100, 0) : 0 }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">All Billing Records ({{
            $data['billings']->count() }})</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-blue-900">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Billing ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Clinic</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Payment Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Payment Method</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($data['billings'] as $billing)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-semibold text-blue-600">
                            <a href="{{ route('admin.billing.show', $billing->id) }}" class="hover:underline">
                                BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{
                            $billing->appointment->caseOrder->clinic->clinic_name }}</td>
                        <td class="px-4 py-3 text-sm font-bold text-green-600">₱{{ number_format($billing->total_amount,
                            2) }}</td>
                        <td class="px-4 py-3">
                            <span
                                class="px-2 py-1 text-xs rounded-full font-medium
                                {{ $billing->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                                   ($billing->payment_status === 'partial' ? 'bg-orange-100 text-orange-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($billing->payment_status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $billing->payment_method ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $billing->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.billing.show', $billing->id) }}"
                                class="text-blue-600 hover:underline text-xs">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-green-50">
                    <tr>
                        <td colspan="2" class="px-4 py-3 text-sm font-bold text-gray-800 text-right">Total Revenue
                            (Paid):</td>
                        <td colspan="5" class="px-4 py-3 text-lg font-bold text-green-600">₱{{
                            number_format($data['total_revenue'], 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg shadow-lg p-6">
       <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v7.5m2.25-6.466a9.016 9.016 0 0 0-3.461-.203c-.536.072-.974.478-1.021 1.017a4.559 4.559 0 0 0-.018.402c0 .464.336.844.775.994l2.95 1.012c.44.15.775.53.775.994 0 .136-.006.27-.018.402-.047.539-.485.945-1.021 1.017a9.077 9.077 0 0 1-3.461-.203M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
</svg>

  Financial Insights
</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">Average Billing Amount</h3>
                <p class="text-2xl font-bold text-blue-600">
                    ₱{{ $data['billings']->count() > 0 ? number_format($data['billings']->sum('total_amount') /
                    $data['billings']->count(), 2) : '0.00' }}
                </p>
            </div>
            <div class="bg-white p-4 rounded-lg">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">Highest Single Billing</h3>
                <p class="text-2xl font-bold text-purple-600">
                    ₱{{ number_format($data['billings']->max('total_amount') ?? 0, 2) }}
                </p>
            </div>
            <div class="bg-white p-4 rounded-lg">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">Outstanding Receivables</h3>
                <p class="text-2xl font-bold text-orange-600">
                    ₱{{ number_format($data['pending_revenue'] + $data['partial_revenue'], 2) }}
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function exportDetailPDF() {
    const params = new URLSearchParams({
        date_from: '{{ $dateFrom }}',
        date_to: '{{ $dateTo }}'
    });
    
    // Open print preview page in new tab
    const printUrl = '{{ route("admin.reports.printRevenueDetail") }}?' + params.toString();
    window.open(printUrl, '_blank');
}
</script>
@endsection