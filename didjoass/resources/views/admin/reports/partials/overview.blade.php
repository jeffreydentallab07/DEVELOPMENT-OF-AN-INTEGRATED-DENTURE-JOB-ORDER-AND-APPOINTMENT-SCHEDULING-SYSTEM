<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white rounded-lg shadow p-0 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
        <div class="p-4 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-t-lg">
            <h3 class="text-lg font-bold">Case Orders</h3>
        </div>
        <div class="p-6 space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Cases</span>
                <span class="font-bold text-blue-600">{{ $data['total_case_orders'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Completed</span>
                <span class="font-bold text-green-600">{{ $data['completed_cases'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Pending</span>
                <span class="font-bold text-yellow-600">{{ $data['pending_cases'] }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-0 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
        <div class="p-4 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-t-lg">
            <h3 class="text-lg font-bold">Appointments</h3>
        </div>
        <div class="p-6 space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Appointments</span>
                <span class="font-bold text-blue-600">{{ $data['total_appointments'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Completed</span>
                <span class="font-bold text-green-600">{{ $data['completed_appointments'] }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-0 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
        <div class="p-4 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-t-lg">
            <h3 class="text-lg font-bold">Revenue</h3>
        </div>
        <div class="p-6 space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Revenue</span>
                <span class="font-bold text-green-600">₱{{ number_format($data['total_revenue'], 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Pending</span>
                <span class="font-bold text-yellow-600">₱{{ number_format($data['pending_revenue'], 2) }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-0 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
        <div class="p-4 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-t-lg">
            <h3 class="text-lg font-bold">Deliveries</h3>
        </div>
        <div class="p-6 space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Deliveries</span>
                <span class="font-bold text-blue-600">{{ $data['total_deliveries'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Completed</span>
                <span class="font-bold text-green-600">{{ $data['completed_deliveries'] }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-0 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
         <div class="p-4 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-t-lg">
            <h3 class="text-lg font-bold">Staff & Clinics</h3>
        </div>
        <div class="p-6 space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Clinics</span>
                <span class="font-bold text-blue-600">{{ $data['total_clinics'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Technicians</span>
                <span class="font-bold text-purple-600">{{ $data['total_technicians'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Riders</span>
                <span class="font-bold text-orange-600">{{ $data['total_riders'] }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-0 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl">
        <div class="p-4 bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-t-lg">
            <h3 class="text-lg font-bold">Inventory Status</h3>
        </div>
        <div class="p-6 space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Low Stock</span>
                <span class="font-bold text-orange-600">{{ $data['low_stock_materials'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Out of Stock</span>
                <span class="font-bold text-red-600">{{ $data['out_of_stock_materials'] }}</span>
            </div>
        </div>
    </div>

</div>
