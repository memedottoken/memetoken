<?php

namespace App\Install\Controllers;

use App\Install\Helpers\EnvHelper;
use App\Install\Middleware\InstallMiddleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Str;

class InstallController extends Controller
{
    protected $envHelper;

    public function __construct(EnvHelper $envHelper)
    {
        $this->envHelper = $envHelper;
    }

    public function index(): Response
    {
        return Inertia::render('Install/Steps/Welcome');
    }

    public function requirements(): Response
    {
        $requirements = $this->checkRequirements();
        return Inertia::render('Install/Steps/Requirements', [
            'requirements' => $requirements,
            'meets_requirements' => !in_array(false, $requirements, true)
        ]);
    }

    public function permissions(): Response
    {
        $permissions = $this->checkPermissions();
        return Inertia::render('Install/Steps/Permissions', [
            'permissions' => $permissions,
            'meets_permissions' => !in_array(false, $permissions, true)
        ]);
    }

    public function environment(): Response
    {
        $currentEnv = [
            'APP_URL' => $this->envHelper->getEnv('APP_URL'),
            'COINCAP_APIKEY' => $this->envHelper->getEnv('COINCAP_APIKEY'),
            'PROJECT_ID' => $this->envHelper->getEnv('PROJECT_ID'),
            'ANKR_KEY' => $this->envHelper->getEnv('ANKR_KEY'),
            'ADMIN' => $this->envHelper->getEnv('ADMIN'),
            //database
            'DB_HOST' => $this->envHelper->getEnv('DB_HOST'),
            'DB_PORT' => $this->envHelper->getEnv('DB_PORT'),
            'DB_DATABASE' => $this->envHelper->getEnv('DB_DATABASE'),
            'DB_USERNAME' => $this->envHelper->getEnv('DB_USERNAME'),
            'DB_PASSWORD' => $this->envHelper->getEnv('DB_PASSWORD'),
        ];
        return Inertia::render('Install/Steps/Environment', [
            'installed' => Storage::disk('public')->exists('installed'),
            'current' => $currentEnv
        ]);
    }

    public function saveEnvironment(Request $request)
    {
        $validated = $request->validate([
            'APP_URL' => 'required|url',
            'COINCAP_APIKEY' => 'required|string',
            'PROJECT_ID' => 'required|string',
            'ANKR_KEY' => 'required|string',
            'ADMIN' => 'required|string',
            // Database validation
            'DB_HOST' => 'required_unless:DB_CONNECTION,sqlite',
            'DB_PORT' => 'required_unless:DB_CONNECTION,sqlite',
            'DB_DATABASE' => 'required',
            'DB_USERNAME' => 'required_unless:DB_CONNECTION,sqlite',
            'DB_PASSWORD' => 'nullable',
        ]);
        try {
            $this->migrateAndSeed($validated);
        } catch (\Exception $e) {
            return back()->with('error', 'Database setup failed: ' . $e->getMessage());
        }
        // Test database connection
        $success = $this->envHelper->updateMultipleEnv($validated);
        if ($success) {
            // Mark as installed
            if (!InstallMiddleware::markAsInstalled()) {
                return back()->with('error', 'Failed to mark application as installed.');
            }
            return redirect()->route('install.final');
        }
        return back()->with('error', 'Failed to update environment variables.');
    }



    public function final(): Response
    {
        Artisan::call('config:clear');
        return Inertia::render('Install/Steps/Final');
    }

    public function complete()
    {

        return redirect('/');
    }

    protected function migrateAndSeed($config)
    {
        config(
            [
                'database.connections.mysql' =>
                [
                    'driver'    => 'mysql',
                    'host'      => $config['DB_HOST'],
                    'port'      => $config['DB_PORT'],
                    'database'  =>  $config['DB_DATABASE'],
                    'username'  => $config['DB_USERNAME'],
                    'password'  => $config['DB_PASSWORD'],
                    'charset'   => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                ],
            ]
        );
        try {
            DB::connection('mysql')->getPDO();
        } catch (\Exception $e) {
            return redirect()->route('install.environment')->with('error', 'Invalid DB credentials');
        }
        try {
            // Disable foreign key checks before migrations
            DB::connection('mysql')->statement('SET FOREIGN_KEY_CHECKS=0;');
            // Run migrations
            Artisan::call('migrate', ['--force' => true, '--database' => 'mysql']);
            $migrationOutput = Artisan::output();
            // Run seeders
            Artisan::call('db:seed', ['--force' => true]);
            $seederOutput = Artisan::output();
            // Re-enable foreign key checks
            DB::connection('mysql')->statement('SET FOREIGN_KEY_CHECKS=1;');
            // Check for any error messages in the output
            if (Str::contains($migrationOutput, 'error') || Str::contains($seederOutput, 'error')) {
                throw new \Exception("Error during migration or seeding process.");
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    protected function checkRequirements(): array
    {
        return [
            'PHP Version (>= 8.2)' => version_compare(PHP_VERSION, '8.2.0', '>='),
            'BCMath Extension' => extension_loaded('bcmath'),
            'Ctype Extension' => extension_loaded('ctype'),
            'JSON Extension' => extension_loaded('json'),
            'Mbstring Extension' => extension_loaded('mbstring'),
            'OpenSSL Extension' => extension_loaded('openssl'),
            'PDO Extension' => extension_loaded('pdo'),
            'Tokenizer Extension' => extension_loaded('tokenizer'),
            'XML Extension' => extension_loaded('xml'),
        ];
    }



    protected function checkPermissions(): array
    {
        return [
            'storage/app' => is_writable(storage_path('app')),
            'storage/framework' => is_writable(storage_path('framework')),
            'storage/logs' => is_writable(storage_path('logs')),
            'bootstrap/cache' => is_writable(base_path('bootstrap/cache')),
            '.env' => is_writable(base_path('.env')),
        ];
    }
}
