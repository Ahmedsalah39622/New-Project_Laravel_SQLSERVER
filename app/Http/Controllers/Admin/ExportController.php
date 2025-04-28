<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    /**
     * Export users as CSV.
     */
    public function exportUsersCsv(): Response
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
     * Export users as Excel.
     */
    public function exportUsersExcel()
    {
        // Logic for exporting users as Excel
        // You can use a package like Maatwebsite Excel for this
        return response()->json(['message' => 'Excel export not implemented yet.']);
    }

    /**
     * Export users as PDF.
     */
    public function exportUsersPdf()
    {
        $users = User::all(['id', 'name', 'email', 'created_at']);
        $pdf = Pdf::loadView('admin.exports.users-pdf', compact('users'));

        return $pdf->download('users.pdf');
    }

    /**
     * Export users for Print.
     */
    public function exportUsersPrint()
    {
        $users = User::all(['id', 'name', 'email', 'created_at']);
        return view('admin.exports.users-print', compact('users'));
    }

    /**
     * Export users as Copy (JSON format).
     */
    public function exportUsersCopy(): Response
    {
        $users = User::all(['id', 'name', 'email', 'created_at']);
        return response()->json($users);
    }
}
