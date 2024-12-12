<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class MaintainanceController extends Controller
{
    public function runMigrate()
    {
        // Log the action
        Log::info('Run Migrate: Starting migration process.');

        // Run Laravel migrations
        Artisan::call('migrate');

        // Log the result
        Log::info('Run Migrate: Migration process completed successfully.');

        return redirect()->back()->with('success', 'Migrations executed successfully.');
    }

    public function cacheClear()
    {
        // Log the action
        Log::info('Cache Clear: Clearing application cache.');

        // Clear Laravel cache
        Artisan::call('cache:clear');

        // Log the result
        Log::info('Cache Clear: Cache cleared successfully.');

        return redirect()->back()->with('success', 'Cache cleared successfully.');
    }

    public function composerInstall()
    {
        try {
            // Log the action
            Log::info('Composer Install: Starting Composer dependency installation.');

            // Set the working directory to the Laravel root
            $projectRoot = base_path();

            // Run the composer install command using exec
            $output = [];
            $returnVar = 0;
            exec("cd $projectRoot && composer install", $output, $returnVar);

            // Check the result of the command
            if ($returnVar !== 0) {
                // Log the error output
                Log::error('Composer Install: Failed to install dependencies.', ['output' => $output, 'returnVar' => $returnVar]);

                return redirect()->back()->with('error', 'Failed to install Composer dependencies.');
            }

            // Log the success output
            Log::info('Composer Install: Composer dependencies installed successfully.', ['output' => $output]);

            return redirect()->back()->with('success', 'Composer dependencies installed successfully.');
        } catch (\Exception $exception) {
            // Catch and log any unexpected errors
            Log::error('Composer Install: Unexpected error - ' . $exception->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred.');
        }
    }
}
