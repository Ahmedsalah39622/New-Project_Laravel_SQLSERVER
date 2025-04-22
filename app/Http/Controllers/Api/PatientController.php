namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function getPatientStatistics()
    {
        // Fetch patient count grouped by month
        $patientsByMonth = Patient::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format data for the chart
        $data = [
            'months' => $patientsByMonth->pluck('month')->map(function ($month) {
                return date('M', mktime(0, 0, 0, $month, 1)); // Convert month number to name
            }),
            'counts' => $patientsByMonth->pluck('count')
        ];

        return response()->json($data);
    }

    public function getNewPatients(): JsonResponse
    {
        try {
            // Get the current month
            $currentMonth = Carbon::now()->month;

            // Count the number of patients registered in the current month
            $newPatientsCount = Patient::whereMonth('created_at', $currentMonth)->count();

            return response()->json(['newPatients' => $newPatientsCount], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch new patients count'], 500);
        }
    }
}
