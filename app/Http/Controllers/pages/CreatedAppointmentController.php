<?php

namespace App\Http\Controllers\pages;

use App\Models\CreatedAppointment;
use Illuminate\Http\Request;

class CreatedAppointmentController extends Controller
{
    // 📌 عرض جميع المواعيد
    public function index()
    {
        $appointments = CreatedAppointment::with('doctor')->get();
        return response()->json($appointments);
    }

    // 📌 إضافة موعد جديد
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time' => 'required|string',
            'is_available' => 'boolean'
        ]);

        $appointment = CreatedAppointment::create($request->all());

        return response()->json(['message' => 'Appointment created successfully', 'appointment' => $appointment], 201);
    }

    // 📌 عرض موعد معين حسب ID
    public function show($id)
    {
        $appointment = CreatedAppointment::with('doctor')->find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        return response()->json($appointment);
    }

    // 📌 تحديث موعد معين
    public function update(Request $request, $id)
    {
        $appointment = CreatedAppointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $request->validate([
            'doctor_id' => 'exists:doctors,id',
            'date' => 'date',
            'time' => 'string',
            'is_available' => 'boolean'
        ]);

        $appointment->update($request->all());

        return response()->json(['message' => 'Appointment updated successfully', 'appointment' => $appointment]);
    }

    // 📌 حذف موعد معين
    public function destroy($id)
    {
        $appointment = CreatedAppointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }

    // 📌 تغيير حالة توفر الموعد
    public function toggleAvailability($id)
    {
        $appointment = CreatedAppointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->is_available = !$appointment->is_available;
        $appointment->save();

        return response()->json(['message' => 'Availability status updated', 'is_available' => $appointment->is_available]);
    }
}
