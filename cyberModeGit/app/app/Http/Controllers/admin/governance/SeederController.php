<?php

namespace App\Http\Controllers\admin\governance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeederController extends Controller
{
    protected $frameworks = [
        'NCA-ECC – 1: 2018',
        'NCA-SMACC',
        // 'NCA-CCC – 1: 2020',
        'NCACCC_P',
        'NCACCC_T',
        'NCA-TCC',
        'NCA-CSCC – 1: 2019',
        'NCA-OTCC-1:2022',
        'NCA-DCC-1:2022',
        'SAMA',
        'ISO-27001',
        'Cma',
        
    ];

    public function index()
    {
        $regulators = DB::table('regulators')->pluck('name', 'id')->toArray();
        $seededFrameworks = DB::table('seeded_frameworks')->get();
        $frameworks = array_diff($this->frameworks, $seededFrameworks->pluck('framework')->toArray());

        $breadcrumbs = [
            ['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
            ['name' => __('locale.Regulators')],
            ['link' => route('admin.governance.regulator.index'), 'name' => __('locale.Frameworks')],
            ['name' => __('locale.InstallFramework')],
        ];

        return view('admin.content.configure.framework_seede.index', [
            'frameworks' => $frameworks,
            'breadcrumbs' => $breadcrumbs,
            'seededFrameworks' => $seededFrameworks,
            'regulators' => $regulators,

        ]);
    }


    public function runSeeder(Request $request)
    {
        $request->validate([
            'framework' => 'required|string'
        ]);
    
        $regulation = $request->input('regulation');
        $framework = $request->input('framework');
        $options = $request->input('options', '[]');
        
        // Check if a regulator with the given name already exists
        $regulator = DB::table('regulators')->where('name', $regulation)->first();
    
        if ($regulator) {
            // Regulator exists, get the ID
            $regulatorId = $regulator->id;
        } else {
            // Regulator does not exist, create a new one
            $regulatorId = DB::table('regulators')->insertGetId([
                'name' => $regulation,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    
        // Decode the JSON-encoded options
        $options = json_decode($options, true);
    
    
        // Ensure $options is an array
        if (!is_array($options)) {
            return response()->json([
                'message' => __('locale.An error occurred while running the seeder.'),
                'error' => __('locale.Decoded options is not an array.')
            ], 500);
        }
    
        // Convert framework name to seeder class name
        $seederClass = 'Database\\Seeders\\' . $this->frameworkNameToSeederClass($framework) . 'Seeder';

        try {
            if (!class_exists($seederClass)) {
                throw new \Exception(__('locale.Seeder class does not exist:') . ' ' . $seederClass);
            }
            
            // Set environment variables
            putenv('SEEDER_OPTIONS=' . json_encode($options));
            putenv('SEEDER_REGULATION=' . $regulatorId);
            
            // Run the seeder
            Artisan::call('db:seed', [
                '--class' => $seederClass,
                '--force' => true,
            ]);
    
            // Log the seeded framework
            DB::table('seeded_frameworks')->insert([
                'framework' => $framework,
                'mapping' => in_array('install_mapping', $options),
                'document' => in_array('install_document', $options),
                'requirement' => in_array('install_requirement', $options),
                'created_at' => now(),
            ]);
    
            return response()->json([
                'message' => __('locale.:framework seeder has been executed successfully.', ['framework' => $framework])
            ]);
        } catch (\Exception $e) {
            // Log the detailed error message including file and line number
            
            return response()->json([
                'message' => __('locale.An error occurred while running the seeder.'),
                'error' => $e->getMessage() . ' ' . __('locale.in file') . ' ' . $e->getFile() . ' ' . __('locale.on line') . ' ' . $e->getLine()
            ], 500);
        }
    }
    







    protected function frameworkNameToSeederClass($frameworkName)
    {
        // Sanitize framework name to match the seeder class name
        return str_replace(
            [' ', '–', ':'], // Characters to be replaced
            ['_', '_', '_'], // Replacement characters
            Str::studly($frameworkName) // Convert to StudlyCaps
        );
    }
}
