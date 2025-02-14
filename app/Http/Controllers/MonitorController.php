<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Metadata;
use App\Models\Metric;
use App\Models\Alert;

class MonitorController extends Controller
{
    public function getMetrics()
    {
        $cpuUsage = (float)$this->getCpuUsage(); // Get CPU load
        $memoryUsage = (float)memory_get_usage(true) / 1024 / 1024;
        $diskUsage = (float)disk_free_space("/") / disk_total_space("/") * 100;

        Log::info("Metrics - CPU: $cpuUsage, Memory: $memoryUsage MB, Disk: $diskUsage%");

        DB::table('metrics')->insert([
            'cpu_usage' => round($cpuUsage, 2),
            'memory_usage' => round($memoryUsage, 2),
            'disk_usage' => round($diskUsage, 2),
            'created_at' => now(),
        ]);

        if ($cpuUsage > 80) {
            DB::table('alerts')->insert([
                'metric' => 'CPU',
                'value' => round($cpuUsage, 2),
                'threshold' => '80%',
                'status' => 'active',
                'created_at' => now()
            ]);
        }
        
        if ($diskUsage < 10) {
            DB::table('alerts')->insert([
                'metric' => 'Disk',
                'value' => round($diskUsage, 2),
                'threshold' => '10%',
                'status' => 'active',
                'created_at' => now()
            ]);
        }
        
        return response()->json([
            'cpu' => round($cpuUsage, 2).'%',
            'memory' => round($memoryUsage, 2).'MB',
            'disk' => round($diskUsage, 2).'% Used',
            'timestamp' => now()
        ]);
    }

    public function setMetadata(Request $request)
    {
        $validated = $request->validate([
            'server_name' => 'required|string',
            'environment' => 'required|string',
            'location' => 'required|string'
        ]);

        #DB::table('metadata')->insert($validated);
        $metadata = Metadata::create([
            'server_name' => $request->server_name,
            'environment' => $request->environment,
            'location' => $request->location,
        ]);
        return response()->json(['message' => 'Metadata saved', 'data' => $metadata], 201);
    }

    public function getMetadata()
    {
        return response()->json(DB::table('metadata')->get());
    }

    public function getAlerts()
    {
        return response()->json(DB::table('alerts')->where('status', 'active')->get());
    }
    
    public function getAllMetrics()
    {
        $metrics = DB::table('metrics')->orderBy('created_at', 'desc')->limit(10)->get();
        return response()->json($metrics);
    }
    private function getCpuUsage()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows-specific CPU usage
            $cmd = 'wmic cpu get LoadPercentage';
            @exec($cmd, $output);
            if (isset($output[1])) {
                return (float)trim($output[1]) ;
            }
        } else {
            // Linux/macOS (Use `sys_getloadavg()`)
            $load = sys_getloadavg();
            return (float)$load[0] ;
        }

        return 0.0;
    }

}
