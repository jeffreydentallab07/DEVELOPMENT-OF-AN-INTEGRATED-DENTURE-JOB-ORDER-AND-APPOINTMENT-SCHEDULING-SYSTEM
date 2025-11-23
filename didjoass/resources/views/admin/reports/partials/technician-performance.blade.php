<div class="space-y-6">
  

      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Technicians</h3>
       <div class="overflow-x-auto rounded-xl shadow-lg">
    <table class="min-w-full">
        <thead class="bg-blue-900">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Technician Name</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Total Appointments</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Completed</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Completion Rate</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Materials Used</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">Material Cost</th>
            </tr>
        </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($data['technician_stats'] as $index => $technician)
                    <tr class="{{ $index < 3 ? 'bg-blue-50' : '' }}">
                        
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $technician->photo ? asset('storage/' . $technician->photo) : asset('images/default-avatar.png') }}"
                                    alt="{{ $technician->name }}" class="w-8 h-8 rounded-full object-cover border">
                                <span class="text-sm font-medium text-gray-800">{{ $technician->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-blue-600">{{ $technician->total_appointments }}</td>
                        <td class="px-4 py-3 text-sm font-bold text-green-600">{{ $technician->completed_appointments }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @php
                            $rate = $technician->total_appointments > 0 ? ($technician->completed_appointments /
                            $technician->total_appointments * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $rate }}%"></div>
                                </div>
                                <span class="font-semibold text-gray-700">{{ number_format($rate, 1) }}%</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-purple-600">{{ $technician->materials_used }}</td>
                        <td class="px-4 py-3 text-sm font-bold text-orange-600">₱{{
                            number_format($technician->total_material_cost, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">No technician data for this period
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

   
</div>