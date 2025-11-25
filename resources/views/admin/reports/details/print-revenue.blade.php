<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Detail Report</title>
    <link rel="icon" href="{{ asset('images/logo3.ico') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .page-break {
                page-break-after: always;
            }
        }

        #pdf-loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        #pdf-loading .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="bg-white">

    <!-- Print Controls -->
    <div class="no-print fixed top-0 left-0 right-0 bg-gray-800 text-white px-6 py-4 shadow-lg z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-lg font-bold">Revenue Report Preview</h1>
                <p class="text-sm text-gray-300">{{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} - {{
                    \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}</p>
            </div>
            <div class="flex gap-3">
                <!-- Download PDF Button -->
                <button onclick="downloadPDF()"
                    class="bg-green-600 hover:bg-green-700 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Download PDF
                </button>

                <!-- Print Button -->
                <button onclick="window.print()"
                    class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Print
                </button>

                <!-- Close Button -->
                <button onclick="window.history.back()"
                    class="bg-gray-600 hover:bg-gray-700 px-6 py-2 rounded-lg font-semibold transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Report Content -->
    <div id="report-content" class="max-w-7xl mx-auto p-8" style="margin-top: 80px;">

        <!-- Report Header -->
        <div class="text-center mb-8 pb-6 border-b-2 border-gray-300">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ config('app.name', 'Denture Lab') }}</h1>
            <h2 class="text-xl font-semibold text-gray-700 mb-1">Revenue - Detailed Breakdown</h2>
            <p class="text-gray-600">Period: {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} - {{
                \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}</p>
            <p class="text-sm text-gray-500 mt-2">Generated on: {{ now()->format('M d, Y h:i A') }}</p>
        </div>

        <!-- Financial Overview -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 pb-2">Financial Overview</h2>
            <div class="grid grid-cols-4 gap-4">
                <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                    <h3 class="text-sm text-gray-600 font-medium">Total Revenue (Paid)</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">₱{{ number_format($data['total_revenue'], 2) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Collected payments</p>
                </div>
                <div class="text-center p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <h3 class="text-sm text-gray-600 font-medium">Pending Payment</h3>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">₱{{ number_format($data['pending_revenue'], 2) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Awaiting payment</p>
                </div>
                <div class="text-center p-4 bg-orange-50 rounded-lg border border-orange-200">
                    <h3 class="text-sm text-gray-600 font-medium">Partial Payment</h3>
                    <p class="text-3xl font-bold text-orange-600 mt-2">₱{{ number_format($data['partial_revenue'], 2) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Partially paid</p>
                </div>
                <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="text-sm text-gray-600 font-medium">Total Expected</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">₱{{ number_format($data['total_revenue'] +
                        $data['pending_revenue'] + $data['partial_revenue'], 2) }}</p>
                    <p class="text-xs text-gray-500 mt-1">All billings</p>
                </div>
            </div>
        </div>

        <!-- Payment Status Distribution -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 pb-2">Payment Status Distribution</h2>
            @php
            $totalBillings = $data['billings']->count();
            $paidCount = $data['billings']->where('payment_status', 'paid')->count();
            $unpaidCount = $data['billings']->where('payment_status', 'unpaid')->count();
            $partialCount = $data['billings']->where('payment_status', 'partial')->count();
            $totalExpected = $data['total_revenue'] + $data['pending_revenue'] + $data['partial_revenue'];
            $collectionRate = $totalExpected > 0 ? ($data['total_revenue'] / $totalExpected) * 100 : 0;
            @endphp
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Paid Billings</span>
                            <span class="text-sm font-bold text-green-600">{{ $paidCount }} ({{ $totalBillings > 0 ?
                                number_format(($paidCount/$totalBillings)*100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-6">
                            <div class="bg-green-500 h-6 rounded-full"
                                style="width: {{ $totalBillings > 0 ? ($paidCount/$totalBillings)*100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Unpaid Billings</span>
                            <span class="text-sm font-bold text-yellow-600">{{ $unpaidCount }} ({{ $totalBillings > 0 ?
                                number_format(($unpaidCount/$totalBillings)*100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-6">
                            <div class="bg-yellow-500 h-6 rounded-full"
                                style="width: {{ $totalBillings > 0 ? ($unpaidCount/$totalBillings)*100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Partial Billings</span>
                            <span class="text-sm font-bold text-orange-600">{{ $partialCount }} ({{ $totalBillings > 0 ?
                                number_format(($partialCount/$totalBillings)*100, 1) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-6">
                            <div class="bg-orange-500 h-6 rounded-full"
                                style="width: {{ $totalBillings > 0 ? ($partialCount/$totalBillings)*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div
                        class="text-center border-4 border-green-500 rounded-full w-48 h-48 flex items-center justify-center">
                        <div>
                            <p class="text-5xl font-bold text-green-600">{{ number_format($collectionRate, 1) }}%</p>
                            <p class="text-sm text-gray-600 mt-2">Collection Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 10 Revenue Generating Clinics -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 pb-2">Top 10 Revenue Generating Clinics</h2>
            <table class="min-w-full border border-gray-300">
                <thead class="bg-green-900 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase border-r border-green-800">Rank
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase border-r border-green-800">Clinic
                            Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase border-r border-green-800">Total
                            Revenue</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase">% of Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['revenue_by_clinic'] as $index => $clinicRevenue)
                    <tr
                        class="border-b border-gray-200 {{ $loop->index < 3 ? 'bg-green-50' : ($loop->index % 2 === 0 ? 'bg-gray-50' : 'bg-white') }}">
                        <td class="px-4 py-3 border-r border-gray-200">
                            @if($loop->index === 0)
                            <span class="text-xl">🥇</span>
                            @elseif($loop->index === 1)
                            <span class="text-xl">🥈</span>
                            @elseif($loop->index === 2)
                            <span class="text-xl">🥉</span>
                            @else
                            <span class="font-semibold text-gray-600">{{ $loop->iteration }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800 border-r border-gray-200">{{ $index }}
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-green-600 border-r border-gray-200">₱{{
                            number_format($clinicRevenue, 2) }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-700">{{ $data['total_revenue'] > 0 ?
                            number_format(($clinicRevenue / $data['total_revenue']) * 100, 1) : 0 }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Monthly Revenue Trend -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 pb-2">Monthly Revenue Trend</h2>
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase border-r border-gray-300">
                            Month</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['revenue_by_month'] as $month)
                    <tr class="border-b border-gray-200">
                        <td class="px-4 py-3 text-sm font-medium text-gray-800 border-r border-gray-200">{{ date('F Y',
                            mktime(0, 0, 0, $month->month, 1, $month->year)) }}</td>
                        <td class="px-4 py-3 text-sm font-bold text-green-600">₱{{ number_format($month->total, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- All Billing Records -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 pb-2">All Billing Records ({{
                $data['billings']->count() }})</h2>
            <table class="min-w-full border border-gray-300 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase border-r border-gray-300">
                            Billing ID</th>
                        <th
                            class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase border-r border-gray-300">
                            Clinic</th>
                        <th
                            class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase border-r border-gray-300">
                            Amount</th>
                        <th
                            class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase border-r border-gray-300">
                            Status</th>
                        <th
                            class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase border-r border-gray-300">
                            Payment Method</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['billings'] as $billing)
                    <tr class="border-b border-gray-200">
                        <td class="px-3 py-2 font-semibold text-blue-600 border-r border-gray-200">BILL-{{
                            str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-3 py-2 text-gray-700 border-r border-gray-200">{{
                            $billing->appointment->caseOrder->clinic->clinic_name }}</td>
                        <td class="px-3 py-2 font-bold text-green-600 border-r border-gray-200">₱{{
                            number_format($billing->total_amount, 2) }}</td>
                        <td class="px-3 py-2 border-r border-gray-200">
                            <span
                                class="px-2 py-1 text-xs rounded-full font-medium {{ $billing->payment_status === 'paid' ? 'bg-green-100 text-green-800' : ($billing->payment_status === 'partial' ? 'bg-orange-100 text-orange-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($billing->payment_status) }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-gray-700 border-r border-gray-200">{{ $billing->payment_method ??
                            'N/A' }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ $billing->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-green-50">
                    <tr>
                        <td colspan="2" class="px-3 py-3 text-sm font-bold text-gray-800 text-right">Total Revenue
                            (Paid):</td>
                        <td colspan="4" class="px-3 py-3 text-lg font-bold text-green-600">₱{{
                            number_format($data['total_revenue'], 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Financial Insights -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 pb-2">💰 Financial Insights</h2>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Average Billing Amount</h3>
                    <p class="text-2xl font-bold text-blue-600">₱{{ $data['billings']->count() > 0 ?
                        number_format($data['billings']->sum('total_amount') / $data['billings']->count(), 2) : '0.00'
                        }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Highest Single Billing</h3>
                    <p class="text-2xl font-bold text-purple-600">₱{{
                        number_format($data['billings']->max('total_amount') ?? 0, 2) }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Outstanding Receivables</h3>
                    <p class="text-2xl font-bold text-orange-600">₱{{ number_format($data['pending_revenue'] +
                        $data['partial_revenue'], 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 pt-6 border-t-2 border-gray-300 text-center text-sm text-gray-600">
            <p class="font-medium">This is an official report generated by {{ config('app.name', 'Denture Lab') }}</p>
            <p class="mt-1">For inquiries, please contact the administration office.</p>
        </div>
    </div>
</body>
<script>
    function downloadPDF() {
            const element = document.getElementById('report-content');
            const dateFrom = '{{ $dateFrom }}';
            const dateTo = '{{ $dateTo }}';

            // Show loading
            const loading = document.createElement('div');
            loading.id = 'pdf-loading';
            loading.innerHTML = `
                <div style="background: white; padding: 30px; border-radius: 10px; text-align: center;">
                    <div class="spinner" style="margin: 0 auto 15px;"></div>
                    <p style="margin: 0; font-size: 16px; color: #333;">Generating PDF...</p>
                </div>
            `;
            document.body.appendChild(loading);

            const filename = `revenue-detail-report-${dateFrom}-to-${dateTo}.pdf`;

            const opt = {
                margin: [5, 5, 5, 5],
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    letterRendering: true,
                    logging: false
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
            };

            // Temporarily remove top margin for PDF
            element.style.marginTop = '0';

            html2pdf()
                .set(opt)
                .from(element)
                .save()
                .then(() => {
                    element.style.marginTop = '80px';
                    document.getElementById('pdf-loading')?.remove();
                })
                .catch((err) => {
                    console.error('PDF Error:', err);
                    element.style.marginTop = '80px';
                    document.getElementById('pdf-loading')?.remove();
                    alert('Failed to generate PDF. Please try again.');
                });
        }

        // Auto-download if flag is set
        @if(isset($autoDownload) && $autoDownload)
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(downloadPDF, 500);
        });
        @endif
</script>

</html>