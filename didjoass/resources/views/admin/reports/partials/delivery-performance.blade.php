<div class="space-y-6">
   
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Delivery and Pickup Reports</h3>
    
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @php
    $totalDeliveries = $data['rider_stats']->sum('total_deliveries');
    $completedDeliveries = $data['rider_stats']->sum('completed_deliveries');
    $totalPickups = $data['rider_stats']->sum('total_pickups');
    @endphp

    <div class="bg-white rounded-lg shadow-md p-6 transform transition duration-300 hover:-translate-y-2 hover:shadow-xl">
        <h3 class="text-sm text-gray-500">Total Deliveries</h3>
        <p class="text-3xl font-bold text-orange-600">{{ $totalDeliveries }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 transform transition duration-300 hover:-translate-y-2 hover:shadow-xl">
        <h3 class="text-sm text-gray-500">Completed Deliveries</h3>
        <p class="text-3xl font-bold text-green-600">{{ $completedDeliveries }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 transform transition duration-300 hover:-translate-y-2 hover:shadow-xl">
        <h3 class="text-sm text-gray-500">Total Pickups</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $totalPickups }}</p>
    </div>
</div>


    @if(!empty($data['delivery_status_breakdown']))
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Delivery Status Breakdown</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($data['delivery_status_breakdown'] as $status => $count)
            <div class="border rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500 mb-1">{{ ucfirst(str_replace('_', ' ', $status)) }}</p>
                <p class="text-2xl font-bold
                    {{ $status === 'delivered' ? 'text-green-600' : 
                       ($status === 'in transit' ? 'text-blue-600' : 'text-yellow-600') }}">
                    {{ $count }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Rider Performance</h3>
       <div class="overflow-x-auto rounded-xl shadow-lg transform transition duration-300 hover:-translate-y-2 hover:shadow-2xl">
    <table class="min-w-full">
        <thead class="bg-blue-900">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Rider Name</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Total Deliveries</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Completed</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Completion Rate</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Total Pickups</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Completed Pickups</th>
            </tr>
        </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($data['rider_stats'] as $index => $rider)
                    <tr class="{{ $index < 3 ? 'bg-orange-50' : '' }}">
                      
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $rider->photo ? asset('storage/' . $rider->photo) : asset('images/default-avatar.png') }}"
                                    alt="{{ $rider->name }}" class="w-8 h-8 rounded-full object-cover border">
                                <span class="text-sm font-medium text-gray-800">{{ $rider->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-orange-600">{{ $rider->total_deliveries }}</td>
                        <td class="px-4 py-3 text-sm font-bold text-green-600">{{ $rider->completed_deliveries }}</td>
                        <td class="px-4 py-3 text-sm">
                            @php
                            $rate = $rider->total_deliveries > 0 ? ($rider->completed_deliveries /
                            $rider->total_deliveries * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $rate }}%"></div>
                                </div>
                                <span class="font-semibold text-gray-700">{{ number_format($rate, 1) }}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-blue-600">{{ $rider->total_pickups }}</td>
                        <td class="px-4 py-3 text-sm font-bold text-purple-600">{{ $rider->completed_pickups }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">No rider data for this period</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>