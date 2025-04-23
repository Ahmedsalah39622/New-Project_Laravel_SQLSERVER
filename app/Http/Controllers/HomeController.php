public function index()
{
    // Get upcoming appointments (next 2 appointments)
    $upcomingAppointments = Appointment::where('appointment_date', '>=', now())
        ->where('status', '!=', 'cancelled')
        ->orderBy('appointment_date')
        ->orderBy('start_time')
        ->take(2)
        ->get();

    return view('content.pages.pages-home', compact('upcomingAppointments'));
}
