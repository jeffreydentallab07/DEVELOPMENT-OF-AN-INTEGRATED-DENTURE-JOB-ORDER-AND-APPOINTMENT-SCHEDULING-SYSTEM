<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ ucfirst(str_replace('-', ' ', $reportType)) }} Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #1f2937;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .report-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #d1d5db;
        }

        .report-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .report-header h2 {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 4px;
        }

        .report-header p {
            color: #6b7280;
            font-size: 10px;
            margin-top: 8px;
        }

        /* Summary Grid */
        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }

        .summary-row {
            display: table-row;
        }

        .summary-card {
            display: table-cell;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin: 5px;
            width: 33.33%;
            vertical-align: top;
        }

        .summary-card h3 {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #3b82f6;
        }

        .stat-item {
            display: block;
            padding: 8px 0;
        }

        .stat-label {
            color: #6b7280;
            font-size: 10px;
            display: inline-block;
            width: 60%;
        }

        .stat-value {
            font-weight: bold;
            color: #1f2937;
            font-size: 11px;
            display: inline-block;
            width: 38%;
            text-align: right;
        }

        .stat-value.primary {
            color: #3b82f6;
            font-size: 13px;
        }

        .stat-value.success {
            color: #10b981;
        }

        .stat-value.warning {
            color: #f59e0b;
        }

        .stat-value.danger {
            color: #ef4444;
        }

        /* Section Styles */
        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }

        thead {
            background: #3b82f6;
            color: white;
        }

        th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 9px;
            text-transform: uppercase;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        tbody tr:hover {
            background: #f3f4f6;
        }

        /* Footer */
        .report-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #d1d5db;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }

        .report-footer p {
            margin: 4px 0;
        }

        /* Chart Labels */
        .chart-label {
            display: inline-block;
            padding: 4px 8px;
            background: #eff6ff;
            border-radius: 4px;
            margin: 2px;
            font-size: 9px;
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Page Break */
        .page-break {
            page-break-after: always;
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .mb-4 {
            margin-bottom: 16px;
        }

        .mt-4 {
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Report Header -->
        <div class="report-header">
            <h1>{{ config('app.name', 'Jeffrey Dental Lab') }}</h1>
            <h2>{{ ucfirst(str_replace('-', ' ', $reportType)) }} Report</h2>
            <p>
                Period: {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} - {{
                \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
            </p>
            <p>
                Generated on: {{ $generatedAt }}
            </p>
        </div>

        <!-- Report Data -->
        @if($reportType === 'overview')
        <!-- Overview Report -->
        <div class="section">
            <table style="width: 100%; margin-bottom: 0;">
                <tr>
                    <td style="width: 33.33%; vertical-align: top; padding: 10px; border: none;">
                        <div class="summary-card" style="display: block; margin: 0;">
                            <h3>Case Orders Summary</h3>
                            <div class="stat-item">
                                <span class="stat-label">Total Cases:</span>
                                <span class="stat-value primary">{{ $data['total_case_orders'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Completed:</span>
                                <span class="stat-value success">{{ $data['completed_cases'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Pending:</span>
                                <span class="stat-value warning">{{ $data['pending_cases'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td style="width: 33.33%; vertical-align: top; padding: 10px; border: none;">
                        <div class="summary-card" style="display: block; margin: 0;">
                            <h3>Revenue Summary</h3>
                            <div class="stat-item">
                                <span class="stat-label">Total Revenue:</span>
                                <span class="stat-value primary">₱{{ number_format($data['total_revenue'], 2) }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Pending Revenue:</span>
                                <span class="stat-value warning">₱{{ number_format($data['pending_revenue'], 2)
                                    }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Completion Rate:</span>
                                <span class="stat-value success">
                                    {{ $data['total_case_orders'] > 0 ? number_format(($data['completed_cases'] /
                                    $data['total_case_orders'] * 100), 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    </td>
                    <td style="width: 33.33%; vertical-align: top; padding: 10px; border: none;">
                        <div class="summary-card" style="display: block; margin: 0;">
                            <h3>Appointments Summary</h3>
                            <div class="stat-item">
                                <span class="stat-label">Total Appointments:</span>
                                <span class="stat-value primary">{{ $data['total_appointments'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Completed:</span>
                                <span class="stat-value success">{{ $data['completed_appointments'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Completion Rate:</span>
                                <span class="stat-value success">
                                    {{ $data['total_appointments'] > 0 ? number_format(($data['completed_appointments']
                                    / $data['total_appointments'] * 100), 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section mt-4">
            <table style="width: 100%; margin-bottom: 0;">
                <tr>
                    <td style="width: 33.33%; vertical-align: top; padding: 10px; border: none;">
                        <div class="summary-card" style="display: block; margin: 0;">
                            <h3>Delivery Summary</h3>
                            <div class="stat-item">
                                <span class="stat-label">Total Deliveries:</span>
                                <span class="stat-value primary">{{ $data['total_deliveries'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Completed:</span>
                                <span class="stat-value success">{{ $data['completed_deliveries'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Completion Rate:</span>
                                <span class="stat-value success">
                                    {{ $data['total_deliveries'] > 0 ? number_format(($data['completed_deliveries'] /
                                    $data['total_deliveries'] * 100), 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    </td>
                    <td style="width: 33.33%; vertical-align: top; padding: 10px; border: none;">
                        <div class="summary-card" style="display: block; margin: 0;">
                            <h3>Materials Summary</h3>
                            <div class="stat-item">
                                <span class="stat-label">Low Stock Items:</span>
                                <span class="stat-value warning">{{ $data['low_stock_materials'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Out of Stock:</span>
                                <span class="stat-value danger">{{ $data['out_of_stock_materials'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Action Required:</span>
                                <span
                                    class="stat-value {{ ($data['low_stock_materials'] + $data['out_of_stock_materials']) > 0 ? 'danger' : 'success' }}">
                                    {{ ($data['low_stock_materials'] + $data['out_of_stock_materials']) > 0 ? 'Yes' :
                                    'No' }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td style="width: 33.33%; vertical-align: top; padding: 10px; border: none;">
                        <div class="summary-card" style="display: block; margin: 0;">
                            <h3>Team Summary</h3>
                            <div class="stat-item">
                                <span class="stat-label">Total Clinics:</span>
                                <span class="stat-value">{{ $data['total_clinics'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Total Technicians:</span>
                                <span class="stat-value">{{ $data['total_technicians'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Total Riders:</span>
                                <span class="stat-value">{{ $data['total_riders'] }}</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        @elseif($reportType === 'case-orders')
        <div class="section">
            <div class="summary-card mb-4">
                <h3>Case Orders Summary</h3>
                <div class="stat-item">
                    <span class="stat-label">Total Cases in Period:</span>
                    <span class="stat-value primary">{{ $data['total_cases'] }}</span>
                </div>
            </div>

            <h3 class="section-title">Case Orders Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Case No.</th>
                        <th>Clinic</th>
                        <th>Patient</th>
                        <th>Case Type</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['case_orders'] as $case)
                    <tr>
                        <td>CASE-{{ str_pad($case->co_id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $case->clinic->clinic_name }}</td>
                        <td>{{ $case->patient->name ?? 'N/A' }}</td>
                        <td>{{ $case->case_type }}</td>
                        <td>
                            <span class="badge badge-info">
                                {{ ucfirst(str_replace('-', ' ', $case->status)) }}
                            </span>
                        </td>
                        <td>{{ $case->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @elseif($reportType === 'revenue')
        <div class="section">
            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <td style="width: 33.33%; vertical-align: top; padding: 10px; border: none;">
                        <div class="summary-card" style="display: block; margin: 0;">
                            <h3>Total Revenue (Paid)</h3>
                            <div class="stat-item">
                                <span class="stat-value primary" style="font-size: 16px;">₱{{
                                    number_format($data['total_revenue'], 2) }}</span>
                            </div>
                        </div>
                    </td>
                    <td style="width: 33.33%; vertical-align: top; padding: 10px; border: none;">
                        <div class="summary-card" style="display: block; margin: 0;">
                            <h3>Pending Payment</h3>
                            <div class="stat-item">
                                <span class="stat-value warning" style="font-size: 16px;">₱{{
                                    number_format($data['pending_revenue'], 2) }}</span>
                            </div>
                        </div>
                    </td>
                    <td style="width: 33.33%; vertical-align: top; padding: 10px; border: none;">
                        <div class="summary-card" style="display: block; margin: 0;">
                            <h3>Partial Payment</h3>
                            <div class="stat-item">
                                <span class="stat-value" style="font-size: 16px;">₱{{
                                    number_format($data['partial_revenue'], 2) }}</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <h3 class="section-title">Billing Records</h3>
            <table>
                <thead>
                    <tr>
                        <th>Billing ID</th>
                        <th>Clinic</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['billings'] as $billing)
                    <tr>
                        <td>BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $billing->appointment->caseOrder->clinic->clinic_name }}</td>
                        <td class="font-bold">₱{{ number_format($billing->total_amount, 2) }}</td>
                        <td>
                            @if($billing->payment_status === 'paid')
                            <span class="badge badge-success">Paid</span>
                            @elseif($billing->payment_status === 'partial')
                            <span class="badge badge-warning">Partial</span>
                            @else
                            <span class="badge badge-danger">Unpaid</span>
                            @endif
                        </td>
                        <td>{{ $billing->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @elseif($reportType === 'materials')
        <div class="section">
            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <td style="width: 50%; vertical-align: top; padding: 10px; border: none;">
                        <div class="summary-card" style="display: block; margin: 0;">
                            <h3>Total Material Cost</h3>
                            <div class="stat-item">
                                <span class="stat-value primary" style="font-size: 16px;">₱{{
                                    number_format($data['total_material_cost'], 2) }}</span>
                            </div>
                        </div>
                    </td>
                    <td style="width: 50%; vertical-align: top; padding: 10px; border: none;">
                        <div class="summary-card" style="display: block; margin: 0;">
                            <h3>Low/Out of Stock Materials</h3>
                            <div class="stat-item">
                                <span class="stat-value danger" style="font-size: 16px;">{{
                                    $data['low_stock_materials']->count() }}</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <h3 class="section-title">Material Usage</h3>
            <table>
                <thead>
                    <tr>
                        <th>Material Name</th>
                        <th>Total Used</th>
                        <th>Unit</th>
                        <th>Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['material_usages'] as $usage)
                    <tr>
                        <td>{{ $usage->material_name }}</td>
                        <td class="text-center">{{ $usage->total_used }}</td>
                        <td>{{ $usage->unit }}</td>
                        <td class="font-bold">₱{{ number_format($usage->total_cost, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @elseif($reportType === 'clinic-performance')
        <div class="section">
            <h3 class="section-title">Clinic Performance Rankings</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%;">Rank</th>
                        <th>Clinic Name</th>
                        <th>Total Orders</th>
                        <th>Completed</th>
                        <th>Completion Rate</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['clinic_stats'] as $index => $clinic)
                    <tr>
                        <td class="text-center font-bold">{{ $index + 1 }}</td>
                        <td>{{ $clinic->clinic_name }}</td>
                        <td class="text-center">{{ $clinic->total_orders }}</td>
                        <td class="text-center">{{ $clinic->completed_orders }}</td>
                        <td class="text-center">
                            <span
                                class="badge {{ $clinic->total_orders > 0 && ($clinic->completed_orders / $clinic->total_orders * 100) >= 80 ? 'badge-success' : 'badge-warning' }}">
                                {{ $clinic->total_orders > 0 ? number_format(($clinic->completed_orders /
                                $clinic->total_orders * 100), 1) : 0 }}%
                            </span>
                        </td>
                        <td class="font-bold">₱{{ number_format($clinic->total_revenue, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @elseif($reportType === 'technician-performance')
        <div class="section">
            <h3 class="section-title">Technician Performance Rankings</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%;">Rank</th>
                        <th>Technician Name</th>
                        <th>Total Appointments</th>
                        <th>Completed</th>
                        <th>Completion Rate</th>
                        <th>Materials Used</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['technician_stats'] as $index => $technician)
                    <tr>
                        <td class="text-center font-bold">{{ $index + 1 }}</td>
                        <td>{{ $technician->name }}</td>
                        <td class="text-center">{{ $technician->total_appointments }}</td>
                        <td class="text-center">{{ $technician->completed_appointments }}</td>
                        <td class="text-center">
                            <span
                                class="badge {{ $technician->total_appointments > 0 && ($technician->completed_appointments / $technician->total_appointments * 100) >= 80 ? 'badge-success' : 'badge-warning' }}">
                                {{ $technician->total_appointments > 0 ?
                                number_format(($technician->completed_appointments / $technician->total_appointments *
                                100), 1) : 0 }}%
                            </span>
                        </td>
                        <td class="text-center">{{ $technician->materials_used }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @elseif($reportType === 'delivery-performance')
        <div class="section">
            <h3 class="section-title">Rider Performance Rankings</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%;">Rank</th>
                        <th>Rider Name</th>
                        <th>Total Deliveries</th>
                        <th>Completed</th>
                        <th>Total Pickups</th>
                        <th>Completed Pickups</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['rider_stats'] as $index => $rider)
                    <tr>
                        <td class="text-center font-bold">{{ $index + 1 }}</td>
                        <td>{{ $rider->name }}</td>
                        <td class="text-center">{{ $rider->total_deliveries }}</td>
                        <td class="text-center">
                            <span class="badge badge-success">{{ $rider->completed_deliveries }}</span>
                        </td>
                        <td class="text-center">{{ $rider->total_pickups }}</td>
                        <td class="text-center">
                            <span class="badge badge-success">{{ $rider->completed_pickups }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Report Footer -->
        <div class="report-footer">
            <p>This is an official report generated by {{ config('app.name', 'Jeffrey Dental Lab') }}</p>
            <p>For inquiries, please contact the administration office.</p>
        </div>
    </div>
</body>

</html>