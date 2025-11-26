<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\CaseOrder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Dentist;

class ClinicController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $clinic = Auth::guard('clinic')->user();

        // Get statistics
        $totalCaseOrders = CaseOrder::where('clinic_id', $clinic->clinic_id)->count();
        $completedCases = CaseOrder::where('clinic_id', $clinic->clinic_id)
            ->where('status', 'completed')
            ->count();
        $pendingCases = CaseOrder::where('clinic_id', $clinic->clinic_id)
            ->whereIn('status', ['initial', 'in-progress'])
            ->count();

        // Recent appointments
        $recentAppointments = Appointment::whereHas('caseOrder', function ($query) use ($clinic) {
            $query->where('clinic_id', $clinic->clinic_id);
        })
            ->with(['caseOrder.patient', 'technician'])
            ->latest('estimated_date')
            ->take(5)
            ->get();

        // Total patients and dentists
        $totalPatients = Patient::where('clinic_id', $clinic->clinic_id)->count();
        $totalDentists = Dentist::where('clinic_id', $clinic->clinic_id)->count();

        return view('clinic.dashboard', compact(
            'totalCaseOrders',
            'completedCases',
            'pendingCases',
            'recentAppointments',
            'totalPatients',
            'totalDentists'
        ));
    }

    // Settings
    public function settings()
    {
        $clinic = Auth::guard('clinic')->user();
        return view('clinic.clinic_settings.index', compact('clinic'));
    }

    // Update Settings
    public function updateSettings(Request $request)
    {
        $clinic = Auth::guard('clinic')->user();

        // Validate with the form field names
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prepare data for update
        $updateData = [];

        // Map clinic_name
        if (isset($validated['clinic_name'])) {
            $updateData['clinic_name'] = $validated['clinic_name'];
        }

        // Map phone to contact_number
        if (isset($validated['phone'])) {
            $updateData['contact_number'] = $validated['phone'];
        }

        // Map address
        if (isset($validated['address'])) {
            $updateData['address'] = $validated['address'];
        }

        // Handle password update
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($clinic->profile_photo && Storage::disk('public')->exists($clinic->profile_photo)) {
                Storage::disk('public')->delete($clinic->profile_photo);
            }

            // Store new photo
            $path = $request->file('photo')->store('clinic_photos', 'public');
            $updateData['profile_photo'] = $path;
        }

        // Update the clinic
        $clinic->update($updateData);

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
