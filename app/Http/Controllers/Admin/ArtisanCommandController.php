<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class ArtisanCommandController extends Controller
{
    /**
     * Run ANY artisan command (NO RESTRICTIONS - DEV ONLY!)
     */
    public function run(Request $request)
    {
        $command = $request->input('command');
        
        if (!$command) {
            return response()->json([
                'success' => false,
                'message' => 'No command provided'
            ], 400);
        }
        
        try {
            // Parse command and arguments
            $parts = explode(' ', $command);
            $cmd = $parts[0];
            $params = [];
            
            // Parse arguments like --seed, --force, etc.
            for ($i = 1; $i < count($parts); $i++) {
                $arg = $parts[$i];
                if (str_starts_with($arg, '--')) {
                    // Handle --seed, --force, etc.
                    if (str_contains($arg, '=')) {
                        $paramParts = explode('=', $arg);
                        $params[$paramParts[0]] = $paramParts[1];
                    } else {
                        $params[$arg] = true;
                    }
                } else {
                    // Positional arguments
                    $params[] = $arg;
                }
            }
            
            // Create output buffer
            $output = new BufferedOutput();
            
            // Run the command
            $exitCode = Artisan::call($cmd, $params, $output);
            
            // Get output
            $commandOutput = $output->fetch();
            
            return response()->json([
                'success' => $exitCode === 0,
                'command' => $command,
                'exit_code' => $exitCode,
                'output' => $commandOutput ?: ($exitCode === 0 ? '✅ Command executed successfully!' : '❌ Command failed with exit code: ' . $exitCode),
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'command' => $command,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Simple HTML form
     */
    public function index()
    {
        return view('admin.artisan');
    }
}