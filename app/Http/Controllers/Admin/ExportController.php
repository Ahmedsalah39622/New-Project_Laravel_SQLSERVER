<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Response;

class ExportController extends Controller
{
    /**
     * Export users as CSV.
     */
    public function exportUsers(): Response
    {
        $users = User::all(['id', 'name', 'email', 'created_at']);

        $csvData = "ID,Name,Email,Created At\n";
        foreach ($users as $user) {
            $csvData .= "$user->id,$user->name,$user->email,$user->created_at\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="users.csv"');
    }

    /**
     * Export appointments as CSV.
     */
    public function exportAppointments(): Response
    {
        $appointments = Appointment::all(['id', 'user_id', 'date', 'status']);

        $csvData = "ID,User ID,Date,Status\n";
        foreach ($appointments as $appointment) {
            $csvData .= "$appointment->id,$appointment->user_id,$appointment->date,$appointment->status\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="appointments.csv"');
    }
}
