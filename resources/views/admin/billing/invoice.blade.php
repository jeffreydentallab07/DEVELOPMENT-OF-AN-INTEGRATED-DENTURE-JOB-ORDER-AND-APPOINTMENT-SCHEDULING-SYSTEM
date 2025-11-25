<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}</title>
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

<body class="bg-gray-300 p-8">

    <div class="no-print max-w-4xl mx-auto mb-4 flex justify-end gap-3">
        <button onclick="downloadPDF()"
            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Download PDF
        </button>
        <button onclick="window.print()"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print Invoice
        </button>
        <button onclick="window.history.back()"
            class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
            Close
        </button>
    </div>

    <div id="invoice-content" class="max-w-4xl mx-auto bg-white shadow-lg">

        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-8">
            <div class="flex justify-between items-start">
                <div>
                    <img src="{{ asset('images/logo2.png') }}" alt="Jeffrey Dental Lab" class="h-16 mb-3">
                    <h1 class="text-3xl font-bold">Jeffrey Dental Laboratory</h1>
                    <p class="text-blue-100 text-sm mt-2">Cagayan de Oro City, Philippines</p>
                    <p class="text-blue-100 text-sm">Contact: 09067732353</p>
                    <p class="text-blue-100 text-sm">Email: <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                            data-cfemail="731916151501160a17161d07121f1f1211434433141e121a1f5d101c1e">[email&#160;protected]</a>
                        .com</p>
                </div>
                <div class="text-right">
                    <h2 class="text-2xl font-bold">INVOICE</h2>
                    <p class="text-xl font-semibold mt-2">BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm text-blue-100 mt-2">Date: {{ $billing->created_at->format('M d, Y') }}</p>
                    <p class="text-sm text-blue-100">Due Date: {{ $billing->created_at->addDays(30)->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="p-8 grid grid-cols-2 gap-8 border-b-2">
            <div>
                <h3 class="text-sm font-bold text-gray-600 uppercase mb-3">Bill To:</h3>
                <div class="text-gray-800">
                    <p class="font-bold text-lg">{{ $billing->appointment->caseOrder->clinic->clinic_name }}</p>
                    <p class="text-sm mt-1">{{ $billing->appointment->caseOrder->clinic->address }}</p>
                    <p class="text-sm mt-1">{{ $billing->appointment->caseOrder->clinic->email }}</p>
                    <p class="text-sm">{{ $billing->appointment->caseOrder->clinic->contact_number }}</p>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-600 uppercase mb-3">Payment Information:</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Case Order:</span>
                        <span class="font-semibold">CASE-{{ str_pad($billing->appointment->case_order_id, 5, '0',
                            STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Appointment:</span>
                        <span class="font-semibold">APT-{{ str_pad($billing->appointment_id, 5, '0', STR_PAD_LEFT)
                            }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Payment Status:</span>
                        <span
                            class="px-2 py-1 rounded text-xs font-semibold
                            {{ $billing->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                               ($billing->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($billing->payment_status) }}
                        </span>
                    </div>
                    @if($billing->payment_method)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-semibold">{{ $billing->payment_method }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-8 border-b-2 bg-gray-50">
            <h3 class="text-sm font-bold text-gray-600 uppercase mb-3">Case Details:</h3>
            <div class="grid grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Patient:</span>
                    <p class="font-semibold">{{ $billing->appointment->caseOrder->patient->name }}</p>
                </div>
                <div>
                    <span class="text-gray-600">Case Type:</span>
                    <p class="font-semibold">{{ ucfirst($billing->appointment->caseOrder->case_type) }}</p>
                </div>
                <div>
                    <span class="text-gray-600">Technician:</span>
                    <p class="font-semibold">{{ $billing->appointment->technician->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <h3 class="text-sm font-bold text-gray-600 uppercase mb-4">Materials & Services:</h3>

            <table class="w-full">
                <thead class="bg-gray-100 border-b-2">
                    <tr>
                        <th class="text-left p-3 text-sm font-semibold text-gray-700">Description</th>
                        <th class="text-center p-3 text-sm font-semibold text-gray-700">Qty</th>
                        <th class="text-right p-3 text-sm font-semibold text-gray-700">Unit Price</th>
                        <th class="text-right p-3 text-sm font-semibold text-gray-700">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @if($billing->appointment->materialUsages->count() > 0)
                    @foreach($billing->appointment->materialUsages as $usage)
                    <tr>
                        <td class="p-3 text-sm text-gray-800">{{ $usage->material->material_name }}</td>
                        <td class="p-3 text-sm text-center text-gray-800">{{ $usage->quantity_used }}</td>
                        <td class="p-3 text-sm text-right text-gray-800">₱{{
                            number_format($usage->material->price, 2) }}</td>
                        <td class="p-3 text-sm text-right font-medium text-gray-800">₱{{
                            number_format($usage->quantity_used * $usage->material->price, 2) }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="p-3 text-sm text-gray-600 text-center italic">No materials recorded</td>
                    </tr>
                    @endif

                    <!-- Labor & Services -->
                    @php
                    $laborCost = $billing->total_amount - $billing->appointment->total_material_cost;
                    @endphp
                    @if($laborCost > 0)
                    <tr class="bg-gray-50">
                        <td class="p-3 text-sm text-gray-800">Labor & Professional Services</td>
                        <td class="p-3 text-sm text-center text-gray-800">1</td>
                        <td class="p-3 text-sm text-right text-gray-800">₱{{ number_format($laborCost, 2) }}</td>
                        <td class="p-3 text-sm text-right font-medium text-gray-800">₱{{ number_format($laborCost, 2) }}
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="px-8 pb-8">
            <div class="flex justify-end">
                <div class="w-80">
                    <div class="space-y-2 border-t-2 pt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal (Materials):</span>
                            <span class="font-semibold">₱{{ number_format($billing->appointment->total_material_cost, 2)
                                }}</span>
                        </div>
                        @if($laborCost > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Labor & Services:</span>
                            <span class="font-semibold">₱{{ number_format($laborCost, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-lg font-bold pt-3 border-t-2">
                            <span class="text-gray-800">Total Amount:</span>
                            <span class="text-blue-600">₱{{ number_format($billing->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($billing->notes)
        <div class="px-8 pb-8 border-t-2">
            <h3 class="text-sm font-bold text-gray-600 uppercase mb-3 mt-4">Notes:</h3>
            <p class="text-sm text-gray-700 whitespace-pre-line bg-gray-50 p-4 rounded">{{ $billing->notes }}</p>
        </div>
        @endif

        <div class="bg-gray-100 p-8 text-sm text-gray-600">
            <h3 class="font-bold text-gray-800 mb-3">Payment Terms:</h3>
            <ul class="space-y-1 list-disc list-inside">
                <li>Payment is due within 30 days of invoice date</li>
                <li>Accepted payment methods: Cash, Bank Transfer, Credit Card, GCash, PayMaya</li>
                <li>Late payments may incur additional charges</li>
            </ul>

            <div class="mt-6 pt-6 border-t border-gray-300 text-center">
                <p class="font-semibold text-gray-800">Thank you for your business!</p>
                <p class="text-xs mt-2">For inquiries, please contact us at jeffreydentallab07@gmail.com</p>
            </div>
        </div>

    </div>

</body>
<script>
    function downloadPDF() {
        const element = document.getElementById('invoice-content');
        const billingId = '{{ str_pad($billing->id, 5, "0", STR_PAD_LEFT) }}';

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

        const filename = `invoice-BILL-${billingId}.pdf`;

        const opt = {
            margin: [0, 1, 2, 3],
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
                format: 'legal',
                orientation: 'portrait'
            },
            pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
        };

        html2pdf()
            .set(opt)
            .from(element)
            .save()
            .then(() => {
                document.getElementById('pdf-loading')?.remove();
            })
            .catch((err) => {
                console.error('PDF Error:', err);
                document.getElementById('pdf-loading')?.remove();
                alert('Failed to generate PDF. Please try again.');
            });
    }
</script>

</html>