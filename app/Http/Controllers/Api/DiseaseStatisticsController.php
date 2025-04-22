namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DiseaseStatisticsController extends Controller
{
    public function getTopDiseases()
    {
        // Get all column names from the disease_statistics table
        $columns = DB::getSchemaBuilder()->getColumnListing('disease_statistics');

        // Exclude only non-disease columns like id, ds, created_at, and updated_at
        $diseaseColumns = collect($columns)->filter(function ($column) {
            return !in_array($column, ['id', 'ds', 'created_at', 'updated_at']);
        });

        // Dynamically sum the cases for each disease
        $diseaseTotals = DB::table('disease_statistics')
            ->selectRaw(implode(', ', $diseaseColumns->map(fn($col) => "SUM($col) as $col")->toArray()))
            ->first();

        // Convert the totals to an array and sort them
        $diseaseTotalsArray = collect((array) $diseaseTotals)->sortDesc();

        // Get the top 3 diseases
        $topDiseases = $diseaseTotalsArray->take(3);

        // Return the data as JSON
        return response()->json([
            'top_diseases' => $topDiseases
        ]);
    }

    public function getAllDiseases()
    {
        // Get all column names from the disease_statistics table
        $columns = DB::getSchemaBuilder()->getColumnListing('disease_statistics');

        // Exclude non-disease columns
        $diseaseColumns = collect($columns)->filter(function ($column) {
            return !in_array($column, ['id', 'ds', 'created_at', 'updated_at']);
        });

        // Dynamically sum the cases for each disease
        $diseaseTotals = DB::table('disease_statistics')
            ->selectRaw(implode(', ', $diseaseColumns->map(fn($col) => "SUM($col) as $col")->toArray()))
            ->first();

        // Convert the totals to an array
        $diseaseTotalsArray = (array) $diseaseTotals;

        // Return the data as JSON
        return response()->json([
            'diseases' => $diseaseTotalsArray
        ]);
    }
}
