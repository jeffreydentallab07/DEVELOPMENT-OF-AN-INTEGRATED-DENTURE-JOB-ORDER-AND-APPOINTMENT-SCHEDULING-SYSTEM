<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst(str_replace('-', ' ', $reportType)) }} Report - {{ $dateFrom }} to {{ $dateTo }}</title>
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

    <!-- Print Controls (Hidden when printing) -->
    <div class="no-print fixed top-0 left-0 right-0 bg-gray-800 text-white px-6 py-4 shadow-lg z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-lg font-bold">Report Preview</h1>
                <p class="text-sm text-gray-300">{{ ucfirst(str_replace('-', ' ', $reportType)) }} Report</p>
            </div>
            <div class="flex gap-3">
                <!-- Download as PDF Button -->
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
                <button onclick="window.close()"
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
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                {{ config('app.name', 'Denture Lab') }}
            </h1>
            <h2 class="text-xl font-semibold text-gray-700 mb-1">
                {{ ucfirst(str_replace('-', ' ', $reportType)) }} Report
            </h2>
            <p class="text-gray-600">
                Period: {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} - {{
                \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
            </p>
            <p class="text-sm text-gray-500 mt-2">
                Generated on: {{ now()->format('M d, Y h:i A') }}
            </p>
        </div>

        <!-- Report Data -->
        @if($reportType === 'overview')
        @include('admin.reports.partials.overview', ['data' => $data])
        @elseif($reportType === 'case-orders')
        @include('admin.reports.partials.case-orders', ['data' => $data])
        @elseif($reportType === 'revenue')
        @include('admin.reports.partials.revenue', ['data' => $data])
        @elseif($reportType === 'materials')
        @include('admin.reports.partials.materials', ['data' => $data])
        @elseif($reportType === 'clinic-performance')
        @include('admin.reports.partials.clinic-performance', ['data' => $data])
        @elseif($reportType === 'technician-performance')
        @include('admin.reports.partials.technician-performance', ['data' => $data])
        @elseif($reportType === 'delivery-performance')
        @include('admin.reports.partials.delivery-performance', ['data' => $data])
        @endif

        <!-- Report Footer -->
        <div class="mt-12 pt-6 border-t-2 border-gray-300 text-center text-sm text-gray-600">
            <p>This is an official report generated by {{ config('app.name', 'Denture Lab') }}</p>
            <p class="mt-1">For inquiries, please contact the administration office.</p>
        </div>
    </div>

    <script>
        function downloadPDF() {
            const element = document.getElementById('report-content');
            const reportType = '{{ $reportType }}';
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

            // Determine orientation based on report type
            const landscapeReports = ['clinic-performance', 'technician-performance', 'delivery-performance', 'case-orders'];
            const isLandscape = landscapeReports.includes(reportType);

            const filename = `${reportType}-report-${dateFrom}-to-${dateTo}.pdf`;

            const opt = {
                margin: [10, 10, 10, 10],
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
                    format: isLandscape ? 'a3' : 'a4',
                    orientation: isLandscape ? 'landscape' : 'portrait'
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

</body>

</html>